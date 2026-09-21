# Rencana Migrasi: Konversi TypeScript & React ke JavaScript Murni (Vanilla JS)

Dokumen ini memuat seluruh analisis, arsitektur, jaminan efek animasi 1:1, dan panduan langkah demi langkah untuk mengonversi komponen navigasi berbasis **React + TypeScript + Framer Motion** menjadi **JavaScript Murni (Vanilla JS) + CSS Modern** di aplikasi Laravel **AttamamEdu**.

---

## 1. Latar Belakang & Tujuan

### Masalah Saat Ini
1. **Beban Dependensi Berat (*Overhead*)**:
   Saat ini, aplikasi memuat pustaka `react` (v19), `react-dom` (v19), `framer-motion` (v13), dan `lucide-react` hanya untuk merender **satu bilah menu navigasi tab** di header (`MainNavigationTabs`). Ini menambah ratusan kilobyte ukuran JavaScript yang harus diunduh dan diproses oleh browser.
2. **Kedipan DOM (*Flash / Layout Shift*)**:
   Laravel Blade merender markup HTML statis di `#react-main-nav`. Namun beberapa milidetik setelah halaman dimuat, skrip React di `app.js` melakukan `createRoot` dan mengganti seluruh DOM elemen tersebut.
3. **Dual Stack**:
   Proyek Laravel berbasis Blade bercampur dengan sintaks `.tsx` dan konfigurasi `components.json` (shadcn style) yang tidak lazim untuk ekosistem Blade murni.

### Tujuan Migrasi
* Mengubah seluruh logika interaksi dan animasi menjadi **Vanilla JavaScript murni** dan **CSS Transitions modern**.
* **Menjamin 100% tidak ada efek animasi maupun fungsionalitas yang hilang.**
* Menghapus seluruh file `.tsx` dan `.ts` yang tidak diperlukan (`resources/js/components/ui/` dan `resources/js/lib/`).
* Mengoptimalkan performa halaman (*Zero hydration delay*, *Zero layout shift*, *Instant render*).

---

## 2. Inventaris File yang Terdampak

| Lokasi File | Tipe Saat Ini | Tindakan yang Direncanakan |
| :--- | :--- | :--- |
| `resources/js/components/ui/expandable-tabs.tsx` | React Component (.tsx) | **Dihapus** (Digantikan logika Vanilla JS + CSS) |
| `resources/js/components/ui/main-navigation-tabs.tsx` | React Component (.tsx) | **Dihapus** (Digantikan logika Vanilla JS + CSS) |
| `resources/js/components/ui/demo.tsx` | React Component (.tsx) | **Dihapus** (Hanya file demo lokal) |
| `resources/js/lib/utils.ts` | TypeScript Helper (.ts) | **Dihapus** (Fungsi `cn` tidak lagi dibutuhkan tanpa React) |
| `resources/js/app.js` | JavaScript Bundle Entry | **Dimodifikasi** (Hapus `createRoot`, `React`, ganti dengan import Vanilla JS) |
| `resources/js/animated-tabs.js` | Vanilla JS Module | **Dioptimalkan / Disatukan** untuk tabs interaktif |
| `resources/views/partials/navbar.blade.php` | Blade Template | **Dioptimalkan** (Hapus pembungkus React mount, sempurnakan script Vanilla) |
| `public/css/style.css` | Stylesheet Utama | **Dipertahankan & Dipastikan** kurva cubic-bezier berjalan sempurna |
| `vite.config.js` | Konfigurasi Build Vite | **Dimodifikasi** (Hapus `@vitejs/plugin-react`) |
| `components.json` | Konfigurasi Shadcn | **Dihapus / Dinonaktifkan** |
| `package.json` | Dependensi Proyek | **Dibersihkan** (Hapus `react`, `react-dom`, `framer-motion`, dll) |

---

## 3. Matriks Jaminan Efek Visual & Interaktif (1:1)

Semua efek yang sebelumnya ditangani oleh React + Framer Motion akan dijamin tetap aktif dengan padanan teknis berikut:

| No | Efek Visual / Interaksi | Implementasi di React + Framer Motion | Implementasi di JavaScript Murni + CSS | Status Jaminan |
| :---: | :--- | :--- | :--- | :---: |
| **1** | **Pelebaran Tab saat Hover (*Expand on Hover*)** | Framer Motion animate spring: lebar teks bertambah saat kursor masuk. | CSS Transition: `max-width` 0 ke 140px & `opacity` 0 ke 1 dengan timing `cubic-bezier(0.16, 1, 0.3, 1)`. Sangat mulus pada 60-120fps. | **100% Identik** |
| **2** | **Indikator Aktif & Efek Glow** | State `selected === index` dengan styling Tailwind text glow. | Class `.expandable-tab-btn.active` di `style.css` dengan `box-shadow: 0 0 16px rgba(0, 180, 216, 0.32)` dan label tetap terbuka. | **100% Identik** |
| **3** | **Deteksi Scroll Otomatis (*Scrollspy*)** | `useEffect` scroll event listener memantau posisi elemen `#jenjang`, `#cabang`, `#berita`. | Fungsi Vanilla JS `updateScrollspy()` memantau posisi viewport dengan passive listener untuk performa maksimal. | **100% Identik** |
| **4** | **Smooth Scroll ke Section** | `handleSelect` memanggil `window.scrollTo({ behavior: 'smooth' })`. | Vanilla JS `handleSamePageNavigation()` dengan `window.scrollTo({ behavior: 'smooth' })` + dukungan GSAP ScrollSmoother (jika aktif). | **100% Identik** |
| **5** | **Sensasi Tekan Tombol (*Tactile Feedback*)** | Standar klik tombol. | Class mikro `.nav-link-pressed` (skala tombol membal 250ms saat ditekan). | **Lebih Responsif** |
| **6** | **Pemisah Tab (*Separator*) & Ikon Tajam** | Komponen React `<Icon>` + pemisah div. | Elemen SVG Lucide inline tajam di Blade + `.expandable-tab-separator`. | **100% Identik** |
| **7** | **Adaptasi Tema (Dark & Light Mode)** | Variabel Tailwind dark/light. | Variabel CSS `[data-theme="light"]` dan `[data-theme="dark"]` yang sudah ada di `public/css/style.css`. | **100% Identik** |

