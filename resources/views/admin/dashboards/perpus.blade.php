@extends('layouts.admin')

@section('title', 'Dashboard Perpustakaan - At-Tamam Edu')

@section('content')
<!-- HERO BANNER (ADMIN PERPUS) -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
            <span>Portal Petugas Perpustakaan</span>
        </div>
        <h1 class="hero-title">Pusat Sirkulasi & Koleksi Buku Digital</h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.perpus.books.index') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><line x1="12" y1="5" x2="12" y2="19"/></svg>
            <span>Katalog Buku</span>
        </a>
        <a href="{{ route('admin.perpus.loans.export') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            <span>Ekspor Laporan CSV</span>
        </a>
    </div>
</div>

<!-- KARTU STATISTIK PERPUSTAKAAN -->
<div class="stats-grid">
    <!-- Stat 1: Total Judul -->
    <a href="{{ route('admin.perpus.books.index') }}" class="card stat-card-item" style="text-decoration: none;">
        <div class="stat-card-header">
            <span class="stat-card-label">TOTAL JUDUL BUKU</span>
            <div class="stat-card-icon icon-cyan">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
            </div>
        </div>
        <div class="stat-card-val">{{ $stats['total_books'] }}</div>
        <div class="stat-card-sub">Koleksi judul aktif</div>
    </a>

    <!-- Stat 2: Total Tersedia -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">EKSEMPLAR TERSEDIA</span>
            <div class="stat-card-icon icon-emerald">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #34d399;">{{ $stats['total_available'] }}</div>
        <div class="stat-card-sub">Siap dipinjam santri & umum</div>
    </div>

    <!-- Stat 3: Sedang Dipinjam -->
    <a href="{{ route('admin.perpus.loans.index', ['status' => 'dipinjam']) }}" class="card stat-card-item" style="text-decoration: none;">
        <div class="stat-card-header">
            <span class="stat-card-label">SEDANG DIPINJAM</span>
            <div class="stat-card-icon icon-sky">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #38bdf8;">{{ $stats['total_dipinjam'] }}</div>
        <div class="stat-card-sub">Sirkulasi buku aktif</div>
    </a>

    <!-- Stat 4: Pengajuan Pending (Menunggu Verifikasi) -->
    <a href="{{ route('admin.perpus.loans.index', ['status' => 'diajukan']) }}" class="card stat-card-item" style="text-decoration: none;">
        <div class="stat-card-header">
            <span class="stat-card-label">PENGAJUAN PENDING</span>
            <div class="stat-card-icon icon-amber">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #fbbf24;">{{ $stats['total_pending'] ?? 0 }}</div>
        <div class="stat-card-sub">Menunggu verifikasi admin</div>
    </a>

    <!-- Stat 5: Terlambat -->
    <a href="{{ route('admin.perpus.loans.index', ['status' => 'terlambat']) }}" class="card stat-card-item" style="text-decoration: none;">
        <div class="stat-card-header">
            <span class="stat-card-label">TERLAMBAT KEMBALI</span>
            <div class="stat-card-icon icon-rose">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #f87171;">{{ $stats['total_terlambat'] }}</div>
        <div class="stat-card-sub">Perlu tindak lanjut petugas</div>
    </a>
</div>

