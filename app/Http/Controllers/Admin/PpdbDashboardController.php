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
            'pending' => PpdbRegistration::where('status', 'pending')->count(),
            'diverifikasi' => PpdbRegistration::where('status', 'diverifikasi')->count(),
            'diterima' => PpdbRegistration::where('status', 'diterima')->count(),
            'ditolak' => PpdbRegistration::where('status', 'ditolak')->count(),
            'docs_unverified' => PpdbDocument::where('verification_status', 'belum_diverifikasi')->count(),
            'docs_valid' => PpdbDocument::where('verification_status', 'valid')->count(),
        ];

        $pendingRegistrations = PpdbRegistration::with('documents')
            ->where('status', 'pending')
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
