<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\TeacherStaff;
use App\Models\PpdbRegistration;
use App\Models\PpdbDocument;
use App\Models\Major;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Agenda;
use App\Models\Gallery;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    protected function authorizeAction(bool $condition, string $message = 'Akses ditolak. Anda tidak memiliki izin untuk tindakan ini.')
    {
        if (!$condition) {
            abort(403, $message);
        }
    }

    protected function logActivity($module, $action, $description)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => $module,
            'action' => $action,
            'description' => $description,
        ]);
    }

    /**
     * Dashboard Panel Admin
     */
    public function dashboard()
    {
        $stats = [
            'news' => News::count(),
            'teachers' => TeacherStaff::count(),
            'ppdb' => PpdbRegistration::count(),
            'majors' => Major::count(),
            'announcements' => Announcement::count(),
            'agenda' => Agenda::count(),
            'galleries' => Gallery::count(),
            'users' => User::count(),
        ];

        $recentLogs = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $ppdbPending = PpdbRegistration::where('status', 'pending')->count();

        return view('admin.dashboard', compact('stats', 'recentLogs', 'ppdbPending'));
    }

    /**
     * ==========================================
     * MODUL BERITA (CMS)
     * ==========================================
     */
    public function newsIndex()
    {
        $newsList = News::with(['category', 'author'])->orderBy('created_at', 'desc')->get();
        return view('admin.news.index', compact('newsList'));
    }

    public function newsCreate()
    {
        $this->authorizeAction(Auth::user()->canManageCms());

        $categories = NewsCategory::all();
        // Fallback category if none exist
        if ($categories->isEmpty()) {
            $defaultCat = NewsCategory::create(['name' => 'Umum', 'slug' => 'umum']);
            $categories = collect([$defaultCat]);
        }
        return view('admin.news.create', compact('categories'));
    }

    public function newsStore(Request $request)
    {
        $this->authorizeAction(Auth::user()->canManageCms());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required|string',
            'thumbnail' => 'nullable|string', // Simple url/path string
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        $validated['author_id'] = Auth::id();

        $news = News::create($validated);

        $this->logActivity('berita', 'create', "Membuat berita baru: '{$news->title}'");

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    public function newsEdit($id)
    {
        $this->authorizeAction(Auth::user()->canManageCms());

        $news = News::findOrFail($id);
        $categories = NewsCategory::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function newsUpdate(Request $request, $id)
    {
        $this->authorizeAction(Auth::user()->canManageCms());

        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required|string',
            'thumbnail' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        if ($news->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        }

        $news->update($validated);

        $this->logActivity('berita', 'update', "Mengubah berita: '{$news->title}'");

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function newsDelete($id)
    {
        $this->authorizeAction(Auth::user()->canManageCms());

        $news = News::findOrFail($id);
        $title = $news->title;
        $news->delete();

        $this->logActivity('berita', 'delete', "Menghapus berita: '{$title}'");

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus!');
    }

    /**
     * ==========================================
     * MODUL GURU & STAF (AKADEMIK)
     * ==========================================
     */
    public function teacherIndex()
    {
        $teachers = TeacherStaff::orderBy('name', 'asc')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function teacherCreate()
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());
        return view('admin.teachers.create');
    }

    public function teacherStore(Request $request)
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'photo' => 'nullable|string',
            'nip' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $teacher = TeacherStaff::create($validated);

        $this->logActivity('guru', 'create', "Menambah data guru/staf: '{$teacher->name}'");

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru/staf berhasil ditambahkan!');
    }

    public function teacherEdit($id)
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());
        $teacher = TeacherStaff::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function teacherUpdate(Request $request, $id)
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());
        $teacher = TeacherStaff::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'photo' => 'nullable|string',
            'nip' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $teacher->update($validated);

        $this->logActivity('guru', 'update', "Mengubah data guru/staf: '{$teacher->name}'");

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru/staf berhasil diperbarui!');
    }

    public function teacherDelete($id)
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());
        $teacher = TeacherStaff::findOrFail($id);
        $name = $teacher->name;
        $teacher->delete();

        $this->logActivity('guru', 'delete', "Menghapus data guru/staf: '{$name}'");

        return redirect()->route('admin.teachers.index')->with('success', 'Data guru/staf berhasil dihapus!');
    }

    /**
     * ==========================================
     * MODUL PPDB ONLINE (PPDB)
     * ==========================================
     */
    public function ppdbIndex()
    {
        $registrations = PpdbRegistration::orderBy('created_at', 'desc')->get();
        return view('admin.ppdb.index', compact('registrations'));
    }

    /**
     * Ekspor Data PPDB ke format CSV (FR-C06)
     */
    public function ppdbExportCsv()
    {
        $registrations = PpdbRegistration::orderBy('created_at', 'desc')->get();
        $filename = 'rekap-ppdb-' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');
            // Tambahkan UTF-8 BOM untuk kompatibilitas Excel (tidak rusak saat dibuka di Windows/Mac)
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header Kolom CSV
            fputcsv($file, [
                'No. Pendaftaran',
                'Nama Lengkap',
                'Jenis Kelamin',
                'Tanggal Lahir',
                'Alamat',
                'Nama Orang Tua / Wali',
                'No. HP Orang Tua',
                'Status Pendaftaran',
                'Catatan Panitia',
                'Tanggal Mendaftar'
            ], ';');

            // Data Baris
            foreach ($registrations as $reg) {
                fputcsv($file, [
                    $reg->no_pendaftaran,
                    $reg->full_name,
                    $reg->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                    $reg->birth_date ? $reg->birth_date->format('d/m/Y') : '-',
                    $reg->address,
                    $reg->parent_name,
                    $reg->parent_phone,
                    ucfirst($reg->status),
                    $reg->notes ?? '-',
                    $reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '-',
                ], ';');
            }

            fclose($file);
        };

        $this->logActivity('ppdb', 'export', 'Mengekspor seluruh rekap data pendaftar PPDB ke format file CSV');

        return response()->stream($callback, 200, $headers);
    }

    public function ppdbShow($id)
    {
        $registration = PpdbRegistration::with('documents')->findOrFail($id);
        return view('admin.ppdb.show', compact('registration'));
    }

    public function ppdbUpdateStatus(Request $request, $id)
    {
        $this->authorizeAction(Auth::user()->canManagePpdb());

        $registration = PpdbRegistration::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,diverifikasi,diterima,ditolak',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $registration->status;
        $registration->update($validated);

        $this->logActivity('ppdb', 'verify', "Mengubah status PPDB {$registration->no_pendaftaran} ({$registration->full_name}) dari {$oldStatus} ke {$validated['status']}");

        return redirect()->route('admin.ppdb.show', $id)->with('success', 'Status pendaftaran PPDB berhasil diperbarui!');
    }

    public function ppdbDocumentVerify(Request $request, $id)
    {
        $this->authorizeAction(Auth::user()->canManagePpdb());

        $doc = PpdbDocument::findOrFail($id);
        $validated = $request->validate([
            'verification_status' => 'required|in:belum_diverifikasi,valid,tidak_valid'
        ]);

        $doc->update($validated);

        $this->logActivity('ppdb', 'verify_document', "Memverifikasi dokumen {$doc->doc_type} pendaftar ID #{$doc->registration_id} menjadi: {$validated['verification_status']}");

        return back()->with('success', 'Status verifikasi dokumen berhasil diperbarui!');
    }

    public function ppdbDelete($id)
    {
        $this->authorizeAction(Auth::user()->canManagePpdb());

        $registration = PpdbRegistration::findOrFail($id);
        $noPendaftaran = $registration->no_pendaftaran;
        $fullName = $registration->full_name;
        $registration->delete();

        $this->logActivity('ppdb', 'delete', "Menghapus data PPDB {$noPendaftaran} ({$fullName})");

        return redirect()->route('admin.ppdb.index')->with('success', 'Data pendaftaran PPDB berhasil dihapus!');
    }

    /**
     * ==========================================
     * MODUL JURUSAN (AKADEMIK / CMS)
     * ==========================================
     */
    public function majorIndex()
    {
        $majors = Major::orderBy('name', 'asc')->get();
        return view('admin.majors.index', compact('majors'));
    }

    public function majorCreate()
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());
        return view('admin.majors.create');
    }

    public function majorStore(Request $request)
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $major = Major::create($validated);

        $this->logActivity('jurusan', 'create', "Menambah jurusan baru: '{$major->name}'");

        return redirect()->route('admin.majors.index')->with('success', 'Jurusan baru berhasil ditambahkan!');
    }

    public function majorEdit($id)
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());
        $major = Major::findOrFail($id);
        return view('admin.majors.edit', compact('major'));
    }

    public function majorUpdate(Request $request, $id)
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());
        $major = Major::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        if ($major->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $major->update($validated);

        $this->logActivity('jurusan', 'update', "Mengubah jurusan: '{$major->name}'");

        return redirect()->route('admin.majors.index')->with('success', 'Data jurusan berhasil diperbarui!');
    }

    public function majorDelete($id)
    {
        $this->authorizeAction(Auth::user()->canManageAcademic());
        $major = Major::findOrFail($id);
        $name = $major->name;
        $major->delete();

        $this->logActivity('jurusan', 'delete', "Menghapus jurusan: '{$name}'");

        return redirect()->route('admin.majors.index')->with('success', 'Jurusan berhasil dihapus!');
    }

    /**
     * ==========================================
     * MODUL PENGGUNA ADMIN (Super Admin Only)
     * ==========================================
     */
    public function userIndex()
    {
        $this->authorizeAction(Auth::user()->canManageUsers());

        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function userStore(Request $request)
    {
        $this->authorizeAction(Auth::user()->canManageUsers());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:super_admin,admin_cms,admin_ppdb,editor_akademik',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        $this->logActivity('pengguna', 'create', "Menambahkan akun admin: {$user->name} ({$user->role})");

        return redirect()->route('admin.users.index')->with('success', 'Pengguna admin baru berhasil ditambahkan!');
    }

    public function userUpdateRole(Request $request, $id)
    {
        $this->authorizeAction(Auth::user()->canManageUsers());

        $user = User::findOrFail($id);
        $validated = $request->validate([
            'role' => 'required|in:super_admin,admin_cms,admin_ppdb,editor_akademik',
        ]);

        $oldRole = $user->role;
        $user->update(['role' => $validated['role']]);

        $this->logActivity('pengguna', 'update', "Mengubah role pengguna {$user->name} dari {$oldRole} ke {$validated['role']}");

        return redirect()->route('admin.users.index')->with('success', 'Peran (role) pengguna berhasil diubah!');
    }

    public function userToggleActive($id)
    {
        $this->authorizeAction(Auth::user()->canManageUsers());

        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusStr = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->logActivity('pengguna', 'toggle_active', "Akun pengguna {$user->name} {$statusStr}");

        return redirect()->route('admin.users.index')->with('success', "Akun {$user->name} berhasil {$statusStr}!");
    }

    public function userDelete($id)
    {
        $this->authorizeAction(Auth::user()->canManageUsers());

        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $userName = $user->name;
        $user->delete();

        $this->logActivity('pengguna', 'delete', "Menghapus akun pengguna admin: {$userName}");

        return redirect()->route('admin.users.index')->with('success', "Akun {$userName} berhasil dihapus!");
    }

    /**
     * ==========================================
     * MODUL PENGUMUMAN (Super Admin & Admin CMS)
     * ==========================================
     */
    public function announcementIndex()
    {
        $announcements = Announcement::with('creator')->orderBy('start_date', 'desc')->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function announcementCreate()
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());
        return view('admin.announcements.create');
    }

    public function announcementStore(Request $request)
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_archived'] = false;

        $announcement = Announcement::create($validated);

        $this->logActivity('pengumuman', 'create', "Membuat pengumuman baru: '{$announcement->title}'");

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dipublikasikan!');
    }

    public function announcementEdit($id)
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());
        $announcement = Announcement::findOrFail($id);
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function announcementUpdate(Request $request, $id)
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());

        $announcement = Announcement::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['is_archived'] = $request->has('is_archived');
        $announcement->update($validated);

        $this->logActivity('pengumuman', 'update', "Mengubah pengumuman: '{$announcement->title}'");

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function announcementDelete($id)
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());

        $announcement = Announcement::findOrFail($id);
        $title = $announcement->title;
        $announcement->delete();

        $this->logActivity('pengumuman', 'delete', "Menghapus pengumuman: '{$title}'");

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus!');
    }

    /**
     * ==========================================
     * MODUL AGENDA (Super Admin & Admin CMS)
     * ==========================================
     */
    public function agendaIndex()
    {
        $agendas = Agenda::with('creator')->orderBy('date', 'desc')->get();
        return view('admin.agenda.index', compact('agendas'));
    }

    public function agendaCreate()
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());
        return view('admin.agenda.create');
    }

    public function agendaStore(Request $request)
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['created_by'] = Auth::id();

        $agenda = Agenda::create($validated);

        $this->logActivity('agenda', 'create', "Menambah agenda baru: '{$agenda->title}'");

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan berhasil ditambahkan!');
    }

    public function agendaEdit($id)
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());
        $agenda = Agenda::findOrFail($id);
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function agendaUpdate(Request $request, $id)
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());

        $agenda = Agenda::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $agenda->update($validated);

        $this->logActivity('agenda', 'update', "Mengubah agenda: '{$agenda->title}'");

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan berhasil diperbarui!');
    }

    public function agendaDelete($id)
    {
        $this->authorizeAction(Auth::user()->canManageAnnouncements());

        $agenda = Agenda::findOrFail($id);
        $title = $agenda->title;
        $agenda->delete();

        $this->logActivity('agenda', 'delete', "Menghapus agenda: '{$title}'");

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan berhasil dihapus!');
    }

    /**
     * ==========================================
     * MODUL GALERI (Super Admin & Admin CMS)
     * ==========================================
     */
    public function galleryIndex()
    {
        $galleries = Gallery::with('uploader')->orderBy('created_at', 'desc')->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function galleryCreate()
    {
        $this->authorizeAction(Auth::user()->canManageCms());
        return view('admin.galleries.create');
    }

    public function galleryStore(Request $request)
    {
        $this->authorizeAction(Auth::user()->canManageCms());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'image_path' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $imagePath = $validated['image_path'] ?? null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('galleries', 'public');
            $imagePath = 'storage/' . $path;
        }

        if (!$imagePath) {
            return back()->with('error', 'Silakan masukkan URL gambar atau unggah file foto!')->withInput();
        }

        $gallery = Gallery::create([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? 'Kegiatan',
            'image_path' => $imagePath,
            'uploaded_by' => Auth::id(),
        ]);

        $this->logActivity('galeri', 'create', "Mengunggah foto galeri: '{$gallery->title}'");

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    public function galleryDelete($id)
    {
        $this->authorizeAction(Auth::user()->canManageCms());

        $gallery = Gallery::findOrFail($id);
        $title = $gallery->title;
        $gallery->delete();

        $this->logActivity('galeri', 'delete', "Menghapus foto galeri: '{$title}'");

        return redirect()->route('admin.galleries.index')->with('success', 'Foto galeri berhasil dihapus!');
    }
}
