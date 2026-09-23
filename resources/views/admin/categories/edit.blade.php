@extends('layouts.admin')

@section('title', 'Edit Kategori Buku - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Edit Kategori Buku</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.categories.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Kategori</a></p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="name">Nama Kategori *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Teknologi Informasi & Pemrograman" required value="{{ old('name', $category->name) }}">
            @error('name')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="icon">Ikon Kategori (SVG Lucide)</label>
            <input type="text" id="icon" name="icon" class="form-control" placeholder="Pilihan: book-open, laptop, microscope, book, landmark, trending-up" value="{{ old('icon', $category->icon) }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Masukkan nama ikon SVG (misal: <code>book-open</code>, <code>laptop</code>, <code>microscope</code>, <code>book</code>, <code>landmark</code>, <code>trending-up</code>).</span>
            @error('icon')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Deskripsi Kategori</label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Tulis ringkasan cakupan topik dalam kategori ini...">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span>Simpan Perubahan</span>
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
