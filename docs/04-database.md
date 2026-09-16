# 🗄️ Folder `database/` — Skema Data, Migrasi & Seeder (Database Architecture)

Folder `database/` mengelola seluruh siklus hidup basis data aplikasi **At-Tamam Edu**, mulai dari perancangan tabel (migrations), data awal default (*seeders*), hingga generator data tiruan untuk pengujian otomatis (*factories*).

---

## 🗂️ Struktur Subdirektori `database/`

```
database/
├── factories/               # Cetak biru (blueprint) data tiruan untuk automated test
│   └── UserFactory.php      # Generator dummy model User
├── migrations/              # Berkas pengubah skema tabel database berurutan
└── seeders/                 # Pengisi data awal (default user, jurusan, profil sekolah)
    └── DatabaseSeeder.php   # Master seeder yang menjalankan seluruh data inisialisasi
```

---

## 1. Subfolder `database/migrations/` (Skema Tabel)

Setiap file migrasi dieksekusi secara terurut oleh perintah `php artisan migrate`. Tabel-tabel utama yang dikelola meliputi:

### A. Tabel Autentikasi & Pengguna:
- **`users`**:
  - Kolom: `id`, `name`, `email`, `password`, `role` (enum: `super_admin`, `admin_cms`, `admin_ppdb`, `editor_akademik`), `avatar`, `is_active` (boolean), `remember_token`, `timestamps`.

### B. Tabel Pendaftaran PPDB Online:
- **`ppdb_registrations`**:
  - Kolom: `id`, `no_pendaftaran` (string unik, contoh: `PPDB-2026-SD-001`), `jenjang` (enum: `sd`, `smp`, `smk`), `major_choice` (nullable, pilihan jurusan khusus SMK), `full_name`, `nisn`, `gender` (`L`/`P`), `birth_date`, `birth_place`, `parent_name`, `parent_phone`, `address`, `status` (enum: `pending`, `diverifikasi`, `diterima`, `ditolak`), `notes` (catatan verifikator), `timestamps`.
- **`ppdb_documents`**:
  - Kolom: `id`, `ppdb_registration_id` (foreign key berelasi ke `ppdb_registrations`), `doc_type` (KK, Akta Lahir, Ijazah, Rapor), `file_path` (lokasi di disk storage), `verification_status` (`belum_diverifikasi`, `valid`, `tidak_valid`), `verified_by`, `timestamps`.

### C. Tabel Konten & Akademik:
- **`majors`**:
  - Menyimpan data program keahlian/jurusan SMK: `id`, `name`, `code`, `description`, `icon`, `is_active`, `timestamps`.
- **`teacher_staff`**:
  - Menyimpan direktori tenaga pendidik: `id`, `name`, `nip`, `position`, `subject`, `photo`, `is_active`, `timestamps`.
- **`news` & `news_categories`**:
  - Publikasi berita: `id`, `category_id`, `user_id` (penulis), `title`, `slug` (URL unik ramah SEO), `content`, `thumbnail`, `status` (`draft`/`published`), `views_count`, `timestamps`.
- **`agendas` & `announcements`**:
  - Kalender agenda kegiatan sekolah dan pengumuman resmi instansi.
- **`school_profiles`**:
  - Profil lembaga, visi, misi, kontak pimpinan, dan legalitas izin operasional.
- **`activity_logs`**:
  - Audit keamanan sistem: mencatat siapa (`user_id`), melakukan apa (`action`), pada data apa (`subject_type`, `subject_id`), beserta `ip_address` dan waktu kejadian.

---

## 2. Subfolder `database/seeders/` (Data Inisialisasi)

Berkas utama di sini adalah **`DatabaseSeeder.php`**, yang bertugas mengisi database saat pertama kali aplikasi dipasang (`php artisan db:seed`):

### Akun Administrator Default yang Dibuat Otomatis:
1. **Super Admin**:
   - Email: `superadmin@attamam.sch.id`
   - Peran: `super_admin` (Akses tanpa batas ke semua fitur sistem).
2. **Admin CMS**:
   - Email: `admincms@attamam.sch.id`
   - Peran: `admin_cms` (Pengelola berita, agenda, pengumuman, dan galeri).
3. **Admin PPDB**:
   - Email: `adminppdb@attamam.sch.id`
   - Peran: `admin_ppdb` (Verifikator pendaftaran, pengelola status berkas, dan ekspor).
4. **Editor Akademik**:
   - Email: `editorakademik@attamam.sch.id`
   - Peran: `editor_akademik` (Pengelola direktori guru dan program jurusan).

### Data Master Awal:
- Jurusan SMK default: Rekayasa Perangkat Lunak (RPL), Desain Komunikasi Visual (DKV), Teknik Komputer dan Jaringan (TKJ).
- Contoh artikel berita awal dan kategori untuk verifikasi antarmuka frontend.

---

## 3. Subfolder `database/factories/` (Mock Data Generator)

- Digunakan bersama framework pengujian **Pest / PHPUnit** untuk menguji sistem tanpa bergantung pada data manual.
- Menggunakan pustaka *Faker* untuk menggenerasi nama, alamat, nomor telepon, dan email secara instan saat pengetesan kode di lingkungan isolasi.
