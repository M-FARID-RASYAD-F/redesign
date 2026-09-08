<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users untuk seluruh Role RBAC (3.3.1 & 3.4)
        $admin = User::updateOrCreate(
            ['email' => 'budi.guru@sekolah.sch.id'],
            [
                'name' => 'Budi Santoso, S.Pd. (Super Admin)',
                'password' => bcrypt('password123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        $adminCms = User::updateOrCreate(
            ['email' => 'cms@sekolah.sch.id'],
            [
                'name' => 'Fahri Ramadhan (Admin CMS)',
                'password' => bcrypt('password123'),
                'role' => 'admin_cms',
                'is_active' => true,
            ]
        );

        $adminPpdb = User::updateOrCreate(
            ['email' => 'ppdb@sekolah.sch.id'],
            [
                'name' => 'Ratna Dewi, S.Kom. (Admin PPDB)',
                'password' => bcrypt('password123'),
                'role' => 'admin_ppdb',
                'is_active' => true,
            ]
        );

        $editorAkademik = User::updateOrCreate(
            ['email' => 'akademik@sekolah.sch.id'],
            [
                'name' => 'Hendra Pratama (Editor Akademik)',
                'password' => bcrypt('password123'),
                'role' => 'editor_akademik',
                'is_active' => true,
            ]
        );

        // 2. Seed Majors (Jurusan)
        $jurusanList = [
            [
                'name' => 'Rekayasa Perangkat Lunak (RPL)',
                'slug' => 'rekayasa-perangkat-lunak-rpl',
                'description' => 'Mempelajari pemrograman web (Laravel, React), aplikasi mobile, basis data, dan pengembangan software berbasis industri.',
                'icon' => '⚡',
            ],
            [
                'name' => 'Teknik Komputer & Jaringan (TKJ)',
                'slug' => 'teknik-komputer-jaringan-tkj',
                'description' => 'Fokus pada arsitektur jaringan komputer, administrasi server Linux/Windows, cloud computing, dan siber security.',
                'icon' => '📡',
            ],
            [
                'name' => 'Desain Komunikasi Visual (DKV)',
                'slug' => 'desain-komunikasi-visual-dkv',
                'description' => 'Mengembangkan kreativitas seni visual, desain grafis, fotografi, videografi, serta desain UI/UX aplikasi digital.',
                'icon' => '🎨',
            ]
        ];

        foreach ($jurusanList as $jur) {
            \App\Models\Major::firstOrCreate(['slug' => $jur['slug']], $jur);
        }

        // 3. Seed News Categories
        $categories = [
            ['name' => 'Prestasi', 'slug' => 'prestasi'],
            ['name' => 'Kerjasama', 'slug' => 'kerjasama'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman'],
            ['name' => 'Umum', 'slug' => 'umum'],
        ];

        $cats = [];
        foreach ($categories as $cat) {
            $cats[$cat['slug']] = \App\Models\NewsCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Seed News
        $newsList = [
            [
                'category_id' => $cats['prestasi']->id,
                'title' => 'Tim RPL SMKN 1 Nusantara Meraih Juara 1 LKS Pemrograman Web 2026',
                'slug' => 'tim-rpl-smkn-1-nusantara-meraih-juara-1-lks-pemrograman-web-2026',
                'thumbnail' => 'https://picsum.photos/800/400?random=1',
                'content' => 'Siswa kami berhasil memboyong piala emas dalam kejuaraan Lomba Kompetensi Siswa tingkat provinsi yang diadakan minggu lalu di Gedung Pusat Kebudayaan.',
                'author_id' => $admin->id,
                'published_at' => now(),
            ],
            [
                'category_id' => $cats['kerjasama']->id,
                'title' => 'Penandatanganan MoU Kemitraan Kerja dengan 12 Perusahaan IT Nasional',
                'slug' => 'penandatanganan-mou-kemitraan-kerja-dengan-12-perusahaan-it-nasional',
                'thumbnail' => 'https://picsum.photos/800/400?random=2',
                'content' => 'SMKN 1 Nusantara memperluas jangkauan magang dan rekrutmen lulusan secara langsung sebelum wisuda kelulusan melalui penandatanganan kerja sama strategis ini.',
                'author_id' => $admin->id,
                'published_at' => now(),
            ],
            [
                'category_id' => $cats['pengumuman']->id,
                'title' => 'Pembukaan Pendaftaran Siswa Baru (PPDB) Gelombang 2 Tahun 2026/2027',
                'slug' => 'pembukaan-pendaftaran-siswa-baru-ppdb-gelombang-2-tahun-2026-2027',
                'thumbnail' => 'https://picsum.photos/800/400?random=3',
                'content' => 'Informasi lengkap persyaratan dan alur pendaftaran calon peserta didik baru gelombang 2 dapat diakses melalui portal PPDB online di website resmi ini.',
                'author_id' => $admin->id,
                'published_at' => now(),
            ]
        ];

        foreach ($newsList as $n) {
            \App\Models\News::firstOrCreate(['slug' => $n['slug']], $n);
        }

        // 5. Seed Teachers & Staff
        $teachers = [
            [
                'name' => 'Dr. H. Ahmad Fauzi, M.Pd.',
                'position' => 'Kepala Sekolah',
                'subject' => 'Manajemen Sekolah',
                'photo' => 'https://i.pravatar.cc/150?img=60',
                'nip' => '197508122000031002',
                'status' => 'aktif',
            ],
            [
                'name' => 'Budi Santoso, S.Pd.',
                'position' => 'Guru Pengajar',
                'subject' => 'Rekayasa Perangkat Lunak',
                'photo' => 'https://i.pravatar.cc/150?img=53',
                'nip' => '198203112009121003',
                'status' => 'aktif',
            ],
            [
                'name' => 'Siti Aminah, M.Kom.',
                'position' => 'Guru Pengajar',
                'subject' => 'Teknik Komputer & Jaringan',
                'photo' => 'https://i.pravatar.cc/150?img=47',
                'nip' => '198705242014022001',
                'status' => 'aktif',
            ]
        ];

        foreach ($teachers as $t) {
            \App\Models\TeacherStaff::firstOrCreate(['nip' => $t['nip']], $t);
        }

        // 6. Seed PPDB Registrations
        $ppdbList = [
            [
                'no_pendaftaran' => 'PPDB20260001',
                'full_name' => 'Muhammad Rifqi',
                'gender' => 'L',
                'birth_date' => '2010-04-15',
                'address' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'parent_name' => 'Bambang Hermawan',
                'parent_phone' => '081234567890',
                'status' => 'pending',
                'notes' => 'Menunggu verifikasi rapor dan KK',
            ],
            [
                'no_pendaftaran' => 'PPDB20260002',
                'full_name' => 'Laras Ayu Wandira',
                'gender' => 'P',
                'birth_date' => '2010-09-22',
                'address' => 'Jl. Melati Indah Gg. 3 No. 14, Jakarta Barat',
                'parent_name' => 'Sri Astuti',
                'parent_phone' => '089876543210',
                'status' => 'diverifikasi',
                'notes' => 'Dokumen lengkap dan valid',
            ]
        ];

        foreach ($ppdbList as $p) {
            $reg = \App\Models\PpdbRegistration::firstOrCreate(['no_pendaftaran' => $p['no_pendaftaran']], $p);
            
            // Seed mock document for each
            \App\Models\PpdbDocument::firstOrCreate(
                ['registration_id' => $reg->id, 'doc_type' => 'kk'],
                [
                    'file_path' => 'storage/ppdb/kk_' . $reg->id . '.pdf',
                    'verification_status' => $reg->status == 'diverifikasi' ? 'valid' : 'belum_diverifikasi',
                ]
            );
        }

        // 7. Seed Pengumuman (3.3.3 Modul Pengumuman)
        $announcements = [
            [
                'title' => 'Pengumuman Pelaksanaan Ujian Sertifikasi BNSP 2026',
                'content' => 'Seluruh santri tingkat akhir jurusan RPL, TKJ, dan DKV diwajibkan mengikuti uji kompetensi keahlian bersertifikat BNSP pada tanggal 15-20 Oktober 2026. Persiapkan berkas portofolio karya masing-masing.',
                'type' => 'akademik',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonths(1)->toDateString(),
                'is_archived' => false,
                'created_by' => $adminCms->id,
            ],
            [
                'title' => 'Informasi Libur Awal Ramadhan & Pesantren Kilat',
                'content' => 'Diberitahukan kepada seluruh wali santri bahwa kegiatan belajar mengajar tatap muka akan diliburkan menyambut awal bulan suci Ramadhan, dilanjutkan kegiatan Daurah Qurani & Pesantren Kilat.',
                'type' => 'umum',
                'start_date' => now()->subDays(5)->toDateString(),
                'end_date' => now()->addDays(20)->toDateString(),
                'is_archived' => false,
                'created_by' => $admin->id,
            ]
        ];

        foreach ($announcements as $ann) {
            \App\Models\Announcement::firstOrCreate(['title' => $ann['title']], $ann);
        }

        // 8. Seed Agenda (3.3.3 Modul Agenda)
        $agendas = [
            [
                'title' => 'Workshop UI/UX Design Bersama Mentor Industri Digital',
                'date' => now()->addDays(7)->toDateString(),
                'location' => 'Laboratorium Multimedia & DKV Kampus Panam',
                'description' => 'Pelatihan intensif pembuatan design system dan prototyping aplikasi menggunakan Figma untuk siswa SMK.',
                'created_by' => $adminCms->id,
            ],
            [
                'title' => 'Khataman Akbar & Wisuda Tahfizh Al-Qur\'an Juz 30',
                'date' => now()->addDays(14)->toDateString(),
                'location' => 'Masjid Jami\' At-Tamam Kampus Pusat',
                'description' => 'Prosesi wisuda tahfizh dan pemberian sanad kelulusan bagi santri penghafal Quran mutqin.',
                'created_by' => $admin->id,
            ]
        ];

        foreach ($agendas as $ag) {
            \App\Models\Agenda::firstOrCreate(['title' => $ag['title']], $ag);
        }

        // 9. Seed Galeri Foto (3.3.2 Modul Galeri)
        $galleries = [
            [
                'title' => 'Suasana Praktik Lab Jaringan Komputer & Cloud Cisco',
                'image_path' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?w=800',
                'category' => 'Praktik Industri',
                'uploaded_by' => $adminCms->id,
            ],
            [
                'title' => 'Halaqah Qur\'an dan Tahfizh Subuh Santri Putra',
                'image_path' => 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?w=800',
                'category' => 'Keagamaan',
                'uploaded_by' => $admin->id,
            ],
            [
                'title' => 'Pameran Karya Desain Grafis & UI/UX Santri DKV',
                'image_path' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=800',
                'category' => 'Pameran Karya',
                'uploaded_by' => $adminCms->id,
            ]
        ];

        foreach ($galleries as $g) {
            \App\Models\Gallery::firstOrCreate(['title' => $g['title']], $g);
        }

        // 10. Seed Initial Activity Logs
        \App\Models\ActivityLog::create([
            'user_id' => $admin->id,
            'module' => 'auth',
            'action' => 'create',
            'description' => 'System seeding data awal RBAC dan seluruh modul berhasil dijalankan',
        ]);
    }
}
