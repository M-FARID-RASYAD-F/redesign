# 🎨 REDESIGN PLAN — Website SMKN 1 Nusantara
> **Pendekatan: 100% CSS statis via `public/css/style.css` + Vanilla JS — tanpa Tailwind/Vite.**
> Animasi sudah digabung langsung di setiap section.

---

## 📋 RINGKASAN CAKUPAN REDESIGN

| No | Komponen | Prioritas | Animasi | File Diubah |
|----|----------|-----------|---------|-------------|
| 1  | **Navbar** | 🔴 UTAMA | Shimmer CTA, slide-down mobile | `navbar.blade.php` + `style.css` |
| 2  | **Hero Section** | 🔴 UTAMA | FadeInUp stagger, float orbs | `welcome.blade.php` + `style.css` |
| 3  | **Stats Counter** | 🟡 SEDANG | Hover lift + glow, scroll reveal | `style.css` |
| 4  | **Sambutan Kepsek** | 🟡 SEDANG | Scroll reveal fadeInUp | `style.css` |
| 5  | **Kartu Jurusan** | 🟡 SEDANG | Hover gradient border, scroll reveal | `welcome.blade.php` + `style.css` |
| 6  | **Fasilitas Grid** | 🟢 MINOR | Hover scale + lift | `welcome.blade.php` + `style.css` |
| 7  | **Berita** | 🟢 MINOR | Arrow slide hover, scroll reveal | `style.css` |
| 8  | **Form Kontak** | 🟢 MINOR | Focus glow, submit button hover | `style.css` |
| 9  | **Footer** | 🟡 SEDANG | Link indent hover | `footer.blade.php` + `style.css` |
| 10 | **Responsive Mobile** | 🔴 UTAMA | – | `style.css` |

---

## 🔤 TIPOGRAFI — Dual Font System

### Sistem Dua Font (sudah diimplementasikan ✅)

| Peran | Font | Digunakan Untuk |
|-------|------|-----------------|
| **Display / Judul** | `Playfair Display` | Hero title, Section titles (h2), Card titles, Nama Kepsek |
| **Body / UI** | `Plus Jakarta Sans` | Semua teks paragraph, nav links, tombol, badge, form |

### Elemen yang Memakai Playfair Display
- `.hero-title` — Judul utama hero (`SMKN 1 NUSANTARA`)
- `.section-title` — Semua judul section (`Pilih Masa Depanmu...`, `Fasilitas Modern...`, dst)
- `.card-title` — Judul kartu program & berita
- `.principal-name` — Nama Kepala Sekolah

### Alasan Pemilihan Font
Playfair Display adalah serif klasik yang sering digunakan institusi pendidikan dan brand premium.
Kombinasinya dengan Plus Jakarta Sans (sans-serif modern) menciptakan kontras yang elegan:
**serif untuk prestige & authority** · **sans-serif untuk keterbacaan UI modern**

### CSS Variable
```css
:root {
  --font-family: 'Plus Jakarta Sans', 'Inter', system-ui, sans-serif;   /* body */
  --font-display: 'Playfair Display', Georgia, serif;                   /* judul besar */
}
```

---

## 🔴 1. NAVBAR — Redesign Total

### Kondisi Saat Ini
- Background `rgba(15,23,42,0.95)` + blur 10px — cukup baik tapi kurang premium
- Link PPDB/Cek Status memakai inline `style=""` warna hardcoded
- **Tidak ada hamburger menu** — di mobile navigasi hilang total (`display:none`)
- Tidak ada visual hierarchy antara nav link biasa vs aksi penting

### A. Glassmorphism Lebih Kuat
```css
/* SEKARANG */
.navbar {
  background: rgba(15, 23, 42, 0.95);
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

/* MENJADI */
.navbar {
  background: rgba(15, 23, 42, 0.78);
  backdrop-filter: blur(20px) saturate(180%);
  border-bottom: 1px solid rgba(255,255,255,0.08);
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 8px 32px rgba(0,0,0,0.06);
  transition: box-shadow 0.3s ease;   /* smooth intensify saat scroll */
}
/* Navbar makin gelap saat di-scroll — via JS */
.navbar.scrolled {
  box-shadow: 0 2px 8px rgba(0,0,0,0.2), 0 8px 32px rgba(0,0,0,0.14);
}
```

