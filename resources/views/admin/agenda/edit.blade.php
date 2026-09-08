@extends('layouts.admin')

@section('title', 'Edit Agenda: ' . $agenda->title . ' - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Edit Agenda Kegiatan</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.agenda.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Agenda</a></p>
    </div>
</div>

<div class="card" style="max-width: 700px;">
    <form action="{{ route('admin.agenda.update', $agenda->id) }}" method="POST">
        @csrf

        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-label" for="title">Nama Kegiatan / Agenda *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $agenda->title) }}" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
            <div class="form-group">
                <label class="form-label" for="date">Tanggal Kegiatan *</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $agenda->date ? $agenda->date->format('Y-m-d') : '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="location">Lokasi / Tempat</label>
                <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $agenda->location) }}">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label class="form-label" for="description">Deskripsi / Detail Kegiatan</label>
            <textarea id="description" name="description" class="form-control" rows="5">{{ old('description', $agenda->description) }}</textarea>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.agenda.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