<!-- Main Content Grid -->
<div class="admin-perpus-main-grid">
    <!-- Recent Loans Table -->
    <div class="card" style="padding: 22px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.12)); padding-bottom: 12px;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Peminjaman Terbaru
            </h3>
            <a href="{{ route('admin.perpus.loans.index') }}" style="font-size: 0.85rem; color: var(--adm-primary, #00B4D8); text-decoration: none; font-weight: 600;">Lihat Semua &rarr;</a>
        </div>

        <div class="table-responsive">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                <thead>
                    <tr style="color: var(--adm-text-title, #ffffff); background-color: rgba(0, 180, 216, 0.10); border-bottom: 2px solid var(--adm-border, rgba(0, 180, 216, 0.3)); text-align: left;">
                        <th style="padding: 10px 12px; font-weight: 600;">Kode / Tanggal</th>
                        <th style="padding: 10px 12px; font-weight: 600;">Peminjam</th>
                        <th style="padding: 10px 12px; font-weight: 600;">Buku</th>
                        <th style="padding: 10px 12px; font-weight: 600; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLoans as $loan)
                    <tr style="border-bottom: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.08));">
                        <td style="padding: 12px 10px;">
                            <a href="{{ route('admin.perpus.loans.show', $loan->id) }}" style="font-family: monospace; font-weight: 700; color: var(--adm-primary, #00B4D8); text-decoration: none;">
                                {{ $loan->loan_code }}
                            </a>
                            <div style="font-size: 0.75rem; color: var(--adm-text-muted, #cbd5e1); margin-top: 2px;">{{ $loan->created_at->diffForHumans() }}</div>
                        </td>
                        <td style="padding: 12px 10px;">
                            <div style="font-weight: 600; color: var(--adm-text-title, #ffffff);">{{ $loan->member->full_name }}</div>
                            <div style="font-size: 0.775rem; color: var(--adm-text-muted, #cbd5e1);">{{ $loan->member->phone }}</div>
                        </td>
                        <td style="padding: 12px 10px; color: var(--adm-text-sub, #f1f5f9);">
                            {{ Str::limit($loan->book->title, 25) }}
                        </td>
                        <td style="padding: 12px 10px; text-align: center;">
                            @php
                                $badgeStyles = match($loan->status) {
                                    'diajukan'     => 'background-color: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4);',
                                    'dipinjam'     => 'background-color: rgba(56, 189, 248, 0.2); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4);',
                                    'dikembalikan' => 'background-color: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4);',
                                    'terlambat'    => 'background-color: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4);',
                                    default        => 'background-color: rgba(255, 255, 255, 0.1); color: #cbd5e1;',
                                };
                            @endphp
                            <span style="padding: 4px 10px; border-radius: 9999px; font-size: 0.725rem; font-weight: 600; display: inline-block; {{ $badgeStyles }}">
                                {{ $loan->status_label }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 24px; text-align: center; color: var(--adm-text-muted, #cbd5e1);">
                            Belum ada riwayat peminjaman buku.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Books Column -->
    <div class="card" style="padding: 22px;">
        <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0 0 16px; border-bottom: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.12)); padding-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Buku Paling Populer
        </h3>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            @forelse($topBooks as $index => $item)
            <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: rgba(255, 255, 255, 0.05); border-radius: 10px; border: 1px solid var(--adm-border, rgba(0, 180, 216, 0.25));">
                <div style="width: 28px; height: 28px; border-radius: 9999px; {{ $index === 0 ? 'background: rgba(245, 158, 11, 0.25); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.5);' : ($index === 1 ? 'background: rgba(203, 213, 225, 0.2); color: #e2e8f0; border: 1px solid rgba(203, 213, 225, 0.4);' : 'background: rgba(255, 255, 255, 0.08); color: var(--adm-text-sub, #f1f5f9); border: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.12));') }}; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem; flex-shrink: 0;">
                    {{ $index + 1 }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; color: var(--adm-text-title, #ffffff); font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $item->book ? $item->book->title : 'Buku #' . $item->book_id }}
                    </div>
                    <div style="font-size: 0.775rem; color: var(--adm-text-muted, #cbd5e1);">
                        {{ $item->book ? $item->book->author : '-' }}
                    </div>
                </div>
                <div style="text-align: right; flex-shrink: 0;">
                    <span style="background: rgba(0, 180, 216, 0.18); color: var(--adm-primary, #00B4D8); border: 1px solid rgba(0, 180, 216, 0.35); font-weight: 700; font-size: 0.8rem; padding: 3px 9px; border-radius: 6px; display: inline-block;">
                        {{ $item->total }}x dipinjam
                    </span>
                </div>
            </div>
            @empty
            <div style="padding: 24px; text-align: center; color: var(--adm-text-muted, #cbd5e1); font-size: 0.875rem;">
                Belum ada data sirkulasi buku.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
