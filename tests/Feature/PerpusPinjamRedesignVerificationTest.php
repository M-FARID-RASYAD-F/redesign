<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookLoan;
use App\Models\LibraryMember;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerpusPinjamRedesignVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected BookCategory $category;
    protected Book $book;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = BookCategory::create([
            'name' => 'Pengembangan Diri & Karakter',
            'slug' => 'pengembangan-diri-karakter',
        ]);

        $this->book = Book::create([
            'id'            => 14,
            'category_id'   => $this->category->id,
            'title'         => '7 Keajaiban Rezeki & Percepatan Sukses',
            'isbn'          => '978-979-27-7241-8',
            'author'        => 'Ippho Santosa',
            'publisher'     => 'Elex Media Komputindo',
            'stock'         => 5,
            'available'     => 4,
            'rack_location' => 'Rak E-02',
        ]);
    }

    /**
     * Test 1: Halaman Formulir Peminjaman me-render seluruh elemen visual dari Screenshot (37).png
     */
    public function test_pinjam_form_renders_all_screenshot_redesign_elements(): void
    {
        $response = $this->get(route('perpus.pinjam.create', $this->book->id));
        $response->assertOk();
        $content = $response->getContent();

        // 1. Tata Letak Terpusat Tanpa Sidebar (Centered Modern SaaS Layout)
        $this->assertStringNotContainsString('sidebar-dashboard', $content);
        $this->assertStringContainsString('pinjam-master-card', $content);
        $this->assertStringContainsString('max-w-4xl', $content);

        // 2. Breadcrumb Navigation sesuai Screenshot (37).png
        $this->assertStringContainsString('aria-label="Breadcrumb"', $content);
        $this->assertStringContainsString('Beranda', $content);
        $this->assertStringContainsString('Perpustakaan', $content);
        $this->assertStringContainsString('Form pinjam', $content);
        $this->assertStringContainsString('Kembali ke detail buku', $content);

        // 3. Header Form & Status Badges
        $this->assertStringContainsString('Sirkulasi mandiri literasi', $content);
        $this->assertStringContainsString('Ajukan peminjaman buku', $content);
        $this->assertStringContainsString('Kode referensi peminjaman akan langsung diterbitkan', $content);

        // 4. Book Information Card sesuai Screenshot (37).png
        $this->assertStringContainsString('Sampul', $content);
        $this->assertStringContainsString(e($this->category->name), $content);
        $this->assertStringContainsString('4 eksemplar tersedia', $content);
        $this->assertStringContainsString('Penulis:', $content);
        $this->assertStringContainsString('Ippho Santosa', $content);
        $this->assertStringContainsString('7 hari kalender', $content);
        $this->assertStringContainsString('Rak E-02', $content);
        $this->assertStringContainsString('Gratis', $content);

        // 5. Section Identitas Peminjam & Form Inputs (.f & .ip)
        $this->assertStringContainsString('Identitas peminjam', $content);
        $this->assertStringContainsString('Nama lengkap', $content);
        $this->assertStringContainsString('Muhammad Rayhan', $content);
        $this->assertStringContainsString('Untuk santri, siswa, guru, staf, dan pengunjung.', $content);

        $this->assertStringContainsString('Nomor WhatsApp aktif', $content);
        $this->assertStringContainsString('081234567890', $content);
        $this->assertStringContainsString('Dipakai untuk melacak kode peminjaman.', $content);

        $this->assertStringContainsString('Kelas / asrama / domisili', $content);
        $this->assertStringContainsString('Kelas X Tahfizh A / Asrama Kampus Panam', $content);
        $this->assertStringContainsString('Membantu petugas mengenali Anda saat penyerahan buku.', $content);

        // 6. Ketentuan & Action Buttons
        $this->assertStringContainsString('Ketentuan peminjaman', $content);
        $this->assertStringContainsString('Maksimal 7 hari kalender sejak buku diambil.', $content);
        $this->assertStringContainsString('Jaga buku tanpa coretan atau kerusakan.', $content);
        $this->assertStringContainsString('Tunjukkan tiket pinjam ke petugas.', $content);
        $this->assertStringContainsString('Layanan gratis. Data Anda terlindungi.', $content);
        $this->assertStringContainsString('Batal', $content);
        $this->assertStringContainsString('Kirim pengajuan', $content);
        $this->assertStringContainsString('WhatsApp online, hubungi kami', $content);
    }

    /**
     * Test 2: Pengiriman Form Pinjam berhasil menyimpan data ke database dan redirect ke sukses
     */
    public function test_pinjam_form_submits_successfully_and_creates_loan(): void
    {
        $response = $this->post(route('perpus.pinjam.store', $this->book->id), [
            'full_name' => 'Muhammad Rayhan',
            'phone'     => '081234567890',
            'address'   => 'Kelas X Tahfizh A / Asrama Kampus Panam',
        ]);

        $response->assertRedirect();
        
        $loan = BookLoan::where('book_id', $this->book->id)->first();
        $this->assertNotNull($loan);
        $this->assertEquals('diajukan', $loan->status);

        $member = LibraryMember::find($loan->member_id);
        $this->assertNotNull($member);
        $this->assertEquals('Muhammad Rayhan', $member->full_name);
        $this->assertEquals('081234567890', $member->phone);
        $this->assertEquals('Kelas X Tahfizh A / Asrama Kampus Panam', $member->address);

        $response->assertRedirect(route('perpus.pinjam.success', $loan->loan_code));
    }

    /**
     * Test 3: Validasi error jika input wajib tidak diisi
     */
    public function test_pinjam_form_validates_required_fields(): void
    {
        $response = $this->from(route('perpus.pinjam.create', $this->book->id))
            ->post(route('perpus.pinjam.store', $this->book->id), [
                'full_name' => '',
                'phone'     => '',
            ]);

        $response->assertRedirect(route('perpus.pinjam.create', $this->book->id));
        $response->assertSessionHasErrors(['full_name', 'phone']);
    }
}
