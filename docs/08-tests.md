# 🧪 Folder `tests/` — Pengujian Otomatis & Jaminan Kualitas (Automated Testing)

Folder `tests/` berisi rangkaian pengujian otomatis (*automated test suite*) berbasis **PHPUnit** untuk memastikan bahwa setiap fitur, hak akses (RBAC), alur pendaftaran PPDB, dan mekanisme keamanan bekerja 100% andal tanpa *regression* (kerusakan fitur lama).

---

## 🗂️ Struktur Subdirektori `tests/`

```
tests/
├── Feature/                 # Pengujian integrasi alur HTTP, otentikasi, dan database
│   ├── Auth/                # Pengujian login, logout, dan pengalihan peran
│   │   └── AuthenticationTest.php
│   ├── NewsPortalTest.php   # Pengujian rute portal berita publik (/berita)
│   ├── PpdbMultiLevelTest.php # Pengujian pendaftaran lintas jenjang (SD, SMP, SMK)
│   ├── PpdbWorkflowTest.php # Pengujian alur lengkap pendaftaran, tracking, & verifikasi
│   ├── RbacTest.php         # Pengujian izin hak akses berbasis peran (Super Admin, CMS, PPDB, Akademik)
│   └── SecurityHardeningTest.php # Pengujian header HTTP, perlindungan XSS & clickjacking
├── TestCase.php             # Base class pengujian turunan Laravel
└── Unit/                    # Pengujian unit fungsi kecil terisolasi tanpa HTTP/Database
    └── ExampleTest.php
```

---

## 1. Subfolder `tests/Feature/` (Feature & Integration Tests)

Pengujian feature menguji aplikasi dari sudut pandang interaksi pengguna dan respon server:

### A. `tests/Feature/RbacTest.php` (Role-Based Access Control)
Menguji pembatasan izin keamanan secara menyeluruh:
- Tamu (*guest*) wajib diarahkan ke halaman login jika mencoba membuka `/admin/*`.
- `super_admin` memiliki akses penuh ke seluruh modul, termasuk manajemen akun pengguna.
- `admin_cms` hanya boleh mengelola berita, agenda, dan dilarang mengakses modul PPDB atau kelola user (`403 Forbidden`).
- `admin_ppdb` memiliki hak verifikasi dan penghapusan pendaftar PPDB, namun dilarang mengakses kelola user atau berita.
- `editor_akademik` hanya memiliki akses ke modul guru dan jurusan.
- Pengguna yang dinonaktifkan (`is_active = false`) langsung ditolak masuk ke panel.
- Pengalihan (*redirect*) otomatis ke dashboard yang tepat sesuai peran saat login.

### B. `tests/Feature/PpdbWorkflowTest.php` & `PpdbMultiLevelTest.php`
- Memastikan formulir pendaftaran berhasil menyimpan biodata calon siswa.
- Menguji bahwa upload dokumen digital tersimpan di disk storage dengan benar.
- Menguji fitur pencarian mandiri status pendaftaran siswa (*tracking status*).
- Menguji ekspor data pendaftaran ke file CSV dan kompresi arsip ZIP.

### C. `tests/Feature/SecurityHardeningTest.php`
- Memverifikasi keberadaan header proteksi HTTP (`X-Frame-Options`, `X-Content-Type-Options`, `X-XSS-Protection`).
- Menguji pencegahan kebocoran informasi server pada header respons.

### D. `tests/Feature/NewsPortalTest.php`
- Memastikan katalog `/berita` menampilkan artikel berstatus *published*.
- Memastikan artikel berstatus *draft* tidak bocor ke publik.
- Menguji fungsi pencarian berita berdasarkan kata kunci dan kategori.

---

## 2. Cara Menjalankan Pengujian

Developer dapat menjalankan pengujian otomatis kapan saja melalui terminal:

```bash
# Menjalankan seluruh rangkaian tes:
php artisan test

# Menjalankan pengujian spesifik hak akses (RBAC):
php artisan test tests/Feature/RbacTest.php

# Menjalankan pengujian alur PPDB:
php artisan test tests/Feature/PpdbWorkflowTest.php
```
