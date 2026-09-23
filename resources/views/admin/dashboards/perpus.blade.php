@extends('layouts.admin')

@section('title', 'Dashboard Perpustakaan - At-Tamam Edu')

@section('content')
<!-- Hero Section -->
<div class="dashboard-hero" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: white; padding: 28px 32px; border-radius: 14px; margin-bottom: 28px; box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.3);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 255, 255, 0.2); padding: 4px 12px; border-radius: 9999px; font-size: 0.8rem; font-weight: 500; margin-bottom: 10px; backdrop-filter: blur(4px);">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
                Portal Petugas Perpustakaan
            </div>
            <h1 style="font-size: 1.75rem; font-weight: 800; margin: 0 0 6px 0; color: #ffffff;">
                Pusat Sirkulasi & Koleksi Buku Digital
            </h1>
            <p style="margin: 0; color: rgba(255, 255, 255, 0.85); font-size: 0.95rem;">
                Pantau sirkulasi peminjaman, buku aktif, pengembalian terlambat, dan ketersediaan koleksi.
            </p>
        </div>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.perpus.books.index') }}" class="btn" style="background: #ffffff; color: #002147; font-weight: 700; padding: 9px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><line x1="12" y1="5" x2="12" y2="19"/></svg>
                Katalog Buku
            </a>
            <a href="{{ route('admin.perpus.loans.export') }}" class="btn" style="background: rgba(255, 255, 255, 0.15); color: white; border: 1px solid rgba(255, 255, 255, 0.4); font-weight: 600; padding: 9px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; backdrop-filter: blur(4px);">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Ekspor Laporan
            </a>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 18px; margin-bottom: 28px;">
    <!-- Stat 1: Total Judul -->
    <a href="{{ route('admin.perpus.books.index') }}" class="card" style="padding: 20px; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s; border-left: 4px solid var(--adm-primary, #00B4D8);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span style="font-size: 0.85rem; font-weight: 600; color: var(--adm-text-sub, #f1f5f9);">Total Judul Buku</span>
            <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(0, 180, 216, 0.18); color: var(--adm-primary, #00B4D8); border: 1px solid rgba(0, 180, 216, 0.35); display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
            </div>
        </div>
        <div style="font-size: 1.85rem; font-weight: 800; color: var(--adm-text-title, #ffffff);">{{ $stats['total_books'] }}</div>
        <div style="font-size: 0.775rem; color: var(--adm-text-muted, #cbd5e1); margin-top: 4px;">Koleksi judul aktif</div>
    </a>

    <!-- Stat 2: Total Tersedia -->
    <div class="card" style="padding: 20px; border-left: 4px solid #10b981;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span style="font-size: 0.85rem; font-weight: 600; color: var(--adm-text-sub, #f1f5f9);">Eksemplar Tersedia</span>
            <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(16, 185, 129, 0.18); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div style="font-size: 1.85rem; font-weight: 800; color: var(--adm-text-title, #ffffff);">{{ $stats['total_available'] }}</div>
        <div style="font-size: 0.775rem; color: var(--adm-text-muted, #cbd5e1); margin-top: 4px;">Siap dipinjam siswa & umum</div>
    </div>

    <!-- Stat 3: Sedang Dipinjam -->
    <a href="{{ route('admin.perpus.loans.index', ['status' => 'dipinjam']) }}" class="card" style="padding: 20px; text-decoration: none; border-left: 4px solid #3b82f6;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span style="font-size: 0.85rem; font-weight: 600; color: var(--adm-text-sub, #f1f5f9);">Sedang Dipinjam</span>
            <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(59, 130, 246, 0.18); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.35); display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div style="font-size: 1.85rem; font-weight: 800; color: var(--adm-text-title, #ffffff);">{{ $stats['total_dipinjam'] }}</div>
        <div style="font-size: 0.775rem; color: var(--adm-text-muted, #cbd5e1); margin-top: 4px;">Sirkulasi buku aktif</div>
    </a>

    <!-- Stat 4: Terlambat -->
    <a href="{{ route('admin.perpus.loans.index', ['status' => 'terlambat']) }}" class="card" style="padding: 20px; text-decoration: none; border-left: 4px solid #ef4444;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span style="font-size: 0.85rem; font-weight: 600; color: var(--adm-text-sub, #f1f5f9);">Terlambat Kembali</span>
            <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(239, 68, 68, 0.18); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.35); display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div style="font-size: 1.85rem; font-weight: 800; color: #f87171;">{{ $stats['total_terlambat'] }}</div>
        <div style="font-size: 0.775rem; color: #fca5a5; margin-top: 4px;">Perlu ditindaklanjuti</div>
    </a>
</div>

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
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
