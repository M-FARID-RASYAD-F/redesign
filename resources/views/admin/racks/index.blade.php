@extends('layouts.admin')

@section('title', 'Kelola Rak Buku - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Rak Buku</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola data lokasi fisik rak dan tata letak penyimpanan buku perpustakaan.</p>
    </div>
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            <span>Daftar Buku</span>
        </a>
        <a href="{{ route('admin.racks.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <span>Tambah Rak Baru</span>
        </a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 110px;">Kode Rak</th>
                    <th>Nama / Label Rak</th>
                    <th>Lokasi Fisik</th>
                    <th>Keterangan</th>
                    <th style="width: 120px; text-align: center;">Koleksi Buku</th>
                    <th style="width: 150px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($racks as $rack)
                <tr>
                    <td>
                        <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); font-family: monospace; font-size: 0.85rem; font-weight: 700; padding: 4px 8px; border-radius: 6px;">
                            {{ $rack->code }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #ffffff;">{{ $rack->name }}</div>
                    </td>
                    <td style="color: #38bdf8; font-size: 0.85rem;">
                        <div style="display: inline-flex; align-items: center; gap: 5px;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>{{ $rack->location ?? 'Belum ditentukan' }}</span>
                        </div>
                    </td>
                    <td style="line-height: 1.4; color: var(--text-muted); font-size: 0.85rem;">
                        {{ Str::limit($rack->description ?? '-', 80) }}
                    </td>
                    <td style="text-align: center;">
                        <span class="badge" style="background: rgba(0, 180, 216, 0.12); color: #00b4d8; border: 1px solid rgba(0, 180, 216, 0.25); font-weight: 600; padding: 4px 10px; border-radius: 9999px;">
                            {{ $rack->books_count }} Buku
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('admin.racks.edit', $rack->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary); display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                <span>Edit</span>
                            </a>
                            
                            <form action="{{ route('admin.racks.delete', $rack->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus rak <strong>{{ $rack->name }} ({{ $rack->code }})</strong>?">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger" style="display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada data rak buku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
