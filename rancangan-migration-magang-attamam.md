# Rancangan Migration — Program Magang Laravel PKBM Tahfizh At-Tamam

Berdasarkan **Bagian 3.3 Kamus Data & Skema Basis Data** (Program_Magang_Attamam_Fix.docx) dan pola yang diajarkan di **Materi Bootcamp Fase 0** (Hari ke-13, 15, 19, 26).

Database: `website_attamam` · MySQL 8 · Laravel 11

---

## 1. Daftar Migration & Urutan Pembuatan

Urutan ini **penting** karena beberapa tabel punya foreign key ke tabel lain — tabel "induk" harus dibuat lebih dulu.

| # | Migration | Modul | Owner Tim (Bagian 5.2) |
|---|-----------|-------|--------------------------|
| 1 | `0001_..._add_role_is_active_to_users_table` | Auth & Pengguna | Semua (base) |
| 2 | `0002_..._create_activity_logs_table` | Auth & Pengguna | Backend Admin |
| 3 | `0003_..._create_news_categories_table` | Website Profil | Backend Admin (CMS) |
| 4 | `0004_..._create_news_table` | Website Profil | Backend Admin (CMS) |
| 5 | `0005_..._create_galleries_table` | Website Profil | Backend Admin (CMS) |
| 6 | `0006_..._create_teachers_staff_table` | Website Profil | Backend Akademik |
| 7 | `0007_..._create_majors_table` | Website Profil | Backend Akademik |
| 8 | `0008_..._create_school_profile_table` | Website Profil | Backend Akademik |
| 9 | `0009_..._create_announcements_table` | Pengumuman & Agenda | Backend Admin (CMS) |
| 10 | `0010_..._create_agenda_table` | Pengumuman & Agenda | Backend Admin (CMS) |
| 11 | `0011_..._create_ppdb_registrations_table` | PPDB Online | Backend Admin (PPDB) |
| 12 | `0012_..._create_ppdb_documents_table` | PPDB Online | Backend Admin (PPDB) |

> Catatan Bagian 5.2: setiap tim **membuat file migration baru sendiri**, jangan edit file migration tim lain yang sudah ada.

---

## 2. Perintah Artisan untuk Generate Semua File

```bash
# 1. Users sudah ada dari Breeze — tambah kolom via migration baru
php artisan make:migration add_role_is_active_to_users_table --table=users

# 2. Auth & activity log
php artisan make:model ActivityLog -m

# 3-8. Modul Website Profil
php artisan make:model NewsCategory -m
php artisan make:model News -mf
php artisan make:model Gallery -mf
php artisan make:model TeacherStaff -mf
php artisan make:model Major -m
php artisan make:model SchoolProfile -m

# 9-10. Modul Pengumuman & Agenda
php artisan make:model Announcement -mf
php artisan make:model Agenda -mf

# 11-12. Modul PPDB Online
php artisan make:model PpdbRegistration -mf
php artisan make:model PpdbDocument -m
```

`-m` = buat migration sekalian, `-mf` = migration + factory (untuk tabel yang butuh data dummy saat development, sesuai pola Hari ke-19 bootcamp).

---

## 3. Isi Tiap Migration

### 1) `add_role_is_active_to_users_table`
```php
Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['super_admin', 'admin_cms', 'admin_ppdb', 'editor_akademik'])
          ->default('editor_akademik')
          ->after('email');
    $table->boolean('is_active')->default(true)->after('role');
});
```
> Mengacu Bagian 3.3.1: role sesuai Matriks RBAC Bagian 3.4.

### 2) `create_activity_logs_table`
```php
Schema::create('activity_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
    $table->string('module');       // mis. 'ppdb', 'pengumuman', 'berita'
    $table->string('action');       // mis. 'create', 'update', 'delete', 'verify'
    $table->text('description')->nullable();
    $table->timestamp('created_at')->useCurrent();
});
```
> Audit trail wajib sesuai Bagian 3.6 & 3.9 (jejak akses data pribadi PPDB). Tidak perlu `updated_at` — log tidak diubah.

### 3) `create_news_categories_table`
```php
Schema::create('news_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});
```

