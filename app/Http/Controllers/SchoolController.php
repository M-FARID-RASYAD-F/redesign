<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolProfile;
use App\Models\Major;
use App\Models\News;
use App\Models\TeacherStaff;
use App\Models\PpdbRegistration;
use App\Models\PpdbDocument;
use App\Models\ActivityLog;

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
            'deskripsi' => 'Sekolah menengah kejuruan terkemuka yang memadukan kurikulum industri modern, pembentukan karakter mulia, dan fasilitas pembelajaran digital.',
            'tahun_berdiri' => '2018',
            'akreditasi' => 'B (Baik)',
            'alamat' => 'Jl. Pendidikan Teknologi No. 45, Cyber City, Nusantara',
            'telepon' => '(021) 555-0192',
            'email' => 'info@pkbmtahfizhattamam.sch.id'
        ];

        // 2. Data Sambutan Kepala Sekolah
        $kepsek = TeacherStaff::where('position', 'Kepala Sekolah')->first();
        $sambutan = [
            'nama' => $kepsek ? $kepsek->name : 'Dr. H. Ahmad Fauzi, M.Pd.',
            'jabatan' => 'Kepala Sekolah SMK Negeri 1 Nusantara',
            'pesan' => 'Selamat datang di portal resmi SMK Negeri 1 Nusantara. Kami berdedikasi menciptakan lingkungan belajar yang inspiratif, inovatif, dan relevan dengan kebutuhan dunia kerja masa depan. Mari bersama mewujudkan impian dan potensi terbaik para siswa!',
            'foto_initials' => 'AF'
        ];

        // 3. Data Statistik Sekolah
        $jumlahSiswa = PpdbRegistration::count() + 1250; // Simulasi dengan penambahan pendaftar
        $jumlahGuru = TeacherStaff::count();
        $jumlahJurusan = Major::count();

        $stats = [
            ['label' => 'Siswa Terdaftar', 'value' => number_format($jumlahSiswa) . '+', 'icon' => '👨‍🎓', 'color' => '#eff6ff'],
            ['label' => 'Guru & Staf', 'value' => ($jumlahGuru > 0 ? $jumlahGuru : 85) . ' Pengajar', 'icon' => '👩‍🏫', 'color' => '#ecfdf5'],
            ['label' => 'Program Keahlian', 'value' => ($jumlahJurusan > 0 ? $jumlahJurusan : 3) . ' Jurusan', 'icon' => '💻', 'color' => '#fffbeb'],
            ['label' => 'Serapan Kerja', 'value' => '94% Pertahun', 'icon' => '🚀', 'color' => '#f3e8ff'],
        ];

        // 4. Data Program Keahlian / Jurusan (Dinamis dari Database)
        $jurusan = Major::all()->map(function ($item) {
            $badges = [
                'rekayasa-perangkat-lunak-rpl' => '🔥 Paling Favorit',
                'teknik-komputer-jaringan-tkj' => '🌐 Sertifikasi Cisco/Mikrotik',
                'desain-komunikasi-visual-dkv' => '🎨 Studio Kreatif Komplit',
            ];

            return [
                'id' => $item->slug,
                'nama' => $item->name,
                'kategori' => str_contains($item->slug, 'dkv') ? 'Industri Kreatif' : 'Teknologi Informasi',
                'deskripsi' => $item->description,
                'prospek' => 'Lulusan siap kerja di bidang ' . explode(' (', $item->name)[0],
                'badge' => $badges[$item->slug] ?? '✨ Program Unggulan',
                'icon' => $item->icon ?? '⚡'
            ];
        })->toArray();

        // Fallback jika database belum di-seed
        if (empty($jurusan)) {
            $jurusan = [
                [
                    'id' => 'rpl',
                    'nama' => 'Rekayasa Perangkat Lunak (RPL)',
                    'kategori' => 'Teknologi Informasi',
                    'deskripsi' => 'Mempelajari pemrograman web (Laravel, React), aplikasi mobile, basis data, dan pengembangan software berbasis industri.',
                    'prospek' => 'Fullstack Developer, Web Developer, Mobile App Engineer',
                    'badge' => '🔥 Paling Favorit',
                    'icon' => '⚡'
                ]
            ];
        }

        // 5. Data Berita Terbaru (Dinamis dari Database)
        $berita = News::with('category')->latest()->take(3)->get()->map(function ($item) {
            return [
                'judul' => $item->title,
                'tanggal' => $item->created_at->translatedFormat('d F Y') ?? $item->created_at->format('d M Y'),
                'kategori' => $item->category ? $item->category->name : 'Umum',
                'ringkasan' => substr(strip_tags($item->content), 0, 120) . '...',
                'baca_waktu' => '3 menit baca'
            ];
        })->toArray();

        // Fallback jika database belum di-seed
        if (empty($berita)) {
            $berita = [
                [
                    'judul' => 'Tim RPL SMKN 1 Nusantara Meraih Juara 1 LKS Pemrograman Web 2026',
                    'tanggal' => '28 Juli 2026',
                    'kategori' => 'Prestasi',
                    'ringkasan' => 'Siswa kami berhasil memboyong piala emas dalam kejuaraan Lomba Kompetensi Siswa tingkat provinsi.',
                    'baca_waktu' => '3 menit baca'
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
                'image' => 'https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?q=80&w=1200&auto=format&fit=crop',
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
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=1200&auto=format&fit=crop',
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
                'image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1200&auto=format&fit=crop',
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
                'image' => 'https://images.unsplash.com/photo-1519452635265-7b1fbfd1e4e0?q=80&w=1200&auto=format&fit=crop',
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

        // Kirim seluruh data ke view 'welcome'
        return view('welcome', compact('sekolah', 'sambutan', 'stats', 'jurusan', 'berita', 'fasilitas', 'cabang'));
    }

    /**
     * Memproses Form Pendaftaran / Kontak dari Pengunjung dan menyimpannya ke database
     */
    public function submitContact(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|min:3',
            'email' => 'required|email',
            'jurusan_minat' => 'required',
            'pesan' => 'required|min:10',
            'berkas' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi!',
            'nama.min' => 'Nama minimal terdiri dari 3 karakter.',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Format email tidak valid!',
            'jurusan_minat.required' => 'Pilih jurusan yang diminati!',
            'pesan.required' => 'Pesan/pertanyaan wajib diisi!',
            'pesan.min' => 'Pesan minimal terdiri dari 10 karakter.',
            'berkas.file' => 'Berkas harus berupa file yang valid.',
            'berkas.mimes' => 'Berkas harus berformat PDF, JPG, JPEG, atau PNG.',
            'berkas.max' => 'Ukuran berkas maksimal 2MB.',
        ]);

        $berkasInfo = '';
        if ($request->hasFile('berkas')) {
            $request->file('berkas')->store('berkas_ppdb', 'public');
            $berkasInfo = ' serta berkas persyaratan berhasil diunggah';
        }

        // Simpan pendaftaran ke database ppdb_registrations
        $noPendaftaran = 'PPDB-' . date('Ymd') . '-' . rand(1000, 9999);
        $registration = PpdbRegistration::create([
            'no_pendaftaran' => $noPendaftaran,
            'full_name' => $validated['nama'],
            'gender' => 'L', // default value
            'birth_date' => now()->subYears(15)->format('Y-m-d'), // default value
            'address' => $validated['pesan'], // simpan pesan ke alamat
            'parent_name' => 'Wali Murid',
            'parent_phone' => '081200000000',
            'major_choice' => $validated['jurusan_minat'],
            'status' => 'pending',
            'notes' => 'Registrasi otomatis dari form kontak landing page'
        ]);

        // Catat log aktivitas admin/sistem
        ActivityLog::create([
            'user_id' => 1, // Hubungkan ke user Budi Santoso yang pertama kali diseed
            'module' => 'ppdb',
            'action' => 'create',
            'description' => 'Pendaftaran PPDB baru oleh ' . $validated['nama'] . ' (No. Reg: ' . $noPendaftaran . ')',
        ]);

        // Kirim response flash message kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Halo ' . $validated['nama'] . ', terima kasih! Pesan dan pendaftaran informasi Anda mengenai jurusan ' . strtoupper($validated['jurusan_minat']) . ' telah berhasil terkirim' . $berkasInfo . '. Nomor Pendaftaran Anda: ' . $noPendaftaran);
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
            'gelombang' => 'Gelombang II (Tahun Ajaran 2026/2027)',
            'deadline' => '30 Agustus 2026'
        ];

        return view('ppdb.index', compact('majors', 'stats'));
    }

    /**
     * Halaman Formulir Pendaftaran Siswa Baru Mandiri
     */
    public function ppdbCreate()
    {
        $majors = Major::all();
        return view('ppdb.create', compact('majors'));
    }

    /**
     * Memproses Pengiriman Formulir Pendaftaran PPDB Online Mandiri
     */
    public function ppdbStore(Request $request)
    {
        $validated = $request->validate([
            // Data Calon Siswa
            'full_name' => 'required|string|min:3|max:255',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date|before:today',
            'address' => 'required|string|min:8',
            'major_choice' => 'required|string',

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
            'full_name.required' => 'Nama lengkap calon siswa wajib diisi.',
            'full_name.min' => 'Nama lengkap minimal 3 karakter.',

            'gender.required' => 'Pilih jenis kelamin calon siswa.',
            'birth_date.required' => 'Tanggal lahir wajib diisi.',
            'birth_date.before' => 'Tanggal lahir tidak valid.',

            'address.required' => 'Alamat tempat tinggal lengkap wajib diisi.',
            'address.min' => 'Alamat minimal 8 karakter.',

            'major_choice.required' => 'Pilih salah satu program keahlian / jurusan.',
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

        // Simpan data pendaftaran
        $registration = PpdbRegistration::create([
            'full_name' => $validated['full_name'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
            'address' => $validated['address'],
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
            'major_choice' => $validated['major_choice'],
            'status' => 'pending',
            'notes' => 'Pendaftaran online mandiri berhasil diajukan. Menunggu verifikasi berkas oleh panitia PPDB.',
        ]);

        // Upload Dokumen Pendukung jika dilampirkan
        $docMapping = [
            'doc_kk' => 'kk',
            'doc_akta' => 'akta_lahir',
            'doc_foto' => 'foto',
            'doc_rapor' => 'rapor_terakhir',
        ];

        foreach ($docMapping as $field => $type) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('ppdb_documents', 'public');
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
            'description' => "Pendaftaran PPDB mandiri berhasil diajukan oleh {$registration->full_name} (No: {$registration->no_pendaftaran})",
        ]);

        return redirect()->route('ppdb.success', $registration->no_pendaftaran);
    }

    /**
     * Halaman Sukses Pendaftaran & Bukti Registrasi Digital
     */
    public function ppdbSuccess($no_pendaftaran)
    {
        $registration = PpdbRegistration::with('documents')->where('no_pendaftaran', $no_pendaftaran)->firstOrFail();
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
            'no_pendaftaran.required' => 'Masukkan Nomor Pendaftaran yang ingin dicari!',
        ]);

        $query = trim($request->no_pendaftaran);
        $registration = PpdbRegistration::with('documents')
            ->where('no_pendaftaran', $query)
            ->first();

        if (!$registration) {
            return redirect()->route('ppdb.tracking')
                ->withInput()
                ->with('error', "Nomor pendaftaran '{$query}' tidak ditemukan dalam basis data sistem. Pastikan format nomor yang Anda masukkan sudah sesuai.");
        }

        return view('ppdb.tracking', [
            'registration' => $registration,
            'search' => $query,
        ]);
    }
}
