<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\LogsActivity;
use App\Models\PpdbRegistration;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PpdbController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $currentJenjang = strtolower($request->query('jenjang', ''));
        $query = PpdbRegistration::query();

        if (in_array($currentJenjang, ['sd', 'smp', 'smk'])) {
            $query->where('jenjang', $currentJenjang);
        } else {
            $currentJenjang = 'all';
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();

        $counts = [
            'all' => PpdbRegistration::count(),
            'sd'  => PpdbRegistration::where('jenjang', 'sd')->count(),
            'smp' => PpdbRegistration::where('jenjang', 'smp')->count(),
            'smk' => PpdbRegistration::where('jenjang', 'smk')->count(),
        ];

        return view('admin.ppdb.index', compact('registrations', 'currentJenjang', 'counts'));
    }

    public function exportCsv(Request $request)
    {
        $currentJenjang = strtolower($request->query('jenjang', ''));
        $query = PpdbRegistration::query();

        if (in_array($currentJenjang, ['sd', 'smp', 'smk'])) {
            $query->where('jenjang', $currentJenjang);
            $suffix = '-' . $currentJenjang;
        } else {
            $suffix = '-semua-jenjang';
        }

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
            // Tambahkan UTF-8 BOM untuk kompatibilitas Excel
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

    public function show($id)
    {
        $registration = PpdbRegistration::with('documents')->findOrFail($id);
        $majors = Major::all();
        return view('admin.ppdb.show', compact('registration', 'majors'));
    }

    public function updateStatus(Request $request, $id)
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

    public function destroy($id)
    {
        $registration = PpdbRegistration::findOrFail($id);
        Gate::authorize('delete', $registration);

        $noPendaftaran = $registration->no_pendaftaran;
        $fullName = $registration->full_name;
        $registration->delete();

        $this->logActivity('ppdb', 'delete', "Menghapus data PPDB {$noPendaftaran} ({$fullName})");

        return redirect()->route('admin.ppdb.index')->with('success', 'Data pendaftaran PPDB berhasil dihapus!');
    }

    // Aliases for backward compatibility
    public function ppdbIndex(Request $request) { return $this->index($request); }
    public function ppdbExportCsv(Request $request) { return $this->exportCsv($request); }
    public function ppdbShow($id) { return $this->show($id); }
    public function ppdbUpdateStatus(Request $request, $id) { return $this->updateStatus($request, $id); }
    public function ppdbDelete($id) { return $this->destroy($id); }
}
