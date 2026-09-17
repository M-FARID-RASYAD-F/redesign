@extends('layouts.admin')

@section('title', 'Pendaftaran PPDB Online - At-Tamam Edu')

@section('content')
<style>
    /* ═══════════════════════════════════════════════════════════
       PPDB INDEX RESPONSIVE & FLUSH CONTAINER ENHANCEMENTS
       Menghilangkan bottleneck max-width 1240px dan celah padding
       yang membuat tabel terpotong & memicu horizontal scrollbar.
       ═══════════════════════════════════════════════════════════ */
    .admin-topbar,
    #crudPageContent,
    .alert-success,
    .alert-danger {
        max-width: 100% !important;
    }

    .ppdb-table-card {
        padding: 0 !important;
        overflow: hidden !important;
        border-radius: 16px !important;
        background: var(--adm-card-bg);
        border: 1.5px solid var(--adm-border);
        box-shadow: var(--adm-shadow);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        margin-bottom: 24px;
    }

    .ppdb-table-card .table-responsive {
        border: none !important;
        border-radius: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        box-shadow: inset -14px 0 12px -8px rgba(0, 0, 0, 0.45);
    }

    .ppdb-swipe-hint {
        display: none;
        padding: 9px 18px;
        background: rgba(0, 180, 216, 0.08);
        border-bottom: 1px solid var(--adm-table-border);
        font-size: 0.78rem;
        font-weight: 600;
        color: #38bdf8;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    @media (max-width: 991px) {
        .ppdb-swipe-hint {
            display: flex;
        }
    }

    .ppdb-table-card table {
        width: 100% !important;
        margin: 0 !important;
        border-collapse: collapse !important;
    }

    .ppdb-table-card th {
        background: rgba(0, 0, 0, 0.35) !important;
        padding: 14px 18px !important;
        font-size: 0.8rem !important;
        font-weight: 800 !important;
        letter-spacing: 0.05em !important;
        border-bottom: 1.5px solid var(--adm-border) !important;
        white-space: nowrap !important;
        color: #ffffff !important;
    }

    .ppdb-table-card td {
        padding: 14px 18px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid var(--adm-table-border) !important;
    }

    .ppdb-table-card tr:last-child td {
        border-bottom: none !important;
    }

    .ppdb-table-card th:first-child,
    .ppdb-table-card td:first-child {
        padding-left: 24px !important;
    }

    .ppdb-table-card th:last-child,
    .ppdb-table-card td:last-child {
        padding-right: 24px !important;
    }

    .ppdb-table-footer {
        padding: 14px 24px;
        border-top: 1px solid var(--adm-table-border);
        display: flex;
        justify-content: flex-end;
        align-items: center;
        background: rgba(0, 0, 0, 0.12);
    }
</style>

<div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 class="header-title">Pendaftaran PPDB Online</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola dan verifikasi pendaftaran calon peserta didik baru sesuai tingkat dan statusnya.</p>
    </div>
    <div class="header-actions" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
        @if($currentJenjang !== 'all' || $currentStatus !== 'all')
            <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600; padding: 10px 16px; border-radius: 8px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                <span>Reset Filter</span>
            </a>
        @endif
        <a href="{{ route('admin.ppdb.export', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" class="btn btn-success" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 10px 18px; border-radius: 8px; text-decoration: none; color: white; background: #10b981;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            <span>Unduh Rekap CSV</span>
            @if($currentJenjang !== 'all') ({{ strtoupper($currentJenjang) }}) @endif
            @if($currentStatus !== 'all') [{{ ucfirst($currentStatus) }}] @endif
        </a>
        <a href="{{ route('admin.ppdb.export-zip', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 10px 18px; border-radius: 8px; text-decoration: none; color: white; background: #4f46e5; border-color: #4338ca;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="21 8 21 21 3 21 3 8"/><rect width="22" height="5" x="1" y="3"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
            <span>Unduh Rekap ZIP (Berkas)</span>
            @if($currentJenjang !== 'all') ({{ strtoupper($currentJenjang) }}) @endif
            @if($currentStatus !== 'all') [{{ ucfirst($currentStatus) }}] @endif
        </a>
    </div>
</div>

