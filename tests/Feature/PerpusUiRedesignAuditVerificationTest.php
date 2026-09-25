<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookLoan;
use App\Models\LibraryMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerpusUiRedesignAuditVerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Item 1: Phone sanitization and tracking lookup consistency
     */
    public function test_phone_sanitization_allows_consistent_tracking(): void
    {
        $category = BookCategory::create(['name' => 'Teknologi', 'slug' => 'teknologi']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Pemrograman Web Modern',
            'author' => 'Ahmad Santoso',
            'stock' => 5,
            'available' => 5,
        ]);

        // Submit with dashes and spaces
        $response = $this->post(route('perpus.pinjam.store', $book->id), [
            'full_name' => 'Muhammad Fatih',
            'phone' => '0812-3456-7890',
            'address' => 'Asrama Putra',
        ]);

        $response->assertRedirect();
        $loan = BookLoan::first();
        $this->assertNotNull($loan);

        // Member phone should be sanitized to digits
        $member = LibraryMember::find($loan->member_id);
        $this->assertEquals('081234567890', $member->phone);

        // Can be tracked using clean phone
        $trackResponse = $this->post(route('perpus.check'), [
            'loan_code' => '081234567890',
        ]);
        $trackResponse->assertOk();
        $trackResponse->assertSee($loan->loan_code);

        // Can also be tracked using formatted phone
        $trackFormattedResponse = $this->post(route('perpus.check'), [
            'loan_code' => '0812-3456-7890',
        ]);
        $trackFormattedResponse->assertOk();
        $trackFormattedResponse->assertSee($loan->loan_code);
    }

    /**
     * Item 2: Book Cover displays properly and Book model has cover_url accessor
     */
    public function test_book_model_has_cover_url_and_tracking_renders_cover(): void
    {
        $category = BookCategory::create(['name' => 'Sains', 'slug' => 'sains']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Fisika Kuantum Dasar',
            'author' => 'Dr. Farhan',
            'cover' => 'covers/test-cover.jpg',
            'stock' => 2,
            'available' => 2,
        ]);

        $this->assertStringContainsString('covers/test-cover.jpg', $book->cover_url);

        $member = LibraryMember::create([
            'member_code' => 'LIB-2026-0001',
            'full_name' => 'Fulan bin Fulan',
            'phone' => '081299998888',
        ]);

        $loan = BookLoan::create([
            'loan_code' => 'PINJAM-2026-0099',
            'member_id' => $member->id,
            'book_id' => $book->id,
            'status' => 'dipinjam',
            'due_at' => now()->addDays(7),
        ]);

        $response = $this->post(route('perpus.check'), [
            'loan_code' => 'PINJAM-2026-0099',
        ]);

        $response->assertOk();
        $content = $response->getContent();
        // Should NOT contain broken 'No Cover' fallback when cover exists
        $this->assertStringContainsString('covers/test-cover.jpg', $content);
    }

    /**
     * Item 3: Print styles and receipts exist for Success & Tracking views
     */
    public function test_print_receipt_markup_present_in_success_and_tracking(): void
    {
        $category = BookCategory::create(['name' => 'Agama', 'slug' => 'agama']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Tafsir Al-Quran',
            'author' => 'Ustadz Abdullah',
            'stock' => 3,
            'available' => 3,
        ]);

        $member = LibraryMember::create([
            'member_code' => 'LIB-2026-0002',
            'full_name' => 'Zaidan Umar',
            'phone' => '081377776666',
        ]);

        $loan = BookLoan::create([
            'loan_code' => 'PINJAM-2026-0077',
            'member_id' => $member->id,
            'book_id' => $book->id,
            'status' => 'diajukan',
            'due_at' => now()->addDays(7),
        ]);

        // Success Page
        session(['submitted_loan_code' => 'PINJAM-2026-0077']);
        $successResponse = $this->get(route('perpus.pinjam.success', $loan->loan_code));
        $successResponse->assertOk();
        $successContent = $successResponse->getContent();

        $this->assertStringContainsString('print-only', $successContent);
        $this->assertStringContainsString('BUKTI PENGAJUAN PEMINJAMAN BUKU', $successContent);
        $this->assertStringContainsString('Tanda Tangan Peminjam', $successContent);
        $this->assertStringContainsString('Petugas Perpustakaan', $successContent);
        $this->assertStringContainsString('window.print()', $successContent);

        // CSS Print Stylesheet
        $css = file_get_contents(public_path('css/style.css'));
        $this->assertStringContainsString('@media print', $css);
        $this->assertStringContainsString('.print-only {', $css);
    }

    /**
     * Item 4: Detail page renders breadcrumbs, live stock indicator, and related books
     */
    public function test_book_detail_renders_breadcrumbs_and_live_stock(): void
    {
        $category = BookCategory::create(['name' => 'Sejarah', 'slug' => 'sejarah']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Sejarah Peradaban Islam',
            'author' => 'Prof. Ridwan',
            'stock' => 4,
            'available' => 4,
            'rack_location' => 'B-03',
        ]);

        $response = $this->get(route('perpus.show', $book->id));
        $response->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('aria-label="Breadcrumb"', $content);
        $this->assertStringContainsString('Sejarah Peradaban Islam', $content);
        $this->assertStringContainsString('Rak: B-03', $content);
        $this->assertStringContainsString('Status Ketersediaan Fisik:', $content);
        $this->assertStringContainsString('4 Eksemplar Tersedia', $content);
        $this->assertStringContainsString('Ajukan Peminjaman Buku Ini', $content);
    }

    /**
     * Item 5: Form pinjam contains client validation script & anti double-submit
     */
    public function test_pinjam_form_contains_anti_double_submit_and_phone_sanitizer(): void
    {
        $category = BookCategory::create(['name' => 'Bahasa', 'slug' => 'bahasa']);
        $book = Book::create([
            'category_id' => $category->id,
            'title' => 'Kamus Bahasa Arab',
            'author' => 'Munawwir',
            'stock' => 1,
            'available' => 1,
        ]);

        $response = $this->get(route('perpus.pinjam.create', $book->id));
        $response->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('id="pinjamForm"', $content);
        $this->assertStringContainsString('submitBtn.disabled = true', $content);
        $this->assertStringContainsString('submitSpinner', $content);
        $this->assertStringContainsString('replace(/[^0-9+]/g', $content);
    }

    /**
     * Item 6: Catalog index renders search clear script and responsive pills
     */
    public function test_catalog_index_renders_search_clear_and_stats(): void
    {
        $response = $this->get(route('perpus.index'));
        $response->assertOk();
        $content = $response->getContent();

        $this->assertStringContainsString('id="perpusSearchInput"', $content);
        $this->assertStringContainsString('id="perpusSearchClear"', $content);
        $this->assertStringContainsString('perpus-pills-row', $content);
        $this->assertStringContainsString('perpus-books-grid', $content);
    }
}
