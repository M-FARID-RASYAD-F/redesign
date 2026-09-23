@extends('layouts.admin')

@section('title', 'Tambah Kategori Buku - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Tambah Kategori Buku</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.categories.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Kategori</a></p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nama Kategori *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Teknologi Informasi & Pemrograman" required value="{{ old('name') }}">
            @error('name')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="icon">Ikon / Simbol Singkat</label>
            <input type="text" id="icon" name="icon" class="form-control" placeholder="Contoh: 💻, 🔬, 📚, 🕌, 🏛️" value="{{ old('icon') }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Gunakan emoji atau simbol representasi kategori.</span>
            @error('icon')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Deskripsi Kategori</label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Tulis ringkasan cakupan topik dalam kategori ini...">{{ old('description') }}</textarea>
            @error('description')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Tambah Kategori</span>
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
