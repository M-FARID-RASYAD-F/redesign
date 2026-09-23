@extends('layouts.admin')

@section('title', 'Edit Rak Buku - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Edit Rak Buku</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.racks.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Rak</a></p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.racks.update', $rack->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="code">Kode Rak *</label>
            <input type="text" id="code" name="code" class="form-control" placeholder="Contoh: RAK-01 atau RAK-TI" required value="{{ old('code', $rack->code) }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Kode unik pengenal rak penyimpanan fisik.</span>
            @error('code')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Nama / Label Rak *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Rak Komputer & Pemrograman" required value="{{ old('name', $rack->name) }}">
            @error('name')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="location">Lokasi Fisik Ruangan</label>
            <input type="text" id="location" name="location" class="form-control" placeholder="Contoh: Lantai 1 - Sayap Barat Baris 3" value="{{ old('location', $rack->location) }}">
            @error('location')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Keterangan Tambahan</label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Kapasitas, klasifikasi nomor klasifikasi DDC, atau catatan rak...">{{ old('description', $rack->description) }}</textarea>
            @error('description')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span>Simpan Perubahan</span>
            </button>
            <a href="{{ route('admin.racks.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
