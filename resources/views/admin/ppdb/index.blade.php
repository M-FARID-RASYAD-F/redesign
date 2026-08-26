@extends('layouts.admin')

@section('title', 'Pendaftaran PPDB Online - At-Tamam Edu')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h1 class="header-title">Pendaftaran PPDB Online</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola dan verifikasi pendaftaran calon peserta didik baru.</p>
    </div>
    <div>
        <a href="{{ route('admin.ppdb.export') }}" class="btn btn-success" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 10px 18px; border-radius: 8px; text-decoration: none; color: white; background: #10b981;">
            📥 Unduh Rekap CSV
        </a>
    </div>
</div>


<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Pendaftaran</th>
                    <th>Nama Calon Siswa</th>
                    <th>Pilihan Jurusan</th>
                    <th>Nama Orang Tua</th>
                    <th>Telepon Orang Tua</th>
                    <th>Status Pendaftaran</th>
                    <th style="width: 150px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $reg)
                <tr>
                    <td style="font-weight: 700; font-family: monospace; color: var(--primary);">
                        {{ $reg->no_pendaftaran }}
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #0f172a; margin-bottom: 2px;">{{ $reg->full_name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">
                            {{ $reg->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} · Lahir: {{ $reg->birth_date ? $reg->birth_date->format('d/m/Y') : '-' }}
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ strtoupper($reg->major_choice) }}</span>
                    </td>
                    <td>
                        {{ $reg->parent_name }}
                    </td>
                    <td>
                        {{ $reg->parent_phone }}
                    </td>
                    <td>
                        @if($reg->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($reg->status == 'diverifikasi')
                            <span class="badge badge-info">Diverifikasi</span>
                        @elseif($reg->status == 'diterima')
                            <span class="badge badge-success">Diterima</span>
                        @elseif($reg->status == 'ditolak')
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary);">Detail & Verifikasi</a>
                            
                            <form action="{{ route('admin.ppdb.delete', $reg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftar PPDB ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada pendaftaran PPDB online masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
