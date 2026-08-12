# 📚 Tutorial Step-by-Step Pengerjaan Website Landing Page Sekolah dengan Laravel

Dokumen ini disusun khusus sebagai panduan pengajaran bagi Guru/Tutor dalam membimbing siswa memahami pembuatan **Website Landing Page Sekolah Modern** menggunakan Framework **Laravel**.

---

## 🎯 1. Tujuan Pembelajaran

Setelah mengikuti panduan ini, siswa diharapkan mampu memahami:
1. Konsep dasar arsitektur **MVC (Model-View-Controller)** pada Laravel.
2. Pembuatan **Routing** (`Route::get` & `Route::post`).
3. Penggunaan **Controller** untuk mengelola data dan alur logika aplikasi.
4. Teknik **Blade Templating** (Layout Master `@extends`, Partials `@include`, dan Components `<x-card>`).
5. Pemrosesan **Formulir, Validasi Input, dan Notifikasi Flash Message** (`session('success')`).
6. Pengondisian autentikasi sederhana (`@auth` dan `@guest`).

---

## 🛠️ 2. Prasyarat & Cara Menjalankan Project

### A. Persiapan Software
- PHP 8.2 atau yang lebih baru.
- Composer.
- Web Browser (Chrome / Edge / Firefox).

### B. Perintah Membuat Project dari Nol (Untuk Contoh Siswa)
```bash
composer create-project laravel/laravel website-sekolah
cd website-sekolah
```

### C. Menjalankan Server Lokal Laravel
Jalankan perintah berikut di terminal:
```bash
php artisan serve
```
Akses website melalui browser pada alamat: **`http://127.0.0.1:8000`**

---

## 📁 3. Peta Struktur Folder & File Utama

Berikut adalah file-file penting yang kita buat dan modifikasi dalam project ini:

```text
laravel-13/
├── app/
│   └── Http/
│       └── Controllers/
│           └── SchoolController.php        <-- (Logika Data & Form Validation)
├── public/
│   └── css/
│       └── style.css                      <-- (Design System & Styling CSS Modern)
├── resources/
│   └── views/
│       ├── components/                    <-- (Blade Components Reusable)
│       │   ├── card.blade.php             
│       │   ├── section-header.blade.php   
│       │   └── stat-card.blade.php        
│       ├── layouts/
│       │   └── app.blade.php              <-- (Layout Master HTML utama)
│       ├── partials/
│       │   ├── navbar.blade.php           <-- (Header Navigation Bar)
│       │   └── footer.blade.php           <-- (Footer Sekolah)
│       └── welcome.blade.php              <-- (Halaman Utama Landing Page)
└── routes/
    └── web.php                            <-- (Pendaftaran URL / Route)
```

---

## 🚀 4. Step-by-Step Pengerjaan Website (Langkah Demi Langkah)

---

### 🔹 Langkah 1: Membuat CSS Design System (`public/css/style.css`)
Buat file baru di `public/css/style.css`. Gunakan CSS Variable agar siswa dapat mempelajari tata kelola warna dan layout yang rapi tanpa perlu menginstal pustaka luar.

**Fitur CSS yang Diterapkan:**
- Global reset & typography (`Plus Jakarta Sans`).
- Color palette modern (`--primary`, `--secondary`, `--accent`, `--surface`).
- Flexbox & CSS Grid responsif untuk tampilan kartu (card).
- Hover animations dan efek glassmorphism pada Hero Section.

---

### 🔹 Langkah 2: Membuat Master Layout (`resources/views/layouts/app.blade.php`)
Buat kerangka dasar HTML yang akan digunakan oleh seluruh halaman.

```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMK Negeri 1 Nusantara')</title>
    
    <!-- Google Fonts & Custom CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Navigasi -->
    @include('partials.navbar')

    <!-- Flash Message Success -->
    @if(session('success'))
        <div class="alert-success">
            ✨ {{ session('success') }}
        </div>
    @endif

    <!-- Konten Dinamis -->
    <main class="main-content">
        @yield('konten_utama')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
```

