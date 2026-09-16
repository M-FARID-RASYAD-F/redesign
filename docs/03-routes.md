# 🛣️ Folder `routes/` — Peta Alur Rute & Endpoints (Routing System)

Folder `routes/` bertanggung jawab mendefinisikan seluruh alamat URL (endpoints) yang tersedia dalam aplikasi **At-Tamam Edu**, menentukan controller mana yang memproses permintaan tersebut, serta menetapkan lapisan keamanan (middleware) yang harus dilalui.

---

## 🗂️ Struktur Berkas `routes/`

```
routes/
├── web.php                  # Seluruh rute antarmuka berbasis web (browser, sesi, CSRF)
└── console.php              # Definisi perintah artisan terminal berbasis closure
```

---

## 1. Berkas Utama: `routes/web.php`

Rute web diorganisasikan ke dalam beberapa kelompok fungsional yang terisolasi dengan baik:

### A. Rute Publik (Terbuka untuk Umum):
Rute-rute ini dapat diakses oleh calon wali murid, siswa, maupun masyarakat umum tanpa memerlukan login:

| Method | URI | Controller Action | Keterangan |
|---|---|---|---|
| `GET` | `/` | `SchoolController@index` | Halaman beranda utama (Landing Page). |
| `GET` | `/ppdb` | `SchoolController@ppdbIndex` | Beranda informasi alur dan syarat PPDB. |
| `GET` | `/ppdb/daftar` | `SchoolController@ppdbCreate` | Formulir pendaftaran calon siswa baru. |
| `POST` | `/ppdb/daftar` | `SchoolController@ppdbStore` | Menyimpan formulir pendaftaran dan berkas upload. |
| `GET` | `/ppdb/sukses/{id}` | `SchoolController@ppdbSuccess` | Halaman konfirmasi sukses dengan nomor pendaftaran. |
| `GET` | `/ppdb/status` | `SchoolController@ppdbTracking` | Halaman pelacakan status seleksi mandiri. |
| `POST` | `/ppdb/status` | `SchoolController@ppdbCheck` | Memproses pencarian data seleksi calon siswa. |
| `GET` | `/ppdb/cetak/{id}` | `SchoolController@ppdbPrint` | Mencetak bukti pendaftaran / kartu ujian. |
| `GET` | `/berita` | `SchoolController@newsIndex` | Portal katalog artikel berita sekolah. |
| `GET` | `/berita/{slug}` | `SchoolController@newsShow` | Membaca artikel berita spesifik berdasarkan slug URL. |

---

### B. Rute Autentikasi Pengguna:
Menggunakan middleware bawaan `web` dan proteksi CSRF:

| Method | URI | Controller Action | Keterangan |
|---|---|---|---|
| `GET` | `/login` | `Auth\LoginController@showLoginForm` | Menampilkan form login admin panel. |
| `POST` | `/login-process` | `Auth\LoginController@login` | Memvalidasi kredensial dan inisialisasi sesi admin. |
| `GET` / `POST` | `/logout` | `Auth\LoginController@logout` | Menghancurkan sesi pengguna dan redirect ke login. |

---

### C. Rute Panel Admin Terproteksi:
Semua rute di bawah ini berada dalam grup middleware `['auth', 'active']` untuk memastikan pengguna **telah login** dan akunnya berstatus **aktif**:

#### 1. Rute Dashboard Spesifik Berdasarkan Peran (Role-Based Routing):
- `/admin/dashboard` ➔ Diarahkan secara dinamis ke dashboard peran masing-masing atau dashboard agregat Super Admin.
- `/admin/superadmin/dashboard` ➔ Khusus peran `super_admin` (`middleware: role:super_admin`).
- `/admin/cms/dashboard` ➔ Khusus peran `super_admin,admin_cms` (`middleware: role:super_admin,admin_cms`).
- `/admin/ppdb/dashboard` ➔ Khusus peran `super_admin,admin_ppdb` (`middleware: role:super_admin,admin_ppdb`).
- `/admin/akademik/dashboard` ➔ Khusus peran `super_admin,editor_akademik` (`middleware: role:super_admin,editor_akademik`).

#### 2. Modul Manajemen PPDB Admin:
- `GET /admin/ppdb` ➔ Menampilkan daftar tabel seluruh pendaftar, pencarian, dan filter jenjang.
- `GET /admin/ppdb/{id}` ➔ Halaman detail identitas, berkas pendaftar, dan riwayat.
- `POST /admin/ppdb/{id}/status` ➔ Memperbarui status seleksi (*Pending*, *Diverifikasi*, *Diterima*, *Ditolak*) dan catatan panitia.
- `GET /admin/ppdb/document/{id}` ➔ Membuka pratinjau dokumen digital (KK/Akta) yang diunggah pendaftar secara aman.
- `GET /admin/ppdb/export-csv` ➔ Mengekspor seluruh pendaftar terpilih ke format spreadsheet CSV.
- `GET /admin/ppdb/export-zip` ➔ Mengunduh seluruh berkas pendaftar per-jenjang yang dikemas dalam arsip ZIP otomatis.
- `DELETE /admin/ppdb/{id}` ➔ Menghapus pendaftar (Dibatasi oleh Policy: hanya Super Admin dan Admin PPDB).

#### 3. Modul Kelola Pengguna (User Management):
- `GET /admin/users` ➔ Daftar pengguna admin.
- `GET /admin/users/create` & `POST /admin/users` ➔ Tambah akun baru dan penentuan role.
- `GET /admin/users/{id}/edit` & `PUT /admin/users/{id}` ➔ Perbarui identitas, email, dan status aktif user.
- `DELETE /admin/users/{id}` ➔ Hapus user (Dilindungi ketat: hanya `super_admin`).

#### 4. Modul Berita, Guru & Staf, serta Jurusan:
- Rute CRUD Berita: `/admin/news` (Create, Store, Edit, Update, Destroy).
- Rute CRUD Guru: `/admin/teachers` (Kelola pendidik dan staf sekolah).
- Rute CRUD Jurusan: `/admin/majors` (Kelola jurusan kejuruan SMK).

---

## 2. Berkas: `routes/console.php`

- Tempat mendefinisikan perintah CLI khusus aplikasi berbasis Closure yang dapat dijalankan melalui terminal dengan sintaks `php artisan <nama-command>`.
- Dapat dimanfaatkan untuk menjadwalkan tugas otomatis (*Task Scheduling*), seperti pembersihan berkas pendaftaran kedaluwarsa atau pengarsipan log.
