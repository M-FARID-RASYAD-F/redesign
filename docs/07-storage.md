# 📦 Folder `storage/` — Penyimpanan Berkas Dinamis & Cache (Storage & Cache)

Folder `storage/` bertugas menampung seluruh berkas yang dihasilkan secara dinamis saat aplikasi berjalan, baik berkas yang diunggah oleh pendaftar, data sesi pengguna, berkas view Blade yang telah dikompilasi, maupun catatan log aktivitas dan error sistem.

---

## 🗂️ Struktur Subdirektori `storage/`

```
storage/
├── app/                     # Berkas yang disimpan oleh aplikasi
│   ├── private/             # Berkas tertutup yang tidak boleh diakses publik langsung
│   └── public/              # Berkas yang dipublikasikan melalui symlink (dokumen PPDB, gambar berita)
│       └── ppdb/            # Subfolder berkas pendaftaran calon siswa (KK, Akta Lahir)
├── framework/               # Berkas internal yang dikelola otomatis oleh Laravel
│   ├── cache/               # Data cache performa query dan objek
│   ├── sessions/            # Berkas sesi pengguna login (jika driver session=file)
│   ├── testing/             # Berkas sementara saat menjalankan automated tests
│   └── views/               # Template Blade yang telah dikompilasi menjadi PHP murni
└── logs/                    # Berkas catatan kejadian dan galat sistem
    └── laravel.log          # Catatan log error, peringatan, dan jejak aktivitas harian
```

---

## 1. Subfolder `storage/app/public/` (Unggahan Pengguna)

Folder ini menyimpan berkas-berkas digital penting dari pengguna:
- **Dokumen Persyaratan PPDB**:
  - Salinan digital Kartu Keluarga (KK).
  - Akta Kelahiran calon peserta didik.
  - Surat Keterangan Lulus / Ijazah / Rapor terakhir.
  - Setiap dokumen disimpan dengan nama acak (*hashed filename*) dan terenkripsi ekstensi untuk mencegah penimpaan berkas (*file overwriting*) dan eksekusi skrip berbahaya.
- **Media Konten Berita & Guru**:
  - Gambar banner berita publikasi sekolah.
  - Foto profil guru dan tenaga kependidikan.

> ℹ️ **Penting**: Folder ini terhubung ke direktori luar melalui perintah `php artisan storage:link`, yang membuat jalan pintas di `public/storage`.

---

## 2. Subfolder `storage/framework/views/` (Compiled Views)

- Setiap kali berkas `.blade.php` di folder `resources/views/` dipanggil, Laravel akan mengompilasinya menjadi kode PHP standar yang sangat cepat dieksekusi.
- Hasil kompilasi tersebut disimpan di dalam folder ini.
- Jika ada perubahan pada kode tampilan Blade yang belum terlihat di browser, developer dapat membersihkannya dengan perintah:
  ```bash
  php artisan view:clear
  ```

---

## 3. Subfolder `storage/logs/` (Pencatatan Audit & Debugging)

- Menyimpan berkas **`laravel.log`**.
- Mencatat seluruh jejak pengecualian (*exceptions*), galat SQL, kegagalan proses unggah, serta upaya autentikasi mencurigakan.
- Sangat berguna bagi administrator dan developer untuk memantau kesehatan server serta mendiagnosis kendala teknis secara presisi.
