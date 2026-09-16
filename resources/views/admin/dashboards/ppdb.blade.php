@extends('layouts.admin')

@section('title', 'PPDB Dashboard - At-Tamam Edu')

@section('content')
<!-- HERO BANNER (ADMIN PPDB) -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="m9 14 2 2 4-4"/></svg>
            <span>PORTAL VERIFIKASI & SELEKSI PPDB ONLINE</span>
        </div>
        <h1 class="hero-title">Pusat Seleksi & Verifikasi Berkas Calon Siswa</h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.ppdb.export') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            <span>Ekspor CSV Rekap</span>
        </a>
        <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M3 15h18"/><path d="M9 3v18"/><path d="M15 3v18"/></svg>
            <span>Tabel Semua Pendaftar</span>
        </a>
    </div>
</div>

<!-- STATISTIK KARTU SELEKSI PPDB -->
<div class="stats-grid-5">
    <!-- Total Pendaftar -->
    <a href="{{ route('admin.ppdb.index') }}" class="card stat-card-item" style="text-decoration: none;">
        <div class="stat-card-header">
            <span class="stat-card-label">TOTAL PENDAFTAR</span>
            <div class="stat-card-icon icon-sky">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/><path d="m9 14 2 2 4-4"/></svg>
            </div>
        </div>
        <div class="stat-card-val">{{ $stats['total'] }}</div>
        <div class="stat-card-sub">Tahun 2026/2027 ↗</div>
    </a>

    <!-- Menunggu Verifikasi (Pending) -->
    <a href="{{ route('admin.ppdb.index', ['status' => 'pending']) }}" class="card stat-card-item" style="text-decoration: none; border-color: rgba(245, 158, 11, 0.45); background: rgba(245, 158, 11, 0.08);">
        <div class="stat-card-header">
            <span class="stat-card-label" style="color: #fbbf24;">PERLU VERIFIKASI</span>
            <div class="stat-card-icon icon-amber">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #fbbf24;">{{ $stats['pending'] }}</div>
        <div class="stat-card-sub" style="color: #fde68a;">Menunggu panitia ↗</div>
    </a>

    <!-- Terverifikasi -->
    <a href="{{ route('admin.ppdb.index', ['status' => 'diverifikasi']) }}" class="card stat-card-item" style="text-decoration: none; border-color: rgba(56, 189, 248, 0.4); background: rgba(56, 189, 248, 0.08);">
        <div class="stat-card-header">
            <span class="stat-card-label" style="color: #38bdf8;">BERKAS VALID</span>
            <div class="stat-card-icon icon-cyan">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="m9 15 2 2 4-4"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #38bdf8;">{{ $stats['diverifikasi'] }}</div>
        <div class="stat-card-sub" style="color: #bae6fd;">Dokumen lolos ↗</div>
    </a>

    <!-- Diterima -->
    <a href="{{ route('admin.ppdb.index', ['status' => 'diterima']) }}" class="card stat-card-item" style="text-decoration: none; border-color: rgba(16, 185, 129, 0.45); background: rgba(16, 185, 129, 0.08);">
        <div class="stat-card-header">
            <span class="stat-card-label" style="color: #34d399;">SISWA DITERIMA</span>
            <div class="stat-card-icon icon-emerald">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #34d399;">{{ $stats['diterima'] }}</div>
        <div class="stat-card-sub" style="color: #a7f3d0;">Siap registrasi ↗</div>
    </a>

    <!-- Ditolak -->
    <a href="{{ route('admin.ppdb.index', ['status' => 'ditolak']) }}" class="card stat-card-item ppdb-card-rejected" style="text-decoration: none; border-color: rgba(239, 68, 68, 0.4); background: rgba(239, 68, 68, 0.08);">
        <div class="stat-card-header">
            <span class="stat-card-label" style="color: #f87171;">TIDAK LOLOS</span>
            <div class="stat-card-icon icon-rose">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #f87171;">{{ $stats['ditolak'] }}</div>
        <div class="stat-card-sub" style="color: #fca5a5;">Tidak memenuhi ↗</div>
    </a>
</div>

<!-- REKAP PENDAFTAR PER TINGKATAN (SD, SMP, SMK) -->
<div style="margin-bottom: 26px;">
    <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        <span>Pendaftar Berdasarkan Tingkatan Pendidikan</span>
    </h3>
    <div class="stats-grid-3">
        <!-- SD -->
        <a href="{{ route('admin.ppdb.index', ['jenjang' => 'sd']) }}" class="card stat-card-item" style="text-decoration: none; border-color: rgba(16, 185, 129, 0.4); background: rgba(16, 185, 129, 0.08);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 0.8rem; color: #34d399; font-weight: 800; text-transform: uppercase;">SEKOLAH DASAR (SD)</span>
                    <div class="stat-card-val" style="margin-top: 4px;">{{ $stats['sd_total'] }}</div>
                    <span style="font-size: 0.78rem; color: #a7f3d0; font-weight: 600;">Kelola Pendaftar SD →</span>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; color: #34d399;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
                </div>
            </div>
        </a>

        <!-- SMP -->
        <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smp']) }}" class="card stat-card-item" style="text-decoration: none; border-color: rgba(56, 189, 248, 0.4); background: rgba(56, 189, 248, 0.08);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 0.8rem; color: #38bdf8; font-weight: 800; text-transform: uppercase;">MENENGAH PERTAMA (SMP)</span>
                    <div class="stat-card-val" style="margin-top: 4px;">{{ $stats['smp_total'] }}</div>
                    <span style="font-size: 0.78rem; color: #bae6fd; font-weight: 600;">Kelola Pendaftar SMP →</span>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(56, 189, 248, 0.15); display: flex; align-items: center; justify-content: center; color: #38bdf8;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
            </div>
        </a>

        <!-- SMK -->
        <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smk']) }}" class="card stat-card-item" style="text-decoration: none; border-color: rgba(168, 85, 247, 0.4); background: rgba(168, 85, 247, 0.08);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 0.8rem; color: #c084fc; font-weight: 800; text-transform: uppercase;">KEJURUAN (SMK)</span>
                    <div class="stat-card-val" style="margin-top: 4px;">{{ $stats['smk_total'] }}</div>
                    <span style="font-size: 0.78rem; color: #e9d5ff; font-weight: 600;">Kelola Pendaftar SMK →</span>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(168, 85, 247, 0.15); display: flex; align-items: center; justify-content: center; color: #c084fc;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- VISUAL BAR STATUS PROGRESS CHART -->
