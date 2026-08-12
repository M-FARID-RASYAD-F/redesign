<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolProfile;
use App\Models\Major;
use App\Models\News;
use App\Models\TeacherStaff;
use App\Models\PpdbRegistration;
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
            'nama' => 'SMK Negeri 1 Nusantara',
            'slogan' => 'Mencetak Generasi Unggul, Berkarakter & Siap Kerja di Era Digital',
            'deskripsi' => 'Sekolah menengah kejuruan terkemuka yang memadukan kurikulum industri modern, pembentukan karakter mulia, dan fasilitas pembelajaran digital.',
            'tahun_berdiri' => '2005',
            'akreditasi' => 'A (Sangat Baik)',
            'alamat' => 'Jl. Pendidikan Teknologi No. 45, Cyber City, Nusantara',
            'telepon' => '(021) 555-0192',
            'email' => 'info@smkn1nusantara.sch.id'
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
            ['label' => 'Program Keahlian', 'value' => ($jumlahJurusan > 0 ? $jumlahJurusan : 4) . ' Jurusan', 'icon' => '💻', 'color' => '#fffbeb'],
            ['label' => 'Serapan Kerja', 'value' => '94% Pertahun', 'icon' => '🚀', 'color' => '#f3e8ff'],
        ];

        // 4. Data Program Keahlian / Jurusan (Dinamis dari Database)
        $jurusan = Major::all()->map(function ($item) {
            $badges = [
                'rekayasa-perangkat-lunak-rpl' => '🔥 Paling Favorit',
                'teknik-komputer-jaringan-tkj' => '🌐 Sertifikasi Cisco/Mikrotik',
                'desain-komunikasi-visual-dkv' => '🎨 Studio Kreatif Komplit',
                'akuntansi-keuangan-lembaga-akl' => '📊 Lab Keuangan Digital',
            ];

            return [
                'id' => $item->slug,
                'nama' => $item->name,
                'kategori' => str_contains($item->slug, 'akl') ? 'Bisnis & Manajemen' : (str_contains($item->slug, 'dkv') ? 'Industri Kreatif' : 'Teknologi Informasi'),
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

        // 6. Data Fasilitas Utama
        $fasilitas = [
            ['nama' => 'Lab Komputer High-End', 'deskripsi' => 'Lab modern dengan 120 unit PC Core i7, GPU dedicated, dan koneksi High Speed Fiber Optic.', 'icon' => '🖥️'],
            ['nama' => 'Perpustakaan Digital Hub', 'deskripsi' => 'Akses ribuan e-book, repositori karya siswa, serta ruang baca ber-AC yang nyaman.', 'icon' => '📚'],
            ['nama' => 'Studio Animasi & Podcast', 'deskripsi' => 'Fasilitas produksi konten audio-visual standar industri kreatif penyiaran.', 'icon' => '🎙️'],
            ['nama' => 'Lapangan Olahraga Multifungsi', 'deskripsi' => 'Fasilitas outdoor & indoor untuk futsal, basket, voli, dan kegiatan kebugaran.', 'icon' => '⚽']
        ];

        // Kirim seluruh data ke view 'welcome'
        return view('welcome', compact('sekolah', 'sambutan', 'stats', 'jurusan', 'berita', 'fasilitas'));
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
}