<!-- PANEL FILTER TINGKAT (JENJANG) & STATUS SELEKSI -->
<div class="card ppdb-filter-panel" style="margin-bottom: 22px; padding: 18px 20px; border-radius: 14px;">
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <!-- Baris 1: Filter Berdasarkan Tingkatan (SD, SMP, SMK) -->
        <div class="ppdb-filter-row" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div class="ppdb-filter-label" style="display: flex; align-items: center; gap: 6px; min-width: 140px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Tingkat:</span>
            </div>
            <div class="ppdb-filter-options" style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.ppdb.index', ['jenjang' => null, 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'all' ? 'background: var(--primary); color: #ffffff;' : 'background: rgba(255,255,255,0.06); color: var(--text-muted); border: 1px solid var(--border);' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M3 15h18"/><path d="M9 3v18"/><path d="M15 3v18"/></svg>
                    <span>Semua Tingkat</span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $counts['all'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => 'sd', 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'sd' ? 'background: #059669; color: #ffffff;' : 'background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.3);' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
                    <span>SD (Sekolah Dasar)</span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $counts['sd'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smp', 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'smp' ? 'background: #0284c7; color: #ffffff;' : 'background: rgba(56,189,248,0.1); color: #38bdf8; border: 1px solid rgba(56,189,248,0.3);' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    <span>SMP (Menengah Pertama)</span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $counts['smp'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smk', 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'smk' ? 'background: #7c3aed; color: #ffffff;' : 'background: rgba(168,85,247,0.1); color: #c084fc; border: 1px solid rgba(168,85,247,0.3);' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    <span>SMK (Kejuruan)</span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $counts['smk'] }}</span>
                </a>
            </div>
        </div>

        <div style="border-top: 1px solid rgba(255, 255, 255, 0.08);"></div>

        <!-- Baris 2: Filter Berdasarkan Status Seleksi -->
        <div class="ppdb-filter-row" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div class="ppdb-filter-label" style="display: flex; align-items: center; gap: 6px; min-width: 140px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Status Seleksi:</span>
            </div>
            <div class="ppdb-filter-options" style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'all' ? 'background: var(--primary); color: #ffffff;' : 'background: rgba(255,255,255,0.06); color: var(--text-muted); border: 1px solid var(--border);' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/><path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"/><path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"/></svg>
                    <span>Semua Status</span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['all'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => 'pending']) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'pending' ? 'background: #d97706; color: #ffffff;' : 'background: rgba(245,158,11,0.1); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3);' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span>Pending</span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['pending'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => 'diverifikasi']) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'diverifikasi' ? 'background: #0284c7; color: #ffffff;' : 'background: rgba(56,189,248,0.1); color: #38bdf8; border: 1px solid rgba(56,189,248,0.3);' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="m9 15 2 2 4-4"/></svg>
                    <span>Diverifikasi</span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['diverifikasi'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => 'diterima']) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'diterima' ? 'background: #059669; color: #ffffff;' : 'background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.3);' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>Diterima</span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['diterima'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => 'ditolak']) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'ditolak' ? 'background: #dc2626; color: #ffffff;' : 'background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.3);' }}">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <span>Ditolak</span>
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['ditolak'] }}</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card ppdb-table-card">
    <div class="ppdb-swipe-hint" aria-hidden="true">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        <span>Geser tabel ke kanan untuk melihat kolom aksi &rarr;</span>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="min-width: 130px;">No. Pendaftaran</th>
                    <th style="min-width: 100px;">Tingkat</th>
                    <th style="min-width: 200px;">Nama Calon Siswa</th>
                    <th style="min-width: 170px;">Wali & Kontak</th>
                    <th style="min-width: 110px;">Status</th>
                    <th style="min-width: 160px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $reg)
                <tr>
                    <td style="white-space: nowrap;">
                        <span class="badge" style="font-family: monospace; font-size: 0.82rem; font-weight: 700; background: rgba(0, 180, 216, 0.12); color: var(--primary); border: 1px solid rgba(0, 180, 216, 0.3); padding: 4px 8px; letter-spacing: 0.5px; border-radius: 6px;">
                            {{ $reg->no_pendaftaran }}
                        </span>
                    </td>
                    <td>
                        @if($reg->jenjang === 'sd')
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
                                <span>SD</span>
                            </span>
                        @elseif($reg->jenjang === 'smp')
                            <span class="badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35); font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                <span>SMP</span>
                            </span>
                        @elseif($reg->jenjang === 'smk')
                            <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35); font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                <span>SMK</span>
                            </span>
                            @if($reg->major_choice)
                                <div style="font-size: 0.74rem; color: #c084fc; margin-top: 3px; font-weight: 600;">
                                    {{ $reg->major_choice }}
                                </div>
                            @endif
                        @else
                            <span class="badge" style="background: rgba(148, 163, 184, 0.15); color: #94a3b8;">
                                {{ strtoupper($reg->jenjang ?? '-') }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 700; color: #ffffff; margin-bottom: 3px; font-size: 0.92rem;">{{ $reg->full_name }}</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted); display: flex; align-items: center; gap: 6px; flex-wrap: wrap;">
                            <span>{{ $reg->gender == 'L' ? 'Ikhwan (L)' : 'Akhwat (P)' }}</span>
                            <span>•</span>
                            <span>Lahir: {{ $reg->birth_date ? $reg->birth_date->format('d/m/Y') : '-' }}</span>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #ffffff; margin-bottom: 3px; font-size: 0.88rem;">{{ $reg->parent_name }}</div>
                        @if($reg->parent_phone)
                            @php
                                $rawPhone = $reg->parent_phone;
                                $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $waPhone = '62' . substr($cleanPhone, 1);
                                } else {
                                    $waPhone = $cleanPhone;
                                }
                            @endphp
                            <a href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.78rem; color: #34d399; text-decoration: none; font-family: monospace;" title="Hubungi Orang Tua via WhatsApp">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                <span>{{ $reg->parent_phone }}</span>
                            </a>
                        @else
                            <span style="font-size: 0.78rem; color: var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td>
                        @if($reg->status == 'pending')
                            <span class="badge badge-warning" style="font-weight: 700;">Pending</span>
                        @elseif($reg->status == 'diverifikasi')
                            <span class="badge badge-info" style="font-weight: 700;">Diverifikasi</span>
                        @elseif($reg->status == 'diterima')
                            <span class="badge badge-success" style="font-weight: 700;">Diterima</span>
                        @elseif($reg->status == 'ditolak')
                            <span class="badge badge-danger" style="font-weight: 700;">Ditolak</span>
                        @endif
                    </td>
                    <td style="text-align: right; white-space: nowrap;">
                        <div style="display: inline-flex; gap: 6px; align-items: center; justify-content: flex-end;">
                            <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 4px; font-weight: 600; padding: 6px 12px; font-size: 0.8rem; color: var(--primary); border-color: var(--primary); text-decoration: none;" title="Periksa Berkas & Verifikasi Data">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <span>Detail & Verifikasi</span>
                            </a>
                            
                            @can('delete', $reg)
                            <form action="{{ route('admin.ppdb.delete', $reg->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus pendaftar <strong>{{ $reg->full_name }}</strong>? Tindakan ini tidak dapat dibatalkan." style="margin: 0; display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger" title="Hapus Data Pendaftar" style="padding: 6px 10px; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    <span>Hapus</span>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 48px 20px;">
                        <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.06); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; color: var(--text-muted); margin-left: auto; margin-right: auto;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                        </div>
                        <div style="font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 6px;">
                            @if($currentJenjang !== 'all' || $currentStatus !== 'all')
                                Tidak ada data pendaftaran yang sesuai dengan filter
                            @else
                                Belum ada pendaftaran PPDB online masuk
                            @endif
                        </div>
                        <div style="font-size: 0.84rem; color: var(--text-muted); margin-bottom: 16px;">
                            @if($currentJenjang !== 'all' && $currentStatus !== 'all')
                                Tidak ditemukan pendaftar tingkat <strong>{{ strtoupper($currentJenjang) }}</strong> dengan status <strong>{{ ucfirst($currentStatus) }}</strong>.
                            @elseif($currentJenjang !== 'all')
                                Belum ada pendaftar untuk tingkat <strong>{{ strtoupper($currentJenjang) }}</strong>.
                            @elseif($currentStatus !== 'all')
                                Tidak ada pendaftar dengan status <strong>{{ ucfirst($currentStatus) }}</strong>.
                            @else
                                Pendaftaran calon peserta didik baru akan tampil di sini.
                            @endif
                        </div>
                        @if($currentJenjang !== 'all' || $currentStatus !== 'all')
                            <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                <span>Tampilkan Semua Pendaftar</span>
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($registrations->hasPages())
    <div class="ppdb-table-footer">
        {{ $registrations->links() }}
    </div>
    @endif
</div>
@endsection
