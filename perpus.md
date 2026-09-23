# Rancangan Implementasi: Modul Perpustakaan Digital
### Ditambahkan ke Portal Sekolah Berbasis Laravel

Dokumen ini adalah rancangan teknis lengkap untuk menambahkan modul **Perpustakaan Digital** ke website Laravel yang sudah ada (mengikuti pola arsitektur yang sudah dipakai di modul PPDB & RBAC). Disusun ulang dari lembar tugas menjadi satu alur implementasi yang bisa dikerjakan berurutan.

---

## 1. Peta Arsitektur

```
PENGUNJUNG / ANGGOTA PERPUS (PUBLIK)
 |
 +--------------------+--------------------+
 |                    |                    |
 GET /perpustakaan    GET /perpustakaan/pinjam   GET /perpustakaan/status
 (katalog + cari)     (form ajukan pinjam)       (cek status pinjaman)
 |                    |                    |
 +----------- SchoolController -------------+
 |
 resources/views/perpus/*.blade.php

=========================================================================

ADMIN (SETELAH LOGIN, role admin_perpus)
 |
 GET /admin/perpus/dashboard
 |
 +-----------------------+-----------------------+
 |                       |                        |
 Kelola Katalog Buku     Verifikasi Peminjaman     Laporan & Ekspor CSV
 [Bagian A]              [Bagian B]                [Bagian C]
 |                       |                        |
 AdminController         AdminController           PerpusDashboardController
 book*() / bookCategory*()  loan*()                perpusExportCsv()
 |                       |                        |
 +-----------------------+----------------------------+
 |
 Tabel: book_categories, books, library_members, book_loans
 Role baru: admin_perpus
```

### Kesepakatan Nama (jangan diubah, harus konsisten)

| Kesepakatan | Nilai baku |
|---|---|
| Nama role baru | `admin_perpus` |
| Tabel kategori buku | `book_categories` |
| Tabel buku | `books` |
| Tabel anggota | `library_members` |
| Tabel peminjaman | `book_loans` |
| Prefix route publik | `/perpustakaan` (name: `perpus.*`) |
| Prefix route admin | `/admin/perpus/...` (name: `admin.perpus.*`) |

### Urutan Implementasi (penting!)

Karena `book_loans` (Bagian B) punya foreign key ke `books` (Bagian A), migration Bagian A **harus** bertanggal/dibuat lebih dulu, baru Bagian B. Bagian C (RBAC + dashboard + laporan) mengikat keduanya, jadi dikerjakan terakhir.

**Urutan: Bagian A → Bagian B → Bagian C → Uji coba terintegrasi.**

---

## BAGIAN A — Modul Katalog Buku

Pola sama seperti modul CRUD master-data sederhana yang sudah ada (mis. Jurusan): satu tabel kategori + satu tabel utama, CRUD standar, plus katalog publik.

### A.1 — Migration

```bash
php artisan make:migration create_book_categories_table
php artisan make:migration create_books_table
```

**`..._create_book_categories_table.php`**
```php
Schema::create('book_categories', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->timestamps();
});
```

**`..._create_books_table.php`**
```php
Schema::create('books', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->nullable()
        ->constrained('book_categories')->nullOnDelete();
    $table->string('title');
    $table->string('isbn')->nullable()->unique();
    $table->string('author');
    $table->string('publisher')->nullable();
    $table->unsignedInteger('stock')->default(1);
    $table->unsignedInteger('available')->default(1);
    $table->string('cover')->nullable();
    $table->text('synopsis')->nullable();
    $table->string('rack_location')->nullable();
    $table->timestamps();
});
```

> **Catatan `stock` vs `available`:** `stock` = total eksemplar yang dimiliki. `available` = sisa yang boleh dipinjam saat ini (berkurang saat status jadi "dipinjam", bertambah saat "dikembalikan"). Keduanya diisi sama saat buku baru dibuat.

### A.2 — Model

**`app/Models/BookCategory.php`**
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $fillable = ['name', 'slug'];

    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}
```

**`app/Models/Book.php`**
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'category_id', 'title', 'isbn', 'author', 'publisher',
        'stock', 'available', 'cover', 'synopsis', 'rack_location',
    ];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'category_id');
    }

    public function loans()
    {
        return $this->hasMany(BookLoan::class, 'book_id');
    }
}
```

### A.3 — Policy

**`app/Policies/BookPolicy.php`**
```php
<?php
namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function view(User $user, Book $book): bool
    {
        return $user->is_active;
    }

    public function create(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function update(User $user, Book $book): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }
}
```

