<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherStaff;
use App\Models\Major;
use Illuminate\Http\Request;

class AkademikDashboardController extends Controller
{
    /**
     * Dashboard Khusus Editor Akademik:
     * Menampilkan metrik data guru & staf, program kejuruan,
     * serta tombol shortcut pengelolaan kurikulum/akademik.
     */
    public function index()
    {
        $stats = [
            'total_teachers' => TeacherStaff::count(),
            'active_teachers' => TeacherStaff::where('status', 'aktif')->count(),
            'inactive_teachers' => TeacherStaff::where('status', 'nonaktif')->count(),
            'total_majors' => Major::count(),
        ];

        $teachers = TeacherStaff::latest()->limit(6)->get();
        $majors = Major::all();

        return view('admin.dashboards.akademik', compact('stats', 'teachers', 'majors'));
    }
}
