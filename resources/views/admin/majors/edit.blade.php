@extends('layouts.admin')

@section('title', 'Edit Jurusan - At-Tamam Edu')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="header-title" style="font-size: 1.5rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0 0 6px 0;">Edit Data Jurusan</h1>
        <p style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.9rem; margin: 0;">Perbarui nama, ikon, atau deskripsi kurikulum program keahlian.</p>
    </div>
    <div>
        <a href="{{ route('admin.majors.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar Jurusan</span>
        </a>
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
            <label class="form-label" for="icon">Ikon / Simbol Jurusan</label>
            <input type="text" id="icon" name="icon" class="form-control" placeholder="Contoh: IT, DKV, TAB, TKJ" value="{{ old('icon', $major->icon) }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Masukkan kode singkat atau simbol yang merepresentasikan jurusan tersebut.</span>
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
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span>Simpan Perubahan</span>
            </button>
            <a href="{{ route('admin.majors.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
