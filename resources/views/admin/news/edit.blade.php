@extends('layouts.admin')

@section('title', 'Edit Berita - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Edit Berita</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.news.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Berita</a></p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.news.update', $news->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="title">Judul Berita *</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan judul berita" required value="{{ old('title', $news->title) }}">
            @error('title')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="category_id">Kategori Berita *</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="thumbnail">URL Gambar Thumbnail</label>
            <input type="text" id="thumbnail" name="thumbnail" class="form-control" placeholder="Masukkan link gambar atau biarkan kosong" value="{{ old('thumbnail', $news->thumbnail) }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Contoh: https://picsum.photos/800/400</span>
            @error('thumbnail')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="published_at">Tanggal Publikasi</label>
            <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Biarkan kosong untuk menjadikannya draft, atau isi tanggal agar otomatis terbit.</span>
            @error('published_at')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="content">Isi Konten Berita *</label>
            <textarea id="content" name="content" class="form-control" rows="12" placeholder="Tulis isi berita selengkapnya disini..." required>{{ old('content', $news->content) }}</textarea>
            @error('content')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
