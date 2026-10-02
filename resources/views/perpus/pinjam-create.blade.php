@extends('layouts.app')

@section('title', 'Formulir Peminjaman - ' . $book->title)

@push('styles')
<style>
/* Page Layout Wrapper - 100% Centered Modern Dashboard Theme matching Website */
.perpus-pinjam-wrapper {
    position: relative;
    width: 100% !important;
    min-height: 100vh;
    padding-top: clamp(95px, 11vh, 125px) !important;
    padding-bottom: clamp(48px, 6vh, 80px) !important;
    box-sizing: border-box !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important; /* Force horizontally centered alignment for all viewports */
    justify-content: flex-start !important;
    margin-left: auto !important;
    margin-right: auto !important;
    background-color: #001529; /* Website base navy background */
    background-image: 
        radial-gradient(circle at 50% 0%, rgba(0, 180, 216, 0.12) 0%, rgba(0, 21, 41, 0.98) 55%, #001529 100%),
        radial-gradient(circle at 15% 30%, rgba(0, 180, 216, 0.04) 0%, transparent 40%),
        radial-gradient(circle at 85% 70%, rgba(16, 185, 129, 0.03) 0%, transparent 40%);
}

/* Focused Centered Container (Max 860px for Elegant Ergonomic Balance) */
.pinjam-center-container {
    width: 100% !important;
    max-width: 860px !important;
    margin-left: auto !important;
    margin-right: auto !important;
    padding-left: clamp(1rem, 2.5vw, 1.75rem) !important;
    padding-right: clamp(1rem, 2.5vw, 1.75rem) !important;
    box-sizing: border-box !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: stretch !important;
}

/* Master Form Card Outer Shell */
.pinjam-master-card {
    width: 100% !important;
    max-width: 860px !important;
    margin-left: auto !important;
    margin-right: auto !important;
    box-sizing: border-box !important;
    background: rgba(0, 28, 58, 0.88);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(0, 180, 216, 0.22);
    border-radius: 18px;
    padding: 18px;
    box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.55), 0 0 25px rgba(0, 180, 216, 0.05);
}

@media (max-width: 639px) {
    .pinjam-master-card {
        padding: 14px;
        border-radius: 16px;
    }
}

/* Inner Surface Card matching Screenshot (37).png */
.pinjam-inner-surface {
    background: rgba(2, 16, 33, 0.95);
    border: 1px solid rgba(0, 180, 216, 0.18);
    border-radius: 14px;
    padding: 1.5rem;
    box-sizing: border-box;
}

@media (min-width: 640px) {
    .pinjam-inner-surface {
        padding: 1.85rem;
    }
}

/* Status Badge Top - Generous Breathable Padding */
.pinjam-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    border-radius: 9999px;
    background: rgba(16, 185, 129, 0.16);
    color: #6ee7b7;
    border: 1px solid rgba(16, 185, 129, 0.38);
    font-size: 12.5px;
    font-weight: 600;
    line-height: 1.35;
    box-shadow: 0 1px 4px rgba(16, 185, 129, 0.1);
}

/* Book Information Strip */
.pinjam-book-strip {
    display: flex;
    gap: 18px;
    align-items: center;
    background: rgba(4, 21, 42, 0.75);
    border: 1px solid rgba(0, 180, 216, 0.22);
    border-radius: 14px;
    padding: 16px 18px;
    margin-bottom: 22px;
    box-sizing: border-box;
}

@media (max-width: 639px) {
    .pinjam-book-strip {
        flex-direction: column;
        align-items: flex-start;
        gap: 14px;
        padding: 14px;
    }
}

/* Cover Placeholder Box (72x96px) */
.pinjam-cover-box {
    width: 72px;
    height: 96px;
    flex: none;
    background: rgba(2, 14, 28, 0.95);
    border: 1px solid rgba(0, 180, 216, 0.25);
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    color: #94a3b8;
    overflow: hidden;
}

/* Spacious Badges (No longer cramped / sempit) */
.pinjam-cat-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    font-size: 12.5px;
    font-weight: 600;
    line-height: 1.35;
    border-radius: 9999px;
    background: rgba(0, 180, 216, 0.16);
    color: #38bdf8;
    border: 1px solid rgba(0, 180, 216, 0.35);
    letter-spacing: 0.01em;
    box-shadow: 0 1px 4px rgba(0, 180, 216, 0.1);
}

.pinjam-stock-badge {
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    font-size: 12.5px;
    font-weight: 600;
    line-height: 1.35;
    border-radius: 9999px;
    letter-spacing: 0.01em;
}

