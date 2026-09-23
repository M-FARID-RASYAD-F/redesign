<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Rack;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kategori Buku
        $categoriesData = [
            [
                'name' => 'Teknologi Informasi & Komputer',
                'slug' => 'teknologi-informasi-dan-komputer',
                'description' => 'Buku-buku tentang pemrograman web, kecerdasan buatan, algoritma, rekayasa perangkat lunak, dan jaringan.',
                'icon' => '💻'
            ],
            [
                'name' => 'Agama Islam & Tahfizh',
                'slug' => 'agama-islam-dan-tahfizh',
                'description' => 'Koleksi tafsir Al-Qur\'an, fiqih ibadah, akhlak Islam, sirah nabawiyah, dan ilmu tajwid.',
                'icon' => '🕌'
            ],
            [
                'name' => 'Sains & Matematika',
                'slug' => 'sains-dan-matematika',
                'description' => 'Buku teks dan referensi fisika, biologi, kimia modern, kalkulus, dan logika matematika.',
                'icon' => '🔬'
            ],
            [
                'name' => 'Sastra & Fiksi Inspiratif',
                'slug' => 'sastra-dan-fiksi-inspiratif',
                'description' => 'Karya novel pembangun jiwa, antologi puisi, cerita anak, dan literasi bahasa Indonesia.',
                'icon' => '📚'
            ],
            [
                'name' => 'Sejarah & Sosial Budaya',
                'slug' => 'sejarah-dan-sosial-budaya',
                'description' => 'Buku sejarah peradaban dunia, kebudayaan nusantara, dan sosiologi pendidikan.',
                'icon' => '🏛️'
            ],
            [
                'name' => 'Kewirausahaan & Vokasi',
                'slug' => 'kewirausahaan-dan-vokasi',
                'description' => 'Panduan bisnis digital, tata kelola keuangan, dan keahlian kerja kejuruan modern.',
                'icon' => '📈'
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $categories[$data['slug']] = Category::firstOrCreate(['slug' => $data['slug']], $data);
        }

        // 2. Rak Buku Fisik
        $racksData = [
            [
                'code' => 'RAK-TI-01',
                'name' => 'Rak TI & Rekayasa Perangkat Lunak',
                'location' => 'Lantai 1 - Sayap Barat Baris A',
                'description' => 'Menampung buku referensi coding, rekayasa web, dan teknologi komputer.'
            ],
            [
                'code' => 'RAK-AGM-01',
                'name' => 'Rak Studi Keislaman & Qurani',
                'location' => 'Lantai 1 - Sayap Timur Baris B',
                'description' => 'Menampung kitab tafsir, hadits, dan materi pembinaan akhlak santri.'
            ],
            [
                'code' => 'RAK-SNS-01',
                'name' => 'Rak Sains & Eksakta Modern',
                'location' => 'Lantai 1 - Koridor Tengah Baris C',
                'description' => 'Buku teks matematika, fisika terapan, dan laboratorium biologi.'
            ],
            [
                'code' => 'RAK-LIT-01',
                'name' => 'Rak Literasi Sastra & Novel',
                'location' => 'Lantai 2 - Area Baca Santai',
                'description' => 'Buku fiksi bermakna, biografi tokoh teladan, dan sastra nusantara.'
            ],
            [
                'code' => 'RAK-VOK-01',
                'name' => 'Rak Vokasi & Keterampilan Industri',
                'location' => 'Lantai 2 - Pojok Vokasi',
                'description' => 'Modul kejuruan SMK, desain grafis, dan keterampilan digital.'
            ],
        ];

        $racks = [];
        foreach ($racksData as $data) {
            $racks[$data['code']] = Rack::firstOrCreate(['code' => $data['code']], $data);
        }

        // 3. Koleksi Buku
        $booksData = [
            [
                'category_slug' => 'teknologi-informasi-dan-komputer',
                'rack_code' => 'RAK-TI-01',
                'title' => 'Mastering Laravel 11 & Arsitektur Clean Code',
                'isbn' => '978-602-01-4451-1',
                'author' => 'Rasyad Fauzan, M.Kom.',
                'publisher' => 'Informatika Pratama',
                'publication_year' => 2024,
                'pages' => 380,
                'stock' => 6,
                'available_stock' => 5,
                'status' => 'tersedia',
                'description' => 'Panduan komprehensif membangun aplikasi web skala industri dengan framework Laravel, Eloquent ORM tingkat lanjut, otentikasi multi-role, dan pengujian otomatis PHPUnit.',
            ],
            [
                'category_slug' => 'teknologi-informasi-dan-komputer',
                'rack_code' => 'RAK-TI-01',
                'title' => 'Algoritma & Struktur Data Modern dengan Python',
                'isbn' => '978-602-01-8892-3',
                'author' => 'Dr. Hendra Gunawan',
                'publisher' => 'Gava Media',
                'publication_year' => 2023,
                'pages' => 320,
                'stock' => 4,
                'available_stock' => 4,
                'status' => 'tersedia',
                'description' => 'Konsep fundamental algoritma pencarian, pengurutan, grafik, tree, dynamic programming, dan analisis kompleksitas Big-O yang mudah dipahami bagi siswa kejuruan.',
            ],
            [
                'category_slug' => 'teknologi-informasi-dan-komputer',
                'rack_code' => 'RAK-VOK-01',
                'title' => 'UI/UX Design Mastery: Dari Wireframe ke High-Fidelity Design',
                'isbn' => '978-623-01-1209-8',
                'author' => 'Siti Nurhaliza, S.Ds.',
                'publisher' => 'Elex Media Komputindo',
                'publication_year' => 2024,
                'pages' => 264,
                'stock' => 5,
                'available_stock' => 3,
                'status' => 'tersedia',
                'description' => 'Teknik merancang antarmuka aplikasi berkelas dunia, psikologi warna, hierarki tipografi, sistem grid, dan aksesibilitas modern untuk platform web dan mobile.',
            ],
            [
                'category_slug' => 'agama-islam-dan-tahfizh',
                'rack_code' => 'RAK-AGM-01',
                'title' => 'Metode Muraja\'ah Efektif: Seni Menjaga Hafalan Al-Qur\'an 30 Juz',
                'isbn' => '978-979-05-3341-2',
                'author' => 'K.H. Ahmad Fauzi Ridwan',
                'publisher' => 'Pustaka Al-Kautsar',
                'publication_year' => 2022,
                'pages' => 240,
                'stock' => 10,
                'available_stock' => 8,
                'status' => 'tersedia',
                'description' => 'Langkah-langkah praktis dan spiritual dalam memperkuat hafalan Qur\'an, manajemen waktu harian santri tahfizh, dan cara mengatasi kejenuhan saat menghafal.',
            ],
            [
                'category_slug' => 'agama-islam-dan-tahfizh',
                'rack_code' => 'RAK-AGM-01',
                'title' => 'Tafsir Ayat-Ayat Sains dalam Al-Qur\'an',
                'isbn' => '978-979-05-9981-0',
                'author' => 'Prof. Dr. H. M. Quraish Shihab',
                'publisher' => 'Lentera Hati',
                'publication_year' => 2023,
                'pages' => 450,
                'stock' => 3,
                'available_stock' => 2,
                'status' => 'tersedia',
                'description' => 'Penjelasan mendalam tentang keselarasan ayat kauniyah dengan temuan sains modern seputar astronomi, embriologi manusia, dan geologi bumi.',
            ],
            [
                'category_slug' => 'sains-dan-matematika',
                'rack_code' => 'RAK-SNS-01',
                'title' => 'Fisika Terapan & Robotika untuk SMK Teknologi',
                'isbn' => '978-602-44-1290-9',
                'author' => 'Ir. Bambang Trihatmojo, M.T.',
                'publisher' => 'Yrama Widya',
                'publication_year' => 2023,
                'pages' => 310,
                'stock' => 5,
                'available_stock' => 5,
                'status' => 'tersedia',
                'description' => 'Materi terintegrasi antara mekanika gerak, hukum kelistrikan, sensor IoT, serta implementasi kendali mikrokontroler Arduino dan Raspberry Pi.',
            ],
            [
                'category_slug' => 'sastra-dan-fiksi-inspiratif',
                'rack_code' => 'RAK-LIT-01',
                'title' => 'Negeri 5 Menara (Edisi Khusus Pelajar)',
                'isbn' => '978-979-22-4861-6',
                'author' => 'A. Fuadi',
                'publisher' => 'Gramedia Pustaka Utama',
                'publication_year' => 2021,
                'pages' => 424,
                'stock' => 8,
                'available_stock' => 7,
                'status' => 'tersedia',
                'description' => 'Kisah inspiratif tentang perjuangan enam santri dari berbagai pelosok Indonesia di pondok pesantren yang bertekad menaklukkan impian dunia dengan mantra Man Jadda Wajada.',
            ],
            [
                'category_slug' => 'kewirausahaan-dan-vokasi',
                'rack_code' => 'RAK-VOK-01',
                'title' => 'Kewirausahaan Santri Era Digital: Startup & Marketplace',
                'isbn' => '978-623-01-7712-4',
                'author' => 'Muhammad Ilham Robbani, M.B.A.',
                'publisher' => 'Andi Publisher',
                'publication_year' => 2024,
                'pages' => 210,
                'stock' => 4,
                'available_stock' => 4,
                'status' => 'tersedia',
                'description' => 'Strategi memulai bisnis mandiri dari bangku sekolah, permodalan etis syariah, branding media sosial, dan ekosistem digital untuk produk lokal.',
            ],
        ];

        foreach ($booksData as $bData) {
            $cat = $categories[$bData['category_slug']] ?? null;
            $rack = $racks[$bData['rack_code']] ?? null;

            if ($cat && $rack) {
                $slug = Str::slug($bData['title']);
                Book::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'category_id' => $cat->id,
                        'rack_id' => $rack->id,
                        'title' => $bData['title'],
                        'slug' => $slug,
                        'isbn' => $bData['isbn'],
                        'author' => $bData['author'],
                        'publisher' => $bData['publisher'],
                        'publication_year' => $bData['publication_year'],
                        'pages' => $bData['pages'],
                        'stock' => $bData['stock'],
                        'available_stock' => $bData['available_stock'],
                        'status' => $bData['status'],
                        'description' => $bData['description'],
                    ]
                );
            }
        }
    }
}
