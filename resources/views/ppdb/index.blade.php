@extends('layouts.app')

@section('title', 'Portal PPDB Online 2026/2027 — PKBM Tahfizh At-Tamam')

@section('konten_utama')
<!-- Hero Section PPDB -->
<section class="ppdb-hero-section">
    <div class="ppdb-hero-inner">
        <span class="ppdb-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M21.42 10.922a1 1 0 0 0-.019-.838L12.83 3.18a2 2 0 0 0-1.66 0L2.6 10.084a1 1 0 0 0 0 1.832l8.57 6.908a2 2 0 0 0 1.66 0l8.57-6.908a1 1 0 0 0 .02-.994z"/><path d="M6 12.5v5a6 3 0 0 0 12 0v-5"/></svg>
            Penerimaan Peserta Didik Baru (PPDB) Online
        </span>
        <h1 class="ppdb-hero-title">
            Raih Masa Depan Gemilang & Berkarakter Mulia
        </h1>
        <p class="ppdb-hero-desc">
            Pendaftaran peserta didik baru Tahun Ajaran 2026/2027 telah dibuka secara daring. Daftar mandiri dari rumah dengan mudah, cepat, dan transparan.
        </p>

        <!-- CTA Buttons -->
        <div class="ppdb-hero-actions">
            <a href="{{ route('ppdb.create') }}" class="btn btn-primary ppdb-btn-hero">
                <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <span>Isi Formulir Pendaftaran Sekarang</span>
            </a>
            <a href="{{ route('ppdb.tracking') }}" class="btn btn-outline ppdb-btn-hero">
                <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span>Lacak / Cek Status Pendaftaran</span>
            </a>
        </div>
    </div>
</section>

<!-- Statistik & Informasi Gelombang -->
<section class="ppdb-stats-wrapper">
    <div class="ppdb-stats-grid">
        <div class="ppdb-stat-card">
            <div class="ppdb-stat-label">Status Pendaftaran</div>
            <div class="ppdb-stat-val">{{ $stats['gelombang'] }}</div>
            <div class="ppdb-stat-sub text-emerald">● Pendaftaran Sedang Dibuka</div>
        </div>

        <div class="ppdb-stat-card stat-amber">
            <div class="ppdb-stat-label">Batas Akhir Gelombang</div>
            <div class="ppdb-stat-val">{{ $stats['deadline'] }}</div>
            <div class="ppdb-stat-sub text-amber">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block; vertical-align:-1px; margin-right:3px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Segera Lengkapi Berkas
            </div>
        </div>

        <div class="ppdb-stat-card stat-emerald">
            <div class="ppdb-stat-label">Calon Siswa Terdaftar</div>
            <div class="ppdb-stat-val ppdb-stat-val-highlight">{{ $stats['total'] }}+ Pendaftar</div>
            <div class="ppdb-stat-sub text-slate">dari berbagai sekolah asal</div>
        </div>
    </div>
</section>

