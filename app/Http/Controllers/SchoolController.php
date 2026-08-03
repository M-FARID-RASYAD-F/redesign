<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Menampilkan Landing Page Utama Website Sekolah
     */
    public function index()
    {
        // 1. Data Informasi Sekolah
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
        $sambutan = [
            'nama' => 'Dr. H. Ahmad Fauzi, M.Pd.',
            'jabatan' => 'Kepala Sekolah SMK Negeri 1 Nusantara',
            'pesan' => 'Selamat datang di portal resmi SMK Negeri 1 Nusantara. Kami berdedikasi menciptakan lingkungan belajar yang inspiratif, inovatif, dan relevan dengan kebutuhan dunia kerja masa depan. Mari bersama mewujudkan impian dan potensi terbaik para siswa!',
            'foto_initials' => 'AF'
        ];

        // 3. Data Statistik Sekolah
        $stats = [
            ['label' => 'Siswa Aktif', 'value' => '1,250+', 'icon' => '👨‍🎓', 'color' => '#eff6ff'],
            ['label' => 'Guru & Staf', 'value' => '85 Pengajar', 'icon' => '👩‍🏫', 'color' => '#ecfdf5'],
            ['label' => 'Program Keahlian', 'value' => '4 Jurusan', 'icon' => '💻', 'color' => '#fffbeb'],
            ['label' => 'Serapan Kerja', 'value' => '94% Pertahun', 'icon' => '🚀', 'color' => '#f3e8ff'],
        ];

        // 4. Data Program Keahlian / Jurusan
        $jurusan = [
            [
                'id' => 'rpl',
                'nama' => 'Rekayasa Perangkat Lunak (RPL)',
                'kategori' => 'Teknologi Informasi',
                'deskripsi' => 'Mempelajari pemrograman web (Laravel, React), aplikasi mobile, basis data, dan pengembangan software berbasis industri.',
                'prospek' => 'Fullstack Developer, Web Developer, Mobile App Engineer',
                'badge' => '🔥 Paling Favorit',
                'icon' => '⚡'
            ],
            [
                'id' => 'tkj',
                'nama' => 'Teknik Komputer & Jaringan (TKJ)',
                'kategori' => 'Teknologi Informasi',
                'deskripsi' => 'Fokus pada arsitektur jaringan komputer, administrasi server Linux/Windows, cloud computing, dan siber security.',
                'prospek' => 'Network Engineer, Cloud Administrator, Cybersecurity Specialist',
                'badge' => '🌐 Sertifikasi Cisco/Mikrotik',
                'icon' => '📡'
            ],
            [
                'id' => 'dkv',
                'nama' => 'Desain Komunikasi Visual (DKV)',
                'kategori' => 'Industri Kreatif',
                'deskripsi' => 'Mengembangkan kreativitas seni visual, desain grafis, fotografi, videografi, serta desain UI/UX aplikasi digital.',
                'prospek' => 'UI/UX Designer, Graphic Designer, Video Editor, Creative Director',
                'badge' => '🎨 Studio Kreatif Komplit',
                'icon' => '✨'
            ],
            [
                'id' => 'akl',
                'nama' => 'Akuntansi & Keuangan Lembaga (AKL)',
                'kategori' => 'Bisnis & Manajemen',
                'deskripsi' => 'Menguasai pengelolaan keuangan digital, perbankan syariah, pembukuan komputerisasi (Accurate/MYOB), dan pajak.',
                'prospek' => 'Staf Keuangan, Financial Analyst, Akuntan Publik Junior',
                'badge' => '📊 Lab Keuangan Digital',
                'icon' => '💼'
            ]
        ];

        // 5. Data Berita Terbaru
        $berita = [
            [
                'judul' => 'Tim RPL SMKN 1 Nusantara Meraih Juara 1 LKS Pemrograman Web 2026',
                'tanggal' => '28 Juli 2026',
                'kategori' => 'Prestasi',
                'ringkasan' => 'Siswa kami berhasil memboyong piala emas dalam kejuaraan Lomba Kompetensi Siswa tingkat provinsi.',
                'baca_waktu' => '3 menit baca'
            ],
            [
                'judul' => 'Penandatanganan MoU Kemitraan Kerja dengan 12 Perusahaan IT Nasional',
                'tanggal' => '18 Juli 2026',
                'kategori' => 'Kerjasama DUDI',
                'ringkasan' => 'Memperluas jangkauan magang dan rekrutmen lulusan secara langsung sebelum wisuda kelulusan.',
                'baca_waktu' => '2 menit baca'
            ],
            [
                'judul' => 'Pembukaan Pendaftaran Siswa Baru (PPDB) Gelombang 2 Tahun 2026/2027',
                'tanggal' => '05 Juli 2026',
                'kategori' => 'Pengumuman',
                'ringkasan' => 'Informasi lengkap persyataan dan alur pendaftaran calon peserta didik baru dapat diakses di portal ini.',
                'baca_waktu' => '5 menit baca'
            ]
        ];

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
     * Memproses Form Simulasi Pendaftaran / Kontak dari Pengunjung
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

        // Kirim response flash message kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Halo ' . $validated['nama'] . ', terima kasih! Pesan dan pendaftaran informasi Anda mengenai jurusan ' . strtoupper($validated['jurusan_minat']) . ' telah berhasil terkirim' . $berkasInfo . '.');
    }
}
