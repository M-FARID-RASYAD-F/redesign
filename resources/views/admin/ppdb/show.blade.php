@extends('layouts.admin')

@section('title', 'Detail PPDB: ' . $registration->full_name . ' - At-Tamam Edu')

@section('content')
@php
    $rawPhone = $registration->parent_phone ?? '';
    $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
    if (str_starts_with($cleanPhone, '0')) {
        $waPhone = '62' . substr($cleanPhone, 1);
    } else {
        $waPhone = $cleanPhone;
    }

    $names = explode(' ', trim($registration->full_name ?? ''));
    $initials = '';
    if (count($names) >= 2) {
        $initials = strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1));
    } elseif (count($names) == 1 && !empty($names[0])) {
        $initials = strtoupper(substr($names[0], 0, min(2, strlen($names[0]))));
    } else {
        $initials = 'PS';
    }
@endphp

<style>
    /* ═══════════════════════════════════════════════════════════
       PPDB DETAIL RESPONSIVE SUITE
       ═══════════════════════════════════════════════════════════ */
    .ppdb-top-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 20px;
    }

    .ppdb-top-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .ppdb-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid var(--adm-border);
        color: var(--adm-text-sub);
        text-decoration: none;
        background: rgba(255, 255, 255, 0.04);
        transition: all 0.2s ease;
    }
    .ppdb-back-btn:hover {
        border-color: var(--adm-primary);
        color: #ffffff;
        background: rgba(0, 180, 216, 0.12);
        transform: translateX(-2px);
    }

    /* Hero Identity Banner */
    .ppdb-hero-card {
        background: var(--adm-card-bg);
        border: 1px solid var(--adm-border);
        border-radius: 16px;
        padding: 22px 24px;
        margin-bottom: 24px;
        box-shadow: var(--adm-shadow);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .ppdb-hero-identity {
        display: flex;
        align-items: center;
        gap: 18px;
        min-width: 0;
    }

    .ppdb-hero-avatar {
        width: 58px;
        height: 58px;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(0, 180, 216, 0.22) 0%, rgba(0, 119, 182, 0.42) 100%);
        border: 1.5px solid var(--adm-border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--adm-primary);
        flex-shrink: 0;
        box-shadow: 0 4px 14px rgba(0, 180, 216, 0.2);
    }

    .ppdb-hero-info {
        min-width: 0;
    }

    .ppdb-hero-info h1 {
        font-size: 1.38rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0 0 6px 0;
        line-height: 1.25;
        word-break: break-word;
    }

    .ppdb-hero-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 0.82rem;
    }

    .ppdb-reg-pill {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        color: var(--adm-primary);
        background: rgba(0, 180, 216, 0.12);
        padding: 2px 8px;
        border-radius: 6px;
        border: 1px solid rgba(0, 180, 216, 0.25);
    }

    .ppdb-hero-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .ppdb-action-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .ppdb-action-wa {
        background: rgba(37, 211, 102, 0.15);
        color: #25d366;
        border: 1px solid rgba(37, 211, 102, 0.35);
    }
    .ppdb-action-wa:hover {
        background: rgba(37, 211, 102, 0.28);
        border-color: #25d366;
        transform: translateY(-1px);
    }

    .ppdb-action-call {
        background: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.35);
    }
    .ppdb-action-call:hover {
        background: rgba(56, 189, 248, 0.28);
        border-color: #38bdf8;
        transform: translateY(-1px);
    }

    /* Section Cards & Data Grid */
    .ppdb-section-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1.05rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 16px 0;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--adm-border);
    }

    .ppdb-data-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .ppdb-data-item {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--adm-border);
        border-radius: 10px;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        transition: border-color 0.2s ease;
    }
    .ppdb-data-item:hover {
        border-color: var(--adm-border-hover);
    }

    .ppdb-data-item.span-full {
        grid-column: 1 / -1;
    }

    .ppdb-data-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: var(--adm-text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ppdb-data-value {
        font-size: 0.94rem;
        font-weight: 600;
        color: #ffffff;
        word-break: break-word;
        line-height: 1.45;
    }

    /* Dokumen Persyaratan */
    .ppdb-doc-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .ppdb-doc-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--adm-border);
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        transition: border-color 0.2s ease, background 0.2s ease;
    }
    .ppdb-doc-card:hover {
        border-color: var(--adm-border-hover);
        background: rgba(0, 180, 216, 0.03);
    }

    .ppdb-doc-meta {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }

    .ppdb-doc-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(0, 180, 216, 0.12);
        border: 1px solid rgba(0, 180, 216, 0.25);
        color: var(--adm-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .ppdb-doc-title {
        font-weight: 700;
        font-size: 0.92rem;
        color: #ffffff;
        text-transform: uppercase;
        margin-bottom: 4px;
        letter-spacing: 0.02em;
    }

    .ppdb-doc-action {
        flex-shrink: 0;
    }

    .ppdb-empty-state {
        text-align: center;
        padding: 36px 16px;
        color: var(--adm-text-muted);
        border: 1px dashed var(--adm-border);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.01);
    }

    /* Verification Sidebar Sticky on Desktop */
    .admin-detail-sidebar .card {
        position: sticky;
        top: 86px;
    }

    /* ═══════════════════════════════════════════════════════════
       RESPONSIVE BREAKPOINTS (TABLET & MOBILE)
       ═══════════════════════════════════════════════════════════ */
    @media (max-width: 860px) {
        .ppdb-hero-card {
            padding: 18px;
            gap: 14px;
        }

        .ppdb-hero-identity {
            gap: 14px;
            width: 100%;
        }

        .ppdb-hero-avatar {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }

        .ppdb-hero-info h1 {
            font-size: 1.22rem;
        }

        .ppdb-hero-actions {
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .ppdb-action-link {
            justify-content: center;
            padding: 10px 12px;
            font-size: 0.82rem;
        }

        .ppdb-data-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .ppdb-doc-card {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            padding: 14px;
        }

        .ppdb-doc-meta {
            width: 100%;
        }

        .ppdb-doc-action {
            width: 100%;
        }

        .ppdb-doc-action .btn {
            width: 100%;
            justify-content: center;
            min-height: 42px;
            font-size: 0.85rem;
        }

        .admin-detail-sidebar .card {
            position: static;
        }
    }

    @media (max-width: 520px) {
        .ppdb-top-nav {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .ppdb-top-left {
            width: 100%;
            justify-content: space-between;
        }

        .ppdb-hero-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Top Breadcrumb & Actions Bar -->
<div class="ppdb-top-nav">
    <div class="ppdb-top-left">
        <a href="{{ route('admin.ppdb.index') }}" class="ppdb-back-btn">
            <span>←</span>
            <span>Kembali ke Daftar PPDB</span>
        </a>
    </div>

    <div>
        @if($registration->status == 'pending')
            <span class="badge badge-warning" style="font-size: 0.85rem; padding: 6px 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                <span>Pending / Menunggu</span>
            </span>
        @elseif($registration->status == 'diverifikasi')
            <span class="badge badge-info" style="font-size: 0.85rem; padding: 6px 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span>Terverifikasi</span>
            </span>
        @elseif($registration->status == 'diterima')
            <span class="badge badge-success" style="font-size: 0.85rem; padding: 6px 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span>Diterima</span>
            </span>
        @elseif($registration->status == 'ditolak')
            <span class="badge badge-danger" style="font-size: 0.85rem; padding: 6px 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <span>Ditolak</span>
            </span>
        @endif
    </div>
</div>

<!-- Profile Summary Hero Card -->
<div class="ppdb-hero-card">
    <div class="ppdb-hero-identity">
        <div class="ppdb-hero-avatar">{{ $initials }}</div>
        <div class="ppdb-hero-info">
            <h1>{{ $registration->full_name }}</h1>
            <div class="ppdb-hero-meta">
                <span class="ppdb-reg-pill">{{ $registration->no_pendaftaran }}</span>
                
                @if($registration->jenjang === 'sd')
                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                        <span>SD (Sekolah Dasar)</span>
                    </span>
                @elseif($registration->jenjang === 'smp')
                    <span class="badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35); display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>SMP (Menengah Pertama)</span>
                    </span>
                @elseif($registration->jenjang === 'smk')
                    <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35); display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <span>SMK (Kejuruan)</span>
                    </span>
                    @if($registration->major_choice)
                        <span class="badge" style="background: rgba(168, 85, 247, 0.1); color: #d8b4fe; border: 1px solid rgba(168, 85, 247, 0.25);">
                            {{ $registration->major_choice }}
                        </span>
                    @endif
                @else
                    <span class="badge">{{ strtoupper($registration->jenjang ?? '-') }}</span>
                @endif
            </div>
        </div>
    </div>

    @if(!empty($registration->parent_phone))
    <div class="ppdb-hero-actions">
        <a href="https://wa.me/{{ $waPhone }}?text=Halo%20Bapak%2FIbu%20{{ urlencode($registration->parent_name) }}%2C%20kami%20dari%20Panitia%20PPDB%20At-Tamam%20Edu%20mengenai%20pendaftaran%20ananda%20{{ urlencode($registration->full_name) }}%20(No.%20{{ $registration->no_pendaftaran }})..." 
           target="_blank" 
           class="ppdb-action-link ppdb-action-wa"
           title="Kirim pesan WhatsApp ke Wali Murid"
           style="display: inline-flex; align-items: center; gap: 7px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            <span>WhatsApp Wali</span>
        </a>
        <a href="tel:{{ $registration->parent_phone }}" 
           class="ppdb-action-link ppdb-action-call"
           title="Hubungi Wali Murid melalui Panggilan Telepon"
           style="display: inline-flex; align-items: center; gap: 7px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <span>Hubungi Telepon</span>
        </a>
    </div>
    @endif
</div>

<!-- Main Detail & Sidebar Grid -->
<div class="admin-detail-layout">
    <!-- Left Column: Details & Documents -->
    <div class="admin-detail-main">
        <!-- Student Personal & Parent Info -->
        <div class="card" style="margin-bottom: 24px;">
            <h3 class="ppdb-section-header" style="display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <span>Data Lengkap Calon Siswa & Wali</span>
            </h3>
            
            <div class="ppdb-data-grid">
                <div class="ppdb-data-item">
                    <span class="ppdb-data-label" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>No. Pendaftaran</span>
                    </span>
                    <span class="ppdb-data-value" style="font-family: 'JetBrains Mono', monospace; color: var(--adm-primary);">
                        {{ $registration->no_pendaftaran }}
                    </span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                        <span>Tingkat / Jenjang</span>
                    </span>
                    <span class="ppdb-data-value">
                        @if($registration->jenjang === 'sd')
                            <span style="display: inline-flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                <span>Sekolah Dasar (SD)</span>
                            </span>
                        @elseif($registration->jenjang === 'smp')
                            <span style="display: inline-flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                <span>Sekolah Menengah Pertama (SMP)</span>
                            </span>
                        @elseif($registration->jenjang === 'smk')
                            <span style="display: inline-flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                                <span>Sekolah Menengah Kejuruan (SMK)</span>
                            </span>
                            @if($registration->major_choice)
                                <div style="margin-top: 4px; font-size: 0.84rem; color: #c084fc; font-weight: 500;">
                                    Jurusan: <strong>{{ $registration->major_choice }}</strong>
                                </div>
                            @endif
                        @else
                            {{ strtoupper($registration->jenjang ?? '-') }}
                        @endif
                    </span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>Nama Lengkap</span>
                    </span>
                    <span class="ppdb-data-value">{{ $registration->full_name }}</span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v6M12 16v6M4.93 4.93l4.24 4.24M14.83 14.83l4.24 4.24M2 12h6M16 12h6M4.93 19.07l4.24-4.24M14.83 9.17l4.24-4.24"></path></svg>
                        <span>Jenis Kelamin</span>
                    </span>
                    <span class="ppdb-data-value">{{ $registration->gender == 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}</span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span>Tanggal Lahir</span>
                    </span>
                    <span class="ppdb-data-value">{{ $registration->birth_date ? $registration->birth_date->format('d F Y') : '-' }}</span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Nama Orang Tua / Wali</span>
                    </span>
                    <span class="ppdb-data-value">{{ $registration->parent_name }}</span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        <span>No. Telepon Orang Tua</span>
                    </span>
                    <span class="ppdb-data-value" style="font-family: 'JetBrains Mono', monospace;">
                        <a href="tel:{{ $registration->parent_phone }}" style="color: var(--adm-primary); text-decoration: none;">
                            {{ $registration->parent_phone }}
                        </a>
                    </span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span>Waktu Pendaftaran</span>
                    </span>
                    <span class="ppdb-data-value" style="color: var(--adm-text-sub); font-size: 0.88rem;">
                        {{ $registration->created_at ? $registration->created_at->format('d M Y, H:i') . ' WIB' : '-' }}
                    </span>
                </div>

                <div class="ppdb-data-item span-full">
                    <span class="ppdb-data-label" style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Alamat Lengkap</span>
                    </span>
                    <span class="ppdb-data-value" style="font-weight: 500; line-height: 1.6;">{{ $registration->address }}</span>
                </div>
            </div>
        </div>

        <!-- PPDB Documents Card -->
        <div class="card">
            <h3 class="ppdb-section-header" style="display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                <span>Berkas Dokumen Persyaratan</span>
            </h3>
            
            <div class="ppdb-doc-list">
                @forelse($registration->documents as $doc)
                <div class="ppdb-doc-card">
                    <div class="ppdb-doc-meta">
                        <div class="ppdb-doc-icon" style="display: flex; align-items: center; justify-content: center;">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <div style="min-width: 0;">
                            <div class="ppdb-doc-title">
                                {{ strtoupper(str_replace('_', ' ', $doc->doc_type)) }}
                            </div>
                            <div>
                                @if($doc->verification_status == 'belum_diverifikasi')
                                    <span class="badge badge-warning" style="font-size: 0.76rem; display: inline-flex; align-items: center; gap: 4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        <span>Belum Diverifikasi</span>
                                    </span>
                                @elseif($doc->verification_status == 'valid')
                                    <span class="badge badge-success" style="font-size: 0.76rem; display: inline-flex; align-items: center; gap: 4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        <span>Valid / Cocok</span>
                                    </span>
                                @elseif($doc->verification_status == 'tidak_valid')
                                    <span class="badge badge-danger" style="font-size: 0.76rem; display: inline-flex; align-items: center; gap: 4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                        <span>Tidak Valid</span>
                                    </span>
                                @else
                                    <span class="badge badge-info" style="font-size: 0.76rem;">{{ ucfirst($doc->verification_status ?? '-') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="ppdb-doc-action">
                        <a href="{{ route('admin.ppdb.document', $doc->id) }}" target="_blank" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <span>Buka Dokumen</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="ppdb-empty-state">
                    <div style="display: flex; justify-content: center; margin-bottom: 12px; color: var(--adm-text-sub);">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div style="font-weight: 600; color: #ffffff; margin-bottom: 4px;">Belum Ada Dokumen</div>
                    <div style="font-size: 0.85rem;">Pendaftar belum mengunggah dokumen persyaratan digital (KK, Akta Lahir, dsb).</div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Sidebar: Verification Form & Status -->
    <div class="admin-detail-sidebar">
        <div class="card">
            <h3 class="ppdb-section-header" style="margin-bottom: 18px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
                <span>Status & Verifikasi</span>
            </h3>
            
            <div style="margin-bottom: 20px; background: rgba(255, 255, 255, 0.02); border: 1px solid var(--adm-border); border-radius: 10px; padding: 12px 14px;">
                <span class="ppdb-data-label" style="margin-bottom: 6px;">Status Saat Ini</span>
                @if($registration->status == 'pending')
                    <span class="badge badge-warning" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span>Pending / Menunggu</span>
                    </span>
                @elseif($registration->status == 'diverifikasi')
                    <span class="badge badge-info" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Terverifikasi</span>
                    </span>
                @elseif($registration->status == 'diterima')
                    <span class="badge badge-success" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>Diterima</span>
                    </span>
                @elseif($registration->status == 'ditolak')
                    <span class="badge badge-danger" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        <span>Ditolak</span>
                    </span>
                @endif
            </div>

            @can('update', $registration)
            <form action="{{ route('admin.ppdb.status', $registration->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="jenjang">Tingkat / Jenjang *</label>
                    <select id="jenjang" name="jenjang" class="form-control" required onchange="toggleAdminMajorField(this.value)">
                        <option value="sd" {{ $registration->jenjang == 'sd' ? 'selected' : '' }}>SD (Sekolah Dasar)</option>
                        <option value="smp" {{ $registration->jenjang == 'smp' ? 'selected' : '' }}>SMP (Menengah Pertama)</option>
                        <option value="smk" {{ $registration->jenjang == 'smk' ? 'selected' : '' }}>SMK (Kejuruan)</option>
                    </select>
                </div>

                <div class="form-group" id="adminMajorContainer" style="display: {{ $registration->jenjang == 'smk' ? 'block' : 'none' }};">
                    <label class="form-label" for="major_choice">Jurusan (Khusus SMK)</label>
                    <select id="major_choice" name="major_choice" class="form-control">
                        <option value="">-- Tanpa Jurusan Tertentu --</option>
                        @foreach($majors as $m)
                            <option value="{{ $m->name }}" {{ $registration->major_choice == $m->name ? 'selected' : '' }}>
                                {{ $m->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="status">Ubah Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="pending" {{ $registration->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diverifikasi" {{ $registration->status == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                        <option value="diterima" {{ $registration->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $registration->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">Catatan Verifikasi</label>
                    <textarea id="notes" name="notes" class="form-control" rows="4" placeholder="Masukkan alasan penolakan, catatan validasi, atau detail penerimaan...">{{ old('notes', $registration->notes) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; min-height: 42px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    <span>Simpan Perubahan</span>
                </button>
            </form>
            <script>
            function toggleAdminMajorField(val) {
                const el = document.getElementById('adminMajorContainer');
                if (el) el.style.display = val === 'smk' ? 'block' : 'none';
            }
            </script>
            @else
            <div style="padding: 14px; background: rgba(0,0,0,0.25); border-radius: 10px; border: 1px solid var(--adm-border);">
                <div class="ppdb-data-label" style="margin-bottom: 6px;">Catatan Panitia</div>
                <div style="font-size: 0.9rem; color: #ffffff; line-height: 1.5;">{{ $registration->notes ?? 'Tidak ada catatan.' }}</div>
                <div style="margin-top: 12px; font-size: 0.75rem; color: var(--adm-text-muted); font-style: italic; display: flex; align-items: center; gap: 6px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <span>Akun Anda dalam mode pratinjau (read-only).</span>
                </div>
            </div>
            @endcan

            @can('delete', $registration)
            <div style="margin-top: 20px; padding-top: 18px; border-top: 1px solid var(--adm-border);">
                <form action="{{ route('admin.ppdb.delete', $registration->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus pendaftar <strong>{{ $registration->full_name }}</strong>? Tindakan ini tidak dapat dibatalkan.">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm btn-delete-trigger" style="width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px; min-height: 40px; font-weight: 600;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        <span>Hapus Pendaftar</span>
                    </button>
                </form>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection
