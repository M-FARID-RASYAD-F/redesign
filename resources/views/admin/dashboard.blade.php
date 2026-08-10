@extends('layouts.admin')

@section('title', 'Dashboard Admin - At-Tamam Edu')

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: var(--shadow);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Modul-specific icon colors */
    .icon-news { background: #eff6ff; color: var(--primary); }
    .icon-teachers { background: #ecfdf5; color: var(--success); }
    .icon-ppdb { background: #fffbeb; color: var(--warning); }
    .icon-majors { background: #fdf2f8; color: #db2777; }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .action-card {
        padding: 20px;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        gap: 12px;
        box-shadow: var(--shadow);
    }

    .action-card-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #0f172a;
    }

    .action-card-desc {
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.4;
    }
</style>
@endpush

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Dashboard</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Selamat datang kembali, {{ auth()->user()->name }}. Kelola portal sekolah At-Tamam Edu disini.</p>
    </div>
</div>

@if($ppdbPending > 0)
<div style="background-color: #fffbeb; border: 1px solid #fde68a; color: #b45309; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 1.25rem;">⚠️</span>
        <span style="font-weight: 600;">Ada {{ $ppdbPending }} pendaftaran PPDB baru yang perlu diverifikasi!</span>
    </div>
    <a href="{{ route('admin.ppdb.index') }}" class="btn btn-primary btn-sm" style="background-color: var(--warning); color: #78350f;">Verifikasi Sekarang</a>
</div>
@endif

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-news">📰</div>
        <div class="stat-info">
            <span class="stat-number">{{ $stats['news'] }}</span>
            <span class="stat-label">Total Berita</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-teachers">👨‍🏫</div>
        <div class="stat-info">
            <span class="stat-number">{{ $stats['teachers'] }}</span>
            <span class="stat-label">Guru & Staf</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-ppdb">📝</div>
        <div class="stat-info">
            <span class="stat-number">{{ $stats['ppdb'] }}</span>
            <span class="stat-label">Pendaftar PPDB</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-majors">💻</div>
        <div class="stat-info">
            <span class="stat-number">{{ $stats['majors'] }}</span>
            <span class="stat-label">Total Jurusan</span>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <div class="action-card">
        <span style="font-size: 1.5rem;">📰</span>
        <h3 class="action-card-title">Publikasi Berita</h3>
        <p class="action-card-desc">Tulis artikel berita, pengumuman, atau prestasi terbaru sekolah untuk ditampilkan di portal depan.</p>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm" style="margin-top: auto; align-self: flex-start;">Tulis Berita</a>
    </div>
    <div class="action-card">
        <span style="font-size: 1.5rem;">👨‍🏫</span>
        <h3 class="action-card-title">Guru & Akademik</h3>
        <p class="action-card-desc">Tambahkan tenaga pendidik baru, perbarui mata pelajaran yang diampu, atau ubah status guru.</p>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm" style="margin-top: auto; align-self: flex-start;">Tambah Guru</a>
    </div>
    <div class="action-card">
        <span style="font-size: 1.5rem;">💻</span>
        <h3 class="action-card-title">Manajemen Jurusan</h3>
        <p class="action-card-desc">Kelola program keahlian yang dibuka di sekolah, perbarui deskripsi, atau ikon keahlian.</p>
        <a href="{{ route('admin.majors.create') }}" class="btn btn-primary btn-sm" style="margin-top: auto; align-self: flex-start;">Tambah Jurusan</a>
    </div>
</div>

<!-- Audit Trail Logs -->
<div class="card">
    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #0f172a; display: flex; align-items: center; gap: 8px;">
        <span>🔍</span> Log Aktivitas Terbaru (Audit Trail)
    </h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Modul</th>
                    <th>Aksi</th>
                    <th>Detail Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLogs as $log)
                <tr>
                    <td style="color: var(--text-muted); font-size: 0.85rem; width: 180px;">
                        {{ $log->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                    </td>
                    <td style="font-weight: 600;">
                        {{ $log->user->name ?? 'System' }}
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $log->module }}</span>
                    </td>
                    <td>
                        @if($log->action == 'create')
                            <span class="badge badge-success">{{ $log->action }}</span>
                        @elseif($log->action == 'update' || $log->action == 'verify')
                            <span class="badge badge-warning">{{ $log->action }}</span>
                        @elseif($log->action == 'delete')
                            <span class="badge badge-danger">{{ $log->action }}</span>
                        @else
                            <span class="badge badge-info">{{ $log->action }}</span>
                        @endif
                    </td>
                    <td style="color: var(--text-main);">
                        {{ $log->description }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada log aktivitas yang tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
