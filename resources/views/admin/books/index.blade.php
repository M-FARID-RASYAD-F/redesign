@extends('layouts.admin')

@section('title', 'Kelola Data Buku - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Koleksi Buku</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Master data katalog buku, kategori, penempatan rak, dan stok perpustakaan.</p>
    </div>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <a href="{{ route('catalog.index') }}" target="_blank" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            <span>Katalog Publik</span>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            <span>Kelola Kategori</span>
        </a>
        <a href="{{ route('admin.racks.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/></svg>
            <span>Kelola Rak</span>
        </a>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <span>Tambah Buku Baru</span>
        </a>
    </div>
</div>

{{-- Filter Toolbar --}}
<div class="card" style="margin-bottom: 20px; padding: 16px;">
    <form action="{{ route('admin.books.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end;">
        <div style="flex: 2; min-width: 200px;">
            <label class="form-label" style="margin-bottom: 4px; font-size: 0.8rem;" for="filterSearch">Cari Buku</label>
            <input type="text" id="filterSearch" name="search" class="form-control" placeholder="Cari judul, penulis, ISBN, atau penerbit..." value="{{ $search }}">
        </div>

        <div style="flex: 1; min-width: 150px;">
            <label class="form-label" style="margin-bottom: 4px; font-size: 0.8rem;" for="filterCategory">Kategori</label>
            <select id="filterCategory" name="category_id" class="form-control">
                <option value="all">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="flex: 1; min-width: 130px;">
            <label class="form-label" style="margin-bottom: 4px; font-size: 0.8rem;" for="filterRack">Rak</label>
            <select id="filterRack" name="rack_id" class="form-control">
                <option value="all">Semua Rak</option>
                @foreach($racks as $r)
                    <option value="{{ $r->id }}" {{ $rackId == $r->id ? 'selected' : '' }}>{{ $r->code }} ({{ $r->name }})</option>
                @endforeach
            </select>
        </div>

        <div style="flex: 1; min-width: 120px;">
            <label class="form-label" style="margin-bottom: 4px; font-size: 0.8rem;" for="filterStatus">Status</label>
            <select id="filterStatus" name="status" class="form-control">
                <option value="all">Semua Status</option>
                <option value="tersedia" {{ $status === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="dipinjam" {{ $status === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="rusak" {{ $status === 'rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
        </div>

        <div style="display: flex; gap: 8px;">
            <button type="submit" class="btn btn-primary" style="padding: 9px 16px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span>Filter</span>
            </button>
            @if($search || ($categoryId && $categoryId !== 'all') || ($rackId && $rackId !== 'all') || ($status && $status !== 'all'))
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline" style="padding: 9px 14px;" title="Reset Filter">✕</a>
            @endif
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 70px; text-align: center;">Cover</th>
                    <th>Judul Buku & Penulis</th>
                    <th>Kategori</th>
                    <th>Rak Buku</th>
                    <th style="width: 100px; text-align: center;">Stok</th>
                    <th style="width: 110px; text-align: center;">Status</th>
                    <th style="width: 170px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">
                        <img 
                            src="{{ $book->cover_url }}" 
                            alt="{{ $book->title }}" 
                            style="width: 44px; height: 60px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1);"
                            loading="lazy"
                        >
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #ffffff; font-size: 0.95rem; margin-bottom: 2px;">{{ $book->title }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); display: flex; gap: 10px; flex-wrap: wrap;">
                            <span>✍️ {{ $book->author }}</span>
                            @if($book->publication_year)
                                <span>📅 {{ $book->publication_year }}</span>
                            @endif
                            @if($book->isbn)
                                <span style="font-family: monospace; color: #94a3b8;">ISBN: {{ $book->isbn }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($book->category)
                            <span class="badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); font-size: 0.8rem; padding: 4px 8px; border-radius: 6px;">
                                {{ $book->category->name }}
                            </span>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.8rem;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($book->rack)
                            <div style="font-size: 0.85rem; font-weight: 600; color: #10b981;">
                                {{ $book->rack->code }}
                            </div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">
                                {{ $book->rack->name }}
                            </div>
                        @else
                            <span style="color: var(--text-muted); font-size: 0.8rem;">Belum ada rak</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <div style="font-size: 0.9rem; font-weight: 700; color: {{ $book->available_stock > 0 ? '#10b981' : '#ef4444' }};">
                            {{ $book->available_stock }} <span style="font-size: 0.75rem; font-weight: 400; color: var(--text-muted);">/ {{ $book->stock }}</span>
                        </div>
                        <div style="font-size: 0.7rem; color: var(--text-muted);">Tersedia</div>
                    </td>
                    <td style="text-align: center;">
                        @if($book->status === 'tersedia')
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); font-size: 0.75rem; padding: 3px 8px; border-radius: 9999px;">
                                Tersedia
                            </span>
                        @elseif($book->status === 'dipinjam')
                            <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); font-size: 0.75rem; padding: 3px 8px; border-radius: 9999px;">
                                Dipinjam
                            </span>
                        @else
                            <span class="badge" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); font-size: 0.75rem; padding: 3px 8px; border-radius: 9999px;">
                                Rusak
                            </span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 6px;">
                            <a href="{{ route('catalog.show', $book->slug) }}" target="_blank" class="btn btn-outline btn-sm" title="Lihat Tampilan Publik" style="padding: 4px 8px; color: #94a3b8;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary); display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                <span>Edit</span>
                            </a>
                            
                            <form action="{{ route('admin.books.delete', $book->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus buku <strong>{{ $book->title }}</strong>?">
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
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 30px;">
                        Tidak ada koleksi buku yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $books->links() }}
        </div>
    @endif
</div>
@endsection
