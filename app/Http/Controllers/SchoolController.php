<?php

namespace App\Http\Controllers;


use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookLoan;
use App\Models\LibraryMember;
use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\TeacherStaff;
use App\Models\PpdbRegistration;
use App\Models\PpdbDocument;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    /**
     * Menampilkan Landing Page Utama Website Sekolah
     */
    public function index()
    {
        // 1. Data Informasi Sekolah (Default fallback jika DB kosong)
        $sekolah = [
            'nama' => 'PKBM TAHFIZH ATTAMAM',
            'slogan' => 'Mencetak Generasi Qurani, Berkarakter & Siap Kerja di Era Digital',
            'deskripsi' => 'Lembaga pendidikan Islam & kejuruan terkemuka yang memadukan kurikulum industri modern, pembentukan karakter mulia, dan fasilitas pembelajaran digital.',
            'tahun_berdiri' => '2018',
            'akreditasi' => 'B (Baik)',
            'alamat' => 'Jl. Hangtuah No. 45, Tenayan Raya, Pekanbaru, Riau',
            'telepon' => '(0761) 555-0192',
            'email' => 'info@pkbmtahfizhattamam.sch.id'
        ];

        // 2. Data Sambutan Kepala Sekolah
        $kepsek = TeacherStaff::where('position', 'Kepala Sekolah')->first();
        $sambutan = [
            'nama' => $kepsek ? $kepsek->name : 'Dr. H. Ahmad Fauzi, M.Pd.',
            'jabatan' => 'Kepala PKBM Tahfizh At-Tamam',
            'pesan' => 'Selamat datang di portal resmi PKBM Tahfizh At-Tamam. Kami berdedikasi menciptakan lingkungan belajar yang inspiratif, inovatif, dan berlandaskan nilai-nilai Al-Qur\'an serta kejuruan modern.',
            'foto_initials' => 'AF'
        ];

        // 3. Data Statistik Sekolah
        $jumlahSiswa = PpdbRegistration::count() + 1250; // Simulasi dengan penambahan pendaftar
        $jumlahGuru = TeacherStaff::count();
        $jumlahJurusan = Major::count();

        $stats = [
            ['label' => 'Siswa Terdaftar', 'value' => number_format($jumlahSiswa) . '+', 'icon' => 'users', 'color' => '#00B4D8'],
            ['label' => 'Guru & Staf', 'value' => ($jumlahGuru > 0 ? $jumlahGuru : 85) . ' Pengajar', 'icon' => 'teachers', 'color' => '#10b981'],
            ['label' => 'Jenjang Pendidikan', 'value' => '3 Jenjang (SD, SMP, SMK)', 'icon' => 'school', 'color' => '#f59e0b'],
            ['label' => 'Serapan Kerja & Prestasi', 'value' => '96% Sukses', 'icon' => 'trending-up', 'color' => '#a855f7'],
        ];

        // 4. Data Jenjang Pendidikan (SD, SMP, SMK) - Dummy Data Lengkap
        $jenjang = [
            [
                'id' => 'sd',
                'kode' => 'SD',
                'nama' => 'Sekolah Dasar (SD)',
                'kategori' => 'Pendidikan Dasar & Karakter',
                'badge' => 'Fondasi Qurani',
                'badge_icon' => 'sprout',
                'deskripsi' => 'Membangun aqidah shohihah, adab islami, tahfizh juz 30 mutqin, serta dasar literasi, numerasi, dan sains eksploratif dengan suasana belajar aktif.',
                'masa_studi' => '6 Tahun',
                'fokus_kurikulum' => 'Tahfizh & Adab',
                'keunggulan_label' => 'Program Unggulan:',
                'keunggulan' => 'Tahfizh Cilik, Bilingual Dasar, Islamic Character Building, Fun Science & Math',
                'icon' => 'book-open',
                'link_daftar' => route('ppdb.create', ['jenjang' => 'sd']),
            ],
            [
                'id' => 'smp',
                'kode' => 'SMP',
                'nama' => 'Sekolah Menengah Pertama (SMP)',
                'kategori' => 'Pendidikan Menengah & Riset',
                'badge' => 'Karakter & Sains Terapan',
                'badge_icon' => 'sparkles',
                'deskripsi' => 'Penguatan tahfizh Al-Qur\'an berkesinambungan, pembentukan kepemimpinan santri, penguasaan sains terapan, serta pengenalan dasar teknologi digital.',
                'masa_studi' => '3 Tahun',
                'fokus_kurikulum' => 'Tahfizh & Sains',
                'keunggulan_label' => 'Program Unggulan:',
                'keunggulan' => 'Target 5–10 Juz Mutqin, Arabic & English Club, Basic Coding, Leadership Camp',
                'icon' => 'compass',
                'link_daftar' => route('ppdb.create', ['jenjang' => 'smp']),
            ],
            [
                'id' => 'smk',
                'kode' => 'SMK',
                'nama' => 'Sekolah Menengah Kejuruan (SMK)',
                'kategori' => 'Pendidikan Vokasi & Siap Kerja',
                'badge' => 'Keahlian Industri & Digital',
                'badge_icon' => 'rocket',
                'deskripsi' => 'Membekali keterampilan kejuruan vokasi berstandar industri (RPL, TKJ, DKV), sertifikasi BNSP/LSP, kurikulum industri, serta magang kerja nyata.',
                'masa_studi' => '3 Tahun',
                'fokus_kurikulum' => 'Industri & Vokasi',
                'keunggulan_label' => 'Program Unggulan:',
                'keunggulan' => 'Kelas Industri (RPL, TKJ, DKV), Magang Kerja (PKL), Sertifikasi BNSP, Inkubator Bisnis',
                'icon' => 'laptop',
                'link_daftar' => route('ppdb.create', ['jenjang' => 'smk']),
            ],
        ];

        // 5. Data Program Keahlian / Jurusan (Dinamis dari Database - Tetap disimpan untuk kompatibilitas)
        $jurusan = Major::all()->map(function ($item) {
            $badges = [
                'rekayasa-perangkat-lunak-rpl' => '🔥 Paling Favorit',
                'teknik-komputer-jaringan-tkj' => '🌐 Sertifikasi Cisco/Mikrotik',
                'desain-komunikasi-visual-dkv' => '🎨 Studio Kreatif Komplit',
            ];

            $prospeks = [
                'rekayasa-perangkat-lunak-rpl' => 'Fullstack Developer, Web & Mobile App Engineer',
                'teknik-komputer-jaringan-tkj' => 'Network Engineer, Cloud Admin, Cyber Security',
                'desain-komunikasi-visual-dkv' => 'Graphic Designer, UI/UX Designer, Video & Motion Animator',
            ];

            return [
                'id' => $item->slug,
                'nama' => $item->name,
                'kategori' => str_contains($item->slug, 'dkv') ? 'Industri Kreatif' : 'Teknologi Informasi',
                'deskripsi' => $item->description,
                'prospek' => $prospeks[$item->slug] ?? ('Lulusan siap kerja di bidang ' . explode(' (', $item->name)[0]),
                'badge' => $badges[$item->slug] ?? '✨ Program Unggulan',
                'icon' => $item->icon ?? '⚡'
            ];
        })->toArray();

        // Fallback jika database belum di-seed
        if (empty($jurusan)) {
            $jurusan = [
                [
                    'id' => 'rekayasa-perangkat-lunak-rpl',
                    'nama' => 'Rekayasa Perangkat Lunak (RPL)',
                    'kategori' => 'Teknologi Informasi',
                    'deskripsi' => 'Mempelajari pemrograman web (Laravel, React), aplikasi mobile, basis data, dan pengembangan software berbasis industri.',
                    'prospek' => 'Fullstack Developer, Web & Mobile App Engineer',
                    'badge' => '🔥 Paling Favorit',
                    'icon' => '⚡'
                ],
                [
                    'id' => 'teknik-komputer-jaringan-tkj',
                    'nama' => 'Teknik Komputer & Jaringan (TKJ)',
                    'kategori' => 'Teknologi Informasi',
                    'deskripsi' => 'Fokus pada arsitektur jaringan komputer, administrasi server Linux/Windows, cloud computing, dan siber security.',
                    'prospek' => 'Network Engineer, Cloud Admin, Cyber Security',
                    'badge' => '🌐 Sertifikasi Cisco/Mikrotik',
                    'icon' => '📡'
                ],
                [
                    'id' => 'desain-komunikasi-visual-dkv',
                    'nama' => 'Desain Komunikasi Visual (DKV)',
                    'kategori' => 'Industri Kreatif',
                    'deskripsi' => 'Mengembangkan kreativitas seni visual, ilustrasi digital, fotografi, videografi konten, serta desain antarmuka UI/UX masa depan.',
                    'prospek' => 'Graphic Designer, UI/UX Designer, Video & Motion Animator',
                    'badge' => '🎨 Studio Kreatif Komplit',
                    'icon' => '🎨'
                ]
            ];
        }

        // 5. Data Berita Terbaru (Dinamis dari Database)
        $localNewsImages = [
            'images/sch1.jpeg',
            'images/sch2.jpeg',
            'images/sch3.jpeg',
            'images/sch5.jpg',
        ];

        $berita = News::with('category')->latest()->take(3)->get()->values()->map(function ($item, $idx) use ($localNewsImages) {
            return [
                'id' => $item->id,
                'slug' => $item->slug ?? \Illuminate\Support\Str::slug($item->title),
                'judul' => $item->title,
                'tanggal' => $item->created_at->translatedFormat('d F Y') ?? $item->created_at->format('d M Y'),
                'kategori' => $item->category ? $item->category->name : 'Umum',
                'ringkasan' => \Illuminate\Support\Str::limit(strip_tags($item->content), 130),
                'baca_waktu' => '3 menit baca',
                'gambar' => $localNewsImages[$idx % count($localNewsImages)],
            ];
        })->toArray();

        // Fallback jika database belum di-seed
        if (empty($berita)) {
            $berita = [
                [
                    'id' => 1,
                    'slug' => 'santri-pkbm-tahfizh-attamam-raih-juara-1',
                    'judul' => 'Santri PKBM Tahfizh At-Tamam Raih Juara 1 Musabaqah Hifdzil Quran 2026',
                    'tanggal' => '28 Juli 2026',
                    'kategori' => 'Prestasi',
                    'ringkasan' => 'Santri binaan kami berhasil memboyong prestasi gemilang dalam kejuaraan tahfizh tingkat provinsi.',
                    'baca_waktu' => '3 menit baca',
                    'gambar' => 'images/sch1.jpeg',
                ]
            ];
        }

        // 6. Data Cabang-Cabang Sekolah PKBM Tahfizh At-Tamam
        $cabang = [
            [
                'id' => 'kampus-pusat',
                'label' => 'Kampus Pusat',
                'title' => 'Kampus Utama & Pusat Tahfizh At-Tamam',
                'tag' => 'KAMPUS PUSAT & ASRAMA',
                'kota' => 'Tenayan Raya, Pekanbaru',
                'alamat' => 'Jl. Hangtuah No. 45, Rejosari, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28281',
                'jam' => 'Senin – Sabtu: 07.30 – 16.30 WIB',
                'telepon' => '(0761) 555-0192',
                'wa' => '0812-7000-1920',
                'wa_url' => 'https://wa.me/6281270001920?text=Halo%20Admin%20Kampus%20Pusat%20At-Tamam,%20saya%20ingin%20informasi%20pendaftaran',
                'maps_url' => 'https://maps.google.com/?q=PKBM+Tahfizh+At-Tamam+Pekanbaru',
                'desc' => 'Pusat pendidikan terpadu At-Tamam yang menaungi program Tahfizh Qur\'an intensif 30 juz, asrama santri modern putra/putri, serta kejuruan rekayasa perangkat lunak dengan fasilitas terlengkap.',
                'image' => asset('images/sch1.jpeg'),
                'features' => [
                    'Asrama Santri Nyaman & Ber-AC',
                    'Masjid Jami\' At-Tamam 500 Jamaah',
                    'Lab Komputer High-End 120 Unit PC',
                    'Studio Podcast & Broadcast Kreatif',
                    'Klinik Kesehatan Santri & Kantin',
                    'Free WiFi High-Speed Fiber 1 Gbps'
                ]
            ],
            [
                'id' => 'cabang-panam',
                'label' => 'Cabang Panam',
                'title' => 'Cabang Panam — Sentra Teknologi & Kejuruan',
                'tag' => 'SENTRA IT & MULTIMEDIA',
                'kota' => 'Tampan / Panam, Pekanbaru',
                'alamat' => 'Jl. HR. Soebrantas Km. 12, Kel. Simpang Baru, Kec. Tampan, Kota Pekanbaru, Riau 28293',
                'jam' => 'Senin – Sabtu: 08.00 – 17.00 WIB',
                'telepon' => '(0761) 555-0193',
                'wa' => '0812-7000-1921',
                'wa_url' => 'https://wa.me/6281270001921?text=Halo%20Admin%20Cabang%20Panam%20At-Tamam,%20saya%20ingin%20tanya%20program%20kejuruan%20dan%20tahfizh',
                'maps_url' => 'https://maps.google.com/?q=HR+Soebrantas+Panam+Pekanbaru',
                'desc' => 'Sentra kejuruan digital & multimedia At-Tamam yang dirancang khusus untuk mencetak developer muda, teknisi jaringan bersertifikasi Cisco/Mikrotik, serta talenta kreatif animasi.',
                'image' => asset('images/sch2.jpeg'),
                'features' => [
                    'Smart Interactive Classrooms',
                    'Laboratorium Cyber Security & Jaringan',
                    'Studio Desain Komunikasi Visual (DKV)',
                    'Co-Working Space Siswa Ber-AC',
                    'Program Sertifikasi Industri Resmi',
                    'Area Parkir Luas & Akses Strategis'
                ]
            ],
            [
                'id' => 'cabang-marpoyan',
                'label' => 'Cabang Marpoyan',
                'title' => 'Cabang Marpoyan — Tahfizh & Kewirausahaan',
                'tag' => 'TAHFIZH & ENTREPRENEUR',
                'kota' => 'Marpoyan Damai, Pekanbaru',
                'alamat' => 'Jl. Kaharuddin Nasution No. 88, Kel. Maharatu, Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28284',
                'jam' => 'Senin – Sabtu: 07.30 – 16.30 WIB',
                'telepon' => '(0761) 555-0194',
                'wa' => '0812-7000-1922',
                'wa_url' => 'https://wa.me/6281270001922?text=Halo%20Admin%20Cabang%20Marpoyan%20At-Tamam,%20saya%20ingin%20konsultasi%20program%20tahfizh%20dan%20wirausaha',
                'maps_url' => 'https://maps.google.com/?q=Marpoyan+Damai+Pekanbaru',
                'desc' => 'Kampus asri bernuansa green campus yang menitikberatkan pada hafalan Al-Qur\'an bersanad mutqin, pembinaan adab santri, serta pelatihan kewirausahaan digital dan bisnis mandiri.',
                'image' => asset('images/sch3.jpeg'),
                'features' => [
                    'Ruang Halaqah Al-Qur\'an Sejuk & Asri',
                    'Arena Olahraga Sunnah (Panahan)',
                    'Aula Pertemuan Serbaguna (300 Seat)',
                    'Perpustakaan & Pojok Literasi Islam',
                    'Greenhouse Edukasi Botani & Agribisnis',
                    'Pengawasan Keamanan CCTV 24 Jam'
                ]
            ],
            [
                'id' => 'cabang-rumbai',
                'label' => 'Cabang Rumbai',
                'title' => 'Cabang Rumbai — Sentra Bahasa & Sains',
                'tag' => 'SAINS & BAHASA DUNIA',
                'kota' => 'Rumbai, Pekanbaru',
                'alamat' => 'Jl. Yos Sudarso No. 102, Kel. Lembah Damai, Kec. Rumbai, Kota Pekanbaru, Riau 28265',
                'jam' => 'Senin – Sabtu: 08.00 – 16.30 WIB',
                'telepon' => '(0761) 555-0195',
                'wa' => '0812-7000-1923',
                'wa_url' => 'https://wa.me/6281270001923?text=Halo%20Admin%20Cabang%20Rumbai%20At-Tamam,%20saya%20ingin%20informasi%20program%20bilingual%20dan%20paket%20belajar',
                'maps_url' => 'https://maps.google.com/?q=Rumbai+Pekanbaru',
                'desc' => 'Kampus percontohan pengembangan kompetensi dwibahasa (Arab & Inggris aktif) yang terintegrasi dengan pembelajaran sains terapan, kelas fleksibel kesetaraan Paket B/C, dan tahfizh akhir pekan.',
                'image' => asset('images/sch5.jpg'),
                'features' => [
                    'Laboratorium Bahasa Digital Interaktif',
                    'Pusat Belajar Paket Kesetaraan Fleksibel',
                    'Ruang Multimedia & Presentasi Audio',
                    'Musholla Kampus yang Bersih & Luas',
                    'Area Diskusi Terbuka Siswa Berpohon',
                    'Konseling & Bimbingan Minat Karir'
                ]
            ]
        ];

        // Alias untuk kompatibilitas data view lama
        $fasilitas = $cabang;

        // 7. Data Galeri Fasilitas Kampus
        $galeriFasilitas = [
            [
                'id' => 1,
                'title' => 'Masjid Jami\' & Pusat Halaqah Tahfizh',
                'category' => 'ibadah',
                'category_label' => 'Tahfizh & Masjid',
                'image' => asset('images/sch1.jpeg'),
                'desc' => 'Pusat kegiatan ibadah, halaqah quran, dan tasmi\' hafalan 30 juz santri.'
            ],
            [
                'id' => 2,
                'title' => 'Laboratorium Komputer & Software Studio',
                'category' => 'lab',
                'category_label' => 'Laboratorium IT',
                'image' => asset('images/sch2.jpeg'),
                'desc' => '120 workstation high-end untuk praktikum coding, software web/mobile, dan cloud.'
            ],
            [
                'id' => 3,
                'title' => 'Perpustakaan & Ruang Baca Digital',
                'category' => 'akademik',
                'category_label' => 'Ruang Belajar',
                'image' => asset('images/sch3.jpeg'),
                'desc' => 'Koleksi kitab rujukan Islam, literatur sains modern, dan pojok e-library.'
            ],
            [
                'id' => 4,
                'title' => 'Gedung Kampus Utama & Hall Serbaguna',
                'category' => 'kampus',
                'category_label' => 'Kampus Utama',
                'image' => asset('images/sch5.jpg'),
                'desc' => 'Ruang kelas interaktif ber-AC dengan pencahayaan alami dan lingkungan sejuk.'
            ],
            [
                'id' => 5,
                'title' => 'Asrama Santri Modern & Hunian Ber-AC',
                'category' => 'asrama',
                'category_label' => 'Asrama & Boarding',
                'image' => asset('images/hero-campus.jpg'),
                'desc' => 'Hunian santri kondusif dengan pendampingan musyrif 24 jam dan sanitasi bersih.'
            ],
            [
                'id' => 6,
                'title' => 'Studio Kreatif Multimedia & Desain DKV',
                'category' => 'lab',
                'category_label' => 'Laboratorium IT',
                'image' => asset('images/sch2.jpeg'),
                'desc' => 'Perangkat kamera profesional, render station, editing video, dan studio podcast.'
            ]
        ];

        // 8. Data Testimoni Wali Santri & Alumni Sukses
        $testimoni = [
            [
                'name' => 'Ustadz H. Hendra Kurniawan, S.Pd.I',
                'role' => 'Wali Santri SD Tahfizh, putra mutqin Juz 29 & 30',
                'rating' => 5,
                'quote' => 'Alhamdulillah, dalam 2 tahun anak kami di SD At-Tamam hafalan Juz 30 dan Juz 29 sudah mutqin. Yang paling membahagiakan, akhlak dan adab kesehariannya terhadap orang tua sangat santun.',
                'avatar_initials' => 'HK',
                'badge' => 'Wali Santri SD'
            ],
            [
                'name' => 'Muhammad Farhan Al-Fatih',
                'role' => 'Alumni Tahfizh 30 Juz, kini di Al-Azhar Kairo',
                'rating' => 5,
                'quote' => 'Fondasi bahasa Arab dan hafalan Al-Qur\'an 30 Juz yang saya peroleh selama di At-Tamam menjadi modal berharga saat mengikuti seleksi beasiswa ke Universitas Al-Azhar Mesir.',
                'avatar_initials' => 'MF',
                'badge' => 'Alumni Tahfizh 30 Juz'
            ],
            [
                'name' => 'Rizky Pratama',
                'role' => 'Alumni SMK RPL, kini Software Engineer di Tech Studio',
                'rating' => 5,
                'quote' => 'Kurikulum vokasi di SMK At-Tamam sangat aplikatif. Kami langsung mendalami tech stack modern Laravel dan React. Sebelum wisuda pun saya sudah mulai bekerja di industri digital.',
                'avatar_initials' => 'RP',
                'badge' => 'Alumni SMK RPL'
            ],
            [
                'name' => 'dr. Hj. Nurul Hidayah, Sp.A',
                'role' => 'Wali Santri Boarding School, Dokter Spesialis Anak',
                'rating' => 5,
                'quote' => 'Sebagai orang tua yang bekerja, kami sangat tenang mempercayakan pendidikan putra kami di Boarding At-Tamam. Fasilitas asrama bersih, makanan bergizi, dan ibadah terpantau ketat.',
                'avatar_initials' => 'NH',
                'badge' => 'Wali Santri Boarding'
            ]
        ];

        // Kirim seluruh data ke view 'welcome'
        return view('welcome', compact('sekolah', 'sambutan', 'stats', 'jenjang', 'jurusan', 'berita', 'fasilitas', 'cabang', 'galeriFasilitas', 'testimoni'));
    }

    /**
     * ========================================================
     * MODUL PPDB MANDIRI PUBLIK (PRD 2.5.3 & SAD 3.5.1)
     * ========================================================
     */

    /**
     * Halaman Informasi Utama PPDB Online (Alur, Jadwal, Persyaratan, Kuota)
     */
    public function ppdbIndex()
    {
        $majors = Major::all();
        $totalPendaftar = PpdbRegistration::count() + 85;
        $totalDiterima = PpdbRegistration::where('status', 'diterima')->count() + 60;

        $stats = [
            'total' => $totalPendaftar,
            'diterima' => $totalDiterima,
            'gelombang' => 'Gelombang I (Tahun Ajaran 2026/2027)',
            'deadline' => '30 September 2026'
        ];

        // Data FAQ Komprehensif PPDB
        $faqs = [
            [
                'q' => 'Apakah ijazah lulusan PKBM Tahfizh At-Tamam resmi dan diakui negara?',
                'a' => 'Ya, 100% resmi di bawah naungan Kemendikbudristek RI. Ijazah kelulusan berstatus setara formal dan memiliki hak serta legalitas yang sama untuk melanjutkan ke Perguruan Tinggi Negeri (SNBP/SNBT/SPAN-PTKIN), Perguruan Tinggi Kedinasan, maupun universitas internasional serta melamar pekerjaan formal.',
                'category' => 'Akademik'
            ],
            [
                'q' => 'Berapa target hafalan Al-Qur\'an untuk masing-masing jenjang (SD, SMP, SMK)?',
                'a' => 'Jenjang SD ditargetkan minimal 3-5 Juz mutqin (Juz 30, 29, 28) beserta kaidah tajwid dasar. Jenjang SMP ditargetkan minimal 5–10 Juz mutqin bersanad. Sedangkan jenjang SMK ditargetkan minimal 3-5 Juz dengan kelas khusus takhasus 30 Juz bagi santri yang berkeinginan menuntaskan hafalan.',
                'category' => 'Tahfizh'
            ],
            [
                'q' => 'Bagaimana syarat dan ketentuan Beasiswa Tahfizh 30 Juz?',
                'a' => 'Beasiswa Tahfizh 30 Juz diberikan kepada calon santri yang telah menyelesaikan hafalan 30 Juz dengan baik. Setelah lulus uji tasmi\' panitia seleksi, santri berhak memperoleh Beasiswa Bebas Uang Pangkal 100% dan Bebas SPP Bulanan 100% selama masa belajar dengan komitmen muraja\'ah aktif.',
                'category' => 'Beasiswa'
            ],
            [
                'q' => 'Apakah santri diwajibkan tinggal di asrama (Boarding) atau boleh Full Day?',
                'a' => 'Jenjang SD diselenggarakan dalam format Full Day School (07.30 - 15.30 WIB). Untuk jenjang SMP dan SMK, calon santri dan wali santri bebas memilih antara program Full Day School atau Islamic Boarding School (Asrama ber-AC dengan pendampingan musyrif 24 jam).',
                'category' => 'Fasilitas'
            ],
            [
                'q' => 'Bagaimana tahapan seleksi masuk PPDB dan materi apa saja yang diujikan?',
                'a' => 'Tahapan seleksi terdiri dari: 1) Verifikasi berkas administrasi digital, 2) Uji observasi bacaan Al-Qur\'an & tes hafalan, 3) Tes potensi dasar dan minat bakat, serta 4) Sesi wawancara komitmen orang tua/wali santri.',
                'category' => 'Seleksi'
            ],
            [
                'q' => 'Apakah tersedia layanan antar-jemput bagi santri Full Day di wilayah Pekanbaru?',
                'a' => 'Ya, kami menyediakan armada antar-jemput resmi ber-AC yang melayani rute Tenayan Raya, Sukajadi, Tampan/Panam, Marpoyan Damai, Bukit Raya, dan sekitarnya dengan tarif bulanan terjangkau sesuai zona.',
                'category' => 'Layanan'
            ],
            [
                'q' => 'Bagaimana cara konfirmasi setelah mengisi formulir pendaftaran online?',
                'a' => 'Setelah menyelesaikan pendaftaran, sistem akan otomatis menerbitkan Nomor Registrasi resmi (contoh: PPDB-2026-0001). Anda dapat mencetak kartu bukti atau menghubungi Panitia PPDB via WhatsApp resmi untuk jadwal tes wawancara dan observasi.',
                'category' => 'Alur'
            ]
        ];

        return view('ppdb.index', compact('majors', 'stats', 'faqs'));
    }

    /**
     * Halaman Formulir Pendaftaran Siswa Baru Mandiri
     */
    public function ppdbCreate(Request $request)
    {
        $selectedJenjang = strtolower($request->query('jenjang', ''));
        if (!in_array($selectedJenjang, ['sd', 'smp', 'smk'])) {
            $selectedJenjang = null;
        }
        $majors = Major::all();
        return view('ppdb.create', compact('majors', 'selectedJenjang'));
    }

    /**
     * Memproses Pengiriman Formulir Pendaftaran PPDB Online Mandiri
     */
    public function ppdbStore(Request $request)
    {
        $validated = $request->validate([
            // Pilihan Jenjang & Jurusan
            'jenjang' => 'required|in:sd,smp,smk',
            'major_choice' => 'nullable|string|max:100',

            // Data Calon Siswa
            'full_name' => 'required|string|min:3|max:255',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date|before:today',
            'address' => 'required|string|min:8',

            // Data Orang Tua / Wali
            'parent_name' => 'required|string|min:3|max:255',
            'parent_phone' => 'required|string|min:9|max:20',

            // Dokumen Persyaratan (Max 3MB per file)
            'doc_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'doc_akta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:3072',
            'doc_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:3072',
            'doc_rapor' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:3072',

            // Pernyataan UU PDP & Kebenaran Data
            'agreement' => 'accepted',
        ], [
            'jenjang.required' => 'Pilih tingkatan / jenjang pendidikan (SD, SMP, atau SMK).',
            'jenjang.in' => 'Pilihan jenjang pendidikan tidak valid.',

            'full_name.required' => 'Nama lengkap calon siswa wajib diisi.',
            'full_name.min' => 'Nama lengkap minimal 3 karakter.',

            'gender.required' => 'Pilih jenis kelamin calon siswa.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before' => 'Tanggal lahir tidak valid.',

            'address.required' => 'Alamat tempat tinggal lengkap wajib diisi.',
            'address.min' => 'Alamat minimal 8 karakter.',

            'parent_name.required' => 'Nama orang tua / wali wajib diisi.',
            'parent_phone.required' => 'Nomor WhatsApp / telepon orang tua wajib diisi.',

            'doc_kk.mimes' => 'Kartu Keluarga harus berformat PDF, JPG, atau PNG.',
            'doc_kk.max' => 'Ukuran file Kartu Keluarga maksimal 3MB.',

            'doc_akta.mimes' => 'Akta Kelahiran harus berformat PDF, JPG, atau PNG.',
            'doc_akta.max' => 'Ukuran file Akta Kelahiran maksimal 3MB.',

            'doc_foto.mimes' => 'Pas Foto harus berformat JPG atau PNG.',
            'doc_foto.max' => 'Ukuran file Pas Foto maksimal 3MB.',

            'doc_rapor.mimes' => 'Rapor terakhir harus berformat PDF, JPG, atau PNG.',
            'doc_rapor.max' => 'Ukuran file Rapor maksimal 3MB.',
            'agreement.accepted' => 'Anda wajib menyetujui pernyataan kebenaran data dan kebijakan privasi.',
        ]);

        // Simpan data pendaftaran (Sanitasi data masukan dari karakter berbahaya/tag HTML)
        $registration = PpdbRegistration::create([
            'jenjang' => $validated['jenjang'],
            'major_choice' => $validated['jenjang'] === 'smk' && !empty($request->input('major_choice'))
                ? strip_tags(trim($request->input('major_choice')))
                : null,
            'full_name' => strip_tags(trim($validated['full_name'])),
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
            'address' => strip_tags(trim($validated['address'])),
            'parent_name' => strip_tags(trim($validated['parent_name'])),
            'parent_phone' => preg_replace('/[^0-9\+\-\s]/', '', $validated['parent_phone']),
            'status' => 'pending',
            'notes' => 'Pendaftaran online mandiri berhasil diajukan. Menunggu verifikasi berkas oleh panitia PPDB.',
        ]);

        // Upload Dokumen Pendukung ke Private Disk (Storage local/private) demi keamanan privasi berkas
        $docMapping = [
            'doc_kk' => 'kk',
            'doc_akta' => 'akta_lahir',
            'doc_foto' => 'foto',
            'doc_rapor' => 'rapor_terakhir',
        ];

        foreach ($docMapping as $field => $type) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('ppdb_documents', 'local');
                PpdbDocument::create([
                    'registration_id' => $registration->id,
                    'doc_type' => $type,
                    'file_path' => $path,
                    'verification_status' => 'belum_diverifikasi',
                ]);
            }
        }

        // Catat Audit Trail
        ActivityLog::create([
            'user_id' => null,
            'module' => 'ppdb',
            'action' => 'create',
            'description' => "Pendaftaran PPDB mandiri ({$registration->jenjang_label}) berhasil diajukan oleh {$registration->full_name} (No: {$registration->no_pendaftaran})",
        ]);

        // Berikan izin akses sesi untuk melihat bukti pendaftaran yang baru saja dibuat
        session(['submitted_ppdb_no' => $registration->no_pendaftaran]);

        return redirect()->route('ppdb.success', $registration->no_pendaftaran);
    }

    /**
     * Halaman Sukses Pendaftaran & Bukti Registrasi Digital
     */
    public function ppdbSuccess(Request $request, $no_pendaftaran)
    {
        $registration = PpdbRegistration::with('documents')->where('no_pendaftaran', $no_pendaftaran)->firstOrFail();

        // Otorisasi: hanya pengaju pada sesi pendaftaran/lacak status saat ini atau admin yang dapat membuka kartu bukti
        $isAuthorizedSession = session('submitted_ppdb_no') === $no_pendaftaran
            || session('verified_tracking_no') === $no_pendaftaran
            || Auth::check();

        if (!$isAuthorizedSession) {
            return redirect()->route('ppdb.tracking')
                ->with('error', 'Sesi akses bukti pendaftaran tidak ditemukan atau telah kedaluwarsa. Silakan cari nomor pendaftaran Anda melalui form di bawah ini.');
        }

        return view('ppdb.success', compact('registration'));
    }

    /**
     * Halaman Lacak / Tracking Status PPDB Mandiri
     */
    public function ppdbTracking()
    {
        return view('ppdb.tracking');
    }

    /**
     * Memproses Pencarian Status PPDB
     */
    public function ppdbCheckStatus(Request $request)
    {
        $request->validate([
            'no_pendaftaran' => 'required|string|min:5|max:50',
        ], [
            'no_pendaftaran.required' => 'Masukkan Nomor Pendaftaran atau Nomor WhatsApp yang ingin dicari!',
        ]);

        $query = trim($request->no_pendaftaran);
        $cleanPhone = preg_replace('/[^0-9]/', '', $query);

        // Hanya izinkan pencarian persis: Format Nomor Pendaftaran resmi atau Nomor Telepon lengkap (min 10 digit)
        $isRegCode = (bool) preg_match('/^PPDB-\d{4}-\d{4}$/i', $query);
        $isFullPhone = strlen($cleanPhone) >= 10;

        $registration = null;

        if ($isRegCode) {
            $registration = PpdbRegistration::with('documents')
                ->where('no_pendaftaran', strtoupper($query))
                ->first();
        } elseif ($isFullPhone) {
            // Pencarian nomor telepon wajib eksak penuh, bukan potongan wildcard %...% (Cegah enumerasi PII)
            $registration = PpdbRegistration::with('documents')
                ->where(function ($q) use ($query, $cleanPhone) {
                    $q->where('parent_phone', $query)
                      ->orWhere('parent_phone', $cleanPhone);
                })
                ->first();
        } else {
            // Fallback kecocokan eksak pada nomor pendaftaran
            $registration = PpdbRegistration::with('documents')
                ->where('no_pendaftaran', $query)
                ->first();
        }

        if (!$registration) {
            return redirect()->route('ppdb.tracking')
                ->withInput()
                ->with('error', "Data pendaftaran dengan kata kunci '{$query}' tidak ditemukan. Pastikan Nomor Pendaftaran (misal: PPDB-2026-0001) atau Nomor WhatsApp yang Anda masukkan sudah lengkap dan sesuai.");
        }

        // Izinkan sesi pengguna saat ini membuka kartu bukti pendaftaran
        session(['verified_tracking_no' => $registration->no_pendaftaran]);

        return view('ppdb.tracking', [
            'registration' => $registration,
            'search' => $query,
        ]);
    }

    /**
     * Menampilkan Portal Berita & Pengumuman Sekolah (Publik)
     */
    public function newsIndex(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $kategori = trim((string) $request->input('kategori', ''));

        $query = News::with(['category', 'author'])
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($kategori !== '') {
            $query->whereHas('category', function ($q) use ($kategori) {
                $q->where('slug', $kategori);
            });
        }

        $news = $query->latest('created_at')->paginate(9)->withQueryString();
        $headline = null;
        $categories = NewsCategory::withCount('news')->get();

        $localNewsImages = [
            'images/sch1.jpeg',
            'images/sch2.jpeg',
            'images/sch3.jpeg',
            'images/sch5.jpg',
        ];

        return view('news.index', compact('news', 'headline', 'categories', 'search', 'kategori', 'localNewsImages'));
    }

    /**
     * Menampilkan Halaman Detail Berita / Pengumuman Publik
     */
    public function newsShow($slug)
    {
        $news = News::with(['category', 'author'])->where('slug', $slug)->firstOrFail();
        
        $relatedNews = News::where('id', '!=', $news->id)
            ->where('category_id', $news->category_id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('news.show', compact('news', 'relatedNews'));
    }

    /**
     * Endpoint API Global Search (Spotlight / Quick Finder)
     */
    public function globalSearch(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        // Daftar index navigasi statis & layanan sekolah
        $items = [
            [
                'title' => 'Pendaftaran PPDB Online',
                'desc' => 'Pengisian formulir pendaftaran santri baru jenjang SD, SMP, dan SMK secara mandiri',
                'url' => route('ppdb.create'),
                'category' => 'Layanan PPDB',
                'badge' => 'Formulir',
                'icon' => 'form',
            ],
            [
                'title' => 'Lacak Status Pendaftaran PPDB',
                'desc' => 'Pantau status verifikasi berkas dan hasil kelulusan seleksi PPDB',
                'url' => route('ppdb.tracking'),
                'category' => 'Layanan PPDB',
                'badge' => 'Tracking',
                'icon' => 'search',
            ],
            [
                'title' => 'Informasi & Syarat PPDB 2026/2027',
                'desc' => 'Alur pendaftaran, persyaratan berkas, jadwal gelombang, dan ketentuan beasiswa',
                'url' => route('ppdb.index'),
                'category' => 'Layanan PPDB',
                'badge' => 'Info',
                'icon' => 'info',
            ],
            [
                'title' => 'Kalkulator Simulasi Biaya & Beasiswa',
                'desc' => 'Simulasi estimasi biaya masuk dan potongan beasiswa tahfizh 30 Juz & prestasi',
                'url' => route('ppdb.index') . '#simulasi-biaya',
                'category' => 'Layanan PPDB',
                'badge' => 'Kalkulator',
                'icon' => 'calculator',
            ],
            [
                'title' => 'Tanya Jawab (FAQ) PPDB & Sekolah',
                'desc' => 'Pertanyaan umum seputar akreditasi, biaya, asrama/boarding, dan kurikulum tahfizh',
                'url' => route('ppdb.index') . '#faq-section',
                'category' => 'Bantuan & FAQ',
                'badge' => 'FAQ',
                'icon' => 'help',
            ],
            [
                'title' => 'Jenjang Sekolah Dasar (SD)',
                'desc' => 'Fondasi Qurani, tahfizh cilik, pembentukan adab, dan suasana belajar menyenangkan',
                'url' => route('home') . '#jenjang',
                'category' => 'Jenjang Pendidikan',
                'badge' => 'SD',
                'icon' => 'school',
            ],
            [
                'title' => 'Jenjang Sekolah Menengah Pertama (SMP)',
                'desc' => 'Target 5-10 juz mutqin, sains terapan, kepemimpinan santri, dan bahasa Arab/Inggris',
                'url' => route('home') . '#jenjang',
                'category' => 'Jenjang Pendidikan',
                'badge' => 'SMP',
                'icon' => 'compass',
            ],
            [
                'title' => 'SMK - Rekayasa Perangkat Lunak (RPL)',
                'desc' => 'Pemrograman web (Laravel/React), aplikasi mobile, cloud computing & kelas industri',
                'url' => route('home') . '#jenjang',
                'category' => 'Program Kejuruan',
                'badge' => 'SMK RPL',
                'icon' => 'code',
            ],
            [
                'title' => 'SMK - Teknik Komputer & Jaringan (TKJ)',
                'desc' => 'Arsitektur jaringan, server Linux/Windows, infrastruktur IT & sertifikasi industri',
                'url' => route('home') . '#jenjang',
                'category' => 'Program Kejuruan',
                'badge' => 'SMK TKJ',
                'icon' => 'network',
            ],
            [
                'title' => 'SMK - Desain Komunikasi Visual (DKV)',
                'desc' => 'Desain grafis, UI/UX, fotografi, videografi, serta studio animasi digital',
                'url' => route('home') . '#jenjang',
                'category' => 'Program Kejuruan',
                'badge' => 'SMK DKV',
                'icon' => 'palette',
            ],
            [
                'title' => 'Kampus Pusat (Hangtuah, Tenayan Raya)',
                'desc' => 'Gedung utama, masjid jami, administrasi pusat & ruang belajar representatif',
                'url' => route('home') . '#cabang',
                'category' => 'Cabang Kampus',
                'badge' => 'Pusat',
                'icon' => 'map-pin',
            ],
            [
                'title' => 'Cabang Kampus Panam (Pekanbaru Barat)',
                'desc' => 'Pusat vokasi kejuruan modern, laboratorium komputer, asrama & aula serbaguna',
                'url' => route('home') . '#cabang',
                'category' => 'Cabang Kampus',
                'badge' => 'Panam',
                'icon' => 'map-pin',
            ],
            [
                'title' => 'Cabang Kampus Marpoyan (Pekanbaru Selatan)',
                'desc' => 'Pusat tahfizh intensif dengan suasana asri, asrama santri & sarana olahraga',
                'url' => route('home') . '#cabang',
                'category' => 'Cabang Kampus',
                'badge' => 'Marpoyan',
                'icon' => 'map-pin',
            ],
            [
                'title' => 'Galeri Fasilitas & Kampus Tour',
                'desc' => 'Dokumentasi foto fasilitas belajar, masjid, laboratorium dan asrama santri',
                'url' => route('home') . '#galeri-fasilitas',
                'category' => 'Fasilitas',
                'badge' => 'Galeri',
                'icon' => 'image',
            ],
            [
                'title' => 'Kisah Sukses Santri & Wali Santri',
                'desc' => 'Ulasan langsung wali santri dan kisah alumni penghafal Quran & profesional',
                'url' => route('home') . '#testimoni',
                'category' => 'Testimoni',
                'badge' => 'Alumni',
                'icon' => 'star',
            ],
            [
                'title' => 'Portal Berita & Warta Sekolah',
                'desc' => 'Katalog berita, kegiatan santri, prestasi dan pengumuman resmi institusi',
                'url' => route('berita.index'),
                'category' => 'Publikasi',
                'badge' => 'Warta',
                'icon' => 'newspaper',
            ],
            [
                'title' => 'WhatsApp Helpdesk Panitia',
                'desc' => 'Layanan bantuan & informasi pendaftaran langsung melalui WhatsApp resmi',
                'url' => config('school.whatsapp_url', 'https://wa.me/6281270001920'),
                'category' => 'Bantuan & Kontak',
                'badge' => 'WhatsApp',
                'icon' => 'phone',
            ],
        ];

        // Tambahkan artikel berita dinamis
        $newsItems = News::select('title', 'slug', 'content')->latest()->take(8)->get();
        foreach ($newsItems as $n) {
            $items[] = [
                'title' => $n->title,
                'desc' => Str::limit(strip_tags($n->content), 85),
                'url' => route('news.show', $n->slug),
                'category' => 'Berita Terbaru',
                'badge' => 'Berita',
                'icon' => 'newspaper',
            ];
        }

        if ($q !== '') {
            $filtered = array_filter($items, function ($item) use ($q) {
                return mb_stripos($item['title'], $q) !== false 
                    || mb_stripos($item['desc'], $q) !== false 
                    || mb_stripos($item['category'], $q) !== false
                    || mb_stripos($item['badge'], $q) !== false;
            });
            return response()->json(array_values($filtered));
        }

        return response()->json($items);
    }

    /**
     * ==========================================
     * MODUL PERPUSTAKAAN - PUBLIK
     * ==========================================
     */
    public function perpusIndex(Request $request)
    {
        $info = $this->getSchoolData()['info'];
        $search = $request->query('search');
        $categoryId = $request->query('category');

        $books = Book::with('category')
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%"))
            ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        $categories = BookCategory::orderBy('name')->get();

        return view('perpus.index', compact('books', 'categories', 'search', 'categoryId', 'info'));
    }

    public function perpusShow($id)
    {
        $info = $this->getSchoolData()['info'];
        $book = Book::with('category')->findOrFail($id);
        $related = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)->take(4)->get();

        return view('perpus.show', compact('book', 'related', 'info'));
    }

    public function perpusPinjamCreate($bookId)
    {
        $info = $this->getSchoolData()['info'];
        $book = Book::findOrFail($bookId);
        return view('perpus.pinjam-create', compact('book', 'info'));
    }

    public function perpusPinjamStore(Request $request, $bookId)
    {
        $book = Book::findOrFail($bookId);

        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'phone'     => 'required|string|max:20',
            'address'   => 'nullable|string',
        ]);

        if ($book->available < 1) {
            return back()->withErrors(['stock' => 'Maaf, seluruh eksemplar buku ini sedang dipinjam.']);
        }

        // Cari anggota lama berdasarkan nomor HP, atau daftarkan sebagai anggota baru
        $member = LibraryMember::firstOrCreate(
            ['phone' => $validated['phone']],
            [
                'full_name' => $validated['full_name'],
                'address'   => $validated['address'] ?? null,
                'joined_at' => now(),
            ]
        );

        $loan = BookLoan::create([
            'member_id' => $member->id,
            'book_id'   => $book->id,
            'due_at'    => now()->addDays(7),
            'status'    => 'diajukan',
        ]);

        session(['submitted_loan_code' => $loan->loan_code]);

        return redirect()->route('perpus.pinjam.success', $loan->loan_code)
            ->with('success', 'Pengajuan peminjaman berhasil dikirim!');
    }

    public function perpusPinjamSuccess($loanCode)
    {
        $info = $this->getSchoolData()['info'];
        $loan = BookLoan::with('book')->where('loan_code', $loanCode)->firstOrFail();

        // Otorisasi: hanya peminjam pada sesi aktif atau petugas admin yang dapat membuka kartu bukti langsung
        if (session('submitted_loan_code') !== $loanCode && !Auth::check()) {
            return redirect()->route('perpus.tracking')
                ->with('info', 'Silakan masukkan kode peminjaman Anda di bawah ini untuk memeriksa status.');
        }

        return view('perpus.pinjam-success', compact('loan', 'info'));
    }

    public function perpusTracking()
    {
        $info = $this->getSchoolData()['info'];
        return view('perpus.tracking', compact('info'));
    }

    public function perpusCheckStatus(Request $request)
    {
        $validated = $request->validate(['loan_code' => 'required|string']);
        $loan = BookLoan::with(['book', 'member'])
            ->where('loan_code', $validated['loan_code'])->first();

        if (!$loan) {
            return back()->withErrors(['loan_code' => 'Kode peminjaman tidak ditemukan.']);
        }

        return view('perpus.tracking', ['loan' => $loan, 'info' => $this->getSchoolData()['info']]);
    }

    /**
     * Helper data profil sekolah untuk modul perpustakaan & publik
     */
    private function getSchoolData(): array
    {
        return [
            'info' => [
                'nama'          => 'PKBM TAHFIZH ATTAMAM',
                'slogan'        => 'Mencetak Generasi Qurani, Berkarakter & Siap Kerja di Era Digital',
                'alamat'        => 'Jl. Hangtuah No. 45, Tenayan Raya, Pekanbaru, Riau',
                'telepon'       => '(0761) 555-0192',
                'email'         => 'info@pkbmtahfizhattamam.sch.id',
                'tahun_berdiri' => '2018',
                'akreditasi'    => 'B (Baik)',
            ]
        ];
    }
}
