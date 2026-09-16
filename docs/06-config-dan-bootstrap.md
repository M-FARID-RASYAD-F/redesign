# ⚙️ Folder `config/` & `bootstrap/` — Konfigurasi & Inisialisasi Sistem

Folder `config/` dan `bootstrap/` mengatur cara kerja internal framework **Laravel 11**, mulai dari inisialisasi lingkungan (*bootstrap lifecycle*), koneksi database, manajemen sesi, hingga parameter keamanan aplikasi.

---

## 🗂️ 1. Folder `bootstrap/` — Bootstrapping Aplikasi

Pada Laravel 11, proses inisialisasi disederhanakan secara terpadu di dalam berkas:

```
bootstrap/
├── app.php                  # Pusat pendaftaran routing, middleware, dan exception handler
└── cache/                   # Cache konfigurasi, paket, dan rute untuk performa produksi
```

### Penjelasan `bootstrap/app.php`:
- **Routing**: Menetapkan berkas rute web (`routes/web.php`), console (`routes/console.php`), serta health-check URL (`/up`).
- **Middleware Pipeline**: Mendaftarkan middleware global, grup `web`, serta alias middleware seperti:
  - `role` ➔ [`App\Http\Middleware\CheckRole`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/app/Http/Middleware/CheckRole.php)
  - `active` ➔ [`App\Http\Middleware\EnsureUserIsActive`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/app/Http/Middleware/EnsureUserIsActive.php)
  - `security.headers` ➔ [`App\Http\Middleware\SecurityHeadersMiddleware`](file:///C:/Users/Administrator/Desktop/asyraf%20hafizzurahman/A/Redesign/app/Http/Middleware/SecurityHeadersMiddleware.php)
- **Exception Handling**: Mengatur cara aplikasi merespon kegagalan otorisasi (`403 Forbidden`) atau halaman tidak ditemukan (`404 Not Found`).

---

## 🗂️ 2. Folder `config/` — Pengaturan Konfigurasi Terpusat

Setiap berkas konfigurasi di folder ini membaca nilai default dari file environment `.env`:

```
config/
├── app.php                  # Identitas aplikasi, zona waktu (Asia/Jakarta), dan bahasa (id)
├── auth.php                 # Driver autentikasi, guard web, model User, dan hashing password
├── database.php             # Pengaturan koneksi database MySQL, SQLite, dan Redis
├── filesystems.php          # Driver penyimpanan disk (local, public, S3)
├── logging.php              # Kanal pencatatan log error (single, daily, stack)
├── session.php              # Keamanan sesi browser, masa aktif, enkripsi cookie, dan SameSite
├── cache.php                # Driver penyimpanan cache memori (file, redis, database)
└── cors.php                 # Pengaturan Cross-Origin Resource Sharing untuk API
```

---

## 🔍 Sorotan Konfigurasi Kritis:

1. **`config/auth.php`**:
   - Mengonfigurasi guard default `web` yang menggunakan driver sesi.
   - Mengarahkan otentikasi ke model `App\Models\User::class` dengan hashing modern *Bcrypt / Argon2id*.

2. **`config/session.php`**:
   - Dikonfigurasi dengan atribut keamanan tinggi:
     - `secure => env('SESSION_SECURE_COOKIE', false)` (Otomatis bernilai `true` di lingkungan produksi HTTPS).
     - `http_only => true` (Mencegah cookie sesi diakses melalui JavaScript / anti serangan XSS).
     - `same_site => 'lax'` (Mencegah serangan CSRF antar-domain).

3. **`config/filesystems.php`**:
   - Mengatur disk `public` dengan *root path* di `storage/app/public` dan URL `/storage`, tempat dokumen pendaftaran PPDB disimpan.