*Penjelasan untuk Siswa:*
- `@yield('konten_utama')`: Tempat di mana isi dari halaman anak (seperti `welcome.blade.php`) akan disisipkan.
- `@include('partials.navbar')`: Memanggil potongan kode HTML navbar agar file tidak menumpuk.
- `session('success')`: Menampilkan notifikasi hijau saat form berhasil dikirim.

---

### 🔹 Langkah 3: Membuat Navbar & Footer Partials

#### A. Navbar (`resources/views/partials/navbar.blade.php`)
Membuat navigasi sekolah lengkap dengan logo, menu, dan simulasi status Login Guru:
- `@guest`: Menampilkan tombol **Login Guru** jika pengguna belum login.
- `@auth`: Menampilkan nama guru yang sedang aktif dan tombol **Logout**.

#### B. Footer (`resources/views/partials/footer.blade.php`)
Membuat footer berisi alamat sekolah, nomor kontak, serta hak cipta website.

---

### 🔹 Langkah 4: Membuat Blade Components (Reusable UI)

Blade Component memungkinkan kita membuat elemen UI satu kali dan menggunakannya berulang kali secara bersih.

#### 1. Komponen Kartu (`resources/views/components/card.blade.php`)
```blade
@props(['title' => null, 'badge' => null, 'icon' => null, 'subtitle' => null])

<div class="custom-card">
    @if($title || $badge)
        <div class="card-header">
            <div>
                @if($icon) <span>{{ $icon }}</span> @endif
                <h3 class="card-title">{{ $title }}</h3>
                @if($subtitle)
                    <div style="font-size: 0.85rem; color: #64748b;">{{ $subtitle }}</div>
                @endif
            </div>
            @if($badge)
                <span class="badge">{{ $badge }}</span>
            @endif
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>
</div>
```

#### 2. Komponen Statistik (`resources/views/components/stat-card.blade.php`)
Menampilkan angka statistik sekolah (Jumlah Siswa, Guru, Jurusan, dll).

#### 3. Komponen Judul Seksi (`resources/views/components/section-header.blade.php`)
Menyediakan judul seksi yang seragam di seluruh landing page.

---

### 🔹 Langkah 5: Membuat Controller & Logika Data (`app/Http/Controllers/SchoolController.php`)

Jalankan perintah (atau buat file controller):
```bash
php artisan make:controller SchoolController
```

Isi dari `SchoolController.php`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        // Data Informasi Sekolah
        $sekolah = [
            'nama' => 'SMK Negeri 1 Nusantara',
            'slogan' => 'Mencetak Generasi Unggul, Berkarakter & Siap Kerja di Era Digital',
            'deskripsi' => 'Sekolah kejuruan berbasis teknologi dan kurikulum industri.',
            'tahun_berdiri' => '2005',
            'akreditasi' => 'A (Sangat Baik)',
            'alamat' => 'Jl. Pendidikan Teknologi No. 45, Cyber City',
            'telepon' => '(021) 555-0192',
            'email' => 'info@smkn1nusantara.sch.id'
        ];

        // Data Sambutan Kepala Sekolah
        $sambutan = [
            'nama' => 'Dr. H. Ahmad Fauzi, M.Pd.',
            'jabatan' => 'Kepala Sekolah SMK Negeri 1 Nusantara',
            'pesan' => 'Selamat datang di portal resmi SMK Negeri 1 Nusantara...',
            'foto_initials' => 'AF'
        ];

        // Data Statistik, Jurusan, Berita, & Fasilitas
        $stats = [...];
        $jurusan = [...];
        $berita = [...];
        $fasilitas = [...];

        // Mengirimkan data ke view 'welcome' menggunakan compact()
        return view('welcome', compact('sekolah', 'sambutan', 'stats', 'jurusan', 'berita', 'fasilitas'));
    }

    public function submitContact(Request $request)
    {
        // Validasi Form
        $validated = $request->validate([
            'nama' => 'required|min:3',
            'email' => 'required|email',
            'jurusan_minat' => 'required',
            'pesan' => 'required|min:10'
        ]);

        return redirect()->back()->with('success', 'Terima kasih ' . $validated['nama'] . '! Pesan Anda berhasil dikirim.');
    }
}
```

*Penjelasan untuk Siswa:*
- Array data di atas mensimulasikan data yang nantinya bisa diambil dari database MySQL (Model).
- `$request->validate(...)` memastikan inputan formulir terisi dengan benar.

---

### 🔹 Langkah 6: Mendaftarkan Route (`routes/web.php`)

Buka `routes/web.php` dan hubungkan controller:

```php
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\SchoolController;

