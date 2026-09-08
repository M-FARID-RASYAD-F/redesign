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

<!-- STATISTIK UTAMA (GRID KARTU) -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 26px;">
    <!-- Card User Admin -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">ADMIN AKTIF</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0, 180, 216, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">👥</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #ffffff;">{{ $stats['total_users'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Akun pengelola sistem</div>
    </div>

    <!-- Card Berita -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">TOTAL BERITA</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(56, 189, 248, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📰</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #ffffff;">{{ $stats['total_news'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Artikel & pengumuman CMS</div>
    </div>

    <!-- Card Guru & Staf -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">GURU & STAF</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">👨‍🏫</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #ffffff;">{{ $stats['total_teachers'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Tenaga pendidik & staf</div>
    </div>

    <!-- Card Pendaftar PPDB -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">PENDAFTAR PPDB</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(245, 158, 11, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📝</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #ffffff;">{{ $stats['total_ppdb'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Calon peserta didik baru</div>
    </div>
</div>

<!-- BREAKDOWN STATUS PPDB (MINI STATS) -->
<div class="card" style="margin-bottom: 26px;">
    <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
        <span>📊</span> Distribusi Status Seleksi PPDB Online
    </h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
        <div style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 12px; padding: 16px;">
            <span style="font-size: 0.8rem; color: #fbbf24; font-weight: 700; text-transform: uppercase;">⏳ Menunggu Verifikasi</span>
            <div style="font-size: 1.8rem; font-weight: 800; color: #fbbf24; margin-top: 4px;">{{ $stats['ppdb_pending'] }}</div>
        </div>
        <div style="background: rgba(0, 180, 216, 0.1); border: 1px solid rgba(0, 180, 216, 0.3); border-radius: 12px; padding: 16px;">
            <span style="font-size: 0.8rem; color: #38bdf8; font-weight: 700; text-transform: uppercase;">📑 Terverifikasi Berkas</span>
            <div style="font-size: 1.8rem; font-weight: 800; color: #38bdf8; margin-top: 4px;">{{ $stats['ppdb_diverifikasi'] }}</div>
        </div>
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 12px; padding: 16px;">
            <span style="font-size: 0.8rem; color: #34d399; font-weight: 700; text-transform: uppercase;">✅ Diterima (Lolos)</span>
            <div style="font-size: 1.8rem; font-weight: 800; color: #34d399; margin-top: 4px;">{{ $stats['ppdb_diterima'] }}</div>
        </div>
        <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 16px;">
            <span style="font-size: 0.8rem; color: #f87171; font-weight: 700; text-transform: uppercase;">❌ Ditolak / Gugur</span>
            <div style="font-size: 1.8rem; font-weight: 800; color: #f87171; margin-top: 4px;">{{ $stats['ppdb_ditolak'] }}</div>
        </div>
    </div>
</div>

<!-- DUA KOLOM: AUDIT LOGS & USER ADMIN TERBARU -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
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
            <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff;">Pengelola Sistem</h3>
            <a href="{{ route('admin.users.index') }}" style="font-size: 0.8rem; color: var(--adm-primary); font-weight: 700; text-decoration: none;">Semua →</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($recentUsers as $u)
            <div style="display: flex; align-items: center; gap: 12px; padding: 10px 12px; background: rgba(0, 0, 0, 0.25); border: 1px solid var(--adm-border); border-radius: 10px;">
                <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--adm-primary-gradient); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem;">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-size: 0.88rem; font-weight: 700; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $u->name }}</div>
                    <div style="font-size: 0.76rem; color: var(--adm-text-muted);">{{ $u->email }}</div>
                </div>
                <div>
                    <span class="badge {{ $u->role === 'super_admin' ? 'badge-danger' : ($u->role === 'admin_cms' ? 'badge-info' : ($u->role === 'admin_ppdb' ? 'badge-warning' : 'badge-success')) }}" style="font-size: 0.7rem;">
                        {{ $u->role_label }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 18px; padding-top: 14px; border-top: 1px solid var(--adm-border);">
            <a href="{{ route('admin.users.create') }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center;">
                ➕ Tambah Pengguna Admin Baru
            </a>
        </div>
    </div>
</div>
@endsection
