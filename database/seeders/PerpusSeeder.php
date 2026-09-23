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
        // 1. Akun Petugas Perpustakaan
        User::updateOrCreate(
            ['email' => 'perpus@sekolah.sch.id'],
            [
                'name'      => 'Ust. Ahmad Fauzan, S.I.Pust. (Pustakawan)',
                'password'  => bcrypt('password123'),
                'role'      => 'admin_perpus',
                'is_active' => true,
            ]
        );

        // 2. Kategori Buku Lengkap
        $categoriesData = [
            ['name' => 'Al-Qur\'an & Tafsir', 'slug' => 'alquran-tafsir'],
            ['name' => 'Hadits & Fiqih', 'slug' => 'hadits-fiqih'],
            ['name' => 'Sains & Teknologi', 'slug' => 'sains-teknologi'],
            ['name' => 'Sejarah Islam & Peradaban', 'slug' => 'sejarah-islam-peradaban'],
            ['name' => 'Sastra & Fiksi Inspiratif', 'slug' => 'sastra-fiksi-inspiratif'],
            ['name' => 'Pengembangan Diri & Karakter', 'slug' => 'pengembangan-diri-karakter'],
            ['name' => 'Bisnis & Kewirausahaan', 'slug' => 'bisnis-kewirausahaan'],
            ['name' => 'Ensiklopedia & Referensi Umum', 'slug' => 'ensiklopedia-referensi-umum'],
        ];

        $categoryModels = [];
        foreach ($categoriesData as $c) {
            $cat = BookCategory::firstOrCreate(
                ['slug' => $c['slug']],
                ['name' => $c['name']]
            );
            $categoryModels[$c['slug']] = $cat;
        }

        // 3. Koleksi Buku Kaya & Realistis (18 Judul Lengkap)
        $booksData = [
            [
                'title'         => 'Tafsir Al-Azhar (Jilid Lengkap)',
                'author'        => 'Prof. Dr. Buya Hamka',
                'publisher'     => 'Gema Insani Press',
                'category_slug' => 'alquran-tafsir',
                'isbn'          => '978-602-250-718-4',
                'rack'          => 'Rak A-01',
                'stock'         => 6,
                'available'     => 4,
                'synopsis'      => 'Mahakarya tafsir fenomenal khas Nusantara karya Buya Hamka yang menggabungkan kedalaman ilmu tafsir klasik dengan analisis sosial kemasyarakatan modern.',
            ],
            [
                'title'         => 'Menghafal Al-Qur\'an Itu Mudah: Kaidah 3T',
                'author'        => 'Ustadz Adi Hidayat, Lc., M.A.',
                'publisher'     => 'Quantum Akhyar Institute',
                'category_slug' => 'alquran-tafsir',
                'isbn'          => '978-602-51204-1-1',
                'rack'          => 'Rak A-02',
                'stock'         => 8,
                'available'     => 6,
                'synopsis'      => 'Panduan metodologis praktis menghafal Al-Qur\'an secara mutqin dan menyenangkan melalui kaidah Talqin, Tikrar, dan Tasmi\', sangat cocok untuk santri tahfizh.',
            ],
            [
                'title'         => 'Ringkasan Shahih Al-Bukhari',
                'author'        => 'Imam Az-Zabidi',
                'publisher'     => 'Pustaka As-Sunnah',
                'category_slug' => 'hadits-fiqih',
                'isbn'          => '978-979-3772-45-8',
                'rack'          => 'Rak A-03',
                'stock'         => 5,
                'available'     => 3,
                'synopsis'      => 'Ikhtisar komprehensif hadits-hadits shahih pilihan dari kitab Al-Jami\' Ash-Shahih Al-Bukhari, disusun secara tematik untuk memudahkan telaah hukum harian.',
            ],
            [
                'title'         => 'Fiqih Sunnah Sayyid Sabiq',
                'author'        => 'Sayyid Sabiq',
                'publisher'     => 'Pena Pundi Aksara',
                'category_slug' => 'hadits-fiqih',
                'isbn'          => '978-979-24-5801-5',
                'rack'          => 'Rak A-04',
                'stock'         => 4,
                'available'     => 4,
                'synopsis'      => 'Rujukan fiqih ibadah dan muamalah kontemporer berbasis dalil shahih yang menyajikan komparasi madzhab secara objektif, lugas, dan moderat.',
            ],
            [
                'title'         => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author'        => 'Robert C. Martin (Uncle Bob)',
                'publisher'     => 'Prentice Hall',
                'category_slug' => 'sains-teknologi',
                'isbn'          => '978-013-235088-4',
                'rack'          => 'Rak B-01',
                'stock'         => 6,
                'available'     => 4,
                'synopsis'      => 'Panduan legendaris bagi software developer mengenai tata cara menulis kode yang bersih, mudah dibaca, dirawat, dan berstandar industri kelas dunia.',
            ],
            [
                'title'         => 'Arsitektur Jaringan Komputer & Cloud Infrastructure',
                'author'        => 'Dr. Ir. Onno W. Purbo, M.Eng.',
                'publisher'     => 'Andi Publisher',
                'category_slug' => 'sains-teknologi',
                'isbn'          => '978-623-01-0892-1',
                'rack'          => 'Rak B-02',
                'stock'         => 7,
                'available'     => 5,
                'synopsis'      => 'Panduan praktis perancangan jaringan komputer skala enterprise, routing BGP, administrasi server Linux, serta penerapan virtualisasi cloud computing modern.',
            ],
            [
                'title'         => 'Desain Komunikasi Visual & UI/UX Design System',
                'author'        => 'Arif Pratama & Tim Studio Kreatif',
                'publisher'     => 'Elex Media Komputindo',
                'category_slug' => 'sains-teknologi',
                'isbn'          => '978-602-04-9812-3',
                'rack'          => 'Rak B-03',
                'stock'         => 5,
                'available'     => 3,
                'synopsis'      => 'Konsep fundamental desain visual, tipografi digital, perancangan antarmuka pengguna (UI), dan riset pengalaman pengguna (UX) untuk aplikasi web dan mobile.',
            ],
            [
                'title'         => 'Sapiens: Riwayat Singkat Umat Manusia',
                'author'        => 'Yuval Noah Harari',
                'publisher'     => 'Kepustakaan Populer Gramedia',
                'category_slug' => 'sejarah-islam-peradaban',
                'isbn'          => '978-602-424-416-3',
                'rack'          => 'Rak C-01',
                'stock'         => 5,
                'available'     => 4,
                'synopsis'      => 'Eksplorasi mendalam mengenai evolusi biologis dan sosiologis peradaban manusia dari zaman prasejarah hingga peradaban modern berbasis kecerdasan buatan.',
            ],
            [
                'title'         => 'Sejarah Peradaban Islam: Kejayaan & Dinamika',
                'author'        => 'Dr. Badri Yatim, M.A.',
                'publisher'     => 'Rajawali Pers',
                'category_slug' => 'sejarah-islam-peradaban',
                'isbn'          => '978-979-421-337-7',
                'rack'          => 'Rak C-02',
                'stock'         => 6,
                'available'     => 5,
                'synopsis'      => 'Rekam jejak kebangkitan peradaban Islam sejak masa Khulafaur Rasyidin, Bani Umayyah, Bani Abbasiyah, Andalusia hingga pengaruh keilmuannya ke Nusantara.',
            ],
            [
                'title'         => 'Laskar Pelangi',
                'author'        => 'Andrea Hirata',
                'publisher'     => 'Bentang Pustaka',
                'category_slug' => 'sastra-fiksi-inspiratif',
                'isbn'          => '978-979-1227-81-0',
                'rack'          => 'Rak D-01',
                'stock'         => 6,
                'available'     => 4,
                'synopsis'      => 'Kisah inspiratif sepuluh anak Belitong yang berjuang mengejar mimpi dan asa pendidikan di tengah segala keterbatasan fasilitas sekolah pedalaman.',
            ],
            [
                'title'         => 'Negeri 5 Menara',
                'author'        => 'Ahmad Fuadi',
                'publisher'     => 'Gramedia Pustaka Utama',
                'category_slug' => 'sastra-fiksi-inspiratif',
                'isbn'          => '978-979-22-4861-6',
                'rack'          => 'Rak D-02',
                'stock'         => 5,
                'available'     => 3,
                'synopsis'      => 'Catatan perjalanan enam santri di Pondok Madani dengan filosofi agung Man Jadda Wajada, membuktikan kedahsyatan impian yang dilandasi kesungguhan.',
            ],
            [
                'title'         => 'Bumi (Serial Dunia Paralel)',
                'author'        => 'Tere Liye',
                'publisher'     => 'Gramedia Pustaka Utama',
                'category_slug' => 'sastra-fiksi-inspiratif',
                'isbn'          => '978-602-03-3295-6',
                'rack'          => 'Rak D-03',
                'stock'         => 3,
                'available'     => 0, // Sengaja 0 stok tersedia untuk testing state "Stok Habis"
                'synopsis'      => 'Petualangan fantastis tiga remaja yang menemukan dunia paralel klan bulan dengan kekuatan rahasia dan persahabatan yang tak terpisahkan.',
            ],
            [
                'title'         => 'Atomic Habits: Perubahan Kecil Berdampak Besar',
                'author'        => 'James Clear',
                'publisher'     => 'Gramedia Pustaka Utama',
                'category_slug' => 'pengembangan-diri-karakter',
                'isbn'          => '978-602-06-3317-6',
                'rack'          => 'Rak E-01',
                'stock'         => 6,
                'available'     => 4,
                'synopsis'      => 'Kerangka praktis berbasis sains psikologi untuk membentuk kebiasaan baik, mengikis kebiasaan buruk, dan menguasai aksi kecil harian penentu kemajuan hidup.',
            ],
            [
                'title'         => '7 Keajaiban Rezeki & Percepatan Sukses',
                'author'        => 'Ippho Santosa',
                'publisher'     => 'Elex Media Komputindo',
                'category_slug' => 'pengembangan-diri-karakter',
                'isbn'          => '978-979-27-7241-8',
                'rack'          => 'Rak E-02',
                'stock'         => 5,
                'available'     => 4,
                'synopsis'      => 'Pendekatan otak kanan dan prinsip spiritualitas Islami dalam mempercepat pencapaian impian, kelimpahan rezeki, serta harmoni kesuksesan hidup berkelanjutan.',
            ],
            [
                'title'         => 'The Lean Startup: Inovasi Bisnis Berkelanjutan',
                'author'        => 'Eric Ries',
                'publisher'     => 'Kepustakaan Populer Gramedia',
                'category_slug' => 'bisnis-kewirausahaan',
                'isbn'          => '978-602-424-690-7',
                'rack'          => 'Rak F-01',
                'stock'         => 4,
                'available'     => 3,
                'synopsis'      => 'Metodologi pengembangan produk dan startup rintisan berbasis eksperimen tervalidasi, iterasi cepat, serta efisiensi modal dan sumber daya.',
            ],
            [
                'title'         => 'Wirausaha Berkah: Sukses Bisnis Ala Entrepreneur Muslim',
                'author'        => 'Dr. M. Syafii Antonio, M.Ec.',
                'publisher'     => 'Tazkia Publishing',
                'category_slug' => 'bisnis-kewirausahaan',
                'isbn'          => '978-979-158-123-3',
                'rack'          => 'Rak F-02',
                'stock'         => 5,
                'available'     => 4,
                'synopsis'      => 'Meneladani etika dan strategi bisnis Rasulullah SAW serta para sahabat dalam membangun konglomerasi niaga yang halal, adil, profesional, dan bernilai ibadah.',
            ],
            [
                'title'         => 'Ensiklopedia Sains & Teknologi Populer',
                'author'        => 'Tim Editor Dorling Kindersley',
                'publisher'     => 'Penerbit Erlangga',
                'category_slug' => 'ensiklopedia-referensi-umum',
                'isbn'          => '978-979-015-882-5',
                'rack'          => 'Rak G-01',
                'stock'         => 4,
                'available'     => 3,
                'synopsis'      => 'Referensi visual ensiklopedis lengkap memuat rekam jejak penemuan ilmiah terbesar dunia, eksplorasi antariksa, robotika, dan rekayasa genetika.',
            ],
            [
                'title'         => 'Atlas Sejarah Dunia Islam',
                'author'        => 'Dr. Syauqi Abu Khalil',
                'publisher'     => 'Al-Mahira',
                'category_slug' => 'ensiklopedia-referensi-umum',
                'isbn'          => '978-979-1254-04-5',
                'rack'          => 'Rak G-02',
                'stock'         => 4,
                'available'     => 3,
                'synopsis'      => 'Peta kartografi dan visualisasi geografis perjalanan dakwah, rute perdagangan sutra, serta ekspansi peradaban keilmuan Islam lintas benua.',
            ],
        ];

        $bookModels = [];
        foreach ($booksData as $b) {
            $cat = $categoryModels[$b['category_slug']] ?? null;
            $bookModels[$b['title']] = Book::updateOrCreate(
                ['title' => $b['title']],
                [
                    'category_id'   => $cat?->id,
                    'author'        => $b['author'],
                    'publisher'     => $b['publisher'],
                    'isbn'          => $b['isbn'],
                    'rack_location' => $b['rack'],
                    'stock'         => $b['stock'],
                    'available'     => $b['available'],
                    'synopsis'      => $b['synopsis'],
                ]
            );
        }

        // 4. Data Anggota Perpustakaan Realistis
        $year = date('Y');
        $membersData = [
            [
                'name'    => 'Muhammad Rifqi Pratama',
                'phone'   => '081211112222',
                'code'    => 'ANG-' . $year . '-0001',
                'address' => 'Jl. Merdeka No. 10, Pekanbaru',
            ],
            [
                'name'    => 'Siti Aisyah Nurhaliza',
                'phone'   => '081233334444',
                'code'    => 'ANG-' . $year . '-0002',
                'address' => 'Jl. Hangtuah No. 42, Pekanbaru',
            ],
            [
                'name'    => 'Fadhil Rahman Al-Farisi',
                'phone'   => '081255556666',
                'code'    => 'ANG-' . $year . '-0003',
                'address' => 'Jl. HR. Soebrantas Km. 11, Pekanbaru',
            ],
            [
                'name'    => 'Zahra Amelia Putri',
                'phone'   => '081277778888',
                'code'    => 'ANG-' . $year . '-0004',
                'address' => 'Jl. Kaharuddin Nasution No. 55, Pekanbaru',
            ],
            [
                'name'    => 'Farhan Dwi Alamsyah',
                'phone'   => '081299990000',
                'code'    => 'ANG-' . $year . '-0005',
                'address' => 'Jl. Tuanku Tambusai No. 88, Pekanbaru',
            ],
        ];

        $memberModels = [];
        foreach ($membersData as $m) {
            $memberModels[] = LibraryMember::updateOrCreate(
                ['member_code' => $m['code']],
                [
                    'full_name'   => $m['name'],
                    'phone'       => $m['phone'],
                    'address'     => $m['address'],
                    'joined_at'   => now()->subMonths(3),
                ]
            );
        }

        // 5. Data Peminjaman Buku Beragam Status (diajukan, dipinjam, dikembalikan, terlambat)
        $loansData = [
            [
                'code'        => 'PINJAM-' . $year . '-0001',
                'member_idx'  => 0,
                'book_title'  => 'Tafsir Al-Azhar (Jilid Lengkap)',
                'status'      => 'dipinjam',
                'borrowed_at' => now()->subDays(3),
                'due_at'      => now()->addDays(4),
                'returned_at' => null,
                'notes'       => 'Peminjaman aktif untuk bahan riset karya tulis tahfizh santri.',
            ],
            [
                'code'        => 'PINJAM-' . $year . '-0002',
                'member_idx'  => 1,
                'book_title'  => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'status'      => 'diajukan',
                'borrowed_at' => now(),
                'due_at'      => now()->addDays(7),
                'returned_at' => null,
                'notes'       => 'Pengajuan online santri jurusan Rekayasa Perangkat Lunak.',
            ],
            [
                'code'        => 'PINJAM-' . $year . '-0003',
                'member_idx'  => 2,
                'book_title'  => 'Laskar Pelangi',
                'status'      => 'dikembalikan',
                'borrowed_at' => now()->subDays(14),
                'due_at'      => now()->subDays(7),
                'returned_at' => now()->subDays(7),
                'notes'       => 'Buku dikembalikan tepat waktu dalam kondisi sangat baik.',
            ],
            [
                'code'        => 'PINJAM-' . $year . '-0004',
                'member_idx'  => 3,
                'book_title'  => 'Ringkasan Shahih Al-Bukhari',
                'status'      => 'terlambat',
                'borrowed_at' => now()->subDays(16),
                'due_at'      => now()->subDays(2),
                'returned_at' => null,
                'notes'       => 'Petugas telah mengirimkan pesan pengingat via WhatsApp.',
            ],
            [
                'code'        => 'PINJAM-' . $year . '-0005',
                'member_idx'  => 4,
                'book_title'  => 'Bumi (Serial Dunia Paralel)',
                'status'      => 'dipinjam',
                'borrowed_at' => now()->subDays(2),
                'due_at'      => now()->addDays(5),
                'returned_at' => null,
                'notes'       => 'Seluruh eksemplar judul ini sedang dipinjam santri.',
            ],
        ];

        foreach ($loansData as $l) {
            $book = $bookModels[$l['book_title']] ?? null;
            $member = $memberModels[$l['member_idx']] ?? null;

            if ($book && $member) {
                BookLoan::updateOrCreate(
                    ['loan_code' => $l['code']],
                    [
                        'member_id'   => $member->id,
                        'book_id'     => $book->id,
                        'status'      => $l['status'],
                        'borrowed_at' => $l['borrowed_at'],
                        'due_at'      => $l['due_at'],
                        'returned_at' => $l['returned_at'],
                        'notes'       => $l['notes'],
                    ]
                );
            }
        }
    }
}
