# 📚 Panduan & Dokumentasi Struktur Folder Proyek
> **Proyek**: Redesign Website Sekolah & Sistem Informasi Manajemen PPDB Online — **At-Tamam Edu** (PKBM Tahfizh At-Tamam)  
> **Framework Utama**: Laravel 11 (PHP 8.2+), Blade Templating, Tailwind CSS, GSAP / ScrollSmoother, dan SweetAlert2.

Selamat datang di direktori dokumentasi struktur proyek. Folder `docs/` ini dibuat khusus untuk memberikan panduan lengkap mengenai fungsi, isi, dan tanggung jawab setiap folder yang ada di dalam codebase ini.

---

## 🗺️ Peta Navigasi Folder

Berikut adalah daftar dokumen penjelasan untuk setiap folder. Silakan klik tautan untuk membaca rincian lengkap tiap folder:

| No | Dokumen | Folder yang Dibahas | Deskripsi Singkat |
|---|---|---|---|
| 1 | [**01-app.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/01-app.md) | `app/` | Inti logika bisnis: Controllers, Models Eloquent, Middleware keamanan, Policies (RBAC), dan Providers. |
| 2 | [**02-resources.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/02-resources.md) | `resources/` | Antarmuka pengguna (UI): Template Blade (Admin, PPDB, Berita, Landing Page), CSS, JS, dan komponen UI. |
| 3 | [**03-routes.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/03-routes.md) | `routes/` | Pintu gerbang URL web: Rute publik, portal berita, alur pendaftaran PPDB, dan dashboard admin per peran. |
| 4 | [**04-database.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/04-database.md) | `database/` | Struktur data: Migrasi tabel database, seeders akun & data master, dan factories untuk pengujian otomatis. |
| 5 | [**05-public.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/05-public.md) | `public/` | Aset yang dapat diakses langsung oleh browser: CSS terkompilasi, JavaScript, logo, video animasi, dan gambar. |
| 6 | [**06-config-dan-bootstrap.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/06-config-dan-bootstrap.md) | `config/`, `bootstrap/` | Konfigurasi sistem (Auth, Session, Database) dan inisialisasi aplikasi Laravel 11 (`bootstrap/app.php`). |
| 7 | [**07-storage.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/07-storage.md) | `storage/` | Berkas dinamis: Unggahan dokumen persyaratan pendaftar (KK, Akta), cache view, session, dan catatan log aplikasi. |
| 8 | [**08-tests.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/08-tests.md) | `tests/` | Otomasi pengujian kualitas: Feature tests kontrol akses (RBAC), alur PPDB, keamanan header, dan unit tests. |
| 9 | [**09-components-dan-lib.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/09-components-dan-lib.md) | `components/`, `lib/` | Komponen modular UI (React/TypeScript) dan fungsi utilitas styling (`utils.ts` / classnames merge). |
| 10 | [**10-folder-sistem.md**](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/docs/10-folder-sistem.md) | `vendor/`, `node_modules/`, `.agents/`, `.git/` | Folder dependensi Composer, dependensi NPM Node.js, aturan AI Agent, dan riwayat version control Git. |

---

## 🌳 Diagram Pohon Struktur Direktori Utama

```
Redesign/
├── app/                      # Logika aplikasi (Controller, Model, Middleware, Policy)
├── bootstrap/                # File inisialisasi & bootstrapping Laravel 11
├── components/               # Komponen UI interaktif (React / TSX)
├── config/                   # File konfigurasi sistem (auth, database, session, dll.)
├── database/                 # Skema migrasi tabel, seeder data awal, & factories
├── docs/                     # [FOLDER INI] Dokumentasi lengkap struktur direktori
├── lib/                      # Utilitas pembantu TypeScript/JS (Tailwind merge utils)
├── node_modules/             # Modul dependensi JavaScript / NPM (dihiraukan git)
├── public/                   # Web root (index.php, CSS, JS, aset statis gambar & video)
├── resources/                # Source view Blade, CSS/JS sumber, dan komponen antarmuka
├── routes/                   # Definisi rute URL (web.php dan console.php)
├── storage/                  # Berkas unggahan PPDB, log aplikasi, dan compiled cache
├── tests/                    # Rangkaian automated testing (Feature & Unit tests)
├── vendor/                   # Paket dependensi PHP Composer (dihiraukan git)
├── .agents/                  # Aturan, skill, dan instruksi AI Assistant
├── .env / .env.example       # Variabel lingkungan (database credential, app key)
├── artisan                   # CLI command runner bawaan Laravel
├── composer.json             # Konfigurasi dependensi PHP & metadata proyek
├── package.json              # Konfigurasi dependensi JavaScript / frontend build
├── tailwind.config.js        # Konfigurasi tema warna, spacing, & breakpoint Tailwind
└── vite.config.js            # Konfigurasi bundler Vite untuk kompilasi aset frontend
```

---

## 💡 Panduan Cepat untuk Developer

1. **Ingin mengubah tampilan halaman depan (Landing Page)?**
   - Buka: [`resources/views/welcome.blade.php`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/resources/views/welcome.blade.php) dan styling di [`public/css/style.css`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/public/css/style.css).
2. **Ingin mengubah alur atau form pendaftaran PPDB?**
   - Form pendaftaran: [`resources/views/ppdb/create.blade.php`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/resources/views/ppdb/create.blade.php).
   - Logika pemrosesan data: [`app/Http/Controllers/SchoolController.php`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/app/Http/Controllers/SchoolController.php).
   - Model data: [`app/Models/PpdbRegistration.php`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/app/Models/PpdbRegistration.php).
3. **Ingin mengubah panel admin dan hak akses?**
   - Layout utama admin: [`resources/views/layouts/admin.blade.php`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/resources/views/layouts/admin.blade.php).
   - Otorisasi hak akses: [`app/Policies/`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/app/Policies/) dan [`app/Http/Middleware/CheckRole.php`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/app/Http/Middleware/CheckRole.php).
   - Pengendali rute admin: [`app/Http/Controllers/AdminController.php`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/app/Http/Controllers/AdminController.php) dan sub-controller di [`app/Http/Controllers/Admin/`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/app/Http/Controllers/Admin/).
4. **Ingin menambah rute URL baru?**
   - Buka: [`routes/web.php`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/routes/web.php).