### 4) `create_news_table`
```php
Schema::create('news', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->nullable()->constrained('news_categories')->nullOnDelete();
    $table->string('title');
    $table->string('slug')->unique();
    $table->string('thumbnail')->nullable();
    $table->longText('content');
    $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
    $table->timestamp('published_at')->nullable();
    $table->timestamps();
});
```

### 5) `create_galleries_table`
```php
Schema::create('galleries', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('image_path');
    $table->string('category')->nullable();
    $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
});
```

### 6) `create_teachers_staff_table`
```php
Schema::create('teachers_staff', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('position');       // mis. Kepala Sekolah, Guru, Staf TU
    $table->string('subject')->nullable();
    $table->string('photo')->nullable();
    $table->string('nip')->nullable();
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
});
```

### 7) `create_majors_table`
```php
Schema::create('majors', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description')->nullable();
    $table->string('icon')->nullable();
    $table->timestamps();
});
```

### 8) `create_school_profile_table`
```php
Schema::create('school_profile', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();   // mis. 'visi', 'misi', 'sejarah', 'alamat', 'lat', 'lng'
    $table->text('value')->nullable();
    $table->timestamps();
});
```
> Pola key-value dipilih agar konten profil sekolah fleksibel ditambah tanpa migration baru (lihat Bagian 2.6 — Skalabilitas).

### 9) `create_announcements_table`
```php
Schema::create('announcements', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->string('type')->nullable();   // mis. 'umum', 'akademik', 'kegiatan'
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->boolean('is_archived')->default(false);
    $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
});
```
> `is_archived` diset otomatis oleh scheduler saat `end_date` lewat (Bagian 3.5.2).

### 10) `create_agenda_table`
```php
Schema::create('agenda', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->date('date');
    $table->string('location')->nullable();
    $table->text('description')->nullable();
    $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
    $table->timestamps();
});
```

### 11) `create_ppdb_registrations_table`
```php
Schema::create('ppdb_registrations', function (Blueprint $table) {
    $table->id();
    $table->string('no_pendaftaran')->unique();
    $table->string('full_name');
    $table->enum('gender', ['L', 'P']);
    $table->date('birth_date');
    $table->text('address');
    $table->string('parent_name');
    $table->string('parent_phone');
    $table->string('major_choice');
    $table->enum('status', ['pending', 'diverifikasi', 'diterima', 'ditolak'])->default('pending');
    $table->text('notes')->nullable();
    $table->timestamps();
});
```

### 12) `create_ppdb_documents_table`
```php
Schema::create('ppdb_documents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('registration_id')->constrained('ppdb_registrations')->cascadeOnDelete();
    $table->enum('doc_type', ['kk', 'akta_lahir', 'foto', 'rapor_terakhir']);
    $table->string('file_path');
    $table->enum('verification_status', ['belum_diverifikasi', 'valid', 'tidak_valid'])
          ->default('belum_diverifikasi');
    $table->timestamps();
});
```
> Sesuai Bagian 3.9: dokumen disimpan di disk **private**, bukan `public` — atur `disk` di config filesystem terpisah dari galeri/foto guru.

---

## 4. Menjalankan Migration

```bash
php artisan migrate            # jalankan bertahap
php artisan migrate:fresh --seed   # reset total + isi data dummy (khusus lokal/dev)
```

## 5. Catatan Penting Sesuai Dokumen Program

- **Bagian 5.2**: `database/migrations/*` — migration baru dibuat di file terpisah sesuai data tim masing-masing (Akademik = guru/jurusan/profil; Admin = berita/galeri/pengumuman/ppdb). Jangan edit migration tim lain yang sudah ter-merge ke `main`.
- **Bagian 3.6**: field `password` di tabel `users` otomatis di-hash bcrypt oleh Breeze — tidak perlu ditangani manual di migration.
- **Bagian 3.9**: field terkait dokumen PPDB (`ppdb_documents.file_path`) wajib mengarah ke storage privat, bukan `storage/app/public`.
- Semua tabel pakai `$table->timestamps()` (created_at, updated_at) kecuali `activity_logs` yang cukup `created_at` saja (log tidak pernah diubah).
- Konvensi commit untuk migration: `feat: migration tabel <nama>` (Bagian 5.4).
