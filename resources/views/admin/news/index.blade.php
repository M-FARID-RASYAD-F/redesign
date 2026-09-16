@extends('layouts.admin')

@section('title', 'Kelola Berita - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Berita</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Terbitkan, perbarui, dan hapus artikel atau berita sekolah.</p>
    </div>
    @can('create', App\Models\News::class)
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Tulis Berita Baru</span>
    </a>
    @endcan
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Judul Berita</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Tanggal Rilis</th>
                    <th>Status</th>
                    <th style="width: 150px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($newsList as $news)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #ffffff; margin-bottom: 4px;">{{ $news->title }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">Slug: {{ $news->slug }}</div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $news->category->name ?? 'Umum' }}</span>
                    </td>
                    <td>
                        {{ $news->author->name ?? 'Admin' }}
                    </td>
                    <td style="font-size: 0.85rem; color: var(--text-muted);">
                        {{ $news->published_at ? $news->published_at->format('d M Y') : '-' }}
                    </td>
                    <td>
                        @if($news->published_at && $news->published_at->isPast())
                            <span class="badge badge-success">Diterbitkan</span>
                        @else
                            <span class="badge badge-warning">Draft / Jadwal</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            @can('update', $news)
                            <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary); display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                <span>Edit</span>
                            </a>
                            @endcan
                            
                            @can('delete', $news)
                            <form action="{{ route('admin.news.delete', $news->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus berita <strong>{{ $news->title }}</strong>? Tindakan ini tidak dapat dibatalkan.">
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
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada berita yang diterbitkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($newsList->hasPages())
    <div style="margin-top: 20px; display: flex; justify-content: flex-end; overflow-x: auto;">
        {{ $newsList->links() }}
    </div>
    @endif
</div>
@endsection
