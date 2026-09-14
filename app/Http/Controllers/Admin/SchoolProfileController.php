<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\LogsActivity;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;

class SchoolProfileController extends Controller
{
    use LogsActivity;

    /**
     * Tampilkan Halaman Pengaturan Profil & Cabang Sekolah (CMS)
     */
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'general');

        $general = SchoolProfile::getVal('general');
        $sambutan = SchoolProfile::getVal('sambutan');
        $cabang = SchoolProfile::getVal('cabang');
        $stats = SchoolProfile::getVal('stats');
        $ppdbStats = SchoolProfile::getVal('ppdb_stats', [
            'baseline_pendaftar' => 85,
            'baseline_diterima' => 60,
            'gelombang' => 'Gelombang II (Tahun Ajaran 2026/2027)',
            'deadline' => '30 Agustus 2026',
        ]);

        return view('admin.profile.index', compact('activeTab', 'general', 'sambutan', 'cabang', 'stats', 'ppdbStats'));
    }

    /**
     * Simpan Perubahan Pengaturan Profil / Cabang / Statistik
     */
    public function update(Request $request)
    {
        $section = $request->input('section');

        switch ($section) {
            case 'general':
                $validated = $request->validate([
                    'nama' => 'required|string|max:255',
                    'slogan' => 'required|string|max:255',
                    'deskripsi' => 'required|string',
                    'tahun_berdiri' => 'required|string|max:10',
                    'akreditasi' => 'required|string|max:50',
                    'alamat' => 'required|string',
                    'telepon' => 'required|string|max:50',
                    'email' => 'required|email|max:100',
                ]);
                SchoolProfile::setVal('general', $validated);
                $this->logActivity('profil', 'update', 'Memperbarui identitas dan kontak utama sekolah');
                return redirect()->route('admin.profile.index', ['tab' => 'general'])->with('success', 'Identitas sekolah berhasil disimpan!');

            case 'sambutan':
                $validated = $request->validate([
                    'nama' => 'required|string|max:255',
                    'jabatan' => 'required|string|max:255',
                    'pesan' => 'required|string',
                    'foto_initials' => 'nullable|string|max:10',
                ]);
                SchoolProfile::setVal('sambutan', $validated);
                $this->logActivity('profil', 'update', 'Memperbarui sambutan kepala sekolah');
                return redirect()->route('admin.profile.index', ['tab' => 'sambutan'])->with('success', 'Sambutan kepala sekolah berhasil disimpan!');

            case 'stats':
                $validated = $request->validate([
                    'siswa_baseline' => 'required|integer|min:0',
                    'guru_fallback' => 'required|integer|min:1',
                    'jenjang_label' => 'required|string|max:100',
                    'serapan_prestasi' => 'required|string|max:100',
                    'baseline_pendaftar' => 'required|integer|min:0',
                    'baseline_diterima' => 'required|integer|min:0',
                    'gelombang' => 'required|string|max:100',
                    'deadline' => 'required|string|max:100',
                ]);

                SchoolProfile::setVal('stats', [
                    'siswa_baseline' => $validated['siswa_baseline'],
                    'guru_fallback' => $validated['guru_fallback'],
                    'jenjang_label' => $validated['jenjang_label'],
                    'serapan_prestasi' => $validated['serapan_prestasi'],
                ]);

                SchoolProfile::setVal('ppdb_stats', [
                    'baseline_pendaftar' => $validated['baseline_pendaftar'],
                    'baseline_diterima' => $validated['baseline_diterima'],
                    'gelombang' => $validated['gelombang'],
                    'deadline' => $validated['deadline'],
                ]);

                $this->logActivity('profil', 'update', 'Memperbarui konfigurasi statistik landing page & PPDB');
                return redirect()->route('admin.profile.index', ['tab' => 'stats'])->with('success', 'Konfigurasi statistik berhasil disimpan!');

            case 'cabang':
                $cabangInputs = $request->input('cabang', []);
                if (!is_array($cabangInputs)) {
                    return redirect()->back()->with('error', 'Format data cabang tidak valid.');
                }

                $cleanedCabang = [];
                foreach ($cabangInputs as $item) {
                    if (empty($item['id']) || empty($item['label'])) {
                        continue;
                    }

                    $features = [];
                    if (!empty($item['features'])) {
                        $features = is_array($item['features'])
                            ? $item['features']
                            : array_filter(array_map('trim', explode("\n", $item['features'])));
                    }

                    $cleanedCabang[] = [
                        'id' => $item['id'],
                        'label' => $item['label'],
                        'title' => $item['title'] ?? $item['label'],
                        'tag' => $item['tag'] ?? strtoupper($item['label']),
                        'kota' => $item['kota'] ?? '',
                        'alamat' => $item['alamat'] ?? '',
                        'jam' => $item['jam'] ?? 'Senin – Sabtu: 08.00 – 16.30 WIB',
                        'telepon' => $item['telepon'] ?? '',
                        'wa' => $item['wa'] ?? '',
                        'wa_url' => $item['wa_url'] ?? '',
                        'maps_url' => $item['maps_url'] ?? '',
                        'desc' => $item['desc'] ?? '',
                        'image' => $item['image'] ?? '',
                        'features' => array_values($features),
                    ];
                }

                SchoolProfile::setVal('cabang', $cleanedCabang);
                $this->logActivity('profil', 'update', 'Memperbarui informasi cabang-cabang sekolah');
                return redirect()->route('admin.profile.index', ['tab' => 'cabang'])->with('success', 'Data cabang sekolah berhasil diperbarui!');

            default:
                return redirect()->back()->with('error', 'Bagian pengaturan tidak dikenali.');
        }
    }
}