.pinjam-stock-badge.stock-available {
    background: rgba(16, 185, 129, 0.16);
    color: #6ee7b7;
    border: 1px solid rgba(16, 185, 129, 0.38);
    box-shadow: 0 1px 4px rgba(16, 185, 129, 0.1);
}

.pinjam-stock-badge.stock-empty {
    background: rgba(239, 68, 68, 0.16);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.38);
}

/* Specification Pills - Spacious & Breathable */
.pinjam-spec-pill {
    font-size: 12.5px;
    font-weight: 500;
    padding: 6px 14px;
    border: 1px solid rgba(0, 180, 216, 0.25);
    border-radius: 9999px;
    background: rgba(2, 20, 42, 0.8);
    color: #cbd5e1;
    display: inline-flex;
    gap: 7px;
    align-items: center;
    line-height: 1.35;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

/* Form Styles */
.f {
    display: flex;
    flex-direction: column;
    gap: 7px;
    width: 100%;
}
.f label {
    font-size: 13.5px;
    font-weight: 500;
    color: #f1f5f9;
}
.f small {
    font-size: 12px;
    color: #94a3b8;
    line-height: 1.45;
}
.ip {
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid rgba(0, 180, 216, 0.25);
    border-radius: 10px;
    background: rgba(2, 13, 28, 0.95);
    padding: 0 14px;
    height: 46px; /* Roomy, comfortable touch target */
    transition: all 0.2s ease;
    width: 100%;
    box-sizing: border-box;
}
.ip:focus-within {
    border-color: #00b4d8;
    box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.2);
    background: rgba(3, 18, 38, 0.95);
}
.ip.has-error {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.25) !important;
}
.ip svg {
    color: #94a3b8;
    flex-shrink: 0;
    transition: color 0.2s ease;
}
.ip:focus-within svg {
    color: #00b4d8;
}
.ip input {
    flex: 1;
    min-width: 0;
    border: none !important;
    background: transparent !important;
    box-shadow: none !important;
    padding: 0 !important;
    height: 100% !important;
    outline: none !important;
    color: #ffffff !important;
    font-size: 14px;
}
.ip input::placeholder {
    color: #64748b;
}

/* Notice / Ketentuan Peminjaman Box - Spacious Padding */
.pinjam-ketentuan-box {
    margin-top: 24px;
    background: rgba(245, 158, 11, 0.09);
    border: 1px solid rgba(245, 158, 11, 0.3);
    border-radius: 14px;
    padding: 16px 20px;
    box-sizing: border-box;
}

