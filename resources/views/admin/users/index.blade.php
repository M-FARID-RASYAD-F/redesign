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
        <span>➕</span> Tambah Akun Admin
    </a>
</div>

@if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 600;">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #f87171; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-weight: 600;">
        ⚠️ {{ session('error') }}
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
                    <th style="width: 150px; text-align: right;">Aksi</th>
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
                                <span class="badge" style="background: rgba(168, 85, 247, 0.2); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.4);">👑 Super Admin</span>
                                @break
                            @case('admin_cms')
                                <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4);">📰 Admin CMS</span>
                                @break
                            @case('admin_ppdb')
                                <span class="badge" style="background: rgba(0, 180, 216, 0.2); color: #38bdf8; border: 1px solid rgba(0, 180, 216, 0.4);">📝 Admin PPDB</span>
                                @break
                            @case('editor_akademik')
                                <span class="badge" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4);">👨‍🏫 Editor Akademik</span>
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
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm">
                                ✏️ Edit
                            </a>

                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-sm" style="border-color: rgba(239, 68, 68, 0.4); color: #f87171;">
                                        🗑️ Hapus
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
