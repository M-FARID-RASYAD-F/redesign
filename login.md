# Prompt: Integrasi Komponen React ke Project Laravel (JavaScript)

Kamu adalah asisten developer yang bertugas mengintegrasikan komponen React berikut ke dalam codebase **Laravel** milik saya. Project saya menggunakan **JavaScript murni (bukan TypeScript)**, dengan Laravel sebagai backend dan Vite sebagai bundler frontend.

## Konteks Project
- Framework: Laravel (Blade atau Inertia.js — cek dulu mana yang dipakai)
- Bundler: Vite (via `laravel-vite-plugin`)
- Bahasa: JavaScript (.jsx), TIDAK memakai TypeScript
- Styling: Tailwind CSS
- Struktur folder frontend: `resources/js/`

## Tugas
1. **Cek prasyarat** — pastikan project sudah punya:
   - `react` + `react-dom` + `@vitejs/plugin-react`
   - `tailwindcss` + `postcss` + `autoprefixer`
   - Alias `@` mengarah ke `resources/js` di `vite.config.js`
   
   Jika belum ada salah satunya, berikan instruksi instalasi lengkap sebelum lanjut.

2. **Karena shadcn CLI tidak mendukung Laravel secara native**, jangan gunakan `npx shadcn init`. Sebagai gantinya, buat struktur folder manual yang meniru konvensi shadcn:

   Jelaskan singkat kenapa folder `components/ui` penting (konsistensi konvensi shadcn, memisahkan primitive UI dari komponen halaman).

3. **Install dependency minimal yang dibutuhkan komponen ini**:
```bash
   npm install clsx tailwind-merge
```
   Buat `resources/js/lib/utils.js` berisi helper `cn()` standar shadcn (pakai `clsx` + `twMerge`).

4. **Konversi komponen dari `.tsx` ke `.jsx`** — hapus semua anotasi TypeScript (interface, type, generic) tapi pertahankan logic dan className persis sama.

5. **Analisis komponen sebelum integrasi**, dan laporkan:
   - Props apa saja yang diterima (jika tidak ada, sebutkan eksplisit)
   - State internal yang dipakai (useState/useReducer/dll)
   - Apakah butuh context provider / custom hook tambahan
   - Apakah butuh asset gambar (jika ya, sarankan Unsplash stock image yang valid) atau icon (pakai `lucide-react` jika diperlukan)
   - Perilaku responsive yang diharapkan

6. **Perbaiki mismatch export/import** jika ada (mis. named export vs default export) supaya tidak error saat build.

7. **Buat entry point mounting ke Blade**:
   - Jika project pakai Blade biasa → buat `resources/js/app.jsx` yang mount komponen ke `#react-root`, plus contoh snippet `@vite(...)` di file Blade.
   - Jika project pakai **Inertia.js** → gunakan pola `resolve` di `createInertiaApp`, bukan `createRoot` manual. Tanyakan dulu ke saya mana yang dipakai jika belum jelas dari codebase.

8. **Berikan instruksi build & run**:
```bash
   npm install
   npm run dev
```

## Komponen yang harus diintegrasikan

**`auth-switch.jsx`**
```jsx
import { cn } from "@/lib/utils";
import { useState } from "react";

export const Component = () => {
  const [count, setCount] = useState(0);
  return (
    <div className={cn("flex flex-col items-center gap-4 p-4 rounded-lg")}>
      <h1 className="text-2xl font-bold mb-2">Component Example</h1>
      <h2 className="text-xl font-semibold">{count}</h2>
      <div className="flex gap-2">
        <button onClick={() => setCount((prev) => prev - 1)}>-</button>
        <button onClick={() => setCount((prev) => prev + 1)}>+</button>
      </div>
    </div>
  );
};

export default Component;
```

**`demo.jsx`**
```jsx
import React from "react";
import AuthSwitch from "./auth-switch";

export default function Demo() {
  return <AuthSwitch />;
}
```

## Output yang diharapkan
- Daftar perintah instalasi (jika ada yang kurang)
- Isi lengkap tiap file yang perlu dibuat/diubah, dengan path lengkapnya
- Penjelasan singkat kenapa tiap perubahan diperlukan
- Peringatkan jika ada asumsi yang perlu saya konfirmasi (mis. Blade vs Inertia)