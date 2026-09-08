@extends('layouts.admin')

@section('title', 'Unggah Foto Galeri - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Unggah Foto Galeri</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.galleries.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Galeri</a></p>
    </div>
</div>

<div class="card" style="max-width: 650px;">
    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label" for="title">Judul / Caption Foto *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" placeholder="Contoh: Suasana Praktik Lab Jaringan Santri SMK" required>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label" for="category">Kategori Kegiatan</label>
            <input type="text" id="category" name="category" class="form-control" value="{{ old('category', 'Kegiatan Santri') }}" placeholder="Contoh: Prestasi, Ekstrakurikuler, Fasilitas">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label" for="image_file">Unggah File Foto (JPG/PNG/WEBP)</label>
            <input type="file" id="image_file" name="image_file" class="form-control" accept="image/*">
            <small style="color: var(--text-muted); display: block; margin-top: 4px;">Maksimal 3MB. Atau Anda bisa menggunakan link URL foto di bawah.</small>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label class="form-label" for="image_path">Atau URL Gambar Eksternal</label>
            <input type="url" id="image_path" name="image_path" class="form-control" value="{{ old('image_path') }}" placeholder="https://images.unsplash.com/photo-...">
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Simpan ke Galeri</button>
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
