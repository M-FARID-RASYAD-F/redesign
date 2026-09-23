<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookLoan;
use App\Models\LibraryMember;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\PpdbDocument;
use App\Models\PpdbRegistration;
use App\Models\User;
use App\Services\HtmlSanitizerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: HTML Sanitizer Service strictly neutralizes dangerous XSS payloads
     */
    public function test_html_sanitizer_removes_scripts_and_malicious_attributes(): void
    {
        $sanitizer = app(HtmlSanitizerService::class);

        $payload = '<p>Paragraf aman <a href="javascript:alert(document.cookie)">Klik Saya</a> <img src="x" onerror="alert(1)"> <script>alert("hack")</script></p>';
        $cleaned = $sanitizer->clean($payload);

        $this->assertStringNotContainsString('<script>', $cleaned);
        $this->assertStringNotContainsString('javascript:', $cleaned);
        $this->assertStringNotContainsString('onerror', $cleaned);
        $this->assertStringContainsString('Paragraf aman', $cleaned);
    }

    /**
     * Test 2: PPDB Tracking rejects wildcard / partial phone number enumeration
     */
    public function test_ppdb_tracking_rejects_partial_phone_numbers(): void
    {
        $reg = PpdbRegistration::create([
            'jenjang' => 'smp',
            'full_name' => 'Ahmad Santri',
            'gender' => 'L',
            'birth_date' => '2012-01-01',
            'address' => 'Jl. Hangtuah No. 12',
            'parent_name' => 'Bapak Ahmad',
            'parent_phone' => '081234567890',
            'status' => 'pending',
        ]);

        // Input potongan 8 digit tidak boleh mencocokkan data
        $responsePartial = $this->post(route('ppdb.check'), [
            'no_pendaftaran' => '08123456',
        ]);

        $responsePartial->assertRedirect(route('ppdb.tracking'));
        $responsePartial->assertSessionHas('error');

        // Input nomor telepon lengkap persis harus berhasil
        $responseExact = $this->post(route('ppdb.check'), [
            'no_pendaftaran' => '081234567890',
        ]);
        $responseExact->assertOk();
        $responseExact->assertSee($reg->no_pendaftaran);
    }

    /**
     * Test 3: admin_cms cannot access private PPDB documents (Principle of Least Privilege)
     */
    public function test_admin_cms_cannot_access_private_ppdb_documents(): void
    {
        $adminCms = User::factory()->create([
            'role' => 'admin_cms',
            'is_active' => true,
        ]);

        $reg = PpdbRegistration::create([
            'no_pendaftaran' => 'PPDB-2026-TEST',
            'full_name' => 'Siswa Test',
            'gender' => 'L',
            'birth_date' => '2012-01-01',
            'address' => 'Alamat Test',
            'parent_name' => 'Wali Test',
            'parent_phone' => '081234567890',
            'status' => 'pending',
        ]);

        $doc = PpdbDocument::create([
            'registration_id' => $reg->id,
            'doc_type' => 'kk',
            'file_path' => 'ppdb_documents/test.pdf',
            'verification_status' => 'belum_diverifikasi',
        ]);

        $this->actingAs($adminCms);

        $response = $this->get(route('admin.ppdb.document', $doc->id));
        $response->assertForbidden();
    }

    /**
     * Test 4: Weak passwords are rejected when creating an admin user
     */
    public function test_weak_password_rejected_in_user_management(): void
    {
        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $this->actingAs($superAdmin);

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Staf Baru',
            'email' => 'staf@sekolah.sch.id',
            'password' => '12345', // Kurang dari 8 dan tidak memenuhi standar
            'role' => 'editor_akademik',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test 5: BookLoan generates non-predictable random loan code
     */
    public function test_book_loan_generates_random_loan_code(): void
    {
        $member = LibraryMember::create([
            'full_name' => 'Anggota Test',
            'phone' => '081200001111',
        ]);

        $book = Book::create([
            'title' => 'Buku Uji Keamanan',
            'author' => 'Penulis',
            'stock' => 5,
            'available' => 5,
        ]);

        $loan1 = BookLoan::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'status' => 'diajukan',
        ]);

        $loan2 = BookLoan::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'status' => 'diajukan',
        ]);

        $this->assertNotEquals($loan1->loan_code, $loan2->loan_code);
        $this->assertMatchesRegularExpression('/^PINJAM-\d{4}-\d{4}$/', $loan1->loan_code);
        $this->assertMatchesRegularExpression('/^PINJAM-\d{4}-\d{4}$/', $loan2->loan_code);
    }
}
