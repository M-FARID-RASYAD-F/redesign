@extends('layouts.admin')

@section('title', 'Dashboard Admin - At-Tamam Edu')

@push('styles')
<style>
    /* ═══════════════════════════════════════════════════════════
       DASHBOARD HERO BANNER
       ═══════════════════════════════════════════════════════════ */
    .dashboard-hero {
        position: relative;
        border-radius: 20px;
        padding: 30px 32px;
        margin-bottom: 26px;
        background: var(--adm-card-bg);
        border: 1.5px solid var(--adm-border);
        box-shadow: var(--adm-shadow);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 22px;
        transition: border-color 0.3s ease;
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -10%;
        width: 60%;
        height: 200%;
        background: radial-gradient(circle, var(--adm-primary-glow) 0%, transparent 65%);
        pointer-events: none;
        opacity: 0.6;
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 680px;
    }

    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.76rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--adm-primary);
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid var(--adm-border);
        padding: 5px 12px;
        border-radius: 20px;
        margin-bottom: 12px;
    }

    .hero-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #ffffff !important;
        line-height: 1.25;
        margin-bottom: 8px;
        letter-spacing: -0.02em;
    }

    .hero-desc {
        font-size: 0.94rem;
        color: var(--adm-text-sub) !important;
        line-height: 1.6;
        margin-bottom: 18px;
    }

    .hero-meta-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 700;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--adm-border);
        color: #ffffff !important;
    }

    .hero-actions {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
        flex-shrink: 0;
    }

    /* ═══════════════════════════════════════════════════════════
       PPDB PENDING ALERT BANNER
       ═══════════════════════════════════════════════════════════ */
    .ppdb-alert-card {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.18) 0%, rgba(180, 83, 9, 0.25) 100%);
        border: 1.5px solid rgba(245, 158, 11, 0.55);
        color: #ffffff;
        padding: 16px 22px;
        border-radius: 16px;
        margin-bottom: 26px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.25);
    }

    .ppdb-alert-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .ppdb-alert-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(245, 158, 11, 0.3);
        border: 1.5px solid rgba(245, 158, 11, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .ppdb-alert-text h4 {
        font-size: 0.98rem;
        font-weight: 800;
        color: #ffffff !important;
        margin-bottom: 3px;
    }

    .ppdb-alert-text p {
        font-size: 0.85rem;
        color: #fef3c7 !important;
        line-height: 1.4;
    }

    .btn-alert-verify {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff !important;
        font-weight: 800;
        font-size: 0.86rem;
        padding: 9px 18px;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.4);
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.25s ease;
        flex-shrink: 0;
    }

    .btn-alert-verify:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.6);
        filter: brightness(1.1);
    }

    /* ═══════════════════════════════════════════════════════════
       STATS METRIC CARDS
       ═══════════════════════════════════════════════════════════ */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--adm-card-bg);
        border: 1.5px solid var(--adm-border);
        border-radius: 16px;
        padding: 22px 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 14px;
        box-shadow: var(--adm-shadow);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 80px;
        height: 80px;
        background: radial-gradient(circle at 100% 0%, var(--adm-primary-glow) 0%, transparent 70%);
        pointer-events: none;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        border-color: var(--adm-border-hover);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4), 0 0 20px var(--adm-primary-glow);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: rgba(255, 255, 255, 0.08);
        border: 1.5px solid var(--adm-border);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }

    .stat-pill {
        font-size: 0.72rem;
        font-weight: 800;
        padding: 4px 8px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid var(--adm-border);
        color: var(--adm-primary);
    }

    .stat-number {
        font-size: 2.1rem;
        font-weight: 800;
        color: #ffffff !important;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .stat-label {
        font-size: 0.88rem;
        color: var(--adm-text-muted) !important;
        font-weight: 700;
        margin-top: 4px;
    }

    .stat-footer-link {
        font-size: 0.80rem;
        font-weight: 800;
        color: var(--adm-primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 4px;
        transition: gap 0.2s ease;
    }

    .stat-footer-link:hover {
        gap: 8px;
        color: var(--adm-primary-hover);
    }

    /* ═══════════════════════════════════════════════════════════
       QUICK ACTION CENTER
       ═══════════════════════════════════════════════════════════ */
    .section-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ffffff !important;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 18px;
        margin-bottom: 30px;
    }

    .action-card {
        padding: 22px;
        border-radius: 16px;
        background: var(--adm-card-bg);
        border: 1.5px solid var(--adm-border);
        display: flex;
        flex-direction: column;
        gap: 12px;
        box-shadow: var(--adm-shadow);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .action-card:hover {
        transform: translateY(-4px);
        border-color: var(--adm-border-hover);
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.4), 0 0 22px var(--adm-primary-glow);
    }

    .action-icon-pill {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.08);
        border: 1.5px solid var(--adm-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
    }

    .action-card-title {
        font-weight: 800;
        font-size: 1.05rem;
        color: #ffffff !important;
    }

    .action-card-desc {
        font-size: 0.86rem;
        color: var(--adm-text-sub) !important;
        line-height: 1.55;
        margin-bottom: 6px;
    }

    /* ═══════════════════════════════════════════════════════════
       TWO COLUMN LAYOUT: AUDIT TRAIL + SYSTEM INFO
       ═══════════════════════════════════════════════════════════ */
    .dashboard-columns {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 22px;
        margin-bottom: 30px;
    }

    .table-scroll-hint {
        display: none;
        align-items: center;
        gap: 6px;
        font-size: 0.74rem;
        font-weight: 700;
        color: var(--adm-text-muted);
        margin-bottom: 8px;
        padding: 6px 10px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        border: 1px solid var(--adm-border);
    }

    .system-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid var(--adm-table-border);
        font-size: 0.86rem;
    }

    .system-info-item:last-child {
        border-bottom: none;
    }

    .system-info-label {
        color: var(--adm-text-muted) !important;
        font-weight: 700;
    }

    .system-info-value {
        color: #ffffff !important;
        font-weight: 700;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.84rem;
    }

    /* ═══════════════════════════════════════════════════════════
       RESPONSIF MOBILE KHUSUS HALAMAN DASHBOARD
       ═══════════════════════════════════════════════════════════ */
    @media (max-width: 1024px) {
        .dashboard-hero {
            flex-direction: column;
            align-items: stretch;
            padding: 22px 20px;
        }

        .dashboard-columns {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    @media (max-width: 680px) {
        .dashboard-hero {
            padding: 18px 16px;
            border-radius: 16px;
            gap: 16px;
        }

        .hero-title {
            font-size: 1.45rem;
        }

        .hero-desc {
            font-size: 0.86rem;
            margin-bottom: 14px;
        }

        .hero-actions {
            flex-direction: row;
            width: 100%;
            gap: 8px;
        }

        .hero-actions .btn {
            flex: 1;
            justify-content: center;
        }

        .ppdb-alert-card {
            flex-direction: column;
            align-items: stretch;
            padding: 16px 14px;
            gap: 14px;
        }

        .btn-alert-verify {
            width: 100%;
            justify-content: center;
        }

        /* 2 Kolom Stat Cards pada Mobile */
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .stat-card {
            padding: 14px 12px;
            border-radius: 14px;
            gap: 10px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1.25rem;
        }

        .stat-pill {
            font-size: 0.65rem;
            padding: 3px 6px;
        }

        .stat-number {
            font-size: 1.65rem;
        }

        .stat-label {
            font-size: 0.76rem;
        }

        .stat-footer-link {
            font-size: 0.72rem;
        }

        .quick-actions {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .action-card {
            padding: 18px 16px;
        }

        .action-card .btn {
            width: 100%;
            justify-content: center;
        }

        .table-scroll-hint {
            display: flex;
        }
    }

    @media (max-width: 400px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .hero-actions {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<!-- 1. Hero Command Center Banner -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <span>🛡️</span>
            <span>At-Tamam Master Control Panel</span>
        </div>
        <h1 class="hero-title">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="hero-desc">
            Pusat manajemen terpadu PKBM Tahfizh At-Tamam. Pantau dan kelola pendaftaran siswa baru, publikasi berita resmi, staf pendidik, serta program keahlian secara real-time.
        </p>
        <div class="hero-meta-chips">
            <div class="hero-chip">
                <span>👤</span>
                <span>Hak Akses: {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</span>
            </div>
            <div class="hero-chip">
                <span>📅</span>
                <span>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <div class="hero-chip">
                <span>🟢</span>
                <span>Sistem Operasional Normal</span>
            </div>
        </div>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">
            <span>➕</span> Tulis Berita
        </a>
        <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline btn-sm">
            <span>📋</span> Kelola PPDB
        </a>
    </div>
</div>

<!-- 2. Alert Pendaftaran PPDB Baru (Jika Ada yang Pending) -->
@if($ppdbPending > 0)
<div class="ppdb-alert-card">
    <div class="ppdb-alert-left">
        <div class="ppdb-alert-icon-wrap">⚠️</div>
        <div class="ppdb-alert-text">
            <h4>Ada {{ $ppdbPending }} Pendaftaran PPDB Baru Menunggu Verifikasi!</h4>
            <p>Silakan periksa berkas dan data calon peserta didik baru untuk proses seleksi lanjutan.</p>
        </div>
    </div>
    <a href="{{ route('admin.ppdb.index') }}" class="btn-alert-verify">
        Verifikasi Sekarang <span>→</span>
    </a>
</div>
@endif

<!-- 3. Key Performance Indicators (Stats Cards) -->
<div class="stats-grid">
    <!-- Card 1: Total Berita -->
    <div class="stat-card">
        <div>
            <div class="stat-header">
                <div class="stat-icon">📰</div>
                <span class="stat-pill">CMS Sekolah</span>
            </div>
            <div style="margin-top: 12px;">
                <div class="stat-number">{{ $stats['news'] }}</div>
                <div class="stat-label">Total Berita & Artikel</div>
            </div>
        </div>
        <a href="{{ route('admin.news.index') }}" class="stat-footer-link">
            Kelola Warta Sekolah <span>→</span>
        </a>
    </div>

    <!-- Card 2: Guru & Staf -->
    <div class="stat-card">
        <div>
            <div class="stat-header">
                <div class="stat-icon">👨‍🏫</div>
                <span class="stat-pill">Akademik</span>
            </div>
            <div style="margin-top: 12px;">
                <div class="stat-number">{{ $stats['teachers'] }}</div>
                <div class="stat-label">Guru & Staf Pengajar</div>
            </div>
        </div>
        <a href="{{ route('admin.teachers.index') }}" class="stat-footer-link">
            Lihat Tenaga Pendidik <span>→</span>
        </a>
    </div>

    <!-- Card 3: Pendaftar PPDB -->
    <div class="stat-card">
        <div>
            <div class="stat-header">
                <div class="stat-icon">📝</div>
                <span class="stat-pill" style="color: #f59e0b; border-color: rgba(245, 158, 11, 0.45); background: rgba(245, 158, 11, 0.18);">
                    {{ $ppdbPending }} Pending
                </span>
            </div>
            <div style="margin-top: 12px;">
                <div class="stat-number">{{ $stats['ppdb'] }}</div>
                <div class="stat-label">Calon Siswa PPDB</div>
            </div>
        </div>
        <a href="{{ route('admin.ppdb.index') }}" class="stat-footer-link">
            Verifikasi Pendaftar <span>→</span>
        </a>
    </div>

    <!-- Card 4: Total Jurusan -->
    <div class="stat-card">
        <div>
            <div class="stat-header">
                <div class="stat-icon">💻</div>
                <span class="stat-pill">Vokasi / Tahfizh</span>
            </div>
            <div style="margin-top: 12px;">
                <div class="stat-number">{{ $stats['majors'] }}</div>
                <div class="stat-label">Program Keahlian</div>
            </div>
        </div>
        <a href="{{ route('admin.majors.index') }}" class="stat-footer-link">
            Kelola Jurusan <span>→</span>
        </a>
    </div>
</div>

<!-- 4. Quick Actions Center -->
<div class="section-title">
    <span>⚡</span> Akses Cepat Manajemen
</div>
<div class="quick-actions">
    <div class="action-card">
        <div class="action-icon-pill">📰</div>
        <h3 class="action-card-title">Publikasi Warta Berita</h3>
        <p class="action-card-desc">
            Rilis kabar kegiatan, prestasi santri/siswa, atau pengumuman resmi sekolah langsung ke halaman portal publik.
        </p>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm" style="margin-top: auto; align-self: flex-start;">
            <span>➕</span> Tulis Berita Baru
        </a>
    </div>

    <div class="action-card">
        <div class="action-icon-pill">👨‍🏫</div>
        <h3 class="action-card-title">Registrasi Tenaga Pendidik</h3>
        <p class="action-card-desc">
            Daftarkan asatidz atau guru baru beserta mata pelajaran yang diampu dan kualifikasi akademik di sekolah.
        </p>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm" style="margin-top: auto; align-self: flex-start;">
            <span>➕</span> Tambah Guru Baru
        </a>
    </div>

    <div class="action-card">
        <div class="action-icon-pill">💻</div>
        <h3 class="action-card-title">Kurikulum & Jurusan</h3>
        <p class="action-card-desc">
            Perbarui deskripsi kejuruan, keunggulan laboratorium praktik, dan prospek karir lulusan sekolah.
        </p>
        <a href="{{ route('admin.majors.create') }}" class="btn btn-primary btn-sm" style="margin-top: auto; align-self: flex-start;">
            <span>➕</span> Tambah Jurusan
        </a>
    </div>
</div>

<!-- 5. Two Columns: Audit Trail Table + System Health Widget -->
<div class="dashboard-columns">
    <!-- Kolom Kiri: Audit Trail Log Aktivitas -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 8px;">
            <h3 style="font-size: 1.15rem; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                <span>🔍</span> Log Aktivitas Terbaru (Audit Trail)
            </h3>
            <span class="badge badge-info">10 Aksi Terakhir</span>
        </div>

        <!-- Hint geser tabel khusus mobile -->
        <div class="table-scroll-hint">
            <span>👈</span> Geser tabel ke samping untuk melihat detail log <span>👉</span>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Modul</th>
                        <th>Aksi</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLogs as $log)
                    <tr>
                        <td style="color: var(--adm-text-muted); font-size: 0.82rem; width: 170px; font-family: 'JetBrains Mono', monospace; white-space: nowrap;">
                            {{ $log->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                        </td>
                        <td style="white-space: nowrap;">
                            <div style="font-weight: 700; color: #ffffff;">
                                {{ $log->user->name ?? 'System' }}
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $log->module }}</span>
                        </td>
                        <td>
                            @if($log->action == 'create')
                                <span class="badge badge-success">Create</span>
                            @elseif($log->action == 'update' || $log->action == 'verify')
                                <span class="badge badge-warning">{{ ucfirst($log->action) }}</span>
                            @elseif($log->action == 'delete')
                                <span class="badge badge-danger">Delete</span>
                            @else
                                <span class="badge badge-info">{{ ucfirst($log->action) }}</span>
                            @endif
                        </td>
                        <td style="color: #ffffff; font-size: 0.88rem; min-width: 200px;">
                            {{ $log->description }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--adm-text-muted); padding: 36px;">
                            <div style="font-size: 2rem; margin-bottom: 8px;">📜</div>
                            Belum ada riwayat aktivitas terbaru yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kolom Kanan: Status Server & Info Cepat -->
    <div style="display: flex; flex-direction: column; gap: 18px;">
        <!-- Card Info Sistem -->
        <div class="card" style="margin-bottom: 0;">
            <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                <span>⚙️</span> Spesifikasi Sistem
            </h3>
            
            <div class="system-info-item">
                <span class="system-info-label">Versi PHP</span>
                <span class="system-info-value">v{{ phpversion() }}</span>
            </div>
            <div class="system-info-item">
                <span class="system-info-label">Versi Laravel</span>
                <span class="system-info-value">v{{ app()->version() }}</span>
            </div>
            <div class="system-info-item">
                <span class="system-info-label">Environment</span>
                <span class="system-info-value">{{ strtoupper(app()->environment()) }}</span>
            </div>
            <div class="system-info-item">
                <span class="system-info-label">Database</span>
                <span class="system-info-value">MySQL Active</span>
            </div>
            <div class="system-info-item">
                <span class="system-info-label">Keamanan Sesi</span>
                <span class="system-info-value" style="color: #34d399;">CSRF & Auth OK</span>
            </div>
        </div>

        <!-- Card Shortcut Cepat -->
        <div class="card" style="margin-bottom: 0;">
            <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                <span>🚀</span> Rekapitulasi Data PPDB
            </h3>
            <p style="font-size: 0.85rem; color: var(--adm-text-sub); line-height: 1.5; margin-bottom: 16px;">
                Unduh berkas rekap seluruh pendaftar calon santri/siswa baru ke format CSV spreadsheet secara instan.
            </p>
            <a href="{{ route('admin.ppdb.export') }}" class="btn btn-success btn-sm" style="width: 100%; justify-content: center;">
                <span>📥</span> Unduh Rekap CSV
            </a>
        </div>
    </div>
</div>
@endsection
