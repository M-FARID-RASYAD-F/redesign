# 📁 Folder `app/` — Logika Utama Aplikasi (Application Core)

Folder `app/` adalah jantung dari seluruh proses bisnis, pemrosesan data, dan alur kontrol aplikasi **At-Tamam Edu**. Di folder ini, Laravel menerapkan pola arsitektur **MVC (Model-View-Controller)** yang diperkaya dengan sistem otorisasi **RBAC (Role-Based Access Control)** melalui *Policy* dan *Middleware*.

---

## 🗂️ Struktur Subdirektori `app/`

```
app/
├── Filament/                # Konfigurasi & Resource panel Filament (jika diaktifkan)
├── Http/                    # Lapisan penerima request HTTP (Controller, Middleware, FormRequest)
│   ├── Controllers/         # Menangani logika permintaan dari user/browser
│   │   ├── Admin/           # Controller terfragmentasi khusus modul admin
│   │   ├── Auth/            # Controller autentikasi (Login, Register, Logout)
│   │   ├── AdminController.php   # Controller agregator panel admin utama
│   │   ├── Controller.php        # Base controller turunan Laravel
│   │   └── SchoolController.php  # Controller publik (Landing Page, PPDB, Berita)
│   ├── Middleware/          # Filter lapisan keamanan sebelum request masuk ke controller
│   └── Requests/            # Validasi form request yang terisolasi (jika digunakan)
├── Models/                  # Representasi tabel database berbasis Eloquent ORM
├── Policies/                # Penjaga gerbang hak akses (RBAC Gate) untuk tiap resource
└── Providers/               # Inisialisasi service provider aplikasi (AppServiceProvider)
```

---

## 1. Subfolder `app/Http/Controllers/`

Controller bertugas menerima permintaan HTTP dari pengguna, memanggil model data, memvalidasi input, dan mengembalikan respon berupa tampilan Blade atau data JSON.

### A. Controller Publik:
- **`SchoolController.php`**:
  - Menangani seluruh halaman publik: Landing Page (`index()`), formulir pendaftaran PPDB (`ppdbCreate()`), pemrosesan penyimpanan calon siswa (`ppdbStore()`), pencarian status pendaftar (`ppdbTracking()`), dan portal berita mandiri (`newsIndex()`, `newsShow()`).
  - Mengelola upload berkas digital PPDB (KK, Akta Lahir, Ijazah/Rapor) ke storage disk publik.

### B. Controller Panel Admin:
- **`AdminController.php`**:
  - Mengelola halaman administrasi: manajemen guru/staf, program jurusan, berita CMS, pendaftar PPDB, verifikasi berkas, dan ekspor data ke format CSV atau arsip ZIP.
- **Subfolder `app/Http/Controllers/Admin/`**:
  - **`SuperAdminDashboardController.php`**: Menyajikan metrik agregat total pengguna, pendaftar PPDB, berita, dan log aktivitas untuk Super Admin.
  - **`CmsDashboardController.php`**: Menyajikan statistik artikel, agenda, dan pengumuman untuk Admin CMS.
  - **`PpdbDashboardController.php`**: Menyajikan grafik antrean verifikasi, distribusi jenjang (SD, SMP, SMK), dan data validasi berkas untuk Admin PPDB.
  - **`AkademikDashboardController.php`**: Menyajikan data guru aktif, sebaran mata pelajaran, dan jurusan kejuruan untuk Editor Akademik.
  - **`UserController.php`**: CRUD akun administrator sekolah (tambah, edit, nonaktifkan, dan ganti role).

### C. Subfolder `app/Http/Controllers/Auth/`:
- Menangani proses otentikasi: login akun admin (`LoginController.php`), verifikasi sesi pengguna, proteksi brute-force, dan penghancuran sesi saat logout.

---

## 2. Subfolder `app/Models/` (Eloquent Models)

Setiap berkas model di folder ini memetakan satu tabel database ke dalam objek PHP:

1. **`User.php`**:
   - Mewakili tabel `users`. Menyimpan kredensial admin, avatar, status aktif (`is_active`), dan role (`super_admin`, `admin_cms`, `admin_ppdb`, `editor_akademik`).
2. **`PpdbRegistration.php`**:
   - Mewakili tabel `ppdb_registrations`. Menyimpan data calon siswa (Nomor pendaftaran, jenjang SD/SMP/SMK, jurusan SMK pilihan, nama lengkap, NISN, tanggal lahir, kontak orang tua/wali, status pendaftaran `pending`/`diverifikasi`/`diterima`/`ditolak`, dan catatan panitia).
   - Memiliki relasi `hasMany` ke `PpdbDocument`.
3. **`PpdbDocument.php`**:
   - Mewakili tabel `ppdb_documents`. Menyimpan berkas digital pendaftar (Kartu Keluarga, Akta Kelahiran, Ijazah) beserta status verifikasi berkasnya (`belum_diverifikasi`, `valid`, `tidak_valid`).
4. **`News.php`** & **`NewsCategory.php`**:
   - Mewakili tabel publikasi artikel berita, informasi prestasi, kegiatan sekolah, dan kategorisasinya.
5. **`Major.php`**:
   - Mewakili tabel jurusan kejuruan (SMK) seperti RPL, DKV, TKJ, atau Teknik lainnya.
6. **`TeacherStaff.php`**:
   - Mewakili direktori pendidik dan tenaga kependidikan sekolah.
7. **`SchoolProfile.php`**:
   - Menyimpan identitas sekolah (visi, misi, nama lembaga, nomor izin operasional, kontak, dan alamat).
8. **`Agenda.php` & `Announcement.php`**:
   - Menyimpan kalender kegiatan dan pengumuman resmi instansi.
9. **`ActivityLog.php`**:
   - Catatan audit keamanan otomatis atas tindakan yang dilakukan di panel admin (tambah user, verifikasi PPDB, hapus data).

---

## 3. Subfolder `app/Policies/` (Role-Based Access Control)

Folder ini mengisolasi logika izin akses agar controller tetap bersih dan aman:

- **`PpdbRegistrationPolicy.php`**: Memastikan hanya peran `super_admin` dan `admin_ppdb` yang dapat mengubah status seleksi atau menghapus data pendaftar.
- **`NewsPolicy.php`**: Mengatur izin bagi `admin_cms` dan `super_admin` dalam membuat atau mempublikasikan berita.
- **`TeacherStaffPolicy.php`** & **`MajorPolicy.php`**: Mengatur hak akses staf kurikulum dan `editor_akademik`.
- **`UserPolicy.php`**: Menjamin bahwa manajemen pengguna akun hanya bisa dilakukan oleh `super_admin`.

---

## 4. Subfolder `app/Http/Middleware/`

Filter yang memotong alur HTTP sebelum request sampai ke controller:

1. **`CheckRole.php`**:
   - Memeriksa apakah peran user yang login sesuai dengan parameter rute (contoh: `role:super_admin,admin_ppdb`).
2. **`EnsureUserIsActive.php`**:
   - Memeriksa apakah status akun `is_active` bernilai `true`. Jika dinonaktifkan oleh Super Admin, user langsung dipaksa keluar (*force logout*).
3. **`SecurityHeadersMiddleware.php`**:
   - Menginjeksikan header proteksi keamanan HTTP modern seperti `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `Referrer-Policy`, dan pembatasan script untuk mencegah serangan clickjacking & XSS.

---

## 5. Subfolder `app/Providers/`

- **`AppServiceProvider.php`**:
  - Tempat mendaftarkan pengaturan global framework, konfigurasi pagination Tailwind, pendaftaran Policy otorisasi, dan listener database.
