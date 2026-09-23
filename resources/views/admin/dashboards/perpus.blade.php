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
            <a href="{{ route('admin.perpus.books.index') }}" class="btn" style="background: white; color: #0369a1; font-weight: 600; padding: 9px 18px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
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
    <a href="{{ route('admin.perpus.books.index') }}" class="card" style="padding: 20px; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s; border-left: 4px solid #0284c7;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Total Judul Buku</span>
            <div style="width: 36px; height: 36px; border-radius: 8px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
            </div>
        </div>
        <div style="font-size: 1.85rem; font-weight: 800; color: #0f172a;">{{ $stats['total_books'] }}</div>
        <div style="font-size: 0.775rem; color: #64748b; margin-top: 4px;">Koleksi judul aktif</div>
    </a>

    <!-- Stat 2: Total Tersedia -->
    <div class="card" style="padding: 20px; border-left: 4px solid #10b981;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Eksemplar Tersedia</span>
            <div style="width: 36px; height: 36px; border-radius: 8px; background: #dcfce7; color: #15803d; display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div style="font-size: 1.85rem; font-weight: 800; color: #0f172a;">{{ $stats['total_available'] }}</div>
        <div style="font-size: 0.775rem; color: #64748b; margin-top: 4px;">Siap dipinjam siswa & umum</div>
    </div>

    <!-- Stat 3: Sedang Dipinjam -->
    <a href="{{ route('admin.perpus.loans.index', ['status' => 'dipinjam']) }}" class="card" style="padding: 20px; text-decoration: none; border-left: 4px solid #3b82f6;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Sedang Dipinjam</span>
            <div style="width: 36px; height: 36px; border-radius: 8px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div style="font-size: 1.85rem; font-weight: 800; color: #0f172a;">{{ $stats['total_dipinjam'] }}</div>
        <div style="font-size: 0.775rem; color: #64748b; margin-top: 4px;">Sirkulasi buku aktif</div>
    </a>

    <!-- Stat 4: Terlambat -->
    <a href="{{ route('admin.perpus.loans.index', ['status' => 'terlambat']) }}" class="card" style="padding: 20px; text-decoration: none; border-left: 4px solid #ef4444;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">Terlambat Kembali</span>
            <div style="width: 36px; height: 36px; border-radius: 8px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div style="font-size: 1.85rem; font-weight: 800; color: #dc2626;">{{ $stats['total_terlambat'] }}</div>
        <div style="font-size: 0.775rem; color: #dc2626; margin-top: 4px;">Perlu ditindaklanjuti</div>
    </a>
</div>

<!-- Main Content Grid -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
    <!-- Recent Loans Table -->
    <div class="card" style="padding: 22px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: #1e293b; margin: 0; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Peminjaman Terbaru
            </h3>
            <a href="{{ route('admin.perpus.loans.index') }}" style="font-size: 0.85rem; color: #0284c7; text-decoration: none; font-weight: 600;">Lihat Semua &rarr;</a>
        </div>

        <div class="table-responsive">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                <thead>
                    <tr style="color: #64748b; border-bottom: 1px solid #e2e8f0; text-align: left;">
                        <th style="padding: 8px 10px; font-weight: 600;">Kode / Tanggal</th>
                        <th style="padding: 8px 10px; font-weight: 600;">Peminjam</th>
                        <th style="padding: 8px 10px; font-weight: 600;">Buku</th>
                        <th style="padding: 8px 10px; font-weight: 600; text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLoans as $loan)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 10px;">
                            <a href="{{ route('admin.perpus.loans.show', $loan->id) }}" style="font-family: monospace; font-weight: 700; color: #0284c7; text-decoration: none;">
                                {{ $loan->loan_code }}
                            </a>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $loan->created_at->diffForHumans() }}</div>
                        </td>
                        <td style="padding: 10px;">
                            <div style="font-weight: 600; color: #1e293b;">{{ $loan->member->full_name }}</div>
                            <div style="font-size: 0.775rem; color: #64748b;">{{ $loan->member->phone }}</div>
                        </td>
                        <td style="padding: 10px; color: #334155;">
                            {{ Str::limit($loan->book->title, 25) }}
                        </td>
                        <td style="padding: 10px; text-align: center;">
                            @php
                                $badgeStyles = match($loan->status) {
                                    'diajukan'     => 'background-color: #fef3c7; color: #b45309;',
                                    'dipinjam'     => 'background-color: #dbeafe; color: #1d4ed8;',
                                    'dikembalikan' => 'background-color: #dcfce7; color: #15803d;',
                                    'terlambat'    => 'background-color: #fee2e2; color: #b91c1c;',
                                    default        => 'background-color: #f1f5f9; color: #475569;',
                                };
                            @endphp
                            <span style="padding: 3px 8px; border-radius: 9999px; font-size: 0.725rem; font-weight: 600; display: inline-block; {{ $badgeStyles }}">
                                {{ $loan->status_label }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 24px; text-align: center; color: #94a3b8;">
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
        <h3 style="font-size: 1.05rem; font-weight: 700; color: #1e293b; margin: 0 0 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Buku Paling Populer
        </h3>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            @forelse($topBooks as $index => $item)
            <div style="display: flex; align-items: center; gap: 12px; padding: 10px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                <div style="width: 26px; height: 26px; border-radius: 9999px; background: {{ $index === 0 ? '#fef08a; color: #854d0e;' : ($index === 1 ? '#e2e8f0; color: #475569;' : '#f1f5f9; color: #64748b;') }}; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                    {{ $index + 1 }}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 600; color: #1e293b; font-size: 0.875rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $item->book ? $item->book->title : 'Buku #' . $item->book_id }}
                    </div>
                    <div style="font-size: 0.775rem; color: #64748b;">
                        {{ $item->book ? $item->book->author : '-' }}
                    </div>
                </div>
                <div style="text-align: right;">
                    <span style="background: #e0f2fe; color: #0369a1; font-weight: 700; font-size: 0.8rem; padding: 2px 8px; border-radius: 6px;">
                        {{ $item->total }}x dipinjam
                    </span>
                </div>
            </div>
            @empty
            <div style="padding: 24px; text-align: center; color: #94a3b8; font-size: 0.875rem;">
                Belum ada data sirkulasi buku.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