Buat juga `BookCategoryPolicy` dengan isi identik (ganti nama model saja). Pendaftaran `Gate::policy()`-nya digabung di Bagian C.6.

### A.4 — Tambahkan Method ke `AdminController`

Tambahkan di bagian paling bawah class, dengan komentar penanda section:

```php
use App\Models\Book;
use App\Models\BookCategory; // tambahkan use ini di paling atas file

/**
 * ==========================================
 * MODUL PERPUSTAKAAN - KATALOG
 * ==========================================
 */
public function bookIndex(Request $request)
{
    Gate::authorize('viewAny', Book::class);

    $search = $request->query('search');
    $books = Book::with('category')
        ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%")
            ->orWhere('author', 'like', "%{$search}%"))
        ->orderBy('title')
        ->paginate(15)
        ->withQueryString();

    return view('admin.perpus.books.index', compact('books', 'search'));
}

public function bookCreate()
{
    Gate::authorize('create', Book::class);
    $categories = BookCategory::orderBy('name')->get();
    return view('admin.perpus.books.create', compact('categories'));
}

public function bookStore(Request $request)
{
    Gate::authorize('create', Book::class);

    $validated = $request->validate([
        'category_id'   => 'nullable|exists:book_categories,id',
        'title'         => 'required|string|max:255',
        'isbn'          => 'nullable|string|max:50|unique:books,isbn',
        'author'        => 'required|string|max:150',
        'publisher'     => 'nullable|string|max:150',
        'stock'         => 'required|integer|min:1',
        'synopsis'      => 'nullable|string',
        'rack_location' => 'nullable|string|max:50',
    ]);

    $validated['available'] = $validated['stock'];
    $book = Book::create($validated);

    $this->logActivity('perpus', 'create', "Menambahkan buku baru: '{$book->title}'");

    return redirect()->route('admin.perpus.books.index')
        ->with('success', 'Buku baru berhasil ditambahkan ke katalog!');
}

public function bookEdit($id)
{
    $book = Book::findOrFail($id);
    Gate::authorize('update', $book);
    $categories = BookCategory::orderBy('name')->get();
    return view('admin.perpus.books.edit', compact('book', 'categories'));
}

public function bookUpdate(Request $request, $id)
{
    $book = Book::findOrFail($id);
    Gate::authorize('update', $book);

    $validated = $request->validate([
        'category_id'   => 'nullable|exists:book_categories,id',
        'title'         => 'required|string|max:255',
        'isbn'          => 'nullable|string|max:50|unique:books,isbn,' . $book->id,
        'author'        => 'required|string|max:150',
        'publisher'     => 'nullable|string|max:150',
        'stock'         => 'required|integer|min:1',
        'synopsis'      => 'nullable|string',
        'rack_location' => 'nullable|string|max:50',
    ]);

    // Jaga agar 'available' tidak pernah melebihi stok baru
    $selisih = $validated['stock'] - $book->stock;
    $validated['available'] = max(0, $book->available + $selisih);

    $book->update($validated);
    $this->logActivity('perpus', 'update', "Memperbarui data buku: '{$book->title}'");

    return redirect()->route('admin.perpus.books.index')
        ->with('success', 'Data buku berhasil diperbarui!');
}

public function bookDelete($id)
{
    $book = Book::findOrFail($id);
    Gate::authorize('delete', $book);

    $title = $book->title;
    $book->delete();
    $this->logActivity('perpus', 'delete', "Menghapus buku: '{$title}'");

    return redirect()->route('admin.perpus.books.index')
        ->with('success', 'Buku berhasil dihapus dari katalog!');
}

public function bookCategoryStore(Request $request)
{
    Gate::authorize('create', Book::class);

    $validated = $request->validate(['name' => 'required|string|max:100']);
    $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);

    BookCategory::create($validated);

    return redirect()->back()->with('success', 'Kategori buku baru berhasil ditambahkan!');
}
```

> **Kenapa `Gate::authorize()` di tiap method?** Middleware `role:...` di routes membatasi siapa yang bisa MENGAKSES rute. `Gate::authorize()` memastikan aturan bisnis (Policy) tetap dicek di level Controller juga — pertahanan berlapis.

### A.5 — Tambahkan ke `SchoolController` (Katalog Publik)

