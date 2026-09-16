# 🎨 Folder `resources/` — Tampilan Antarmuka & Aset Sumber (UI & Views)

Folder `resources/` berisi seluruh kode antarmuka pengguna (Frontend), template tampilan HTML dinamis berbasis **Laravel Blade**, komponen modular, serta berkas sumber CSS dan JavaScript yang diproses oleh bundler Vite.

---

## 🗂️ Struktur Subdirektori `resources/`

```
resources/
├── css/                     # Sumber style CSS modern & import Tailwind
│   └── app.css              # Entry point Tailwind CSS
├── js/                      # Sumber JavaScript / TypeScript aplikasi
│   ├── app.js               # Entry point bundler Vite
│   └── components/          # Bridge komponen React / TypeScript
└── views/                   # Template Blade HTML dinamis
    ├── admin/               # Panel dashboard dan modul administrasi
    ├── auth/                # Halaman login otentikasi
    ├── components/          # Komponen Blade reusable (Card, Tabs, StatCard)
    ├── errors/              # Halaman error HTTP khusus (403, 404, 500)
    ├── layouts/             # Master layout pembungkus halaman (Admin & App)
    ├── news/                # Portal berita mandiri publik (/berita)
    ├── partials/            # Potongan tampilan bersama (Navbar, Footer, Modal)
    ├── ppdb/                # Halaman alur pendaftaran PPDB Online publik
    └── welcome.blade.php    # Halaman utama (Landing Page Sekolah)
```

---

## 1. Subfolder `resources/views/layouts/` (Master Layout)

Layout master membungkus seluruh halaman agar struktur HTML, head, script, dan tema tetap konsisten di seluruh website:

1. **`layouts/app.blade.php`**:
   - Master layout untuk halaman publik (Landing Page, PPDB, Berita).
   - Memuat font Google (Plus Jakarta Sans, Inter, JetBrains Mono), meta tags responsif, ScrollSmoother/GSAP wrapper, notifikasi flash message sukses, navbar, konten utama (`@yield('konten_utama')`), footer, dan tombol WhatsApp mengambang.
2. **`layouts/admin.blade.php`**:
   - Master layout untuk panel administrasi sekolah.
   - Dilengkapi **Dual-Theme Engine** (Dark Mode `Oxford Navy` & Light Mode `Crimson Rose`), topbar dengan tombol pemilih tema (*theme switcher*), navigasi sidebar dinamis dengan ikon vektor SVG, sistem modal konfirmasi hapus berbasis SweetAlert2, dan penanganan session alert.

---

## 2. Subfolder `resources/views/admin/` (Panel Admin Multi-Role)

Panel admin dibagi secara modular sesuai tugas dan perannya:

### A. Subfolder `dashboards/`:
- **`superadmin.blade.php`**: Ringkasan performa sistem keseluruhan, statistik gabungan, audit log ringkas, dan shortcut kelola user.
- **`cms.blade.php`**: Manajemen konten artikel berita, agenda kegiatan, pengumuman, dan galeri dokumentasi kegiatan sekolah.
- **`ppdb.blade.php`**: Monitoring antrean pendaftaran PPDB, visualisasi jenjang (SD, SMP, SMK), status verifikasi berkas, dan tombol unduh rekap.
- **`akademik.blade.php`**: Monitoring tenaga pendidik, sebaran pengajar aktif, dan data program keahlian/jurusan.

### B. Modul CRUD Admin:
- **`ppdb/index.blade.php` & `ppdb/show.blade.php`**: Tabel pendaftar lengkap dengan filter interaktif jenjang dan status seleksi, tombol unduh CSV/ZIP, serta halaman detail verifikasi berkas fisik/digital pendaftar.
- **`users/` (`index.blade.php`, `create.blade.php`, `edit.blade.php`)**: Manajemen akun administrator beserta penetapan perannya.
- **`teachers/index.blade.php`**: Daftar guru dan staf pendidik.
- **`majors/` (`index.blade.php`, `create.blade.php`, `edit.blade.php`)**: Manajemen data jurusan kejuruan SMK.
- **`news/index.blade.php`**: Daftar dan filter postingan artikel berita.

---

## 3. Subfolder `resources/views/ppdb/` (Alur Pendaftaran Publik)

- **`index.blade.php`**: Beranda informasi PPDB, persyaratan umum, alur tahapan seleksi, dan biaya/fasilitas.
- **`create.blade.php`**: Formulir pendaftaran calon peserta didik baru multi-jenjang (SD, SMP, SMK) dilengkapi upload digital dokumen KK, Akta Lahir, dan Ijazah.
- **`success.blade.php`**: Halaman konfirmasi setelah formulir berhasil dikirim, menampilkan nomor registrasi unik dan petunjuk langkah selanjutnya.
- **`tracking.blade.php`**: Halaman pelacakan status seleksi mandiri oleh calon siswa/orang tua hanya dengan memasukkan Nomor Pendaftaran dan Tanggal Lahir.

---

## 4. Subfolder `resources/views/news/` (Portal Berita Publik)

- **`index.blade.php`**: Katalog artikel berita dengan fitur filter kategori, pencarian artikel, dan kartu berita bertema modern.
- **`show.blade.php`**: Halaman baca artikel lengkap dengan metadata penulis, tanggal rilis, dan rekomendasi artikel terkait.

---

## 5. Subfolder `resources/views/partials/` (Komponen Parsial)

- **`navbar.blade.php`**: Navigasi bar atas publik yang responsif, mendukung transisi tema, menu dropdown jenjang, dan menu mobile drawer.
- **`footer.blade.php`**: Bagian bawah halaman publik berisi profil singkat sekolah, tautan cepat, media sosial, kontak, dan alamat Google Maps.
- **`logout-modal.blade.php`**: Dialog konfirmasi logout dengan animasi orbit modern dan pesan peringatan keamanan sesi.
- **`whatsapp-button.blade.php`**: Tombol kontak WhatsApp melayang di sudut layar untuk konsultasi pendaftaran langsung ke panitia PPDB.

---

## 6. Subfolder `resources/views/components/` (Komponen Blade Modular)

- **`card.blade.php`**: Kartu tampilan serbaguna dengan efek glassmorphism, border glow, dan hover halus.
- **`stat-card.blade.php`**: Kartu visualisasi angka statistik yang digunakan pada dashboard admin.
- **`animated-tabs.blade.php`**: Tab interaktif dengan transisi mulus untuk memilah konten profil jenjang sekolah.

---

## 7. `resources/views/welcome.blade.php` (Landing Page)

Halaman muka utama sekolah yang mencakup:
- Hero section dinamis dengan slogan dan tombol aksi PPDB.
- Pengenalan profil yayasan dan lembaga pendidikan At-Tamam Edu.
- Sorotan program jenjang pendidikan (SD Islam Terpadu, SMP IT, dan SMK Kejuruan).
- Galeri prestasi dan fasilitas sekolah.
- Testimoni dan artikel berita terbaru.
