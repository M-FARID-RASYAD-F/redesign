@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Siswa Baru (PPDB) — PKBM Tahfizh At-Tamam')

@push('styles')
<style>
/* Panggung Story Stack Deck PPDB */
.ppdb-page-container {
    overflow-x: clip;
}

/* Panel Stepper di atas Kartu Stage */
.ppdb-stepper-panel {
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 20px;
    padding: 22px 28px 18px;
    margin-bottom: 24px;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
}

[data-theme="light"] .ppdb-stepper-panel {
    background: oklch(27.1% 0.105 12.094 / 0.85);
    border-color: oklch(58.6% 0.253 17.585 / 0.35);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
}

/* Deck Penampung Kartu Stage */
.ppdb-slide-deck {
    position: relative;
    width: 100%;
    overflow: visible;
    border-radius: 24px;
    perspective: 1400px;
    -webkit-perspective: 1400px;
    transition: height 0.45s cubic-bezier(0.22, 1, 0.36, 1);
}

/* Track Penampung Kartu Bertumpuk */
.ppdb-slide-track {
    position: relative;
    width: 100%;
    transform-style: preserve-3d;
    -webkit-transform-style: preserve-3d;
}

/* Setiap Section adalah selembar kartu fisik Story modern */
.ppdb-section-card,
.ppdb-slide {
    display: none;
    flex-direction: column;
    width: 100%;
    min-height: 520px;
    background: #141f36;
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(56, 189, 248, 0.3);
    border-radius: 24px;
    padding: clamp(24px, 4vw, 42px);
    box-shadow: 0 24px 60px rgba(0, 0, 0, 0.55), 0 0 0 1px rgba(255, 255, 255, 0.05);
    box-sizing: border-box;
    backface-visibility: hidden;
    -webkit-backface-visibility: hidden;
    transform-origin: top left;
    transition: filter 0.3s ease;
}

[data-theme="light"] .ppdb-section-card,
[data-theme="light"] .ppdb-slide {
    background: oklch(27.1% 0.105 12.094 / 0.98);
    border-color: oklch(58.6% 0.253 17.585 / 0.45);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
}

/* Status Section Card Aktif Normal (Resting state) */
.ppdb-section-card.active,
.ppdb-slide.active {
    display: flex !important;
    position: relative;
    z-index: 10;
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
    transform: translate3d(0, 0, 0) rotate(0deg) scale(1);
    filter: none;
}

/* ─────────────────────────────────────────────────────────────────────────────
   ANIMASI STORY STACK SCROLL: MAJU (TOMBOL LANJUT)
   - Kartu baru muncul dari bawah tengah dengan ujung kiri atas memimpin.
   - Bergerak ke arah kiri untuk menstabilkan diri sepenuhnya.
   - Kartu lama di bawahnya terdorong mundur ke lapisan tumpukan (depth & blur).
   ───────────────────────────────────────────────────────────────────────────── */
.ppdb-section-card.story-enter-forward,
.ppdb-slide.story-enter-forward {
    display: flex !important;
    position: absolute !important;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 25 !important;
    visibility: visible !important;
    pointer-events: none;
    will-change: transform, opacity, box-shadow;
    animation: ppdbStoryEnterForward 0.65s cubic-bezier(0.22, 1, 0.36, 1) forwards !important;
}

.ppdb-section-card.story-underneath-forward,
.ppdb-slide.story-underneath-forward {
    display: flex !important;
    position: absolute !important;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 5 !important;
    visibility: visible !important;
    pointer-events: none;
    will-change: transform, filter, opacity;
    animation: ppdbStoryUnderneathForward 0.65s cubic-bezier(0.22, 1, 0.36, 1) forwards !important;
}

