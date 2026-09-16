# 🌐 Folder `public/` — Berkas Statis & Web Root (Public Web Assets)

Folder `public/` adalah satu-satunya folder dalam aplikasi yang dipaparkan langsung ke internet oleh Web Server (Apache/Nginx). Semua permintaan HTTP yang masuk pertama kali diterima oleh berkas `index.php` di dalam folder ini.

---

## 🗂️ Struktur Subdirektori `public/`

```
public/
├── .htaccess                # Konfigurasi Apache: Rewrite URL, Gzip, dan proteksi berkas
├── Animasi Logo.mp4         # Video aset animasi opening / splash screen logo sekolah
├── build/                   # Hasil kompilasi bundler Vite (CSS/JS berversi hash)
├── css/                     # Berkas CSS utama yang dimuat browser
│   └── style.css            # Desain sistem kustom (Dark/Light Mode, tipografi, animasi)
├── favicon.ico              # Ikon tab browser sekolah
├── fonts/                   # Font lokal (jika dimuat secara offline)
├── images/                  # Aset gambar statis (logo sekolah, banner, ilustrasi)
├── index.php                # Entry point utama aplikasi Laravel
├── js/                      # Script interaktivitas frontend
│   └── scroll-reveal.js     # Engine animasi scroll reveal bidirectional berbasis cubic-bezier
├── robots.txt               # Petunjuk pengindeksan untuk mesin pencari (Googlebot)
├── sekolah.jpg              # Foto utama gedung / kampus At-Tamam Edu
└── storage/                 # Symlink direktori (menunjuk ke storage/app/public)
```

---

## 1. Berkas Utama `public/index.php`

- Merupakan titik masuk tunggal (*Single Point of Entry*) bagi seluruh request pengguna.
- Menginisialisasi autoloader Composer (`vendor/autoload.php`), melakukan bootstrap aplikasi Laravel (`bootstrap/app.php`), menerima request HTTP, dan mengirimkan respon kembali ke browser.

---

## 2. Berkas `public/css/style.css`

Merupakan pusat desain sistem visual aplikasi yang dirancang dengan sangat detail:
- **Dual-Theme Engine Tokens**:
  - **Dark Mode (Oxford Navy)**: Kombinasi latar `#001529` dengan aksen neon cyan `#00B4D8` yang modern dan berkesan teknologi tinggi.
  - **Light Mode (Crimson Rose / Deep Maroon)**: Warna latar elegan berkarakter hangat dengan kombinasi maroon dan mawar anggun (`oklch(41% 0.159 10.272)`).
- **Komponen Kustom**: Styling kartu glassmorphism, tombol glow, badge status, tabel responsif admin, dan penataan formulir pendaftaran PPDB.
- **Micro-Interactions**: Transisi halus saat tombol disentuh atau disentuh kursor (*hover/focus*).

---

## 3. Berkas `public/js/scroll-reveal.js`

- Engine script animasi scroll dua arah (*bidirectional scroll reveal*).
- Menghadirkan efek elemen melayang masuk (*fade-in / slide-up*) saat user menggulir layar ke bawah, dan kembali bersiap secara mulus saat digulir ke atas dengan kurva transisi *cubic-bezier*.
- Terintegrasi dengan mulus bersama pustaka GSAP dan ScrollSmoother.

---

## 4. Tautan Simbolik `public/storage/`

- Tautan simbolis (*symlink*) yang dibuat melalui perintah `php artisan storage:link`.
- Menghubungkan direktori `public/storage` ke folder asli `storage/app/public`.
- Memungkinkan berkas dokumen digital PPDB, avatar admin, atau foto thumbnail berita yang diunggah pengguna dapat diakses dan ditampilkan di browser secara aman.

---

## 5. Berkas Konfigurasi Server (`.htaccess` & `robots.txt`)

- **`.htaccess`**:
  - Mengarahkan semua rute URL ke `index.php` (*URL Rewriting*).
  - Mencegah akses langsung ke berkas tersembunyi (`.env`, `.git`).
  - Mengaktifkan kompresi Gzip/Brotli untuk mempercepat pemuatan halaman web di browser.
- **`robots.txt`**:
  - Mengizinkan mesin pencari merayapi halaman publik seperti `/`, `/ppdb`, dan `/berita`, namun melarang perayapan pada rute internal `/admin/*`.
