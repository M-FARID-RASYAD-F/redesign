<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\LibraryMember;
use App\Models\BookLoan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PerpusSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun petugas perpustakaan
        User::updateOrCreate(
            ['email' => 'perpus@sekolah.sch.id'],
            [
                'name'      => 'Petugas Perpustakaan',
                'password'  => bcrypt('password123'),
                'role'      => 'admin_perpus',
                'is_active' => true,
            ]
        );

        // 2. Kategori & buku contoh
        $categories = ['Fiksi', 'Sains & Teknologi', 'Sejarah', 'Agama'];
        $categoryModels = [];
        foreach ($categories as $name) {
            $categoryModels[$name] = BookCategory::firstOrCreate(
                ['slug' => Str::slug($name)], ['name' => $name]
            );
        }

        $books = [
            ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'category' => 'Fiksi', 'rack' => 'Rak A-01'],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'category' => 'Sains & Teknologi', 'rack' => 'Rak B-02'],
            ['title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'category' => 'Sejarah', 'rack' => 'Rak C-03'],
        ];
        $bookModels = [];
        foreach ($books as $b) {
            $bookModels[] = Book::firstOrCreate(
                ['title' => $b['title']],
                [
                    'category_id'   => $categoryModels[$b['category']]->id,
                    'author'        => $b['author'],
                    'stock'         => 3,
                    'available'     => 2, // 1 sedang dipinjam di bawah
                    'rack_location' => $b['rack'],
                ]
            );
        }

        // 3. Anggota & peminjaman contoh
        $year = date('Y');
        $member = LibraryMember::firstOrCreate(
            ['phone' => '081200001111'],
            [
                'full_name'   => 'Contoh Anggota',
                'member_code' => 'ANG-' . $year . '-0001',
                'joined_at'   => now(),
            ]
        );

        BookLoan::firstOrCreate(
            ['member_id' => $member->id, 'book_id' => $bookModels[0]->id],
            [
                'loan_code'   => 'PINJAM-' . $year . '-0001',
                'status'      => 'dipinjam',
                'borrowed_at' => now()->subDays(3),
                'due_at'      => now()->addDays(4),
            ]
        );
    }
}
