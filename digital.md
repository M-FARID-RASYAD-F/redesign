\# BAGIAN 7 \- Panduan Fitur Modul Perpustakaan Digital  
Bagian ini adalah checklist fitur, bukan kode lengkap. Kode lengkap (migration, model, controller, route, sampai Blade) sudah ada di tugas-modul-perpustakaan.pdf. Bagian ini menjawab tiga pertanyaan cepat untuk tiap halaman yang akan kalian bangun: apa yang harus tampil, apa yang perlu ditambahkan ke kode, dan jadi bahan cek sendiri sebelum PR (lihat lagi Bagian 5).

Pembagian tiga modul ini mengikuti pembagian yang sudah disepakati: Modul A Katalog Buku, Modul B Peminjaman, Modul C RBAC & Laporan.

\#\# 7.1 \- Modul A: Katalog Buku

\*\*Katalog Buku (Publik) \`/perpustakaan\`\*\*  
Yang harus tampil:  
\- Daftar buku dalam bentuk kartu/grid: sampul, judul, penulis, kategori, status (Tersedia / Dipinjam Semua)  
\- Kolom pencarian judul/penulis  
\- Filter kategori (dropdown)  
\- Pagination di bagian bawah daftar

Yang perlu ditambahkan:  
\- Migration \`books\` (judul, penulis, penerbit, tahun, sinopsis, sampul, stok, \`category\_id\`) dan \`book\_categories\`  
\- Model \`Book\` dan \`BookCategory\` (relasi \`belongsTo\`/\`hasMany\`)  
\- \`BookController@index\` dengan query pencarian \+ filter kategori  
\- View \`resources/views/perpustakaan/katalog.blade.php\`

\*\*Detail Buku (Publik) \`/perpustakaan/{book}\`\*\*  
Yang harus tampil:  
\- Info lengkap buku (penulis, penerbit, tahun, sinopsis) dan jumlah stok tersedia saat ini \- otomatis nonaktif kalau stok sedang 0  
\- Tombol "Ajukan Pinjam"

Yang perlu ditambahkan:  
\- \`BookController@show\` dan view \`detail.blade.php\`

\*\*Admin \- Kelola Buku \`/admin/perpustakaan/buku\`\*\*  
Yang harus tampil:  
\- Tabel semua buku lengkap dengan stok dan kategori, tombol edit/hapus per baris  
\- Tombol "Tambah Buku"

Yang perlu ditambahkan:  
\- CRUD lengkap (create, store, edit, update, destroy) di controller admin atau Filament Resource  
\- Validasi field wajib (judul, penulis, stok tidak boleh negatif)  
\- \`BookPolicy\` supaya hanya \`admin\_perpus\` dan \`super\_admin\` yang bisa akses halaman ini

\#\# 7.2 \- Modul B: Peminjaman

\*\*Form Ajukan Pinjam (Publik) \`/perpustakaan/pinjam/{book}\`\*\*  
Yang harus tampil:  
\- Nama dan kontak peminjam, buku yang dipilih (ditampilkan readonly), tanggal pengajuan

Yang perlu ditambahkan:  
\- Migration \`loans\` (kode\_peminjaman, book\_id, nama\_peminjam, kontak, status, tanggal\_pinjam, tanggal\_kembali)  
\- \`LoanController@store\` buat kode peminjaman otomatis, polanya sama seperti nomor pendaftaran di PPDB  
\- Validasi stok harus \> 0 sebelum pengajuan diterima

\*\*Lacak Status Peminjaman (Publik) \`/perpustakaan/lacak\`\*\*  
Yang harus tampil:  
\- Input kode peminjaman, lalu status: diajukan \-\> disetujui \-\> dipinjam \-\> dikembalikan, atau ditolak

Yang perlu ditambahkan:  
\- \`LoanController@track\` \- pola yang sama dengan cek status PPDB

\*\*Admin \- Verifikasi Peminjaman \`/admin/perpustakaan/peminjaman\`\*\*  
Yang harus tampil:  
\- Daftar pengajuan, terutama yang berstatus "diajukan", dengan tombol Setujui/Tolak  
\- Tombol "Tandai Dikembalikan" untuk peminjaman yang sedang berjalan

Yang perlu ditambahkan:  
\- \`LoanController@approve\`, \`@reject\`, \`@markReturned\`  
\- Logika stok otomatis: berkurang saat disetujui, bertambah lagi saat ditandai dikembalikan  
\- \`LoanPolicy\` untuk membatasi akses halaman ini

\*CATATAN \- Kenapa ini domain yang pas untuk latihan:\*  
Alur status berjenjang di sini sengaja meniru pola PPDB yang sudah kalian kuasai. Kalau bagian ini terasa familiar, itu tandanya kalian benar-benar paham polanya \- bukan cuma hafal kodenya.

\#\# 7.3 \- Modul C: RBAC & Laporan

\*\*Peran Baru: \`admin\_perpus\`\*\* (perubahan sistem, bukan halaman baru)  
Yang perlu ditambahkan:  
\- Tambahkan \`admin\_perpus\` ke daftar role yang valid di kolom role tabel \`users\`  
\- Perbarui middleware \`CheckRole\` dan form Kelola Pengguna supaya role baru ini bisa dipilih  
\- \`BookPolicy\` & \`LoanPolicy\`: \`admin\_perpus\` boleh kelola buku dan peminjaman, tapi tidak boleh menyentuh berita, PPDB, atau data pengguna lain

\*\*Dashboard \`admin\_perpus\` \`/admin/perpustakaan\`\*\* (halaman setelah login)  
Yang harus tampil:  
\- Kartu statistik: total judul buku, total stok, buku yang sedang dipinjam, jumlah pengajuan pending

Yang perlu ditambahkan:  
\- Query hitung (count) ke masing-masing angka di atas, ditampilkan lewat komponen kartu statistik yang sama seperti dashboard role lain

\*\*Laporan & Ekspor \`/admin/perpustakaan/laporan\`\*\*  
Yang harus tampil:  
\- Tabel riwayat peminjaman dengan filter rentang tanggal  
\- Tombol "Export CSV"

Yang perlu ditambahkan:  
\- Export CSV memakai pola yang sama seperti ekspor rekap PPDB yang sudah ada  
\- \`PerpusSeeder\` berisi data contoh (kategori, buku, beberapa peminjaman), dipanggil terpisah dari \`DatabaseSeeder.php\` supaya tidak bentrok saat merge

\*CATATAN\*  
Sebelum PR untuk modul ini, cocokkan dulu ke checklist di atas untuk halaman yang kalian kerjakan, baru jalankan checklist umum di Bagian 5\. Kalau ada bagian yang belum jelas caranya, buka lagi tugas-modul-perpustakaan.pdf \- jangan menebak strukturnya sendiri, supaya ketiga modul tetap nyambung saat digabung.

\---

\# Lembar Ringkas  
Satu halaman ini merangkum semua perintah yang paling sering dipakai. Tempel di catatan kalian kalau perlu.

\*\*Mulai kerja baru\*\*  
\`\`\`bash  
git checkout main  
git pull origin main  
git checkout \-b feature/nama-fitur  
\`\`\`

\*\*Selama kerja\*\*  
\`\`\`bash  
git add \<file yang diubah\>  
git commit \-m "feat: deskripsi singkat"  
git push origin feature/nama-fitur  
\`\`\`

\*\*Setelah PR di-approve dan di-merge di Github\*\*  
\`\`\`bash  
git checkout main  
git pull origin main  
git branch \-d feature/nama-fitur  
\`\`\`

\*\*Kalau branch ketinggalan dari main\*\*  
\`\`\`bash  
git fetch origin  
git merge origin/main  
\`\`\`

\*CATATAN \- Satu prinsip untuk diingat\*  
Kalau ragu branch mana yang benar, atau ragu bagian mana yang boleh diubah \- tanya dulu ke mentor sebelum menulis kode. Pertanyaan 30 detik jauh lebih murah daripada membongkar conflict berjam-jam.

\---

\# Lampiran A \- Mekanisme Merapikan Repository  
\*(Khusus pembimbing/pemegang akses admin repo \- bukan bagian yang dikerjakan siswa)\*

PERHATIAN \- Bukan bagian dari SOP siswa  
Semua langkah di lampiran ini mengubah struktur repository secara permanen (hapus branch, pindah kepemilikan, kunci pengaturan). Hanya dikerjakan oleh pembimbing yang memegang akses admin repo, dan sebaiknya dilakukan sekali di awal sebelum Modul Perpustakaan Digital dimulai \- bukan sesuatu yang diulang-ulang.

Ini mekanisme konkret untuk membereskan kondisi \`main\` / \`experiment\` / \`mainkedua\` yang dibahas di Bagian 2, sekaligus memastikan aturan "tidak ada push langsung ke main" benar-benar ditegakkan sistem \- bukan cuma tertulis di dokumen.

\*\*LANGKAH 1 \- Backup dulu, sebelum apa pun\*\*  
Simpan salinan penuh seluruh branch dan riwayat apa adanya, sebelum menyentuh apa pun. Kalau ada langkah di bawah yang salah ambil, tinggal kembali ke sini.  
\`\`\`bash  
git clone \--mirror \[url\_repo\_lama\] redesign-backup.git  
\`\`\`

\*\*LANGKAH 2 \- Satukan branch experiment ke main\*\*  
\`experiment\` isinya justru yang paling baru (rombakan tampilan). Jangan di-merge diam-diam lewat command line \- buka sebagai Pull Request, sekalian jadi contoh nyata alur yang benar ke siswa.  
\`\`\`bash  
git checkout experiment  
git pull origin experiment  
git push origin experiment  
\`\`\`  
Lanjut di GitHub: New Pull Request \-\> base \`main\`. Merge. Baru setelah itu branch \`experiment\` boleh dihapus.

\*\*LANGKAH 3 \- Putuskan nasib branch mainkedua\*\*  
Cek dulu apa ada sesuatu di sana yang belum ada di main:  
\`\`\`bash  
git log main..mainkedua \--oneline  
\`\`\`  
Kalau memang tidak ada yang perlu diselamatkan, arsipkan lewat tag supaya sejarahnya tidak hilang total, baru hapus branch-nya:  
\`\`\`bash  
git tag archive/mainkedua mainkedua  
git push origin archive/mainkedua  
git push origin \--delete mainkedua  
git branch \-D mainkedua  
\`\`\`

\*\*LANGKAH 4 \- Kunci aturannya lewat Branch Protection\*\*  
Lakukan ini sebelum memindahkan kepemilikan repo di Langkah 5, supaya proses merge di Langkah 2-3 tidak ikut terblokir aturan baru. Buka Settings \-\> Branches \-\> Add branch protection rule, isi pola nama branch dengan \`main\`, lalu aktifkan:  
\- Require a pull request before merging  
\- Require approvals (minimal 1\)  
\- Do not allow bypassing the above settings \- termasuk untuk admin, supaya pembimbing sendiri juga lewat PR, konsisten dengan SOP yang dibagikan ke siswa  
\- Require status checks to pass before merging \- aktifkan kalau CI sudah ditambahkan

\*CATATAN \- Efeknya setelah aktif:\*  
\`git push\` langsung ke \`main\` akan otomatis ditolak GitHub untuk siapa pun yang mencoba \- bukan lagi soal disiplin masing-masing orang.

\*\*LANGKAH 5 \- Pindahkan kepemilikan repo ke akun organisasi\*\*  
Paling terakhir dilakukan, karena paling mengganggu (semua orang perlu mengganti remote lokalnya). Ada dua cara:  
1\. \*\*Transfer resmi GitHub\*\*: Repo lama: Settings \> Danger Zone \> "Transfer ownership" \> masukkan nama organisasi tujuan. Siswa pemilik yang memulai transfer, organisasi yang menerima harus accept invite. URL lama otomatis redirect. (Cocok jika: Siswa kooperatif dan akun organisasi GitHub sudah siap).  
2\. \*\*Mirror ke repo baru\*\*: Clone penuh dari repo lama, lalu push penuh ke repo kosong baru di organisasi. Semua orang ganti remote lokalnya. (Cocok jika: Ingin lebih cepat / tidak bergantung siswa, tapi histori issue dan PR lama tidak ikut pindah).

Kalau memilih cara Mirror:  
\`\`\`bash  
git clone \--mirror \[url\_repo\_lama\] redesign.git  
cd redesign.git  
git push \--mirror \[url\_repo\_baru\]  
\`\`\`  
Lalu semua orang (termasuk siswa) memperbarui remote lokalnya:  
\`\`\`bash  
git remote set-url origin \[url\_repo\_baru\]  
\`\`\`

\*\*Ringkasan Urutan:\*\*  
1\. Backup penuh (Langkah 1\)  
2\. Merge \`experiment\` ke \`main\` lewat PR (Langkah 2\)  
3\. Arsipkan dan hapus \`mainkedua\` (Langkah 3\)  
4\. Nyalakan branch protection di \`main\` (Langkah 4\)  
5\. Pindahkan kepemilikan repo (Langkah 5\) \- setelah semuanya rapi

\---

\# Lampiran B \- Setup CI Otomatis (Pint & Test)  
\*(Khusus pembimbing/pemegang akses admin repo)\*

Checklist PR di Bagian 5 (Pint, test, tidak ada kode debug) saat ini masih 100% mengandalkan mata pembimbing setiap kali review. Lampiran ini menambahkan satu workflow GitHub Actions yang menjalankan Pint dan test otomatis setiap ada Pull Request ke \`main\` \- supaya PR yang belum lolos sudah ketahuan sebelum sempat dibaca manual.

\*\*LANGKAH 1 \- Buat file workflow\*\*  
Buat folder \`.github/workflows/\` di root project, lalu file \`ci.yml\` berisi:  
\`\`\`yaml  
name: CI  
on:  
  pull\_request:  
    branches: \[main\]  
jobs:  
  test:  
    runs-on: ubuntu-latest  
    steps:  
      \- uses: actions/checkout@v4  
      \- name: Setup PHP  
        uses: shivammathur/setup-php@v2  
        with:  
          php-version: '8.3'  
      \- name: Install dependencies  
        run: composer install \--prefer-dist \--no-progress  
      \- name: Siapkan .env  
        run: cp .env.example .env && php artisan key:generate  
      \- name: Cek format kode (Pint)  
        run: ./vendor/bin/pint \--test  
      \- name: Jalankan migration (SQLite in-memory)  
        run: php artisan migrate \--force  
        env:  
          DB\_CONNECTION: sqlite  
          DB\_DATABASE: ':memory:'  
      \- name: Jalankan test  
        run: php artisan test  
        env:  
          DB\_CONNECTION: sqlite  
          DB\_DATABASE: ':memory:'  
\`\`\`

\*\*LANGKAH 2 \- Commit lewat PR, bukan push langsung\*\*  
\`\`\`bash  
git checkout \-b chore/setup-ci-pint-test  
git add .github/workflows/ci.yml  
git commit \-m "chore: tambah CI otomatis untuk Pint dan test"  
git push origin chore/setup-ci-pint-test  
\`\`\`  
Buka PR seperti biasa mengikuti alur di Bagian 3 \- workflow ini pun sekalian menguji dirinya sendiri di PR pertamanya.

\*\*LANGKAH 3 \- Kaitkan ke Branch Protection\*\*  
Setelah PR ini di-merge minimal sekali (supaya GitHub mengenali job-nya), kembali ke Settings \-\> Branches \-\> \`main\` dari Lampiran A Langkah 4, lalu aktifkan "Require status checks to pass before merging" dan pilih job \`test\`. Sejak saat itu, PR yang Pint atau test-nya gagal tidak akan bisa di-merge sama sekali, bukan cuma ditandai merah.

\*CATATAN \- Kenapa SQLite in-memory, bukan MySQL:\*  
Lebih cepat dan tidak perlu menyiapkan server database terpisah di GitHub Actions. Cukup untuk menjalankan seluruh test suite yang sudah ada tanpa mengubah konfigurasi database produksi.

\---

\# Lampiran C \- Setup Scheduler Auto-Arsip Pengumuman  
\*(Khusus pembimbing/pemegang akses admin repo)\*

PERHATIAN \- Kerjakan setelah Modul B (Pengumuman & Agenda) resmi dibangun.  
Contoh di bawah memakai model \`Announcement\` dan kolom \`end\_date\`/\`is\_archived\` yang sudah ada di migration sejak awal, tapi belum ada controller atau view yang memakainya. Jangan pasang scheduler ini duluan sebelum modulnya benar-benar berfungsi.  
Ini menutup gap FR-B05: pengumuman yang sudah lewat \`end\_date\` harus otomatis ditandai arsip, bukan dibiarkan manual.

\*\*LANGKAH 1 \- Buat Artisan Command baru\*\*  
\`\`\`bash  
php artisan make:command ArchiveExpiredAnnouncements  
\`\`\`

\*\*LANGKAH 2 \- Isi logika pengarsipan\*\*  
Edit \`app/Console/Commands/ArchiveExpiredAnnouncements.php\`:  
\`\`\`php  
\<?php

namespace App\\Console\\Commands;

use App\\Models\\Announcement;  
use Illuminate\\Console\\Command;

class ArchiveExpiredAnnouncements extends Command  
{  
    protected \$signature \= 'announcements:archive-expired';  
    protected \$description \= 'Tandai pengumuman yang sudah lewat end\_date sebagai arsip';

    public function handle(): void  
    {  
        \$count \= Announcement::where('end\_date', '\<', now())  
            \-\>where('is\_archived', false)  
            \-\>update(\['is\_archived' \=\> true\]);  
              
        \$this-\>info("(\$count) pengumuman diarsipkan otomatis.");  
    }  
}  
\`\`\`

\*\*LANGKAH 3 \- Daftarkan jadwalnya\*\*  
Laravel 11+ tidak lagi memakai \`app/Console/Kernel.php\` untuk jadwal \- cukup tambahkan ke \`routes/console.php\` yang sudah ada di project:  
\`\`\`php  
use Illuminate\\Support\\Facades\\Schedule;

Schedule::command('announcements:archive-expired')-\>daily();  
\`\`\`

\*\*LANGKAH 4 \- Pastikan server menjalankan scheduler\*\*  
Untuk uji coba lokal, jalankan langsung:  
\`\`\`bash  
php artisan announcements:archive-expired  
\`\`\`

Di server produksi, tambahkan satu baris cron ini supaya semua jadwal Laravel (termasuk yang baru ditambahkan) berjalan otomatis tiap menit:  
\`\`\`bash  
\* \* \* \* \* cd /path-ke-project && php artisan schedule:run \>\> /dev/null 2\>&1  
\`\`\`

\*CATATAN \- Kenapa lewat Artisan Command sendiri, bukan langsung ditulis di jadwal:\*  
Supaya bisa diuji manual kapan saja (\`php artisan announcements:archive-expired\`) tanpa menunggu jadwal jalan, dan polanya gampang ditiru untuk kebutuhan arsip otomatis lain nanti (misalnya peminjaman buku yang terlambat dikembalikan).