<!-- Pilihan Jenjang Pendidikan (SD, SMP, SMK) -->
<section class="ppdb-section" id="pilih-jenjang">
    <div class="ppdb-section-header">
        <span class="ppdb-section-tag">Pilihan Tingkatan</span>
        <h2 class="ppdb-section-title">Daftar Sesuai Tingkatan Pendidikan</h2>
        <p class="ppdb-section-desc">Pilih jenjang yang Anda tuju untuk langsung membuka formulir pendaftaran yang sesuai.</p>
    </div>

    <div class="ppdb-jenjang-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
        <!-- SD -->
        <div class="ppdb-step-card" style="display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(16, 185, 129, 0.35);">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <span style="width: 46px; height: 46px; border-radius: 12px; background: rgba(16, 185, 129, 0.14); border: 1.5px solid rgba(16, 185, 129, 0.35); display: flex; align-items: center; justify-content: center; color: #34d399;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </span>
                    <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; border: 1px solid rgba(16, 185, 129, 0.3); display: inline-flex; align-items: center; gap: 4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 1 1.1 4c-1.2 0-2.8-.6-3.8-1.5-.9-.9-1.4-2.1-1.4-3.5 2.5 0 3.4.5 4.1 1z"/></svg>
                        Fondasi Qurani
                    </span>
                </div>
                <h3 class="ppdb-step-title" style="font-size: 1.2rem;">Sekolah Dasar (SD)</h3>
                <p class="ppdb-step-desc" style="line-height: 1.6; margin-bottom: 16px;">
                    Membangun aqidah shohihah, adab islami, tahfizh juz 30 mutqin, serta dasar calistung dan sains eksploratif.
                </p>
                <div style="font-size: 0.82rem; color: #cbd5e1; margin-bottom: 20px;">
                    <div style="display: flex; gap: 8px; margin-bottom: 6px; align-items: center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        <span>Tahfizh Cilik & Islamic Character</span>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>Masa Studi: 6 Tahun</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('ppdb.create', ['jenjang' => 'sd']) }}" class="btn btn-primary" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #10b981, #059669); border: none; font-weight: 700; padding: 12px 18px; border-radius: 12px; text-decoration: none;">
                Daftar Jenjang SD ➜
            </a>
        </div>

        <!-- SMP -->
        <div class="ppdb-step-card" style="display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(56, 189, 248, 0.35);">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <span style="width: 46px; height: 46px; border-radius: 12px; background: rgba(56, 189, 248, 0.14); border: 1.5px solid rgba(56, 189, 248, 0.35); display: flex; align-items: center; justify-content: center; color: #38bdf8;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                    </span>
                    <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; border: 1px solid rgba(56, 189, 248, 0.3); display: inline-flex; align-items: center; gap: 4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        Karakter & Riset
                    </span>
                </div>
                <h3 class="ppdb-step-title" style="font-size: 1.2rem;">Sekolah Menengah Pertama (SMP)</h3>
                <p class="ppdb-step-desc" style="line-height: 1.6; margin-bottom: 16px;">
                    Penguatan hafalan Al-Qur'an (target 5–10 juz), pembentukan jiwa kepemimpinan, sains terapan, dan pengenalan coding.
                </p>
                <div style="font-size: 0.82rem; color: #cbd5e1; margin-bottom: 20px;">
                    <div style="display: flex; gap: 8px; margin-bottom: 6px; align-items: center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        <span>Tahfizh Intensif & English/Arabic Club</span>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>Masa Studi: 3 Tahun</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('ppdb.create', ['jenjang' => 'smp']) }}" class="btn btn-primary" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #0284c7, #2563eb); border: none; font-weight: 700; padding: 12px 18px; border-radius: 12px; text-decoration: none;">
                Daftar Jenjang SMP ➜
            </a>
        </div>

        <!-- SMK -->
        <div class="ppdb-step-card" style="display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(168, 85, 247, 0.35);">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <span style="width: 46px; height: 46px; border-radius: 12px; background: rgba(168, 85, 247, 0.14); border: 1.5px solid rgba(168, 85, 247, 0.35); display: flex; align-items: center; justify-content: center; color: #c084fc;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"/></svg>
                    </span>
                    <span style="background: rgba(168, 85, 247, 0.15); color: #c084fc; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; border: 1px solid rgba(168, 85, 247, 0.3); display: inline-flex; align-items: center; gap: 4px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                        Vokasi Industri
                    </span>
                </div>
                <h3 class="ppdb-step-title" style="font-size: 1.2rem;">Sekolah Menengah Kejuruan (SMK)</h3>
                <p class="ppdb-step-desc" style="line-height: 1.6; margin-bottom: 16px;">
                    Keahlian kejuruan vokasi berstandar industri dengan 3 pilihan program keahlian (RPL, TKJ, DKV) & sertifikasi BNSP.
                </p>
                <div style="font-size: 0.82rem; color: #cbd5e1; margin-bottom: 20px;">
                    <div style="display: flex; gap: 8px; margin-bottom: 6px; align-items: center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#c084fc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                        <span>Kelas Industri RPL, TKJ, DKV & PKL</span>
                    </div>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#c084fc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <span>Masa Studi: 3 Tahun</span>
                    </div>
                </div>
            </div>
            <a href="{{ route('ppdb.create', ['jenjang' => 'smk']) }}" class="btn btn-primary" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #7c3aed, #9333ea); border: none; font-weight: 700; padding: 12px 18px; border-radius: 12px; text-decoration: none;">
                Daftar Jenjang SMK ➜
            </a>
        </div>
    </div>
