@extends('layouts.admin')

@section('title', 'Kelola Jurusan - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Jurusan</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola data program keahlian/jurusan yang tersedia di sekolah.</p>
    </div>
    @can('create', App\Models\Major::class)
    <a href="{{ route('admin.majors.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Tambah Jurusan Baru</span>
    </a>
    @endcan
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px; text-align: center;">Ikon</th>
                    <th>Nama Jurusan</th>
                    <th>Deskripsi Ringkas</th>
                    <th style="width: 150px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($majors as $major)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">
                        <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(0, 180, 216, 0.15); color: #38bdf8; display: inline-flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                            @if($major->icon)
                                {{ $major->icon }}
                            @else
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #ffffff; margin-bottom: 2px;">{{ $major->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">Slug: {{ $major->slug }}</div>
                    </td>
                    <td style="line-height: 1.4; color: var(--text-muted); font-size: 0.85rem;">
                        {{ Str::limit($major->description, 100) }}
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            @can('update', $major)
                            <a href="{{ route('admin.majors.edit', $major->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary); display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                <span>Edit</span>
                            </a>
                            @endcan
                            
                            @can('delete', $major)
                            <form action="{{ route('admin.majors.delete', $major->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus jurusan <strong>{{ $major->name }}</strong>? Tindakan ini tidak dapat dibatalkan.">
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
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada data jurusan keahlian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
