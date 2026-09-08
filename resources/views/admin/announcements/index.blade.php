@extends('layouts.admin')

@section('title', 'Kelola Pengumuman - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Pengumuman</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Modul pengumuman resmi sekolah. Pengumuman otomatis diarsipkan oleh scheduler jika tanggal berakhir telah lewat.</p>
    </div>
    @if(auth()->user()->canManageAnnouncements())
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
        <span>➕</span> Buat Pengumuman Baru
    </a>
    @endif
</div>

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
    ✅ {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Judul Pengumuman</th>
                    <th>Kategori / Tipe</th>
                    <th>Periode Aktif</th>
                    <th>Status Arsip</th>
                    <th>Penulis</th>
                    @if(auth()->user()->canManageAnnouncements())
                    <th style="width: 150px; text-align: right;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($announcements as $ann)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #fff; margin-bottom: 4px;">{{ $ann->title }}</div>
                        <div style="color: var(--text-muted); font-size: 0.82rem; line-height: 1.4;">
                            {{ Str::limit(strip_tags($ann->content), 90) }}
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($ann->type ?? 'Umum') }}</span>
                    </td>
                    <td style="font-size: 0.85rem; color: var(--text-muted);">
                        <div>Mulai: {{ $ann->start_date ? $ann->start_date->format('d/m/Y') : '-' }}</div>
                        <div>Selesai: {{ $ann->end_date ? $ann->end_date->format('d/m/Y') : 'Selamanya' }}</div>
                    </td>
                    <td>
                        @if($ann->is_archived)
                            <span class="badge badge-danger">Diarsipkan (Expired)</span>
                        @else
                            <span class="badge badge-success">Aktif Publik</span>
                        @endif
                    </td>
                    <td style="font-size: 0.85rem; color: var(--text-muted);">
                        {{ $ann->creator ? $ann->creator->name : '-' }}
                    </td>
                    @if(auth()->user()->canManageAnnouncements())
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('admin.announcements.edit', $ann->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary);">Edit</a>
                            
                            <form action="{{ route('admin.announcements.delete', $ann->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus pengumuman <strong>{{ $ann->title }}</strong>?">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada pengumuman yang diterbitkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
