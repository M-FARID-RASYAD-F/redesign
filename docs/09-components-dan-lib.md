# 🧩 Folder `components/` & `lib/` — Komponen UI Modern & Utilitas (UI System)

Folder `components/` dan `lib/` menampung arsitektur komponen UI modern berbasis **React / TypeScript**, desain sistem **shadcn/ui**, serta fungsi pembantu (*utilities*) manipulasi styling Tailwind CSS.

---

## 🗂️ Struktur Subdirektori `components/` & `lib/`

```
Redesign/
├── components/              # Koleksi komponen UI React / TypeScript terisolasi
│   └── ui/                  # Komponen antarmuka atomik (shadcn/ui ecosystem)
│       └── main-navigation-tabs.tsx # Komponen navigasi tab interaktif modern
├── components.json          # Konfigurasi standar shadcn/ui untuk integrasi Tailwind
└── lib/                     # Pustaka fungsi utilitas pembantu
    └── utils.ts             # Fungsi penggabung class Tailwind (cn utility)
```

---

## 1. Folder `components/ui/`

Menampung komponen-komponen antarmuka yang ditulis menggunakan sintaks TypeScript JSX (`.tsx`):

- **`main-navigation-tabs.tsx`**:
  - Komponen tab navigasi dinamis dengan animasi transisi yang mulus.
  - Dapat dikompilasi oleh Vite dan diintegrasikan ke dalam halaman web sekolah untuk menyajikan navigasi tingkat lanjut antar-kategori informasi jenjang (SD, SMP, SMK).

> 💡 **Perbedaan Arsitektur Komponen**:
> - **`components/ui/`**: Berisi komponen frontend modern berbasis **React/TypeScript** yang mengutamakan interaktivitas tinggi di sisi klien (*client-side state*).
> - **`resources/views/components/`**: Berisi komponen berbasis **Blade PHP** (seperti `card.blade.php`, `stat-card.blade.php`) yang dirender langsung di sisi server (*server-side rendering*).

---

## 2. Folder `lib/` & Berkas `lib/utils.ts`

- Menyediakan fungsi utilitas standar industri:
  ```typescript
  import { clsx, type ClassValue } from "clsx"
  import { twMerge } from "tailwind-merge"

  export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs))
  }
  ```
- **Fungsi `cn()`**:
  - Menggabungkan beberapa nama class Tailwind CSS secara kondisional.
  - Mencegah konflik antar class (misal: jika ada class `px-2` dan ditimpa dengan `px-4`, `tailwind-merge` secara cerdas hanya akan menggunakan `px-4`).

---

## 3. Berkas Pendukung: `components.json` & `tsconfig.json`

- **`components.json`**:
  - Berkas konfigurasi CLI *shadcn/ui*. Menentukan jalur alias direktori (`@/components`, `@/lib/utils`), varian styling Tailwind, dan skema warna dasar.
- **`tsconfig.json`**:
  - Menetapkan konfigurasi compiler TypeScript, pemetaan path alias `@/*`, dan aturan pengecekan tipe data yang ketat (*strict mode*).