/* Action Buttons */
.btn-batal-pinjam {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 500;
    color: #cbd5e1;
    background: rgba(4, 18, 35, 0.85);
    border: 1px solid rgba(148, 163, 184, 0.25);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-batal-pinjam:hover {
    color: #ffffff;
    background: rgba(15, 30, 55, 0.95);
    border-color: rgba(148, 163, 184, 0.45);
}

.btn-kirim-pengajuan {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 600;
    color: #ffffff;
    background: linear-gradient(135deg, #00b4d8 0%, #0077b6 100%);
    border: 1px solid rgba(0, 180, 216, 0.4);
    border-radius: 10px;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(0, 180, 216, 0.3);
    transition: all 0.2s ease;
}
.btn-kirim-pengajuan:hover {
    background: linear-gradient(135deg, #22d3ee 0%, #0096c7 100%);
    box-shadow: 0 6px 20px rgba(0, 180, 216, 0.45);
    transform: translateY(-1px);
}

/* WhatsApp Bottom Pill */
.pinjam-wa-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 22px;
    border-radius: 9999px;
    font-size: 13.5px;
    font-weight: 600;
    line-height: 1.35;
    background: rgba(16, 185, 129, 0.16);
    color: #6ee7b7;
    border: 1px solid rgba(16, 185, 129, 0.38);
    transition: all 0.2s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}
.pinjam-wa-pill:hover {
    background: rgba(16, 185, 129, 0.28);
    color: #a7f3d0;
    border-color: rgba(16, 185, 129, 0.55);
}

/* Breadcrumb Button Default (Dark Theme) */
.btn-breadcrumb-back {
    color: #38bdf8;
    background: rgba(3, 28, 56, 0.85);
    border: 1px solid rgba(0, 180, 216, 0.35);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease;
}
.btn-breadcrumb-back:hover {
    color: #ffffff;
    background: rgba(6, 40, 79, 0.95);
    border-color: rgba(0, 180, 216, 0.6);
    box-shadow: 0 0 14px rgba(0, 180, 216, 0.25);
    transform: translateY(-1px);
}
.btn-breadcrumb-back svg {
    color: #00b4d8;
    transition: color 0.2s ease;
}
.btn-breadcrumb-back:hover svg {
    color: #ffffff;
}

.breadcrumb-link {
    color: #94a3b8;
    transition: color 0.2s ease;
}
.breadcrumb-link:hover {
    color: #38bdf8;
}

.pinjam-section-header {
    border-bottom: 1px solid rgba(0, 180, 216, 0.18);
}

.pinjam-action-footer {
    border-top: 1px solid rgba(0, 180, 216, 0.2);
}

/* Smooth transitions when user clicks theme toggle button */
.perpus-pinjam-wrapper,
.pinjam-master-card,
.pinjam-inner-surface,
.pinjam-book-strip,
.pinjam-cover-box,
.pinjam-cat-badge,
.pinjam-stock-badge,
.pinjam-spec-pill,
.pinjam-status-pill,
.pinjam-ketentuan-box,
.pinjam-section-header,
.pinjam-action-footer,
.btn-breadcrumb-back,
.btn-batal-pinjam,
.btn-kirim-pengajuan,
.pinjam-wa-pill,
.ip {
    transition: background 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                background-color 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                border-color 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                color 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.2s ease !important;
}

/* ═══════════════════════════════════════════════════════════
   LIGHT / RED THEME SYNCHRONIZATION ([data-theme="light"])
   Sinkronisasi Penuh dengan Mode Warna Merah (Velvet Crimson)
   ═══════════════════════════════════════════════════════════ */
[data-theme="light"] .perpus-pinjam-wrapper {
    background-color: oklch(41% 0.159 10.272) !important;
    background-image: 
        radial-gradient(circle at 50% 0%, oklch(58.6% 0.253 17.585 / 0.42) 0%, oklch(32% 0.13 12 / 0.98) 55%, oklch(27.1% 0.105 12.094) 100%),
        radial-gradient(circle at 15% 30%, oklch(58.6% 0.253 17.585 / 0.25) 0%, transparent 45%),
        radial-gradient(circle at 85% 70%, oklch(58.6% 0.253 17.585 / 0.2) 0%, transparent 45%) !important;
}

[data-theme="light"] .pinjam-master-card {
    background: linear-gradient(145deg, oklch(27.1% 0.105 12.094 / 0.96) 0%, oklch(22% 0.09 11 / 0.98) 100%) !important;
    border: 1.5px solid oklch(58.6% 0.253 17.585 / 0.55) !important;
    box-shadow: 0 20px 50px -10px rgba(25, 4, 9, 0.65), 0 0 35px oklch(58.6% 0.253 17.585 / 0.3) !important;
}

[data-theme="light"] .pinjam-inner-surface {
    background: oklch(20% 0.08 11 / 0.95) !important;
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.38) !important;
}

[data-theme="light"] .pinjam-status-pill {
    background: rgba(16, 185, 129, 0.18) !important;
    border-color: rgba(16, 185, 129, 0.45) !important;
    color: #34d399 !important;
}

[data-theme="light"] .pinjam-book-strip {
    background: oklch(25% 0.095 11.5 / 0.88) !important;
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.45) !important;
}

[data-theme="light"] .pinjam-cover-box {
    background: oklch(18% 0.07 11 / 0.95) !important;
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.5) !important;
}

[data-theme="light"] .pinjam-cat-badge {
    background: oklch(58.6% 0.253 17.585 / 0.3) !important;
    color: #ffffff !important;
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.7) !important;
    box-shadow: 0 2px 10px oklch(58.6% 0.253 17.585 / 0.35) !important;
}

[data-theme="light"] .pinjam-spec-pill {
    background: oklch(24% 0.09 11.5 / 0.85) !important;
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.45) !important;
    color: #ffe4e6 !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25) !important;
}

[data-theme="light"] .pinjam-spec-pill svg {
    color: oklch(75% 0.18 18) !important;
}

[data-theme="light"] .btn-breadcrumb-back {
    color: #ffe4e6 !important;
    background: oklch(22% 0.085 11 / 0.9) !important;
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.5) !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.35) !important;
}