### B. Nav Link — Hover Area Pill
```css
/* SEKARANG */
.nav-link { color: #cbd5e1; }
.nav-link:hover { color: #ffffff; }

/* MENJADI */
.nav-link {
  color: #cbd5e1;
  padding: 7px 14px;
  border-radius: 8px;
  transition: background 0.2s ease, color 0.2s ease;
}
.nav-link:hover {
  color: #ffffff;
  background: rgba(255,255,255,0.09);
}
```

### C. CTA PPDB — Emerald Gradient + Shimmer Animation ✨
```css
.nav-cta-ppdb {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%);
  color: #ffffff !important;
  padding: 10px 22px;
  border-radius: 50px;
  font-weight: 700;
  font-size: 0.875rem;
  box-shadow: 0 4px 16px rgba(16, 185, 129, 0.35);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  position: relative;
  overflow: hidden;
}
.nav-cta-ppdb:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 28px rgba(16, 185, 129, 0.50);
  color: #ffffff !important;
}
/* ✨ Shimmer sweep saat hover */
.nav-cta-ppdb::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg,
    transparent 40%,
    rgba(255,255,255,0.28) 50%,
    transparent 60%
  );
  transform: translateX(-100%);
  transition: transform 0.55s ease;
}
.nav-cta-ppdb:hover::after {
  transform: translateX(200%);
}
```

### D. Hamburger Menu + Mobile Panel ✨
```css
/* Tombol hamburger — tampil hanya di mobile */
.nav-hamburger {
  display: none;
  width: 40px; height: 40px;
  align-items: center; justify-content: center;
  border: none;
  background: rgba(255,255,255,0.06);
  border-radius: 8px;
  cursor: pointer;
  color: #cbd5e1;
  transition: background 0.2s ease, color 0.2s ease;
}
.nav-hamburger:hover { background: rgba(255,255,255,0.12); color: #fff; }

/* Mobile dropdown panel — slide down animation */
.nav-mobile-panel {
  display: none;
  border-top: 1px solid rgba(255,255,255,0.08);
  background: rgba(15, 23, 42, 0.97);
  backdrop-filter: blur(20px);
  padding: 12px 16px 20px;
}
.nav-mobile-panel.is-open {
  display: block;
  animation: slideDown 0.22s ease-out;   /* ✨ slide-down animasi */
}

/* Mobile links */
.nav-mobile-link {
  display: flex;
  align-items: center;
  gap: 12px;
  color: #cbd5e1;
  padding: 12px 16px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 0.9rem;
  transition: background 0.2s, color 0.2s;
}
.nav-mobile-link:hover { background: rgba(255,255,255,0.08); color: #fff; }

/* Mobile CTA full-width */
.nav-mobile-cta {
  display: block;
  width: 100%;
  text-align: center;
  margin-top: 8px;
  background: linear-gradient(135deg, #10b981, #14b8a6);
  color: white !important;
  padding: 13px;
  border-radius: 12px;
  font-weight: 700;
  box-shadow: 0 4px 16px rgba(16,185,129,0.3);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.nav-mobile-cta:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(16,185,129,0.4);
  color: white !important;
}
```

### E. Auth Badge Redesign
```css
/* SEKARANG — inline style berantakan */
/* MENJADI */
.nav-auth-pill {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.10);
  border-radius: 50px;
  padding: 5px 14px 5px 6px;
  font-size: 0.82rem;
}
.nav-auth-avatar {
  width: 28px; height: 28px;
  border-radius: 50%;
  background: linear-gradient(135deg, #6366f1, #8b5cf6);
  color: white;
  display: flex; align-items: center; justify-content: center;
  font-weight: 700; font-size: 0.75rem;
}
.nav-admin-link {
  background: rgba(245,158,11,0.12);
  color: #f59e0b;
  padding: 4px 12px;
  border-radius: 50px;
  font-size: 0.8rem;
  font-weight: 700;
  transition: background 0.2s ease;
}
.nav-admin-link:hover { background: rgba(245,158,11,0.22); color: #f59e0b; }
.nav-logout-link {
  color: #f87171;
  font-size: 0.8rem;
  font-weight: 600;
  transition: color 0.2s ease;
}
.nav-logout-link:hover { color: #fca5a5; }
```

