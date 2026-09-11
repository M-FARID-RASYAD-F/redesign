<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Major;
use App\Models\NewsCategory;
use App\Models\News;
use App\Models\TeacherStaff;
use App\Models\PpdbRegistration;
use App\Models\PpdbDocument;
use App\Models\ActivityLog;
use App\Models\Gallery;
use App\Models\Announcement;
use App\Models\Agenda;
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
        // 1. Seed Users untuk Tiap Role (Admin Dummy)
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@attamam.sch.id'],
            [
                'name' => 'Budi Santoso, S.Pd. (Super Admin)',
                'password' => bcrypt('password123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );

        $adminCms = User::updateOrCreate(
            ['email' => 'cms@attamam.sch.id'],
            [
                'name' => 'Siti Rahmah, S.Kom. (Admin CMS)',
                'password' => bcrypt('password123'),
                'role' => 'admin_cms',
                'is_active' => true,
            ]
        );

        $adminPpdb = User::updateOrCreate(
            ['email' => 'ppdb@attamam.sch.id'],
            [
                'name' => 'Ahmad Fauzan, S.Pd. (Admin PPDB)',
                'password' => bcrypt('password123'),
                'role' => 'admin_ppdb',
                'is_active' => true,
            ]
        );

        $editorAkademik = User::updateOrCreate(
            ['email' => 'akademik@attamam.sch.id'],
            [
                'name' => 'Dewi Lestari, M.Pd. (Editor Akademik)',
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
            Major::firstOrCreate(['slug' => $jur['slug']], $jur);
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
            $cats[$cat['slug']] = NewsCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 4. Seed News
        $newsList = [
            [
                'category_id' => $cats['prestasi']->id,
                'title' => 'Tim RPL SMKN 1 Nusantara Meraih Juara 1 LKS Pemrograman Web 2026',
                'slug' => 'tim-rpl-smkn-1-nusantara-meraih-juara-1-lks-pemrograman-web-2026',
                'thumbnail' => 'https://picsum.photos/800/400?random=1',
                'content' => 'Siswa kami berhasil memboyong piala emas dalam kejuaraan Lomba Kompetensi Siswa tingkat provinsi yang diadakan minggu lalu di Gedung Pusat Kebudayaan.',
                'author_id' => $adminCms->id,
                'published_at' => now(),
            ],
            [
                'category_id' => $cats['kerjasama']->id,
                'title' => 'Penandatanganan MoU Kemitraan Kerja dengan 12 Perusahaan IT Nasional',
                'slug' => 'penandatanganan-mou-kemitraan-kerja-dengan-12-perusahaan-it-nasional',
                'thumbnail' => 'https://picsum.photos/800/400?random=2',
                'content' => 'SMKN 1 Nusantara memperluas jangkauan magang dan rekrutmen lulusan secara langsung sebelum wisuda kelulusan melalui penandatanganan kerja sama strategis ini.',
                'author_id' => $adminCms->id,
                'published_at' => now(),
            ],
            [
                'category_id' => $cats['pengumuman']->id,
                'title' => 'Pembukaan Pendaftaran Siswa Baru (PPDB) Gelombang 2 Tahun 2026/2027',
                'slug' => 'pembukaan-pendaftaran-siswa-baru-ppdb-gelombang-2-tahun-2026-2027',
                'thumbnail' => 'https://picsum.photos/800/400?random=3',
                'content' => 'Informasi lengkap persyaratan dan alur pendaftaran calon peserta didik baru gelombang 2 dapat diakses melalui portal PPDB online di website resmi ini.',
                'author_id' => $adminCms->id,
                'published_at' => now(),
            ]
        ];

        foreach ($newsList as $n) {
            News::firstOrCreate(['slug' => $n['slug']], $n);
        }

        // 5. Seed Galleries
        $galleries = [
            [
                'title' => 'Kegiatan Halaqah Tahfizh Pagi Santri',
                'image_path' => 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=800',
                'category' => 'Kegiatan Santri',
                'uploaded_by' => $adminCms->id,
            ],
            [
                'title' => 'Praktikum Jaringan Fiber Optic di Lab Komputer',
                'image_path' => 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=800',
                'category' => 'Akademik & Lab',
                'uploaded_by' => $adminCms->id,
            ],
            [
                'title' => 'Pameran Karya Desain Grafis & Motion Animasi DKV',
                'image_path' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=800',
                'category' => 'Pameran Karya',
                'uploaded_by' => $adminCms->id,
            ],
        ];

        foreach ($galleries as $g) {
            Gallery::firstOrCreate(['title' => $g['title']], $g);
        }

        // 6. Seed Announcements
        $announcements = [
            [
                'title' => 'Jadwal Tes Wawancara & Observasi PPDB Gelombang II',
                'content' => 'Pelaksanaan observasi dan wawancara calon santri baru dijadwalkan pada hari Sabtu dan Ahad di Kampus Pusat.',
                'type' => 'ppdb',
                'start_date' => now()->subDays(2)->toDateString(),
                'end_date' => now()->addDays(10)->toDateString(),
                'is_archived' => false,
                'created_by' => $adminCms->id,
            ],
            [
                'title' => 'Pelatihan Sertifikasi Mikrotik & Cisco untuk Guru Produktif',
                'content' => 'Seluruh pengajar jurusan teknik diwajibkan mengikuti agenda upskilling industri selama 3 hari.',
                'type' => 'akademik',
                'start_date' => now()->subDays(30)->toDateString(),
                'end_date' => now()->subDays(5)->toDateString(),
                'is_archived' => true,
                'created_by' => $adminCms->id,
            ],
        ];

        foreach ($announcements as $a) {
            Announcement::firstOrCreate(['title' => $a['title']], $a);
        }

        // 7. Seed Agenda
        $agendas = [
            [
                'title' => 'Workshop UI/UX Bersama Praktisi Startup Unicorn',
                'date' => now()->addDays(7)->toDateString(),
                'location' => 'Aula Serbaguna Lt. 2 Kampus Panam',
                'description' => 'Membahas tren desain produk digital masa depan dan standar portfolio industri.',
                'created_by' => $adminCms->id,
            ],
            [
                'title' => 'Tasmi\' Akbar Hafalan 30 Juz Sekali Duduk',
                'date' => now()->addDays(14)->toDateString(),
                'location' => 'Masjid Jami\' At-Tamam',
                'description' => 'Ujian kelulusan mutqin para santri kelas akhir disaksikan oleh wali santri dan dewan asatidz.',
                'created_by' => $adminCms->id,
            ],
        ];

        foreach ($agendas as $ag) {
            Agenda::firstOrCreate(['title' => $ag['title']], $ag);
        }

        // 8. Seed Teachers & Staff
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
            TeacherStaff::firstOrCreate(['nip' => $t['nip']], $t);
        }

        // 9. Seed PPDB Registrations
        $ppdbList = [
            [
                'no_pendaftaran' => 'PPDB20260001',
                'jenjang' => 'smk',
                'major_choice' => 'Rekayasa Perangkat Lunak (RPL)',
                'full_name' => 'Muhammad Rifqi',
                'gender' => 'L',
                'birth_date' => '2010-04-15',
                'address' => 'Jl. Merdeka No. 10, Pekanbaru',
                'parent_name' => 'Bambang Hermawan',
                'parent_phone' => '081234567890',
                'status' => 'pending',
                'notes' => 'Menunggu verifikasi berkas kartu keluarga dan pas foto oleh panitia.',
            ],
            [
                'no_pendaftaran' => 'PPDB20260002',
                'jenjang' => 'smp',
                'major_choice' => null,
                'full_name' => 'Laras Ayu Wandira',
                'gender' => 'P',
                'birth_date' => '2010-09-22',
                'address' => 'Jl. Melati Indah Gg. 3 No. 14, Pekanbaru',
                'parent_name' => 'Sri Astuti',
                'parent_phone' => '089876543210',
                'status' => 'diverifikasi',
                'notes' => 'Seluruh dokumen lengkap dan terverifikasi valid.',
            ],
            [
                'no_pendaftaran' => 'PPDB20260003',
                'jenjang' => 'sd',
                'major_choice' => null,
                'full_name' => 'Fadhil Rahman Al-Farisi',
                'gender' => 'L',
                'birth_date' => '2010-01-18',
                'address' => 'Jl. HR. Soebrantas Km. 11, Pekanbaru',
                'parent_name' => 'Rahman Hakim',
                'parent_phone' => '081399887766',
                'status' => 'diterima',
                'notes' => 'Lulus tes observasi dan wawancara. Siap daftar ulang.',
            ],
            [
                'no_pendaftaran' => 'PPDB20260004',
                'jenjang' => 'smk',
                'major_choice' => 'Desain Komunikasi Visual (DKV)',
                'full_name' => 'Zahra Amelia Putri',
                'gender' => 'P',
                'birth_date' => '2011-03-05',
                'address' => 'Jl. Kaharuddin Nasution No. 55, Pekanbaru',
                'parent_name' => 'Amran Syah',
                'parent_phone' => '082155443322',
                'status' => 'ditolak',
                'notes' => 'Usia belum mencukupi batas persyaratan penerimaan tahun ajaran 2026/2027.',
            ]
        ];

        foreach ($ppdbList as $p) {
            $reg = PpdbRegistration::firstOrCreate(['no_pendaftaran' => $p['no_pendaftaran']], $p);
            
            // Seed mock document for each
            PpdbDocument::firstOrCreate(
                ['registration_id' => $reg->id, 'doc_type' => 'kk'],
                [
                    'file_path' => 'ppdb_documents/kk_' . $reg->id . '.pdf',
                    'verification_status' => in_array($reg->status, ['diverifikasi', 'diterima']) ? 'valid' : 'belum_diverifikasi',
                ]
            );
        }

        // 10. Seed Initial Activity Logs
        ActivityLog::create([
            'user_id' => $superAdmin->id,
            'module' => 'auth',
            'action' => 'seed',
            'description' => 'System seeding data awal seluruh modul dan role admin berhasil dijalankan',
        ]);
        ActivityLog::create([
            'user_id' => $adminPpdb->id,
            'module' => 'ppdb',
            'action' => 'verify',
            'description' => 'Verifikasi berkas persyaratan PPDB pendaftar Laras Ayu Wandira',
        ]);
        ActivityLog::create([
            'user_id' => $adminCms->id,
            'module' => 'news',
            'action' => 'publish',
            'description' => 'Mempublikasikan artikel berita prestasi lomba LKS 2026',
        ]);
    }
}
