<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\TeacherStaff;
use App\Models\PpdbRegistration;
use App\Models\PpdbDocument;
use App\Models\Major;
use App\Models\ActivityLog;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    protected function logActivity($module, $action, $description)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required|string',
            'thumbnail' => 'nullable|string', // Simple url/path string
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        $validated['author_id'] = auth()->id();

        $news = News::create($validated);

        $this->logActivity('berita', 'create', "Membuat berita baru: '{$news->title}'");

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    public function newsEdit($id)
    {
        $news = News::findOrFail($id);
        $categories = NewsCategory::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function newsUpdate(Request $request, $id)
    {
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
        return view('admin.teachers.create');
    }

    public function teacherStore(Request $request)
    {
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
        $teacher = TeacherStaff::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function teacherUpdate(Request $request, $id)
    {
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

    public function ppdbShow($id)
    {
        $registration = PpdbRegistration::with('documents')->findOrFail($id);
        return view('admin.ppdb.show', compact('registration'));
    }

    public function ppdbUpdateStatus(Request $request, $id)
    {
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

    public function ppdbDelete($id)
    {
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
        return view('admin.majors.create');
    }

    public function majorStore(Request $request)
    {
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
        $major = Major::findOrFail($id);
        return view('admin.majors.edit', compact('major'));
    }

    public function majorUpdate(Request $request, $id)
    {
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
        $major = Major::findOrFail($id);
        $name = $major->name;
        $major->delete();

        $this->logActivity('jurusan', 'delete', "Menghapus jurusan: '{$name}'");

        return redirect()->route('admin.majors.index')->with('success', 'Jurusan berhasil dihapus!');
    }
}
