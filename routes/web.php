<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SuperAdminDashboardController;
use App\Http\Controllers\Admin\CmsDashboardController;
use App\Http\Controllers\Admin\PpdbDashboardController;
use App\Http\Controllers\Admin\AkademikDashboardController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes - Website Sekolah (Contoh Pembelajaran Laravel)
|--------------------------------------------------------------------------
*/

// 1. Route Halaman Utama Landing Page Sekolah
Route::get('/', [SchoolController::class, 'index'])->name('home');

// 2. Route Memproses Form Kontak Cepat
Route::post('/kontak', [SchoolController::class, 'submitContact'])->name('kontak.submit');

// 3. Route Modul PPDB Online Mandiri (Publik)
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', [SchoolController::class, 'ppdbIndex'])->name('index');
    Route::get('/daftar', [SchoolController::class, 'ppdbCreate'])->name('create');
    Route::post('/daftar', [SchoolController::class, 'ppdbStore'])->name('store');
    Route::get('/sukses/{no_pendaftaran}', [SchoolController::class, 'ppdbSuccess'])->name('success');
    Route::get('/cek-status', [SchoolController::class, 'ppdbTracking'])->name('tracking');
    Route::post('/cek-status', [SchoolController::class, 'ppdbCheckStatus'])->name('check');
});

// 4. Route Login & Registrasi Guru (Custom UI) + proses autentikasi
Route::get('/login', function () {
    return view('auth.login', ['defaultTab' => 'login']);
})->name('login')->middleware('guest');

Route::get('/register', function () {
    return view('auth.login', ['defaultTab' => 'register']);
})->name('register')->middleware('guest');

Route::post('/login-process', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])
    ->name('login.process')
    ->middleware('guest');

Route::post('/register-process', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store'])
    ->name('register.process')
    ->middleware('guest');

// 5. Route Logout Guru
Route::get('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json(['status' => 'success', 'message' => 'Kamu telah berhasil logout.']);
    }

    return redirect('/')->with('success', 'Anda telah berhasil Logout dari sistem.');
})->name('logout');

// 6. Route Group Admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // 6.1 Role Dashboards
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
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
    // Read: super_admin, admin_cms, admin_ppdb, editor_akademik
    // Write (Create/Edit/Delete): super_admin, admin_cms
    Route::get('/news', [AdminController::class, 'newsIndex'])->name('news.index');
    Route::middleware('role:super_admin,admin_cms')->group(function () {
        Route::get('/news/create', [AdminController::class, 'newsCreate'])->name('news.create');
        Route::post('/news', [AdminController::class, 'newsStore'])->name('news.store');
        Route::get('/news/{id}/edit', [AdminController::class, 'newsEdit'])->name('news.edit');
        Route::post('/news/{id}', [AdminController::class, 'newsUpdate'])->name('news.update');
        Route::delete('/news/{id}', [AdminController::class, 'newsDelete'])->name('news.delete');
    });

    // 6.4 Modul Guru & Staf (Akademik & CMS)
    // Read: super_admin, admin_cms, editor_akademik
    // Write: super_admin, admin_cms, editor_akademik
    Route::get('/teachers', [AdminController::class, 'teacherIndex'])->name('teachers.index');
    Route::middleware('role:super_admin,admin_cms,editor_akademik')->group(function () {
        Route::get('/teachers/create', [AdminController::class, 'teacherCreate'])->name('teachers.create');
        Route::post('/teachers', [AdminController::class, 'teacherStore'])->name('teachers.store');
        Route::get('/teachers/{id}/edit', [AdminController::class, 'teacherEdit'])->name('teachers.edit');
        Route::post('/teachers/{id}', [AdminController::class, 'teacherUpdate'])->name('teachers.update');
        Route::delete('/teachers/{id}', [AdminController::class, 'teacherDelete'])->name('teachers.delete');
    });

    // 6.5 Modul Program Jurusan (Akademik & CMS)
    // Read: super_admin, admin_cms, editor_akademik
    // Write: super_admin, admin_cms, editor_akademik
    Route::get('/majors', [AdminController::class, 'majorIndex'])->name('majors.index');
    Route::middleware('role:super_admin,admin_cms,editor_akademik')->group(function () {
        Route::get('/majors/create', [AdminController::class, 'majorCreate'])->name('majors.create');
        Route::post('/majors', [AdminController::class, 'majorStore'])->name('majors.store');
        Route::get('/majors/{id}/edit', [AdminController::class, 'majorEdit'])->name('majors.edit');
        Route::post('/majors/{id}', [AdminController::class, 'majorUpdate'])->name('majors.update');
        Route::delete('/majors/{id}', [AdminController::class, 'majorDelete'])->name('majors.delete');
    });

    // 6.6 Modul PPDB Online
    // Read (Index, Show): super_admin, admin_ppdb, admin_cms
    Route::middleware('role:super_admin,admin_ppdb,admin_cms')->group(function () {
        Route::get('/ppdb', [AdminController::class, 'ppdbIndex'])->name('ppdb.index');
        Route::get('/ppdb/export', [AdminController::class, 'ppdbExportCsv'])
            ->name('ppdb.export')
            ->middleware('role:super_admin,admin_ppdb');
        Route::get('/ppdb/{id}', [AdminController::class, 'ppdbShow'])->name('ppdb.show');
        Route::post('/ppdb/{id}/status', [AdminController::class, 'ppdbUpdateStatus'])
            ->name('ppdb.status')
            ->middleware('role:super_admin,admin_ppdb');
    });
    // Delete PPDB: KHUSUS super_admin (admin_ppdb tidak diizinkan menghapus)
    Route::delete('/ppdb/{id}', [AdminController::class, 'ppdbDelete'])
        ->name('ppdb.delete')
        ->middleware('role:super_admin');
});