<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\PpdbController;
use App\Models\News;
use App\Models\TeacherStaff;
use App\Models\PpdbRegistration;
use App\Models\Major;
use App\Models\ActivityLog;

/**
 * AdminController (Legacy facade & centralized routing forwarder)
 * 
 * Logika modul telah dipecah ke controller modular tersendiri:
 * - NewsController    -> App\Http\Controllers\Admin\NewsController
 * - TeacherController -> App\Http\Controllers\Admin\TeacherController
 * - MajorController   -> App\Http\Controllers\Admin\MajorController
 * - PpdbController    -> App\Http\Controllers\Admin\PpdbController
 */
class AdminController extends Controller
{
    /**
     * Dashboard ringkas admin
     */
    public function dashboard()
    {
        $stats = [
            'news' => News::count(),
            'teachers' => TeacherStaff::count(),
            'ppdb' => PpdbRegistration::count(),
            'majors' => Major::count(),
        ];

        $recentLogs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $ppdbPending = PpdbRegistration::where('status', 'pending')->count();

        return view('admin.dashboard', compact('stats', 'recentLogs', 'ppdbPending'));
    }

    // ==========================================
    // MODUL BERITA (Forwarding ke NewsController)
    // ==========================================
    public function newsIndex() { return app(NewsController::class)->index(); }
    public function newsCreate() { return app(NewsController::class)->create(); }
    public function newsStore(Request $request) { return app(NewsController::class)->store($request); }
    public function newsEdit($id) { return app(NewsController::class)->edit($id); }
    public function newsUpdate(Request $request, $id) { return app(NewsController::class)->update($request, $id); }
    public function newsDelete($id) { return app(NewsController::class)->destroy($id); }

    // ==========================================
    // MODUL GURU (Forwarding ke TeacherController)
    // ==========================================
    public function teacherIndex() { return app(TeacherController::class)->index(); }
    public function teacherCreate() { return app(TeacherController::class)->create(); }
    public function teacherStore(Request $request) { return app(TeacherController::class)->store($request); }
    public function teacherEdit($id) { return app(TeacherController::class)->edit($id); }
    public function teacherUpdate(Request $request, $id) { return app(TeacherController::class)->update($request, $id); }
    public function teacherDelete($id) { return app(TeacherController::class)->destroy($id); }

    // ==========================================
    // MODUL PPDB (Forwarding ke PpdbController)
    // ==========================================
    public function ppdbIndex(Request $request) { return app(PpdbController::class)->index($request); }
    public function ppdbExportCsv(Request $request) { return app(PpdbController::class)->exportCsv($request); }
    public function ppdbShow($id) { return app(PpdbController::class)->show($id); }
    public function ppdbUpdateStatus(Request $request, $id) { return app(PpdbController::class)->updateStatus($request, $id); }
    public function ppdbDelete($id) { return app(PpdbController::class)->destroy($id); }

    // ==========================================
    // MODUL JURUSAN (Forwarding ke MajorController)
    // ==========================================
    public function majorIndex() { return app(MajorController::class)->index(); }
    public function majorCreate() { return app(MajorController::class)->create(); }
    public function majorStore(Request $request) { return app(MajorController::class)->store($request); }
    public function majorEdit($id) { return app(MajorController::class)->edit($id); }
    public function majorUpdate(Request $request, $id) { return app(MajorController::class)->update($request, $id); }
    public function majorDelete($id) { return app(MajorController::class)->destroy($id); }
}
