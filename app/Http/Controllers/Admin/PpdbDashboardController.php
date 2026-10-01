<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\PpdbDocument;
use Illuminate\Http\Request;

class PpdbDashboardController extends Controller
{
    /**
     * Dashboard Khusus Admin PPDB:
     * Menampilkan statistik pendaftar per status seleksi,
     * antrean pendaftar yang membutuhkan verifikasi, dan shortcut ekspor CSV.
     */
    public function index()
    {
        $stats = [
            'total' => PpdbRegistration::count(),
            'pending' => PpdbRegistration::pending()->count(),
            'diverifikasi' => PpdbRegistration::status('diverifikasi')->count(),
            'diterima' => PpdbRegistration::status('diterima')->count(),
            'ditolak' => PpdbRegistration::status('ditolak')->count(),
            'docs_unverified' => PpdbDocument::unverified()->count(),
            'docs_valid' => PpdbDocument::verified()->count(),
            'sd_total' => PpdbRegistration::jenjang('sd')->count(),
            'smp_total' => PpdbRegistration::jenjang('smp')->count(),
            'smk_total' => PpdbRegistration::jenjang('smk')->count(),
        ];

        $pendingRegistrations = PpdbRegistration::with('documents')
            ->pending()
            ->orderBy('created_at', 'asc')
            ->limit(8)
            ->get();

        $recentRegistrations = PpdbRegistration::with('documents')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('admin.dashboards.ppdb', compact('stats', 'pendingRegistrations', 'recentRegistrations'));
    }
}
