kamu adalah senior product designer. Lakukan audit UI/UX menyeluruh pada website [NAMA WEBSITE / URL] untuk versi DESKTOP dan MOBILE.

CAKUPAN PENGECEKAN:
1. Layout & Responsiveness
   - Elemen overlap, terpotong, atau keluar dari viewport
   - Breakpoint yang rusak saat resize (desktop, tablet, mobile)
   - Spacing/padding/margin tidak konsisten
   - Scroll horizontal yang tidak diinginkan

2. Tipografi
   - Font tidak terbaca (ukuran terlalu kecil/besar, kontras rendah)
   - Line-height/letter-spacing yang aneh
   - Teks terpotong (truncated) tanpa indikasi

3. Navigasi & Interaksi
   - Menu/dropdown tidak berfungsi atau tertutup elemen lain
   - Tombol/link tidak responsif saat diklik/tap
   - Hover state tidak muncul di desktop, tap state tidak muncul di mobile
   - Area klik terlalu kecil untuk mobile (touch target)

4. Gambar & Media
   - Gambar pecah, tidak termuat, atau rasio distorsi
   - Video/iframe tidak responsive
   - Lazy loading yang gagal

5. Form & Input
   - Validasi error tidak muncul jelas
   - Placeholder hilang saat fokus tanpa label pengganti
   - Keyboard mobile menutupi input field

6. Konsistensi Desain
   - Warna, ikon, atau komponen yang tidak seragam antar halaman
   - Branding tidak konsisten (logo, warna, font)

7. Kompatibilitas Browser & Device
   - Perbedaan tampilan di Chrome, Safari, Firefox, Edge
   - Perbedaan tampilan di iOS vs Android

8. Aksesibilitas Dasar
   - Kontras warna tidak memenuhi standar (WCAG)
   - Alt text gambar hilang
   - Navigasi keyboard tidak berfungsi

FORMAT LAPORAN:
Untuk setiap temuan, sertakan:
- Nama halaman/komponen
- Deskripsi masalah
- Platform terdampak (Desktop/Mobile/Keduanya)
- Screenshot atau lokasi (jika ada)
- Tingkat keparahan (gunakan kategori di bawah)
- Rekomendasi perbaikan

KATEGORI TINGKAT KEPARAHAN:
- CRITICAL: Menghalangi fungsi utama (checkout gagal, tombol login rusak, halaman blank/error, form tidak bisa submit)
- HIGH: Mengganggu pengalaman pengguna secara signifikan tapi masih ada workaround (navigasi membingungkan, elemen penting terpotong)
- MEDIUM: Masalah tampilan yang terlihat jelas tapi tidak menghalangi fungsi (spacing tidak rapi, font kurang konsisten)
- LOW: Kosmetik minor, hampir tidak berpengaruh ke fungsi (perbedaan warna sangat kecil, alignment sedikit miring)

Sajikan hasil dalam bentuk tabel terurut dari CRITICAL ke LOW.