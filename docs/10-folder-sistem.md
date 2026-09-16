# 💻 Folder `vendor/`, `node_modules/`, `.agents/`, `.git/` & Berkas Root (System & Environment)

Dokumen ini menjelaskan direktori sistem, dependensi pihak ketiga, pengaturan kontrol versi Git, serta berkas konfigurasi di tingkat terluar (*root directory*) aplikasi **At-Tamam Edu**.

---

## 🗂️ 1. Folder Sistem & Dependensi

### A. Folder `vendor/` (PHP Composer Packages)
- Berisi seluruh pustaka dan dependensi pihak ketiga PHP yang diunduh melalui Composer:
  - Framework **Laravel 11** (`laravel/framework`).
  - ORM Eloquent, database query builder, dan validasi.
  - Driver PDF & ZIP (`barryvdh/laravel-dompdf`, `nelexa/zip`).
  - Framework pengujian **PHPUnit** / **Pest**.
- **Catatan**: Folder ini tidak disertakan ke repositori Git (`.gitignore`) karena ukurannya yang besar. Folder ini dapat dibuat ulang kapan saja di komputer lain menggunakan perintah `composer install`.

### B. Folder `node_modules/` (Node.js / NPM Packages)
- Menampung paket-paket JavaScript dan CSS frontend yang diunduh melalui NPM:
  - Bundler **Vite** dan plugin Laravel Vite.
  - **Tailwind CSS**, PostCSS, dan Autoprefixer.
  - Pustaka animasi **GSAP** (GreenSock), ScrollSmoother, dan Lucide icons.
  - Dependensi React, TypeScript, and utility `clsx` / `tailwind-merge`.
- **Catatan**: Folder ini dihiraukan oleh Git dan dapat diunduh ulang dengan perintah `npm install`.

### C. Folder `.agents/` (AI Assistant Rules & Skills)
- Berisi aturan kerja (*rules*), instruksi khusus (*skills*), dan konfigurasi untuk asisten AI pengembang:
  - Aturan desain UI/UX (`ui-styling`, `framer-motion`, `ui-ux-pro-max`).
  - Aturan pemeliharaan knowledge graph arsitektur sistem (`graphify`).
  - Aturan optimasi dan efisiensi kode (`ponytail`).

### D. Folder `.git/` (Git Version Control)
- Menyimpan basis data pelacakan versi Git, riwayat commit, branch (`main`, `feature/*`), remote URL (`origin/main`), dan konfigurasi staging.
- Folder ini dikelola secara otomatis oleh program Git.

---

## 📄 2. Berkas Konfigurasi di Root Direktori

Selain folder-folder di atas, terdapat berkas-berkas penting di root direktori proyek:

| Berkas | Fungsi dan Peranan |
|---|---|
| **`.env`** | Kredensial rahasia lokal: koneksi database MySQL, kunci enkripsi `APP_KEY`, mode debug `APP_DEBUG`, URL aplikasi, dan konfigurasi mailer. Berkas ini tidak boleh diunggah ke GitHub publik. |
| **`.env.example`** | Contoh template variabel lingkungan yang aman dibagikan sebagai acuan setup bagi developer lain. |
| **`artisan`** | Skrip CLI entry point untuk mengeksekusi perintah Laravel (seperti `php artisan serve`, `migrate`, `db:seed`, `test`). |
| **`composer.json`** | Daftar nama dan versi pustaka PHP yang dibutuhkan aplikasi, serta konfigurasi autoloading PSR-4 (`App\` ➔ `app/`, `Database\` ➔ `database/`). |
| **`package.json`** | Daftar modul JavaScript frontend dan skrip eksekusi (seperti `npm run dev` dan `npm run build`). |
| **`tailwind.config.js`** | Pengaturan tema warna, varian, dan direktori template yang harus dipindai oleh Tailwind CSS. |
| **`vite.config.js`** | Konfigurasi bundler Vite untuk menghubungkan aset frontend dengan server backend Laravel. |
| **`phpunit.xml`** | Konfigurasi pengujian otomatis, database in-memory untuk testing, dan variabel testing environment. |
| **`.gitignore`** | Daftar berkas dan folder yang sengaja dikecualikan dari pelacakan Git (seperti `.env`, `/vendor`, `/node_modules`, `/storage/*.key`). |
