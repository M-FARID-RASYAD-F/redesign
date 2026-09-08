# Prompt Lanjutan — RBAC & Dashboard per Role

Migration & model untuk skema database (`users`, `news`, `galleries`, `ppdb_registrations`, dll.) sudah saya jalankan berdasarkan prompt sebelumnya. Sekarang saya ingin melanjutkan dengan mengimplementasikan **Role-Based Access Control (RBAC)** sekaligus **dashboard terpisah per role**, di atas struktur yang sudah ada (gunakan model/migration yang sudah ada, jangan buat ulang tabel).

## Daftar Role
(sudah ada di kolom `role` tabel `users`)

1. `super_admin`
2. `admin_cms`
3. `admin_ppdb`
4. `editor_akademik`
5. `guest` (unauthenticated/publik)

## Matriks Hak Akses

| Role | Modul Website Profil | Modul Pengumuman | Modul PPDB |
|---|---|---|---|
| **super_admin** | Akses penuh | Akses penuh | Akses penuh + kelola pengguna admin |
| **admin_cms** | Kelola berita, galeri, data guru & jurusan (CRUD penuh) | Kelola pengumuman & agenda (CRUD penuh) | Read-only (lihat rekap) |
| **admin_ppdb** | Read-only | Read-only | Verifikasi dokumen, ubah status, ekspor data (tanpa hapus) |
| **editor_akademik** | Kelola data guru, staf, jurusan saja | Read-only | Read-only |
| **guest** | Lihat halaman publik | Lihat pengumuman & agenda publik | Isi formulir & lacak status pendaftaran sendiri |

## Bagian A — RBAC (Otorisasi)

1. Middleware `CheckRole` untuk membatasi route/controller per role.
2. Policy class untuk tiap resource: `NewsPolicy`, `GalleryPolicy`, `TeacherStaffPolicy`, `MajorPolicy`, `AnnouncementPolicy`, `AgendaPolicy`, `PpdbRegistrationPolicy`, `PpdbDocumentPolicy`, `UserPolicy` (khusus super_admin untuk kelola akun admin lain) — sesuai detail matriks di atas.
3. Contoh `@can()` di Blade untuk sembunyikan tombol aksi sesuai role.
4. Route publik (guest) dipisah dari route admin, tanpa middleware `auth`.
5. Rekomendasi: pakai **Spatie Laravel-permission** atau custom role/policy manual — sebutkan pertimbangan untuk skala project ini.

## Bagian B — Dashboard per Role

1. Redirect otomatis setelah login sesuai role (di `LoginController`/`AuthenticatedSessionController` kalau pakai Breeze/Fortify), contoh:
   - `super_admin` → `/admin/dashboard`
   - `admin_cms` → `/admin/cms/dashboard`
   - `admin_ppdb` → `/admin/ppdb/dashboard`
   - `editor_akademik` → `/admin/akademik/dashboard`

2. Isi/widget tiap dashboard:

| Role | Isi Dashboard |
|---|---|
| **super_admin** | Ringkasan semua modul: total berita, total pendaftar PPDB per status, jumlah user admin aktif, log aktivitas terbaru (`activity_logs`), shortcut kelola akun admin |
| **admin_cms** | Jumlah berita/galeri terbaru, draft belum publish, pengumuman/agenda aktif vs expired, shortcut tambah berita/galeri/pengumuman/agenda |
| **admin_ppdb** | Statistik pendaftar (pending/diverifikasi/diterima/ditolak) dalam chart, daftar pendaftaran terbaru perlu diverifikasi, shortcut verifikasi dokumen & ekspor data |
| **editor_akademik** | Jumlah data guru/staf & jurusan, shortcut tambah/edit guru & jurusan |

3. Controller terpisah per role (`SuperAdminDashboardController`, `CmsDashboardController`, `PpdbDashboardController`, `AkademikDashboardController`) atau satu `DashboardController` dengan method berbeda per role — jelaskan mana yang lebih baik untuk maintainability project ini.

4. View/Blade layout dashboard terpisah per role, tapi reuse satu layout admin utama (sidebar/topbar sama, hanya konten & menu sidebar menyesuaikan role) — hindari duplikasi kode.

5. Sidebar menu otomatis menyesuaikan role yang login (misal `editor_akademik` tidak melihat menu "Berita/Galeri").

6. Route group per role, masing-masing menggunakan middleware `role:...` yang sama seperti Bagian A, dan masing-masing punya route dashboard sendiri.

## Catatan Penting

Pastikan Bagian A dan B saling terhubung — dashboard dan menu sidebar mengikuti aturan hak akses yang sama persis dengan policy yang dibuat di Bagian A, jangan buat sistem otorisasi baru yang terpisah.