[data-theme="light"] .btn-breadcrumb-back:hover {
    color: #ffffff !important;
    background: oklch(58.6% 0.253 17.585 / 0.35) !important;
    border-color: oklch(58.6% 0.253 17.585 / 0.9) !important;
    box-shadow: 0 0 18px oklch(58.6% 0.253 17.585 / 0.45) !important;
}

[data-theme="light"] .btn-breadcrumb-back svg {
    color: oklch(75% 0.18 18) !important;
}

[data-theme="light"] .btn-breadcrumb-back:hover svg {
    color: #ffffff !important;
}

[data-theme="light"] .breadcrumb-link {
    color: #fda4af !important;
}

[data-theme="light"] .breadcrumb-link:hover {
    color: #ffffff !important;
}

[data-theme="light"] .f label {
    color: #ffffff !important;
}

[data-theme="light"] .f small {
    color: #fda4af !important;
}

[data-theme="light"] .ip {
    background: oklch(20% 0.08 11 / 0.92) !important;
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.45) !important;
}

[data-theme="light"] .ip:focus-within {
    border-color: oklch(58.6% 0.253 17.585) !important;
    box-shadow: 0 0 0 3px oklch(58.6% 0.253 17.585 / 0.35), 0 0 16px oklch(58.6% 0.253 17.585 / 0.25) !important;
    background: oklch(23% 0.09 11.5 / 0.98) !important;
}

[data-theme="light"] .ip svg {
    color: oklch(75% 0.18 18) !important;
}

[data-theme="light"] .ip:focus-within svg {
    color: #ffffff !important;
}

[data-theme="light"] .ip input::placeholder,
[data-theme="light"] .ip textarea::placeholder {
    color: oklch(75% 0.18 18 / 0.6) !important;
}

[data-theme="light"] .pinjam-section-header {
    border-bottom-color: oklch(58.6% 0.253 17.585 / 0.38) !important;
}

[data-theme="light"] .pinjam-section-header svg {
    color: oklch(75% 0.18 18) !important;
}

[data-theme="light"] .pinjam-ketentuan-box {
    background: oklch(30% 0.1 50 / 0.24) !important;
    border-color: oklch(65% 0.18 50 / 0.45) !important;
}

[data-theme="light"] .pinjam-ketentuan-box span {
    color: #ffe4e6 !important;
}

[data-theme="light"] .pinjam-action-footer {
    border-top-color: oklch(58.6% 0.253 17.585 / 0.38) !important;
}

[data-theme="light"] .btn-batal-pinjam {
    background: oklch(22% 0.085 11 / 0.85) !important;
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.4) !important;
    color: #ffe4e6 !important;
}

[data-theme="light"] .btn-batal-pinjam:hover {
    background: oklch(58.6% 0.253 17.585 / 0.3) !important;
    border-color: oklch(58.6% 0.253 17.585 / 0.8) !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-kirim-pengajuan {
    background: linear-gradient(135deg, oklch(58.6% 0.253 17.585) 0%, oklch(48% 0.22 17) 100%) !important;
    border: 1px solid rgba(251, 113, 133, 0.7) !important;
    box-shadow: 0 4px 18px oklch(58.6% 0.253 17.585 / 0.5) !important;
}

[data-theme="light"] .btn-kirim-pengajuan:hover {
    background: linear-gradient(135deg, oklch(65% 0.26 18) 0%, oklch(53% 0.24 17) 100%) !important;
    box-shadow: 0 6px 24px oklch(58.6% 0.253 17.585 / 0.7) !important;
}

[data-theme="light"] .pinjam-wa-pill {
    background: rgba(16, 185, 129, 0.18) !important;
    color: #34d399 !important;
    border-color: rgba(16, 185, 129, 0.45) !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25) !important;
}

[data-theme="light"] .pinjam-wa-pill:hover {
    background: rgba(16, 185, 129, 0.3) !important;
    color: #ffffff !important;
    border-color: rgba(16, 185, 129, 0.65) !important;
}

/* Light / Red Theme: Subtle Text Adaptations */
[data-theme="light"] .perpus-pinjam-wrapper .text-slate-300 {
    color: #ffe4e6 !important;
}

[data-theme="light"] .perpus-pinjam-wrapper .text-slate-400 {
    color: #fda4af !important;
}
</style>
@endpush

