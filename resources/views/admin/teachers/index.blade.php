@extends('layouts.admin')

@section('title', 'Kelola Guru & Staf - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Guru & Staf</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Daftar guru, tenaga pengajar, dan staf administrasi sekolah.</p>
    </div>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
        <span>➕</span> Tambah Guru / Staf
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Pengajar</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Mata Pelajaran</th>
                    <th>Status</th>
                    <th style="width: 150px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 700; color: #475569; overflow: hidden;">
                                @if($teacher->photo)
                                    <img src="{{ $teacher->photo }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                @endif
                            </div>
                            <div style="font-weight: 600; color: #0f172a;">{{ $teacher->name }}</div>
                        </div>
                    </td>
                    <td style="font-family: monospace; font-size: 0.85rem;">
                        {{ $teacher->nip ?? 'Belum Diisi' }}
                    </td>
                    <td>
                        {{ $teacher->position }}
                    </td>
                    <td>
                        {{ $teacher->subject ?? '-' }}
                    </td>
                    <td>
                        @if($teacher->status == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary);">Edit</a>
                            
                            <form action="{{ route('admin.teachers.delete', $teacher->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada data guru atau staf.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