```php
use App\Models\Book;
use App\Models\BookCategory;

/**
 * Tampilkan Katalog Buku Perpustakaan (Publik)
 */
public function perpusIndex(Request $request)
{
    $info = $this->getSchoolData()['info'];
    $search = $request->query('search');
    $categoryId = $request->query('category');

    $books = Book::with('category')
        ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%")
            ->orWhere('author', 'like', "%{$search}%"))
        ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
        ->orderBy('title')
        ->paginate(12)
        ->withQueryString();

    $categories = BookCategory::orderBy('name')->get();

    return view('perpus.index', compact('books', 'categories', 'search', 'categoryId', 'info'));
}

public function perpusShow($id)
{
    $info = $this->getSchoolData()['info'];
    $book = Book::with('category')->findOrFail($id);
    $related = Book::where('category_id', $book->category_id)
        ->where('id', '!=', $book->id)->take(4)->get();

    return view('perpus.show', compact('book', 'related', 'info'));
}
```

### A.6 — Routes

```php
// Route publik - sejajar dengan Route::prefix('ppdb')->...
Route::prefix('perpustakaan')->name('perpus.')->group(function () {
    Route::get('/', [SchoolController::class, 'perpusIndex'])->name('index');
    Route::get('/buku/{id}', [SchoolController::class, 'perpusShow'])->name('show');
});

// Route admin - di dalam Route::middleware(['auth','active'])->prefix('admin')->...
Route::middleware('role:super_admin,admin_perpus')->prefix('perpus')->name('perpus.')->group(function () {
    Route::get('/books', [AdminController::class, 'bookIndex'])->name('books.index');
    Route::get('/books/create', [AdminController::class, 'bookCreate'])->name('books.create');
    Route::post('/books', [AdminController::class, 'bookStore'])->name('books.store');
    Route::get('/books/{id}/edit', [AdminController::class, 'bookEdit'])->name('books.edit');
    Route::post('/books/{id}', [AdminController::class, 'bookUpdate'])->name('books.update');
    Route::delete('/books/{id}', [AdminController::class, 'bookDelete'])->name('books.delete');
    Route::post('/book-categories', [AdminController::class, 'bookCategoryStore'])
        ->name('book-categories.store');
});
```

> Nama grup publik (`perpus.index`) dan admin (`admin.perpus.books.index`) tidak bentrok karena grup admin ada di dalam `Route::prefix('admin')->name('admin.')`.

### A.7 — Views yang perlu dibuat

Salin struktur dari halaman CRUD master-data yang sudah ada (mis. `admin/majors/`) lalu sesuaikan field:

- `resources/views/admin/perpus/books/index.blade.php` — tabel buku + kolom stok/tersedia + search
- `resources/views/admin/perpus/books/create.blade.php` & `edit.blade.php` — form + dropdown kategori
- `resources/views/perpus/index.blade.php` — grid katalog publik + search + filter kategori + pagination
- `resources/views/perpus/show.blade.php` — detail buku + tombol "Ajukan Peminjaman" → `route('perpus.pinjam.create', $book->id)` (dibuat di Bagian B)

### A.8 — Uji Coba

```bash
php artisan migrate
php artisan serve
```
1. Tambah 2–3 kategori & beberapa buku lewat dashboard admin.
2. Buka `/perpustakaan`, cek katalog tampil, coba search & filter kategori.
3. Buka detail buku, cek data (penulis, penerbit, sinopsis) tampil benar.
4. Edit stok sebuah buku, pastikan kolom "tersedia" ikut menyesuaikan.

---

## BAGIAN B — Modul Anggota dan Peminjaman

Alurnya: formulir publik → status "diajukan" → admin verifikasi & ubah status → nomor unik auto-generate → halaman cek status. Pola ini adalah salinan alur PPDB (pendaftaran → verifikasi), hanya beda domain data.

### B.1 — Migration

```bash
php artisan make:migration create_library_members_table
php artisan make:migration create_book_loans_table
```

**`..._create_library_members_table.php`**
```php
Schema::create('library_members', function (Blueprint $table) {
    $table->id();
    $table->string('full_name');
    $table->string('member_code')->unique();
    $table->string('phone');
    $table->text('address')->nullable();
    $table->date('joined_at');
    $table->timestamps();
});
```

**`..._create_book_loans_table.php`**
```php
Schema::create('book_loans', function (Blueprint $table) {
    $table->id();
    $table->string('loan_code')->unique();
    $table->foreignId('member_id')->constrained('library_members')->cascadeOnDelete();
    $table->foreignId('book_id')->constrained('books')->restrictOnDelete();
    $table->date('borrowed_at')->nullable();
    $table->date('due_at')->nullable();
    $table->date('returned_at')->nullable();
    $table->enum('status', ['diajukan', 'dipinjam', 'dikembalikan', 'terlambat'])
        ->default('diajukan');
    $table->text('notes')->nullable();
    $table->timestamps();
});
```

