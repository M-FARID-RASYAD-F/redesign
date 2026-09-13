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
            <span class="badge badge-warning" style="font-size: 0.85rem; padding: 6px 14px; font-weight: 700;">
                ⏳ Pending / Menunggu
            </span>
        @elseif($registration->status == 'diverifikasi')
            <span class="badge badge-info" style="font-size: 0.85rem; padding: 6px 14px; font-weight: 700;">
                🔍 Terverifikasi
            </span>
        @elseif($registration->status == 'diterima')
            <span class="badge badge-success" style="font-size: 0.85rem; padding: 6px 14px; font-weight: 700;">
                ✅ Diterima
            </span>
        @elseif($registration->status == 'ditolak')
            <span class="badge badge-danger" style="font-size: 0.85rem; padding: 6px 14px; font-weight: 700;">
                ❌ Ditolak
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
                    <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35);">
                        🎒 SD (Sekolah Dasar)
                    </span>
                @elseif($registration->jenjang === 'smp')
                    <span class="badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35);">
                        📚 SMP (Menengah Pertama)
                    </span>
                @elseif($registration->jenjang === 'smk')
                    <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35);">
                        💻 SMK (Kejuruan)
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
           title="Kirim pesan WhatsApp ke Wali Murid">
            💬 WhatsApp Wali
        </a>
        <a href="tel:{{ $registration->parent_phone }}" 
           class="ppdb-action-link ppdb-action-call"
           title="Hubungi Wali Murid melalui Panggilan Telepon">
            📞 Hubungi Telepon
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
            <h3 class="ppdb-section-header">
                👤 Data Lengkap Calon Siswa & Wali
            </h3>
            
            <div class="ppdb-data-grid">
                <div class="ppdb-data-item">
                    <span class="ppdb-data-label">🔖 No. Pendaftaran</span>
                    <span class="ppdb-data-value" style="font-family: 'JetBrains Mono', monospace; color: var(--adm-primary);">
                        {{ $registration->no_pendaftaran }}
                    </span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label">🏫 Tingkat / Jenjang</span>
                    <span class="ppdb-data-value">
                        @if($registration->jenjang === 'sd')
                            🎒 Sekolah Dasar (SD)
                        @elseif($registration->jenjang === 'smp')
                            📚 Sekolah Menengah Pertama (SMP)
                        @elseif($registration->jenjang === 'smk')
                            💻 Sekolah Menengah Kejuruan (SMK)
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
                    <span class="ppdb-data-label">👤 Nama Lengkap</span>
                    <span class="ppdb-data-value">{{ $registration->full_name }}</span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label">⚧️ Jenis Kelamin</span>
                    <span class="ppdb-data-value">{{ $registration->gender == 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}</span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label">📅 Tanggal Lahir</span>
                    <span class="ppdb-data-value">{{ $registration->birth_date ? $registration->birth_date->format('d F Y') : '-' }}</span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label">👪 Nama Orang Tua / Wali</span>
                    <span class="ppdb-data-value">{{ $registration->parent_name }}</span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label">📱 No. Telepon Orang Tua</span>
                    <span class="ppdb-data-value" style="font-family: 'JetBrains Mono', monospace;">
                        <a href="tel:{{ $registration->parent_phone }}" style="color: var(--adm-primary); text-decoration: none;">
                            {{ $registration->parent_phone }}
                        </a>
                    </span>
                </div>

                <div class="ppdb-data-item">
                    <span class="ppdb-data-label">⏱️ Waktu Pendaftaran</span>
                    <span class="ppdb-data-value" style="color: var(--adm-text-sub); font-size: 0.88rem;">
                        {{ $registration->created_at ? $registration->created_at->format('d M Y, H:i') . ' WIB' : '-' }}
                    </span>
                </div>

                <div class="ppdb-data-item span-full">
                    <span class="ppdb-data-label">📍 Alamat Lengkap</span>
                    <span class="ppdb-data-value" style="font-weight: 500; line-height: 1.6;">{{ $registration->address }}</span>
                </div>
            </div>
        </div>

        <!-- PPDB Documents Card -->
        <div class="card">
            <h3 class="ppdb-section-header">
                📂 Berkas Dokumen Persyaratan
            </h3>
            
            <div class="ppdb-doc-list">
                @forelse($registration->documents as $doc)
                <div class="ppdb-doc-card">
                    <div class="ppdb-doc-meta">
                        <div class="ppdb-doc-icon">📄</div>
                        <div style="min-width: 0;">
                            <div class="ppdb-doc-title">
                                {{ strtoupper(str_replace('_', ' ', $doc->doc_type)) }}
                            </div>
                            <div>
                                @if($doc->verification_status == 'belum_diverifikasi')
                                    <span class="badge badge-warning" style="font-size: 0.76rem;">⏳ Belum Diverifikasi</span>
                                @elseif($doc->verification_status == 'valid')
                                    <span class="badge badge-success" style="font-size: 0.76rem;">✅ Valid / Cocok</span>
                                @elseif($doc->verification_status == 'tidak_valid')
                                    <span class="badge badge-danger" style="font-size: 0.76rem;">❌ Tidak Valid</span>
                                @else
                                    <span class="badge badge-info" style="font-size: 0.76rem;">{{ ucfirst($doc->verification_status ?? '-') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="ppdb-doc-action">
                        <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                            <span>👀 Buka Dokumen</span>
                            <span style="font-size: 0.75rem;">↗</span>
                        </a>
                    </div>
                </div>
                @empty
                <div class="ppdb-empty-state">
                    <div style="font-size: 2rem; margin-bottom: 8px;">📂</div>
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
            <h3 class="ppdb-section-header" style="margin-bottom: 18px;">
                🛡️ Status & Verifikasi
            </h3>
            
            <div style="margin-bottom: 20px; background: rgba(255, 255, 255, 0.02); border: 1px solid var(--adm-border); border-radius: 10px; padding: 12px 14px;">
                <span class="ppdb-data-label" style="margin-bottom: 6px;">Status Saat Ini</span>
                @if($registration->status == 'pending')
                    <span class="badge badge-warning" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center;">⏳ Pending / Menunggu</span>
                @elseif($registration->status == 'diverifikasi')
                    <span class="badge badge-info" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center;">🔍 Terverifikasi</span>
                @elseif($registration->status == 'diterima')
                    <span class="badge badge-success" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center;">✅ Diterima</span>
                @elseif($registration->status == 'ditolak')
                    <span class="badge badge-danger" style="font-size: 0.9rem; padding: 6px 12px; width: 100%; justify-content: center;">❌ Ditolak</span>
                @endif
            </div>

            @can('update', $registration)
            <form action="{{ route('admin.ppdb.status', $registration->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="jenjang">Tingkat / Jenjang *</label>
                    <select id="jenjang" name="jenjang" class="form-control" required onchange="toggleAdminMajorField(this.value)">
                        <option value="sd" {{ $registration->jenjang == 'sd' ? 'selected' : '' }}>🎒 SD (Sekolah Dasar)</option>
                        <option value="smp" {{ $registration->jenjang == 'smp' ? 'selected' : '' }}>📚 SMP (Menengah Pertama)</option>
                        <option value="smk" {{ $registration->jenjang == 'smk' ? 'selected' : '' }}>💻 SMK (Kejuruan)</option>
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

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; min-height: 42px; font-weight: 700;">
                    💾 Simpan Perubahan
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
                <div style="margin-top: 12px; font-size: 0.75rem; color: var(--adm-text-muted); font-style: italic;">
                    🔒 Akun Anda dalam mode pratinjau (read-only).
                </div>
            </div>
            @endcan

            @can('delete', $registration)
            <div style="margin-top: 20px; padding-top: 18px; border-top: 1px solid var(--adm-border);">
                <form action="{{ route('admin.ppdb.delete', $registration->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus pendaftar <strong>{{ $registration->full_name }}</strong>? Tindakan ini tidak dapat dibatalkan.">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm btn-delete-trigger" style="width: 100%; justify-content: center; display: inline-flex; align-items: center; gap: 6px; min-height: 40px; font-weight: 600;">
                        🗑️ Hapus Pendaftar
                    </button>
                </form>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection
