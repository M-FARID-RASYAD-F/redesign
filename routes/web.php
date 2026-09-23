<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SuperAdminDashboardController;
use App\Http\Controllers\Admin\CmsDashboardController;
use App\Http\Controllers\Admin\PpdbDashboardController;
use App\Http\Controllers\Admin\AkademikDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RackController;

/*
|--------------------------------------------------------------------------
| Web Routes - Website Sekolah (Contoh Pembelajaran Laravel)
|--------------------------------------------------------------------------
*/

// 1. Route Halaman Utama Landing Page Sekolah
Route::get('/', [SchoolController::class, 'index'])->name('home');

// 1.1 Route Portal Berita Publik & Detail Artikel
Route::get('/berita', [SchoolController::class, 'newsIndex'])->name('berita.index');
Route::get('/berita/{slug}', [SchoolController::class, 'newsShow'])->name('news.show');

// 1.2 Route Quick Search API (Spotlight / Cmd+K)
Route::get('/api/search', [SchoolController::class, 'globalSearch'])->name('api.search');

// 1.3 Route Modul Katalog Perpustakaan Publik (Tugas 1: Katalog & Master Data)
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
// 2. Route Modul PPDB Online Mandiri (Publik)
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', [SchoolController::class, 'ppdbIndex'])->name('index');
    Route::get('/daftar', [SchoolController::class, 'ppdbCreate'])->name('create');
    Route::post('/daftar', [SchoolController::class, 'ppdbStore'])
        ->name('store')
        ->middleware('throttle:10,1');
    Route::get('/sukses/{no_pendaftaran}', [SchoolController::class, 'ppdbSuccess'])
        ->name('success')
        ->middleware('throttle:30,1');
    Route::get('/cek-status', [SchoolController::class, 'ppdbTracking'])->name('tracking');
    Route::post('/cek-status', [SchoolController::class, 'ppdbCheckStatus'])
        ->name('check')
        ->middleware('throttle:20,1');
});

// 4. Route Login & Registrasi Guru (Custom UI) + proses autentikasi
Route::get('/login', function () {
    return view('auth.login', ['defaultTab' => 'login']);
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('auth.login', ['defaultTab' => 'register']);
})->name('register')->middleware('guest');

// POST Login (mendukung /login dan /login-process dengan throttle 10 per menit)
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.post')
    ->middleware(['guest', 'throttle:10,1']);

Route::post('/login-process', [AuthenticatedSessionController::class, 'store'])
    ->name('login.process')
    ->middleware(['guest', 'throttle:10,1']);

// POST Register (mendukung /register dan /register-process dengan throttle 10 per menit)
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register.post')
    ->middleware(['guest', 'throttle:10,1']);

Route::post('/register-process', [RegisteredUserController::class, 'store'])
    ->name('register.process')
    ->middleware(['guest', 'throttle:10,1']);

// 5. Route Logout (Mewajibkan HTTP POST dengan proteksi CSRF demi keamanan sesi)
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json(['status' => 'success', 'message' => 'Kamu telah berhasil logout.']);
    }

    return redirect('/')->with('success', 'Anda telah berhasil Logout dari sistem.');
})->name('logout');

