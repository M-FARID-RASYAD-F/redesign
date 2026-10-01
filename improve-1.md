# 14 Konsep Laravel — Kode Sehari-hari & Standar Perusahaan

**PKBM AT-TAMAM • DIVISI MAGANG LARAVEL**
**MATERI LANJUTAN — KELOMPOK IKHWAN**

*Before / After dari Kode Proyek Redesign Kalian Sendiri*

Bagian A: 7 pola sehari-hari yang sudah dekat dengan kode kalian. Bagian B: 7 standar tingkat perusahaan yang belum ada sama sekali.

Lanjutan dari yang sudah dikuasai: Blade `@extends`/`@include` dan CSRF

Disusun oleh Mentor Magang · devbytamam@gmail.com

*Portal Sekolah PKBM At-Tamam (Laravel) — Kelompok Ikhwan redesign*

> **File ini adalah Bagian 1 dari 2.** Bagian 1 berisi Pendahuluan dan Bagian A (Topik 1–7). Bagian 2 (`improve-2.md`) berisi Bagian B (Topik 8–14) dan Ringkasan.

---

## Daftar Isi

**Bagian 1 (file ini)**

- Pendahuluan
- BAGIAN A — Pola Sehari-hari
  - Topik 1 — Eloquent Relationships (BelongsTo & HasMany)
  - Topik 2 — Eager Loading & Masalah N+1
  - Topik 3 — Route Model Binding
  - Topik 4 — Form Request Classes
  - Topik 5 — Model Events, lalu Naik Level ke Observer
  - Topik 6 — Accessor & Mutator: Menyatukan Gaya Lama & Baru
  - Topik 7 — Query Scopes

**Bagian 2 (`improve-2.md`)**

- BAGIAN B — Standar Level Perusahaan (Topik 8–14)
- Ringkasan & Urutan Belajar

---

## Pendahuluan

### Kenapa 14 topik ini, dan cara memakai dokumen ini

Kalian sudah kuasai `@extends`, `@include`, dan CSRF. Dokumen ini sekarang dibagi dua bagian besar.

1. **Bagian A — Pola Sehari-hari (Topik 1–7).** Pola yang langsung berhubungan dengan kode yang sudah kalian tulis: relasi data, query, routing, validasi. Beberapa sudah kalian pakai tanpa sadar.
2. **Bagian B — Standar Level Perusahaan (Topik 8–14).** Hal-hal yang wajib ada di aplikasi yang benar-benar dipakai orang banyak (bukan sekadar tugas kuliah), tapi belum ada sama sekali di proyek redesign saat ini: transaksi database, soft delete, logging, exception handling, queue, dan kesiapan production.

Semua contoh — di kedua bagian — diambil langsung dari file yang sudah kalian tulis sendiri, bukan contoh generik dari tutorial.

### Format Tiap Topik

1. **Apa & Kenapa** — penjelasan konsepnya, termasuk kenapa ini penting di aplikasi nyata
2. **Kode Kalian Sekarang** — kutipan asli dari file proyek, dengan nama file dan nomor baris
3. **Langkah Menerapkan** — urutan konkret, siap diikuti
4. **Kode Sesudah** — hasil akhirnya
5. **Coba Langsung** — cara memverifikasi hidup di aplikasi/terminal, bukan cuma dibaca
6. **Latihan** — satu tugas kecil untuk dicoba sendiri

> **CATATAN — Sebelum mulai**
> Jalankan di branch terpisah (lihat SOP Git & Alur Kerja Tim) — `git checkout -b latihan/konsep-laravel` — supaya bebas bereksperimen tanpa risiko merusak `main`.

---

# BAGIAN A — Pola Sehari-hari

*Tujuh pola yang langsung berhubungan dengan kode yang sudah kalian tulis*

---

## TOPIK 1 — Eloquent Relationships (BelongsTo & HasMany)

Relasi antar tabel di Eloquent bukan ditulis sebagai foreign key mentah, tapi sebagai method di model yang mengembalikan objek relasi. Dua yang paling sering dipakai: `belongsTo` (saya "milik" satu induk) dan `hasMany` (saya "punya banyak" anak).

