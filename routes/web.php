<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AdminController;

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
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Berita (CMS)
    Route::get('/news', [AdminController::class, 'newsIndex'])->name('news.index');
    Route::get('/news/create', [AdminController::class, 'newsCreate'])->name('news.create');
    Route::post('/news', [AdminController::class, 'newsStore'])->name('news.store');
    Route::get('/news/{id}/edit', [AdminController::class, 'newsEdit'])->name('news.edit');
    Route::post('/news/{id}', [AdminController::class, 'newsUpdate'])->name('news.update');
    Route::delete('/news/{id}', [AdminController::class, 'newsDelete'])->name('news.delete');

    // Guru & Staf (Akademik)
    Route::get('/teachers', [AdminController::class, 'teacherIndex'])->name('teachers.index');
    Route::get('/teachers/create', [AdminController::class, 'teacherCreate'])->name('teachers.create');
    Route::post('/teachers', [AdminController::class, 'teacherStore'])->name('teachers.store');
    Route::get('/teachers/{id}/edit', [AdminController::class, 'teacherEdit'])->name('teachers.edit');
    Route::post('/teachers/{id}', [AdminController::class, 'teacherUpdate'])->name('teachers.update');
    Route::delete('/teachers/{id}', [AdminController::class, 'teacherDelete'])->name('teachers.delete');

    // PPDB Online (PPDB)
    Route::get('/ppdb', [AdminController::class, 'ppdbIndex'])->name('ppdb.index');
    Route::get('/ppdb/export', [AdminController::class, 'ppdbExportCsv'])->name('ppdb.export');
    Route::get('/ppdb/{id}', [AdminController::class, 'ppdbShow'])->name('ppdb.show');
    Route::post('/ppdb/{id}/status', [AdminController::class, 'ppdbUpdateStatus'])->name('ppdb.status');
    Route::post('/ppdb/document/{id}/verify', [AdminController::class, 'ppdbDocumentVerify'])->name('ppdb.document.verify');
    Route::delete('/ppdb/{id}', [AdminController::class, 'ppdbDelete'])->name('ppdb.delete');

    // Jurusan (CMS / Akademik)
    Route::get('/majors', [AdminController::class, 'majorIndex'])->name('majors.index');
    Route::get('/majors/create', [AdminController::class, 'majorCreate'])->name('majors.create');
    Route::post('/majors', [AdminController::class, 'majorStore'])->name('majors.store');
    Route::get('/majors/{id}/edit', [AdminController::class, 'majorEdit'])->name('majors.edit');
    Route::post('/majors/{id}', [AdminController::class, 'majorUpdate'])->name('majors.update');
    Route::delete('/majors/{id}', [AdminController::class, 'majorDelete'])->name('majors.delete');

    // Galeri Foto (CMS)
    Route::get('/galleries', [AdminController::class, 'galleryIndex'])->name('galleries.index');
    Route::get('/galleries/create', [AdminController::class, 'galleryCreate'])->name('galleries.create');
    Route::post('/galleries', [AdminController::class, 'galleryStore'])->name('galleries.store');
    Route::delete('/galleries/{id}', [AdminController::class, 'galleryDelete'])->name('galleries.delete');

    // Pengumuman (Pengumuman & Agenda)
    Route::get('/announcements', [AdminController::class, 'announcementIndex'])->name('announcements.index');
    Route::get('/announcements/create', [AdminController::class, 'announcementCreate'])->name('announcements.create');
    Route::post('/announcements', [AdminController::class, 'announcementStore'])->name('announcements.store');
    Route::get('/announcements/{id}/edit', [AdminController::class, 'announcementEdit'])->name('announcements.edit');
    Route::post('/announcements/{id}', [AdminController::class, 'announcementUpdate'])->name('announcements.update');
    Route::delete('/announcements/{id}', [AdminController::class, 'announcementDelete'])->name('announcements.delete');

    // Agenda Kegiatan (Pengumuman & Agenda)
    Route::get('/agenda', [AdminController::class, 'agendaIndex'])->name('agenda.index');
    Route::get('/agenda/create', [AdminController::class, 'agendaCreate'])->name('agenda.create');
    Route::post('/agenda', [AdminController::class, 'agendaStore'])->name('agenda.store');
    Route::get('/agenda/{id}/edit', [AdminController::class, 'agendaEdit'])->name('agenda.edit');
    Route::post('/agenda/{id}', [AdminController::class, 'agendaUpdate'])->name('agenda.update');
    Route::delete('/agenda/{id}', [AdminController::class, 'agendaDelete'])->name('agenda.delete');

    // Pengguna Admin (Super Admin Only)
    Route::get('/users', [AdminController::class, 'userIndex'])->name('users.index');
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::post('/users/{id}/role', [AdminController::class, 'userUpdateRole'])->name('users.role');
    Route::post('/users/{id}/toggle-active', [AdminController::class, 'userToggleActive'])->name('users.toggle-active');
    Route::delete('/users/{id}', [AdminController::class, 'userDelete'])->name('users.delete');
});