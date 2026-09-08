@extends('layouts.admin')

@section('title', 'Tambah Akun Admin Baru - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Tambah Akun Admin Baru</h1>
        <p style="color: var(--adm-text-muted); font-size: 0.9rem; margin-top: 4px;">
            Kembali ke <a href="{{ route('admin.users.index') }}" style="color: var(--adm-primary); text-decoration: none; font-weight: 600;">Daftar Pengguna Admin</a>
        </p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap *</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Ustadz Ahmad Fauzi" required value="{{ old('name') }}">
            @error('name')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Alamat Email *</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Contoh: ahmad@attamam.sch.id" required value="{{ old('email') }}">
            @error('email')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password Masuk *</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            @error('password')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="role">Peran & Hak Akses (Role) *</label>
            <select id="role" name="role" class="form-control" required>
                <option value="">-- Pilih Peran Admin --</option>
                <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>👑 Super Admin (Akses Penuh Semua Modul & Kelola Akun)</option>
                <option value="admin_cms" {{ old('role') == 'admin_cms' ? 'selected' : '' }}>📰 Admin CMS (Kelola Berita, Galeri, Agenda & Pengumuman)</option>
                <option value="admin_ppdb" {{ old('role') == 'admin_ppdb' ? 'selected' : '' }}>📝 Admin PPDB (Verifikasi Pendaftar, Ubah Status, Hapus & Ekspor CSV)</option>
                <option value="editor_akademik" {{ old('role') == 'editor_akademik' ? 'selected' : '' }}>👨‍🏫 Editor Akademik (Kelola Dewan Guru, Staf & Program Jurusan)</option>
            </select>
            @error('role')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--adm-primary);">
                <span style="font-weight: 600; color: #ffffff;">Akun Aktif (Dapat Login ke Sistem)</span>
            </label>
            <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-left: 28px; margin-top: 4px;">
                Jika dinonaktifkan, akun tidak akan dapat mengakses panel admin.
            </div>
        </div>

        <div style="margin-top: 28px; display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <span>💾</span> Simpan Akun Admin
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
