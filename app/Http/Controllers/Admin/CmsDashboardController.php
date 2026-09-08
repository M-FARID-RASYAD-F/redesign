<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Announcement;
use App\Models\Agenda;
use Illuminate\Http\Request;

class CmsDashboardController extends Controller
{
    /**
     * Dashboard Khusus Admin CMS:
     * Menampilkan statistik berita & galeri, artikel publish vs draft,
     * agenda & pengumuman aktif vs kedaluwarsa, dan tombol aksi cepat.
     */
    public function index()
    {
        $today = now()->toDateString();

        $stats = [
            'total_news' => News::count(),
            'published_news' => News::whereNotNull('published_at')->where('published_at', '<=', now())->count(),
            'draft_news' => News::whereNull('published_at')->orWhere('published_at', '>', now())->count(),
            'total_galleries' => Gallery::count(),
            'active_announcements' => Announcement::where('is_archived', false)
                ->where('start_date', '<=', $today)
                ->where(function ($q) use ($today) {
                    $q->whereNull('end_date')->orWhere('end_date', '>=', $today);
                })->count(),
            'expired_announcements' => Announcement::where('is_archived', true)
                ->orWhere(function ($q) use ($today) {
                    $q->whereNotNull('end_date')->where('end_date', '<', $today);
                })->count(),
            'upcoming_agendas' => Agenda::where('date', '>=', $today)->count(),
            'past_agendas' => Agenda::where('date', '<', $today)->count(),
        ];

        $recentNews = News::with('category')->latest()->limit(5)->get();
        $recentGalleries = Gallery::latest()->limit(6)->get();
        $recentAnnouncements = Announcement::latest()->limit(4)->get();
        $upcomingAgendas = Agenda::where('date', '>=', $today)->orderBy('date', 'asc')->limit(4)->get();

        return view('admin.dashboards.cms', compact('stats', 'recentNews', 'recentGalleries', 'recentAnnouncements', 'upcomingAgendas'));
    }
}
