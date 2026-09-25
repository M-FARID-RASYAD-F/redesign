@extends('layouts.app')

@section('title', 'Lacak Status Peminjaman Buku - Perpustakaan Digital')

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-narrow">

        <!-- Official Print Receipt Header (Only visible when printing slip) -->
        <div class="print-only text-black mb-6 border-b-2 border-black pb-4 text-center">
            <h2 class="text-xl font-bold uppercase tracking-wider">PKBM Tahfizh At-Tamam Edu</h2>
            <p class="text-xs text-slate-700">Unit Pelayanan Perpustakaan &amp; Sirkulasi Literasi Mandiri</p>
            <p class="text-xs text-slate-700">Jl. Hangtuah No. 45, Pekanbaru | Telp/WA: 0812-7000-1920</p>
            <div class="mt-3 text-sm font-bold border-t border-b border-black py-1">
                LEMBAR STATUS PEMINJAMAN BUKU PERPUSTAKAAN
            </div>
        </div>
        
        <!-- Breadcrumb / Header Navigation -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 no-print">
            <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-300 font-medium" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <span class="text-slate-500">/</span>
                <a href="{{ route('perpus.index') }}" class="hover:text-white transition-colors">Perpustakaan</a>
                <span class="text-slate-500">/</span>
                <span class="text-slate-400" aria-current="page">Lacak Status</span>
            </nav>

            <a href="{{ route('perpus.index') }}" class="perpus-btn-detail inline-flex items-center gap-2 px-3.5 py-2 text-xs sm:text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Katalog Buku</span>
            </a>
        </div>

        <!-- Header Hero (Screen only) -->
        <div class="text-center mb-8 no-print">
            <div class="perpus-hero-badge">
                Layanan Mandiri Sirkulasi
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-white mb-3 tracking-tight">
                Lacak Status Peminjaman
            </h1>
            <p class="text-slate-300 text-sm sm:text-base max-w-lg mx-auto leading-relaxed">
                Periksa status pengajuan, masa berlaku peminjaman, serta lokasi rak buku dengan memasukkan Kode Peminjaman atau Nomor WhatsApp Anda.
            </p>
        </div>

        <!-- Search Card (Screen only) -->
        <div class="perpus-card-surface p-6 sm:p-8 mb-8 no-print">
            <form action="{{ route('perpus.check') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="loan_code" class="block text-sm font-bold text-slate-200">
                            Kode Peminjaman atau No. WhatsApp
                        </label>
                        <span class="text-xs text-slate-400">Pencarian Otomatis</span>
                    </div>
                    <div class="relative">
                        <svg class="w-5 h-5 absolute left-3.5 top-3.5 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="loan_code" name="loan_code" value="{{ old('loan_code', isset($loan) ? $loan->loan_code : request('loan_code')) }}" required placeholder="Contoh: PINJAM-2026-0001 atau 081234567890" class="perpus-form-input w-full pl-11 pr-4 py-3 bg-white/5 border border-white/20 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 font-mono font-semibold uppercase text-white placeholder-slate-400 text-sm sm:text-base transition-all">
                    </div>
                    <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                        <span>Format yang didukung:</span>
                        <span class="px-2 py-0.5 rounded bg-white/10 text-emerald-300 font-mono font-medium">PINJAM-YYYY-XXXX</span>
                        <span>atau</span>
                        <span class="px-2 py-0.5 rounded bg-white/10 text-sky-300 font-medium">08xxxxxxxxxx</span>
                    </div>
                </div>

                @if($errors->has('loan_code'))
                <div class="p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm flex items-center gap-2" role="alert">
                    <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $errors->first('loan_code') }}</span>
                </div>
                @endif

                <button type="submit" class="perpus-btn-borrow w-full py-3.5 text-base flex items-center justify-center gap-2 font-bold cursor-pointer min-h-[48px]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    <span>Periksa Status Peminjaman</span>
                </button>
            </form>
        </div>

        <!-- Result Card if $loan is present -->
        @if(isset($loan))
        <div class="perpus-card-surface overflow-hidden mb-8 shadow-2xl">
            <!-- Header Result -->
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-white/10 bg-white/5">
                <div>
                    <div class="text-xs uppercase tracking-wider text-slate-400 font-medium">Hasil Pencarian Peminjaman</div>
                    <div class="text-xl sm:text-2xl font-extrabold font-mono text-emerald-400 tracking-wide mt-1">
                        {{ $loan->loan_code }}
                    </div>
                </div>
                <div>
                    @php
                        $badgeClasses = match($loan->status) {
                            'diajukan'     => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
                            'dipinjam'     => 'bg-blue-500/20 text-blue-300 border-blue-500/40',
                            'dikembalikan' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40',
                            'terlambat'    => 'bg-rose-500/20 text-rose-300 border-rose-500/40',
                            default        => 'bg-slate-500/20 text-slate-300 border-slate-500/40',
                        };

                        $step = match($loan->status) {
                            'diajukan'     => 1,
                            'dipinjam'     => 2,
                            'dikembalikan' => 3,
                            'terlambat'    => 2,
                            default        => 1,
                        };

                        $progressWidth = match($step) {
                            1 => '15%',
                            2 => '55%',
                            3 => '100%',
                            default => '15%',
                        };
                    @endphp
                    <span class="inline-block px-4 py-2 rounded-xl text-xs sm:text-sm font-bold border {{ $badgeClasses }}">
                        {{ $loan->status_label }}
                    </span>
                </div>
            </div>

            <!-- Stepper Progress Bar (Screen only) -->
            <div class="px-4 sm:px-8 pt-6 pb-2 no-print">
                <div class="perpus-stepper">
                    <div class="perpus-step-line">
                        <div class="perpus-step-line-progress" style="width: {{ $progressWidth }};"></div>
                    </div>
                    
                    <!-- Step 1: Diajukan -->
                    <div class="perpus-step-item {{ $step >= 1 ? 'step-active' : '' }}">
                        <div class="perpus-step-circle">
                            @if($step > 1)
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                                1
                            @endif
                        </div>
                        <div class="perpus-step-label">
                            <span class="block font-semibold">Diajukan</span>
                            <span class="block text-[10px] sm:text-[11px] opacity-80 font-normal">{{ $loan->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Step 2: Diambil / Fisik -->
                    <div class="perpus-step-item {{ $loan->status === 'terlambat' ? 'step-warning' : ($step >= 2 ? 'step-active' : '') }}">
                        <div class="perpus-step-circle">
                            @if($step > 2)
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @elseif($loan->status === 'terlambat')
                                !
                            @else
                                2
                            @endif
                        </div>
                        <div class="perpus-step-label">
                            <span class="block font-semibold">{{ $loan->status === 'terlambat' ? 'Terlambat' : 'Dipinjam' }}</span>
                            <span class="block text-[10px] sm:text-[11px] opacity-80 font-normal">
                                {{ $loan->borrowed_at ? $loan->borrowed_at->format('d M Y') : 'Verifikasi Pustakawan' }}
                            </span>
                        </div>
                    </div>

                    <!-- Step 3: Selesai -->
                    <div class="perpus-step-item {{ $step >= 3 ? 'step-active' : '' }}">
                        <div class="perpus-step-circle">
                            @if($step >= 3)
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                                3
                            @endif
                        </div>
                        <div class="perpus-step-label">
                            <span class="block font-semibold">Dikembalikan</span>
                            <span class="block text-[10px] sm:text-[11px] opacity-80 font-normal">
                                {{ $loan->returned_at ? $loan->returned_at->format('d M Y') : 'Batas: ' . ($loan->due_at ? $loan->due_at->format('d M') : '-') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Body -->
            <div class="p-6 sm:p-8 space-y-6 pt-2">
                <!-- Book Info with Cover (Fixed Image Fallback) -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5 p-5 rounded-2xl perpus-card-subsurface">
                    <div class="w-24 h-32 rounded-xl overflow-hidden shrink-0 shadow-lg border border-white/10 flex items-center justify-center bg-slate-900/60">
                        <img src="{{ $loan->book->cover ? asset('storage/' . $loan->book->cover) : asset('images/book-placeholder.png') }}" 
                             alt="Sampul buku: {{ $loan->book->title }}" 
                             width="96" 
                             height="128" 
                             onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                {{ $loan->book->category->name ?? 'Kategori Umum' }}
                            </span>
                            @if($loan->book->rack_location)
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/10 text-slate-300 border border-white/10">
                                    Lokasi Rak: {{ $loan->book->rack_location }}
                                </span>
                            @endif
                        </div>
                        <h2 class="font-bold text-white text-lg sm:text-xl mb-1 leading-snug">
                            {{ $loan->book->title }}
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 mb-3">
                            Penulis: <span class="font-medium text-white">{{ $loan->book->author }}</span>
                            @if($loan->book->isbn)
                                • ISBN: <span class="font-mono text-slate-400">{{ $loan->book->isbn }}</span>
                            @endif
                        </p>
                        <a href="{{ route('perpus.show', $loan->book->id) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-400 hover:text-emerald-300 transition-colors no-print">
                            <span>Buka Halaman Detail Buku</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Timeline / Key Dates Grid -->
                <div class="perpus-timeline-grid text-sm">
                    <div class="p-4 rounded-xl perpus-card-subsurface">
                        <div class="text-xs text-slate-400 mb-1">Tanggal Diajukan</div>
                        <div class="font-bold text-white">{{ $loan->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="p-4 rounded-xl perpus-card-subsurface">
                        <div class="text-xs text-slate-400 mb-1">Tanggal Diambil (Fisik)</div>
                        <div class="font-bold text-white">{{ $loan->borrowed_at ? $loan->borrowed_at->format('d M Y') : 'Menunggu Pustakawan' }}</div>
                    </div>
                    <div class="p-4 rounded-xl perpus-card-subsurface">
                        <div class="text-xs text-slate-400 mb-1">Batas Waktu / Jatuh Tempo</div>
                        <div class="font-bold {{ $loan->status === 'terlambat' ? 'text-rose-400' : 'text-emerald-400' }}">
                            {{ $loan->due_at ? $loan->due_at->format('d M Y') : '-' }}
                        </div>
                    </div>
                </div>

                <!-- Borrower Details -->
                <div class="border-t border-white/10 pt-4 text-sm space-y-2.5">
                    <div class="flex justify-between items-center text-slate-300">
                        <span>Peminjam Terdaftar:</span>
                        <span class="font-semibold text-white">{{ $loan->member->full_name }}</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-300">
                        <span>Nomor Anggota:</span>
                        <span class="font-mono font-bold text-emerald-400">{{ $loan->member->member_code }}</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-300">
                        <span>Nomor WhatsApp:</span>
                        <span class="font-mono text-slate-300">{{ substr($loan->member->phone, 0, 4) }}****{{ substr($loan->member->phone, -4) }}</span>
                    </div>
                    @if($loan->returned_at)
                    <div class="flex justify-between items-center text-slate-300">
                        <span>Tanggal Dikembalikan:</span>
                        <span class="font-bold text-emerald-400">{{ $loan->returned_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                    @if($loan->notes)
                    <div class="mt-4 p-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-200 text-xs">
                        <span class="font-bold block mb-0.5 text-amber-300">Catatan Petugas Perpustakaan:</span>
                        {{ $loan->notes }}
                    </div>
                    @endif
                </div>

                <!-- Action Buttons (Screen only) -->
                <div class="pt-4 border-t border-white/10 flex flex-col sm:flex-row gap-3 no-print">
                    <button type="button" onclick="window.print()" class="flex-1 py-3 px-4 rounded-xl bg-white/10 hover:bg-white/15 text-white font-semibold text-sm flex items-center justify-center gap-2 border border-white/15 transition-all cursor-pointer min-h-[46px]">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Bukti Lacak</span>
                    </button>
                    @if($loan->status === 'diajukan')
                    <a href="https://wa.me/6281270001920?text=Halo%20Admin%20Perpustakaan,%20saya%20sudah%20mengajukan%20peminjaman%20dengan%20kode%20{{ $loan->loan_code }}%20untuk%20buku%20{{ urlencode($loan->book->title) }}" target="_blank" rel="noopener noreferrer" class="flex-1 py-3 px-4 rounded-xl bg-emerald-600/30 hover:bg-emerald-600/40 text-emerald-300 font-semibold text-sm flex items-center justify-center gap-2 border border-emerald-500/40 transition-all min-h-[46px]">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Konfirmasi via WhatsApp</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @else
        <!-- Information Guide Card when no loan searched yet -->
        <div class="perpus-card-surface p-6 sm:p-8 mb-8 no-print">
            <h3 class="text-base sm:text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Panduan Pelacakan Peminjaman Buku</span>
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs sm:text-sm">
                <div class="p-4 rounded-xl perpus-card-subsurface">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-300 font-bold flex items-center justify-center mb-2.5">
                        1
                    </div>
                    <div class="font-bold text-white mb-1">Cari Kode / No. WA</div>
                    <p class="text-slate-300 leading-relaxed text-xs">
                        Ketik kode bukti peminjaman Anda atau gunakan nomor WhatsApp yang terdaftar pada form peminjaman.
                    </p>
                </div>
                <div class="p-4 rounded-xl perpus-card-subsurface">
                    <div class="w-7 h-7 rounded-lg bg-blue-500/20 text-blue-300 font-bold flex items-center justify-center mb-2.5">
                        2
                    </div>
                    <div class="font-bold text-white mb-1">Lihat Status &amp; Rak</div>
                    <p class="text-slate-300 leading-relaxed text-xs">
                        Sistem menampilkan posisi berkas, lokasi nomor rak perpustakaan, serta tenggat pengembalian buku.
                    </p>
                </div>
                <div class="p-4 rounded-xl perpus-card-subsurface">
                    <div class="w-7 h-7 rounded-lg bg-purple-500/20 text-purple-300 font-bold flex items-center justify-center mb-2.5">
                        3
                    </div>
                    <div class="font-bold text-white mb-1">Ambil di Sirkulasi</div>
                    <p class="text-slate-300 leading-relaxed text-xs">
                        Tunjukkan kode peminjaman Anda kepada pustakawan piket untuk serah terima buku fisik di loket.
                    </p>
                </div>
            </div>
            <div class="mt-4 p-3.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300 flex items-center gap-3">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 shrink-0" aria-hidden="true"></span>
                <span>Jam Layanan Sirkulasi Fisik: <strong>Senin – Jumat, Pukul 07.30 – 16.00 WIB</strong> di Gedung Perpustakaan Pusat.</span>
            </div>
        </div>
        @endif

        <div class="mt-8 text-center no-print">
            <a href="{{ route('perpus.index') }}" class="perpus-hero-track-btn">
                &larr; <span>Kembali ke Katalog Buku Utama</span>
            </a>
        </div>

    </div>
</div>
@endsection