### F. Perubahan `navbar.blade.php`
- Ganti `<ul class="nav-links"><li>` → `<nav>` + `<a>` langsung
- Hapus semua inline `style=""` → ganti class baru
- "PPDB Online" → class `.nav-cta-ppdb`
- Tambah `<button class="nav-hamburger" id="navToggle">` dengan SVG ☰/✕
- Tambah `<div class="nav-mobile-panel" id="navMobilePanel">`
- Tambah `<script>` 30 baris vanilla JS (lihat Section Animasi JS di bawah)
- ✅ `route()`, `@guest`, `@auth` **100% tidak berubah**

---

## 🔴 2. HERO SECTION — Redesign Besar

### Kondisi Saat Ini
- Gradient datar: `linear-gradient(135deg, #0f172a, #1e293b)`
- Satu glow biru kecil di kanan hampir tidak terlihat
- Konten muncul tiba-tiba tanpa animasi
- Badge akreditasi memakai inline `style=""` panjang

### A. Background Multi-Layer + Floating Orbs ✨
```css
/* SEKARANG */
.hero { background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }

/* MENJADI */
.hero {
  background:
    radial-gradient(ellipse at 15% 85%, rgba(16,185,129,0.10) 0%, transparent 45%),
    radial-gradient(ellipse at 85% 15%, rgba(59,130,246,0.14) 0%, transparent 45%),
    linear-gradient(135deg, #0f172a 0%, #111827 50%, #1e293b 100%);
}

/* Floating orb ungu di kanan atas — bergerak melayang terus */
.hero::before {
  content: '';
  position: absolute;
  top: 8%; right: 6%;
  width: 320px; height: 320px;
  background: radial-gradient(circle, rgba(99,102,241,0.13) 0%, transparent 70%);
  border-radius: 50%;
  animation: float 9s ease-in-out infinite;   /* ✨ mengambang */
  pointer-events: none;
}

/* Orb hijau di bawah kiri — arah kebalikan */
.hero::after {
  content: '';
  position: absolute;
  bottom: 8%; left: 3%;
  width: 220px; height: 220px;
  background: radial-gradient(circle, rgba(16,185,129,0.10) 0%, transparent 70%);
  border-radius: 50%;
  animation: float 12s ease-in-out infinite reverse;   /* ✨ terbalik */
  pointer-events: none;
}
```

### B. FadeInUp Stagger — Konten Muncul Berurutan ✨
```css
/* Elemen hero muncul satu per satu saat halaman dibuka */
.hero-badge    { animation: fadeInUp 0.55s ease-out 0.10s both; }
.hero-title    { animation: fadeInUp 0.55s ease-out 0.20s both; }
.hero-subtitle { animation: fadeInUp 0.55s ease-out 0.30s both; }
.hero-desc     { animation: fadeInUp 0.55s ease-out 0.40s both; }
.hero-actions  { animation: fadeInUp 0.55s ease-out 0.50s both; }
.hero-card     { animation: fadeInUp 0.65s ease-out 0.35s both; }
```

### C. Badge Akreditasi — Hapus Inline Style
```css
/* BARU — class .hero-badge */
.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(59, 130, 246, 0.15);
  color: #93c5fd;
  border: 1px solid rgba(147, 197, 253, 0.20);
  padding: 6px 18px;
  border-radius: 50px;
  font-size: 0.8rem;
  font-weight: 600;
  letter-spacing: 0.02em;
  margin-bottom: 1.5rem;
}
```

### D. Hero Card — Lebih Premium
```css
/* SEKARANG */
.hero-card {
  background: rgba(255,255,255,0.05);
  backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.1);
  box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
}

/* MENJADI */
.hero-card {
  background: rgba(255,255,255,0.06);
  backdrop-filter: blur(16px) saturate(150%);
  border: 1px solid rgba(255,255,255,0.12);
  box-shadow:
    0 0 0 1px rgba(59,130,246,0.08),
    0 25px 50px -12px rgba(0,0,0,0.45),
    inset 0 1px 0 rgba(255,255,255,0.08);
  transition: transform 0.35s ease, box-shadow 0.35s ease;
}
.hero-card:hover {
  transform: translateY(-4px);
  box-shadow:
    0 0 0 1px rgba(59,130,246,0.15),
    0 32px 60px -12px rgba(0,0,0,0.5),
    inset 0 1px 0 rgba(255,255,255,0.12);
}
```