@section('konten_utama')
<div class="perpus-pinjam-wrapper" style="display: flex !important; flex-direction: column !important; align-items: center !important; justify-content: flex-start !important; width: 100% !important; margin-left: auto !important; margin-right: auto !important;">
    <div class="pinjam-center-container w-full max-w-4xl" style="width: 100% !important; max-width: 860px !important; margin-left: auto !important; margin-right: auto !important;">
        
        {{-- Outer Card Shell --}}
        <div class="pinjam-master-card" style="width: 100% !important; max-width: 860px !important; margin-left: auto !important; margin-right: auto !important;">
            
            {{-- Breadcrumb Navigation Row --}}
            <x-breadcrumb :book="$book" current="Form pinjam" backText="Kembali ke detail buku" />

            {{-- Inner Surface Card matching Screenshot (37).png --}}
            <div class="pinjam-inner-surface">
                
                {{-- Header Section (Centered & Symmetrical) --}}
                <div class="flex flex-col items-center text-center mb-6 pt-1">
                    {{-- Status Pill --}}
                    <div class="mb-3">
                        <span class="pinjam-status-pill">
                            <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>
                            <span>Sirkulasi mandiri literasi</span>
                        </span>
                    </div>

                    {{-- Heading & Subtitle --}}
                    <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2 leading-tight">
                        Ajukan peminjaman buku
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-xl mx-auto">
                        Isi identitas di bawah ini. Kode referensi peminjaman akan langsung diterbitkan untuk proses serah terima buku di perpustakaan sekolah.
                    </p>
                </div>

                {{-- Book Information Strip --}}
                <div class="pinjam-book-strip">
                    {{-- Cover Box (72x96px) --}}
                    <div class="pinjam-cover-box" aria-label="Sampul {{ $book->title }}">
                        @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}"
                                 alt="Sampul {{ $book->title }}"
                                 width="72"
                                 height="96"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<svg class=\'w-6 h-6 text-slate-400\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'1.75\' stroke-linecap=\'round\' stroke-linejoin=\'round\' viewBox=\'0 0 24 24\'><path d=\'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253\'/></svg><span class=\'text-[11px] text-slate-400 font-medium\'>Sampul</span>';"
                                 class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253"/>
                            </svg>
                            <span class="text-[11px] text-slate-400 font-medium">Sampul</span>
                        @endif
                    </div>

                    {{-- Book Details --}}
                    <div class="flex-1 min-w-0">
                        {{-- Spacious Badges Row --}}
                        <div class="flex flex-wrap items-center gap-2.5 mb-2">
                            <span class="pinjam-cat-badge">
                                {{ $book->category ? $book->category->name : 'Sains & Teknologi' }}
                            </span>
                            <span class="pinjam-stock-badge {{ $book->available > 0 ? 'stock-available' : 'stock-empty' }}">
                                {{ $book->available > 0 ? $book->available . ' eksemplar tersedia' : 'Stok habis' }}
                            </span>
                        </div>

                        {{-- Book Title --}}
                        <h2 class="text-base sm:text-[18px] font-semibold text-white mb-1 leading-snug">
                            {{ $book->title }}
                        </h2>

                        {{-- Author --}}
                        <p class="text-xs text-slate-400 mb-3">
                            Penulis: <span class="text-slate-300 font-medium">{{ $book->author }}</span>
                        </p>

                        {{-- Specs Row - Spacious Badges --}}
                        <div class="flex flex-wrap items-center gap-2.5">
                            <span class="pinjam-spec-pill">
                                <svg class="w-3.5 h-3.5 text-cyan-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <span>7 hari kalender</span>
                            </span>

                            <span class="pinjam-spec-pill">
                                <svg class="w-3.5 h-3.5 text-cyan-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <span>{{ $book->rack_location ? (str_starts_with($book->rack_location, 'Rak') ? $book->rack_location : 'Rak ' . $book->rack_location) : 'Rak E-02' }}</span>
                            </span>

                            <span class="pinjam-spec-pill">
                                <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 7v10M9 9h4.5a1.5 1.5 0 0 1 0 3H10.5a1.5 1.5 0 0 0 0 3H15"/>
                                </svg>
                                <span>Gratis</span>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Alert Ringkasan Validasi Backend --}}
                @if($errors->any())
                    <div class="mb-5 p-3.5 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs" role="alert">
                        <p class="font-semibold mb-1">Periksa kembali data yang dimasukkan:</p>
                        <ul class="list-disc list-inside space-y-0.5 text-rose-200">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM SECTION: Identitas Peminjam --}}
                <form action="{{ route('perpus.pinjam.store', $book->id) }}" method="POST" id="pinjamForm" novalidate>
                    @csrf

                    {{-- Section Header --}}
                    <p class="pinjam-section-header flex items-center gap-2 text-sm font-semibold text-white mb-3.5 pb-2 border-b border-cyan-500/15">
                        <svg class="w-4 h-4 text-cyan-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span>Identitas peminjam</span>
                    </p>

                    {{-- 2-Column Row: Nama Lengkap & Nomor WhatsApp --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 mb-4 sm:mb-5">
                        {{-- Field 1: Nama Lengkap --}}
                        <x-form-input 
                            name="full_name" 
                            id="full_name" 
                            label="Nama lengkap" 
                            icon="user" 
                            :required="true" 
                            placeholder="Muhammad Rayhan" 
                            helper="Untuk santri, siswa, guru, staf, dan pengunjung." 
                            :value="old('full_name')" />

                        {{-- Field 2: Nomor WhatsApp Aktif --}}
                        <x-form-input 
                            name="phone" 
                            id="phone" 
                            type="tel" 
                            label="Nomor WhatsApp aktif" 
                            icon="whatsapp" 
                            :required="true" 
                            placeholder="081234567890" 
                            helper="Dipakai untuk melacak kode peminjaman." 
                            :value="old('phone')" />
                    </div>

                    {{-- Field 3: Kelas / Asrama / Domisili (Full Width) --}}
                    <div class="mb-5">
                        <x-form-input 
                            name="address" 
                            id="address" 
                            label="Kelas / asrama / domisili" 
                            icon="building" 
                            :required="false" 
                            placeholder="Kelas X Tahfizh A / Asrama Kampus Panam" 
                            helper="Membantu petugas mengenali Anda saat penyerahan buku." 
                            :value="old('address')" />
                    </div>

                    {{-- Ketentuan Peminjaman Box (Spacious Padding & Clean Grid) --}}
                    <div class="pinjam-ketentuan-box">
                        <p class="flex items-center gap-2 text-xs sm:text-[13.5px] font-semibold text-amber-300 mb-2.5">
                            <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            <span>Ketentuan peminjaman</span>
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2.5 sm:gap-4 text-xs sm:text-[13px] text-slate-200">
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                <span>Maksimal 7 hari kalender sejak buku diambil.</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                <span>Jaga buku tanpa coretan atau kerusakan.</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                <span>Tunjukkan tiket pinjam ke petugas.</span>
                            </span>
                        </div>
                    </div>

                    {{-- Bottom Action Row --}}
                    <div class="pinjam-action-footer border-t border-cyan-500/20 pt-6 sm:pt-7 mt-8 sm:mt-10 flex flex-wrap items-center justify-between gap-3.5" style="margin-top: 38px !important; padding-top: 26px !important;">
                        <span class="flex items-center gap-2 text-xs text-slate-400">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Layanan gratis. Data Anda terlindungi.</span>
                        </span>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('perpus.show', $book->id) }}" class="btn-batal-pinjam">
                                Batal
                            </a>
                            <button type="submit" id="submitBtn" class="btn-kirim-pengajuan">
                                <svg id="submitSpinner" class="w-3.5 h-3.5 shrink-0 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                                <span id="submitText">Kirim pengajuan</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>

            {{-- WhatsApp Contact Below Card --}}
            <div class="flex justify-end mt-7 sm:mt-8" style="width: 100%; max-width: 860px; margin-left: auto; margin-right: auto; margin-top: 28px !important;">
                <a href="https://wa.me/6281270001920?text=Halo%20Perpustakaan%20At-Tamam,%20saya%20ingin%20tanya%20peminjaman%20buku%20{{ urlencode($book->title) }}" 
                   target="_blank" 
                   rel="noopener"
                   class="pinjam-wa-pill">
                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                    </svg>
                    <span>WhatsApp online, hubungi kami</span>
                </a>
            </div>

        </div>

    </div>
</div>

{{-- Interactive Client Scripts --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pinjamForm');
    const phoneInput = document.getElementById('phone');
    const submitBtn = document.getElementById('submitBtn');
    const submitSpinner = document.getElementById('submitSpinner');
    const submitText = document.getElementById('submitText');

    // Auto sanitize phone input to numeric
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    }

    // Anti double submit guard
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            const fullName = document.getElementById('full_name')?.value.trim();
            const phone = phoneInput?.value.trim();

            if (!fullName || !phone) {
                return; // Let native HTML5 validation highlight empty required fields
            }

            // Disable button and show spinner
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            if (submitSpinner) submitSpinner.classList.remove('hidden');
            if (submitText) submitText.innerText = 'Mengirim...';
        });
    }
});
</script>
@endpush
@endsection
