@extends('layouts.admin')

@section('title', 'Detail PPDB: ' . $registration->full_name . ' - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Detail Pendaftar PPDB</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.ppdb.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Pendaftaran</a></p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start;">
    <!-- Main Detail Card -->
    <div>
        <div class="card">
            <h3 style="font-size: 1.10rem; font-weight: 700; margin-bottom: 20px; color: #ffffff; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
                👤 Informasi Data Diri
            </h3>
            
            <table class="table-detail">
                <tbody>
                    <tr>
                        <td style="font-weight: 600;">No. Pendaftaran</td>
                        <td style="font-family: monospace; font-weight: 700; font-size: 1.05rem; color: var(--primary);">{{ $registration->no_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Tingkat / Jenjang</td>
                        <td>
                            @if($registration->jenjang === 'sd')
                                <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 0.85rem; padding: 4px 10px;">
                                    🎒 Sekolah Dasar (SD)
                                </span>
                            @elseif($registration->jenjang === 'smp')
                                <span class="badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35); font-size: 0.85rem; padding: 4px 10px;">
                                    📚 Sekolah Menengah Pertama (SMP)
                                </span>
                            @elseif($registration->jenjang === 'smk')
                                <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35); font-size: 0.85rem; padding: 4px 10px;">
                                    💻 Sekolah Menengah Kejuruan (SMK)
                                </span>
                                @if($registration->major_choice)
                                    <div style="margin-top: 6px; font-size: 0.85rem; color: #a855f7;">
                                        Pilihan Jurusan: <strong>{{ $registration->major_choice }}</strong>
                                    </div>
                                @endif
                            @else
                                <span class="badge">{{ strtoupper($registration->jenjang ?? '-') }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Nama Lengkap</td>
                        <td>{{ $registration->full_name }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Jenis Kelamin</td>
                        <td>{{ $registration->gender == 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Tanggal Lahir</td>
                        <td>{{ $registration->birth_date ? $registration->birth_date->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Alamat Lengkap</td>
                        <td style="line-height: 1.5;">{{ $registration->address }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Nama Orang Tua</td>
                        <td>{{ $registration->parent_name }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">No. Telepon Orang Tua</td>
                        <td style="font-family: monospace;">{{ $registration->parent_phone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- PPDB Documents -->
        <div class="card">
            <h3 style="font-size: 1.10rem; font-weight: 700; margin-bottom: 20px; color: #ffffff; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
                📂 Dokumen Persyaratan
            </h3>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Jenis Dokumen</th>
                            <th>Status Validasi</th>
                            <th>Link File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registration->documents as $doc)
                        <tr>
                            <td style="font-weight: 600; text-transform: uppercase;">
                                {{ strtoupper(str_replace('_', ' ', $doc->doc_type)) }}
                            </td>
                            <td>
                                @if($doc->verification_status == 'belum_diverifikasi')
                                    <span class="badge badge-warning">Belum Diverifikasi</span>
                                @elseif($doc->verification_status == 'valid')
                                    <span class="badge badge-success">Valid / Cocok</span>
                                @elseif($doc->verification_status == 'tidak_valid')
                                    <span class="badge badge-danger">Tidak Valid / Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-outline btn-sm" style="font-size: 0.75rem;">👀 Lihat Dokumen</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada dokumen persyaratan yang diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Verification Sidebar -->
    <div>
        <div class="card">
            <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 16px; color: #ffffff; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
                🛡️ Status & Verifikasi
            </h3>
            
            <div style="margin-bottom: 20px;">
                <span class="form-label" style="margin-bottom: 4px;">Status Saat Ini:</span>
                @if($registration->status == 'pending')
                    <span class="badge badge-warning" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center;">Pending</span>
                @elseif($registration->status == 'diverifikasi')
                    <span class="badge badge-info" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center;">Diverifikasi</span>
                @elseif($registration->status == 'diterima')
                    <span class="badge badge-success" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center;">Diterima</span>
                @elseif($registration->status == 'ditolak')
                    <span class="badge badge-danger" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center;">Ditolak</span>
                @endif
            </div>

            @can('update', $registration)
            <form action="{{ route('admin.ppdb.status', $registration->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="jenjang">Tingkat / Jenjang *</label>
                    <select id="jenjang" name="jenjang" class="form-control" required onchange="toggleAdminMajorField(this.value)">
                        <option value="sd" {{ $registration->jenjang == 'sd' ? 'selected' : '' }}>🎒 SD (Sekolah Dasar)</option>
                        <option value="smp" {{ $registration->jenjang == 'smp' ? 'selected' : '' }}>📚 SMP (Menengah Pertama)</option>
                        <option value="smk" {{ $registration->jenjang == 'smk' ? 'selected' : '' }}>💻 SMK (Kejuruan)</option>
                    </select>
                </div>

                <div class="form-group" id="adminMajorContainer" style="display: {{ $registration->jenjang == 'smk' ? 'block' : 'none' }};">
                    <label class="form-label" for="major_choice">Jurusan (Khusus SMK)</label>
                    <select id="major_choice" name="major_choice" class="form-control">
                        <option value="">-- Tanpa Jurusan Tertentu --</option>
                        @foreach($majors as $m)
                            <option value="{{ $m->name }}" {{ $registration->major_choice == $m->name ? 'selected' : '' }}>
                                {{ $m->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Ubah Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diverifikasi" {{ $registration->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                        <option value="diterima" {{ $registration->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $registration->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">Catatan Verifikasi</label>
                    <textarea id="notes" name="notes" class="form-control" rows="4" placeholder="Masukkan alasan penolakan, catatan validasi, atau detail penerimaan...">{{ old('notes', $registration->notes) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Simpan Perubahan</button>
            </form>
            <script>
            function toggleAdminMajorField(val) {
                const el = document.getElementById('adminMajorContainer');
                if (el) el.style.display = val === 'smk' ? 'block' : 'none';
            }
            </script>
            @else
            <div style="padding: 12px; background: rgba(0,0,0,0.2); border-radius: 8px; border: 1px solid var(--border);">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 4px;">Catatan Panitia:</div>
                <div style="font-size: 0.9rem; color: #ffffff;">{{ $registration->notes ?? 'Tidak ada catatan.' }}</div>
                <div style="margin-top: 10px; font-size: 0.75rem; color: var(--text-muted); font-style: italic;">
                    🔒 Akun Anda dalam mode pratinjau (read-only).
                </div>
            </div>
            @endcan

            @can('delete', $registration)
            <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
                <form action="{{ route('admin.ppdb.delete', $registration->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus pendaftar <strong>{{ $registration->full_name }}</strong>? Tindakan ini tidak dapat dibatalkan.">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm btn-delete-trigger" style="width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px;">
                        🗑️ Hapus Pendaftar
                    </button>
                </form>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection
