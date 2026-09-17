<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuditItems13To18Test extends TestCase
{
    use RefreshDatabase;

    protected User $adminCms;
    protected NewsCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminCms = User::factory()->create([
            'name' => 'Admin CMS',
            'email' => 'cms@attamam.sch.id',
            'role' => 'admin_cms',
            'is_active' => true,
        ]);

        $this->category = NewsCategory::create([
            'name' => 'Prestasi Santri',
            'slug' => 'prestasi-santri',
        ]);
    }

    /**
     * Item 13: Form CMS Berita supports file upload with storage and URL string fallback
     */
    public function test_admin_can_upload_thumbnail_file_when_creating_news(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('kegiatan.jpg', 800, 600);

        $response = $this->actingAs($this->adminCms)->post(route('admin.news.store'), [
            'title' => 'Kegiatan Wisuda Akbar Tahfizh 2026',
            'category_id' => $this->category->id,
            'content' => '<p>Santri berprestasi telah menyelesaikan hafalan 30 Juz.</p>',
            'thumbnail_file' => $file,
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $news = News::where('title', 'Kegiatan Wisuda Akbar Tahfizh 2026')->first();
        $this->assertNotNull($news);
        $this->assertStringStartsWith('storage/news/', $news->thumbnail);

        $filePath = str_replace('storage/', '', $news->thumbnail);
        Storage::disk('public')->assertExists($filePath);
    }

    public function test_admin_can_replace_and_delete_uploaded_thumbnail_file_on_update(): void
    {
        Storage::fake('public');

        $oldFile = UploadedFile::fake()->image('old_photo.jpg');
        $oldPath = $oldFile->store('news', 'public');

        $news = News::create([
            'title' => 'Artikel Ujian Semester',
            'slug' => 'artikel-ujian-semester-123',
            'category_id' => $this->category->id,
            'author_id' => $this->adminCms->id,
            'content' => 'Isi materi ujian',
            'thumbnail' => 'storage/' . $oldPath,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        // Update dengan file baru
        $newFile = UploadedFile::fake()->image('new_photo.jpg');
        $response = $this->actingAs($this->adminCms)->post(route('admin.news.update', $news->id), [
            'title' => 'Artikel Ujian Semester Terupdate',
            'category_id' => $this->category->id,
            'content' => '<p>Isi materi ujian yang sudah direvisi.</p>',
            'thumbnail_file' => $newFile,
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $news->refresh();
        $this->assertNotEquals('storage/' . $oldPath, $news->thumbnail);
        Storage::disk('public')->assertMissing($oldPath);

        $newPath = str_replace('storage/', '', $news->thumbnail);
        Storage::disk('public')->assertExists($newPath);
    }

    public function test_news_create_and_edit_forms_render_quill_and_dropzone(): void
    {
        $responseCreate = $this->actingAs($this->adminCms)->get(route('admin.news.create'));
        $responseCreate->assertOk()
            ->assertSee('quillEditor')
            ->assertSee('dropzoneBox')
            ->assertSee('thumbnail_file')
            ->assertSee('enctype="multipart/form-data"', false);

        $news = News::create([
            'title' => 'Berita Pengujian Edit UI',
            'slug' => 'berita-pengujian-edit-ui',
            'category_id' => $this->category->id,
            'author_id' => $this->adminCms->id,
            'content' => '<p>Konten contoh</p>',
            'thumbnail' => 'images/sch1.jpeg',
        ]);

        $responseEdit = $this->actingAs($this->adminCms)->get(route('admin.news.edit', $news->id));
        $responseEdit->assertOk()
            ->assertSee('quillEditor')
            ->assertSee('dropzoneBox')
            ->assertSee('previewContainer')
            ->assertSee('btnRemoveThumb')
            ->assertSee('enctype="multipart/form-data"', false);
    }

    /**
     * Item 14: Breadcrumb Truncation has Title Tooltip
     */
    public function test_news_show_breadcrumb_has_title_tooltip(): void
    {
        $longTitle = 'Pemberitahuan Pelaksanaan Ujian Asesmen Nasional Berbasis Komputer Tahun 2026';
        $news = News::create([
            'title' => $longTitle,
            'slug' => 'pemberitahuan-anbk-2026',
            'category_id' => $this->category->id,
            'author_id' => $this->adminCms->id,
            'content' => '<p>Detail pelaksanaan asesmen.</p>',
            'published_at' => now()->subHour(),
        ]);

        $response = $this->get(route('news.show', $news->slug));
        $response->assertOk();
        $response->assertSee('title="' . $longTitle . '"', false);
    }

    /**
     * Item 15: Sisa String Nama Sekolah Lama di Console Log
     */
    public function test_welcome_page_has_updated_console_log_without_legacy_school(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk()
            ->assertSee("console.log('Website PKBM Tahfizh At-Tamam - Dimuat dengan sukses!');", false)
            ->assertDontSee('SMKN 1 Nusantara');
    }

    /**
     * Item 16: Halaman Error 403 (dan 404) Selaras dengan Branding
     */
    public function test_forbidden_error_page_has_branding_and_home_button(): void
    {
        // Akses route yang terproteksi role berbeda untuk memicu 403
        $response = $this->actingAs($this->adminCms)->get(route('admin.users.index'));
        $response->assertForbidden()
            ->assertSee('403')
            ->assertSee('Akses Ditolak!')
            ->assertSee('PKBM Tahfizh At-Tamam')
            ->assertSee('Kembali ke Beranda')
            ->assertSee(route('home'));
    }

    /**
     * Item 17: Path Background Gambar Hero Relatif di File CSS
     */
    public function test_css_uses_relative_path_for_hero_background(): void
    {
        $cssContent = file_get_contents(public_path('css/style.css'));
        $this->assertStringContainsString("url('../images/sch5.jpg')", $cssContent);
        $this->assertStringNotContainsString("url('/images/sch5.jpg')", $cssContent);
    }

    /**
     * Item 18: Alt Text Gambar Logo Mobile Terlalu Generik diperbaiki
     */
    public function test_navbar_mobile_logo_has_descriptive_alt_text(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk()
            ->assertSee('alt="Logo Resmi PKBM Tahfizh At-Tamam"', false);
    }
}