</section>

<!-- Alur Pendaftaran PPDB 4 Langkah -->
<section class="ppdb-section">
    <div class="ppdb-section-header">
        <span class="ppdb-section-tag">Prosedur PPDB</span>
        <h2 class="ppdb-section-title">4 Langkah Mudah Pendaftaran Online</h2>
        <p class="ppdb-section-desc">Seluruh tahapan seleksi transparan dan dapat dipantau setiap saat secara daring.</p>
    </div>

    <div class="ppdb-steps-grid">
        <!-- Langkah 1 -->
        <div class="ppdb-step-card">
            <div class="ppdb-step-number step-1">1</div>
            <h3 class="ppdb-step-title">Pengisian Formulir</h3>
            <p class="ppdb-step-desc">Mengisi data diri, identitas orang tua/wali, memilih jurusan impian, serta mengunggah berkas syarat (KK/Akta/Foto).</p>
        </div>

        <!-- Langkah 2 -->
        <div class="ppdb-step-card">
            <div class="ppdb-step-number step-2">2</div>
            <h3 class="ppdb-step-title">Verifikasi Berkas</h3>
            <p class="ppdb-step-desc">Panitia PPDB memeriksa kelengkapan dan keabsahan dokumen dalam waktu 1x24 jam kerja secara cermat.</p>
        </div>

        <!-- Langkah 3 -->
        <div class="ppdb-step-card">
            <div class="ppdb-step-number step-3">3</div>
            <h3 class="ppdb-step-title">Pengumuman Hasil</h3>
            <p class="ppdb-step-desc">Cek status kelulusan penerimaan secara langsung melalui fitur Pelacakan Status menggunakan Nomor Registrasi Anda.</p>
        </div>

        <!-- Langkah 4 -->
        <div class="ppdb-step-card">
            <div class="ppdb-step-number step-4">4</div>
            <h3 class="ppdb-step-title">Daftar Ulang</h3>
            <p class="ppdb-step-desc">Calon siswa yang diterima melakukan konfirmasi daftar ulang dan mengikuti orientasi peserta didik baru.</p>
        </div>
    </div>
</section>

<!-- Simulasi Biaya & Beasiswa PPDB Online (Kalkulator Interaktif) -->
<x-tuition-simulator />