Kenapa ini bukan sekadar gaya penulisan: begitu relasi didefinisikan sebagai method, Eloquent otomatis tahu cara menyambungkan query (join di belakang layar), cara memuat data terkait (Topik 2), dan cara memvalidasi keberadaan data (`exists:news_categories,id` di aturan validasi kalian sendiri memakai nama tabel yang sama).

### Kode Kalian Sekarang — sudah benar!

`app/Models/News.php`

```php
public function category(): BelongsTo
{
    return $this->belongsTo(NewsCategory::class, 'category_id');
}

public function author(): BelongsTo
{
    return $this->belongsTo(User::class, 'author_id');
}
```

`app/Models/User.php`

```php
public function news()
{
    return $this->hasMany(News::class, 'author_id');
}

public function announcements()
{
    return $this->hasMany(Announcement::class, 'created_by');
}
```

Ini poin pentingnya: kalian sudah menulis kode ini dengan benar. Bagian ini bukan tentang memperbaiki, tapi memberi nama konsepnya supaya kalian sadar apa yang sudah dikuasai.

> **CATATAN — Cara membaca arahnya**
> Kalau tabel `news` punya kolom `author_id` yang menunjuk ke tabel `users`, maka dari sisi `News` itu `belongsTo` (satu berita milik satu penulis). Dari sisi `User`, itu `hasMany` (satu penulis punya banyak berita). Aturannya: kolom foreign key selalu ada di sisi yang `belongsTo`.

> **COBA LANGSUNG (LIVE CHECK) — Cek relasinya lewat tinker**
> Buka `php artisan tinker`, lalu jalankan:
>
> ```
> php artisan tinker
> >>> $user = App\Models\User::first();
> >>> $user->news; // koleksi berita milik user ini
> >>> $user->news->count();
> >>> App\Models\News::first()->author->name; // arah sebaliknya
> ```

### Latihan

Modul Perpustakaan Digital butuh relasi baru: `Book belongsTo BookCategory` dan `BookCategory hasMany Book`. Tulis kedua method ini sendiri di model `Book.php` dan `BookCategory.php` sebelum melihat contoh di `tugas-modul-perpustakaan.pdf`.

---

## TOPIK 2 — Eager Loading & Masalah N+1

Kalau kalian mengambil banyak baris lalu mengakses relasinya satu per satu di loop, Eloquent diam-diam menjalankan satu query tambahan per baris. Untuk 20 berita, itu 1 query awal + 20 query relasi = 21 query. Ini yang disebut **masalah N+1**.

Di aplikasi kecil ini tidak terasa. Begitu data ratusan/ribuan baris (bayangkan Modul Perpustakaan dengan ribuan buku), N+1 bisa mengubah halaman yang harusnya 1 query jadi ribuan query — server jadi lambat bukan karena kode salah logika, tapi karena terlalu sering "bolak-balik" ke database.

### Kode Kalian Sekarang — sudah benar!

`app/Http/Controllers/Admin/CmsDashboardController.php:41`

```php
$recentNews = News::with('category')->latest()->limit(5)->get();
```

`app/Http/Controllers/AdminController.php:38`

```php
$newsList = News::with(['category', 'author'])->orderBy('created_at', 'desc')->paginate(15);
```

`with()` memberi tahu Eloquent: "ambil sekalian semua kategori/penulis yang dibutuhkan, dalam satu query tambahan" — bukan satu query per baris. Ada juga `load()` untuk memuat relasi setelah data utama sudah diambil (dipakai di Topik 3 nanti untuk Route Model Binding).

> **CATATAN — Buktikan sendiri bedanya**
> Untuk benar-benar melihat masalahnya, coba sementara hapus `with()` di satu tempat, lalu ikuti langkah "Coba Langsung" di bawah untuk menghitung query yang benar-benar dijalankan. Setelah selesai, kembalikan `with()`-nya.

> **COBA LANGSUNG (LIVE CHECK) — Hitung query sebelum vs sesudah `with()`**
> Tempel baris ini sementara di awal method `index()` yang mau diuji, lalu buka halaman itu di browser:
>
> ```php
> \Illuminate\Support\Facades\DB::enableQueryLog();
> // ... kode yang mau diuji ...
> dd(count(\Illuminate\Support\Facades\DB::getQueryLog()));
> ```
>
> Jalankan sekali DENGAN `with()` (catat jumlah query), lalu hapus `with()` dan jalankan lagi (catat lagi). Untuk 5 berita, harusnya kalian lihat selisih sekitar 5 query lebih banyak tanpa `with()`.

