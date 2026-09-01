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
