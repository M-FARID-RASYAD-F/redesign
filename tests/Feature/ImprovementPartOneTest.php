<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookLoan;
use App\Models\LibraryMember;
use App\Models\Major;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\PpdbDocument;
use App\Models\PpdbRegistration;
use App\Models\TeacherStaff;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImprovementPartOneTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Topik 1: Eloquent Relationships (BelongsTo & HasMany return types)
     */
    public function test_topik_1_eloquent_relationships(): void
    {
        $book = new Book();
        $this->assertInstanceOf(BelongsTo::class, $book->category());
        $this->assertInstanceOf(HasMany::class, $book->loans());

        $category = new BookCategory();
        $this->assertInstanceOf(HasMany::class, $category->books());
    }

    /**
     * Topik 2: Eager Loading & Prevention of N+1 in newsShow
     */
    public function test_topik_2_related_news_eager_loading(): void
    {
        $author = User::factory()->create(['role' => 'admin_cms', 'is_active' => true]);
        $category = NewsCategory::create(['name' => 'Akademik', 'slug' => 'akademik']);

        $mainNews = News::create([
            'category_id' => $category->id,
            'title' => 'Berita Utama',
            'slug' => 'berita-utama',
            'content' => 'Konten utama berita.',
            'author_id' => $author->id,
        ]);

        $otherNews = News::create([
            'category_id' => $category->id,
            'title' => 'Berita Terkait',
            'slug' => 'berita-terkait',
            'content' => 'Konten terkait berita.',
            'author_id' => $author->id,
        ]);

        $response = $this->get(route('news.show', $mainNews->slug));
        $response->assertOk();
        $related = $response->viewData('relatedNews');
        $this->assertNotEmpty($related);
        // Verify category relation is eager-loaded
        $this->assertTrue($related->first()->relationLoaded('category'));
    }

    /**
     * Topik 3: Route Model Binding by slug and 404 for invalid slug
     */
    public function test_topik_3_route_model_binding(): void
    {
        $author = User::factory()->create(['role' => 'admin_cms', 'is_active' => true]);
        $category = NewsCategory::create(['name' => 'Pengumuman', 'slug' => 'pengumuman']);

        $news = News::create([
            'category_id' => $category->id,
            'title' => 'Pengumuman Libur',
            'slug' => 'pengumuman-libur-nasional',
            'content' => 'Isi libur nasional.',
            'author_id' => $author->id,
        ]);

        // Valid slug resolves model automatically
        $responseValid = $this->get(route('news.show', $news->slug));
        $responseValid->assertOk();
        $this->assertEquals($news->id, $responseValid->viewData('news')->id);

        // Invalid slug triggers automatic 404
        $responseInvalid = $this->get('/berita/slug-tidak-terdaftar-999');
        $responseInvalid->assertNotFound();
    }

    /**
     * Topik 4: Form Request Validation & Policy Authorization
     */
    public function test_topik_4_form_requests(): void
    {
        $admin = User::factory()->create(['role' => 'admin_cms', 'is_active' => true]);
        $editor = User::factory()->create(['role' => 'editor_akademik', 'is_active' => true]);
        $category = NewsCategory::create(['name' => 'Umum', 'slug' => 'umum']);

        // Unauthorized user cannot store news
        $responseForbidden = $this->actingAs($editor)->post(route('admin.news.store'), [
            'title' => 'Judul Berita',
            'category_id' => $category->id,
            'content' => 'Konten berita',
        ]);
        $responseForbidden->assertForbidden();

        // Authorized user with invalid data receives validation errors
        $responseInvalid = $this->actingAs($admin)->post(route('admin.news.store'), [
            'title' => '',
            'category_id' => 99999, // nonexistent
            'content' => '',
        ]);
        $responseInvalid->assertSessionHasErrors(['title', 'category_id', 'content']);

        // Store teacher request authorization and validation
        $responseTeacherValid = $this->actingAs($editor)->post(route('admin.teachers.store'), [
            'name' => 'Ustadz Ahmad',
            'position' => 'Guru Tahfizh',
            'subject' => 'Al-Quran',
            'status' => 'aktif',
        ]);
        $responseTeacherValid->assertRedirect(route('admin.teachers.index'));
        $this->assertDatabaseHas('teachers_staff', ['name' => 'Ustadz Ahmad']);
    }

    /**
     * Topik 5: Observer Pattern for Automatic Code Generation
     */
    public function test_topik_5_model_observers(): void
    {
        // PPDB Registration Observer
        $registration = PpdbRegistration::create([
            'full_name' => 'Santri Baru Observer',
            'gender' => 'L',
            'birth_date' => '2010-01-01',
            'address' => 'Jakarta Timur',
            'parent_name' => 'Orang Tua',
            'parent_phone' => '081234567890',
            'jenjang' => 'smp',
            'status' => 'pending',
        ]);

        $this->assertNotEmpty($registration->no_pendaftaran);
        $this->assertStringStartsWith('PPDB-' . date('Y') . '-', $registration->no_pendaftaran);

        // Book Loan Observer
        $member = LibraryMember::create([
            'member_code' => 'ANGGOTA-001',
            'full_name' => 'Siswa Peminjam',
            'phone' => '081234567890',
        ]);
        $cat = BookCategory::create(['name' => 'Agama', 'slug' => 'agama']);
        $book = Book::create([
            'category_id' => $cat->id,
            'title' => 'Fiqih Sunnah',
            'author' => 'Sayyid Sabiq',
            'stock' => 5,
            'available' => 5,
        ]);

        $loan = BookLoan::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_at' => now()->addDays(7),
            'status' => 'diajukan',
        ]);

        $this->assertNotEmpty($loan->loan_code);
        $this->assertStringStartsWith('PINJAM-' . date('Y') . '-', $loan->loan_code);
    }

    /**
     * Topik 6: Accessor & Mutator using modern Attribute::make()
     */
    public function test_topik_6_modern_accessors(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $adminCms = User::factory()->create(['role' => 'admin_cms']);

        $this->assertEquals(route('admin.dashboard'), $superAdmin->dashboard_url);
        $this->assertEquals('Super Admin', $superAdmin->role_label);

        $this->assertEquals(route('admin.cms.dashboard'), $adminCms->dashboard_url);
        $this->assertEquals('Admin CMS', $adminCms->role_label);

        $registration = new PpdbRegistration(['jenjang' => 'smk']);
        $this->assertEquals('Sekolah Menengah Kejuruan (SMK)', $registration->jenjang_label);
        $this->assertEquals('SMK', $registration->jenjang_code);
        $this->assertEquals('💻', $registration->jenjang_icon);
    }

    /**
     * Topik 7: Local Query Scopes
     */
    public function test_topik_7_query_scopes(): void
    {
        $reg1 = PpdbRegistration::create([
            'full_name' => 'Santri 1',
            'gender' => 'L',
            'birth_date' => '2010-01-01',
            'address' => 'Bekasi',
            'parent_name' => 'Bapak 1',
            'parent_phone' => '081234567891',
            'jenjang' => 'smp',
            'status' => 'pending',
        ]);

        $reg2 = PpdbRegistration::create([
            'full_name' => 'Santri 2',
            'gender' => 'P',
            'birth_date' => '2011-01-01',
            'address' => 'Depok',
            'parent_name' => 'Bapak 2',
            'parent_phone' => '081234567892',
            'jenjang' => 'sd',
            'status' => 'diverifikasi',
        ]);

        // Scopes test
        $this->assertEquals(1, PpdbRegistration::pending()->count());
        $this->assertEquals(1, PpdbRegistration::status('diverifikasi')->count());
        $this->assertEquals(1, PpdbRegistration::jenjang('smp')->count());
        $this->assertEquals(1, PpdbRegistration::jenjang('sd')->count());

        // Document scopes test
        $doc1 = PpdbDocument::create([
            'registration_id' => $reg1->id,
            'doc_type' => 'kk',
            'file_path' => 'ppdb/docs/kk.pdf',
            'verification_status' => 'belum_diverifikasi',
        ]);

        $doc2 = PpdbDocument::create([
            'registration_id' => $reg2->id,
            'doc_type' => 'akta_lahir',
            'file_path' => 'ppdb/docs/akta.pdf',
            'verification_status' => 'valid',
        ]);

        $this->assertEquals(1, PpdbDocument::unverified()->count());
        $this->assertEquals(1, PpdbDocument::verified()->count());
    }
}
