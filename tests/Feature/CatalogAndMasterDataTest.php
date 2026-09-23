<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Rack;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogAndMasterDataTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Category $categoryTech;
    protected Category $categoryAgama;
    protected Rack $rackA;
    protected Rack $rackB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $this->categoryTech = Category::create([
            'name' => 'Teknologi Informasi',
            'slug' => 'teknologi-informasi',
            'description' => 'Buku-buku seputar pemrograman dan komputer',
            'icon' => '💻'
        ]);

        $this->categoryAgama = Category::create([
            'name' => 'Agama Islam',
            'slug' => 'agama-islam',
            'description' => 'Buku-buku keislaman',
            'icon' => '🕌'
        ]);

        $this->rackA = Rack::create([
            'code' => 'RAK-01',
            'name' => 'Rak Komputer',
            'location' => 'Lantai 1 Sayap Barat',
            'description' => 'Rak khusus komputer'
        ]);

        $this->rackB = Rack::create([
            'code' => 'RAK-02',
            'name' => 'Rak Agama',
            'location' => 'Lantai 1 Sayap Timur',
            'description' => 'Rak khusus kajian Islam'
        ]);
    }

    /**
     * Test 1: Relasi Model Book belongsTo Category dan Book belongsTo Rack
     */
    public function test_book_belongs_to_category_and_rack_relationships(): void
    {
        $book = Book::create([
            'category_id' => $this->categoryTech->id,
            'rack_id' => $this->rackA->id,
            'title' => 'Laravel Clean Architecture',
            'slug' => 'laravel-clean-architecture',
            'isbn' => '978-602-00-1111-1',
            'author' => 'Rasyad Fauzan',
            'publisher' => 'Informatika Press',
            'publication_year' => 2024,
            'pages' => 350,
            'stock' => 5,
            'available_stock' => 5,
            'status' => 'tersedia',
            'description' => 'Buku panduan arsitektur Laravel.',
        ]);

        // Verifikasi Book belongsTo Category
        $this->assertInstanceOf(Category::class, $book->category);
        $this->assertEquals($this->categoryTech->id, $book->category->id);
        $this->assertEquals('Teknologi Informasi', $book->category->name);

        // Verifikasi Book belongsTo Rack
        $this->assertInstanceOf(Rack::class, $book->rack);
        $this->assertEquals($this->rackA->id, $book->rack->id);
        $this->assertEquals('RAK-01', $book->rack->code);

        // Verifikasi sebaliknya: Category hasMany Book & Rack hasMany Book
        $this->assertTrue($this->categoryTech->books->contains($book));
        $this->assertTrue($this->rackA->books->contains($book));
    }

    /**
     * Test 2: Halaman Katalog Publik dapat diakses dan menampilkan buku
     */
    public function test_public_catalog_can_be_accessed(): void
    {
        Book::create([
            'category_id' => $this->categoryTech->id,
            'rack_id' => $this->rackA->id,
            'title' => 'Pemrograman Web Modern',
            'slug' => 'pemrograman-web-modern',
            'isbn' => '978-602-00-2222-2',
            'author' => 'Budi Hartono',
            'stock' => 3,
            'available_stock' => 3,
            'status' => 'tersedia',
        ]);

        $response = $this->get(route('catalog.index'));
        $response->assertStatus(200);
        $response->assertSee('Pemrograman Web Modern');
        $response->assertSee('Budi Hartono');
        $response->assertSee('Teknologi Informasi');
        $response->assertSee('RAK-01');
    }

    /**
     * Test 3: Pencarian Katalog Publik (search/filter keyword)
     */
    public function test_public_catalog_search_filters_books(): void
    {
        Book::create([
            'category_id' => $this->categoryTech->id,
            'rack_id' => $this->rackA->id,
            'title' => 'Mastering Python Data Science',
            'slug' => 'mastering-python-data-science',
            'isbn' => '978-602-00-3333-3',
            'author' => 'Alexander Python',
            'stock' => 2,
            'available_stock' => 2,
            'status' => 'tersedia',
        ]);

        Book::create([
            'category_id' => $this->categoryAgama->id,
            'rack_id' => $this->rackB->id,
            'title' => 'Panduan Tajwid Al-Qur\'an',
            'slug' => 'panduan-tajwid-al-quran',
            'isbn' => '978-602-00-4444-4',
            'author' => 'Ustadz Abdullah',
            'stock' => 4,
            'available_stock' => 4,
            'status' => 'tersedia',
        ]);

        // Cari Python
        $response = $this->get(route('catalog.index', ['q' => 'Python']));
        $response->assertStatus(200);
        $response->assertSee('Mastering Python Data Science');
        $response->assertDontSee('Panduan Tajwid Al-Qur\'an');

        // Cari Tajwid
        $responseTajwid = $this->get(route('catalog.index', ['q' => 'Tajwid']));
        $responseTajwid->assertStatus(200);
        $responseTajwid->assertSee('Panduan Tajwid Al-Qur\'an');
        $responseTajwid->assertDontSee('Mastering Python Data Science');
    }

    /**
     * Test 4: Filter Kategori Publik
     */
    public function test_public_catalog_filter_by_category(): void
    {
        Book::create([
            'category_id' => $this->categoryTech->id,
            'rack_id' => $this->rackA->id,
            'title' => 'Algoritma Komputer',
            'slug' => 'algoritma-komputer',
            'author' => 'Penulis TI',
            'stock' => 1,
            'available_stock' => 1,
            'status' => 'tersedia',
        ]);

        Book::create([
            'category_id' => $this->categoryAgama->id,
            'rack_id' => $this->rackB->id,
            'title' => 'Fiqih Shalat Berjamaah',
            'slug' => 'fiqih-shalat-berjamaah',
            'author' => 'Penulis Agama',
            'stock' => 1,
            'available_stock' => 1,
            'status' => 'tersedia',
        ]);

        $response = $this->get(route('catalog.index', ['kategori' => 'teknologi-informasi']));
        $response->assertStatus(200);
        $response->assertSee('Algoritma Komputer');
        $response->assertDontSee('Fiqih Shalat Berjamaah');
    }

    /**
     * Test 5: Detail Buku Publik
     */
    public function test_public_catalog_book_detail(): void
    {
        $book = Book::create([
            'category_id' => $this->categoryTech->id,
            'rack_id' => $this->rackA->id,
            'title' => 'Arsitektur Cloud Computing',
            'slug' => 'arsitektur-cloud-computing',
            'isbn' => '978-602-00-5555-5',
            'author' => 'Prof. Ir. Hendra',
            'publisher' => 'Penerbit Komputer',
            'publication_year' => 2024,
            'pages' => 412,
            'stock' => 5,
            'available_stock' => 4,
            'status' => 'tersedia',
            'description' => 'Buku panduan teknologi cloud tingkat lanjut.',
        ]);

        $response = $this->get(route('catalog.show', $book->slug));
        $response->assertStatus(200);
        $response->assertSee('Arsitektur Cloud Computing');
        $response->assertSee('Prof. Ir. Hendra');
        $response->assertSee('978-602-00-5555-5');
        $response->assertSee('RAK-01');
        $response->assertSee('Teknologi Informasi');
    }

    /**
     * Test 6: Admin CRUD Kategori Buku
     */
    public function test_admin_can_crud_category(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Sains Eksakta',
            'icon' => '🔬',
            'description' => 'Fisika, Biologi, Kimia',
        ]);
        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Sains Eksakta']);

        $category = Category::where('name', 'Sains Eksakta')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.categories.update', $category->id), [
            'name' => 'Sains & Teknologi Maju',
            'icon' => '🚀',
            'description' => 'Fisika terapan dan bioteknologi',
        ]);
        $updateResponse->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', ['name' => 'Sains & Teknologi Maju']);

        // 3. Delete
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.categories.delete', $category->id));
        $deleteResponse->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    /**
     * Test 7: Admin CRUD Rak Buku
     */
    public function test_admin_can_crud_rack(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.racks.store'), [
            'code' => 'RAK-03',
            'name' => 'Rak Matematika',
            'location' => 'Lantai 2 Koridor C',
            'description' => 'Koleksi kalkulus dan aljabar linear',
        ]);
        $response->assertRedirect(route('admin.racks.index'));
        $this->assertDatabaseHas('racks', ['code' => 'RAK-03']);

        $rack = Rack::where('code', 'RAK-03')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.racks.update', $rack->id), [
            'code' => 'RAK-03-MTK',
            'name' => 'Rak Matematika & Statistik',
            'location' => 'Lantai 2 Koridor C Barat',
            'description' => 'Koleksi lengkap matematika',
        ]);
        $updateResponse->assertRedirect(route('admin.racks.index'));
        $this->assertDatabaseHas('racks', ['code' => 'RAK-03-MTK']);

        // 3. Delete
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.racks.delete', $rack->id));
        $deleteResponse->assertRedirect(route('admin.racks.index'));
        $this->assertDatabaseMissing('racks', ['id' => $rack->id]);
    }

    /**
     * Test 8: Admin CRUD Buku
     */
    public function test_admin_can_crud_book(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.books.store'), [
            'title' => 'Panduan Fullstack Developer',
            'category_id' => $this->categoryTech->id,
            'rack_id' => $this->rackA->id,
            'isbn' => '978-602-99-8877-1',
            'author' => 'Wahyu Santoso',
            'publisher' => 'Gramedia IT',
            'publication_year' => 2024,
            'pages' => 450,
            'stock' => 10,
            'status' => 'tersedia',
            'description' => 'Membangun aplikasi web dari nol.',
        ]);
        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('books', [
            'title' => 'Panduan Fullstack Developer',
            'isbn' => '978-602-99-8877-1',
            'available_stock' => 10,
        ]);

        $book = Book::where('isbn', '978-602-99-8877-1')->first();

        // 2. Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.books.update', $book->id), [
            'title' => 'Panduan Fullstack Developer Edisi Revisi',
            'category_id' => $this->categoryTech->id,
            'rack_id' => $this->rackA->id,
            'isbn' => '978-602-99-8877-1',
            'author' => 'Wahyu Santoso & Tim',
            'publisher' => 'Gramedia IT',
            'publication_year' => 2024,
            'pages' => 480,
            'stock' => 12,
            'available_stock' => 12,
            'status' => 'tersedia',
            'description' => 'Membangun aplikasi web dari nol edisi lengkap.',
        ]);
        $updateResponse->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Panduan Fullstack Developer Edisi Revisi',
            'stock' => 12,
        ]);

        // 3. Delete
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.books.delete', $book->id));
        $deleteResponse->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
