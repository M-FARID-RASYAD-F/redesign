@extends('layouts.admin')

@section('title', 'Kelola Guru & Staf - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Guru & Staf</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Daftar guru, tenaga pengajar, dan staf administrasi sekolah.</p>
    </div>
    @can('create', App\Models\TeacherStaff::class)
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Tambah Guru / Staf</span>
    </a>
    @endcan
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
                            <div style="font-weight: 600; color: #ffffff;">{{ $teacher->name }}</div>
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
                            @can('update', $teacher)
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary); display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                <span>Edit</span>
                            </a>
                            @endcan
                            
                            @can('delete', $teacher)
                            <form action="{{ route('admin.teachers.delete', $teacher->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus data guru <strong>{{ $teacher->name }}</strong>? Tindakan ini tidak dapat dibatalkan.">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger" style="display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                            @endcan
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

    @if($teachers->hasPages())
    <div style="margin-top: 20px; display: flex; justify-content: flex-end; overflow-x: auto;">
        {{ $teachers->links() }}
    </div>
    @endif
</div>
@endsection