// Route Halaman Utama Landing Page
Route::get('/', [SchoolController::class, 'index'])->name('home');

// Route Submit Form Kontak
Route::post('/kontak', [SchoolController::class, 'submitContact'])->name('kontak.submit');

// Route Simulasi Auth Guru (Untuk Edukasi Siswa)
Route::get('/login', function () {
    $user = User::firstOrCreate(
        ['email' => 'budi.guru@sekolah.sch.id'],
        ['name' => 'Budi Santoso, S.Pd. (Guru)', 'password' => bcrypt('password123')]
    );
    Auth::login($user);
    return redirect('/')->with('success', 'Berhasil Login sebagai Guru: Budi Santoso, S.Pd.!');
})->name('login');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Berhasil Logout.');
})->name('logout');
```

---

### 🔹 Langkah 7: Menyusun View Landing Page (`resources/views/welcome.blade.php`)

Di file `welcome.blade.php`, kita gunakan `@extends('layouts.app')` dan susun seksi-seksi berikut:
1. **Hero Section**: Banner utama dengan tombol CTA (Call to Action) PPDB.
2. **Stats Bar**: Menampilkan komponen `<x-stat-card>`.
3. **Sambutan Kepala Sekolah**: Card profil pimpinan sekolah.
4. **Program Keahlian**: Grid jurusan menggunakan `<x-card>`.
5. **Fasilitas & Berita**: Menampilkan sarana sekolah & pengumuman terbaru.
6. **Form Kontak & PPDB**: Form HTML lengkap dengan `@csrf`, `old('nama')`, dan pesan error `@error('nama')`.

---

## 💡 5. Ide Tugas & Latihan Mandiri untuk Siswa

Untuk menguji pemahaman siswa setelah mempraktikkan tutorial ini, berikan beberapa tantangan berikut:

1. 🌟 **Tantangan 1 (Database Integration)**:
   Ubah data array `$jurusan` di `SchoolController.php` agar diambil dari database MySQL menggunakan Migration & Model Laravel (`php artisan make:model Jurusan -m`).

2. 🌟 **Tantangan 2 (Halaman Detail Jurusan)**:
   Buat route baru `Route::get('/jurusan/{id}', ...)` dan view `resources/views/jurusan/detail.blade.php` untuk menampilkan rincian kurikulum jurusan yang diklik.

3. 🌟 **Tantangan 3 (Upload File Persyaratan PPDB)**:
   Tambahkan input `file` pada form pendaftaran untuk unggah berkas Raport / IJAZAH menggunakan `enctype="multipart/form-data"` dan `$request->file('berkas')->store(...)`.

---

## 📌 Kesimpulan

Dengan struktur project yang bersih ini, siswa dapat mempelajari fondasi utama Laravel secara lengkap—mulai dari tampilan antarmuka (UI/Blade), pengiriman data dari controller, alur routing, hingga validasi form interaktif. Selamat mengajar! 🎉

---

## 👩‍🏫 6. Panduan Khusus & Silabus 4 Jam Pengerjaan (Pendekatan Visual & Ramah Siswi)

Bagian ini disusun khusus untuk membantu siswa/siswi yang membutuhkan **pendekatan visual, terstruktur, dan step-by-step** agar tidak merasa cemas atau bingung saat mempelajari Laravel.

### 💡 A. Analogi Dunia Nyata: "Metode Restoran Kafe"
Jelaskan alur kerja Laravel MVC menggunakan analogi restoran sebelum memulai koding:

| Komponen Laravel | Analogi Restoran | Peran & Tugasnya |
| :--- | :--- | :--- |
| **`routes/web.php`** | **Pramusaji / Kasir** | Menerima pesanan pesanan dari pengunjung (URL di browser). |
| **`Controller`** | **Koki / Chef** | Mengolah pesanan, mengambil bahan makanan, dan menyiapkan hidangan. |
| **`Model` / Database** | **Gudang Bahan** | Tempat menyimpan data mentah (data siswa, guru, dsb.). |
| **`Blade View`** | **Piring & Hiasan Makanan** | Tampilan akhir cantik yang disajikan kepada pembeli (HTML & CSS). |

---

### 📁 B. Peta & Panduan Lokasi File (Cheat Sheet)

```text
AttamamEdu/ (Folder Utama Project)
│
├── 🌐 routes/
│   └── web.php                           <-- 1. Pintu Masuk URL (Daftar Alamat Halaman)
│
├── 🧠 app/Http/Controllers/
│   └── SchoolController.php             <-- 2. Otak Aplikasi (Koki Pemproses Data & Form)
│
├── 🎨 public/css/
│   └── style.css                         <-- 3. Tampilan Visual (Desain Warna & Layout)
│
└── 🖼️ resources/views/                   <-- 4. Komponen Halaman HTML (Blade)
    ├── layouts/
    │   └── app.blade.php                 <-- Master Layout (Bingkai Utama Website)
    ├── partials/
    │   ├── navbar.blade.php              <-- Menu Navigasi Atas
    │   └── footer.blade.php              <-- Bagian Bawah Website
    ├── components/
    │   └── card.blade.php                <-- Kartu Informasi Reusable
    └── welcome.blade.php                 <-- Halaman Utama Landing Page