<!-- Persyaratan Berkas & Pilihan Program Keahlian -->
<section class="ppdb-section">
    <div class="ppdb-req-container">
        <div class="ppdb-req-grid">
            
            <!-- Dokumen Persyaratan -->
            <div>
                <span class="ppdb-section-tag">Checklist Syarat</span>
                <h3 class="ppdb-section-title" style="font-size: 1.6rem; margin-bottom: 12px;">Dokumen yang Perlu Disiapkan</h3>
                <p class="ppdb-section-desc" style="margin: 0 0 20px; text-align: left;">Format file: PDF, JPG, atau PNG dengan ukuran maksimal 3 MB per berkas.</p>

                <ul class="ppdb-checklist-list">
                    <li class="ppdb-checklist-item">
                        <span class="ppdb-check-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <div>
                            <strong class="ppdb-check-title">Kartu Keluarga (KK)</strong>
                            <span class="ppdb-check-sub">Scan atau foto jelas KK yang masih berlaku</span>
                        </div>
                    </li>

                    <li class="ppdb-checklist-item">
                        <span class="ppdb-check-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <div>
                            <strong class="ppdb-check-title">Akta Kelahiran Calon Siswa</strong>
                            <span class="ppdb-check-sub">Sebagai bukti keabsahan identitas dan usia</span>
                        </div>
                    </li>

                    <li class="ppdb-checklist-item">
                        <span class="ppdb-check-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <div>
                            <strong class="ppdb-check-title">Pas Foto Berwarna (3x4)</strong>
                            <span class="ppdb-check-sub">Latar belakang merah atau biru berpakaian rapi</span>
                        </div>
                    </li>

                    <li class="ppdb-checklist-item">
                        <span class="ppdb-check-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <div>
                            <strong class="ppdb-check-title">Rapor Terakhir / SKL</strong>
                            <span class="ppdb-check-sub">Surat Keterangan Lulus dari sekolah asal (SMP/MTs)</span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Pilihan Jurusan -->
            <div>
                <span class="ppdb-section-tag">Program Pilihan</span>
                <h3 class="ppdb-section-title" style="font-size: 1.6rem; margin-bottom: 12px;">Jurusan Kejuruan Tersedia</h3>
                <p class="ppdb-section-desc" style="margin: 0 0 20px; text-align: left;">Pilih program keahlian yang selaras dengan minat dan bakat Anda.</p>

                <div class="ppdb-major-list">
                    @foreach($majors as $m)
                    <div class="ppdb-major-item">
                        <div class="ppdb-major-left">
                            <span class="ppdb-major-icon" style="color: #38bdf8; display: flex; align-items: center; justify-content: center;">
                                @if(str_contains(strtolower($m->name ?? ''), 'rekayasa') || str_contains(strtolower($m->name ?? ''), 'rpl'))
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                                @elseif(str_contains(strtolower($m->name ?? ''), 'jaringan') || str_contains(strtolower($m->name ?? ''), 'tkj'))
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="8" x="2" y="2" rx="2" ry="2"/><rect width="20" height="8" x="2" y="14" rx="2" ry="2"/><line x1="6" x2="6.01" y1="6" y2="6"/><line x1="6" x2="6.01" y1="18" y2="18"/></svg>
                                @elseif(str_contains(strtolower($m->name ?? ''), 'desain') || str_contains(strtolower($m->name ?? ''), 'dkv'))
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>
                                @else
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"/></svg>
                                @endif
                            </span>
                            <div>
                                <h4 class="ppdb-major-name">{{ $m->name }}</h4>
                                <p class="ppdb-major-desc">{{ Str::limit($m->description, 60) }}</p>
                            </div>
                        </div>
                        <span class="ppdb-major-badge">Tersedia</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Tanya Jawab Seputar Sekolah & PPDB (Interactive FAQ) -->
<x-faq-accordion :faqs="$faqs ?? []" />

<!-- Banner Bantuan & Call To Action -->
<section class="ppdb-section" style="margin-bottom: 5rem;">
    <div class="ppdb-cta-card">
        <div>
            <h3 class="ppdb-cta-title">Butuh Bantuan saat Mengisi Formulir?</h3>
            <p class="ppdb-cta-desc">
                Hubungi Tim Helpdesk Panitia PPDB kami via WhatsApp resmi di 
                <a href="{{ config('school.whatsapp_url', 'https://wa.me/6281270001920') }}" target="_blank" rel="noopener noreferrer" style="color: #38bdf8; font-weight: 700; text-decoration: underline;">
                    {{ config('school.whatsapp_formatted', '0812-7000-1920') }}
                </a> (Senin - Sabtu: 08.00 - 16.00 WIB).
            </p>
        </div>
        <div>
            <a href="{{ route('ppdb.create') }}" class="btn btn-primary" style="padding: 12px 28px; font-weight: 700; border-radius: 10px;">
                Mulai Pendaftaran ➜
            </a>
        </div>
    </div>
</section>
@endsection
