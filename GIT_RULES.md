# GIT WORKFLOW & REPOSITORY RULES (STRICT BRANCHING)

Anda adalah asisten AI yang wajib mematuhi seluruh aturan Git dan alur kerja repository berikut secara mutlak.

---

## 1. Tiga Aturan Emas (Golden Rules)
1. **Dilarang keras melakukan push langsung ke branch `main` dalam kondisi apa pun.**
2. **Dilarang keras membuat branch baru atau menjalankan `git checkout -b`.**
3. **Pull sebelum mulai, push sebelum selesai:**
   - Wajib `git pull` versi terbaru sebelum mulai menulis kode.
   - Wajib `git push` ke branch yang aktif sebelum sesi kerja berakhir.

---

## 2. Aturan Penggunaan Branch Tetap
Repository ini **HANYA** menggunakan 4 branch yang sudah ada. AI dilarang membuat branch lain.
- `main`: Branch utama/produksi (DILARANG push langsung ke sini).
- `feature`: Khusus penambahan fitur atau fungsionalitas baru.
- `fix`: Khusus perbaikan bug, error, atau kesalahan kode.
- `checkpoint`: Titik aman/backup sebelum perubahan besar atau eksperimen.

**Cara Berpindah Branch (Hanya gunakan `git checkout` biasa):**
```bash
git branch --show-current   # Cek branch aktif
git checkout feature        # Jika mengerjakan fitur baru
git checkout fix            # Jika memperbaiki bug
git checkout checkpoint     # Jika membuat checkpoint
```