### E. Tombol Hero — Gradient + Hover Lift
```css
/* MENJADI */
.btn-primary {
  background: linear-gradient(135deg, #2563eb, #1d4ed8);
  color: white;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.40);
  transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
}
.btn-primary:hover {
  background: linear-gradient(135deg, #1d4ed8, #1e40af);
  box-shadow: 0 8px 28px rgba(37, 99, 235, 0.55);
  transform: translateY(-2px);
  color: white;
}

/* Perubahan welcome.blade.php: badge inline → class .hero-badge */
```

---

## 🟡 3. STATS COUNTER BAR — Enhancement + Scroll Reveal

### Yang Akan Diubah
```css
/* Card lebih premium */
.stat-card {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
  border: 1px solid rgba(0,0,0,0.06);
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
}
.stat-card:hover {
  transform: translateY(-7px);
  box-shadow: 0 16px 40px -8px rgba(37,99,235,0.15);
  border-color: rgba(37,99,235,0.12);
}

/* Icon wrapper lebih bulat */
.stat-icon-wrapper {
  border-radius: 14px;
  box-shadow: inset 0 1px 0 rgba(255,255,255,0.8);
}

/* Nilai statistik gradient text */
.stat-value {
  font-size: 2rem;
  background: linear-gradient(135deg, #1e293b, #334155);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
```

```blade
{{-- welcome.blade.php: tambah class reveal untuk scroll animation --}}
<div class="stats-section reveal">
  ...
</div>
```

### ✨ Animasi: Scroll Reveal
Stats counter akan muncul dengan `fadeInUp` saat pertama kali terlihat di layar — dikendalikan oleh `IntersectionObserver` di JavaScript.

---

## 🟡 4. SAMBUTAN KEPALA SEKOLAH — Enhancement + Scroll Reveal

### Yang Akan Diubah
```css
.principal-card {
  background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
  border: 1px solid rgba(0,0,0,0.06);
  border-left: 4px solid var(--primary);   /* ← Accent bar kiri */
  box-shadow: 0 4px 24px rgba(37,99,235,0.06), 0 1px 3px rgba(0,0,0,0.06);
}

/* Avatar ring biru halus */
.principal-avatar {
  box-shadow:
    0 8px 16px rgba(0,0,0,0.12),
    0 0 0 4px rgba(37,99,235,0.12);
}

/* Quote serif elegan */
.quote-icon {
  font-family: Georgia, 'Times New Roman', serif;
  font-size: 3.5rem;
  color: var(--primary);
  opacity: 0.18;
  line-height: 1;
  display: block;
  margin-bottom: -8px;
}

/* Teks italic lebih terbaca */
.principal-text {
  font-style: italic;
  font-size: 1.05rem;
  line-height: 1.85;
  color: #334155;
}
```

### ✨ Animasi: Scroll Reveal + Hover Avatar
```css
/* Avatar scale saat kartu di-hover */
.principal-card:hover .principal-avatar {
  transform: scale(1.05);
  transition: transform 0.3s ease;
}
```
Tambah class `.reveal` di `welcome.blade.php` pada `<section id="sambutan">`.

---

## 🟡 5. KARTU JURUSAN — Redesign + Hover + Scroll Reveal

### A. CSS Card Enhancement
```css
/* Hover dengan gradient border glow */
.custom-card {
  transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
}
.custom-card:hover {
  transform: translateY(-7px);
  border-color: transparent;
  box-shadow:
    0 0 0 1.5px rgba(37,99,235,0.28),
    0 20px 40px -8px rgba(37,99,235,0.13);
}

/* Box prospek karir — hapus dashed border */
.card-prospek {
  background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
  padding: 14px 18px;
  border-radius: 10px;
  border: 1px solid rgba(37,99,235,0.08);
  font-size: 0.85rem;
  margin-top: auto;
}
.card-prospek strong { color: #1e293b; }
.card-prospek span   { color: #1d4ed8; font-weight: 600; }
```

