@extends('layouts.admin')

@section('title', 'Edit Akun Admin - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Edit Akun Admin</h1>
        <p style="color: var(--adm-text-muted); font-size: 0.9rem; margin-top: 4px;">
            Perbarui data kredensial atau peran untuk <strong>{{ $user->name }}</strong>. 
            Kembali ke <a href="{{ route('admin.users.index') }}" style="color: var(--adm-primary); text-decoration: none; font-weight: 600;">Daftar Pengguna Admin</a>
        </p>
    </div>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap *</label>
            <input type="text" id="name" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
            @error('name')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Alamat Email *</label>
            <input type="email" id="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
            @error('email')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password Baru (Opsional)</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
            <span style="font-size: 0.75rem; color: var(--adm-text-muted);">Biarkan kosong untuk tetap menggunakan password yang lama.</span>
            @error('password')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="role">Peran & Hak Akses (Role) *</label>
            <select id="role" name="role" class="form-control" required>
                <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>👑 Super Admin (Akses Penuh Semua Modul & Kelola Akun)</option>
                <option value="admin_cms" {{ old('role', $user->role) == 'admin_cms' ? 'selected' : '' }}>📰 Admin CMS (Kelola Berita, Galeri, Agenda & Pengumuman)</option>
                <option value="admin_ppdb" {{ old('role', $user->role) == 'admin_ppdb' ? 'selected' : '' }}>📝 Admin PPDB (Verifikasi Pendaftar, Ubah Status, Hapus & Ekspor CSV)</option>
                <option value="editor_akademik" {{ old('role', $user->role) == 'editor_akademik' ? 'selected' : '' }}>👨‍🏫 Editor Akademik (Kelola Dewan Guru, Staf & Program Jurusan)</option>
            </select>
            @error('role')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--adm-primary);">
                <span style="font-weight: 600; color: #ffffff;">Akun Aktif (Dapat Login ke Sistem)</span>
            </label>
            <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-left: 28px; margin-top: 4px;">
                Jika dinonaktifkan, akun ini tidak akan dapat login ke panel admin.
            </div>
        </div>

        <div style="margin-top: 28px; display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <span>💾</span> Perbarui Akun
            </button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