```

---

### ⏱️ C. Silabus & Materi Pembelajaran 4 Jam Pengerjaan

#### 🕒 Jam Ke-1: Mental Map, Peta File & Tampilan Visual (60 Menit)
* **Fokus:** Mengubah teks/warna dasar & menjalankan server tanpa rasa takut error.
1. Minta siswi membuka `public/css/style.css` dan mengganti warna tema (`--primary`, `--accent`).
2. Minta siswi membuka `resources/views/welcome.blade.php` untuk mengubah judul utama sekolah.
3. Jalankan `php artisan serve` dan lihat hasilnya di browser `http://127.0.0.1:8000`.

#### 🕒 Jam Ke-2: Menghubungkan Halaman & Master Layout (60 Menit)
* **Fokus:** Memahami `@extends`, `@yield`, dan `@include`.
1. Membuat bingkai utama di `resources/views/layouts/app.blade.php` dengan `@yield('konten_utama')`.
2. Membuat `navbar.blade.php` dan `footer.blade.php` di folder `partials/`.
3. Menghubungkan halaman `welcome.blade.php` menggunakan `@extends('layouts.app')`.

#### 🕒 Jam Ke-3: Controller & Pengiriman Data Sederhana (60 Menit)
* **Fokus:** Mengirim data daftar (Array) dari Controller ke View menggunakan `@foreach`.
1. Membuka `app/Http/Controllers/SchoolController.php` dan menyiapkan array data `$jurusan`.
2. Mengirim data ke view menggunakan `return view('welcome', compact('jurusan'));`.
3. Menampilkan kartu jurusan secara dinamis di `welcome.blade.php` dengan sintaks `@foreach`.

#### 🕒 Jam Ke-4: Formulir Kontak, Validasi & Notifikasi (60 Menit)
* **Fokus:** Menangani input formulir user dan menampilkan notifikasi sukses.
1. Daftarkan route POST di `routes/web.php`: `Route::post('/kontak', [SchoolController::class, 'submitContact'])`.
2. Buat fungsi `submitContact` dengan validasi `$request->validate()` dan pengembalian `back()->with('success', ...)`.
3. Buat Form HTML di `welcome.blade.php` lengkap dengan `@csrf`.
4. Tambahkan notifikasi `session('success')` di `layouts/app.blade.php`.

