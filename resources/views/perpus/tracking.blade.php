@extends('layouts.app')

@section('title', 'Lacak Status Peminjaman Buku - Perpustakaan Digital')

@section('konten_utama')
<div class="ppdb-page-container">
    <div style="max-width: 800px; margin: 0 auto;">

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

            <a href="{{ route('perpus.index') }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 6px 14px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Katalog Buku</span>
            </a>
        </div>

        <!-- Header Halaman Tracking -->
        <div style="text-align: center; margin-bottom: 35px;" class="no-print">
            <span class="ppdb-section-tag">Tracking Sistem Perpustakaan</span>
            <h1 class="ppdb-section-title" style="font-size: clamp(1.8rem, 3vw, 2.4rem); margin: 6px 0 0;">Lacak Status Peminjaman</h1>
            <p class="ppdb-section-desc" style="margin-top: 6px;">Masukkan Kode Peminjaman atau Nomor WhatsApp resmi untuk memantau status sirkulasi dan batas pengembalian buku.</p>
        </div>

        <!-- Form Pencarian Kode Peminjaman / No. WA -->
        <div class="ppdb-tracking-box no-print">
            <form action="{{ route('perpus.check') }}" method="POST">
                @csrf
                <label for="loan_code" class="ppdb-form-label" style="margin-bottom: 8px;">
                    Kode Peminjaman atau Nomor WhatsApp:
                </label>
                <div class="ppdb-tracking-form-row" style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <input type="text" id="loan_code" name="loan_code" value="{{ old('loan_code', isset($loan) ? $loan->loan_code : ($search ?? request('loan_code'))) }}" required placeholder="Contoh: PINJAM-2026-0001 atau 081234567890" class="ppdb-form-input" style="flex: 1; min-width: 240px; font-family: monospace; font-weight: 700; text-transform: uppercase;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-weight: 700; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <span>Cari Data</span>
                    </button>
                </div>
                <div style="margin-top: 12px; display: flex; flex-wrap: wrap; align-items: center; gap: 8px; font-size: 0.8rem; color: #94a3b8;">
                    <span>Format yang didukung:</span>
                    <span style="background: rgba(255,255,255,0.08); padding: 2px 8px; border-radius: 6px; font-family: monospace; color: #34d399; font-weight: 600;">PINJAM-YYYY-XXXX</span>
                    <span>atau</span>
                    <span style="background: rgba(255,255,255,0.08); padding: 2px 8px; border-radius: 6px; font-family: monospace; color: #38bdf8; font-weight: 600;">08xxxxxxxxxx</span>
                </div>
            </form>
        </div>

        <!-- Alert Jika Nomor/Kode Tidak Ditemukan -->
        @if(session('error') || $errors->has('loan_code'))
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 16px; padding: 20px; color: #fca5a5; margin-bottom: 30px; display: flex; align-items: flex-start; gap: 12px;" class="no-print">
            <span style="display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: rgba(239, 68, 68, 0.2); color: #f87171; flex-shrink: 0;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </span>
            <div>
                <strong style="display: block; font-size: 0.95rem; margin-bottom: 2px; color: #ffffff;">Data Tidak Ditemukan!</strong>
                <span style="font-size: 0.9rem;">{{ session('error') ?? $errors->first('loan_code') }}</span>
            </div>
        </div>
        @endif

        @if(session('info'))
        <div style="background: rgba(56, 189, 248, 0.12); border: 1px solid rgba(56, 189, 248, 0.4); border-radius: 16px; padding: 20px; color: #bae6fd; margin-bottom: 30px; display: flex; align-items: flex-start; gap: 12px;" class="no-print">
            <span style="display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: rgba(56, 189, 248, 0.2); color: #38bdf8; flex-shrink: 0;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
            </span>
            <div>
                <strong style="display: block; font-size: 0.95rem; margin-bottom: 2px; color: #ffffff;">Petunjuk</strong>
                <span style="font-size: 0.9rem;">{{ session('info') }}</span>
            </div>
        </div>
        @endif

        <!-- TAMPILAN HASIL JIKA LOAN DITEMUKAN -->
        @if(isset($loan))
        <div class="ppdb-result-card" style="margin-bottom: 30px;">
            
            <!-- Header Status Box -->
            <div class="ppdb-result-header">
                <div>
                    <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">KODE PEMINJAMAN</span>
                    <h2 class="ppdb-reg-number" style="font-size: 1.5rem; margin: 2px 0 0; text-align: left; font-family: monospace; color: #34d399;">{{ $loan->loan_code }}</h2>
                </div>

                <!-- Status Badge -->
                <div>
                    @if($loan->status == 'diajukan')
                        <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>Status: Menunggu Konfirmasi Pustakawan</span>
                        </span>
                    @elseif($loan->status == 'dipinjam')
                        <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>Status: Buku Sedang Dipinjam</span>
                        </span>
                    @elseif($loan->status == 'dikembalikan')
                        <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span>Status: Diterima Kembali (Selesai)</span>
                        </span>
                    @elseif($loan->status == 'terlambat')
                        <span style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <span>Status: Terlambat Pengembalian</span>
                        </span>
                    @else
                        <span style="background: rgba(148, 163, 184, 0.15); color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            <span>Status: {{ $loan->status_label }}</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Visual Step Progress Bar (PPDB Timeline bar style) -->
            <div class="ppdb-timeline-bar no-print">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; text-align: center;">
                    
                    <!-- Step 1: Diajukan -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);">✓</div>
                        <span style="font-size: 0.85rem; font-weight: 700; color: #ffffff;">1. Diajukan</span>
                        <span style="font-size: 0.75rem; color: #94a3b8;">{{ $loan->created_at->format('d M Y') }}</span>
                    </div>

                    <!-- Step 2: Verifikasi / Pengambilan -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        @if($loan->status == 'diajukan')
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #f59e0b; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(245, 158, 11, 0.4);">2</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #fbbf24;">2. Verifikasi Fisik</span>
                            <span style="font-size: 0.75rem; color: #fbbf24;">Ambil buku di loket</span>
                        @elseif($loan->status == 'terlambat')
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #ef4444; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(239, 68, 68, 0.4);">!</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #f87171;">2. Terlambat</span>
                            <span style="font-size: 0.75rem; color: #f87171;">Lewat batas waktu</span>
                        @else
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);">✓</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #ffffff;">2. Dipinjam</span>
                            <span style="font-size: 0.75rem; color: #34d399;">{{ $loan->borrowed_at ? $loan->borrowed_at->format('d M Y') : 'Buku diambil' }}</span>
                        @endif
                    </div>

                    <!-- Step 3: Pengembalian -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        @if($loan->status == 'dikembalikan')
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);">✓</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #34d399;">3. Dikembalikan</span>
                            <span style="font-size: 0.75rem; color: #34d399;">Selesai ({{ $loan->returned_at ? $loan->returned_at->format('d M Y') : 'Tepat Waktu' }})</span>
                        @else
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.1); color: #94a3b8; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px;">3</div>
                            <span style="font-size: 0.85rem; font-weight: 600; color: #94a3b8;">3. Pengembalian</span>
                            <span style="font-size: 0.75rem; color: #64748b;">Batas: {{ $loan->due_at ? $loan->due_at->format('d M Y') : '7 Hari' }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Catatan Petugas Perpustakaan -->
            @if($loan->notes)
            <div style="padding: 20px 30px; background: rgba(30, 41, 59, 0.4); border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <h4 style="font-size: 0.95rem; font-weight: 800; color: #ffffff; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    <span>Catatan dari Petugas Perpustakaan:</span>
                </h4>
                <p style="font-size: 0.9rem; color: #cbd5e1; line-height: 1.6; margin: 0;">
                    {{ $loan->notes }}
                </p>
            </div>
            @endif

            <!-- Detail Body -->
            <div class="ppdb-result-body" style="padding: 30px;">
                <!-- Book Showcase inside body -->
                <div style="display: flex; gap: 18px; align-items: center; background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 18px; margin-bottom: 24px;">
                    <div style="width: 80px; height: 110px; border-radius: 10px; overflow: hidden; flex-shrink: 0; background: #0f172a; box-shadow: 0 4px 12px rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center;">
                        <img src="{{ $loan->book->cover ? asset('storage/' . $loan->book->cover) : asset('images/book-placeholder.png') }}"
                             alt="Sampul {{ $loan->book->title }}"
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';">
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 6px;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: #34d399; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); padding: 2px 8px; border-radius: 9999px;">
                                {{ $loan->book->category->name ?? 'Kategori Umum' }}
                            </span>
                            @if($loan->book->rack_location)
                            <span style="font-size: 0.75rem; font-weight: 700; color: #38bdf8; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); padding: 2px 8px; border-radius: 9999px;">
                                Rak: {{ $loan->book->rack_location }}
                            </span>
                            @endif
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 800; color: #ffffff; margin: 0 0 4px; line-height: 1.3;">
                            {{ $loan->book->title }}
                        </h3>
                        <div style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 8px;">
                            Penulis: <span style="color: #cbd5e1; font-weight: 600;">{{ $loan->book->author }}</span>
                            @if($loan->book->isbn)
                            <span style="margin: 0 6px;">•</span>
                            <span>ISBN: <code style="color: #38bdf8; font-family: monospace;">{{ $loan->book->isbn }}</code></span>
                            @endif
                        </div>
                        <a href="{{ route('perpus.show', $loan->book->id) }}" class="no-print" style="font-size: 0.8rem; font-weight: 700; color: #34d399; display: inline-flex; align-items: center; gap: 4px; text-decoration: none;">
                            <span>Lihat Halaman Detail Buku &rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Ringkasan Data Peminjaman -->
                <h4 style="font-size: 1rem; font-weight: 800; color: #ffffff; margin-bottom: 16px;">Ringkasan Data Peminjaman</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; font-size: 0.9rem;">
                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Nama Peminjam:</span>
                        <strong style="color: #ffffff;">{{ $loan->member->full_name }}</strong>
                    </div>
                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Nomor Anggota:</span>
                        <strong style="color: #34d399; font-family: monospace;">{{ $loan->member->member_code }}</strong>
                    </div>
                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Nomor WhatsApp:</span>
                        <strong style="color: #ffffff; font-family: monospace;">{{ substr($loan->member->phone, 0, 4) }}****{{ substr($loan->member->phone, -4) }}</strong>
                    </div>
                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Waktu Pengajuan:</span>
                        <strong style="color: #ffffff;">{{ $loan->created_at ? $loan->created_at->translatedFormat('d F Y - H:i') : '-' }} WIB</strong>
                    </div>
                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Tanggal Pengambilan Fisik:</span>
                        <strong style="color: #ffffff;">{{ $loan->borrowed_at ? $loan->borrowed_at->translatedFormat('d F Y') : 'Menunggu Pengambilan di Loket' }}</strong>
                    </div>
                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Batas Waktu Pengembalian:</span>
                        <strong style="color: {{ $loan->status === 'terlambat' ? '#f87171' : '#34d399' }};">
                            {{ $loan->due_at ? $loan->due_at->translatedFormat('d F Y') : '7 Hari Kalender' }}
                        </strong>
                    </div>
                    @if($loan->returned_at)
                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Tanggal Selesai Dikembalikan:</span>
                        <strong style="color: #34d399;">{{ $loan->returned_at->translatedFormat('d F Y - H:i') }} WIB</strong>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Footer Card Action -->
            <div class="no-print" style="background: rgba(30, 41, 59, 0.4); padding: 18px 30px; border-top: 1px solid rgba(255, 255, 255, 0.08); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="button" onclick="window.print()" class="btn btn-outline" style="font-size: 0.85rem; padding: 8px 16px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                        <span>Cetak Bukti Lacak</span>
                    </button>
                    @if($loan->status === 'diajukan')
                    <a href="https://wa.me/6281270001920?text=Halo%20Admin%20Perpustakaan,%20saya%20sudah%20mengajukan%20peminjaman%20dengan%20kode%20{{ $loan->loan_code }}%20untuk%20buku%20{{ urlencode($loan->book->title) }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="font-size: 0.85rem; padding: 8px 16px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px; background: #059669; border-color: #059669;">
                        <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Konfirmasi via WhatsApp</span>
                    </a>
                    @endif
                </div>
                <span style="font-size: 0.8rem; color: #94a3b8;">
                    Pembaruan status terakhir: {{ $loan->updated_at ? $loan->updated_at->diffForHumans() : '-' }}
                </span>
            </div>
        </div>
        @else
        <!-- Panduan Pelacakan Peminjaman (PPDB result card style) -->
        <div class="ppdb-result-card no-print" style="margin-bottom: 30px;">
            <div class="ppdb-result-header">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(16, 185, 129, 0.15); color: #34d399; display: flex; align-items: center; justify-content: center;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: #ffffff; margin: 0;">Panduan Pelacakan Peminjaman Buku</h3>
                </div>
                <span style="font-size: 0.8rem; color: #94a3b8;">Layanan Mandiri</span>
            </div>

            <div class="ppdb-result-body" style="padding: 24px 30px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                    <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px; padding: 18px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(16, 185, 129, 0.2); color: #34d399; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">1</div>
                        <h5 style="font-size: 0.9rem; font-weight: 700; color: #ffffff; margin: 0 0 6px;">Cari Kode / No. WA</h5>
                        <p style="font-size: 0.8rem; color: #94a3b8; line-height: 1.5; margin: 0;">
                            Ketik kode bukti peminjaman Anda atau gunakan nomor WhatsApp yang terdaftar pada form peminjaman.
                        </p>
                    </div>

                    <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px; padding: 18px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(56, 189, 248, 0.2); color: #38bdf8; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">2</div>
                        <h5 style="font-size: 0.9rem; font-weight: 700; color: #ffffff; margin: 0 0 6px;">Lihat Status &amp; Rak</h5>
                        <p style="font-size: 0.8rem; color: #94a3b8; line-height: 1.5; margin: 0;">
                            Sistem menampilkan posisi berkas, lokasi nomor rak perpustakaan, serta tenggat pengembalian buku.
                        </p>
                    </div>

                    <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px; padding: 18px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(192, 132, 252, 0.2); color: #c084fc; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">3</div>
                        <h5 style="font-size: 0.9rem; font-weight: 700; color: #ffffff; margin: 0 0 6px;">Ambil di Loket Sirkulasi</h5>
                        <p style="font-size: 0.8rem; color: #94a3b8; line-height: 1.5; margin: 0;">
                            Tunjukkan kode peminjaman Anda kepada pustakawan piket untuk serah terima buku fisik di loket.
                        </p>
                    </div>
                </div>

                <div style="margin-top: 18px; padding-top: 14px; border-top: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.8rem; color: #94a3b8; display: flex; align-items: center; gap: 8px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #34d399; display: inline-block;"></span>
                    <span>Jam Layanan Sirkulasi Fisik: <strong style="color: #ffffff;">Senin – Jumat, Pukul 07.30 – 16.00 WIB</strong> di Loket Perpustakaan Pusat.</span>
                </div>
            </div>
        </div>
        @endif

        <div style="text-align: center; margin-top: 30px;" class="no-print">
            <a href="{{ route('perpus.index') }}" class="btn btn-outline" style="font-size: 0.9rem; padding: 10px 24px; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Katalog Buku Utama</span>
            </a>
        </div>

    </div>
</div>
@endsection
