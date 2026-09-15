@extends('layouts.admin')

@section('title', 'Super Admin Dashboard - At-Tamam Edu')

@section('content')
<!-- DASHBOARD HERO BANNER (SUPER ADMIN) -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <span>🛡️</span>
            <span>SUPER ADMIN CONTROL CENTER</span>
        </div>
        <h1 class="hero-title">Pusat Kendali Eksekutif & Sistem Terintegrasi</h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <span>👥</span> Kelola Pengguna Admin
        </a>
        <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <span>📝</span> Data PPDB
        </a>
    </div>
</div>

<!-- STATISTIK UTAMA (GRID KARTU PROPORSIONAL) -->
<div class="stats-grid">
    <!-- Card User Admin -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">ADMIN AKTIF</span>
            <div class="stat-card-icon icon-cyan">👥</div>
        </div>
        <div class="stat-card-val">{{ $stats['total_users'] }}</div>
        <div class="stat-card-sub">Akun pengelola sistem</div>
    </div>

    <!-- Card Berita -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">TOTAL BERITA</span>
            <div class="stat-card-icon icon-sky">📰</div>
        </div>
        <div class="stat-card-val">{{ $stats['total_news'] }}</div>
        <div class="stat-card-sub">Artikel & pengumuman CMS</div>
    </div>

    <!-- Card Guru & Staf -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">GURU & STAF</span>
            <div class="stat-card-icon icon-emerald">👨‍🏫</div>
        </div>
        <div class="stat-card-val">{{ $stats['total_teachers'] }}</div>
        <div class="stat-card-sub">Tenaga pendidik & staf</div>
    </div>

    <!-- Card Pendaftar PPDB -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">PENDAFTAR PPDB</span>
            <div class="stat-card-icon icon-amber">📝</div>
        </div>
        <div class="stat-card-val">{{ $stats['total_ppdb'] }}</div>
        <div class="stat-card-sub">Calon peserta didik baru</div>
    </div>
</div>

<!-- BREAKDOWN STATUS PPDB (MINI STATS) -->
<div class="card card-ppdb-breakdown">
    <div class="ppdb-breakdown-header">
        <h3 class="ppdb-breakdown-title">
            <span>📊</span> Distribusi Status Seleksi PPDB Online
        </h3>
        <span class="ppdb-breakdown-badge">Total {{ $stats['total_ppdb'] }} Calon Siswa</span>
    </div>
    <div class="ppdb-mini-stats-grid">
        <div class="ppdb-mini-stat ppdb-stat-pending">
            <div class="ppdb-mini-label">⏳ Menunggu Verifikasi</div>
            <div class="ppdb-mini-val">{{ $stats['ppdb_pending'] }}</div>
        </div>
        <div class="ppdb-mini-stat ppdb-stat-verified">
            <div class="ppdb-mini-label">📑 Terverifikasi Berkas</div>
            <div class="ppdb-mini-val">{{ $stats['ppdb_diverifikasi'] }}</div>
        </div>
        <div class="ppdb-mini-stat ppdb-stat-accepted">
            <div class="ppdb-mini-label">✅ Diterima (Lolos)</div>
            <div class="ppdb-mini-val">{{ $stats['ppdb_diterima'] }}</div>
        </div>
        <div class="ppdb-mini-stat ppdb-stat-rejected">
            <div class="ppdb-mini-label">❌ Ditolak / Gugur</div>
            <div class="ppdb-mini-val">{{ $stats['ppdb_ditolak'] }}</div>
        </div>
    </div>
</div>

<!-- DUA KOLOM: AUDIT LOGS & USER ADMIN TERBARU -->
<div class="admin-grid-2col">
    <!-- Kolom 1: Log Aktivitas Audit Trail -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; color: #ffffff; margin-bottom: 2px;">Jejak Audit Aktivitas (Activity Logs)</h3>
                <span style="font-size: 0.8rem; color: var(--adm-text-muted);">Merekam riwayat seluruh aksi admin pada data krusial</span>
            </div>
            <span class="badge badge-info">{{ count($recentLogs) }} Terakhir</span>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Modul</th>
                        <th>Aksi</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLogs as $log)
                    <tr>
                        <td style="font-size: 0.8rem; color: var(--adm-text-muted); white-space: nowrap;">
                            {{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}
                        </td>
                        <td style="font-weight: 700;">
                            {{ $log->user ? $log->user->name : 'Sistem' }}
                        </td>
                        <td>
                            <span class="badge badge-info">{{ strtoupper($log->module) }}</span>
                        </td>
                        <td>
                            <span style="font-family: monospace; font-size: 0.82rem; font-weight: 700; color: #38bdf8;">{{ strtoupper($log->action) }}</span>
                        </td>
                        <td style="font-size: 0.85rem; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $log->description ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--adm-text-muted); padding: 24px;">Belum ada log aktivitas tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kolom 2: Daftar Akun Pengelola Sistem -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <div>
                <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff;">Pengelola Sistem</h3>
                <span style="font-size: 0.78rem; color: var(--adm-text-muted);">Akun administrator aktif</span>
            </div>
            <a href="{{ route('admin.users.index') }}" style="font-size: 0.8rem; color: var(--adm-primary); font-weight: 700; text-decoration: none; padding: 4px 10px; border-radius: 6px; background: rgba(0, 180, 216, 0.1);">Semua →</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px;">
            @foreach($recentUsers as $u)
            <div style="display: flex; align-items: center; gap: 12px; padding: 11px 13px; background: rgba(0, 0, 0, 0.25); border: 1px solid var(--adm-border); border-radius: 12px; transition: border-color 0.2s ease;">
                <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--adm-primary-gradient); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.88rem; flex-shrink: 0; box-shadow: 0 2px 8px var(--adm-primary-glow);">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 3px;">
                        <div style="font-size: 0.88rem; font-weight: 700; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $u->name }}">
                            {{ $u->name }}
                        </div>
                        <span class="badge {{ $u->role === 'super_admin' ? 'badge-danger' : ($u->role === 'admin_cms' ? 'badge-info' : ($u->role === 'admin_ppdb' ? 'badge-warning' : 'badge-success')) }}" style="font-size: 0.68rem; padding: 2px 7px; flex-shrink: 0; white-space: nowrap;">
                            {{ $u->role_label }}
                        </span>
                    </div>
                    <div style="font-size: 0.77rem; font-family: 'JetBrains Mono', monospace; color: var(--adm-text-sub); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center; gap: 5px;" title="{{ $u->email }}">
                        <span style="opacity: 0.6; font-size: 0.72rem; flex-shrink: 0;">✉</span>
                        <span style="overflow: hidden; text-overflow: ellipsis;">{{ $u->email }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--adm-border);">
            <a href="{{ route('admin.users.create') }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px;">
                <span>➕</span> Tambah Pengguna Admin Baru
            </a>
        </div>
    </div>
</div>
@endsection
