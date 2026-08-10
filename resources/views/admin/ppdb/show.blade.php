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
            <h3 style="font-size: 1.10rem; font-weight: 700; margin-bottom: 20px; color: #0f172a; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
                👤 Informasi Data Diri
            </h3>
            
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="font-weight: 600; width: 200px; border-bottom: none; padding: 12px 0;">No. Pendaftaran</td>
                        <td style="font-family: monospace; font-weight: 700; font-size: 1.05rem; color: var(--primary); border-bottom: none; padding: 12px 0;">{{ $registration->no_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; border-bottom: none; padding: 12px 0;">Nama Lengkap</td>
                        <td style="border-bottom: none; padding: 12px 0;">{{ $registration->full_name }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; border-bottom: none; padding: 12px 0;">Jenis Kelamin</td>
                        <td style="border-bottom: none; padding: 12px 0;">{{ $registration->gender == 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; border-bottom: none; padding: 12px 0;">Tanggal Lahir</td>
                        <td style="border-bottom: none; padding: 12px 0;">{{ $registration->birth_date ? $registration->birth_date->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; border-bottom: none; padding: 12px 0;">Jurusan Pilihan</td>
                        <td style="border-bottom: none; padding: 12px 0;"><span class="badge badge-info">{{ strtoupper($registration->major_choice) }}</span></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; border-bottom: none; padding: 12px 0;">Alamat Lengkap</td>
                        <td style="border-bottom: none; padding: 12px 0; line-height: 1.5;">{{ $registration->address }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; border-bottom: none; padding: 12px 0;">Nama Orang Tua</td>
                        <td style="border-bottom: none; padding: 12px 0;">{{ $registration->parent_name }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600; border-bottom: none; padding: 12px 0;">No. Telepon Orang Tua</td>
                        <td style="border-bottom: none; padding: 12px 0; font-family: monospace;">{{ $registration->parent_phone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- PPDB Documents -->
        <div class="card">
            <h3 style="font-size: 1.10rem; font-weight: 700; margin-bottom: 20px; color: #0f172a; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
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
                                {{ str_replace('_', ' ', $doc->doc_type) }}
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
                                <a href="{{ asset($doc->file_path) }}" target="_blank" class="btn btn-outline btn-sm" style="font-size: 0.75rem;">👀 Lihat Dokumen</a>
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
            <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 16px; color: #0f172a; border-bottom: 1px solid var(--border); padding-bottom: 10px;">
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

            <form action="{{ route('admin.ppdb.status', $registration->id) }}" method="POST">
                @csrf
                
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

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Simpan Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
