@extends('layouts.admin')

@section('title', 'Kelola Berita - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Berita</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Terbitkan, perbarui, dan hapus artikel atau berita sekolah.</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
        <span>➕</span> Tulis Berita Baru
    </a>
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
                        <div style="font-weight: 600; color: #0f172a; margin-bottom: 4px;">{{ $news->title }}</div>
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
                            <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary);">Edit</a>
                            
                            <form action="{{ route('admin.news.delete', $news->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus berita <strong>{{ $news->title }}</strong>? Tindakan ini tidak dapat dibatalkan.">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger">🗑️ Hapus</button>
                            </form>
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
</div>
@endsection