### Latihan

Cek `SchoolController::newsShow()` — ada query `$relatedNews` tepat setelah `$news`. Apakah query itu perlu `with()` juga? Cek view-nya, lihat apakah relasi kategori/penulis dipakai di sana.

---

## TOPIK 3 — Route Model Binding

Daripada menerima ID/slug mentah lalu mencari modelnya manual di controller, Laravel bisa melakukan pencarian itu otomatis hanya dengan type-hint model di parameter method — termasuk otomatis melempar 404 kalau tidak ketemu.

Ini disebut **implicit binding** (Laravel menebak dari nama parameter route dan tipe di signature method). Ada juga *explicit binding* (didaftarkan manual di provider) untuk kasus yang lebih rumit, tapi untuk proyek ini implicit binding sudah lebih dari cukup.

### Kode Kalian Sekarang

`app/Http/Controllers/SchoolController.php:531`

```php
public function newsShow($slug)
{
    $news = News::with(['category', 'author'])->where('slug', $slug)->firstOrFail();
    ...
}
```

`app/Http/Controllers/AdminController.php:73-96`

```php
public function newsEdit($id)
{
    $news = News::findOrFail($id);
    ...
}

public function newsUpdate(Request $request, $id)
{
    $news = News::findOrFail($id);
    ...
}
```

### LANGKAH 1 — Tambahkan `getRouteKeyName()` di model

`app/Models/News.php`

```php
public function getRouteKeyName(): string
{
    return 'slug';
}
```

### LANGKAH 2 — Ganti parameter route jadi `{news:slug}`

`routes/web.php`

```php
Route::get('/berita/{news:slug}', [SchoolController::class, 'newsShow'])->name('news.show');
```

### LANGKAH 3 — Ganti signature method, hapus pencarian manual

`app/Http/Controllers/SchoolController.php`

```php
public function newsShow(News $news)
{
    $news->load(['category', 'author']);
    ...
}
```

Untuk `newsEdit`/`newsUpdate` di admin, karena route-nya pakai `{id}` (bukan slug), cukup ganti `$id` jadi type-hint `News $news` — tanpa perlu `getRouteKeyName()` karena defaultnya memang cocok dengan kolom `id`:

`app/Http/Controllers/AdminController.php`

```php
public function newsUpdate(Request $request, News $news)
{
    $validated = $request->validate([...]);
    ...
}
```

> **COBA LANGSUNG (LIVE CHECK) — Pastikan 404 otomatis untuk slug salah**
> Buka halaman berita yang benar-benar ada di database dulu (pastikan tetap tampil normal), lalu sengaja buka slug yang tidak ada, misalnya `/berita/asal-ngetik-123` — harus otomatis muncul halaman 404 Laravel, bukan error lain.

### Latihan

Terapkan pola yang sama ke `TeacherStaff` dan `Major` di `AdminController` — keduanya punya method edit/update dengan pola `findOrFail($id)` yang sama persis.

---

## TOPIK 4 — Form Request Classes

Kalau aturan validasi mulai diulang di beberapa method (store dan update, misalnya), pindahkan ke class `FormRequest` sendiri. Controller jadi lebih ringkas dan aturan validasinya hanya ditulis satu tempat.

Selain `rules()` dan `authorize()`, FormRequest juga punya `messages()` untuk pesan error kustom per field (persis seperti array kedua di `$request->validate([...], [...])` yang sudah kalian pakai di `ppdbStore`) dan `withValidator()` untuk aturan validasi yang lebih rumit dari sekadar satu baris.

### Kode Kalian Sekarang — aturan yang sama diulang dua kali

`app/Http/Controllers/AdminController.php:53-96`

