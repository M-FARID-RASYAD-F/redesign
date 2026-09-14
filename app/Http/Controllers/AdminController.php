<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\PpdbDocument;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\TeacherStaff;
use App\Models\PpdbRegistration;
use App\Models\Major;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use ZipArchive;

class AdminController extends Controller
{
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
     * ==========================================
     * MODUL BERITA (CMS)
     * ==========================================
     */
    public function newsIndex()
    {
        $newsList = News::with(['category', 'author'])->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
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
        $validated['author_id'] = Auth::id();

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
        $teachers = TeacherStaff::orderBy('name', 'asc')->paginate(15)->withQueryString();
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
    public function ppdbIndex(Request $request)
    {
        $currentJenjang = strtolower($request->query('jenjang', ''));
        $currentStatus = strtolower($request->query('status', ''));
        $query = PpdbRegistration::query();

        if (in_array($currentJenjang, ['sd', 'smp', 'smk'])) {
            $query->where('jenjang', $currentJenjang);
        } else {
            $currentJenjang = 'all';
        }

        if (in_array($currentStatus, ['pending', 'diverifikasi', 'diterima', 'ditolak'])) {
            $query->where('status', $currentStatus);
        } else {
            $currentStatus = 'all';
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        // Agregasi jumlah pendaftar per jenjang dalam 1 query cepat
        $jenjangAgg = PpdbRegistration::select('jenjang', DB::raw('count(*) as total'))
            ->groupBy('jenjang')
            ->pluck('total', 'jenjang');

        $counts = [
            'all' => $jenjangAgg->sum(),
            'sd'  => (int) ($jenjangAgg->get('sd') ?? 0),
            'smp' => (int) ($jenjangAgg->get('smp') ?? 0),
            'smk' => (int) ($jenjangAgg->get('smk') ?? 0),
        ];

        // Agregasi jumlah status pendaftar berdasarkan jenjang terpilih dalam 1 query cepat
        $statusQuery = PpdbRegistration::select('status', DB::raw('count(*) as total'));
        if ($currentJenjang !== 'all') {
            $statusQuery->where('jenjang', $currentJenjang);
        }
        $statusAgg = $statusQuery->groupBy('status')->pluck('total', 'status');

        $statusCounts = [
            'all'          => $statusAgg->sum(),
            'pending'      => (int) ($statusAgg->get('pending') ?? 0),
            'diverifikasi' => (int) ($statusAgg->get('diverifikasi') ?? 0),
            'diterima'     => (int) ($statusAgg->get('diterima') ?? 0),
            'ditolak'      => (int) ($statusAgg->get('ditolak') ?? 0),
        ];

        return view('admin.ppdb.index', compact('registrations', 'currentJenjang', 'currentStatus', 'counts', 'statusCounts'));
    }

    /**
     * Ekspor Data PPDB ke format CSV (FR-C06)
     */
    public function ppdbExportCsv(Request $request)
    {
        $currentJenjang = strtolower($request->query('jenjang', ''));
        $currentStatus = strtolower($request->query('status', ''));
        $query = PpdbRegistration::query();

        $suffixParts = [];

        if (in_array($currentJenjang, ['sd', 'smp', 'smk'])) {
            $query->where('jenjang', $currentJenjang);
            $suffixParts[] = $currentJenjang;
        } else {
            $currentJenjang = 'all';
        }

        if (in_array($currentStatus, ['pending', 'diverifikasi', 'diterima', 'ditolak'])) {
            $query->where('status', $currentStatus);
            $suffixParts[] = $currentStatus;
        } else {
            $currentStatus = 'all';
        }

        $suffix = !empty($suffixParts) ? '-' . implode('-', $suffixParts) : '-semua-data';

        $registrations = $query->orderBy('created_at', 'desc')->get();
        $filename = 'rekap-ppdb' . $suffix . '-' . date('Y-m-d_His') . '.csv';

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
                'Jenjang Pendidikan',
                'Jurusan (SMK)',
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
                    $reg->jenjang_label,
                    $reg->major_choice ?? '-',
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

        $this->logActivity('ppdb', 'export', 'Mengekspor rekap data pendaftar PPDB ke format file CSV');

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Ekspor Data & Seluruh Berkas Persyaratan Siswa ke format ZIP (Per Siswa 1 Folder)
     */
    public function ppdbExportZip(Request $request)
    {
        $currentJenjang = strtolower($request->query('jenjang', ''));
        $currentStatus = strtolower($request->query('status', ''));
        $query = PpdbRegistration::with('documents');

        $suffixParts = [];

        if (in_array($currentJenjang, ['sd', 'smp', 'smk'])) {
            $query->where('jenjang', $currentJenjang);
            $suffixParts[] = $currentJenjang;
        } else {
            $currentJenjang = 'all';
        }

        if (in_array($currentStatus, ['pending', 'diverifikasi', 'diterima', 'ditolak'])) {
            $query->where('status', $currentStatus);
            $suffixParts[] = $currentStatus;
        } else {
            $currentStatus = 'all';
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();

        if ($registrations->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data pendaftar yang sesuai dengan filter yang dipilih untuk diekspor ke ZIP.');
        }

        $suffix = !empty($suffixParts) ? '-' . implode('-', $suffixParts) : '-semua-tingkat';
        $downloadFileName = 'rekap-berkas-ppdb' . $suffix . '-' . date('Y-m-d_His') . '.zip';

        // Pastikan folder temporary di storage tersedia
        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipPath = $tempDir . '/' . uniqid('ppdb_zip_', true) . '.zip';
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error', 'Gagal menginisialisasi pembuatan file kompresi ZIP.');
        }

        foreach ($registrations as $reg) {
            // Bersihkan nama siswa untuk penamaan folder yang aman di seluruh OS
            $cleanName = preg_replace('/[^\w\s\-]/u', '', $reg->full_name);
            $cleanName = trim(preg_replace('/\s+/', ' ', $cleanName));
            $folderName = $reg->no_pendaftaran . ' - ' . $cleanName;

            // 1. Tambahkan Formulir Pendaftaran HTML Berdesain Resmi & Siap Cetak
            $htmlContent = view('admin.ppdb.summary-export', compact('reg'))->render();
            $zip->addFromString($folderName . '/Formulir_Pendaftaran.html', $htmlContent);

            // 2. Tambahkan Ringkasan Teks Cepat
            $txtContent = "=====================================================\n";
            $txtContent .= "  RINGKASAN DATA PENDAFTARAN SISWA - PPDB ONLINE\n";
            $txtContent .= "  PKBM TAHFIZH AT-TAMAM (TAHUN AJARAN 2026/2027)\n";
            $txtContent .= "=====================================================\n\n";
            $txtContent .= "No. Pendaftaran        : " . $reg->no_pendaftaran . "\n";
            $txtContent .= "Tanggal Mendaftar      : " . ($reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '-') . " WIB\n";
            $txtContent .= "Jenjang Pendidikan     : " . $reg->jenjang_label . " (" . strtoupper($reg->jenjang) . ")\n";
            if ($reg->jenjang === 'smk') {
                $txtContent .= "Program Jurusan        : " . ($reg->major_choice ?: '-') . "\n";
            }
            $txtContent .= "Status Seleksi         : " . ucfirst($reg->status) . "\n";
            $txtContent .= "Catatan Panitia        : " . ($reg->notes ?: '-') . "\n\n";
            $txtContent .= "-----------------------------------------------------\n";
            $txtContent .= "BIODATA CALON SISWA\n";
            $txtContent .= "-----------------------------------------------------\n";
            $txtContent .= "Nama Lengkap           : " . $reg->full_name . "\n";
            $txtContent .= "Jenis Kelamin          : " . ($reg->gender === 'L' ? 'Laki-laki' : 'Perempuan') . "\n";
            $txtContent .= "Tanggal Lahir          : " . ($reg->birth_date ? $reg->birth_date->format('d/m/Y') : '-') . "\n";
            $txtContent .= "Alamat Domisili        : " . $reg->address . "\n\n";
            $txtContent .= "-----------------------------------------------------\n";
            $txtContent .= "DATA ORANG TUA / WALI\n";
            $txtContent .= "-----------------------------------------------------\n";
            $txtContent .= "Nama Orang Tua / Wali  : " . $reg->parent_name . "\n";
            $txtContent .= "Nomor HP / WhatsApp    : " . $reg->parent_phone . "\n\n";
            $txtContent .= "-----------------------------------------------------\n";
            $txtContent .= "STATUS BERKAS PERSYARATAN DI FOLDER INI\n";
            $txtContent .= "-----------------------------------------------------\n";

            $docsByTipe = $reg->documents->keyBy('doc_type');
            $docTypes = [
                'kk' => 'Kartu Keluarga (KK)',
                'akta_lahir' => 'Akta Kelahiran',
                'foto' => 'Pas Foto Formal (3x4)',
                'rapor_terakhir' => 'Rapor Pendidikan Terakhir',
            ];

            foreach ($docTypes as $type => $label) {
                $doc = $docsByTipe->get($type);
                $statusStr = $doc ? 'Dilampirkan' : 'Belum/Tidak Dilampirkan';
                $txtContent .= "- " . str_pad($label, 30) . ": " . $statusStr . "\n";
            }

            $zip->addFromString($folderName . '/Ringkasan_Data.txt', $txtContent);

            // 3. Masukkan Berkas Fisik Persyaratan yang Diunggah Siswa
            foreach ($reg->documents as $doc) {
                $filePath = $doc->file_path;
                $fileContent = null;

                if (Storage::disk('local')->exists($filePath)) {
                    $fileContent = Storage::disk('local')->get($filePath);
                } elseif (Storage::disk('public')->exists($filePath)) {
                    $fileContent = Storage::disk('public')->get($filePath);
                }

                if ($fileContent !== null) {
                    $ext = pathinfo($filePath, PATHINFO_EXTENSION) ?: 'pdf';
                    $cleanDocName = match ($doc->doc_type) {
                        'kk' => 'Berkas_Kartu_Keluarga.' . $ext,
                        'akta_lahir' => 'Berkas_Akta_Kelahiran.' . $ext,
                        'foto' => 'Pas_Foto.' . $ext,
                        'rapor_terakhir' => 'Berkas_Rapor_Terakhir.' . $ext,
                        default => 'Berkas_' . preg_replace('/[^\w\-]/', '_', $doc->doc_type) . '.' . $ext,
                    };

                    $zip->addFromString($folderName . '/' . $cleanDocName, $fileContent);
                }
            }
        }

        $zip->close();

        $this->logActivity('ppdb', 'export', 'Mengekspor rekap berkas pendaftar PPDB ke format file ZIP (' . count($registrations) . ' siswa)');

        return response()->download($zipPath, $downloadFileName)->deleteFileAfterSend(true);
    }

    public function ppdbShow($id)
    {
        $registration = PpdbRegistration::with('documents')->findOrFail($id);
        $majors = Major::all();
        return view('admin.ppdb.show', compact('registration', 'majors'));
    }

    /**
     * Membuka / Mengunduh Berkas Dokumen Persyaratan PPDB secara Aman (Private Disk)
     */
    public function ppdbViewDocument($id)
    {
        $document = PpdbDocument::findOrFail($id);

        if (!Auth::check() || !in_array(Auth::user()->role, ['super_admin', 'admin_ppdb', 'admin_cms'])) {
            abort(403, 'Anda tidak memiliki hak akses untuk membuka berkas persyaratan ini.');
        }

        $filePath = $document->file_path;

        // Cek penyimpanan private (local) terlebih dahulu
        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->response($filePath);
        }

        // Fallback untuk berkas lama yang masih tersimpan di storage/public
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->response($filePath);
        }

        abort(404, 'Berkas fisik dokumen tidak ditemukan di penyimpanan server.');
    }

    public function ppdbUpdateStatus(Request $request, $id)
    {
        $registration = PpdbRegistration::findOrFail($id);
        Gate::authorize('update', $registration);

        $validated = $request->validate([
            'status' => 'required|in:pending,diverifikasi,diterima,ditolak',
            'notes' => 'nullable|string',
            'jenjang' => 'nullable|in:sd,smp,smk',
            'major_choice' => 'nullable|string|max:100',
        ]);

        $oldStatus = $registration->status;
        $updateData = [
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ];

        if (!empty($validated['jenjang'])) {
            $updateData['jenjang'] = $validated['jenjang'];
            $updateData['major_choice'] = $validated['jenjang'] === 'smk' ? ($validated['major_choice'] ?? null) : null;
        }

        $registration->update($updateData);

        $this->logActivity('ppdb', 'verify', "Mengubah status PPDB {$registration->no_pendaftaran} ({$registration->full_name}) dari {$oldStatus} ke {$validated['status']}");

        return redirect()->route('admin.ppdb.show', $id)->with('success', 'Data & status pendaftaran PPDB berhasil diperbarui!');
    }

    public function ppdbDelete($id)
    {
        $registration = PpdbRegistration::findOrFail($id);
        Gate::authorize('delete', $registration);

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
