<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\PpdbRegistration;
use App\Models\PpdbDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicAndSecurityEnhancementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_view_public_news_detail(): void
    {
        $author = User::factory()->create(['role' => 'admin_cms']);
        $category = NewsCategory::create(['name' => 'Akademik', 'slug' => 'akademik']);

        $news = News::create([
            'title' => 'Prestasi Santri Tahfizh Nasional 2026',
            'slug' => 'prestasi-santri-tahfizh-nasional-2026',
            'category_id' => $category->id,
            'author_id' => $author->id,
            'content' => 'Alhamdulillah santri PKBM Tahfizh At-Tamam meraih juara 1 dalam ajang tahfizh nasional.',
            'published_at' => now(),
        ]);

        $response = $this->get(route('news.show', $news->slug));

        $response->assertOk()
            ->assertSee('Prestasi Santri Tahfizh Nasional 2026')
            ->assertSee('Alhamdulillah santri PKBM Tahfizh At-Tamam');
    }

    public function test_homepage_hero_cta_points_to_ppdb_index(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee(route('ppdb.index'));
    }

    public function test_homepage_renders_expandable_tabs_navigation(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('id="react-main-nav"', false)
            ->assertSee('class="expandable-nav-tabs"', false)
            ->assertSee('Beranda')
            ->assertSee('Jenjang')
            ->assertSee('Cabang')
            ->assertSee('Berita')
            ->assertSee('PPDB Online');
    }


    public function test_guest_cannot_access_protected_ppdb_document(): void
    {
        $reg = PpdbRegistration::create([
            'no_pendaftaran' => 'PPDB-2026-TEST',
            'full_name' => 'Siswa Uji',
            'gender' => 'L',
            'birth_date' => '2010-01-01',
            'address' => 'Jl. Uji Coba No. 1',
            'parent_name' => 'Wali Uji',
            'parent_phone' => '081234567890',
            'jenjang' => 'smp',
            'status' => 'pending',
        ]);

        $doc = PpdbDocument::create([
            'registration_id' => $reg->id,
            'doc_type' => 'kk',
            'file_path' => 'ppdb_documents/test.pdf',
            'verification_status' => 'belum_diverifikasi',
        ]);

        $response = $this->get(route('admin.ppdb.document', $doc->id));

        $response->assertRedirect(route('login'));
    }

    public function test_authorized_admin_can_access_ppdb_document(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->create('kartu_keluarga.pdf', 100, 'application/pdf');
        $path = $file->store('ppdb_documents', 'public');

        $admin = User::factory()->create(['role' => 'admin_ppdb', 'is_active' => true]);

        $reg = PpdbRegistration::create([
            'no_pendaftaran' => 'PPDB-2026-DOC-TEST',
            'full_name' => 'Budi Santoso',
            'gender' => 'L',
            'birth_date' => '2010-05-05',
            'address' => 'Jl. Melati No. 12',
            'parent_name' => 'Slamet',
            'parent_phone' => '081234567891',
            'jenjang' => 'smp',
            'status' => 'pending',
        ]);

        $doc = PpdbDocument::create([
            'registration_id' => $reg->id,
            'doc_type' => 'kk',
            'file_path' => $path,
            'verification_status' => 'belum_diverifikasi',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.ppdb.document', $doc->id));

        $response->assertOk();
    }
}