> **`restrictOnDelete()` pada `book_id`:** sengaja beda dari `category_id` (yang pakai `nullOnDelete()`) — supaya buku yang masih punya riwayat peminjaman tidak bisa dihapus begitu saja (mencegah data peminjaman jadi yatim). Laravel akan menolak query hapus dengan error jika ini terjadi — itu perilaku yang diinginkan.

### B.2 — Model

**`app/Models/LibraryMember.php`**
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryMember extends Model
{
    protected $fillable = ['full_name', 'member_code', 'phone', 'address', 'joined_at'];
    protected $casts = ['joined_at' => 'date'];

    public function loans()
    {
        return $this->hasMany(BookLoan::class, 'member_id');
    }

    protected static function booted(): void
    {
        static::creating(function (LibraryMember $member) {
            if (empty($member->member_code)) {
                $year = date('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $code = 'ANG-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
                while (static::where('member_code', $code)->exists()) {
                    $count++;
                    $code = 'ANG-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
                }
                $member->member_code = $code;
            }
        });
    }
}
```

**`app/Models/BookLoan.php`**
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLoan extends Model
{
    protected $fillable = [
        'loan_code', 'member_id', 'book_id', 'borrowed_at',
        'due_at', 'returned_at', 'status', 'notes',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_at'      => 'date',
        'returned_at' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(LibraryMember::class, 'member_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'diajukan'     => 'Menunggu Verifikasi',
            'dipinjam'     => 'Sedang Dipinjam',
            'dikembalikan' => 'Sudah Dikembalikan',
            'terlambat'    => 'Terlambat',
            default        => ucfirst($this->status),
        };
    }

    protected static function booted(): void
    {
        static::creating(function (BookLoan $loan) {
            if (empty($loan->loan_code)) {
                $year = date('Y');
                $count = static::whereYear('created_at', $year)->count() + 1;
                $code = 'PINJAM-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
                while (static::where('loan_code', $code)->exists()) {
                    $count++;
                    $code = 'PINJAM-' . $year . '-' . str_pad((string) $count, 4, '0', STR_PAD_LEFT);
                }
                $loan->loan_code = $code;
            }
        });
    }
}
```

### B.3 — Policy

**`app/Policies/BookLoanPolicy.php`**
```php
<?php
namespace App\Policies;

use App\Models\BookLoan;
use App\Models\User;

class BookLoanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function view(User $user, BookLoan $loan): bool
    {
        return $user->is_active;
    }

    public function update(User $user, BookLoan $loan): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }

    public function delete(User $user, BookLoan $loan): bool
    {
        return $user->is_active && in_array($user->role, ['super_admin', 'admin_perpus']);
    }
}
```

### B.4 — Alur Publik di `SchoolController`

```php
use App\Models\BookLoan;
use App\Models\LibraryMember;

public function perpusPinjamCreate($bookId)
{
    $info = $this->getSchoolData()['info'];
    $book = Book::findOrFail($bookId);
    return view('perpus.pinjam-create', compact('book', 'info'));
}

public function perpusPinjamStore(Request $request, $bookId)
{
    $book = Book::findOrFail($bookId);

    $validated = $request->validate([
        'full_name' => 'required|string|max:150',
        'phone'     => 'required|string|max:20',
        'address'   => 'nullable|string',
    ]);

    if ($book->available < 1) {
        return back()->withErrors(['stock' => 'Maaf, seluruh eksemplar buku ini sedang dipinjam.']);
    }

    // Cari anggota lama berdasarkan nomor HP, atau daftarkan sebagai anggota baru
    $member = LibraryMember::firstOrCreate(
        ['phone' => $validated['phone']],
        [
            'full_name' => $validated['full_name'],
            'address'   => $validated['address'] ?? null,
            'joined_at' => now(),
        ]
    );

    $loan = BookLoan::create([
        'member_id' => $member->id,
        'book_id'   => $book->id,
        'due_at'    => now()->addDays(7),
        'status'    => 'diajukan',
    ]);

    return redirect()->route('perpus.pinjam.success', $loan->loan_code)
        ->with('success', 'Pengajuan peminjaman berhasil dikirim!');
}

public function perpusPinjamSuccess($loanCode)
{
    $info = $this->getSchoolData()['info'];
    $loan = BookLoan::with('book')->where('loan_code', $loanCode)->firstOrFail();
    return view('perpus.pinjam-success', compact('loan', 'info'));
}

public function perpusTracking()
{
    $info = $this->getSchoolData()['info'];
    return view('perpus.tracking', compact('info'));
}

public function perpusCheckStatus(Request $request)
{
    $validated = $request->validate(['loan_code' => 'required|string']);
    $loan = BookLoan::with(['book', 'member'])
        ->where('loan_code', $validated['loan_code'])->first();

    if (!$loan) {
        return back()->withErrors(['loan_code' => 'Kode peminjaman tidak ditemukan.']);
    }

    return view('perpus.tracking', ['loan' => $loan, 'info' => $this->getSchoolData()['info']]);
}
```

> **Kenapa dicari lewat nomor HP, bukan login akun?** Supaya pengunjung tidak perlu bikin akun dulu untuk meminjam buku. `firstOrCreate` otomatis membuat baris anggota baru kalau HP-nya belum terdaftar, atau memakai data lama kalau sudah pernah.

### B.5 — Alur Admin: Verifikasi Peminjaman

```php
use App\Models\BookLoan;

/**
 * ==========================================
 * MODUL PERPUSTAKAAN - PEMINJAMAN
 * ==========================================
 */
public function loanIndex(Request $request)
{
    Gate::authorize('viewAny', BookLoan::class);

    $status = strtolower($request->query('status', ''));
    $query = BookLoan::with(['book', 'member']);

    if (in_array($status, ['diajukan', 'dipinjam', 'dikembalikan', 'terlambat'])) {
        $query->where('status', $status);
    } else {
        $status = 'all';
    }

    $loans = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

    return view('admin.perpus.loans.index', compact('loans', 'status'));
}

public function loanShow($id)
{
    $loan = BookLoan::with(['book', 'member'])->findOrFail($id);
    Gate::authorize('view', $loan);
    return view('admin.perpus.loans.show', compact('loan'));
}

public function loanUpdateStatus(Request $request, $id)
{
    $loan = BookLoan::with('book')->findOrFail($id);
    Gate::authorize('update', $loan);

    $validated = $request->validate([
        'status' => 'required|in:diajukan,dipinjam,dikembalikan,terlambat',
        'notes'  => 'nullable|string',
    ]);

    $oldStatus = $loan->status;
    $newStatus = $validated['status'];

    // Kelola stok "available" saat status berubah (hanya sekali per transisi)
    if ($oldStatus !== 'dipinjam' && $newStatus === 'dipinjam') {
        $loan->book->decrement('available');
        $validated['borrowed_at'] = now();
    }
    if ($oldStatus === 'dipinjam' && $newStatus === 'dikembalikan') {
        $loan->book->increment('available');
        $validated['returned_at'] = now();
    }

    $loan->update($validated);
    $this->logActivity('perpus', 'verify',
        "Mengubah status peminjaman {$loan->loan_code} dari {$oldStatus} ke {$newStatus}");

    return redirect()->route('admin.perpus.loans.show', $id)
        ->with('success', 'Status peminjaman berhasil diperbarui!');
}

public function loanDelete($id)
{
    $loan = BookLoan::findOrFail($id);
    Gate::authorize('delete', $loan);

    $code = $loan->loan_code;
    $loan->delete();
    $this->logActivity('perpus', 'delete', "Menghapus data peminjaman {$code}");

    return redirect()->route('admin.perpus.loans.index')
        ->with('success', 'Data peminjaman berhasil dihapus!');
}
```

> **Kenapa "hanya sekali per transisi"?** Kondisi `$oldStatus !== 'dipinjam' && $newStatus === 'dipinjam'` mencegah stok berkurang dua kali kalau admin menyimpan ulang status yang sama. Tanpa ini, `available` bisa jadi minus atau salah hitung kalau form disubmit berkali-kali.

### B.6 — Routes

```php
// Route publik - di dalam grup perpus. milik Bagian A
Route::get('/pinjam/{bookId}', [SchoolController::class, 'perpusPinjamCreate'])->name('pinjam.create');
Route::post('/pinjam/{bookId}', [SchoolController::class, 'perpusPinjamStore'])
    ->name('pinjam.store')->middleware('throttle:10,1');
Route::get('/sukses/{loan_code}', [SchoolController::class, 'perpusPinjamSuccess'])->name('pinjam.success');
Route::get('/status', [SchoolController::class, 'perpusTracking'])->name('tracking');
Route::post('/status', [SchoolController::class, 'perpusCheckStatus'])
    ->name('check')->middleware('throttle:20,1');

// Route admin - di dalam grup role:super_admin,admin_perpus milik Bagian A
Route::get('/loans', [AdminController::class, 'loanIndex'])->name('loans.index');
Route::get('/loans/{id}', [AdminController::class, 'loanShow'])->name('loans.show');
Route::post('/loans/{id}/status', [AdminController::class, 'loanUpdateStatus'])->name('loans.status');
Route::delete('/loans/{id}', [AdminController::class, 'loanDelete'])->name('loans.delete');
```

### B.7 — Views yang perlu dibuat

- `resources/views/perpus/pinjam-create.blade.php` — form ajukan pinjam
- `resources/views/perpus/pinjam-success.blade.php` & `tracking.blade.php` — konfirmasi & cek status
- `resources/views/admin/perpus/loans/index.blade.php` & `show.blade.php` — daftar & detail peminjaman + filter status di query string

### B.8 — Uji Coba

```bash
php artisan migrate
php artisan serve
```
1. Buka detail buku (Bagian A), klik "Ajukan Peminjaman", isi form.
2. Cek halaman sukses menampilkan kode format `PINJAM-2026-0001`.
3. Login admin, ubah status jadi "dipinjam" — kolom "tersedia" di buku terkait harus berkurang satu.
4. Ubah status jadi "dikembalikan" — "tersedia" harus bertambah kembali.
5. Coba cek status pakai kode peminjaman di halaman publik.

---

## BAGIAN C — RBAC, Dashboard, dan Laporan

Mengikat Bagian A dan B: menambahkan role `admin_perpus`, dashboard khusus, ekspor CSV (streaming), dan seeder data contoh.

### C.1 — Daftarkan Role Baru di `User` Model

Di `app/Models/User.php`, tambahkan `admin_perpus` di tiga tempat (jangan hapus role yang sudah ada):

```php
public function canAccessPanel(Panel $panel): bool
{
    return $this->is_active && in_array($this->role, [
        'super_admin',
        'admin_cms',
        'admin_ppdb',
        'editor_akademik',
        'admin_perpus', // baris baru
    ]);
}

public function isAdminPerpus(): bool
{
    return $this->role === 'admin_perpus';
}

public function getDashboardUrlAttribute(): string
{
    return match ($this->role) {
        'super_admin'      => route('admin.dashboard'),
        'admin_cms'        => route('admin.cms.dashboard'),
        'admin_ppdb'       => route('admin.ppdb.dashboard'),
        'editor_akademik'  => route('admin.akademik.dashboard'),
        'admin_perpus'     => route('admin.perpus.dashboard'), // baris baru
        default            => route('admin.dashboard'),
    };
}

public function getRoleLabelAttribute(): string
{
    return match ($this->role) {
        'super_admin'      => 'Super Admin',
        'admin_cms'        => 'Admin CMS',
        'admin_ppdb'       => 'Admin PPDB',
        'editor_akademik'  => 'Editor Akademik',
        'admin_perpus'     => 'Petugas Perpustakaan', // baris baru
        default            => 'Pengguna',
    };
}
```

### C.2 — Izinkan Role Baru di Form Kelola Pengguna

Di `app/Http/Controllers/Admin/UserController.php`, tambahkan `admin_perpus` di **dua tempat**: method `store()` dan `update()`.

```php
'role' => ['required', Rule::in([
    'super_admin', 'admin_cms', 'admin_ppdb', 'editor_akademik', 'admin_perpus',
])],
```

> ⚠️ Kalau cuma diubah di salah satu method, akun `admin_perpus` bisa dibuat tapi tidak bisa diedit lagi (atau sebaliknya).

### C.3 — Dashboard Controller

```bash
php artisan make:controller Admin/PerpusDashboardController
```

**`app/Http/Controllers/Admin/PerpusDashboardController.php`**
```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Support\Facades\DB;

class PerpusDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books'     => Book::count(),
            'total_available' => (int) Book::sum('available'),
            'total_dipinjam'  => BookLoan::where('status', 'dipinjam')->count(),
            'total_terlambat' => BookLoan::where('status', 'terlambat')->count(),
        ];

        $recentLoans = BookLoan::with(['book', 'member'])
            ->orderBy('created_at', 'desc')->take(8)->get();

        $topBooks = BookLoan::select('book_id', DB::raw('count(*) as total'))
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->with('book')
            ->take(5)
            ->get();

        return view('admin.dashboards.perpus', compact('stats', 'recentLoans', 'topBooks'));
    }
}
```

Untuk view, contek struktur dashboard role lain yang sudah ada (kartu statistik + tabel ringkas), sesuaikan dengan `$stats`, `$recentLoans`, `$topBooks` di atas — cocok untuk menampilkan **buku terlambat** dan **buku paling sering dipinjam**.

### C.4 — Ekspor Laporan CSV (Streaming)

Tambahkan ke `AdminController.php`:

```php
public function perpusExportCsv(Request $request)
{
    Gate::authorize('viewAny', \App\Models\BookLoan::class);

    $status = strtolower($request->query('status', ''));
    $query = BookLoan::with(['book', 'member']);

    if (in_array($status, ['diajukan', 'dipinjam', 'dikembalikan', 'terlambat'])) {
        $query->where('status', $status);
    } else {
        $status = 'semua';
    }

    $loans = $query->orderBy('created_at', 'desc')->get();
    $filename = 'rekap-peminjaman-' . $status . '-' . date('Y-m-d_His') . '.csv';

    $headers = [
        'Content-Type'        => 'text/csv; charset=UTF-8',
        'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        'Pragma'              => 'no-cache',
        'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
        'Expires'             => '0',
    ];

    $callback = function () use ($loans) {
        $file = fopen('php://output', 'w');
        fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM biar Excel baca UTF-8 benar
        fputcsv($file, ['Kode Pinjam', 'Anggota', 'No. HP', 'Buku', 'Status', 'Tgl Pinjam', 'Jatuh Tempo']);

        foreach ($loans as $loan) {
            fputcsv($file, [
                $loan->loan_code,
                $loan->member->full_name,
                $loan->member->phone,
                $loan->book->title,
                $loan->status_label,
                optional($loan->borrowed_at)->format('d-m-Y'),
                optional($loan->due_at)->format('d-m-Y'),
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
```

Daftarkan route-nya di grup admin perpus:
```php
Route::get('/loans-export', [AdminController::class, 'perpusExportCsv'])->name('loans.export');
```

> **Catatan skala:** kalau data peminjaman sudah sangat besar, `->get()` di atas bisa mengonsumsi memori. Untuk versi yang benar-benar streaming dari sisi query, ganti `->get()` dengan `->cursor()` (LazyCollection) di dalam `$callback`, sehingga baris query dibaca satu per satu dari database alih-alih dimuat sekaligus ke memory.

### C.5 — Route Dashboard

```php
Route::get('/perpus/dashboard', [\App\Http\Controllers\Admin\PerpusDashboardController::class, 'index'])
    ->name('perpus.dashboard')
    ->middleware('role:super_admin,admin_perpus');
```

### C.6 — Registrasi Policy

Di `app/Providers/AppServiceProvider.php`, method `boot()`:

```php
Gate::policy(\App\Models\Book::class, \App\Policies\BookPolicy::class);
Gate::policy(\App\Models\BookCategory::class, \App\Policies\BookCategoryPolicy::class);
Gate::policy(\App\Models\BookLoan::class, \App\Policies\BookLoanPolicy::class);
```

### C.7 — Seeder

```bash
php artisan make:seeder PerpusSeeder
```

**`database/seeders/PerpusSeeder.php`**
```php
<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\LibraryMember;
use App\Models\BookLoan;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PerpusSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun petugas perpustakaan
        User::updateOrCreate(
            ['email' => 'perpus@sekolah.sch.id'],
            [
                'name'      => 'Petugas Perpustakaan',
                'password'  => bcrypt('password123'),
                'role'      => 'admin_perpus',
                'is_active' => true,
            ]
        );

        // 2. Kategori & buku contoh
        $categories = ['Fiksi', 'Sains & Teknologi', 'Sejarah', 'Agama'];
        $categoryModels = [];
        foreach ($categories as $name) {
            $categoryModels[$name] = BookCategory::firstOrCreate(
                ['slug' => Str::slug($name)], ['name' => $name]
            );
        }

        $books = [
            ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'category' => 'Fiksi'],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'category' => 'Sains & Teknologi'],
            ['title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'category' => 'Sejarah'],
        ];
        $bookModels = [];
        foreach ($books as $b) {
            $bookModels[] = Book::firstOrCreate(
                ['title' => $b['title']],
                [
                    'category_id' => $categoryModels[$b['category']]->id,
                    'author'      => $b['author'],
                    'stock'       => 3,
                    'available'   => 3,
                ]
            );
        }

        // 3. Anggota & peminjaman contoh
        $member = LibraryMember::firstOrCreate(
            ['phone' => '081200001111'],
            ['full_name' => 'Contoh Anggota', 'joined_at' => now()]
        );

        BookLoan::firstOrCreate(
            ['member_id' => $member->id, 'book_id' => $bookModels[0]->id],
            ['status' => 'dipinjam', 'borrowed_at' => now()->subDays(3), 'due_at' => now()->addDays(4)]
        );
    }
}
```

Panggil dari `DatabaseSeeder.php` (tambahkan satu baris, jangan ubah yang lain):
```php
public function run(): void
{
    // ... kode seeding yang sudah ada ...
    $this->call(PerpusSeeder::class);
}
```

### C.8 — Migrasi, Seed, dan Uji Coba

```bash
php artisan migrate:fresh --seed
php artisan serve
```
1. Login pakai `perpus@sekolah.sch.id` / `password123`, pastikan diarahkan ke `/admin/perpus/dashboard`.
2. Cocokkan angka kartu statistik dengan data di database (`php artisan tinker`).
3. Klik ekspor CSV, buka di Excel/Google Sheets — kolom rapi, tidak ada karakter aneh (BOM berfungsi).
4. Login sebagai Super Admin → Kelola Pengguna → pastikan "Petugas Perpustakaan" muncul sebagai pilihan role saat membuat maupun mengedit akun.

---

## 2. Checklist Uji Coba Terintegrasi (Setelah Semua Bagian Selesai)

- [ ] `composer install` bila ada dependency baru
- [ ] `php artisan migrate:fresh --seed` berjalan tanpa error foreign key
- [ ] Login sebagai `admin_perpus` — hanya bisa akses dashboard & menu perpustakaan
- [ ] Alur penuh: katalog (A) → ajukan pinjam (B) → admin verifikasi (B) → cek di dashboard/laporan (C)
- [ ] `php artisan test` — fitur lama (PPDB/Berita/dll) tidak rusak
- [ ] Katalog publik bisa dicari & difilter per kategori
- [ ] Kode peminjaman ter-generate dengan format `PINJAM-YYYY-XXXX`
- [ ] Stok `available` menyesuaikan otomatis saat status berubah, tidak minus meski disubmit berulang
- [ ] Ekspor CSV terbuka rapi di Excel/Sheets

---

## 3. Pengembangan Lanjutan (Opsional)

Kalau modul inti sudah jalan, beberapa fitur tambahan yang bisa dikembangkan:

| Fitur | Ringkasan implementasi |
|---|---|
| **Denda keterlambatan** | Tambah kolom `fine_amount` di `book_loans`; buat scheduled command (`php artisan make:command MarkOverdueLoans`) yang jalan harian: ubah status `dipinjam` → `terlambat` jika `due_at` lewat, hitung denda |
| **Notifikasi jatuh tempo** | Laravel Notification (WhatsApp/Email) H-1 sebelum jatuh tempo, dikirim lewat queue |
| **Rating & ulasan buku** | Tabel `book_reviews` (rating 1–5 + komentar), tampil di halaman detail buku, hanya bisa diisi anggota yang pernah meminjam |
| **QR Code anggota** | Generate QR berisi `member_code` (pakai `simplesoftwareio/simple-qrcode`), petugas scan untuk mempercepat verifikasi |
| **Widget ringkasan di dashboard Super Admin** | Tambahkan total buku & peminjaman aktif ke dashboard Super Admin, supaya bisa dilihat sekilas tanpa masuk dashboard khusus perpustakaan |

---

## 4. Troubleshooting Umum

| Gejala | Kemungkinan Penyebab & Solusi |
|---|---|
| `SQLSTATE... foreign key constraint fails` | Migration Bagian B dijalankan sebelum Bagian A. Pastikan nama file migration `books` bertanggal lebih awal dari `book_loans` |
| `Route [admin.perpus.books.index] not defined` | Route belum terdaftar atau salah ditaruh di luar grup `prefix('admin')`. Cek dengan `php artisan route:list --name=perpus` |
| 403 Akses ditolak padahal sudah login | Role user tidak ada di middleware `role:...` pada route tersebut, atau lupa Langkah C.1/C.2 |
| Kolom "tersedia" jadi minus | Logika penyesuaian stok di `loanUpdateStatus` tereksekusi berkali-kali — cek ulang kondisi `$oldStatus !== 'dipinjam'` |
| Data seeder duplikat / unique constraint error | Pakai `firstOrCreate` / `updateOrCreate`, bukan `create` biasa, di seeder |

---

## 5. Referensi Perintah Artisan

```bash
php artisan make:migration nama_migration
php artisan make:model NamaModel
php artisan make:controller Admin/NamaController
php artisan make:policy NamaPolicy --model=NamaModel
php artisan migrate
php artisan migrate:fresh --seed
php artisan route:list --name=perpus
php artisan tinker
php artisan test
```

> ⚠️ `migrate:fresh` menghapus SEMUA data lalu membuat ulang dari nol + seeder. Aman untuk development, **jangan pernah** dijalankan di server produksi yang sudah punya data pengguna asli — gunakan `php artisan migrate` biasa di sana.