<div class="card" style="margin-bottom: 26px;">
    <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
        <span>Komposisi Kelulusan Seleksi Calon Siswa</span>
    </h3>
    @php
        $total = max($stats['total'], 1);
        $pctPending = round(($stats['pending'] / $total) * 100);
        $pctVerif = round(($stats['diverifikasi'] / $total) * 100);
        $pctDiterima = round(($stats['diterima'] / $total) * 100);
        $pctDitolak = round(($stats['ditolak'] / $total) * 100);
    @endphp
    <!-- Progress Bar Bertingkat -->
    <div style="height: 18px; width: 100%; border-radius: 999px; background: rgba(0,0,0,0.3); overflow: hidden; display: flex; margin-bottom: 14px; border: 1px solid var(--adm-border);">
        <div style="width: {{ $pctPending }}%; background: #fbbf24;" title="Pending: {{ $pctPending }}%"></div>
        <div style="width: {{ $pctVerif }}%; background: #38bdf8;" title="Diverifikasi: {{ $pctVerif }}%"></div>
        <div style="width: {{ $pctDiterima }}%; background: #34d399;" title="Diterima: {{ $pctDiterima }}%"></div>
        <div style="width: {{ $pctDitolak }}%; background: #ef4444;" title="Ditolak: {{ $pctDitolak }}%"></div>
    </div>
    <div style="display: flex; gap: 20px; flex-wrap: wrap; font-size: 0.82rem;">
        <span style="display: inline-flex; align-items: center; gap: 6px; color: #fbbf24;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #fbbf24;"></span> Pending ({{ $pctPending }}%)
        </span>
        <span style="display: inline-flex; align-items: center; gap: 6px; color: #38bdf8;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #38bdf8;"></span> Diverifikasi ({{ $pctVerif }}%)
        </span>
        <span style="display: inline-flex; align-items: center; gap: 6px; color: #34d399;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #34d399;"></span> Diterima ({{ $pctDiterima }}%)
        </span>
        <span style="display: inline-flex; align-items: center; gap: 6px; color: #f87171;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444;"></span> Ditolak ({{ $pctDitolak }}%)
        </span>
    </div>
</div>

<!-- ANTREAN VERIFIKASI PENDAFTAR PENDING -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div>
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #ffffff; margin-bottom: 2px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="#fbbf24" stroke-width="2" viewBox="0 0 24 24"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <span>Antrean Pendaftar Baru (Perlu Tindakan Verifikasi Segera)</span>
            </h3>
            <span style="font-size: 0.8rem; color: var(--adm-text-muted);">Klik tombol "Verifikasi Sekarang" untuk memeriksa berkas dan menentukan status seleksi</span>
        </div>
        <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline btn-sm">Buka Semua Data →</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Pendaftaran</th>
                    <th>Tingkat</th>
                    <th>Nama Calon Siswa</th>
                    <th>Orang Tua / HP</th>
                    <th>Berkas Diunggah</th>
                    <th>Waktu Pengajuan</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingRegistrations as $reg)
                <tr>
                    <td style="font-weight: 700; font-family: monospace; color: var(--adm-primary);">
                        {{ $reg->no_pendaftaran }}
                    </td>
                    <td>
                        @if($reg->jenjang === 'sd')
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
                                <span>SD</span>
                            </span>
                        @elseif($reg->jenjang === 'smp')
                            <span class="badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35); font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                <span>SMP</span>
                            </span>
                        @elseif($reg->jenjang === 'smk')
                            <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35); font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                <span>SMK</span>
                            </span>
                        @else
                            <span class="badge">{{ strtoupper($reg->jenjang ?? '-') }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 700; color: #ffffff;">{{ $reg->full_name }}</div>
                        <div style="font-size: 0.78rem; color: var(--adm-text-muted);">
                            {{ $reg->gender == 'L' ? 'Ikhwan (L)' : 'Akhwat (P)' }} · {{ $reg->birth_date ? $reg->birth_date->format('d/m/Y') : '-' }}
                        </div>
                    </td>
                    <td>
                        <div style="color: #ffffff;">{{ $reg->parent_name }}</div>
                        <div style="font-size: 0.78rem; color: var(--adm-text-muted); font-family: monospace;">{{ $reg->parent_phone }}</div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $reg->documents->count() }} Berkas</span>
                    </td>
                    <td style="font-size: 0.8rem; color: var(--adm-text-muted);">
                        {{ $reg->created_at ? $reg->created_at->diffForHumans() : '-' }}
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 5px;">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                            <span>Verifikasi Sekarang</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #34d399; padding: 30px; font-weight: 700;">
                        <span style="display: inline-flex; align-items: center; gap: 8px;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span>Luar biasa! Seluruh antrean pendaftar telah selesai diverifikasi oleh panitia.</span>
                        </span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
