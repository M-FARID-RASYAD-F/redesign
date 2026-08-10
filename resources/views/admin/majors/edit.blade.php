@extends('layouts.admin')

@section('title', 'Edit Jurusan - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Edit Jurusan</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.majors.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Jurusan</a></p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.majors.update', $major->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nama Jurusan *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required value="{{ old('name', $major->name) }}">
            @error('name')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="icon">Ikon Emoticon</label>
            <input type="text" id="icon" name="icon" class="form-control" placeholder="Contoh: 💻, 📡, 🎨, 📊" value="{{ old('icon', $major->icon) }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Masukkan satu emoji yang merepresentasikan jurusan tersebut.</span>
            @error('icon')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Deskripsi Lengkap Jurusan</label>
            <textarea id="description" name="description" class="form-control" rows="6" placeholder="Tulis deskripsi detail materi pembelajaran dan kompetensi jurusan...">{{ old('description', $major->description) }}</textarea>
            @error('description')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.majors.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
