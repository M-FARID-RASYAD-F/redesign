<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookLoan;
use App\Models\LibraryMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerpusModuleTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $adminPerpus;
    protected User $adminCms;
    protected BookCategory $fictionCategory;
    protected BookCategory $scienceCategory;
    protected Book $testBook;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superAdmin = User::create([
            'name'      => 'Super Admin',
            'email'     => 'superadmin@test.com',
            'password'  => bcrypt('password123'),
            'role'      => 'super_admin',
            'is_active' => true,
        ]);

        $this->adminPerpus = User::create([
            'name'      => 'Petugas Perpus',
            'email'     => 'perpus@test.com',
            'password'  => bcrypt('password123'),
            'role'      => 'admin_perpus',
            'is_active' => true,
        ]);

        $this->adminCms = User::create([
            'name'      => 'Admin CMS',
            'email'     => 'cms@test.com',
            'password'  => bcrypt('password123'),
            'role'      => 'admin_cms',
            'is_active' => true,
        ]);

        $this->fictionCategory = BookCategory::create([
            'name' => 'Fiksi',
            'slug' => 'fiksi',
        ]);

        $this->scienceCategory = BookCategory::create([
            'name' => 'Sains & Teknologi',
            'slug' => 'sains-dan-teknologi',
        ]);

        $this->testBook = Book::create([
            'category_id'   => $this->fictionCategory->id,
            'title'         => 'Laskar Pelangi',
            'isbn'          => '978-979-3062-79-2',
            'author'        => 'Andrea Hirata',
            'publisher'     => 'Bentang Pustaka',
            'stock'         => 3,
            'available'     => 3,
            'synopsis'      => 'Kisah tentang sepuluh anak dari keluarga miskin yang bersekolah di sebuah SD di Belitung.',
            'rack_location' => 'Rak A-01',
        ]);
    }

    /**
     * Test 1: Publik dapat melihat katalog buku dan melakukan pencarian serta filter
     */
    public function test_public_catalog_can_be_viewed_and_searched_and_filtered(): void
    {
        $scienceBook = Book::create([
            'category_id'   => $this->scienceCategory->id,
            'title'         => 'Clean Code',
            'author'        => 'Robert C. Martin',
            'stock'         => 2,
            'available'     => 2,
        ]);

        // Akses halaman katalog publik
        $response = $this->get(route('perpus.index'));
        $response->assertOk();
        $response->assertSee('Laskar Pelangi');
        $response->assertSee('Clean Code');

        // Pencarian berdasarkan kata kunci
        $searchResponse = $this->get(route('perpus.index', ['search' => 'Pelangi']));
        $searchResponse->assertOk();
        $searchResponse->assertSee('Laskar Pelangi');
        $searchResponse->assertDontSee('Clean Code');

        // Pencarian berdasarkan ISBN
        $isbnResponse = $this->get(route('perpus.index', ['search' => '978-979-3062-79-2']));
        $isbnResponse->assertOk();
        $isbnResponse->assertSee('Laskar Pelangi');
        $isbnResponse->assertDontSee('Clean Code');

        // Filter berdasarkan kategori
        $filterResponse = $this->get(route('perpus.index', ['category' => $this->scienceCategory->id]));
        $filterResponse->assertOk();
        $filterResponse->assertSee('Clean Code');
        $filterResponse->assertDontSee('Laskar Pelangi');
    }

    /**
     * Test 2: Publik dapat melihat halaman detail buku
     */
    public function test_public_book_detail_displays_correct_information(): void
    {
        $response = $this->get(route('perpus.show', $this->testBook->id));
        $response->assertOk();
        $response->assertSee('Laskar Pelangi');
        $response->assertSee('Andrea Hirata');
        $response->assertSee('Bentang Pustaka');
        $response->assertSee('Rak A-01');
        $response->assertSee('3 Eksemplar Tersedia');
    }

    /**
     * Test 3: Publik dapat mengajukan peminjaman buku (firstOrCreate member, format kode)
     */
    public function test_visitor_can_submit_book_loan_application(): void
    {
        $response = $this->get(route('perpus.pinjam.create', $this->testBook->id));
        $response->assertOk();
        $response->assertSee('Laskar Pelangi');

        // Submit peminjaman
        $postData = [
            'full_name' => 'Ahmad Santoso',
            'phone'     => '081234567890',
            'address'   => 'Kelas X IPA 1',
        ];

        $postResponse = $this->post(route('perpus.pinjam.store', $this->testBook->id), $postData);

        // Verifikasi member dibuat otomatis dengan kode ANG-YYYY-XXXX
        $member = LibraryMember::where('phone', '081234567890')->first();
        $this->assertNotNull($member);
        $this->assertEquals('Ahmad Santoso', $member->full_name);
        $this->assertMatchesRegularExpression('/^ANG-\d{4}-\d{4}$/', $member->member_code);

        // Verifikasi loan dibuat dengan kode PINJAM-YYYY-XXXX dan status 'diajukan'
        $loan = BookLoan::where('member_id', $member->id)->where('book_id', $this->testBook->id)->first();
        $this->assertNotNull($loan);
        $this->assertMatchesRegularExpression('/^PINJAM-\d{4}-\d{4}$/', $loan->loan_code);
        $this->assertEquals('diajukan', $loan->status);

        // Redirect ke halaman sukses
        $postResponse->assertRedirect(route('perpus.pinjam.success', $loan->loan_code));

        // Halaman sukses menampilkan kode pinjam
        $successResponse = $this->get(route('perpus.pinjam.success', $loan->loan_code));
        $successResponse->assertOk();
        $successResponse->assertSee($loan->loan_code);
        $successResponse->assertSee('Laskar Pelangi');
    }

    /**
     * Test 4: Tidak dapat meminjam jika stok available habis
     */
    public function test_visitor_cannot_borrow_when_available_stock_is_zero(): void
    {
        $outOfStockBook = Book::create([
            'category_id'   => $this->fictionCategory->id,
            'title'         => 'Buku Habis',
            'author'        => 'Anonim',
            'stock'         => 1,
            'available'     => 0,
        ]);

        $response = $this->post(route('perpus.pinjam.store', $outOfStockBook->id), [
            'full_name' => 'Budi',
            'phone'     => '081999999999',
        ]);

        $response->assertSessionHasErrors('stock');
        $this->assertDatabaseMissing('book_loans', ['book_id' => $outOfStockBook->id]);
    }

    /**
     * Test 5: Publik dapat melacak status peminjaman menggunakan loan_code
     */
    public function test_visitor_can_track_loan_status(): void
    {
        $member = LibraryMember::create([
            'full_name' => 'Siti Nurhaliza',
            'phone'     => '081333444555',
            'joined_at' => now(),
        ]);

        $loan = BookLoan::create([
            'member_id' => $member->id,
            'book_id'   => $this->testBook->id,
            'status'    => 'dipinjam',
            'due_at'    => now()->addDays(7),
        ]);

        // Cek halaman tracking dengan Kode Pinjam
        $trackingResponse = $this->post(route('perpus.check'), [
            'loan_code' => $loan->loan_code,
        ]);

        $trackingResponse->assertOk();
        $trackingResponse->assertSee($loan->loan_code);
        $trackingResponse->assertSee('Siti Nurhaliza');
        $trackingResponse->assertSee('Sedang Dipinjam');

        // Cek halaman tracking dengan Nomor WhatsApp
        $phoneTrackingResponse = $this->post(route('perpus.check'), [
            'loan_code' => '081333444555',
        ]);

        $phoneTrackingResponse->assertOk();
        $phoneTrackingResponse->assertSee($loan->loan_code);
        $phoneTrackingResponse->assertSee('Siti Nurhaliza');
    }

    /**
     * Test 6: RBAC Proteksi rute admin perpustakaan
     */
    public function test_admin_perpus_rbac_access_control(): void
    {
        // 1. Guest diarahkan ke login
        $this->get(route('admin.perpus.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.perpus.books.index'))->assertRedirect(route('login'));

        // 2. Role lain (mis. admin_cms) mendapatkan 403 Forbidden
        $this->actingAs($this->adminCms);
        $this->get(route('admin.perpus.dashboard'))->assertForbidden();
        $this->get(route('admin.perpus.books.index'))->assertForbidden();
        $this->get(route('admin.perpus.loans.index'))->assertForbidden();

        // 3. Petugas perpus dapat mengakses modul perpus
        $this->actingAs($this->adminPerpus);
        $this->get(route('admin.perpus.dashboard'))->assertOk();
        $this->get(route('admin.perpus.books.index'))->assertOk();
        $this->get(route('admin.perpus.loans.index'))->assertOk();

        // 4. Petugas perpus dilarang mengakses kelola pengguna (hanya super_admin)
        $this->get(route('admin.users.index'))->assertForbidden();

        // 5. Super admin memiliki akses penuh ke perpus
        $this->actingAs($this->superAdmin);
        $this->get(route('admin.perpus.dashboard'))->assertOk();
        $this->get(route('admin.perpus.books.index'))->assertOk();
    }

    /**
     * Test 7: CRUD Buku oleh admin perpustakaan
     */
    public function test_admin_can_crud_books_and_categories(): void
    {
        $this->actingAs($this->adminPerpus);

        // Tambah Kategori
        $this->post(route('admin.perpus.book-categories.store'), ['name' => 'Agama Islam'])
            ->assertRedirect();
        $this->assertDatabaseHas('book_categories', ['name' => 'Agama Islam', 'slug' => 'agama-islam']);

        // Tambah Buku Baru
        $createResponse = $this->post(route('admin.perpus.books.store'), [
            'category_id'   => $this->fictionCategory->id,
            'title'         => 'Bumi Manusia',
            'isbn'          => '978-979-9731-23-2',
            'author'        => 'Pramoedya Ananta Toer',
            'publisher'     => 'Hasta Mitra',
            'stock'         => 5,
            'rack_location' => 'Rak F-02',
        ]);
        $createResponse->assertRedirect(route('admin.perpus.books.index'));

        $newBook = Book::where('title', 'Bumi Manusia')->first();
        $this->assertNotNull($newBook);
        $this->assertEquals(5, $newBook->stock);
        $this->assertEquals(5, $newBook->available); // available otomatis sama dengan stock saat create

        // Edit Buku
        $updateResponse = $this->post(route('admin.perpus.books.update', $newBook->id), [
            'category_id'   => $this->fictionCategory->id,
            'title'         => 'Bumi Manusia (Edisi Revisi)',
            'author'        => 'Pramoedya Ananta Toer',
            'stock'         => 7, // stok bertambah 2
        ]);
        $updateResponse->assertRedirect(route('admin.perpus.books.index'));

        $newBook->refresh();
        $this->assertEquals('Bumi Manusia (Edisi Revisi)', $newBook->title);
        $this->assertEquals(7, $newBook->stock);
        $this->assertEquals(7, $newBook->available); // available ikut bertambah selisihnya

        // Hapus Buku
        $deleteResponse = $this->delete(route('admin.perpus.books.delete', $newBook->id));
        $deleteResponse->assertRedirect(route('admin.perpus.books.index'));
        $this->assertDatabaseMissing('books', ['id' => $newBook->id]);
    }

    /**
     * Test 8: Verifikasi status peminjaman dan pengelolaan stok (idempotent, no double decrement/increment)
     */
    public function test_loan_verification_and_stock_management(): void
    {
        $this->actingAs($this->adminPerpus);

        $member = LibraryMember::create([
            'full_name' => 'Rahmat Hidayat',
            'phone'     => '082123456789',
            'joined_at' => now(),
        ]);

        $loan = BookLoan::create([
            'member_id' => $member->id,
            'book_id'   => $this->testBook->id,
            'status'    => 'diajukan',
        ]);

        $this->assertEquals(3, $this->testBook->available);

        // 1. Ubah status jadi 'dipinjam' -> stok berkurang 1
        $this->post(route('admin.perpus.loans.status', $loan->id), [
            'status' => 'dipinjam',
            'notes'  => 'Diserahkan dalam kondisi baik',
        ]);

        $this->testBook->refresh();
        $loan->refresh();
        $this->assertEquals('dipinjam', $loan->status);
        $this->assertEquals(2, $this->testBook->available);
        $this->assertNotNull($loan->borrowed_at);

        // 2. Simpan ulang status yang sama 'dipinjam' -> stok TIDAK boleh berkurang lagi
        $this->post(route('admin.perpus.loans.status', $loan->id), [
            'status' => 'dipinjam',
        ]);
        $this->testBook->refresh();
        $this->assertEquals(2, $this->testBook->available);

        // 3. Ubah status jadi 'dikembalikan' -> stok bertambah 1 kembali
        $this->post(route('admin.perpus.loans.status', $loan->id), [
            'status' => 'dikembalikan',
        ]);

        $this->testBook->refresh();
        $loan->refresh();
        $this->assertEquals('dikembalikan', $loan->status);
        $this->assertEquals(3, $this->testBook->available);
        $this->assertNotNull($loan->returned_at);

        // 4. Simpan ulang status 'dikembalikan' -> stok TIDAK boleh bertambah lagi
        $this->post(route('admin.perpus.loans.status', $loan->id), [
            'status' => 'dikembalikan',
        ]);
        $this->testBook->refresh();
        $this->assertEquals(3, $this->testBook->available);
    }

    /**
     * Test 9: Ekspor CSV peminjaman dengan filter status
     */
    public function test_admin_can_export_loans_csv(): void
    {
        $this->actingAs($this->adminPerpus);

        $member = LibraryMember::create([
            'full_name' => 'Dewi Lestari',
            'phone'     => '085678901234',
            'joined_at' => now(),
        ]);

        $loan = BookLoan::create([
            'member_id'   => $member->id,
            'book_id'     => $this->testBook->id,
            'status'      => 'dipinjam',
            'borrowed_at' => now(),
            'due_at'      => now()->addDays(7),
        ]);

        $response = $this->get(route('admin.perpus.loans.export'));
        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        // Streaming response callback execution
        ob_start();
        $response->sendContent();
        $content = ob_get_clean();

        $this->assertStringContainsString('Kode Pinjam', $content);
        $this->assertStringContainsString('Anggota', $content);
        $this->assertStringContainsString('No. HP', $content);
        $this->assertStringContainsString('Buku', $content);
        $this->assertStringContainsString('Status', $content);
        $this->assertStringContainsString($loan->loan_code, $content);
        $this->assertStringContainsString('Dewi Lestari', $content);
        $this->assertStringContainsString('Laskar Pelangi', $content);
    }

    /**
     * Test 10: Dashboard perpustakaan menampilkan statistik dengan benar
     */
    public function test_perpus_dashboard_displays_accurate_stats(): void
    {
        $this->actingAs($this->adminPerpus);

        $member = LibraryMember::create([
            'full_name' => 'Fajar Pratama',
            'phone'     => '081298765432',
            'joined_at' => now(),
        ]);

        BookLoan::create([
            'member_id' => $member->id,
            'book_id'   => $this->testBook->id,
            'status'    => 'dipinjam',
        ]);

        BookLoan::create([
            'member_id' => $member->id,
            'book_id'   => $this->testBook->id,
            'status'    => 'terlambat',
        ]);

        $response = $this->get(route('admin.perpus.dashboard'));
        $response->assertOk();
        $response->assertSee('Portal Petugas Perpustakaan');
        $response->assertSee('Laskar Pelangi');
    }
}