### B. Bersihkan `welcome.blade.php`
```blade
{{-- SEKARANG --}}
<div style="background: #f8fafc; padding: 12px 16px; border-radius: 8px; border: 1px dashed #cbd5e1; font-size: 0.85rem;">
  <strong style="color: var(--text-main);">💼 Prospek Karir Lulusan:</strong><br>
  <span style="color: var(--primary-hover); font-weight: 600;">{{ $j['prospek'] }}</span>
</div>

{{-- MENJADI --}}
<div class="card-prospek">
  <strong>💼 Prospek Karir Lulusan:</strong><br>
  <span>{{ $j['prospek'] }}</span>
</div>
```

### ✨ Animasi: Staggered Scroll Reveal
```css
/* Setiap card muncul dengan delay berbeda */
.grid-2 .custom-card:nth-child(1) { transition-delay: 0.05s; }
.grid-2 .custom-card:nth-child(2) { transition-delay: 0.15s; }
.grid-2 .custom-card:nth-child(3) { transition-delay: 0.25s; }
.grid-2 .custom-card:nth-child(4) { transition-delay: 0.35s; }
```
Tambah class `.reveal` pada `<div class="grid-2">`.

---

## 🟢 6. FASILITAS GRID — Enhancement + Hover Scale

### A. CSS Baru
```css
.facility-card {
  padding: 1.75rem;
  background: #ffffff;
  border-radius: 16px;
  border: 1px solid rgba(0,0,0,0.06);
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  transition: transform 0.28s ease, box-shadow 0.28s ease;
}
/* ✨ Hover: angkat + scale */
.facility-card:hover {
  transform: translateY(-6px) scale(1.02);
  box-shadow: 0 18px 40px rgba(0,0,0,0.10);
}

/* Icon wrapper gradient */
.facility-icon {
  width: 58px; height: 58px;
  background: linear-gradient(135deg, #eff6ff, #f0fdf4);
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.6rem;
  margin-bottom: 1rem;
  box-shadow: 0 2px 8px rgba(37,99,235,0.10);
  transition: transform 0.3s ease;
}
.facility-card:hover .facility-icon {
  transform: scale(1.10) rotate(-3deg);   /* ✨ icon goyang saat hover */
}

.facility-title {
  font-size: 1.05rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
  color: var(--text-main);
}
.facility-desc {
  font-size: 0.875rem;
  color: var(--text-muted);
  line-height: 1.6;
}
```

### B. Bersihkan `welcome.blade.php`
```blade
{{-- MENJADI --}}
<div class="facility-card reveal">
  <div class="facility-icon">{{ $f['icon'] }}</div>
  <h3 class="facility-title">{{ $f['nama'] }}</h3>
  <p class="facility-desc">{{ $f['deskripsi'] }}</p>
</div>
```

---

## 🟢 7. BERITA & PENGUMUMAN — Enhancement + Arrow Hover

### Yang Akan Diubah
```css
/* ✨ "Baca Selengkapnya →" — arrow geser kanan saat hover */
.card-read-more {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-weight: 700;
  font-size: 0.85rem;
  color: var(--primary);
  transition: gap 0.22s ease, color 0.22s ease;
}
.card-read-more:hover {
  gap: 10px;    /* arrow bergeser ke kanan */
  color: var(--primary-hover);
}

/* Badge warna per kategori */
.badge-prestasi { background: #dcfce7; color: #166534; }
.badge-akademik { background: #dbeafe; color: #1e40af; }
.badge-kegiatan { background: #fef9c3; color: #854d0e; }
.badge-umum     { background: #f3f4f6; color: #374151; }

/* Berita grid scroll reveal dengan stagger */
.grid-3 .custom-card:nth-child(1) { transition-delay: 0.05s; }
.grid-3 .custom-card:nth-child(2) { transition-delay: 0.15s; }
.grid-3 .custom-card:nth-child(3) { transition-delay: 0.25s; }
```

