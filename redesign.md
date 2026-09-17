# DOKUMEN PERANCANGAN ULANG & AUDIT UI/UX (REDESIGN.MD)
## PKBM Tahfizh At-Tamam Edu — Portal Resmi & Sistem Informasi Sekolah
**Versi Dokumen:** 1.0.0  
**Tanggal:** 17 September 2026  
**Peran:** Senior Product Designer & Design Systems Architect  
**Platform Diuji:** Desktop (1920×1080, 1440×900, 1280×800) & Mobile (iPhone SE/13/15, Galaxy S/A Series, Layar Lipat 320px–430px)  
**Teknologi:** Laravel 13, Blade Templates, Tailwind CSS, Vanilla CSS Design System, React 19, GSAP & Motion

---

## DAFTAR ISI
1. [Ringkasan Eksekutif (Executive Summary)](#1-ringkasan-eksekutif-executive-summary)
2. [Cakupan & Metodologi Pengecekan](#2-cakupan--metodologi-pengecekan)
3. [Tabel Matriks Audit UI/UX (Terurut CRITICAL ke LOW)](#3-tabel-matriks-audit-uiux-terurut-critical-ke-low)
4. [Analisis Teknis Mendalam per Temuan](#4-analisis-teknis-mendalam-per-temuan)
   - [4.1 Temuan Tingkat CRITICAL](#41-temuan-tingkat-critical)
   - [4.2 Temuan Tingkat HIGH](#42-temuan-tingkat-high)
   - [4.3 Temuan Tingkat MEDIUM](#43-temuan-tingkat-medium)
   - [4.4 Temuan Tingkat LOW](#44-temuan-tingkat-low)
5. [Cakupan 8 Pilar Desain Berdasarkan Spesifikasi UI.MD](#5-cakupan-8-pilar-desain-berdasarkan-spesifikasi-uimd)
6. [Blueprint Desain Sistem Baru (Design System Architecture)](#6-blueprint-desain-sistem-baru-design-system-architecture)
7. [Panduan Solusi & Kode Implementasi Konkret](#7-panduan-solusi--kode-implementasi-konkret)
8. [Roadmap Eksekusi Bertahap (Action Plan)](#8-roadmap-eksekusi-bertahap-action-plan)

---

## 1. Ringkasan Eksekutif (Executive Summary)

Audit dan rencana perancangan ulang (*redesign*) ini disusun untuk mentransformasi antarmuka portal **PKBM Tahfizh At-Tamam Edu** agar memenuhi standar modern situs institusi pendidikan Islam unggulan: estetis, kredibel, berkinerja tinggi, ramah aksesibilitas (WCAG 2.1 AA), dan responsif di seluruh variasi perangkat (desktop, tablet, dan smartphone).

### Sorotan Utama Hasil Evaluasi:
- **Total Temuan:** 18 item teridentifikasi secara presisi pada basis kode.
- **Distribusi Keparahan:**
  - 🔴 **2 CRITICAL:** Alur validasi form wizard PPDB yang dapat dilompati dan masalah keyboard occlusion / iOS auto-zoom pada layar login mobile.
  - 🟠 **5 HIGH:** Tautan palsu social login, celah kosong 88px+ (phantom dock) pada mobile, tabrakan palet warna dual-theme, ketiadaan tag label input, dan dependensi aset gambar eksternal Unsplash tanpa fallback.
  - 🟡 **6 MEDIUM:** Grid tab kampus yang timpang pada smartphone, tipografi sub-12px yang sulit dibaca, inkonsistensi nomor kontak dummy antar halaman, ketiadaan swipe hint pada tabel admin mobile, inkonsistensi emoji mentah vs SVG, dan form berita CMS tanpa live preview / rich editor.
  - 🟢 **5 LOW:** Pemotongan judul breadcrumb tanpa tooltip, sisa string konsol sekolah lama, halaman error 403 unbranded, path gambar absolut di CSS, dan alt text logo yang generik.

Dokumen ini menyediakan panduan solusi teknis langsung yang dapat dieksekusi oleh tim developer dan UI designer.

---

## 2. Cakupan & Metodologi Pengecekan

Sesuai spesifikasi pada berkas acuan `ui.md`, seluruh evaluasi diuji berdasarkan 8 cakupan utama:

```
┌────────────────────────────────────────────────────────────────────────────┐
│                    CAKUPAN EVALUASI SENIOR PRODUCT DESIGNER                │
├──────────────────────┬─────────────────────────────────────────────────────┤
│ 1. Layout &          │ Viewport bounds, responsive breakpoints, spacing    │
│    Responsiveness    │ consistency, unwanted horizontal scrollbars         │
├──────────────────────┼─────────────────────────────────────────────────────┤
│ 2. Tipografi         │ Readability, font-size scale (anti-pattern <12px),  │
│                      │ line-height, text truncation & ellipsis             │
├──────────────────────┼─────────────────────────────────────────────────────┤
│ 3. Navigasi &        │ Tautan aktif vs mati, touch targets (≥44px),        │
│    Interaksi         │ hover & tap feedback, state transisi panggung       │
├──────────────────────┼─────────────────────────────────────────────────────┤
│ 4. Gambar & Media    │ Local vs external assets, aspect ratios, responsive │
│                      │ images, loading fallbacks, storage efficiency       │
├──────────────────────┼─────────────────────────────────────────────────────┤
│ 5. Form & Input      │ Multi-step client validation, visible form labels,  │
│                      │ virtual keyboard adaptation, error highlights       │
├──────────────────────┼─────────────────────────────────────────────────────┤
│ 6. Konsistensi       │ Dual theme coherence, unified iconography (SVG vs  │
│    Desain            │ OS emojis), branding alignment                      │
├──────────────────────┼─────────────────────────────────────────────────────┤
│ 7. Kompatibilitas    │ Safari/iOS auto-zoom, WebKit color spaces (OKLCH),  │
│    Device & Browser  │ modern safe-area-insets                             │
├──────────────────────┼─────────────────────────────────────────────────────┤
│ 8. Aksesibilitas     │ WCAG 2.1 AA contrast ratio (≥4.5:1), keyboard focus │
│    Dasar (A11y)      │ visibility (:focus-visible), informative alt tags   │
└──────────────────────┴─────────────────────────────────────────────────────┘
```

---

## 3. Tabel Matriks Audit UI/UX (Terurut CRITICAL ke LOW)

| No | Nama Halaman / Komponen | Deskripsi Masalah | Platform | Lokasi File & Baris | Keparahan | Rekomendasi Perbaikan |
|:---|:---|:---|:---|:---|:---|:---|
| 1 | **Formulir PPDB Multi-Step Wizard** | Form dipasangi atribut `novalidate` dan tombol navigasi slide (`nextSlide(2)` & `nextSlide(3)`) tidak memvalidasi kelengkapan data wajib di sisi client. Pengguna dapat melompati seluruh field wajib (`full_name`, `gender`, `birth_date`, `address`, `parent_name`, dll.) hingga Langkah 3. Saat disubmit, server menolak dan me-redirect form kembali ke Langkah 1 tanpa indikator error real-time, berisiko tinggi menggagalkan pendaftaran calon santri. | Keduanya | [`resources/views/ppdb/create.blade.php:607`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/ppdb/create.blade.php#L607)<br>[`resources/views/ppdb/create.blade.php:1187-1194`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/ppdb/create.blade.php#L1187-L1194) | **CRITICAL** | Pasang validasi client-side per slide sebelum transisi: batalkan `showSlide(targetStep)` jika input wajib kosong, tampilkan highlight border merah serta pesan error interaktif langsung di bawah field terkait. |
| 2 | **Autentikasi Login/Register Guru & Staf** | Pada mobile (<= 570px), input field menggunakan `font-size: 0.86rem` (~13.7px). Di iOS Safari, input < 16px otomatis memicu auto-zoom browser yang merusak layout. Ditambah container dengan `min-height: 830px` dan `.signin-signup` berposisi `top: 59% absolute`, ketika keyboard virtual smartphone terbuka, tombol submit login tertutup keyboard dan tidak bisa di-scroll. | Mobile | [`resources/views/auth/login.blade.php:744-754`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/auth/login.blade.php#L744-L754)<br>[`resources/views/auth/login.blade.php:936`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/auth/login.blade.php#L936)<br>[`resources/views/auth/login.blade.php:964`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/auth/login.blade.php#L964) | **CRITICAL** | Naikkan font-size input minimal `16px` di mobile. Ubah layout mobile menjadi flow vertikal statis (`height: auto`, hapus `min-height: 830px` dan `position: absolute`), serta beri margin bawah dinamis saat keyboard aktif. |
| 3 | **Tombol Social Sign-in (Login Guru)** | Menampilkan teks "Or sign in with social platforms", namun tombol Google, Twitter (X), dan LinkedIn menggunakan tautan mati `href="javascript:void(0)"`. Sedangkan tombol Facebook mengarah ke grup Facebook publik, bukan alur OAuth Single Sign-On (SSO). Menyesatkan pengguna dan merusak reputasi sistem portal sekolah. | Keduanya | [`resources/views/auth/login.blade.php:2172-2203`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/auth/login.blade.php#L2172-L2203) | **HIGH** | Hapus baris social sign-in jika fitur SSO belum dikonfigurasi, atau integrasikan secara resmi menggunakan Laravel Socialite untuk Google Workspace institusi sekolah. |
| 4 | **Floating Buttons & Celah Phantom Bottom Dock** | Di viewport mobile, CSS menyisipkan `padding-bottom: calc(76px + ...)` pada `body`, serta tombol WhatsApp dan Back-to-Top di `bottom: calc(76px + ...)`. Posisi ini disiapkan untuk dock navigasi bawah, namun elemen dock tersebut tidak ada di markup HTML. Akibatnya timbul celah kosong 88px+ di bawah layar dan kedua tombol melayang di area tengah-bawah menghalangi konten. | Mobile | [`public/css/style.css:4175`](file:///C:/Users/Administrator/Documents/AttamamEdu/public/css/style.css#L4175)<br>[`public/css/style.css:5121`](file:///C:/Users/Administrator/Documents/AttamamEdu/public/css/style.css#L5121)<br>[`resources/views/partials/whatsapp-button.blade.php:181`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/partials/whatsapp-button.blade.php#L181) | **HIGH** | Reset posisi floating buttons ke `bottom: calc(16px + env(safe-area-inset-bottom, 16px))` dan hilangkan padding 76px pada body, atau pasang markup dock navigasi bawah jika memang direncanakan. |
| 5 | **Dual Theme Engine & Benturan Visual Card** | Tombol ganti tema berlabel "Dark / White Mode", namun mode "Light" menghasilkan warna merah marun gelap (`oklch(41% 0.159 10.272)`), bukan tema putih/terang. Selain itu, pada halaman detail berita (`news/show.blade.php`), card berita menggunakan style inline latar navy gelap tanpa aturan override mode terang, sehingga card navy bertabrakan tajam dengan latar marun kemerahan. | Keduanya | [`public/css/style.css:5499-5502`](file:///C:/Users/Administrator/Documents/AttamamEdu/public/css/style.css#L5499-L5502)<br>[`resources/views/news/show.blade.php:34-41`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/news/show.blade.php#L34-L41) | **HIGH** | Redefinisikan tema terang yang sesungguhnya (latar putih `#ffffff`, card `#f8fafc`, teks `#1e293b`), atau jika tetap mempertahankan palet marun, ubah label menjadi "Tema Crimson". Tambahkan styling terpadu untuk `news/show.blade.php`. |
| 6 | **Ketiadaan Label Input (Placeholder Reliance)** | Seluruh kolom input login dan register hanya mengandalkan `placeholder` tanpa tag `<label>`. Saat pengguna mulai mengetik, teks petunjuk hilang seketika, menyulitkan pengecekan ulang data dan melanggar standar aksesibilitas WCAG 3.3.2. | Keduanya | [`resources/views/auth/login.blade.php:2128-2157`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/auth/login.blade.php#L2128-L2157)<br>[`resources/views/auth/login.blade.php:2228-2280`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/auth/login.blade.php#L2228-L2280) | **HIGH** | Tambahkan tag `<label for="...">` eksplisit di atas setiap input field atau terapkan pola floating label modern yang tetap terlihat saat input berisi teks. |
| 7 | **Ketergantungan Gambar Eksternal Tanpa Fallback** | Foto cabang kampus sekolah memuat link eksternal Unsplash (`images.unsplash.com`). Jika koneksi pengguna lambat atau Unsplash diblokir firewall sekolah, kartu informasi cabang menampilkan gambar rusak/pecah tanpa fallback lokal maupun skeleton shimmer. | Keduanya | [`app/Http/Controllers/SchoolController.php:214, 237, 260`](file:///C:/Users/Administrator/Documents/AttamamEdu/app/Http/Controllers/SchoolController.php#L214)<br>[`resources/views/components/animated-tabs.blade.php:60-66`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/components/animated-tabs.blade.php#L60-L66) | **HIGH** | Simpan aset gambar cabang secara lokal di `public/images/` dalam format WebP, dan sertakan atribut `onerror="this.src='{{ asset('images/sch1.jpeg') }}'"` pada tag `<img>`. |
| 8 | **Grid Tab Cabang Sekolah Timpang pada Mobile** | Di layar <768px, `.tab-nav-bar` dipaksa menjadi grid 2 kolom (`grid-template-columns: repeat(2, 1fr) !important;`). Karena jumlah cabang ada 3 (Pusat, Panam, Marpoyan), tab ke-3 sendirian di baris kedua dan meninggalkan kolom kosong di sampingnya. | Mobile | [`public/css/style.css:4878-4887`](file:///C:/Users/Administrator/Documents/AttamamEdu/public/css/style.css#L4878-L4887) | **MEDIUM** | Gunakan flexbox scroll horizontal halus (`display: flex; overflow-x: auto; scroll-snap-type: x mandatory;`) atau buat item ganjil terakhir merentang penuh `grid-column: span 2`. |
| 9 | **Tipografi Sub-12px & Kontras Rendah Neumorphism** | Label masa studi pada kartu jenjang menggunakan font `0.68rem` (~10.8px) dan label keunggulan menggunakan `0.72rem` (~11.5px). Ukuran teks di bawah 12px sangat sulit dibaca di smartphone dan gagal memenuhi rasio kontras 4.5:1 WCAG AA. | Keduanya | [`public/css/style.css:2480, 2502`](file:///C:/Users/Administrator/Documents/AttamamEdu/public/css/style.css#L2480)<br>[`resources/views/welcome.blade.php:134-150`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/welcome.blade.php#L134-L150) | **MEDIUM** | Naikkan font-size minimal ke `0.82rem` (13.1px) dan perjelas saturasi warna teks token (`--neu-text-role` & `--neu-accent`) agar terbaca nyaman oleh calon wali santri. |
| 10 | **Data Kontak Dummy Tidak Konsisten** | Nomor WhatsApp di floating button dan footer mengarah ke nomor palsu `6281200000000`. Pada halaman sukses PPDB, nomor telepon tertulis `(021) 555-0192` (kode Jakarta 021, padahal lokasi di Pekanbaru 0761). Pengguna yang ingin menghubungi sekolah akan terputus. | Keduanya | [`resources/views/partials/footer.blade.php:22`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/partials/footer.blade.php#L22)<br>[`resources/views/partials/whatsapp-button.blade.php:254`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/partials/whatsapp-button.blade.php#L254)<br>[`resources/views/ppdb/success.blade.php:136`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/ppdb/success.blade.php#L136) | **MEDIUM** | Sentralisasi konfigurasi kontak sekolah ke dalam `config/school.php` (misal: telepon `(0761) 555-0192` dan WA resmi `0812-7000-1920`) sehingga seluruh komponen memanggil variabel yang seragam. |
| 11 | **Tabel Admin PPDB: Ketiadaan Swipe Hint di Layar Mobile** | Tabel pendaftaran PPDB memiliki 9 kolom informasi yang melampaui lebar layar mobile. Walaupun memiliki `overflow-x: auto`, ketiadaan bayangan gradasi (shadow fade) di sisi kanan membuat admin tidak menyadari adanya tombol aksi penting (Detail, Status, Hapus) yang terpotong di tepi kanan. | Mobile & Tablet | [`resources/views/admin/ppdb/index.blade.php:31-65`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/admin/ppdb/index.blade.php#L31-L65) | **MEDIUM** | Berikan efek bayangan tepi kanan (`box-shadow: inset -12px 0 10px -6px rgba(0,0,0,0.35)`) atau badge kecil "Geser ke kanan untuk aksi ➔" pada layar mobile. |
| 12 | **Inkonsistensi Karakter Emoji Mentah sebagai Ikon UI** | Pada halaman detail berita dan lencana jurusan, elemen visual menggunakan emoji Unicode OS (`📅`, `✍️`, `⏱️`, `📰`, `⭐`) yang tampil berbeda antara Windows, Apple iOS, dan Android, merusak konsistensi icon set SVG Lucide. | Keduanya | [`resources/views/news/show.blade.php:174-176, 194`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/news/show.blade.php#L174-L176)<br>[`resources/views/news/index.blade.php:46, 203`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/news/index.blade.php#L46) | **MEDIUM** | Ganti seluruh emoji UI dengan SVG line icons (Lucide Icons) terstandarisasi dengan ukuran 16px dan stroke-width 2. |
| 13 | **Form CMS Berita: Input Thumbnail Berupa URL Manual & Raw Textarea** | Form berita mengharuskan admin menginput link URL gambar secara manual (`https://picsum.photos/...`) tanpa adanya fitur upload file dari HP/PC dan tanpa live preview. Konten berita juga berupa plain `<textarea>` tanpa editor format teks (bold, italic, list, heading). | Keduanya | [`resources/views/admin/news/create.blade.php:39-44`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/admin/news/create.blade.php#L39-L44)<br>[`resources/views/admin/news/create.blade.php:57-62`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/admin/news/create.blade.php#L57-L62) | **MEDIUM** | Sediakan input file dengan drag-and-drop & pratinjau instan, serta integrasikan rich-text editor ringan (Quill / Trix Editor) pada kolom isi berita. |
| 14 | **Breadcrumb Truncation Tanpa Title Tooltip** | Breadcrumb pada artikel berita memangkas judul panjang menggunakan `Str::limit($news->title, 40)` tanpa atribut `title`. Pengguna desktop tidak dapat melihat judul lengkap saat melakukan hover mouse. | Desktop | [`resources/views/news/show.blade.php:166`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/news/show.blade.php#L166) | **LOW** | Tambahkan atribut `title="{{ $news->title }}"` pada tag breadcrumb agar memunculkan tooltip native saat kursor diarahkan. |
| 15 | **Sisa String Nama Sekolah Lama di Console Log** | Terdapat script `console.log('Website Sekolah SMKN 1 Nusantara - Dimuat dengan sukses!');` di bagian footer landing page yang belum diubah ke nama resmi PKBM Tahfizh At-Tamam. | Keduanya | [`resources/views/welcome.blade.php:230`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/welcome.blade.php#L230) | **LOW** | Hapus atau ganti teks log menjadi `'Website PKBM Tahfizh At-Tamam - Dimuat dengan sukses!'`. |
| 16 | **Halaman Error 403 Tidak Selaras dengan Branding** | Halaman Akses Ditolak (HTTP 403) menggunakan layout inline HTML putih polos tanpa logo sekolah, tanpa dukungan tema gelap, dan hanya memiliki tombol login/logout tanpa opsi kembali ke Beranda utama. | Keduanya | [`resources/views/errors/403.blade.php:1-36`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/errors/403.blade.php#L1-L36) | **LOW** | Selaraskan halaman 403 (serta 404/500) dengan styling institusi At-Tamam Edu lengkap dengan logo dan tombol "Kembali ke Beranda". |
| 17 | **Path Background Gambar Absolut di File CSS** | Hero background di CSS didefinisikan menggunakan path absolut `url('/images/sch5.jpg');`. Jika aplikasi dipasang di subdirectory server, gambar hero berisiko 404 Not Found. | Keduanya | [`public/css/style.css:1219`](file:///C:/Users/Administrator/Documents/AttamamEdu/public/css/style.css#L1219) | **LOW** | Ganti menjadi path relatif terhadap berkas stylesheet: `url('../images/sch5.jpg');`. |
| 18 | **Alt Text Gambar Logo Mobile Terlalu Generik** | Tag logo pada drawer mobile menggunakan atribut `alt="Logo"` yang terlalu singkat dan tidak deskriptif bagi pengguna pembaca layar (screen reader). | Mobile | [`resources/views/partials/navbar.blade.php:102`](file:///C:/Users/Administrator/Documents/AttamamEdu/resources/views/partials/navbar.blade.php#L102) | **LOW** | Perbarui menjadi `alt="Logo Resmi PKBM Tahfizh At-Tamam"`. |

---

## 4. Analisis Teknis Mendalam per Temuan

### 4.1 Temuan Tingkat CRITICAL

#### Temuan 1: Bypass Validasi Client-Side pada Formulir Multi-Step PPDB
- **File:** `resources/views/ppdb/create.blade.php` (Baris 607, 756-763, 1187-1194)
- **Kondisi Saat Ini:**
  Tag form didefinisikan dengan `<form id="ppdbForm" ... novalidate>`. Saat pengguna berada di Slide 1 (Data Calon Siswa), tombol aksi hanya menjalankan:
  ```javascript
  window.nextSlide = function (targetStep) {
      showSlide(targetStep);
  };
  ```
  Tidak ada satupun pengecekan apakah input wajib (`full_name`, `gender`, `birth_date`, `address`) sudah terisi. Pengguna dapat langsung menekan tombol "Lanjut ke Data Orang Tua →" lalu "Lanjut ke Unggah Berkas →" tanpa mengisi apapun.
- **Dampak UX:**
  Ketika pengguna menekan "Kirim Pendaftaran PPDB" di Slide 3, backend Laravel me-reject request dengan kode 422/redirect back. Blade template merespons error dengan membaca `data-initial-step` lalu memaksa form melompat kembali ke Langkah 1. Pengguna awam merasa form rusak (*broken state*) karena pendaftaran mental kembali ke awal tanpa ada fokus kursor atau scroll otomatis ke field yang bermasalah.
- **Solusi Arsitektur:**
  Terapkan fungsi `validateCurrentStep(stepNumber)` sebelum `showSlide()`. Jika ada input invalid, hentikan transisi slide, tambahkan class `has-error`, tampilkan tooltip peringatan, dan scroll ke input pertama yang belum lengkap.

#### Temuan 2: Kerusakan Tata Letak Login Mobile akibat iOS Auto-Zoom & Keyboard Occlusion
- **File:** `resources/views/auth/login.blade.php` (Baris 736-765, 929-965)
- **Kondisi Saat Ini:**
  Di media query mobile (<= 570px):
  ```css
  .container {
      border-radius: 22px;
      min-height: 830px; /* Nilai fixed sangat tinggi */
  }
  .input-field input {
      font-size: 0.86rem; /* Sekitar 13.76px (< 16px) */
  }
  .signin-signup {
      top: 59%;
      position: absolute;
      transform: translate(-50%, -50%);
  }
  ```
- **Dampak UX:**
  1. Pada iPhone Safari, ukuran font form < 16px secara otomatis memicu browser untuk men-zoom in layar (scale 1.25x–1.5x) saat input menerima fokus. Hal ini membuat kontainer form terpotong keluar batas layar kanan dan kiri.
  2. Saat keyboard virtual ponsel muncul (memangkas viewport height menjadi hanya ~320px–360px), kombinasi `position: absolute; top: 59%` dan `min-height: 830px` mendorong tombol "Login" ke bawah lipatan keyboard virtual. Pengguna tidak dapat men-submit form karena tombol tertutup keyboard dan container tidak memiliki alur scroll normal.

---

### 4.2 Temuan Tingkat HIGH

#### Temuan 3: Tautan Mati Tombol Social Authentication pada Halaman Login
- **File:** `resources/views/auth/login.blade.php` (Baris 2172-2204)
- **Kondisi Saat Ini:**
  Teks penjelas berbunyi *"Or sign in with social platforms"*, tetapi tombol Google, Twitter, dan LinkedIn memiliki atribut `href="javascript:void(0)"`. Sementara tombol Facebook menautkan pengguna ke `https://www.facebook.com/groups/309658054507585`.
- **Dampak UX:**
  Guru dan staf yang mengklik ikon Google berasumsi mereka dapat melakukan login dengan akun Google Workspace sekolah (`@pkbmtahfizhattamam.sch.id`). Namun tombol tidak merespons sama sekali, menimbulkan persepsi sistem belum selesai dibuat (*unfinished product*).

#### Temuan 4: Celah Mengambang (Dead Gap 88px) akibat Penempatan Floating Button
- **File:** `public/css/style.css` (Baris 4174-4176, 5120-5126), `resources/views/partials/whatsapp-button.blade.php` (Baris 180-185)
- **Kondisi Saat Ini:**
  Pada layar mobile (≤ 768px):
  ```css
  body {
      padding-bottom: calc(76px + max(12px, env(safe-area-inset-bottom, 12px)));
  }
  .floating-wa-wrapper, .floating-back-to-top {
      bottom: calc(76px + max(10px, env(safe-area-inset-bottom, 10px)));
  }
  ```
  Angka `76px` ini adalah slot untuk bilah dock bawah mobile (`.nav-mobile-dock-box`). Namun, komponen dock tersebut tidak ada dalam template Blade `layouts/app.blade.php` maupun `partials/navbar.blade.php`.
- **Dampak UX:**
  Di seluruh halaman publik (Beranda, PPDB, Berita), bagian bawah body memiliki ruang kosong sebesar 88px–100px. Tombol WhatsApp dan Back-to-Top melayang tinggi di tengah-bawah layar, seringkali menutupi teks paragraf terakhir, kartu cabang, atau tombol submit formulir.

#### Temuan 5: Inkonsistensi Palet Warna Dual-Theme & Benturan Visual Card Berita
- **File:** `public/css/style.css` (Baris 5495-5550), `resources/views/news/show.blade.php` (Baris 34-41)
- **Kondisi Saat Ini:**
  Dalam file CSS, `[data-theme="light"] body` disetel ke `background-color: oklch(41% 0.159 10.272)` (merah marun gelap) dengan teks `#ffffff`. Sementara tombol switcher navbar menampilkan teks "Mode Terang / Mode Gelap" dengan ikon Matahari. Pada `news/show.blade.php`, card artikel berita memiliki background inline hardcoded:
  ```css
  .news-content {
      background: var(--card-bg, rgba(0, 33, 71, 0.6)); /* Navy gelap */
      border: 1px solid var(--border, rgba(0, 180, 216, 0.25));
  }
  ```
- **Dampak UX:**
  Ketika pengguna beralih ke "Mode Terang", layar tidak berubah menjadi putih/terang, melainkan marun gelap. Pada halaman detail berita, card konten tetap berwarna biru navy gelap di atas latar marun kemerahan dengan border putih abu-abu, menciptakan tabrakan warna yang merusak estetika dan keterbacaan.

#### Temuan 6: Hilangnya Identitas Input Field saat Fokus (Tanpa Tag Label)
- **File:** `resources/views/auth/login.blade.php` (Baris 2128-2157)
- **Kondisi Saat Ini:**
  Input field email dan password hanya didekorasi dengan ikon dan atribut `placeholder="Email"` / `placeholder="Password"`.
- **Dampak UX:**
  Begitu pengguna mulai mengetik, teks placeholder langsung hilang. Pengguna disleksia atau pengguna yang mengalami distraksi kesulitan memastikan apakah kolom yang sedang diisi adalah nomor telepon, NIP, atau alamat email. Pembaca layar (screen reader) juga tidak dapat mengumumkan konteks input secara semantik.

#### Temuan 7: Kerentanan Aset Eksternal Unsplash pada Informasi Kampus
- **File:** `app/Http/Controllers/SchoolController.php` (Baris 214, 237, 260), `resources/views/components/animated-tabs.blade.php` (Baris 59-67)
- **Kondisi Saat Ini:**
  Foto fasilitas Kampus Pusat, Cabang Panam, dan Cabang Marpoyan memanggil tautan eksternal:
  `https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3...`
- **Dampak UX:**
  Saat pengunjung membuka tab cabang sekolah menggunakan jaringan seluler lambat atau jaringan institusi yang memblokir CDN luar, gambar tidak termuat sama sekali (ikon broken image). Komponen tidak memiliki fallback lokal (`images/sch1.jpeg` dll.) maupun skeleton loading.

---

### 4.3 Temuan Tingkat MEDIUM

#### Temuan 8: Layout Tab Cabang Timpang pada Mobile
- **File:** `public/css/style.css` (Baris 4878-4887)
- **Penyebab:** Aturan CSS `grid-template-columns: repeat(2, 1fr) !important;` pada mobile untuk 3 tombol cabang (Pusat, Panam, Marpoyan).
- **Akibat:** Baris pertama berisi 2 tombol, sedangkan baris kedua hanya berisi 1 tombol di sisi kiri dengan ruang kosong di kanannya. Tampak seperti kesalahan rendering layout.

#### Temuan 9: Tipografi Sub-12px pada Kartu Jenjang Pendidikan
- **File:** `public/css/style.css` (Baris 2480, 2502), `resources/views/welcome.blade.php`
- **Penyebab:** Nilai `font-size: 0.68rem` (10.88px) pada `.pc-12__stat span` dan `0.72rem` (11.52px) pada `.pc-12__prospek-label`.
- **Akibat:** Ukuran teks di bawah batas minimal kenyamanan membaca mobile (12px/13px), menyebabkan calon wali santri kesulitan membaca detail masa studi dan program keunggulan.

#### Temuan 10: Ketidaksinkronan Nomor Kontak dan Wilayah Telepon
- **File:** `resources/views/partials/footer.blade.php:22`, `resources/views/partials/whatsapp-button.blade.php:254`, `resources/views/ppdb/success.blade.php:136`
- **Penyebab:** Penggunaan data dummy berbeda-beda: WhatsApp `6281200000000`, telepon `(021) 555-0192` (kode area Jakarta), padahal kampus berlokasi di Kota Pekanbaru (kode area 0761).
- **Akibat:** Pengunjung yang menekan tombol chat WhatsApp atau menelepon panitia PPDB dari kartu bukti pendaftaran tidak akan terhubung ke admin resmi.

#### Temuan 11: Ketiadaan Visual Indicator Geser pada Tabel Admin PPDB Mobile
- **File:** `resources/views/admin/ppdb/index.blade.php` (Baris 31-65)
- **Penyebab:** Tabel pendaftar memiliki 9 kolom data yang melebihi lebar layar smartphone tanpa indikator visual fade / bayangan di tepi kanan.
- **Akibat:** Admin PPDB yang mengoperasikan sistem dari smartphone atau tablet sering tidak menyadari bahwa tombol aksi "Detail", "Ubah Status", dan "Hapus" ada di sebelah kanan tabel.

#### Temuan 12: Penggunaan Emoji Mentah yang Merusak Standarisasi Desain
- **File:** `resources/views/news/show.blade.php:174-176`, `resources/views/news/index.blade.php:46`
- **Penyebab:** Penggunaan karakter Unicode emoji OS (`📅`, `✍️`, `⏱️`, `📰`, `⭐`) di tengah-tengah komponen yang sudah mengadopsi icon set Lucide SVG.
- **Akibat:** Tampilan emoji berbeda drastis antar platform (flat di Windows, 3D berwarna di iOS/macOS, kartun di Android), mengurangi kesan elegan dan profesional institusi tahfizh terpadu.

#### Temuan 13: Kolom Berita CMS Menggunakan URL Gambar Manual & Plain Textarea
- **File:** `resources/views/admin/news/create.blade.php` (Baris 39-62)
- **Penyebab:** Thumbnail berita mewajibkan input teks URL (`https://...`) tanpa tombol upload berkas lokal, serta konten berita berupa textarea tanpa tombol pemformatan teks.
- **Akibat:** Admin sekolah tidak dapat mengunggah dokumentasi foto kegiatan secara langsung dan tidak dapat membuat heading, teks tebal, maupun poin list pada warta sekolah.

---

### 4.4 Temuan Tingkat LOW

#### Temuan 14: Pemotongan Breadcrumb Tanpa Tooltip
- **File:** `resources/views/news/show.blade.php:166`
- **Masalah:** Judul artikel dipotong `Str::limit(..., 40)` tanpa atribut `title="{{ $news->title }}"`. Pengguna desktop tidak dapat membaca judul penuh melalui hover mouse.

#### Temuan 15: String Konsol Sekolah Lawas
- **File:** `resources/views/welcome.blade.php:230`
- **Masalah:** Baris `console.log('Website Sekolah SMKN 1 Nusantara - Dimuat dengan sukses!');` masih tertinggal pada footer script landing page.

#### Temuan 16: Halaman Error 403 Sederhana & Unbranded
- **File:** `resources/views/errors/403.blade.php`
- **Masalah:** Tampilan error 403 berupa template HTML dasar putih polos tanpa identitas sekolah At-Tamam dan tanpa tombol kembali ke Beranda.

#### Temuan 17: Path Gambar Background Absolut di File CSS
- **File:** `public/css/style.css:1219`
- **Masalah:** Aturan `background-image: url('/images/sch5.jpg');` menggunakan leading slash root. Jika aplikasi dideploy pada subdirektori web server, gambar akan 404.

#### Temuan 18: Alt Text Logo Terlalu Pendek pada Mobile Panel
- **File:** `resources/views/partials/navbar.blade.php:102`
- **Masalah:** Gambar logo pada drawer mobile hanya bertuliskan `alt="Logo"`.

---

## 5. Cakupan 8 Pilar Desain Berdasarkan Spesifikasi UI.MD

### 5.1. Layout & Responsiveness
- **Desktop Grid:** Grid 3 kolom pada berita dan jenjang tertata simetris di layar desktop (1200px+).
- **Tablet (768px – 1024px):** Navbar secara mulus beralih menyembunyikan kapsul navigasi tengah dan menampilkan hamburger drawer.
- **Mobile (<768px):** Perlu menghilangkan `padding-bottom: 76px` pada body dan menata ulang floating WhatsApp button agar menempel secara proporsional 16px di atas batas bawah layar.

### 5.2. Tipografi
- **Skala Rasio Font:** Mengadopsi kombinasi *Plus Jakarta Sans* (modern geometric sans-serif untuk fungsionalitas UI & body) dan *Playfair Display* (editorial serif klasik untuk kutipan sambutan kepsek).
- **Standar Minimal:** Seluruh teks antarmuka diwajibkan berukuran minimal `0.8125rem` (13px) untuk menjamin kenyamanan mata di smartphone.

### 5.3. Navigasi & Interaksi
- **Touch Target:** Semua elemen yang dapat diklik pada mobile disesuaikan dengan standar ergonomi jari manusia: tinggi minimal `44px` dan lebar minimal `44px`.
- **Haptic & Kinetic Feedback:** Tombol aksi utama telah memiliki transisi `cubic-bezier(0.16, 1, 0.3, 1)` dan efek scale `0.98` saat di-tap/active.

### 5.4. Gambar & Media
- **Local Priority:** Mengutamakan aset lokal terkompresi WebP/AVIF di `public/images/`.
- **Pembersihan Penyimpanan:** File video `public/images/bck1.mp4` sebesar 244 MB yang tidak terpakai harus dieliminasi dari repositori kerja.

### 5.5. Form & Input
- **Validasi Bertingkat:** Memasang validasi real-time instan per langkah wizard PPDB. Input yang tidak valid langsung diberi highlight merah dan fokus kursor.
- **Pencegahan iOS Zoom:** Seluruh input formulir pada mobile wajib memiliki `font-size: 16px !important` agar Safari tidak melakukan auto-zoom paksa.

### 5.6. Konsistensi Desain
- **Penetapan Tema:** Mode Terang dirancang ulang menjadi tema putih bersih (*Academic Crisp Clean*), sementara Mode Gelap mempertahankan karakter *Oxford Deep Navy*.
- **Icon Set:** 100% menggunakan Lucide Line Icons berbasis SVG.

### 5.7. Kompatibilitas Browser & Device
- **Support WebKit:** Menyertakan prefix `-webkit-backdrop-filter` pada setiap efek glassmorphism.
- **Warna Fallback:** Setiap deklarasi `oklch()` dipasangi fallback warna heksadesimal standar agar kompatibel pada browser versi lama.

### 5.8. Aksesibilitas Dasar (WCAG 2.1 AA)
- **Rasio Kontras:** Minimal 4.5:1 untuk teks normal dan 3:1 untuk teks tebal/judul besar.
- **Keyboard Navigation:** Setiap tombol kustom dan tab interaktif memiliki outline `:focus-visible` kontras tinggi dengan ring offset 2px.

---

## 6. Blueprint Desain Sistem Baru (Design System Architecture)

### 6.1 Token Desain Warna Baru (Dual-Theme Tokens)

```css
/* ═════════════════════════════════════════════════════════════════════
   DESIGN SYSTEM TOKENS — PKBM TAHFIZH AT-TAMAM EDU
   ═════════════════════════════════════════════════════════════════════ */

/* 1. DARK MODE (Oxford Deep Navy & Neon Cyan — Default) */
:root, [data-theme="dark"] {
    --color-bg-base: #001529;
    --color-bg-surface: rgba(0, 33, 71, 0.82);
    --color-bg-card: #002147;
    --color-bg-card-hover: rgba(0, 48, 96, 0.95);
    
    --color-border-subtle: rgba(0, 180, 216, 0.25);
    --color-border-active: #00B4D8;
    
    --color-primary: #00B4D8;
    --color-primary-hover: #38bdf8;
    --color-primary-text: #ffffff;
    
    --color-text-main: #ffffff;
    --color-text-sub: #f1f5f9;
    --color-text-muted: #cbd5e1; /* Rasio kontras > 4.8:1 di atas navy */
    
    --color-status-success: #10b981;
    --color-status-warning: #f59e0b;
    --color-status-danger: #ef4444;
}

/* 2. TRUE LIGHT MODE (Academic Pure White & Royal Sapphire) */
[data-theme="light"] {
    --color-bg-base: #f8fafc;
    --color-bg-surface: #ffffff;
    --color-bg-card: #ffffff;
    --color-bg-card-hover: #f1f5f9;
    
    --color-border-subtle: #e2e8f0;
    --color-border-active: #0284c7;
    
    --color-primary: #0284c7;
    --color-primary-hover: #0369a1;
    --color-primary-text: #ffffff;
    
    --color-text-main: #0f172a;
    --color-text-sub: #334155;
    --color-text-muted: #64748b; /* Rasio kontras > 4.6:1 di atas putih */
    
    --color-status-success: #059669;
    --color-status-warning: #d97706;
    --color-status-danger: #dc2626;
}
```

---

## 7. Panduan Solusi & Kode Implementasi Konkret

### 7.1 Solusi Masalah 1 (Validasi Client-Side Multi-Step PPDB)

Modifikasi pada file `resources/views/ppdb/create.blade.php`:

```javascript
// Tambahkan fungsi validasi per slide sebelum berpindah
function validateStep(step) {
    const currentSlideEl = document.getElementById('slide-' + step);
    if (!currentSlideEl) return true;

    let isValid = true;
    let firstInvalidInput = null;

    // Bersihkan error lama
    currentSlideEl.querySelectorAll('.ppdb-field-error-msg').forEach(el => el.remove());
    currentSlideEl.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    // Validasi input text, select, dan textarea yang berstatus required
    const requiredInputs = currentSlideEl.querySelectorAll('input[required], select[required], textarea[required]');
    
    requiredInputs.forEach(input => {
        let fieldValid = true;

        if (input.type === 'radio') {
            const name = input.name;
            const checked = currentSlideEl.querySelector(`input[name="${name}"]:checked`);
            if (!checked) fieldValid = false;
        } else if (input.type === 'checkbox') {
            if (!input.checked) fieldValid = false;
        } else {
            if (!input.value.trim()) fieldValid = false;
        }

        if (!fieldValid) {
            isValid = false;
            input.classList.add('is-invalid');

            // Tambahkan pesan error di bawah field
            const errorMsg = document.createElement('span');
            errorMsg.className = 'ppdb-field-error-msg';
            errorMsg.style.cssText = 'color: #ef4444; font-size: 0.8rem; margin-top: 4px; display: block; font-weight: 600;';
            errorMsg.textContent = 'Bagian ini wajib diisi dengan benar.';
            input.parentNode.appendChild(errorMsg);

            if (!firstInvalidInput) firstInvalidInput = input;
        }
    });

    if (!isValid && firstInvalidInput) {
        firstInvalidInput.focus();
        firstInvalidInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    return isValid;
}

// Pasang guard pada tombol nextSlide
window.nextSlide = function (targetStep) {
    if (targetStep > currentStep) {
        if (!validateStep(currentStep)) {
            return false; // Batalkan perpindahan slide jika step saat ini belum lengkap
        }
    }
    showSlide(targetStep);
};
```

---

### 7.2 Solusi Masalah 2 (Form Login Mobile: Anti-Zoom iOS & Keyboard Adaptation)

Modifikasi pada file `resources/views/auth/login.blade.php`:

```css
/* Aturan Responsif Mobile Login Baru (<= 570px) */
@media (max-width: 570px) {
    body {
        padding: 1.5rem 1rem;
        min-height: 100dvh; /* Dynamic viewport height */
        display: block; /* Hindari centering vertikal kaku saat keyboard aktif */
        overflow-y: auto;
    }

    .container {
        border-radius: 20px;
        min-height: auto !important; /* Hapus min-height 830px */
        height: auto !important;
        position: relative;
        overflow: visible;
        margin: 2rem auto;
    }

    .signin-signup {
        position: relative !important;
        top: auto !important;
        left: auto !important;
        transform: none !important;
        width: 100% !important;
    }

    form {
        padding: 2rem 1.25rem !important;
        position: relative !important;
    }

    /* KUNCI: 16px mencegah iOS Safari Auto-Zoom */
    .input-field input {
        font-size: 16px !important;
    }

    .input-field {
        height: 50px;
        margin: 10px 0;
    }
}
```

---

### 7.3 Solusi Masalah 4 (Koreksi Posisi Floating Buttons & Penghapusan Padding Phantom)

Modifikasi pada file `public/css/style.css` dan `resources/views/partials/whatsapp-button.blade.php`:

```css
/* Gantikan aturan baris 4174 & 5120 di style.css */
@media (max-width: 768px) {
    body {
        /* Hilangkan padding-bottom 76px yang menyebabkan celah kosong */
        padding-bottom: env(safe-area-inset-bottom, 16px);
    }

    /* Posisikan tombol WhatsApp & Back to top 16px proporsional di atas sudut bawah */
    .floating-wa-wrapper {
        bottom: calc(16px + env(safe-area-inset-bottom, 0px)) !important;
        left: 16px !important;
        z-index: 990;
    }

    .floating-back-to-top {
        bottom: calc(16px + env(safe-area-inset-bottom, 0px)) !important;
        right: 16px !important;
        z-index: 990;
    }
}
```

---

### 7.4 Solusi Masalah 8 (Perbaikan Grid Tab Cabang Kampus Mobile)

Modifikasi pada file `public/css/style.css` (Baris 4878):

```css
/* Dari grid 2-kolom yang timpang diubah menjadi scrollable bar yang elegan */
@media (max-width: 768px) {
    .tab-nav-bar {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        gap: 8px !important;
        padding: 6px !important;
        justify-content: flex-start !important;
        scrollbar-width: none; /* Sembunyikan scrollbar default */
    }

    .tab-nav-bar::-webkit-scrollbar {
        display: none;
    }

    .tab-btn {
        flex: 0 0 auto !important;
        scroll-snap-align: start;
        white-space: nowrap !important;
        padding: 10px 18px !important;
    }
}
```

---

### 7.5 Solusi Masalah 10 (Sentralisasi Konfigurasi Kontak Resmi)

Buat file konfigurasi baru `config/school.php`:

```php
<?php

return [
    'name' => 'PKBM Tahfizh At-Tamam Edu',
    'phone' => '(0761) 555-0192', // Kode area resmi Pekanbaru
    'whatsapp' => '081270001920', // Nomor admin CS resmi
    'whatsapp_formatted' => '0812-7000-1920',
    'whatsapp_url' => 'https://wa.me/6281270001920',
    'email' => 'info@pkbmtahfizhattamam.sch.id',
    'address' => 'Jl. Hangtuah No. 45, Rejosari, Tenayan Raya, Pekanbaru, Riau 28281',
];
```

Dan gunakan pemanggilan seragam di seluruh Blade template:
- `{{ config('school.whatsapp_url') }}`
- `{{ config('school.phone') }}`

---

## 8. Roadmap Eksekusi Bertahap (Action Plan)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                          ROADMAP REDESIGN UI/UX                             │
└─────────────────────────────────────────────────────────────────────────────┘

  [FASE 1: HOTFIX KRITIS & FUNGSIONAL] (Sprint 1)
  ├── 1. Validasi Client-Side Form PPDB (ppdb/create.blade.php)
  ├── 2. Font 16px & Layout Flex Dinamis Login Mobile (auth/login.blade.php)
  ├── 3. Bersihkan dead link social sign-in
  └── 4. Koreksi celah phantom 88px floating buttons (style.css)

  [FASE 2: PENYELARASAN TEMA & DESAIN SISTEM] (Sprint 2)
  ├── 1. Harmonisasi Mode Terang (Pure Light) vs Mode Gelap (Navy)
  ├── 2. Perbaiki card background clash pada news/show.blade.php
  ├── 3. Standarisasi font-size sub-12px kartu jenjang (welcome.blade.php)
  └── 4. Gantikan seluruh karakter emoji visual dengan Lucide SVG icons

  [FASE 3: OPTIMASI ASET & RESPONSIVITAS TINGKAT LANJUT] (Sprint 3)
  ├── 1. Konversi tab cabang mobile ke horizontal scroll pill bar
  ├── 2. Unduh aset Unsplash ke lokal public/images/ dengan onerror fallback
  ├── 3. Hapus video bck1.mp4 (244 MB) yang tidak terpakai
  └── 4. Buat config/school.php untuk sentralisasi kontak & telepon resmi

  [FASE 4: KUALITAS AKHIR & AKSESIBILITAS WCAG] (Sprint 4)
  ├── 1. Tambahkan shadow swipe hint pada tabel admin mobile
  ├── 2. Sematkan :focus-visible outline rings pada tab dan tombol
  ├── 3. Redesain halaman 403, 404, dan 500 berkarakter At-Tamam Edu
  └── 4. Verifikasi akhir pengujian lintas browser (Chrome, Safari, Firefox, Edge)
```

---
*Dokumen perancangan ulang ini adalah panduan resmi perbaikan dan modernisasi visual website PKBM Tahfizh At-Tamam Edu.*
