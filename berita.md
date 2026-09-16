# Rancangan Arsitektur & Desain Portal Berita Sekolah
**PKBM Tahfizh At-Tamam Edu**

---

## 1. Ringkasan & Tujuan

Dokumen ini memuat spesifikasi teknis dan desain antarmuka untuk perubahan rute serta pembuatan halaman portal berita mandiri (`/berita`). 

### Latar Belakang & Masalah
- Sebelumnya, menu navigasi **"Berita"** pada navbar desktop dan mobile hanya menautkan anchor hash internal ke bagian bawah landing page beranda (`/#berita`).
- Di halaman beranda, sistem hanya menampilkan maksimal 3 artikel terbaru (`take(3)`), sehingga arsip berita lama tidak dapat diakses publik dengan optimal.
- Pengunjung memerlukan halaman katalog berita tersendiri yang menampilkan seluruh informasi sekolah yang dipublikasikan oleh pihak pengelola.

### Tujuan Utama
1. Mengubah tautan navbar dari anchor `#berita` menjadi rute halaman penuh `GET /berita` (`route('berita.index')`).
2. Menghadirkan portal berita modern layaknya media profesional (featured hero headline, pencarian, filter kategori, kartu artikel responsif, dan pagination).
3. Mengintegrasikan tampilan portal berita secara otomatis dengan data artikel yang dikelola oleh Admin melalui modul CMS internal.
4. Menjaga konsistensi tema tampilan ganda (*Dark Mode* bernuansa *Deep Navy Glass* dan *Light Mode* bernuansa *Wine Crimson*).

---

## 2. Status Manajemen Data Berita Admin (CMS Eksisting)

Data berita dalam sistem ini **sudah siap dan dikelola sepenuhnya oleh Admin**. Seluruh artikel yang terbit di portal publik bersumber langsung dari modul CMS ini.

### 2.1 Model & Struktur Basis Data
- **Model Utama:** `App\Models\News`
  - `id`: Primary key
  - `category_id`: Relasi `belongsTo` ke `NewsCategory`
  - `title`: Judul artikel berita
  - `slug`: URL slug unik (otomatis dibuat dari judul)
  - `thumbnail`: Path atau URL gambar sampul artikel
  - `content`: Konten artikel (format teks/HTML)
  - `author_id`: Relasi `belongsTo` ke `User` (akun admin/guru pembuat artikel)
  - `published_at`: Tanggal & waktu publikasi artikel
- **Model Kategori:** `App\Models\NewsCategory`
  - `id`: Primary key
  - `name`: Nama kategori (contoh: *Prestasi*, *Akademik*, *Kegiatan Santri*, *Pengumuman*, *Umum*)
  - `slug`: Slug kategori untuk kebutuhan filter URL

