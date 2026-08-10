@extends('layouts.admin')

@section('title', 'Tambah Guru / Staf Baru - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Tambah Guru / Staf Baru</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.teachers.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Guru & Staf</a></p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.teachers.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap & Gelar *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Budi Santoso, S.Pd." required value="{{ old('name') }}">
            @error('name')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="nip">NIP (Nomor Induk Pegawai)</label>
            <input type="text" id="nip" name="nip" class="form-control" placeholder="Contoh: 198203112009121003" value="{{ old('nip') }}">
            @error('nip')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="position">Jabatan / Peran *</label>
            <select id="position" name="position" class="form-control" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="Kepala Sekolah" {{ old('position') == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                <option value="Wakil Kepala Sekolah" {{ old('position') == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala Sekolah</option>
                <option value="Guru Pengajar" {{ old('position') == 'Guru Pengajar' ? 'selected' : '' }}>Guru Pengajar</option>
                <option value="Staf Tata Usaha" {{ old('position') == 'Staf Tata Usaha' ? 'selected' : '' }}>Staf Tata Usaha</option>
                <option value="Staf Perpustakaan" {{ old('position') == 'Staf Perpustakaan' ? 'selected' : '' }}>Staf Perpustakaan</option>
                <option value="Keamanan / Satpam" {{ old('position') == 'Keamanan / Satpam' ? 'selected' : '' }}>Keamanan / Satpam</option>
            </select>
            @error('position')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="subject">Mata Pelajaran (bila pengajar)</label>
            <input type="text" id="subject" name="subject" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak, Matematika, PKn" value="{{ old('subject') }}">
            @error('subject')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="photo">URL Foto</label>
            <input type="text" id="photo" name="photo" class="form-control" placeholder="Masukkan URL gambar foto pengajar" value="{{ old('photo') }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Contoh: https://i.pravatar.cc/150?img=12</span>
            @error('photo')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="status">Status Keaktifan *</label>
            <select id="status" name="status" class="form-control" required>
                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Tambah Guru</button>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
