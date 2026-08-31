# Prompt: Ubah Animasi Hover Container Menjadi 3D Tilt Card

Ubah animasi hover pada container/card di website saya (Laravel + Blade, bukan React) menjadi efek **3D tilt hover** seperti spesifikasi berikut:

## Spesifikasi efek
1. **Tilt 3D mengikuti posisi mouse** — saat cursor bergerak di atas card, card memiringkan diri (rotateX & rotateY) sesuai posisi relatif cursor terhadap card, dengan efek "terangkat" (translateZ) saat hover.
2. **Efek shine/kilau** — gradient cahaya tipis yang bergerak melintasi permukaan card mengikuti sudut kemiringan, muncul hanya saat hover.
3. **Background layer terpisah** — background (gradient atau image) berada di layer paling belakang (translateZ negatif) agar terlihat efek kedalaman (depth) dibanding konten di depannya.
4. **Konten terangkat di layer depan** — icon, judul, deskripsi berada di layer depan (translateZ positif) sehingga terasa "mengambang" di atas background saat card dimiringkan.
5. **Indikator status (dot)** — titik kecil di pojok kanan atas yang berdenyut (pulse animation) saat card di-hover.
6. **Icon bereaksi saat hover** — icon sedikit naik dan berotasi kecil (misal rotate 5deg, translateY -2px).
7. **Teks "Explore"/CTA muncul saat hover** — elemen kecil (garis + teks) yang awalnya tersembunyi (opacity 0, translateX -8px) lalu muncul smooth saat hover.
8. **Transisi kembali ke posisi normal** — saat mouse leave, semua transform kembali ke default dengan transisi halus (ease-out, sekitar 0.15–0.3s).
9. **Shadow membesar saat hover** — box-shadow lebih tebal/menyebar saat card di-hover untuk menegaskan efek "terangkat".

## Batasan teknis
- **Gunakan Vanilla JavaScript murni** (tanpa React, tanpa framer-motion, tanpa library animasi eksternal) — cukup `mousemove`, `mouseenter`, `mouseleave` event listener + CSS transition/keyframes.
- **CSS murni** dengan `transform-style: preserve-3d` dan `perspective` pada container grid.
- Struktur HTML harus kompatibel untuk dijadikan **Blade component** (`resources/views/components/...blade.php`) dengan variable dinamis (title, description, icon, theme/gradient).
- Script JS harus bisa menangani **banyak card sekaligus** dalam satu halaman (pakai `querySelectorAll`, bukan hardcode satu elemen).
- Tidak boleh menggunakan library eksternal tambahan (tanpa GSAP, tanpa Framer Motion, tanpa jQuery) — hanya native JS/CSS.
- Sertakan minimal 3 varian warna/tema (gradient) yang bisa dipilih lewat class, contoh: `theme-primary`, `theme-secondary`, `theme-accent`.

## Yang harus dihasilkan
1. File CSS (bisa ditempel ke `resources/css/app.css`).
2. File JS (bisa ditempel ke `resources/js/app.js` atau file terpisah, dipanggil lewat Vite).
3. Contoh markup HTML/Blade untuk satu card yang bisa dijadikan komponen reusable (`<x-card3d ... />`).
4. Jelaskan singkat cara integrasinya ke project Laravel (di mana file ditaruh, cara load via `@vite`).

Terapkan efek ini ke container yang sudah ada di project saya, sesuaikan dengan struktur HTML container yang saya berikan, tanpa mengubah konten/isi container — hanya tambahkan lapisan animasi hover 3D di atasnya.