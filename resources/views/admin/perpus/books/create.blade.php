@extends('layouts.admin')

@section('title', 'Tambah Buku Baru - Perpustakaan Digital')

@section('content')
<div class="header" style="margin-bottom: 24px;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('admin.perpus.books.index') }}" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 4px;">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali
        </a>
        <h1 class="header-title" style="font-size: 1.4rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0;">Tambah Buku Baru</h1>
    </div>
</div>

@if($errors->any())
<div style="background-color: rgba(239, 68, 68, 0.15); border-left: 4px solid #ef4444; color: #fca5a5; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
    <div style="font-weight: 600; margin-bottom: 4px;">Terjadi kesalahan pengisian form:</div>
    <ul style="margin: 0; padding-left: 18px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card" style="max-width: 800px; padding: 24px;">
    <form action="{{ route('admin.perpus.books.store') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div style="grid-column: span 2;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">Judul Buku <span style="color: #ef4444;">*</span></label>
                <input type="text" name="title" value="{{ old('title') }}" required placeholder="Masukkan judul lengkap buku" class="form-control">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">Kategori Buku</label>
                <select name="category_id" class="form-control" style="cursor: pointer;">
                    <option value="" style="background: var(--adm-card-solid, #002147); color: #ffffff;">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }} style="background: var(--adm-card-solid, #002147); color: #ffffff;">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">Nomor ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="Contoh: 978-602-03-8591-4" class="form-control">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">Penulis / Pengarang <span style="color: #ef4444;">*</span></label>
                <input type="text" name="author" value="{{ old('author') }}" required placeholder="Nama penulis buku" class="form-control">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">Penerbit</label>
                <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="Nama penerbit / tahun terbit" class="form-control">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">Total Eksemplar Stok <span style="color: #ef4444;">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', 1) }}" min="1" required class="form-control">
                <small style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.775rem; display: block; margin-top: 4px;">Stok awal otomatis mengisi jumlah 'Tersedia'.</small>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">Lokasi Rak Fisik</label>
                <input type="text" name="rack_location" value="{{ old('rack_location') }}" placeholder="Contoh: Rak B-03, Lemari 2" class="form-control">
            </div>

            <div style="grid-column: span 2;">
                <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">Sinopsis / Deskripsi Buku</label>
                <textarea name="synopsis" rows="4" placeholder="Ringkasan atau sinopsis singkat buku..." class="form-control" style="font-family: inherit;">{{ old('synopsis') }}</textarea>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.12)); padding-top: 18px;">
            <a href="{{ route('admin.perpus.books.index') }}" class="btn btn-outline" style="padding: 9px 18px;">Batal</a>
            <button type="submit" class="btn btn-primary" style="padding: 9px 22px;">Simpan Buku</button>
        </div>
    </form>
</div>
@endsection
