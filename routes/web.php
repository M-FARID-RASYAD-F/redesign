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

// 2. Route Memproses Form Kontak / Pendaftaran
Route::post('/kontak', [SchoolController::class, 'submitContact'])->name('kontak.submit');

// 3. Route Login Guru (Mengarahkan ke Halaman Login Filament)
Route::get('/login', function () {
    return redirect('/portal/login');
})->name('login');

// 4. Route Logout Guru
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Anda telah berhasil Logout dari sistem.');
})->name('logout');

// 5. Route Group Admin
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
    Route::get('/ppdb/{id}', [AdminController::class, 'ppdbShow'])->name('ppdb.show');
    Route::post('/ppdb/{id}/status', [AdminController::class, 'ppdbUpdateStatus'])->name('ppdb.status');
    Route::delete('/ppdb/{id}', [AdminController::class, 'ppdbDelete'])->name('ppdb.delete');

    // Jurusan (CMS / Akademik)
    Route::get('/majors', [AdminController::class, 'majorIndex'])->name('majors.index');
    Route::get('/majors/create', [AdminController::class, 'majorCreate'])->name('majors.create');
    Route::post('/majors', [AdminController::class, 'majorStore'])->name('majors.store');
    Route::get('/majors/{id}/edit', [AdminController::class, 'majorEdit'])->name('majors.edit');
    Route::post('/majors/{id}', [AdminController::class, 'majorUpdate'])->name('majors.update');
    Route::delete('/majors/{id}', [AdminController::class, 'majorDelete'])->name('majors.delete');
});