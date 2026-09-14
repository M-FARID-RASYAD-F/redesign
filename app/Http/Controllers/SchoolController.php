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
        // 1. Data Informasi Sekolah (Dari Database SchoolProfile / fallback)
        $sekolah = SchoolProfile::getVal('general');

        // 2. Data Sambutan Kepala Sekolah
        $kepsek = TeacherStaff::where('position', 'Kepala Sekolah')->first();
        $sambutanConfig = SchoolProfile::getVal('sambutan');
        $sambutan = [
            'nama' => $kepsek ? $kepsek->name : ($sambutanConfig['nama'] ?? 'Dr. H. Ahmad Fauzi, M.Pd.'),
            'jabatan' => $sambutanConfig['jabatan'] ?? 'Kepala Sekolah PKBM Tahfizh At-Tamam',
            'pesan' => $sambutanConfig['pesan'] ?? 'Selamat datang di portal resmi PKBM Tahfizh At-Tamam. Kami berdedikasi menciptakan lingkungan belajar Qurani yang inspiratif, berkarakter, dan relevan dengan kebutuhan masa depan.',
            'foto_initials' => $sambutanConfig['foto_initials'] ?? 'AF',
        ];

        // 3. Data Statistik Sekolah (Konfigurasi baseline marketing dari SchoolProfile, tanpa hardcoded math di logika)
        $statsConfig = SchoolProfile::getVal('stats');
        $baselineSiswa = (int) ($statsConfig['siswa_baseline'] ?? 0);
        $jumlahSiswa = PpdbRegistration::count() + $baselineSiswa;
        $jumlahGuruAktif = TeacherStaff::where('status', 'aktif')->count();
        $fallbackGuru = (int) ($statsConfig['guru_fallback'] ?? 85);
        $jumlahGuruDisplay = $jumlahGuruAktif > 0 ? $jumlahGuruAktif : $fallbackGuru;

        $stats = [
            ['label' => 'Siswa Terdaftar', 'value' => number_format($jumlahSiswa) . '+', 'icon' => '👨‍🎓', 'color' => '#eff6ff'],
            ['label' => 'Guru & Staf', 'value' => $jumlahGuruDisplay . ' Pengajar', 'icon' => '👩‍🏫', 'color' => '#ecfdf5'],
            ['label' => 'Jenjang Pendidikan', 'value' => $statsConfig['jenjang_label'] ?? '3 Jenjang (SD, SMP, SMK)', 'icon' => '🏫', 'color' => '#fffbeb'],
            ['label' => 'Serapan Kerja & Prestasi', 'value' => $statsConfig['serapan_prestasi'] ?? '96% Sukses', 'icon' => '🚀', 'color' => '#f3e8ff'],
        ];

        // 4. Data Jenjang Pendidikan (SD, SMP, SMK dari SchoolProfile)
        $jenjang = SchoolProfile::getVal('jenjang');
        foreach ($jenjang as &$j) {
            if (empty($j['link_daftar']) && isset($j['id'])) {
                $j['link_daftar'] = route('ppdb.create', ['jenjang' => $j['id']]);
            }
        }
        unset($j);

        // 5. Data Program Keahlian / Jurusan (Dinamis dari Database)
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
                'icon' => $item->icon ?? '⚡',
            ];
        })->toArray();

        // 6. Data Berita Terbaru (Dinamis dari Database)
        $berita = News::with('category')->latest()->take(3)->get()->map(function ($item) {
            return [
                'judul' => $item->title,
                'tanggal' => $item->created_at->translatedFormat('d F Y') ?? $item->created_at->format('d M Y'),
                'kategori' => $item->category ? $item->category->name : 'Umum',
                'ringkasan' => substr(strip_tags($item->content), 0, 120) . '...',
                'baca_waktu' => '3 menit baca',
            ];
        })->toArray();

        // Fallback jika database berita kosong
        if (empty($berita)) {
            $berita = [
                [
                    'judul' => 'Tim RPL PKBM Tahfizh At-Tamam Meraih Juara 1 LKS Pemrograman Web 2026',
                    'tanggal' => date('d F Y'),
                    'kategori' => 'Prestasi',
                    'ringkasan' => 'Siswa kami berhasil memboyong piala emas dalam kejuaraan Lomba Kompetensi Siswa tingkat provinsi.',
                    'baca_waktu' => '3 menit baca',
                ],
            ];
        }

        // 7. Data Cabang-Cabang Sekolah (Dinamis dari Database SchoolProfile)
        $cabang = SchoolProfile::getVal('cabang');
        $fasilitas = $cabang;

        // Kirim seluruh data ke view 'welcome'
        return view('welcome', compact('sekolah', 'sambutan', 'stats', 'jenjang', 'jurusan', 'berita', 'fasilitas', 'cabang'));
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
            'status' => 'pending',
            'notes' => 'Registrasi otomatis dari form kontak landing page',
        ]);

        // Catat log aktivitas admin/sistem
        ActivityLog::create([
            'user_id' => 1,
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

        // Konfigurasi baseline PPDB dari SchoolProfile, tanpa hardcoded math di logika
        $statsConfig = SchoolProfile::getVal('ppdb_stats', [
            'baseline_pendaftar' => 85,
            'baseline_diterima' => 60,
            'gelombang' => 'Gelombang II (Tahun Ajaran 2026/2027)',
            'deadline' => '30 Agustus 2026',
        ]);

        $totalPendaftar = PpdbRegistration::count() + (int) ($statsConfig['baseline_pendaftar'] ?? 0);
        $totalDiterima = PpdbRegistration::where('status', 'diterima')->count() + (int) ($statsConfig['baseline_diterima'] ?? 0);

        $stats = [
            'total' => $totalPendaftar,
            'diterima' => $totalDiterima,
            'gelombang' => $statsConfig['gelombang'] ?? 'Gelombang II (Tahun Ajaran 2026/2027)',
            'deadline' => $statsConfig['deadline'] ?? '30 Agustus 2026',
        ];

        return view('ppdb.index', compact('majors', 'stats'));
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

        // Simpan data pendaftaran
        $registration = PpdbRegistration::create([
            'jenjang' => $validated['jenjang'],
            'major_choice' => $validated['jenjang'] === 'smk' ? ($request->input('major_choice') ?: null) : null,
            'full_name' => $validated['full_name'],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
            'address' => $validated['address'],
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
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
            'description' => "Pendaftaran PPDB mandiri ({$registration->jenjang_label}) berhasil diajukan oleh {$registration->full_name} (No: {$registration->no_pendaftaran})",
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
