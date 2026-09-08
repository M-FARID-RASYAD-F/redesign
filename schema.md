Saya punya project Laravel dan ingin menyesuaikan migration files agar sesuai dengan Kamus Data & Skema Basis Data berikut. Tolong buatkan/sesuaikan migration Laravel (beserta model jika perlu) untuk tabel-tabel berikut, dengan tetap mempertahankan relasi antar tabel:

3.3.1 Modul Autentikasi & Pengguna

users: id, name, email, password, role (enum: super_admin, admin_cms, admin_ppdb, editor_akademik), is_active (boolean), timestamps
activity_logs: id, user_id (FK ke users), module, action, description, created_at — untuk audit trail seluruh aksi tulis/ubah/hapus data penting

3.3.2 Modul Website Profil Sekolah

news_categories: id, name, slug — kategori berita (Prestasi, Kegiatan, Pengumuman Umum, dll.)
news: id, category_id (FK ke news_categories), title, slug, thumbnail, content, author_id (FK ke users), published_at
galleries: id, title, image_path, category, uploaded_by (FK ke users), created_at
teachers_staff: id, name, position, subject, photo, nip, status
majors: id, name, slug, description, icon — data jurusan/program kejuruan (RPL, TKJ, dll.)
school_profile: id, key, value — data profil dinamis (visi, misi, sejarah, alamat, kontak, koordinat peta), disimpan sebagai key-value pairs

3.3.3 Modul Pengumuman & Agenda

announcements: id, title, content, type, start_date, end_date, is_archived (boolean, otomatis di-set via scheduler saat end_date lewat), created_by (FK ke users)
agenda: id, title, date, location, description, created_by (FK ke users)

3.3.4 Modul PPDB Online

ppdb_registrations: id, no_pendaftaran, full_name, gender, birth_date, address, parent_name, parent_phone, major_choice (kemungkinan FK ke majors), status (enum: pending, diverifikasi, diterima, ditolak), notes, created_at
ppdb_documents: id, registration_id (FK ke ppdb_registrations), doc_type (enum: KK, akta_lahir, foto, rapor_terakhir, dll.), file_path, verification_status

Relasi utama yang harus dijaga:

users → activity_logs (1:many)
users → news (author_id), galleries (uploaded_by), announcements & agenda (created_by)
news_categories → news (1:many)
majors → ppdb_registrations (opsional, sebagai referensi pilihan jurusan)
ppdb_registrations → ppdb_documents (1:many)