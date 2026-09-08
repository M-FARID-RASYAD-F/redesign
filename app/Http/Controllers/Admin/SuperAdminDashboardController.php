<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\News;
use App\Models\TeacherStaff;
use App\Models\Major;
use App\Models\PpdbRegistration;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    /**
     * Dashboard Khusus Super Admin:
     * Menampilkan ringkasan holistik semua modul, audit logs terbaru,
     * status pendaftar PPDB, dan shortcut kelola akun admin.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        if ($user && ! $user->isSuperAdmin()) {
            return redirect($user->dashboard_url);
        }

        $stats = [
            'total_users' => User::where('is_active', true)->count(),
            'total_news' => News::count(),
            'total_teachers' => TeacherStaff::count(),
            'total_majors' => Major::count(),
            'total_ppdb' => PpdbRegistration::count(),
            'ppdb_pending' => PpdbRegistration::where('status', 'pending')->count(),
            'ppdb_diverifikasi' => PpdbRegistration::where('status', 'diverifikasi')->count(),
            'ppdb_diterima' => PpdbRegistration::where('status', 'diterima')->count(),
            'ppdb_ditolak' => PpdbRegistration::where('status', 'ditolak')->count(),
        ];

        $recentLogs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboards.superadmin', compact('stats', 'recentLogs', 'recentUsers'));
    }
}
