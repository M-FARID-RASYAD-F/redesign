# GIT WORKFLOW & REPOSITORY RULES (SOP TIM)

Anda adalah asisten pengembang yang wajib mematuhi seluruh Standard Operating Procedure (SOP) Git berikut secara ketat.

---

## 1. Tiga Aturan Emas (Golden Rules)
1. **Dilarang keras melakukan push langsung ke branch `main` dalam kondisi apa pun.** Semua perubahan kode wajib masuk melalui branch fitur masing-masing, kemudian diajukan lewat Pull Request (PR).
2. **Pull sebelum mulai, push sebelum selesai:**
   - Wajib melakukan `git pull` versi terbaru dari `main` sebelum mulai menulis kode.
   - Wajib melakukan `git push` pekerjaan ke remote sebelum sesi kerja berakhir; jangan menyimpan tumpukan perubahan besar hanya di penyimpanan lokal laptop.
3. **PR berukuran kecil dan terfokus:** Satu PR hanya menangani satu topik pekerjaan yang spesifik. Dilarang menumpuk banyak perubahan yang tidak berhubungan dalam satu PR raksasa.

---

## 2. Konvensi Penamaan Branch
Format: `<tipe>/<nama-fitur-atau-bug>`.
- Gunakan seluruhnya **huruf kecil (lowercase)** dan pemisah tanda hubung/strip (`-`), tanpa spasi.
- **Daftar awalan branch yang valid:**
  - `feature/<nama-fitur>`: Penambahan fungsionalitas/fitur baru (contoh: `feature/katalog-buku`, `feature/peminjaman-buku`).
  - `fix/<nama-bug>`: Perbaikan bug pada fitur yang sudah ada (contoh: `fix/validasiform-pinjam`, `fix/salah-hitung-stok`).
  - `checkpoint/<nama-titik>`: Penanda titik aman lokal sebelum eksperimen atau perombakan kode skala besar (contoh: `checkpoint/sebelum-migrasi-role-baru`).

---

## 3. Konvensi Pesan Commit (Conventional Commits)
Format: `<tipe>: <deskripsi singkat>`.
- Gunakan huruf kecil, deskripsi singkat, bahasa konsisten (Indonesia atau Inggris), dan jelaskan perubahan teknis secara objektif.
- **Daftar tipe commit:**
  - `feat:` Menambahkan fitur atau kemampuan baru (contoh: `feat: tambah form pengajuan pinjam buku`).
  - `fix:` Memperbaiki bug atau kesalahan kode (contoh: `fix: stok buku tidak berkurang setelah dipinjam`).
  - `refactor:` Merapikan atau merestrukturisasi kode tanpa mengubah fungsionalitas (contoh: `refactor: pindahkan validasi ke Form Request`).
  - `docs:` Perubahan pada dokumentasi saja (contoh: `docs: perbarui panduan instalasi di README`).
  - `test:` Menambah atau memperbaiki pengujian otomatis (contoh: `test: tambah test untuk alur pengembalian buku`).
  - `chore:` Tugas pemeliharaan, dependensi, atau konfigurasi proyek (contoh: `chore: update composer.lock`).

---

## 4. Alur Kerja Standar 9 Langkah (Standard Cycle)

### Langkah 1: Mulai dari branch `main` yang bersih dan mutakhir
Pastikan branch `main` lokal sinkron dengan upstream sebelum mulai:
```bash
git checkout main
git pull origin main