---

## 🟢 8. FORM KONTAK — Enhancement

### Yang Akan Diubah
```css
/* Focus ring lebih premium */
.form-control:focus {
  outline: none;
  border-color: var(--primary);
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
}

/* ✨ Submit button — emerald gradient (match CTA navbar) */
.btn-submit-ppdb {
  width: 100%;
  padding: 14px;
  background: linear-gradient(135deg, #10b981, #14b8a6);
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  box-shadow: 0 4px 16px rgba(16,185,129,0.35);
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  position: relative;
  overflow: hidden;
}
.btn-submit-ppdb:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 28px rgba(16,185,129,0.45);
}
/* ✨ Shimmer di submit button juga */
.btn-submit-ppdb::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.25) 50%, transparent 60%);
  transform: translateX(-100%);
  transition: transform 0.55s ease;
}
.btn-submit-ppdb:hover::after { transform: translateX(200%); }

/* Contact container — top accent line */
.contact-container {
  border-top: 3px solid linear-gradient(90deg, var(--primary), #10b981);
  /* atau pakai pseudo element: */
}
.contact-container::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--primary), #10b981);
  border-radius: 24px 24px 0 0;
}
```

---

## 🟡 9. FOOTER — Enhancement

### Yang Akan Diubah
```css
/* Background lebih dalam */
.footer {
  background: linear-gradient(180deg, #0f172a 0%, #080f1a 100%);
  border-top: 1px solid rgba(255,255,255,0.06);
}

/* Gradient line di footer bottom */
.footer-bottom {
  position: relative;
  padding-top: 2rem;
  border-top: none;
}
.footer-bottom::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0; height: 1px;
  background: linear-gradient(90deg,
    transparent,
    rgba(255,255,255,0.14),
    transparent
  );
}

/* ✨ Link hover — indent ke kanan */
.footer-links a {
  transition: color 0.2s ease, padding-left 0.2s ease;
  display: inline-block;
}
.footer-links a:hover {
  color: #ffffff;
  padding-left: 6px;
}

/* Footer brand */
.footer-brand-name    { font-size: 1.1rem; font-weight: 800; color: #ffffff; }
.footer-brand-tagline { font-size: 0.8rem; color: #475569; margin-bottom: 1.25rem; }
```

---

## 🎬 KEYFRAMES & JAVASCRIPT — Animasi Global

### CSS `@keyframes` (ditambahkan ke `style.css`)

```css
/* ── Opening: Elemen muncul dari bawah ── */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0);    }
}

/* ── Orb: melayang naik-turun terus ── */
@keyframes float {
  0%, 100% { transform: translateY(0px)   scale(1);    }
  50%       { transform: translateY(-18px) scale(1.04); }
}

/* ── CTA: cahaya menyapu (shimmer) ── */
@keyframes shimmer {
  from { transform: translateX(-100%); }
  to   { transform: translateX(200%);  }
}

/* ── Mobile menu: slide turun ── */
@keyframes slideDown {
  from { opacity: 0; transform: translateY(-10px); }
  to   { opacity: 1; transform: translateY(0);     }
}

/* ── Scroll Reveal: class ditambah JS ── */
.reveal {
  opacity: 0;
  transform: translateY(24px);
  transition: opacity 0.55s ease, transform 0.55s ease;
}
.reveal.visible {
  opacity: 1;
  transform: translateY(0);
}
```

### JavaScript Vanilla — ditaruh di `@push('scripts')` dalam `welcome.blade.php`