@keyframes ppdbStoryEnterForward {
    0% {
        transform: translate3d(16%, 150px, 0) rotate(5.5deg) scale(0.92);
        transform-origin: top left;
        opacity: 0.5;
        box-shadow: 0 32px 64px rgba(0, 0, 0, 0.7), -12px 14px 35px rgba(56, 189, 248, 0.35);
    }
    42% {
        transform: translate3d(7%, 60px, 0) rotate(2.4deg) scale(0.97);
        opacity: 0.95;
        box-shadow: 0 24px 50px rgba(0, 0, 0, 0.6), -8px 10px 30px rgba(56, 189, 248, 0.25);
    }
    75% {
        transform: translate3d(0%, 10px, 0) rotate(0.6deg) scale(0.995);
        opacity: 1;
        box-shadow: 0 18px 42px rgba(0, 0, 0, 0.5);
    }
    100% {
        transform: translate3d(0, 0, 0) rotate(0deg) scale(1);
        transform-origin: top left;
        opacity: 1;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.55);
    }
}

@keyframes ppdbStoryUnderneathForward {
    0% {
        transform: translate3d(0, 0, 0) scale(1);
        filter: brightness(1) blur(0px);
        opacity: 1;
    }
    100% {
        transform: translate3d(0, -26px, 0) scale(0.95);
        filter: brightness(0.55) blur(1.5px);
        opacity: 0.45;
    }
}

/* ─────────────────────────────────────────────────────────────────────────────
   ANIMASI STORY STACK SCROLL: TIMBAL BALIK (TOMBOL KEMBALI)
   - Kartu aktif meluncur keluar berbalik ke arah bawah tengah.
   - Kartu sebelumnya di lapisan tumpukan tersingkap kembali ke permukaan.
   ───────────────────────────────────────────────────────────────────────────── */
.ppdb-section-card.story-exit-backward,
.ppdb-slide.story-exit-backward {
    display: flex !important;
    position: absolute !important;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 25 !important;
    visibility: visible !important;
    pointer-events: none;
    will-change: transform, opacity, box-shadow;
    animation: ppdbStoryExitBackward 0.65s cubic-bezier(0.22, 1, 0.36, 1) forwards !important;
}

.ppdb-section-card.story-reveal-backward,
.ppdb-slide.story-reveal-backward {
    display: flex !important;
    position: absolute !important;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 5 !important;
    visibility: visible !important;
    pointer-events: none;
    will-change: transform, filter, opacity;
    animation: ppdbStoryRevealBackward 0.65s cubic-bezier(0.22, 1, 0.36, 1) forwards !important;
}

@keyframes ppdbStoryExitBackward {
    0% {
        transform: translate3d(0, 0, 0) rotate(0deg) scale(1);
        transform-origin: top left;
        opacity: 1;
        box-shadow: 0 24px 60px rgba(0, 0, 0, 0.55);
    }
    30% {
        transform: translate3d(6%, 50px, 0) rotate(2deg) scale(0.98);
        opacity: 0.9;
    }
    65% {
        transform: translate3d(12%, 105px, 0) rotate(3.8deg) scale(0.95);
        opacity: 0.65;
        box-shadow: 0 24px 50px rgba(0, 0, 0, 0.6), -8px 10px 30px rgba(56, 189, 248, 0.25);
    }
    100% {
        transform: translate3d(16%, 160px, 0) rotate(5.5deg) scale(0.92);
        transform-origin: top left;
        opacity: 0;
        box-shadow: 0 32px 64px rgba(0, 0, 0, 0.7), -12px 14px 35px rgba(56, 189, 248, 0.35);
    }
}

@keyframes ppdbStoryRevealBackward {
    0% {
        transform: translate3d(0, -26px, 0) scale(0.95);
        filter: brightness(0.55) blur(1.5px);
        opacity: 0.45;
    }
    100% {
        transform: translate3d(0, 0, 0) scale(1);
        filter: brightness(1) blur(0px);
        opacity: 1;
    }
}

