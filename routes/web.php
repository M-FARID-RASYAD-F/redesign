<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\SchoolController;

/*
|--------------------------------------------------------------------------
| Web Routes - Website Sekolah (Contoh Pembelajaran Laravel)
|--------------------------------------------------------------------------
*/

// 1. Route Halaman Utama Landing Page Sekolah
Route::get('/', [SchoolController::class, 'index'])->name('home');

// 2. Route Memproses Form Kontak / Pendaftaran
Route::post('/kontak', [SchoolController::class, 'submitContact'])->name('kontak.submit');

// 3. Route Simulasi Login Guru (Auth untuk Edukasi Siswa)
Route::get('/login', function () {
    $user = User::firstOrCreate(
        ['email' => 'budi.guru@sekolah.sch.id'],
        [
            'name' => 'Budi Santoso, S.Pd. (Guru)',
            'password' => bcrypt('password123'),
        ]
    );

    Auth::login($user);
    return redirect('/')->with('success', 'Berhasil Login sebagai Guru: Budi Santoso, S.Pd.!');
})->name('login');

// 4. Route Logout Guru
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Anda telah berhasil Logout dari sistem.');
})->name('logout');