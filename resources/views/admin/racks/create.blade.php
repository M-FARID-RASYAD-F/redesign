@extends('layouts.admin')

@section('title', 'Tambah Rak Buku Baru - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Tambah Rak Buku Baru</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.racks.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Rak</a></p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.racks.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="code">Kode Rak *</label>
            <input type="text" id="code" name="code" class="form-control" placeholder="Contoh: RAK-01 atau RAK-TI" required value="{{ old('code') }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Kode unik pengenal rak penyimpanan fisik.</span>
            @error('code')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Nama / Label Rak *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Rak Komputer & Pemrograman" required value="{{ old('name') }}">
            @error('name')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="location">Lokasi Fisik Ruangan</label>
            <input type="text" id="location" name="location" class="form-control" placeholder="Contoh: Lantai 1 - Sayap Barat Baris 3" value="{{ old('location') }}">
            @error('location')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Keterangan Tambahan</label>
            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Kapasitas, klasifikasi nomor klasifikasi DDC, atau catatan rak...">{{ old('description') }}</textarea>
            @error('description')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Tambah Rak</span>
            </button>
            <a href="{{ route('admin.racks.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