### 2.2 Fitur Panel Admin (`/admin/news`)
Modul admin pada [`AdminController.php`](file:///C:/Users/Administrator/Documents/AttamamEdu/app/Http/Controllers/AdminController.php#L38) sudah mencakup:
1. **Daftar Berita (`GET /admin/news`):** Menampilkan tabel artikel berita, kategori, penulis, tanggal rilis, dan status (*Diterbitkan* vs *Draft/Jadwal*).
2. **Tambah Berita (`GET /admin/news/create` & `POST /admin/news`):** Form pengisian judul, kategori dinamis, thumbnail, konten, dan tanggal publikasi.
3. **Edit Berita (`GET /admin/news/{id}/edit` & `POST /admin/news/{id}`):** Memperbarui isi berita dan memperbarui slug otomatis.
4. **Hapus Berita (`DELETE /admin/news/{id}`):** Menghapus artikel beserta pencatatan ke `ActivityLog`.
5. **Hak Akses Role:** Dibatasi khusus untuk akun `super_admin` dan `admin_cms`.

---

## 3. Arsitektur Rute & Controller Publik

### 3.1 Definisi Rute (`routes/web.php`)
```php
// Route Portal Berita Publik
Route::get('/berita', [SchoolController::class, 'newsIndex'])->name('berita.index');

// Route Baca Detail Artikel Berita
Route::get('/berita/{slug}', [SchoolController::class, 'newsShow'])->name('news.show');
```

### 3.2 Logika Controller (`SchoolController@newsIndex`)
Method `newsIndex` pada [`SchoolController.php`](file:///C:/Users/Administrator/Documents/AttamamEdu/app/Http/Controllers/SchoolController.php) akan menangani:
1. **Pencarian Kata Kunci:**
   - Parameter: `?search=...`
   - Melakukan query `where(title, like, %...%)` atau `where(content, like, %...%)`.
2. **Filter Berdasarkan Kategori:**
   - Parameter: `?kategori=slug-kategori`
   - Melakukan filter melalui relasi `whereHas('category', ...)` berdasarkan slug kategori.
3. **Pemilihan Berita Utama (Headline):**
   - Mengambil 1 artikel terpopuler/terbaru yang memiliki gambar sampul untuk dijadikan *Featured Headline Hero*.
4. **Katalog Berita Berkelanjutan (Grid):**
   - Mengambil artikel tersisa dengan pagination (9 artikel per halaman) menggunakan `paginate(9)->withQueryString()`.
5. **Daftar Kategori Aktif:**
   - Mengambil semua kategori yang memiliki artikel (`withCount('news')`) untuk dijadikan tab navigasi filter.

---

## 4. Konsep Desain Antarmuka Portal Berita

Desain mengadopsi format portal editorial modern dengan hierarki visual yang jelas, tipografi seimbang, dan kartu interaktif:

### 4.1 Sketsa Wireframe Halaman
```
┌────────────────────────────────────────────────────────────────────────┐
│ NAVBAR KAPSUL (Brand | Beranda • Jenjang • Cabang • [BERITA*] | PPDB)   │
├────────────────────────────────────────────────────────────────────────┤
│ HEADER SECTION:                                                        │
│  "Kabar, Prestasi & Warta Sekolah"                                     │
│  Informasi resmi seputar agenda, prestasi, dan dinamika pembelajaran   │
├────────────────────────────────────────────────────────────────────────┤
│ FEATURED HERO HEADLINE (Berita Utama Terkini - Kartu Besar 16:9):      │
│ ┌──────────────────────────────┬─────────────────────────────────────┐ │
│ │                              │ [BADGE KATEGORI] • 2 jam lalu       │ │
│ │      GAMBAR THUMBNAIL        │ Judul Berita Utama yang Berbobot   │ │
│ │       UTAMA HERO             │ Cuplikan lead paragraph artikel...  │ │
│ │      (Aspect Ratio 16:9)     │ 👤 Admin Humas  •  ⏱️ 3 mnt baca   │ │
│ │                              │ [ Baca Selengkapnya ➔ ]             │ │
│ └──────────────────────────────┴─────────────────────────────────────┘ │
├────────────────────────────────────────────────────────────────────────┤
│ FILTER & SEARCH TOOLBAR:                                               │
│ [ 🔍 Cari judul artikel atau topik... ]                                │
│ Kategori: [Semua] [Prestasi] [Kegiatan Santri] [Akademik] [Pengumuman] │
├────────────────────────────────────────────────────────────────────────┤
│ GRID KATALOG BERITA (3 Kolom Responsif):                               │
│ ┌──────────────┐  ┌──────────────┐  ┌──────────────┐                   │
│ │ [Thumbnail]  │  │ [Thumbnail]  │  │ [Thumbnail]  │                   │
│ │ [Kategori]   │  │ [Kategori]   │  │ [Kategori]   │                   │
│ │ Judul Berita │  │ Judul Berita │  │ Judul Berita │                   │
│ │ Cuplikan...  │  │ Cuplikan...  │  │ Cuplikan...  │                   │
│ │ Tanggal • Wkt│  │ Tanggal • Wkt│  │ Tanggal • Wkt│                   │
│ └──────────────┘  └──────────────┘  └──────────────┘                   │
│ ┌──────────────┐  ┌──────────────┐  ┌──────────────┐                   │
│ │ [Thumbnail]  │  │ [Thumbnail]  │  │ [Thumbnail]  │                   │
│ │ Judul Berita │  │ Judul Berita │  │ Judul Berita │                   │
│ └──────────────┘  └──────────────┘  └──────────────┘                   │
├────────────────────────────────────────────────────────────────────────┤
│ PAGINATION NAVIGATOR:                                                  │
│   [ « Sebelumnya ]   [ 1 ]   [ 2 ]   [ 3 ]   [ Selanjutnya » ]         │
├────────────────────────────────────────────────────────────────────────┤
│ FOOTER SEKOLAH LENGKAP                                                 │
└────────────────────────────────────────────────────────────────────────┘
```

### 4.2 Spesifikasi Container Kartu Berita (Mengadopsi `<x-card>` Beranda)

Untuk menjaga konsistensi visual 100% dengan section berita di beranda (`welcome.blade.php`), container kartu di halaman `/berita` menggunakan komponen reusable **`<x-card>`** ([`resources/views/components/card.blade.php`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/components/card.blade.php)) yang baru saja diperbarui dengan efek *blurred color head*:

1. **Struktur & Anatomi Container (`custom-card tilt-card-3d`):**
   - **Efek 3D Tilt & Glare:** Atribut `data-tilt="true"` dan layer `<div class="card-glare">` untuk interaksi tilt 3D responsif terhadap gerakan kursor.
   - **Status Indikator Dot:** `<span class="card-status-dot">` pulsing dot di sudut kanan atas penanda konten aktif.
   - **Pilihan Tema Warna Dinamis:** Class `theme-primary` (Cyan), `theme-secondary` (Emerald), dan `theme-accent` (Amber) yang dipetakan per kategori atau rotasi dinamis.

2. **Area Gambar & Efek Visual Head:**
   - **Flush Image Wrapper:** `<div class="card-image-wrap">` dengan aspect-ratio gambar responsif dan transisi scale halus.
   - **Gradasi Overlay Blur Warna Head:** `<div class="card-image-overlay">` menciptakan gradasi warna lembut transisi antara foto sampul dan badan kartu (efek blur warna head).
   - **Frosted Badge dengan Dot:** `<div class="card-badge-container">` menampung `<span class="card-badge-blur theme-{{ $theme }}">` dengan `<span class="badge-dot">` bersinar sesuai tema warna kategori.
   - **Ambient Color Blur Glow:** `<div class="card-ambient-glow theme-{{ $theme }}">` pendaran cahaya warna lembut di belakang teks yang bereaksi saat kursor hover.

3. **Area Konten & Tipografi:**
   - **Meta Bar (Sebelum Judul):** Baris tanggal berikon kalender SVG (`card-meta-date`) dan estimasi waktu baca berikon jam SVG (`card-meta-read`), dipisahkan separator dot.
   - **Judul Berita Clamped:** `<h3 class="card-title">` dibatasi maksimal 2 baris (`-webkit-line-clamp: 2`) agar tinggi kartu tetap simetris, berbalut link interaktif.
   - **Cuplikan Ringkasan (Body):** `<p class="news-excerpt">` dibatasi 3 baris (`-webkit-line-clamp: 3`) dengan kontras teks ramah mata (`#cbd5e1` / `#fecdd3`).
   - **Tombol Baca Selengkapnya:** Baris pemisah tipis dengan aksi navigasi `<span>Baca Selengkapnya</span>` dan panah gerak `&rarr;` (`.read-more-arrow`).
   - **Explore Hint:** `<div class="card-explore-hint">` di kaki kartu bertuliskan *"Buka Artikel →"*.

4. **Container Featured Headline (Berita Utama):**
   - Menggunakan varian container kartu utama yang di-highlight di bagian atas, mempertahankan elemen visual yang sama (overlay blur head, frosted badge, ambient glow) dalam format horizontal lebar di desktop.

5. **Search & Filter Bar:**
   - Input field dengan background semi-transparan, ikon kaca pembesar, dan tombol *clear search* jika aktif.
   - Tombol pill kategori horizontal yang dapat digeser (*scrollable*) di perangkat mobile.

6. **Pagination Navigator:**
   - Navigasi halaman bernuansa kapsul modern yang selaras dengan tema sistem (mendukung URL parameter pelestarian filter).

---

## 5. Integrasi Sistem Tema Container (Dual-Theme Harmony)

Spesifikasi container kartu berita memanfaatkan token CSS dari [`style.css`](file:///C:/Users/Administrator/Documents/AttamamEdu/public/css/style.css) yang sudah terintegrasi untuk Dark Mode dan Light Mode:

| Komponen Container | Dark Mode (Default) | Light Mode (`data-theme="light"`) |
|---|---|---|
| **Latar Card (`.custom-card.card-with-image`)** | `rgba(0, 33, 71, 0.85)` / `oklch(22% 0.09 11)` | `oklch(27.1% 0.105 12.094 / 0.94)` |
| **Border Card** | `rgba(0, 180, 216, 0.35)` | `oklch(58.6% 0.253 17.585 / 0.35)` |
| **Card Image Overlay (Blur Head)** | Gradasi Gelap ke Navy Transparan | Gradasi Gelap ke Wine Maroon `oklch(27.1% 0.105 12.094 / 0.98)` |
| **Frosted Badge (`.card-badge-blur`)** | Frost Semi-transparan + Cyan/Emerald/Amber Glow | `oklch(20% 0.08 11 / 0.88)` + Wine/Rose Glow |
| **Ambient Color Blur Glow** | Radial Cyan `rgba(0, 180, 216, 0.26)` | Radial Crimson `oklch(58.6% 0.253 17.585 / 0.30)` |
| **Meta Icon & Read More Link** | Aksen Cyan `#38bdf8` | Aksen Rose/Crimson `oklch(75% 0.18 18)` |
| **Tombol Filter Aktif** | Background `#00B4D8`, Teks `#001529` | Background `oklch(58.6% 0.253 17.585)`, Teks `#ffffff` |

---

## 6. Integrasi Navbar & Status Indikator Aktif

### 6.1 Penyesuaian Tautan Navbar
1. **Desktop Navbar ([`navbar.blade.php`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/partials/navbar.blade.php#L34)):**
   - Mengubah tautan:
     ```blade
     <a href="{{ route('berita.index') }}" class="expandable-tab-btn {{ Request::is('berita*') ? 'active' : '' }}" data-section="berita" aria-label="Berita">
         <svg class="tab-icon" ...>...</svg>
         <span class="tab-label">Berita</span>
     </a>
     ```
2. **Mobile Panel ([`navbar.blade.php`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/partials/navbar.blade.php#L112)):**
   - Mengubah tautan:
     ```blade
     <a href="{{ route('berita.index') }}" class="nav-mobile-link {{ Request::is('berita*') ? 'active' : '' }}" data-section="berita">
         <span class="nav-mobile-icon-box">📰</span>
         <span class="nav-mobile-link-text">Berita & Informasi</span>
         <span class="nav-mobile-arrow" aria-hidden="true">›</span>
     </a>
     ```
3. **Komponen Navigasi React ([`main-navigation-tabs.tsx`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/js/components/ui/main-navigation-tabs.tsx)):**
   - Mengubah URL tab Berita dari `#berita` menjadi `/berita`.
   - Menambahkan deteksi URL aktif otomatis (`window.location.pathname.startsWith('/berita')`) agar tab nomor 3 terseleksi saat berada di halaman berita.

---

## 7. Rencana File yang Dibuat & Dimodifikasi

1. **File Baru:**
   - [`resources/views/news/index.blade.php`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/news/index.blade.php): Halaman katalog utama portal berita.
2. **File yang Dimodifikasi:**
   - [`routes/web.php`](file:///C:/Users/Administrator/Documents/AttamamEdu/routes/web.php): Pendaftaran rute `GET /berita`.
   - [`app/Http/Controllers/SchoolController.php`](file:///C:/Users/Administrator/Documents/AttamamEdu/app/Http/Controllers/SchoolController.php): Penambahan method `newsIndex()`.
   - [`resources/views/partials/navbar.blade.php`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/partials/navbar.blade.php): Penyesuaian tautan desktop dan mobile.
   - [`resources/js/components/ui/main-navigation-tabs.tsx`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/js/components/ui/main-navigation-tabs.tsx): Penyesuaian tab item & deteksi rute aktif.
   - [`public/css/style.css`](file:///C:/Users/Administrator/Documents/AttamamEdu/public/css/style.css): Styling lengkap portal berita (layout, grid, search bar, headline, pagination, dan dual-theme).

---

## 8. Rencana Pengujian Otomatis (Testing)

Pengujian dilakukan dengan menambahkan skenario pada test suite Laravel (`php artisan test`):
1. **Status HTTP 200:** Memastikan rute `/berita` dapat diakses secara publik tanpa login.
2. **Pencarian Artikel:** Memastikan pencarian artikel dengan query kata kunci menghasilkan artikel yang relevan.
3. **Filter Kategori:** Memastikan pemfilteran kategori hanya menampilkan berita dari kategori tersebut.
4. **Navigasi Navbar:** Memastikan tautan navbar mengarah ke rute `/berita` dan memiliki kelas aktif saat halaman diakses.
5. **Artikel Terhubung ke Admin:** Memastikan berita baru yang dibuat melalui panel admin langsung muncul pada halaman katalog portal berita.

---

## 9. Tahapan Eksekusi

- [x] **Langkah 1:** Tambahkan method `newsIndex()` pada `SchoolController.php` beserta query filter dan pagination.
- [x] **Langkah 2:** Daftarkan rute `Route::get('/berita', ...)` di `routes/web.php`.
- [x] **Langkah 3:** Buat template view `resources/views/news/index.blade.php` lengkap dengan komponen editorial berita dan container `<x-card>`.
- [x] **Langkah 4:** Perbarui tautan navbar desktop dan mobile di `resources/views/partials/navbar.blade.php` serta komponen React tabs.
- [x] **Langkah 5:** Tulis aturan CSS portal berita di `public/css/style.css` untuk Dark Mode dan Light Mode.
- [x] **Langkah 6:** Jalankan `php artisan test` untuk memastikan semua fitur dan pengujian berjalan tanpa kendala (44 passed).
- [x] **Langkah 7:** Sinkronkan knowledge graph proyek dengan `graphify update .`.