```php
public function newsStore(Request $request)
{
    $validated = $request->validate([
        'title'        => 'required|string|max:255',
        'category_id'  => 'required|exists:news_categories,id',
        'content'      => 'required|string',
        'thumbnail'    => 'nullable|string',
        'published_at' => 'nullable|date',
    ]);
    ...
}

public function newsUpdate(Request $request, $id)
{
    $news = News::findOrFail($id);
    $validated = $request->validate([
        'title'        => 'required|string|max:255',
        'category_id'  => 'required|exists:news_categories,id',
        'content'      => 'required|string',
        'thumbnail'    => 'nullable|string',
        'published_at' => 'nullable|date',
    ]);
    ...
}
```

### LANGKAH 1 — Buat Form Request baru

```bash
php artisan make:request StoreNewsRequest
```

### LANGKAH 2 — Pindahkan aturan validasi ke sana

`app/Http/Requests/StoreNewsRequest.php`

```php
class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', News::class);
    }

    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'category_id'  => 'required|exists:news_categories,id',
            'content'      => 'required|string',
            'thumbnail'    => 'nullable|string',
            'published_at' => 'nullable|date',
        ];
    }
}
```

### LANGKAH 3 — Pakai di controller, tinggal type-hint

`app/Http/Controllers/AdminController.php`

```php
public function newsStore(StoreNewsRequest $request)
{
    $validated = $request->validated();
    $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
    $validated['author_id'] = Auth::id();
    $news = News::create($validated);
    ...
}
```

Laravel otomatis menjalankan validasi sebelum masuk ke isi method — kalau gagal, otomatis redirect back dengan pesan error, persis seperti sebelumnya. Tidak ada perilaku yang berubah dari sisi pengguna.

> **CATATAN — Kaitkan ke Policy yang sudah ada**
> Method `authorize()` di atas bisa langsung memanggil Policy yang sudah kalian punya (9 Policy sudah ada di proyek ini) — jadi aturan "siapa boleh apa" dan "data valid seperti apa" tetap terpisah rapi, tidak tercampur di controller.

> **COBA LANGSUNG (LIVE CHECK) — Pastikan pesan error tidak berubah**
> Submit form tambah berita dengan judul dikosongkan — pesan error yang tampil harus persis sama seperti sebelum refactor ini. Kalau beda atau hilang, cek lagi nama field di `rules()`.

### Latihan

Buat `StoreTeacherRequest` untuk form tambah guru/staf yang validasinya ada di `AdminController.php` sekitar baris 132.

---

## TOPIK 5 — Model Events, lalu Naik Level ke Observer

Kalian sebetulnya sudah memakai konsep Model Events — lewat `booted()` di model. Topik ini menjelaskan konsepnya, lalu menunjukkan cara merapikannya ke class **Observer** terpisah supaya polanya gampang dipakai ulang untuk modul lain.

Eloquent punya siklus event lengkap untuk setiap model: `retrieved` (setelah dibaca dari DB), `creating`/`created`, `updating`/`updated`, `saving`/`saved` (jalan untuk create maupun update), dan `deleting`/`deleted`. Proyek kalian baru memakai satu (`creating`) — memahami semuanya berguna karena nanti Modul Peminjaman butuh event `updating` untuk memvalidasi perubahan stok.

### Kode Kalian Sekarang — sudah cukup canggih!

`app/Models/PpdbRegistration.php:57-73`

```php
protected static function booted(): void
{
    static::creating(function (PpdbRegistration $registration) {
        if (empty($registration->no_pendaftaran)) {
            $year = date('Y');
            $count = static::whereYear('created_at', $year)->count() + 1;
            $noPendaftaran = 'PPDB-' . $year . '-'
                . str_pad((string) $count, 4, '0', STR_PAD_LEFT);

            while (static::where('no_pendaftaran', $noPendaftaran)->exists()) {
                $count++;
                $noPendaftaran = 'PPDB-' . $year . '-'
                    . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
            }

            $registration->no_pendaftaran = $noPendaftaran;
        }
    });
}
```

Ini pola yang benar: nomor pendaftaran dibuat otomatis tepat sebelum baris baru disimpan (event `creating`). Yang bisa dirapikan: logic sebesar ini lebih nyaman hidup di class sendiri daripada menumpuk di dalam model.

### LANGKAH 1 — Buat Observer

```bash
php artisan make:observer PpdbRegistrationObserver --model=PpdbRegistration
```

