<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\Announcement;

// 3.3.3 Modul Pengumuman & Agenda:
// Pengumuman publik; is_archived diset otomatis via scheduler saat end_date lewat
Schedule::call(function () {
    Announcement::whereNotNull('end_date')
        ->where('end_date', '<', now()->toDateString())
        ->where('is_archived', false)
        ->update(['is_archived' => true]);
})->daily()->name('archive-expired-announcements');