@media (max-width: 640px) {
    .ppdb-stepper-panel {
        padding: 18px 14px 14px;
        border-radius: 16px;
    }
    .ppdb-section-card,
    .ppdb-slide {
        min-height: auto;
        padding: 20px 16px;
        border-radius: 18px;
    }
    .ppdb-slide-body {
        flex: 0 0 auto;
    }
    .ppdb-slide-actions {
        margin-top: 20px;
        padding-top: 18px;
    }
}
</style>
@endpush

@section('konten_utama')
<div class="ppdb-page-container">
    <div style="max-width: 840px; margin: 0 auto;">
        
        <!-- Header Formulir -->
        <div style="text-align: center; margin-bottom: 35px;">
            <a href="{{ route('ppdb.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem; font-weight: 700; color: #38bdf8; margin-bottom: 12px; text-decoration: none;">
                ← Kembali ke Portal PPDB
            </a>
            <h1 class="ppdb-section-title" style="font-size: clamp(1.8rem, 3vw, 2.4rem); margin: 0;">Formulir Pendaftaran Siswa Baru</h1>
            <p class="ppdb-section-desc" style="margin-top: 6px;">Tahun Ajaran 2026/2027 · Silakan lengkapi data calon siswa dengan jujur dan teliti.</p>
        </div>

        @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 16px; padding: 18px 24px; margin-bottom: 30px; color: #fca5a5;">
            <div style="font-weight: 700; margin-bottom: 6px; color: #ffffff;">⚠️ Terdapat beberapa kolom yang belum terisi dengan benar:</div>
            <ul style="padding-left: 20px; font-size: 0.9rem; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Stepper Navigation Panel (Di Atas Kartu Deck) -->
        <div class="ppdb-stepper-panel">
            <div class="ppdb-stepper" id="ppdbStepper">
                <button type="button" class="ppdb-step-item active" data-step="1" onclick="jumpToStep(1)">
                    <div class="ppdb-step-circle">
                        <span class="step-num">1</span>
                        <span class="step-check">✓</span>
                    </div>
                    <div class="ppdb-step-info">
                        <span class="ppdb-step-label">Langkah 1</span>
                        <span class="ppdb-step-name">Data Calon Siswa</span>
                    </div>
                </button>

                <div class="ppdb-step-connector" id="connector-1"></div>

                <button type="button" class="ppdb-step-item" data-step="2" onclick="jumpToStep(2)">
                    <div class="ppdb-step-circle">
                        <span class="step-num">2</span>
                        <span class="step-check">✓</span>
                    </div>
                    <div class="ppdb-step-info">
                        <span class="ppdb-step-label">Langkah 2</span>
                        <span class="ppdb-step-name">Orang Tua / Wali</span>
                    </div>
                </button>

                <div class="ppdb-step-connector" id="connector-2"></div>

                <button type="button" class="ppdb-step-item" data-step="3" onclick="jumpToStep(3)">
                    <div class="ppdb-step-circle">
                        <span class="step-num">3</span>
                        <span class="step-check">✓</span>
                    </div>
                    <div class="ppdb-step-info">
                        <span class="ppdb-step-label">Langkah 3</span>
                        <span class="ppdb-step-name">Berkas & Selesai</span>
                    </div>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="ppdb-progress-track">
                <div class="ppdb-progress-bar" id="ppdbProgressBar" style="width: 33.33%;"></div>
            </div>
        </div>

        <!-- Formulir Pendaftaran (Section Card Story Stack) -->
        <form id="ppdbForm" action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" novalidate data-initial-step="{{ $errors->hasAny(['doc_kk', 'doc_akta', 'doc_foto', 'doc_rapor', 'agreement']) ? 3 : ($errors->hasAny(['parent_name', 'parent_phone']) ? 2 : 1) }}">
            @csrf
            <div class="ppdb-slide-deck" id="ppdbSlideDeck">
                <div class="ppdb-slide-track" id="ppdbSlideTrack">

                    <!-- SECTION CARD 1: DATA CALON SISWA -->
                    <section class="ppdb-section-card ppdb-slide active" id="slide-1" data-step="1">
                    <div class="ppdb-slide-body">
                        <div class="ppdb-step-header">
                            <span class="ppdb-step-badge badge-blue">1</span>
                            <div>
                                <h2 class="ppdb-step-heading">Data Calon Peserta Didik</h2>
                                <span style="font-size: 0.8rem; color: #94a3b8;">Isi data pribadi calon siswa sesuai dokumen resmi (KK / Akta Kelahiran).</span>
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="full_name" class="ppdb-form-label">
                                Nama Lengkap Calon Siswa <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required placeholder="Contoh: Muhammad Fatih Al-Ayyubi" class="ppdb-form-input" />
                            @error('full_name')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Kelamin & Tanggal Lahir (2 Kolom) -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label for="gender" class="ppdb-form-label">
                                    Jenis Kelamin <span style="color: #ef4444;">*</span>
                                </label>
                                <select id="gender" name="gender" required class="ppdb-form-select">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki (Ikhwan)</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan (Akhwat)</option>
                                </select>
                                @error('gender')
                                    <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="birth_date" class="ppdb-form-label">
                                    Tanggal Lahir <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required class="ppdb-form-input" />
                                @error('birth_date')
                                    <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="form-group">
                            <label for="address" class="ppdb-form-label">
                                Alamat Domisili / Tempat Tinggal <span style="color: #ef4444;">*</span>
                            </label>
                            <textarea id="address" name="address" rows="3" required placeholder="Jl. Nama Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten" class="ppdb-form-textarea">{{ old('address') }}</textarea>
                            @error('address')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Slide 1 Action Buttons -->
                    <div class="ppdb-slide-actions">
                        <a href="{{ route('ppdb.index') }}" class="ppdb-btn-prev">
                            ← Ke Beranda PPDB
                        </a>
                        <button type="button" class="ppdb-btn-next" onclick="nextSlide(2)">
                            Lanjut ke Data Orang Tua →
                        </button>
                    </div>
                </section>

                <!-- SECTION CARD 2: DATA ORANG TUA / WALI -->
                <section class="ppdb-section-card ppdb-slide" id="slide-2" data-step="2">
                    <div class="ppdb-slide-body">
                        <div class="ppdb-step-header">
                            <span class="ppdb-step-badge badge-amber">2</span>
                            <div>
                                <h2 class="ppdb-step-heading">Data Orang Tua / Wali</h2>
                                <span style="font-size: 0.8rem; color: #94a3b8;">Kontak aktif orang tua / wali untuk notifikasi pengumuman seleksi.</span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 22px;">
                            <div>
                                <label for="parent_name" class="ppdb-form-label">
                                    Nama Lengkap Orang Tua / Wali <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: H. Agus Sulaiman, S.T." class="ppdb-form-input" />
                                @error('parent_name')
                                    <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="parent_phone" class="ppdb-form-label">
                                    Nomor WhatsApp / Telepon Aktif <span style="color: #ef4444;">*</span>
                                </label>
                                <input type="tel" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" required placeholder="Contoh: 081234567890" class="ppdb-form-input" />
                                <span style="font-size: 0.75rem; color: #94a3b8; display: block; margin-top: 4px;">Akan digunakan panitia untuk konfirmasi dan notifikasi status</span>
                                @error('parent_phone')
                                    <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Panduan & Info Komunikasi Orang Tua -->
                        <div class="ppdb-info-card">
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <span style="font-size: 1.6rem; line-height: 1;">📱</span>
                                <div>
                                    <h4 style="font-size: 0.95rem; font-weight: 800; color: #fbbf24; margin: 0 0 6px;">Pemberitahuan & Verifikasi Kontak</h4>
                                    <p style="font-size: 0.84rem; color: #cbd5e1; line-height: 1.6; margin: 0 0 10px;">
                                        Pastikan nomor WhatsApp orang tua/wali aktif. Panitia PPDB PKBM Tahfizh At-Tamam akan mengirimkan:
                                    </p>
                                    <ul style="margin: 0; padding-left: 18px; font-size: 0.82rem; color: #cbd5e1; line-height: 1.6;">
                                        <li>Surat tanda bukti registrasi & kode pendaftaran resmi.</li>
                                        <li>Jadwal pelaksanaan observasi / wawancara wali santri dan calon siswa.</li>
                                        <li>Hasil pengumuman kelulusan seleksi PPDB Tahun Ajaran 2026/2027.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 Action Buttons -->
                    <div class="ppdb-slide-actions">
                        <button type="button" class="ppdb-btn-prev" onclick="prevSlide(1)">
                            ← Kembali ke Data Siswa
                        </button>
                        <button type="button" class="ppdb-btn-next" onclick="nextSlide(3)">
                            Lanjut ke Unggah Berkas →
                        </button>
                    </div>
                </section>

                <!-- SECTION CARD 3: UNGGAH DOKUMEN PERSYARATAN & PERSETUJUAN -->
                <section class="ppdb-section-card ppdb-slide" id="slide-3" data-step="3">
                    <div class="ppdb-slide-body">
                        <div class="ppdb-step-header">
                            <span class="ppdb-step-badge badge-emerald">3</span>
                            <div>
                                <h2 class="ppdb-step-heading">Unggah Berkas & Dokumen</h2>
                                <span style="font-size: 0.8rem; color: #94a3b8;">(Opsional saat pendaftaran awal, namun disarankan untuk mempercepat verifikasi)</span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 22px;">
                            <!-- KK -->
                            <div class="ppdb-upload-box">
                                <label for="doc_kk" class="ppdb-upload-title">📄 Kartu Keluarga (KK)</label>
                                <span class="ppdb-upload-sub">PDF/JPG/PNG (Maks. 3 MB)</span>
                                <input type="file" id="doc_kk" name="doc_kk" accept=".pdf,.jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%; color: #cbd5e1;" />
                            </div>

                            <!-- Akta Lahir -->
                            <div class="ppdb-upload-box">
                                <label for="doc_akta" class="ppdb-upload-title">📜 Akta Kelahiran</label>
                                <span class="ppdb-upload-sub">PDF/JPG/PNG (Maks. 3 MB)</span>
                                <input type="file" id="doc_akta" name="doc_akta" accept=".pdf,.jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%; color: #cbd5e1;" />
                            </div>

                            <!-- Pas Foto -->
                            <div class="ppdb-upload-box">
                                <label for="doc_foto" class="ppdb-upload-title">🖼️ Pas Foto Siswa (3x4)</label>
                                <span class="ppdb-upload-sub">JPG/PNG (Maks. 3 MB)</span>
                                <input type="file" id="doc_foto" name="doc_foto" accept=".jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%; color: #cbd5e1;" />
                            </div>

                            <!-- Rapor / SKL -->
                            <div class="ppdb-upload-box">
                                <label for="doc_rapor" class="ppdb-upload-title">📑 Rapor Terakhir / SKL</label>
                                <span class="ppdb-upload-sub">PDF/JPG/PNG (Maks. 3 MB)</span>
                                <input type="file" id="doc_rapor" name="doc_rapor" accept=".pdf,.jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%; color: #cbd5e1;" />
                            </div>
                        </div>

                        <!-- Privacy Notice & Persetujuan -->
                        <div class="ppdb-pdp-notice" style="margin-bottom: 10px;">
                            <div style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 12px;">
                                <span style="font-size: 1.3rem;">🛡️</span>
                                <div style="flex: 1;">
                                    <h4 class="ppdb-pdp-title">Kebijakan Pelindungan Data Pribadi (UU PDP No. 27/2022)</h4>
                                    <p class="ppdb-pdp-desc">
                                        Seluruh informasi dan berkas yang Anda kirimkan hanya akan digunakan untuk keperluan seleksi dan administrasi PPDB sekolah. Data tersimpan di server terenkripsi dan tidak akan dipindahtangankan kepada pihak ketiga tanpa izin orang tua/wali.
                                    </p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: flex-start; gap: 10px; margin-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                                <input type="checkbox" id="agreement" name="agreement" value="1" required style="margin-top: 4px; width: 18px; height: 18px; cursor: pointer;" />
                                <label for="agreement" style="font-size: 0.85rem; color: #e2e8f0; line-height: 1.5; cursor: pointer;">
                                    <strong>Saya menyatakan bahwa seluruh data yang diisikan adalah benar dan valid.</strong> Saya menyetujui data ini diproses oleh Panitia PPDB PKBM Tahfizh At-Tamam. <span style="color: #ef4444;">*</span>
                                </label>
                            </div>
                            @error('agreement')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Slide 3 Action Buttons -->
                    <div class="ppdb-slide-actions">
                        <button type="button" class="ppdb-btn-prev" onclick="prevSlide(2)">
                            ← Kembali ke Data Orang Tua
                        </button>
                        <button type="submit" id="btnSubmitForm" class="ppdb-btn-submit">
                            🚀 Kirim Pendaftaran PPDB
                        </button>
                    </div>
                    <p style="text-align: center; font-size: 0.8rem; color: #94a3b8; margin-top: 12px; margin-bottom: 0;">
                        Nomor Pendaftaran resmi akan otomatis digenerate setelah pengiriman berhasil.
                    </p>
                </section>
                    </div> <!-- /.ppdb-slide-track -->
                </div> <!-- /.ppdb-slide-deck -->
            </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const totalSteps = 3;
    const form = document.getElementById('ppdbForm');
    const initialStepFromErrors = form && form.dataset.initialStep ? parseInt(form.dataset.initialStep, 10) : 1;
    let currentStep = initialStepFromErrors || 1;

    let isTransitioning = false;

    // Perbarui tampilan stepper dan progress bar
    function updateStepperUI(targetStep) {
        const stepItems = document.querySelectorAll('.ppdb-step-item');
        stepItems.forEach(item => {
            const stepNum = parseInt(item.getAttribute('data-step'));
            item.classList.remove('active', 'completed');
            if (stepNum === targetStep) {
                item.classList.add('active');
            } else if (stepNum < targetStep) {
                item.classList.add('completed');
            }
        });

        const conn1 = document.getElementById('connector-1');
        const conn2 = document.getElementById('connector-2');
        if (conn1) {
            if (targetStep > 1) conn1.classList.add('completed');
            else conn1.classList.remove('completed');
        }
        if (conn2) {
            if (targetStep > 2) conn2.classList.add('completed');
            else conn2.classList.remove('completed');
        }

        const progressBar = document.getElementById('ppdbProgressBar');
        if (progressBar) {
            const percent = (targetStep / totalSteps) * 100;
            progressBar.style.width = percent + '%';
            if (targetStep === 3) {
                progressBar.style.background = 'linear-gradient(90deg, #38bdf8, #10b981)';
            } else {
                progressBar.style.background = 'linear-gradient(90deg, #38bdf8, #2563eb)';
            }
        }
    }

    // Sesuaikan tinggi container slide secara dinamis mengikuti tinggi konten aktif (Auto-Height)
    function updateDeckHeight(targetStep, immediate = false) {
        const step = targetStep || currentStep;
        const activeSlide = document.getElementById('slide-' + step);
        const deck = document.querySelector('.ppdb-slide-deck');
        if (!activeSlide || !deck) return;

        const h = activeSlide.offsetHeight;
        if (!h || h === 0) return;

        if (immediate) {
            const prevTransition = deck.style.transition;
            deck.style.transition = 'none';
            deck.style.height = h + 'px';
            void deck.offsetHeight;
            deck.style.transition = prevTransition;
        } else {
            deck.style.height = h + 'px';
        }
    }

    // Tampilkan slide tertentu melalui animasi Story Stack Scroll dengan timbal balik halus
    function showSlide(targetStep, shouldScroll = true, immediate = false) {
        if (targetStep === currentStep && !immediate) return;
        if (isTransitioning) return;
        if (targetStep < 1 || targetStep > totalSteps) return;

        const outgoing = document.getElementById('slide-' + currentStep);
        const incoming = document.getElementById('slide-' + targetStep);
        const deck = document.querySelector('.ppdb-slide-deck');

        if (!incoming) return;

        const animClasses = [
            'story-enter-forward',
            'story-underneath-forward',
            'story-exit-backward',
            'story-reveal-backward'
        ];

        // Inisialisasi awal tanpa animasi (load pertama / validasi error)
        if (immediate || !outgoing) {
            for (let i = 1; i <= totalSteps; i++) {
                const s = document.getElementById('slide-' + i);
                if (s) {
                    s.classList.remove(...animClasses);
                    if (i === targetStep) {
                        s.classList.add('active');
                        s.style.display = 'flex';
                        s.style.position = 'relative';
                        s.style.zIndex = '10';
                        s.style.transform = '';
                        s.style.opacity = '';
                        s.style.filter = '';
                        s.removeAttribute('inert');
                    } else {
                        s.classList.remove('active');
                        s.style.display = 'none';
                        s.style.position = 'absolute';
                        s.style.zIndex = '1';
                        s.setAttribute('inert', '');
                    }
                }
            }
            updateStepperUI(targetStep);
            currentStep = targetStep;
            updateDeckHeight(targetStep, true);
            return;
        }

        isTransitioning = true;
        const isNext = targetStep > currentStep;

        // Bersihkan inline transform/filter lama agar keyframes bekerja 100%
        incoming.style.transform = '';
        incoming.style.opacity = '';
        incoming.style.filter = '';
        outgoing.style.transform = '';
        outgoing.style.opacity = '';
        outgoing.style.filter = '';

        // 1. Tampilkan kedua kartu dan posisikan untuk animasi bertumpuk
        incoming.style.display = 'flex';
        incoming.style.position = 'absolute';
        incoming.style.top = '0';
        incoming.style.left = '0';
        incoming.style.width = '100%';
        incoming.style.zIndex = isNext ? '25' : '5';
        incoming.removeAttribute('inert');

        outgoing.style.display = 'flex';
        outgoing.style.position = 'absolute';
        outgoing.style.top = '0';
        outgoing.style.left = '0';
        outgoing.style.width = '100%';
        outgoing.style.zIndex = isNext ? '5' : '25';
        outgoing.setAttribute('inert', '');

        // Kunci tinggi deck agar tidak terjadi lonjakan tata letak
        const targetH = incoming.offsetHeight || 550;
        const currentH = outgoing.offsetHeight || targetH;
        const maxH = Math.max(targetH, currentH);
        if (deck) {
            deck.style.height = maxH + 'px';
        }

        // Bersihkan animasi sebelumnya jika ada
        outgoing.classList.remove(...animClasses);
        incoming.classList.remove(...animClasses);

        // Paksa browser me-reflow sebelum animasi dimulai
        void incoming.offsetWidth;
        void outgoing.offsetWidth;

        // 2. Koreografi Animasi Story Stack Scroll
        if (isNext) {
            // MAJU: Kartu baru muncul dari bawah tengah dengan sudut kiri atas memimpin,
            // meluncur diagonal ke arah kiri untuk menstabilkan diri.
            outgoing.classList.add('story-underneath-forward');
            incoming.classList.add('story-enter-forward');
        } else {
            // TIMBAL BALIK: Kartu atas meluncur keluar ke arah bawah tengah,
            // kartu bawah tersingkap kembali ke permukaan aktif.
            outgoing.classList.add('story-exit-backward');
            incoming.classList.add('story-reveal-backward');
        }

        // Perbarui nomor langkah pada stepper
        updateStepperUI(targetStep);
        currentStep = targetStep;

        // 3. Geser halaman ke atas memenuhi tampilan saat sudut kiri kartu menstabilkan posisinya
        if (shouldScroll) {
            setTimeout(() => {
                const deckEl = document.getElementById('ppdbSlideDeck') || incoming;
                if (deckEl) {
                    const rect = deckEl.getBoundingClientRect();
                    if (rect.top < 30 || rect.top > 250) {
                        const targetY = window.pageYOffset + rect.top - 80;
                        window.scrollTo({ top: targetY, behavior: 'smooth' });
                    }
                }
            }, isNext ? 350 : 180);
        }

        // 4. Penyesuaian tinggi ke targetHeight secara bertahap
        if (deck && targetH !== currentH) {
            setTimeout(() => {
                deck.style.height = targetH + 'px';
            }, 350);
        }

        // 5. Bersihkan kelas animasi & stabilkan elemen setelah animasi 650ms tuntas
        setTimeout(() => {
            outgoing.classList.remove('active', ...animClasses);
            outgoing.style.display = 'none';
            outgoing.style.position = 'absolute';
            outgoing.style.zIndex = '1';
            outgoing.style.transform = '';
            outgoing.style.filter = '';
            outgoing.style.opacity = '';

            incoming.classList.add('active');
            incoming.classList.remove(...animClasses);
            incoming.style.display = 'flex';
            incoming.style.position = 'relative';
            incoming.style.zIndex = '10';
            incoming.style.transform = '';
            incoming.style.filter = '';
            incoming.style.opacity = '';

            if (deck) {
                deck.style.height = (incoming.offsetHeight || targetH) + 'px';
            }

            isTransitioning = false;
        }, 650);
    }

    // Fungsi global untuk navigasi tombol
    window.nextSlide = function (targetStep) {
        showSlide(targetStep);
    };

    window.prevSlide = function (targetStep) {
        showSlide(targetStep);
    };

    window.jumpToStep = function (targetStep) {
        if (targetStep === currentStep) return;
        showSlide(targetStep);
    };

    // Navigasi dengan tombol Enter di input slide 1 & 2
    if (form) {
        form.querySelectorAll('#slide-1 input, #slide-2 input').forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    nextSlide(currentStep + 1);
                }
            });
        });

        // Submit form
        form.addEventListener('submit', function (e) {
            const submitBtn = document.getElementById('btnSubmitForm');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '⏳ Mengirim Data Pendaftaran...';
                submitBtn.style.opacity = '0.7';
                submitBtn.style.cursor = 'not-allowed';
            }
        });
    }

    // Feedback visual nama berkas yang diunggah
    document.querySelectorAll('.ppdb-upload-box input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const label = this.parentElement.querySelector('.ppdb-upload-sub');
            if (this.files && this.files.length > 0) {
                label.textContent = '✅ Berkas dipilih: ' + this.files[0].name;
                label.style.color = '#34d399';
                label.style.fontWeight = '700';
            }
        });
    });

    // Inisialisasi slide awal tanpa auto-scroll dan tanpa animasi membalik
    showSlide(currentStep, false, true);

    // Update tinggi saat resize atau rotasi perangkat
    window.addEventListener('resize', function () {
        updateDeckHeight(currentStep, true);
    });

    window.addEventListener('load', function () {
        updateDeckHeight(currentStep, true);
    });

    // Auto-update jika ada elemen dalam slide yang berubah dimensi
    if (window.ResizeObserver) {
        const ro = new ResizeObserver(() => {
            if (!isTransitioning) {
                updateDeckHeight(currentStep, false);
            }
        });
        for (let i = 1; i <= totalSteps; i++) {
            const s = document.getElementById('slide-' + i);
            if (s) ro.observe(s);
        }
    }
});
</script>
@endpush