### LANGKAH 2 — Pindahkan logic ke method `creating()`

`app/Observers/PpdbRegistrationObserver.php`

```php
class PpdbRegistrationObserver
{
    public function creating(PpdbRegistration $registration): void
    {
        if (empty($registration->no_pendaftaran)) {
            $year = date('Y');
            $count = PpdbRegistration::whereYear('created_at', $year)->count() + 1;
            $noPendaftaran = 'PPDB-' . $year . '-'
                . str_pad((string) $count, 4, '0', STR_PAD_LEFT);

            while (PpdbRegistration::where('no_pendaftaran', $noPendaftaran)->exists()) {
                $count++;
                $noPendaftaran = 'PPDB-' . $year . '-'
                    . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
            }

            $registration->no_pendaftaran = $noPendaftaran;
        }
    }
}
```

### LANGKAH 3 — Daftarkan Observer-nya, hapus `booted()` dari model

`app/Providers/AppServiceProvider.php`

```php
public function boot(): void
{
    PpdbRegistration::observe(PpdbRegistrationObserver::class);
}
```

> **COBA LANGSUNG (LIVE CHECK) — Pastikan nomor pendaftaran tetap otomatis**
> Buka tinker, buat satu pendaftaran PPDB baru tanpa mengisi `no_pendaftaran` — harus otomatis terisi persis seperti sebelum refactor:
>
> ```
> php artisan tinker
> >>> $data = ['full_name' => 'Uji Coba', 'jenjang' => 'smp', 'status' => 'pending'];
> >>> App\Models\PpdbRegistration::create($data);
> >>> App\Models\PpdbRegistration::latest()->first()->no_pendaftaran;
> ```

> **CATATAN — Kenapa ini penting untuk Modul Peminjaman**
> Modul Peminjaman Buku butuh pola identik: kode peminjaman dibuat otomatis saat pengajuan dibuat. Begitu Observer ini dikuasai, tinggal disalin polanya jadi `LoanObserver`.

---

## TOPIK 6 — Accessor & Mutator: Menyatukan Gaya Lama & Baru

Eloquent punya dua cara menulis "atribut turunan" (nilai yang dihitung, bukan kolom asli di database). Menariknya, file kalian sendiri memakai kedua gaya itu sekaligus — ini kesempatan bagus untuk menyatukannya.

`Attribute::make()` juga bisa menangani arah sebaliknya: `set:` untuk mengubah nilai sebelum disimpan ke database (disebut *mutator*) — misalnya memastikan nomor telepon orang tua selalu tersimpan tanpa spasi. Satu class, dua arah: baca (`get`) dan tulis (`set`).

### Kode Kalian Sekarang — dua gaya dalam satu file yang sama

`app/Models/User.php`

```php
// Gaya BARU (Laravel 9+) -- dipakai untuk casting
protected function casts(): array
{
    return [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];
}

// Gaya LAMA (magic method) -- dipakai untuk accessor, di file YANG SAMA
public function getDashboardUrlAttribute(): string
{
    return match ($this->role) {
        'super_admin' => route('admin.dashboard'),
        ...
    };
}
```

### LANGKAH 1 — Tulis ulang accessor pakai `Attribute::make()`

`app/Models/User.php`

```php
use Illuminate\Database\Eloquent\Casts\Attribute;

protected function dashboardUrl(): Attribute
{
    return Attribute::make(
        get: fn () => match ($this->role) {
            'super_admin'     => route('admin.dashboard'),
            'admin_cms'       => route('admin.cms.dashboard'),
            'admin_ppdb'      => route('admin.ppdb.dashboard'),
            'editor_akademik' => route('admin.akademik.dashboard'),
            default           => route('admin.dashboard'),
        },
    );
}
```

Nama pemanggilannya di luar tidak berubah sama sekali: `$user->dashboard_url` tetap jalan seperti biasa (Laravel otomatis mengubah nama method `dashboardUrl` jadi `dashboard_url`). Yang berubah cuma cara mendeklarasikannya.