// 6. Route Group Admin (Proteksi Otentikasi & Akun Aktif)
Route::middleware(['auth', 'active'])->prefix('admin')->name('admin.')->group(function () {
    // 6.1 Role Dashboards
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware('role:super_admin');
    Route::get('/cms/dashboard', [CmsDashboardController::class, 'index'])
        ->name('cms.dashboard')
        ->middleware('role:super_admin,admin_cms');
    Route::get('/ppdb/dashboard', [PpdbDashboardController::class, 'index'])
        ->name('ppdb.dashboard')
        ->middleware('role:super_admin,admin_ppdb');
    Route::get('/akademik/dashboard', [AkademikDashboardController::class, 'index'])
        ->name('akademik.dashboard')
        ->middleware('role:super_admin,editor_akademik');

    // 6.2 Kelola Pengguna Admin (Khusus Super Admin)
    Route::resource('users', UserController::class)->middleware('role:super_admin');

    // 6.3 Modul Berita (CMS)
    Route::get('/news', [AdminController::class, 'newsIndex'])->name('news.index');
    Route::middleware('role:super_admin,admin_cms')->group(function () {
        Route::get('/news/create', [AdminController::class, 'newsCreate'])->name('news.create');
        Route::post('/news', [AdminController::class, 'newsStore'])->name('news.store');
        Route::get('/news/{id}/edit', [AdminController::class, 'newsEdit'])->name('news.edit');
        Route::post('/news/{id}', [AdminController::class, 'newsUpdate'])->name('news.update');
        Route::delete('/news/{id}', [AdminController::class, 'newsDelete'])->name('news.delete');
    });

    // 6.4 Modul Guru & Staf (Akademik & CMS)
    Route::get('/teachers', [AdminController::class, 'teacherIndex'])->name('teachers.index');
    Route::middleware('role:super_admin,admin_cms,editor_akademik')->group(function () {
        Route::get('/teachers/create', [AdminController::class, 'teacherCreate'])->name('teachers.create');
        Route::post('/teachers', [AdminController::class, 'teacherStore'])->name('teachers.store');
        Route::get('/teachers/{id}/edit', [AdminController::class, 'teacherEdit'])->name('teachers.edit');
        Route::post('/teachers/{id}', [AdminController::class, 'teacherUpdate'])->name('teachers.update');
        Route::delete('/teachers/{id}', [AdminController::class, 'teacherDelete'])->name('teachers.delete');
    });

    // 6.5 Modul Program Jurusan (Akademik & CMS)
    Route::get('/majors', [AdminController::class, 'majorIndex'])->name('majors.index');
    Route::middleware('role:super_admin,admin_cms,editor_akademik')->group(function () {
        Route::get('/majors/create', [AdminController::class, 'majorCreate'])->name('majors.create');
        Route::post('/majors', [AdminController::class, 'majorStore'])->name('majors.store');
        Route::get('/majors/{id}/edit', [AdminController::class, 'majorEdit'])->name('majors.edit');
        Route::post('/majors/{id}', [AdminController::class, 'majorUpdate'])->name('majors.update');
        Route::delete('/majors/{id}', [AdminController::class, 'majorDelete'])->name('majors.delete');
    });

    // 6.6 Modul PPDB Online
    Route::middleware('role:super_admin,admin_ppdb,admin_cms')->group(function () {
        Route::get('/ppdb', [AdminController::class, 'ppdbIndex'])->name('ppdb.index');
        Route::get('/ppdb/export', [AdminController::class, 'ppdbExportCsv'])
            ->name('ppdb.export')
            ->middleware('role:super_admin,admin_ppdb');
        Route::get('/ppdb/export-zip', [AdminController::class, 'ppdbExportZip'])
            ->name('ppdb.export-zip')
            ->middleware(['role:super_admin,admin_ppdb', 'throttle:5,1']);
        Route::get('/ppdb/{id}', [AdminController::class, 'ppdbShow'])->name('ppdb.show');
        Route::get('/ppdb/document/{id}', [AdminController::class, 'ppdbViewDocument'])
            ->name('ppdb.document');
        Route::post('/ppdb/{id}/status', [AdminController::class, 'ppdbUpdateStatus'])
            ->name('ppdb.status')
            ->middleware('role:super_admin,admin_ppdb');
    });
    // Delete PPDB: super_admin dan admin_ppdb
    Route::delete('/ppdb/{id}', [AdminController::class, 'ppdbDelete'])
        ->name('ppdb.delete')
        ->middleware('role:super_admin,admin_ppdb');

    // 6.7 Modul Perpustakaan & Katalog Master Data (Tugas 1: Siswa A)
    Route::middleware('role:super_admin,admin_cms,admin_perpus,editor_akademik')->group(function () {
        // Books (Buku)
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/books', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::match(['PUT', 'PATCH', 'POST'], '/books/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.delete');
        Route::delete('/books/{id}/destroy', [BookController::class, 'destroy'])->name('books.destroy');

        // Categories (Kategori)
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::match(['PUT', 'PATCH', 'POST'], '/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');
        Route::delete('/categories/{id}/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Racks (Rak)
        Route::get('/racks', [RackController::class, 'index'])->name('racks.index');
        Route::get('/racks/create', [RackController::class, 'create'])->name('racks.create');
        Route::post('/racks', [RackController::class, 'store'])->name('racks.store');
        Route::get('/racks/{id}/edit', [RackController::class, 'edit'])->name('racks.edit');
        Route::match(['PUT', 'PATCH', 'POST'], '/racks/{id}', [RackController::class, 'update'])->name('racks.update');
        Route::delete('/racks/{id}', [RackController::class, 'destroy'])->name('racks.delete');
        Route::delete('/racks/{id}/destroy', [RackController::class, 'destroy'])->name('racks.destroy');
    });
});