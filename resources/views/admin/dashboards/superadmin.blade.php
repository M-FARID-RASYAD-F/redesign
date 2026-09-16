@extends('layouts.admin')

@section('title', 'Super Admin Dashboard - At-Tamam Edu')

@section('content')
<!-- DASHBOARD HERO BANNER (SUPER ADMIN) -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <span>SUPER ADMIN CONTROL CENTER</span>
        </div>
        <h1 class="hero-title">Pusat Kendali Eksekutif & Sistem Terintegrasi</h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span>Kelola Pengguna Admin</span>
        </a>
        <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="m9 14 2 2 4-4"/></svg>
            <span>Data PPDB</span>
        </a>
    </div>
</div>

<!-- STATISTIK UTAMA (GRID KARTU PROPORSIONAL) -->
<div class="stats-grid">
    <!-- Card User Admin -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">ADMIN AKTIF</span>
            <div class="stat-card-icon icon-cyan">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
        <div class="stat-card-val">{{ $stats['total_users'] }}</div>
        <div class="stat-card-sub">Akun pengelola sistem</div>
    </div>

    <!-- Card Berita -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">TOTAL BERITA</span>
            <div class="stat-card-icon icon-sky">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
            </div>
        </div>
        <div class="stat-card-val">{{ $stats['total_news'] }}</div>
        <div class="stat-card-sub">Artikel & pengumuman CMS</div>
    </div>

    <!-- Card Guru & Staf -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">GURU & STAF</span>
            <div class="stat-card-icon icon-emerald">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
        </div>
        <div class="stat-card-val">{{ $stats['total_teachers'] }}</div>
        <div class="stat-card-sub">Tenaga pendidik & staf</div>
    </div>

    <!-- Card Pendaftar PPDB -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">PENDAFTAR PPDB</span>
            <div class="stat-card-icon icon-amber">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="m9 14 2 2 4-4"/></svg>
            </div>
        </div>
        <div class="stat-card-val">{{ $stats['total_ppdb'] }}</div>
        <div class="stat-card-sub">Calon peserta didik baru</div>
    </div>
</div>

<!-- BREAKDOWN STATUS PPDB (MINI STATS) -->
<div class="card card-ppdb-breakdown">
    <div class="ppdb-breakdown-header">
        <h3 class="ppdb-breakdown-title" style="display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            <span>Distribusi Status Seleksi PPDB Online</span>
        </h3>
        <span class="ppdb-breakdown-badge">Total {{ $stats['total_ppdb'] }} Calon Siswa</span>
    </div>
    <div class="ppdb-mini-stats-grid">
        <div class="ppdb-mini-stat ppdb-stat-pending">
            <div class="ppdb-mini-label" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span>Menunggu Verifikasi</span>
            </div>
            <div class="ppdb-mini-val">{{ $stats['ppdb_pending'] }}</div>
        </div>
        <div class="ppdb-mini-stat ppdb-stat-verified">
            <div class="ppdb-mini-label" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="m9 15 2 2 4-4"/></svg>
                <span>Terverifikasi Berkas</span>
            </div>
            <div class="ppdb-mini-val">{{ $stats['ppdb_diverifikasi'] }}</div>
        </div>
        <div class="ppdb-mini-stat ppdb-stat-accepted">
            <div class="ppdb-mini-label" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span>Diterima (Lolos)</span>
            </div>
            <div class="ppdb-mini-val">{{ $stats['ppdb_diterima'] }}</div>
        </div>
        <div class="ppdb-mini-stat ppdb-stat-rejected">
            <div class="ppdb-mini-label" style="display: flex; align-items: center; justify-content: center; gap: 5px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <span>Ditolak / Gugur</span>
            </div>
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
                    <div style="font-size: 0.77rem; font-family: 'JetBrains Mono', monospace; color: var(--adm-text-sub); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: flex; align-items: center; gap: 6px;" title="{{ $u->email }}">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="opacity: 0.7; flex-shrink: 0;"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <span style="overflow: hidden; text-overflow: ellipsis;">{{ $u->email }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--adm-border);">
            <a href="{{ route('admin.users.create') }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Tambah Pengguna Admin Baru</span>
            </a>
        </div>
    </div>
</div>
@endsection