> **CATATAN — Contoh mutator (set), untuk latihan lanjutan**
> Kalau nanti mau memastikan `parent_phone` di `PpdbRegistration` selalu tersimpan tanpa spasi/strip, polanya: `Attribute::make(set: fn ($value) => preg_replace('/\D/', '', $value))` — dijalankan otomatis setiap kali atribut itu di-set, sebelum masuk database.

> **COBA LANGSUNG (LIVE CHECK) — Pastikan nilai accessor tidak berubah**
> Buka tinker, cek nilainya sama persis sebelum dan sesudah diubah:
>
> ```
> php artisan tinker
> >>> App\Models\User::first()->dashboard_url
> >>> App\Models\User::first()->role_label
> ```

### Latihan

Tiga accessor gaya lama di `PpdbRegistration.php` (`getJenjangLabelAttribute`, `getJenjangCodeAttribute`, `getJenjangIconAttribute`) masih menunggu ditulis ulang dengan pola yang sama.

---

## TOPIK 7 — Query Scopes

Kalau kondisi `where()` yang sama diulang di beberapa tempat, itu pertanda saatnya membuat **Local Scope** — method di model yang bisa dipanggil langsung setelah nama model, seolah bagian dari query builder.

Ada juga **Global Scope** (otomatis ditambahkan ke setiap query tanpa perlu dipanggil manual) — dipakai untuk aturan yang benar-benar selalu berlaku, misalnya kalau nanti data perlu difilter per sekolah/cabang. Untuk kebutuhan proyek ini, Local Scope sudah cukup: kalian yang memutuskan kapan filternya dipakai.

### Kode Kalian Sekarang — `where('status', ...)` berulang

`app/Http/Controllers/Admin/PpdbDashboardController.php:19-36`

```php
$stats = [
    'total'        => PpdbRegistration::count(),
    'pending'      => PpdbRegistration::where('status', 'pending')->count(),
    'diverifikasi' => PpdbRegistration::where('status', 'diverifikasi')->count(),
    'diterima'     => PpdbRegistration::where('status', 'diterima')->count(),
    'ditolak'      => PpdbRegistration::where('status', 'ditolak')->count(),
];

$pendingRegistrations = PpdbRegistration::with('documents')
    ->where('status', 'pending')
    ->orderBy('created_at', 'asc')
    ->limit(8)
    ->get();
```

### LANGKAH 1 — Tambah Scope di model

`app/Models/PpdbRegistration.php`

```php
public function scopeStatus($query, string $status)
{
    return $query->where('status', $status);
}

public function scopePending($query)
{
    return $query->where('status', 'pending');
}
```

### LANGKAH 2 — Pakai di controller, tanpa `where()` manual lagi

`app/Http/Controllers/Admin/PpdbDashboardController.php`

```php
$stats = [
    'total'        => PpdbRegistration::count(),
    'pending'      => PpdbRegistration::pending()->count(),
    'diverifikasi' => PpdbRegistration::status('diverifikasi')->count(),
    'diterima'     => PpdbRegistration::status('diterima')->count(),
    'ditolak'      => PpdbRegistration::status('ditolak')->count(),
];

$pendingRegistrations = PpdbRegistration::with('documents')
    ->pending()
    ->orderBy('created_at', 'asc')
    ->limit(8)
    ->get();
```

Perhatikan: dipanggil sebagai `pending()` tanpa awalan `scope` — Eloquent otomatis membuang awalan itu. Method yang dideklarasikan `scopePending` dipanggil sebagai `::pending()`.

> **COBA LANGSUNG (LIVE CHECK) — Pastikan angka hitungan tetap sama**
> Hasil hitungnya harus persis sama sebelum dan sesudah — ini murni soal kerapian kode, bukan mengubah logika:
>
> ```
> php artisan tinker
> >>> App\Models\PpdbRegistration::where('status', 'pending')->count(); // cara lama
> >>> App\Models\PpdbRegistration::pending()->count(); // cara baru, angkanya harus sama
> ```

### Latihan

Buat scope serupa untuk `PpdbDocument`: `scopeVerified($query)` menggantikan `where('verification_status', 'valid')` yang dipakai di `PpdbDashboardController.php:26`.

---

*Lanjut ke Bagian 2: `improve-2.md` (Bagian B — Topik 8–14 dan Ringkasan).*
