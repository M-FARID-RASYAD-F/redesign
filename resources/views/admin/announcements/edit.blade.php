@extends('layouts.admin')

@section('title', 'Edit Pengumuman: ' . $announcement->title . ' - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Edit Pengumuman</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.announcements.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Pengumuman</a></p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST">
        @csrf

        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label" for="title">Judul Pengumuman *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $announcement->title) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 20px;">
            <div class="form-group">
                <label class="form-label" for="type">Tipe / Kategori</label>
                <select id="type" name="type" class="form-control">
                    <option value="umum" {{ $announcement->type == 'umum' ? 'selected' : '' }}>Umum</option>
                    <option value="akademik" {{ $announcement->type == 'akademik' ? 'selected' : '' }}>Akademik</option>
                    <option value="kegiatan" {{ $announcement->type == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="ppdb" {{ $announcement->type == 'ppdb' ? 'selected' : '' }}>PPDB</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="start_date">Tanggal Mulai Berlaku *</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $announcement->start_date ? $announcement->start_date->format('Y-m-d') : '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="end_date">Tanggal Berakhir</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $announcement->end_date ? $announcement->end_date->format('Y-m-d') : '') }}">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #fff;">
                <input type="checkbox" name="is_archived" value="1" {{ $announcement->is_archived ? 'checked' : '' }}>
                <span>Arsipkan Pengumuman ini (tidak ditampilkan di beranda publik)</span>
            </label>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label class="form-label" for="content">Isi Pengumuman *</label>
            <textarea id="content" name="content" class="form-control" rows="8" required>{{ old('content', $announcement->content) }}</textarea>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
