@extends('layouts.app')

@section('title', 'Portal PPDB Online 2026/2027 — PKBM Tahfizh At-Tamam')

@section('konten_utama')
<!-- Hero Section PPDB -->
<section class="ppdb-hero-section">
    <div class="ppdb-hero-inner">
        <span class="ppdb-badge">
            🎓 Penerimaan Peserta Didik Baru (PPDB) Online
        </span>
        <h1 class="ppdb-hero-title">
            Raih Masa Depan Gemilang & Berkarakter Mulia
        </h1>
        <p class="ppdb-hero-desc">
            Pendaftaran peserta didik baru Tahun Ajaran 2026/2027 telah dibuka secara daring. Daftar mandiri dari rumah dengan mudah, cepat, dan transparan.
        </p>

        <!-- CTA Buttons -->
        <div class="ppdb-hero-actions">
            <a href="{{ route('ppdb.create') }}" class="btn btn-primary" style="padding: 14px 32px; font-size: 1rem; font-weight: 700; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px;">
                ✍️ Isi Formulir Pendaftaran Sekarang
            </a>
            <a href="{{ route('ppdb.tracking') }}" class="btn btn-outline" style="padding: 14px 28px; font-size: 1rem; font-weight: 700; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px;">
                🔍 Lacak / Cek Status Pendaftaran
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
            <div class="ppdb-stat-sub text-amber">⏰ Segera Lengkapi Berkas</div>
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

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
        <!-- SD -->
        <div class="ppdb-step-card" style="display: flex; flex-direction: column; justify-content: space-between; border-color: rgba(16, 185, 129, 0.35);">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <span style="font-size: 2.2rem;">🎒</span>
                    <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; border: 1px solid rgba(16, 185, 129, 0.3);">🌱 Fondasi Qurani</span>
                </div>
                <h3 class="ppdb-step-title" style="font-size: 1.2rem;">Sekolah Dasar (SD)</h3>
                <p class="ppdb-step-desc" style="line-height: 1.6; margin-bottom: 16px;">
                    Membangun aqidah shohihah, adab islami, tahfizh juz 30 mutqin, serta dasar calistung dan sains eksploratif.
                </p>
                <div style="font-size: 0.82rem; color: #cbd5e1; margin-bottom: 20px;">
                    <div style="display: flex; gap: 8px; margin-bottom: 6px;"><span>🎯</span> <span>Tahfizh Cilik & Islamic Character</span></div>
                    <div style="display: flex; gap: 8px;"><span>⏱️</span> <span>Masa Studi: 6 Tahun</span></div>
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
                    <span style="font-size: 2.2rem;">📚</span>
                    <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; border: 1px solid rgba(56, 189, 248, 0.3);">🌟 Karakter & Riset</span>
                </div>
                <h3 class="ppdb-step-title" style="font-size: 1.2rem;">Sekolah Menengah Pertama (SMP)</h3>
                <p class="ppdb-step-desc" style="line-height: 1.6; margin-bottom: 16px;">
                    Penguatan hafalan Al-Qur'an (target 5–10 juz), pembentukan jiwa kepemimpinan, sains terapan, dan pengenalan coding.
                </p>
                <div style="font-size: 0.82rem; color: #cbd5e1; margin-bottom: 20px;">
                    <div style="display: flex; gap: 8px; margin-bottom: 6px;"><span>🎯</span> <span>Tahfizh Intensif & English/Arabic Club</span></div>
                    <div style="display: flex; gap: 8px;"><span>⏱️</span> <span>Masa Studi: 3 Tahun</span></div>
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
                    <span style="font-size: 2.2rem;">💻</span>
                    <span style="background: rgba(168, 85, 247, 0.15); color: #c084fc; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; border: 1px solid rgba(168, 85, 247, 0.3);">🚀 Vokasi Industri</span>
                </div>
                <h3 class="ppdb-step-title" style="font-size: 1.2rem;">Sekolah Menengah Kejuruan (SMK)</h3>
                <p class="ppdb-step-desc" style="line-height: 1.6; margin-bottom: 16px;">
                    Keahlian kejuruan vokasi berstandar industri dengan 3 pilihan program keahlian (RPL, TKJ, DKV) & sertifikasi BNSP.
                </p>
                <div style="font-size: 0.82rem; color: #cbd5e1; margin-bottom: 20px;">
                    <div style="display: flex; gap: 8px; margin-bottom: 6px;"><span>🎯</span> <span>Kelas Industri RPL, TKJ, DKV & PKL</span></div>
                    <div style="display: flex; gap: 8px;"><span>⏱️</span> <span>Masa Studi: 3 Tahun</span></div>
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
                        <span class="ppdb-check-icon">✔️</span>
                        <div>
                            <strong class="ppdb-check-title">Kartu Keluarga (KK)</strong>
                            <span class="ppdb-check-sub">Scan atau foto jelas KK yang masih berlaku</span>
                        </div>
                    </li>

                    <li class="ppdb-checklist-item">
                        <span class="ppdb-check-icon">✔️</span>
                        <div>
                            <strong class="ppdb-check-title">Akta Kelahiran Calon Siswa</strong>
                            <span class="ppdb-check-sub">Sebagai bukti keabsahan identitas dan usia</span>
                        </div>
                    </li>

                    <li class="ppdb-checklist-item">
                        <span class="ppdb-check-icon">✔️</span>
                        <div>
                            <strong class="ppdb-check-title">Pas Foto Berwarna (3x4)</strong>
                            <span class="ppdb-check-sub">Latar belakang merah atau biru berpakaian rapi</span>
                        </div>
                    </li>

                    <li class="ppdb-checklist-item">
                        <span class="ppdb-check-icon">✔️</span>
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
                            <span class="ppdb-major-icon">{{ $m->icon ?? '💻' }}</span>
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

<!-- Banner Bantuan & Call To Action -->
<section class="ppdb-section" style="margin-bottom: 5rem;">
    <div class="ppdb-cta-card">
        <div>
            <h3 class="ppdb-cta-title">Butuh Bantuan saat Mengisi Formulir?</h3>
            <p class="ppdb-cta-desc">Hubungi Tim Helpdesk Panitia PPDB kami via WhatsApp di <strong>0812-3456-7890</strong> (Senin - Sabtu: 08.00 - 15.00 WIB).</p>
        </div>
        <div>
            <a href="{{ route('ppdb.create') }}" class="btn btn-primary" style="padding: 12px 28px; font-weight: 700; border-radius: 10px;">
                Mulai Pendaftaran ➜
            </a>
        </div>
    </div>
</section>
@endsection
