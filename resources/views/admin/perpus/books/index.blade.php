@extends('layouts.admin')

@section('title', 'Katalog Buku - Perpustakaan Digital')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="header-title" style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;">Katalog Buku Perpustakaan</h1>
        <p style="color: var(--text-muted, #64748b); font-size: 0.9rem; margin: 0;">Kelola master data buku, klasifikasi kategori, dan ketersediaan stok fisik perpustakaan.</p>
    </div>
    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
        <!-- Modal Trigger for Quick Category Addition -->
        <button type="button" class="btn btn-outline" onclick="document.getElementById('modalAddCategory').style.display='flex'" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Kategori
        </button>
        <a href="{{ route('admin.perpus.books.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Buku
        </a>
    </div>
</div>

@if(session('success'))
<div style="background-color: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="background-color: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
    <ul style="margin: 0; padding-left: 18px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Search & Filter Card -->
<div class="card" style="padding: 18px; margin-bottom: 20px;">
    <form action="{{ route('admin.perpus.books.index') }}" method="GET" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 260px; position: relative;">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari berdasarkan judul buku atau nama penulis..." class="form-control" style="width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid #cbd5e1;">
        </div>
        <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Cari
        </button>
        @if($search)
            <a href="{{ route('admin.perpus.books.index') }}" class="btn btn-outline" style="padding: 9px 14px;">Reset</a>
        @endif
    </form>
</div>

<!-- Table Card -->
<div class="card">
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569;">
                    <th style="padding: 12px 16px; font-weight: 600;">Buku & Penulis</th>
                    <th style="padding: 12px 16px; font-weight: 600;">Kategori</th>
                    <th style="padding: 12px 16px; font-weight: 600;">ISBN</th>
                    <th style="padding: 12px 16px; font-weight: 600;">Lokasi Rak</th>
                    <th style="padding: 12px 16px; font-weight: 600; text-align: center;">Total Stok</th>
                    <th style="padding: 12px 16px; font-weight: 600; text-align: center;">Tersedia</th>
                    <th style="padding: 12px 16px; font-weight: 600; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 14px 16px;">
                        <div style="font-weight: 600; color: #1e293b; font-size: 0.95rem;">{{ $book->title }}</div>
                        <div style="color: #64748b; font-size: 0.825rem; margin-top: 2px;">
                            Penulis: {{ $book->author }} {{ $book->publisher ? '• Penerbit: ' . $book->publisher : '' }}
                        </div>
                    </td>
                    <td style="padding: 14px 16px;">
                        <span style="background-color: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 4px; font-size: 0.775rem; font-weight: 500;">
                            {{ $book->category ? $book->category->name : 'Tanpa Kategori' }}
                        </span>
                    </td>
                    <td style="padding: 14px 16px; color: #475569; font-size: 0.85rem;">
                        {{ $book->isbn ?: '-' }}
                    </td>
                    <td style="padding: 14px 16px; color: #475569; font-size: 0.85rem;">
                        <span style="background: #f1f5f9; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0;">
                            {{ $book->rack_location ?: '-' }}
                        </span>
                    </td>
                    <td style="padding: 14px 16px; text-align: center; font-weight: 600; color: #334155;">
                        {{ $book->stock }}
                    </td>
                    <td style="padding: 14px 16px; text-align: center;">
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; {{ $book->available > 0 ? 'background-color: #dcfce7; color: #15803d;' : 'background-color: #fee2e2; color: #b91c1c;' }}">
                            {{ $book->available }} {{ $book->available > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </td>
                    <td style="padding: 14px 16px; text-align: center;">
                        <div style="display: inline-flex; gap: 6px; align-items: center;">
                            <a href="{{ route('admin.perpus.books.edit', $book->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary, #0284c7); border-color: #bae6fd; display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; font-size: 0.8rem;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.perpus.books.delete', $book->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus buku '<strong>{{ $book->title }}</strong>'?">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger" style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; font-size: 0.8rem;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8;">
                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 12px; display: block; opacity: 0.5;"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10"/></svg>
                        Belum ada data buku perpustakaan ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($books->hasPages())
    <div style="padding: 16px; border-top: 1px solid #e2e8f0;">
        {{ $books->links() }}
    </div>
    @endif
</div>

<!-- Modal Quick Add Category -->
<div id="modalAddCategory" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 9999; align-items: center; justify-content: center; padding: 16px;">
    <div style="background: white; border-radius: 12px; width: 100%; max-width: 440px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600; color: #1e293b;">Tambah Kategori Buku</h3>
            <button type="button" onclick="document.getElementById('modalAddCategory').style.display='none'" style="background: none; border: none; font-size: 1.5rem; line-height: 1; cursor: pointer; color: #94a3b8;">&times;</button>
        </div>
        <form action="{{ route('admin.perpus.book-categories.store') }}" method="POST" style="padding: 20px;">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 500; font-size: 0.875rem; color: #334155; margin-bottom: 6px;">Nama Kategori <span style="color: #ef4444;">*</span></label>
                <input type="text" name="name" required placeholder="Mis. Fiksi, Biografi, Sains" class="form-control" style="width: 100%; padding: 8px 12px; border-radius: 6px; border: 1px solid #cbd5e1;">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                <button type="button" onclick="document.getElementById('modalAddCategory').style.display='none'" class="btn btn-outline" style="padding: 8px 14px;">Batal</button>
                <button type="submit" class="btn btn-primary" style="padding: 8px 16px;">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection
