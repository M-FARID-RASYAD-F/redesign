@extends('layouts.admin')

@section('title', 'Kelola Pengguna Admin - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Pengguna & Hak Akses Admin</h1>
        <p style="color: var(--adm-text-muted); font-size: 0.9rem; margin-top: 4px;">
            Daftar akun administrator sistem PKBM Tahfizh At-Tamam beserta pembagian perannya.
        </p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        <span>Tambah Akun Admin</span>
    </a>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ session('error') }}</span>
    </div>
@endif

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Email Akun</th>
                    <th>Peran (Role)</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th style="width: 190px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; background: rgba(0, 180, 216, 0.2); color: #38bdf8; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0; font-size: 0.95rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #ffffff;">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span style="font-size: 0.72rem; padding: 2px 6px; border-radius: 4px; background: rgba(56, 189, 248, 0.2); color: #38bdf8; margin-left: 4px;">Anda</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; color: var(--adm-text-sub);">
                            {{ $user->email }}
                        </span>
                    </td>
                    <td>
                        @switch($user->role)
                            @case('super_admin')
                                <span class="badge" style="background: rgba(168, 85, 247, 0.2); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.4); display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    <span>Super Admin</span>
                                </span>
                                @break
                            @case('admin_cms')
                                <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/></svg>
                                    <span>Admin CMS</span>
                                </span>
                                @break
                            @case('admin_ppdb')
                                <span class="badge" style="background: rgba(0, 180, 216, 0.2); color: #38bdf8; border: 1px solid rgba(0, 180, 216, 0.4); display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                                    <span>Admin PPDB</span>
                                </span>
                                @break
                            @case('editor_akademik')
                                <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                    <span>Editor Akademik</span>
                                </span>
                                @break
                            @case('admin_perpus')
                                <span class="badge" style="background: rgba(14, 165, 233, 0.2); color: #38bdf8; border: 1px solid rgba(14, 165, 233, 0.4); display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10"/></svg>
                                    <span>Petugas Perpustakaan</span>
                                </span>
                                @break
                            @default
                                <span class="badge badge-info">{{ $user->role }}</span>
                        @endswitch
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-warning">Nonaktif</span>
                        @endif
                    </td>
                    <td style="font-size: 0.82rem; color: var(--adm-text-muted);">
                        {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <div style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 175px;">
                            @if($user->id === auth()->id())
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    <span>Edit</span>
                                </a>
                            @else
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm" style="flex: 1; justify-content: center; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    <span>Edit</span>
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus akun admin <strong>{{ $user->name }}</strong>? Tindakan ini tidak dapat dibatalkan." style="flex: 1; margin: 0; display: inline-flex;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-sm btn-delete-trigger" style="width: 100%; justify-content: center; border-color: rgba(239, 68, 68, 0.4); color: #f87171; display: inline-flex; align-items: center; gap: 4px;">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--adm-text-muted); padding: 24px;">Belum ada data pengguna admin.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