---

## 4. Rencana Langkah demi Langkah (Step-by-Step Execution Plan)

### Langkah 1: Penyiapan Modul JavaScript Murni
Membuat skrip Vanilla JS khusus (misal: `resources/js/expandable-tabs.js` atau disatukan dalam script navbar) yang menangani:
- Menghubungkan setiap tombol `.expandable-tab-btn`.
- Mengatur status `.active` saat tab diklik atau saat scroll melewati section tertentu.
- Sinkronisasi URL hash (`history.pushState`) tanpa memicu *page reload*.
- Menutup status fokus jika pengguna mengklik area di luar navbar (*click-outside*).

### Langkah 2: Pembersihan `resources/js/app.js`
Mengubah `app.js` agar tidak lagi mengimpor:
```javascript
// DIBERSIHKAN / DIHAPUS:
import React from 'react';
import { createRoot } from 'react-dom/client';
import { MainNavigationTabs } from './components/ui/main-navigation-tabs';
import { DefaultDemo, CustomColorDemo } from './components/ui/demo';
```
Dan menggantikannya dengan pemanggilan modul Vanilla JS yang bersih:
```javascript
// FORMAT BARU (VANILLA JS):
import './bootstrap';
import './animated-tabs';
import './expandable-tabs';
```

### Langkah 3: Penyempurnaan Template Blade (`navbar.blade.php`)
- Memastikan kontainer navigasi di `navbar.blade.php` tidak lagi memerlukan ID perantara React mount (`#react-main-nav`), melainkan langsung menjadi navigasi utama yang aktif seketika (*SSR ready*).
- Menyatukan event handler dan *scrollspy* agar bersih, modular, dan tidak terjadi duplikasi event listener.

### Langkah 4: Penghapusan File TypeScript & Komponen React
Menghapus file dan folder yang sudah tidak lagi dipakai:
- Hapus folder `resources/js/components/ui/` (`expandable-tabs.tsx`, `main-navigation-tabs.tsx`, `demo.tsx`).
- Hapus folder `resources/js/lib/` (`utils.ts`).
- Hapus salinan komponen di root `components/ui/` (jika ada).
- Hapus `components.json`.

### Langkah 5: Penyesuaian Build Tooling (`vite.config.js` & `package.json`)
- Hapus plugin `@vitejs/plugin-react` dari `vite.config.js`.
- Hapus dependensi React dari `package.json`:
  - `react`, `react-dom`, `@types/react`, `@types/react-dom`
  - `framer-motion`
  - `usehooks-ts`
  - `clsx`, `tailwind-merge` (jika tidak dipakai di modul lain)
- Menjalankan `npm run build` untuk memverifikasi proses build Vite berhasil tanpa error dan menghasilkan bundle yang jauh lebih ringan.

---

## 5. Rencana Pengujian & Verifikasi (Quality Assurance)

Setelah perubahan diaplikasikan, verifikasi berikut akan dilakukan:
1. **Verifikasi Build**:
   Menjalankan `npm run build` untuk memastikan tidak ada file yang hilang, syntax error, atau referensi modul yang rusak.
2. **Verifikasi Tampilan Awal**:
   Bilah navigasi tampil seketika saat halaman dibuka, tanpa kedipan (*no flickering / no delay*).
3. **Verifikasi Efek Hover**:
   Ketika kursor diarahkan ke tab (misal: "Beranda", "Jenjang", "Cabang", "Berita", "PPDB"), tab harus melebar secara mulus dan menampilkan teks judulnya.
4. **Verifikasi Klik & Smooth Scroll**:
   Mengklik tab "Jenjang" atau "Cabang" harus memicu scroll halus ke section tujuan dengan offset navbar yang pas (tidak tertutup header).
5. **Verifikasi Scrollspy**:
   Melakukan scrolling halaman ke bawah secara manual harus otomatis memindahkan status aktif tab (misal dari "Beranda" -> "Jenjang" -> "Cabang" -> "Berita").
6. **Verifikasi Responsivitas & Tema**:
   Memeriksa bahwa pergantian tema gelap/terang dan tampilan di layar mobile tetap bekerja sempurna.

---

## 6. Rencana Cadangan (*Rollback Plan*)

Jika di kemudian hari diperlukan pengembalian ke React:
- Seluruh kode lama tersimpan dalam riwayat Git (`git diff` / commit log).
- Cukup kembalikan file `app.js`, `main-navigation-tabs.tsx`, dan `vite.config.js` dari riwayat commit Git.
