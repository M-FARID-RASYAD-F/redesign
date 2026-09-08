@extends('layouts.admin')

@section('title', 'Kelola Pengguna Admin - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Pengguna Admin</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola akun staf, guru pembimbing, dan hak akses (RBAC) pada sistem.</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="document.getElementById('modalAddUser').style.display='flex'">
        <span>➕</span> Tambah Admin Baru
    </button>
</div>

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
    ✅ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
    ⚠️ {{ session('error') }}
</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Peran (Role RBAC)</th>
                    <th>Status Akun</th>
                    <th>Terdaftar</th>
                    <th style="width: 220px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--adm-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #fff;">{{ $u->name }}</div>
                                @if($u->id === auth()->id())
                                    <span style="font-size: 0.75rem; color: #38bdf8; font-weight: 600;">(Akun Anda Saat Ini)</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color: var(--text-muted); font-family: monospace;">{{ $u->email }}</td>
                    <td>
                        <form action="{{ route('admin.users.role', $u->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <select name="role" onchange="this.form.submit()" style="background: var(--adm-card-solid); color: #fff; border: 1px solid var(--border); padding: 4px 8px; border-radius: 6px; font-size: 0.85rem; cursor: pointer;">
                                <option value="super_admin" {{ $u->role === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin_cms" {{ $u->role === 'admin_cms' ? 'selected' : '' }}>Admin CMS</option>
                                <option value="admin_ppdb" {{ $u->role === 'admin_ppdb' ? 'selected' : '' }}>Admin PPDB</option>
                                <option value="editor_akademik" {{ $u->role === 'editor_akademik' ? 'selected' : '' }}>Editor Akademik</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        @if($u->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.85rem;">
                        {{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            @if($u->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-active', $u->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline btn-sm" style="font-size: 0.8rem; border-color: var(--border);">
                                        {{ $u->is_active ? '🔒 Nonaktifkan' : '🔓 Aktifkan' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Hapus pengguna admin {{ $u->name }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-trigger">🗑️</button>
                                </form>
                            @else
                                <span style="font-size: 0.8rem; color: var(--text-muted); padding: 4px 8px;">Terkunci</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada akun pengguna admin.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Pengguna Admin -->
<div id="modalAddUser" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: var(--adm-card-solid); border: 1px solid var(--border); border-radius: 12px; width: 100%; max-width: 520px; padding: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #fff;">Tambah Pengguna Admin Baru</h3>
            <button type="button" onclick="document.getElementById('modalAddUser').style.display='none'" style="background: transparent; border: none; color: #fff; font-size: 1.3rem; cursor: pointer;">✕</button>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="name" style="display: block; margin-bottom: 6px; font-weight: 600;">Nama Lengkap *</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Ahmad Zakaria, S.Pd." required>
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="email" style="display: block; margin-bottom: 6px; font-weight: 600;">Alamat Email *</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="admin@sekolah.sch.id" required>
            </div>

            <div class="form-group" style="margin-bottom: 16px;">
                <label class="form-label" for="role" style="display: block; margin-bottom: 6px; font-weight: 600;">Peran / Hak Akses (RBAC) *</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="super_admin">Super Admin / Guru Pembimbing (Akses Penuh)</option>
                    <option value="admin_cms">Admin CMS (Kelola Berita, Galeri, Pengumuman)</option>
                    <option value="admin_ppdb">Admin PPDB (Verifikasi Berkas, Status PPDB)</option>
                    <option value="editor_akademik">Editor Akademik (Kelola Guru & Jurusan)</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" for="password" style="display: block; margin-bottom: 6px; font-weight: 600;">Password Awal *</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" minlength="6" required>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('modalAddUser').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>
@endsection