```javascript
document.addEventListener('DOMContentLoaded', function () {

  // ── 1. SCROLL REVEAL ──
  // Tiap elemen dengan class .reveal akan muncul fadeInUp
  // ketika 15% area elemen terlihat di layar
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(el => {
      if (el.isIntersecting) {
        el.target.classList.add('visible');
        observer.unobserve(el.target);
      }
    });
  }, { threshold: 0.15 });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  // ── 2. NAVBAR SCROLL SHADOW ──
  // Shadow navbar makin kuat saat di-scroll 60px ke bawah
  const nav = document.getElementById('mainNavbar');
  window.addEventListener('scroll', () => {
    nav?.classList.toggle('scrolled', window.scrollY > 60);
  }, { passive: true });

  // ── 3. HAMBURGER TOGGLE ──
  const toggleBtn = document.getElementById('navToggle');
  const mobilePanel = document.getElementById('navMobilePanel');
  const iconOpen = document.getElementById('iconHamburger');
  const iconClose = document.getElementById('iconClose');

  toggleBtn?.addEventListener('click', function () {
    const isOpen = mobilePanel.classList.toggle('is-open');
    this.setAttribute('aria-expanded', isOpen);
    iconOpen.style.display  = isOpen ? 'none'  : 'block';
    iconClose.style.display = isOpen ? 'block' : 'none';
  });

  // Tutup mobile menu saat klik link
  document.querySelectorAll('.nav-mobile-link, .nav-mobile-cta').forEach(link => {
    link.addEventListener('click', () => {
      mobilePanel?.classList.remove('is-open');
      if (iconOpen && iconClose) {
        iconOpen.style.display  = 'block';
        iconClose.style.display = 'none';
      }
    });
  });

});
```

---

## 📱 RESPONSIVE BREAKPOINTS — Redesign Total

### Kondisi Saat Ini
Hanya `@media (max-width: 900px)` yang menyembunyikan nav secara total.

### Breakpoint Baru — 3 Level

```css
/* ════════════════════════════════ */
/*  Tablet Landscape  — ≤ 1024px   */
/* ════════════════════════════════ */
@media (max-width: 1024px) {
  .nav-desktop-links { display: none; }
  .nav-auth-desktop  { display: none; }
  .nav-hamburger     { display: flex; }
}

/* ════════════════════════════════ */
/*  Tablet Portrait  — ≤ 768px     */
/* ════════════════════════════════ */
@media (max-width: 768px) {
  .hero-container    { grid-template-columns: 1fr; gap: 2rem; }
  .hero-title        { font-size: 2.2rem; }
  .principal-card    { grid-template-columns: 1fr; text-align: center; }
  .contact-container { grid-template-columns: 1fr; padding: 2rem 1.5rem; }
  .footer-container  { grid-template-columns: 1fr; gap: 2rem; }
  .stats-grid        { grid-template-columns: repeat(2, 1fr); }
  .grid-3            { grid-template-columns: repeat(2, 1fr); }
}

/* ════════════════════════════════ */
/*  Small Phone  — ≤ 480px         */
/* ════════════════════════════════ */
@media (max-width: 480px) {
  .hero              { padding: 3.5rem 1rem 4rem; }
  .hero-title        { font-size: 1.75rem; }
  .hero-subtitle     { font-size: 1rem; }
  .hero-actions      { flex-direction: column; gap: 0.75rem; }
  .hero-actions .btn { width: 100%; justify-content: center; }
  .stats-grid        { grid-template-columns: 1fr; }
  .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
  .section-title     { font-size: 1.5rem; }
  .navbar-container  { padding: 0 1rem; }
  .contact-container { padding: 1.5rem 1rem; gap: 2rem; }
}
```

---

## 📂 SUMMARY — FILE YANG DIUBAH

| File | Perubahan |
|------|-----------|
| `public/css/style.css` | +~400 baris: animasi, komponen baru, responsive |
| `resources/views/partials/navbar.blade.php` | Redesign total HTML + `<script>` toggle |
| `resources/views/welcome.blade.php` | Bersihkan inline style, tambah class `.reveal` & JS |
| `resources/views/partials/footer.blade.php` | Minor: tambah brand classes |

## ⛔ TIDAK DIUBAH

`app.blade.php` · `SchoolController.php` · `routes/web.php` · `package.json` · halaman PPDB · Blade components

---

## 🚀 URUTAN EKSEKUSI

```
1. style.css      → CSS tokens, @keyframes, utility classes baru
2. style.css      → Navbar, Hero, Stats, Sambutan
3. style.css      → Jurusan, Fasilitas, Berita, Form, Footer
4. style.css      → Responsive breakpoints
5. navbar.blade.php → HTML redesign + JS toggle
6. welcome.blade.php → Bersihkan inline style + class .reveal + JS scroll
7. footer.blade.php → Minor update
```
