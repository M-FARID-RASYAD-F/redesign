@extends('layouts.app')

@section('title', 'Ajukan Peminjaman: ' . $book->title . ' - Perpustakaan Digital')

@section('konten_utama')
<div class="perpus-page-wrapper">
    <!-- Compact Container for Form Focus (max-width: 980px) -->
    <div class="perpus-container-form">
        
        <!-- Breadcrumbs & Navigation Bar (A.5: Proper overflow, padding, and z-index) -->
        <div class="perpus-top-nav-bar">
            <nav class="perpus-breadcrumb-nav" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="breadcrumb-link">Beranda</a>
                <span class="breadcrumb-sep" aria-hidden="true">/</span>
                <a href="{{ route('perpus.index') }}" class="breadcrumb-link">Perpustakaan</a>
                <span class="breadcrumb-sep" aria-hidden="true">/</span>
                @if($book->category)
                    <a href="{{ route('perpus.index', ['category' => $book->category_id]) }}" class="breadcrumb-link text-emerald-400">
                        {{ $book->category->name }}
                    </a>
                    <span class="breadcrumb-sep" aria-hidden="true">/</span>
                @endif
                <a href="{{ route('perpus.show', $book->id) }}" class="breadcrumb-link text-emerald-400 truncate max-w-[140px] sm:max-w-[200px]" title="{{ $book->title }}">
                    {{ $book->title }}
                </a>
                <span class="breadcrumb-sep" aria-hidden="true">/</span>
                <span class="breadcrumb-current" aria-current="page">Form Pinjam</span>
            </nav>

            <div class="perpus-top-actions">
                <a href="{{ route('perpus.show', $book->id) }}" class="perpus-btn-nav-outline">
                    <svg width="14" height="14" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Detail Buku</span>
                </a>
                <a href="{{ route('perpus.tracking') }}" class="perpus-btn-top-track text-xs !py-1.5 !px-3 !rounded-lg !min-h-[38px]">
                    <span>Lacak Status &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Master Container Card (Compact 2-Column Responsive Layout) -->
        <div class="perpus-card-surface perpus-detail-card perpus-card-compact mb-16 sm:mb-20">
            <div class="perpus-form-grid">
                
                <!-- Left Column: Compact Visual & Guidelines Panel (A.6: Sticky on desktop) -->
                <div class="perpus-left-col">
                    <div class="perpus-detail-cover-panel perpus-card-subsurface perpus-side-card">
                        
                        <!-- Top Header: Category & Single Rack Badge (B.2: Single rack badge) -->
                        <div class="perpus-cover-panel-header is-centered">
                            <span class="perpus-detail-cat-badge">
                                <svg width="12" height="12" class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span>{{ $book->category ? $book->category->name : 'Umum' }}</span>
                            </span>
                            @if($book->rack_location)
                            <span class="perpus-detail-rack-badge">
                                <svg width="12" height="12" class="w-3 h-3 shrink-0 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Rak: {{ $book->rack_location }}</span>
                            </span>
                            @endif
                        </div>

                        <!-- Book Cover Showcase (C.1: 2:3 aspect ratio, meaningful fallback) -->
                        <div class="perpus-cover-wrapper">
                            @if($book->cover)
                                <img src="{{ $book->cover_url }}"
                                     alt="Sampul buku {{ $book->title }}"
                                     class="perpus-cover-image"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="perpus-cover-placeholder-meaningful" style="display: none;">
                                    <div class="perpus-cover-spine"></div>
                                    <div class="perpus-cover-content">
                                        <span class="perpus-cover-tag">{{ $book->category ? $book->category->name : 'Buku' }}</span>
                                        <h3 class="perpus-cover-title">{{ $book->title }}</h3>
                                        <p class="perpus-cover-author">{{ $book->author }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="perpus-cover-placeholder-meaningful">
                                    <div class="perpus-cover-spine"></div>
                                    <div class="perpus-cover-content">
                                        <span class="perpus-cover-tag">{{ $book->category ? $book->category->name : 'Buku' }}</span>
                                        <h3 class="perpus-cover-title">{{ $book->title }}</h3>
                                        <p class="perpus-cover-author">{{ $book->author }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Title and Author Summary (A.6: Tight spacing) -->
                        <div class="perpus-side-summary">
                            <span class="perpus-side-label">Buku Pilihan</span>
                            <h2 class="perpus-side-title">{{ $book->title }}</h2>
                            <p class="perpus-side-author">{{ $book->author }}</p>
                        </div>

                        @php
                            $totalStock = max(1, (int)$book->stock);
                            $availStock = max(0, (int)$book->available);
                            $stockPercent = min(100, max(0, round(($availStock / $totalStock) * 100)));
                        @endphp

                        <!-- Live Stock Status Widget (C.2: Progress bar, 'X dari Y tersedia') -->
                        <div class="perpus-stock-card">
                            <div class="perpus-stock-row">
                                <span class="perpus-stock-lbl">Ketersediaan Fisik</span>
                                <span class="perpus-stock-num {{ $availStock > 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                    {{ $availStock }} dari {{ $totalStock }} tersedia
                                </span>
                            </div>
                            <div class="perpus-stock-progress-track" role="progressbar" aria-valuenow="{{ $availStock }}" aria-valuemin="0" aria-valuemax="{{ $totalStock }}" aria-label="Ketersediaan fisik eksemplar">
                                <div class="perpus-stock-progress-bar {{ $availStock > 0 ? 'is-available' : 'is-empty' }}" style="width: {{ $stockPercent }}%;"></div>
                            </div>
                            <div class="perpus-stock-subtext">
                                <span class="perpus-stock-dot {{ $availStock > 0 ? 'is-green animate-pulse' : 'is-red' }}"></span>
                                <span>{{ $availStock > 0 ? 'Siap dipinjam secara langsung' : 'Seluruh eksemplar sedang dipinjam' }}</span>
                            </div>
                        </div>

                        <!-- Mini Guidelines: TATA TERTIB PINJAM (A.1 & A.2: Dedicated card, >=16px gap, left aligned) -->
                        <div class="perpus-rules-card">
                            <div class="perpus-rules-header">
                                <svg width="16" height="16" class="w-4 h-4 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="perpus-rules-title">TATA TERTIB PINJAM</span>
                            </div>
                            <ul class="perpus-rules-list">
                                <li class="perpus-rule-item">
                                    <span class="perpus-rule-bullet" aria-hidden="true">&bull;</span>
                                    <span>Masa pinjam <strong>7 hari kalender</strong> sejak serah terima.</span>
                                </li>
                                <li class="perpus-rule-item">
                                    <span class="perpus-rule-bullet" aria-hidden="true">&bull;</span>
                                    <span>Tunjukkan kode atau nomor WhatsApp Anda kepada petugas.</span>
                                </li>
                                <li class="perpus-rule-item">
                                    <span class="perpus-rule-bullet" aria-hidden="true">&bull;</span>
                                    <span>Wajib merawat keutuhan dan kebersihan lembaran buku.</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Form Panel -->
                <div class="perpus-detail-content-panel">
                    <div>
                        <!-- Category & Status Tag Row (B.3: prominent status, secondary text) -->
                        <div class="perpus-header-status-bar">
                            <span class="perpus-badge-status {{ $book->available > 0 ? 'is-available' : 'is-empty' }}">
                                <span class="perpus-status-dot {{ $book->available > 0 ? 'animate-pulse' : '' }}"></span>
                                <span>{{ $book->available > 0 ? 'Siap Dipinjam' : 'Stok Habis' }}</span>
                            </span>
                            <span class="perpus-text-secondary-sub">Sirkulasi Mandiri Online</span>
                        </div>

                        <!-- Page / Form Title -->
                        <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight mb-2">
                            Ajukan Peminjaman Buku
                        </h1>

                        <!-- Compact Specifications Matrix (B.4: Sleek 2-col, max-height ~48px, no bulky icons) -->
                        <div class="perpus-compact-specs">
                            <div class="perpus-spec-row">
                                <div class="perpus-spec-cell">
                                    <span class="perpus-spec-k">Penulis</span>
                                    <span class="perpus-spec-v" title="{{ $book->author }}">{{ $book->author }}</span>
                                </div>
                                <div class="perpus-spec-cell">
                                    <span class="perpus-spec-k">Penerbit</span>
                                    <span class="perpus-spec-v" title="{{ $book->publisher ?: '-' }}">{{ $book->publisher ?: 'Koleksi Perpustakaan' }}</span>
                                </div>
                            </div>
                            <div class="perpus-spec-row">
                                <div class="perpus-spec-cell">
                                    <span class="perpus-spec-k">Nomor ISBN</span>
                                    <span class="perpus-spec-v font-mono text-cyan-300">{{ $book->isbn ?: 'Tidak Terdaftar' }}</span>
                                </div>
                                <div class="perpus-spec-cell">
                                    <span class="perpus-spec-k">Masa Pinjam</span>
                                    <span class="perpus-spec-v text-emerald-400 font-bold">7 Hari Kalender</span>
                                </div>
                            </div>
                        </div>

                        <!-- Out of Stock Warning -->
                        @if($book->available < 1)
                        <div class="mb-5 p-4 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-200" role="alert">
                            <div class="flex items-center gap-2 font-bold text-sm mb-1 text-rose-300">
                                <svg width="16" height="16" class="w-4 h-4 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Seluruh Eksemplar Sedang Dipinjam</span>
                            </div>
                            <p class="text-xs text-slate-300 mb-3 leading-relaxed">
                                Saat ini seluruh eksemplar fisik buku ini sedang dipinjam. Silakan periksa secara berkala atau cari buku lainnya di katalog perpustakaan.
                            </p>
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('perpus.index') }}" class="perpus-btn-detail px-3 py-1.5 text-xs font-semibold rounded-lg inline-flex items-center gap-1.5">
                                    <svg width="14" height="14" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                    <span>Katalog Buku</span>
                                </a>
                                <a href="{{ route('perpus.tracking') }}" class="perpus-btn-top-track !text-xs !py-1.5 !px-3 !rounded-lg">
                                    <span>Lacak Pinjaman &rarr;</span>
                                </a>
                            </div>
                        </div>
                        @endif

                        <!-- Validation Error Summary -->
                        @if($errors->any())
                        <div class="mb-5 p-3.5 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs sm:text-sm" role="alert" aria-live="assertive">
                            <div class="font-bold mb-1 flex items-center gap-1.5">
                                <svg width="16" height="16" class="w-4 h-4 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Periksa kembali data pengajuan:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 pl-1 text-xs">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Submission Form (C.8 copywriting, D.4 aria-required, D.5 aria-describedby) -->
                        <form action="{{ route('perpus.pinjam.store', $book->id) }}" method="POST" id="pinjamForm" novalidate>
                            @csrf

                            <div class="flex flex-col gap-6 sm:gap-7 mb-7">
                                <!-- Field 1: Nama Lengkap -->
                                <div class="perpus-form-group {{ $errors->has('full_name') ? 'has-error' : '' }}">
                                    <label for="full_name" class="block text-xs sm:text-sm font-bold text-slate-100 mb-2">
                                        Nama Lengkap Peminjam <span class="text-rose-400" aria-hidden="true">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3.5 text-slate-400 pointer-events-none" aria-hidden="true">
                                            <svg width="16" height="16" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </span>
                                        <input type="text"
                                               id="full_name"
                                               name="full_name"
                                               value="{{ old('full_name') }}"
                                               required
                                               aria-required="true"
                                               placeholder="Masukkan nama lengkap peminjam"
                                               aria-invalid="{{ $errors->has('full_name') ? 'true' : 'false' }}"
                                               aria-describedby="{{ $errors->has('full_name') ? 'full_name_error' : 'full_name_help' }}"
                                               class="perpus-form-input !pl-11 !py-3 !text-sm {{ $errors->has('full_name') ? 'has-error' : '' }}"
                                               {{ $book->available < 1 ? 'disabled' : '' }}>
                                    </div>
                                    @error('full_name')
                                        <p id="full_name_error" class="perpus-form-help has-error text-xs text-rose-400 mt-2 font-medium flex items-center gap-1">
                                            <svg width="14" height="14" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @else
                                        <p id="full_name_help" class="perpus-form-help text-xs text-slate-300 mt-2 leading-relaxed">
                                            Terbuka untuk santri, siswa, dewan guru, staf, maupun wali murid.
                                        </p>
                                    @enderror
                                </div>

                                <!-- Field 2: Nomor WhatsApp -->
                                <div class="perpus-form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label for="phone" class="block text-xs sm:text-sm font-bold text-slate-100 mb-2">
                                        Nomor WhatsApp / HP Aktif <span class="text-rose-400" aria-hidden="true">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3.5 text-slate-400 pointer-events-none" aria-hidden="true">
                                            <svg width="16" height="16" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        </span>
                                        <input type="tel"
                                               id="phone"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               required
                                               aria-required="true"
                                               placeholder="Masukkan nomor WhatsApp aktif"
                                               aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                               aria-describedby="{{ $errors->has('phone') ? 'phone_error' : 'phone_help' }}"
                                               class="perpus-form-input !pl-11 !py-3 !text-sm {{ $errors->has('phone') ? 'has-error' : '' }}"
                                               {{ $book->available < 1 ? 'disabled' : '' }}>
                                    </div>
                                    @error('phone')
                                        <p id="phone_error" class="perpus-form-help has-error text-xs text-rose-400 mt-2 font-medium flex items-center gap-1">
                                            <svg width="14" height="14" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @else
                                        <!-- C.8 Shortened copywriting -->
                                        <p id="phone_help" class="perpus-form-help text-xs text-emerald-400 mt-2 flex items-center gap-1.5 leading-relaxed font-medium">
                                            <svg width="14" height="14" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>Nomor ini dipakai untuk melacak pinjaman Anda.</span>
                                        </p>
                                    @enderror
                                </div>

                                <!-- Field 3: Kelas / Asrama / Domisili (C.3: 72px default height, resize vertical) -->
                                <div class="perpus-form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                    <label for="address" class="block text-xs sm:text-sm font-bold text-slate-100 mb-2">
                                        Kelas / Asrama / Alamat Domisili <span class="text-xs font-normal text-slate-400">(Opsional)</span>
                                    </label>
                                    <textarea id="address"
                                               name="address"
                                               rows="2"
                                               placeholder="Tuliskan kelas, asrama, atau alamat domisili"
                                               aria-describedby="{{ $errors->has('address') ? 'address_error' : 'address_help' }}"
                                               class="perpus-form-input perpus-textarea !py-3 !px-3.5 !text-sm {{ $errors->has('address') ? 'has-error' : '' }}"
                                               {{ $book->available < 1 ? 'disabled' : '' }}>{{ old('address') }}</textarea>
                                    @error('address')
                                        <p id="address_error" class="perpus-form-help has-error text-xs text-rose-400 mt-2 font-medium flex items-center gap-1">
                                            <svg width="14" height="14" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                            <span>{{ $message }}</span>
                                        </p>
                                    @else
                                        <p id="address_help" class="perpus-form-help text-xs text-slate-300 mt-2 leading-relaxed">
                                            Membantu petugas mengenali afiliasi Anda di lingkungan sekolah.
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Information Policy Callout & Checkbox (C.4: Single click area, green accent, unchecked initially, D.6 >=44px) -->
                            <div class="mb-5">
                                <label for="agree_terms" class="perpus-terms-block">
                                    <input type="checkbox"
                                           id="agree_terms"
                                           name="agree_terms"
                                           value="1"
                                           required
                                           aria-required="true"
                                           class="perpus-terms-input">
                                    <span class="perpus-terms-text">
                                        <strong class="text-white">Ketentuan Peminjaman:</strong> Saya bersedia merawat buku ini dengan baik, menjaga kebersihan halaman, dan berkomitmen mengembalikannya tepat waktu dalam tempo <strong class="text-emerald-300">7 hari kalender</strong> sejak serah terima fisik buku.
                                    </span>
                                </label>
                            </div>

                            <!-- Call To Action Bar (A.4, C.5, C.6, C.8, E.3, D.6) -->
                            <div class="perpus-form-actions">
                                @if($book->available > 0)
                                <button type="submit" id="submitBtn" class="perpus-btn-submit">
                                    <svg width="16" height="16" id="submitIcon" class="perpus-btn-icon w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span id="submitSpinner" class="perpus-btn-spinner" aria-hidden="true"></span>
                                    <span id="submitText">Ajukan Peminjaman</span>
                                </button>
                                @else
                                <button type="button" disabled class="perpus-btn-submit is-disabled" disabled>
                                    <svg width="16" height="16" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Seluruh Eksemplar Sedang Dipinjam</span>
                                </button>
                                @endif

                                <a href="{{ route('perpus.show', $book->id) }}" class="perpus-btn-cancel">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
/* ═══════════════════════════════════════════════════════════
   DESIGN TOKENS & UI REFINEMENT FOR PINJAM-CREATE
   ═══════════════════════════════════════════════════════════ */
:root {
    /* Palette Tokens: Dark Theme with Green-Cyan Accents */
    --perpus-accent-cyan: #06b6d4;
    --perpus-accent-green: #10b981;
    --perpus-accent-green-hover: #059669;
    --perpus-text-primary: #f8fafc;
    --perpus-text-secondary: #cbd5e1;
    --perpus-text-muted: #94a3b8;
    --perpus-error: #f43f5e;
    --perpus-focus-ring: #06b6d4;

    /* Spacing Scale (4 / 8 / 12 / 16 / 24 / 32 px) */
    --space-1: 4px;
    --space-2: 8px;
    --space-3: 12px;
    --space-4: 16px;
    --space-5: 24px;
    --space-6: 32px;

    /* Radius Scale */
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 24px;

    /* Font Sizes (min 12px for badges/labels, min 14px for inputs/content) */
    --font-xs: 12px;
    --font-sm: 13px;
    --font-base: 14px;
    --font-md: 16px;
    --font-lg: 18px;
}

/* ═══════════════════════════════════════════════════════════
   A.5: TOP NAVIGATION BAR & BREADCRUMBS
   ═══════════════════════════════════════════════════════════ */
.perpus-top-nav-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-3);
    margin-bottom: var(--space-5);
    padding-top: var(--space-2);
    position: relative;
    z-index: 10;
    overflow: visible;
}

.perpus-breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--font-xs);
    color: var(--perpus-text-secondary);
    font-weight: 500;
    min-width: 0;
    flex-wrap: wrap;
}

.breadcrumb-link {
    color: var(--perpus-text-secondary);
    text-decoration: none;
    transition: color 0.15s ease;
}

.breadcrumb-link:hover {
    color: #ffffff;
}

.breadcrumb-sep {
    color: #64748b;
    user-select: none;
}

.breadcrumb-current {
    color: var(--perpus-text-muted);
}

.perpus-top-actions {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    flex-shrink: 0;
}

.perpus-btn-nav-outline {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    font-size: var(--font-xs);
    font-weight: 600;
    color: var(--perpus-text-secondary);
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: var(--radius-sm);
    text-decoration: none;
    min-height: 38px;
    transition: all 0.2s ease;
}

.perpus-btn-nav-outline:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    border-color: rgba(255, 255, 255, 0.3);
}

/* ═══════════════════════════════════════════════════════════
   A.6 & E.1: RESPONSIVE 2-COL LAYOUT & STICKY LEFT COLUMN
   ═══════════════════════════════════════════════════════════ */
.perpus-form-grid {
    display: grid !important;
    grid-template-columns: 295px 1fr !important;
    gap: var(--space-5) !important;
    width: 100% !important;
    align-items: start !important;
}

@media (min-width: 768px) {
    .perpus-left-col {
        position: sticky;
        top: 24px;
        align-self: start;
    }
}

@media (max-width: 767px) {
    .perpus-form-grid {
        grid-template-columns: 1fr !important;
        gap: var(--space-5) !important;
    }
    .perpus-left-col {
        position: static !important;
    }
}

/* ═══════════════════════════════════════════════════════════
   C.1: BOOK COVER COMPONENT (2:3 RATIO & MEANINGFUL PLACEHOLDER)
   ═══════════════════════════════════════════════════════════ */
.perpus-side-card {
    padding: var(--space-4) !important;
    gap: var(--space-4) !important;
    display: flex !important;
    flex-direction: column !important;
}

.perpus-cover-wrapper {
    width: 100%;
    max-width: 195px;
    aspect-ratio: 2 / 3;
    border-radius: var(--radius-md);
    overflow: hidden;
    margin: 0 auto;
    background: linear-gradient(145deg, #0a233d 0%, #030e1a 100%);
    border: 1.5px solid rgba(0, 180, 216, 0.3);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    position: relative;
    display: flex;
}

.perpus-cover-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.perpus-cover-placeholder-meaningful {
    width: 100%;
    height: 100%;
    display: flex;
    background: linear-gradient(135deg, #0b294a 0%, #06192e 60%, #04101e 100%);
    position: relative;
    padding: 16px 14px 16px 20px;
    box-sizing: border-box;
    overflow: hidden;
}

.perpus-cover-spine {
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 10px;
    background: linear-gradient(90deg, rgba(0, 180, 216, 0.45) 0%, rgba(16, 185, 129, 0.2) 100%);
    border-right: 1px solid rgba(255, 255, 255, 0.1);
}

.perpus-cover-content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    width: 100%;
    text-align: left;
    z-index: 1;
}

.perpus-cover-tag {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--perpus-accent-cyan);
    background: rgba(0, 180, 216, 0.18);
    padding: 2px 8px;
    border-radius: 6px;
    align-self: flex-start;
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.perpus-cover-title {
    font-size: var(--font-base);
    font-weight: 800;
    color: #ffffff;
    line-height: 1.35;
    margin: 8px 0 4px 0;
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-wrap: balance;
}

.perpus-cover-author {
    font-size: var(--font-xs);
    color: var(--perpus-text-muted);
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Left Column Metadata Summary */
.perpus-side-summary {
    text-align: center;
    margin-top: var(--space-2);
    margin-bottom: var(--space-1);
    width: 100%;
}

.perpus-side-label {
    display: block;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--perpus-accent-green);
    font-weight: 700;
    margin-bottom: 2px;
}

.perpus-side-title {
    font-size: var(--font-base);
    font-weight: 700;
    color: #ffffff;
    line-height: 1.35;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.perpus-side-author {
    font-size: var(--font-xs);
    color: var(--perpus-text-secondary);
    margin-top: 3px;
    font-weight: 500;
}

/* ═══════════════════════════════════════════════════════════
   C.2: LIVE STOCK CARD WITH PROGRESS BAR
   ═══════════════════════════════════════════════════════════ */
.perpus-stock-card {
    background: rgba(0, 33, 71, 0.4);
    border: 1px solid rgba(0, 180, 216, 0.2);
    border-radius: var(--radius-md);
    padding: var(--space-3);
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
    width: 100%;
    box-sizing: border-box;
}

.perpus-stock-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-2);
}

.perpus-stock-lbl {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--perpus-text-muted);
    font-weight: 600;
}

.perpus-stock-num {
    font-size: var(--font-xs);
    font-weight: 700;
}

.perpus-stock-progress-track {
    width: 100%;
    height: 6px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 9999px;
    overflow: hidden;
}

.perpus-stock-progress-bar {
    height: 100%;
    border-radius: 9999px;
    transition: width 0.3s ease;
}

.perpus-stock-progress-bar.is-available {
    background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
}

.perpus-stock-progress-bar.is-empty {
    background: #f43f5e;
}

.perpus-stock-subtext {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--perpus-text-secondary);
}

.perpus-stock-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
}

.perpus-stock-dot.is-green {
    background: #34d399;
}

.perpus-stock-dot.is-red {
    background: #f43f5e;
}

/* ═══════════════════════════════════════════════════════════
   A.1 & A.2: TATA TERTIB PINJAM PANEL
   ═══════════════════════════════════════════════════════════ */
.perpus-rules-card {
    margin-top: var(--space-4);
    padding: var(--space-3) var(--space-4);
    background: rgba(0, 33, 71, 0.3);
    border: 1px solid rgba(0, 180, 216, 0.15);
    border-radius: var(--radius-md);
    text-align: left;
    width: 100%;
    box-sizing: border-box;
}

.perpus-rules-header {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    margin-bottom: var(--space-2);
}

.perpus-rules-title {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--perpus-accent-cyan);
}

.perpus-rules-list {
    margin: 0;
    padding: 0;
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.perpus-rule-item {
    display: flex;
    align-items: flex-start;
    gap: var(--space-2);
    font-size: 12px;
    color: var(--perpus-text-secondary);
    line-height: 1.5;
    text-align: left;
}

.perpus-rule-bullet {
    color: var(--perpus-accent-cyan);
    font-size: 14px;
    line-height: 1.2;
    flex-shrink: 0;
}

/* ═══════════════════════════════════════════════════════════
   B.3: HEADER STATUS BAR
   ═══════════════════════════════════════════════════════════ */
.perpus-header-status-bar {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    margin-bottom: var(--space-3);
    flex-wrap: wrap;
}

.perpus-badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: var(--font-xs);
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 9999px;
}

.perpus-badge-status.is-available {
    background: rgba(16, 185, 129, 0.18);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.35);
}

.perpus-badge-status.is-empty {
    background: rgba(244, 63, 94, 0.18);
    color: #fda4af;
    border: 1px solid rgba(244, 63, 94, 0.35);
}

.perpus-status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: currentColor;
    flex-shrink: 0;
}

.perpus-text-secondary-sub {
    font-size: var(--font-xs);
    color: var(--perpus-text-muted);
    font-weight: 500;
}

/* ═══════════════════════════════════════════════════════════
   B.4 & E.2: SLEEK 2-COL COMPACT SPECIFICATIONS
   ═══════════════════════════════════════════════════════════ */
.perpus-compact-specs {
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
    margin: var(--space-3) 0 var(--space-5) 0;
    padding: var(--space-3) var(--space-4);
    background: rgba(0, 33, 71, 0.35);
    border: 1px solid rgba(0, 180, 216, 0.18);
    border-radius: var(--radius-md);
}

.perpus-spec-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-4);
    align-items: center;
}

@media (max-width: 480px) {
    .perpus-spec-row {
        grid-template-columns: 1fr;
        gap: var(--space-2);
    }
}

.perpus-spec-cell {
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 40px;
    max-height: 48px;
}

.perpus-spec-k {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--perpus-text-muted);
    margin-bottom: 2px;
}

.perpus-spec-v {
    font-size: 13px;
    font-weight: 600;
    color: var(--perpus-text-primary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ═══════════════════════════════════════════════════════════
   C.3, C.7, D.1 - D.5: FORM CONTROLS & ERROR STATES
   ═══════════════════════════════════════════════════════════ */
.perpus-textarea {
    min-height: 72px !important;
    height: 72px !important;
    resize: vertical !important;
    line-height: 1.45 !important;
}

/* State Class: .has-error */
.has-error .perpus-form-input,
.perpus-form-input.has-error,
.perpus-form-input[aria-invalid="true"] {
    border-color: var(--perpus-error) !important;
    box-shadow: 0 0 0 1px var(--perpus-error) !important;
}

.has-error .perpus-form-input:focus,
.perpus-form-input.has-error:focus,
.perpus-form-input[aria-invalid="true"]:focus {
    box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.25) !important;
}

.perpus-form-help {
    font-size: var(--font-xs);
    line-height: 1.45;
}

.perpus-form-help.has-error {
    color: var(--perpus-error) !important;
}

/* ═══════════════════════════════════════════════════════════
   C.4 & D.6: TERMS CHECKBOX BLOCK
   ═══════════════════════════════════════════════════════════ */
.perpus-terms-block {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    padding: var(--space-3) var(--space-4);
    background: rgba(0, 33, 71, 0.35);
    border: 1px dashed rgba(0, 180, 216, 0.25);
    border-radius: var(--radius-md);
    cursor: pointer;
    user-select: none;
    min-height: 48px;
    box-sizing: border-box;
    transition: all 0.2s ease;
}

.perpus-terms-block:hover {
    background: rgba(0, 33, 71, 0.55);
    border-color: rgba(16, 185, 129, 0.4);
}

.perpus-terms-block:focus-within {
    outline: 2px solid var(--perpus-focus-ring);
    outline-offset: 2px;
}

.perpus-terms-input {
    width: 18px;
    height: 18px;
    margin-top: 2px;
    accent-color: var(--perpus-accent-green);
    cursor: pointer;
    flex-shrink: 0;
}

.perpus-terms-text {
    font-size: var(--font-xs);
    color: var(--perpus-text-secondary);
    line-height: 1.55;
}

/* ═══════════════════════════════════════════════════════════
   A.4, C.5, C.6, C.8, E.3: ACTION BUTTONS & STATES
   ═══════════════════════════════════════════════════════════ */
.perpus-form-actions {
    display: flex;
    align-items: center;
    gap: var(--space-3);
    margin-top: var(--space-4);
    padding-top: var(--space-4);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.perpus-btn-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    min-height: 48px;
    min-width: 48px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    font-size: var(--font-base);
    font-weight: 700;
    border: none;
    border-radius: var(--radius-md);
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.28);
    transition: all 0.2s ease;
    flex: 1;
    text-align: center;
}

.perpus-btn-submit:hover:not(:disabled) {
    background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    transform: translateY(-1px);
}

.perpus-btn-submit:active:not(:disabled) {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
}

.perpus-btn-submit:disabled,
.perpus-btn-submit.is-disabled {
    opacity: 0.55;
    box-shadow: none !important;
    cursor: not-allowed !important;
    transform: none !important;
}

/* Loading State: .is-loading */
.perpus-btn-submit.is-loading {
    opacity: 0.8;
    cursor: wait !important;
    pointer-events: none;
}

.perpus-btn-spinner {
    display: none;
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: perpus-spin 0.75s linear infinite;
    flex-shrink: 0;
}

.perpus-btn-submit.is-loading .perpus-btn-spinner {
    display: inline-block;
}

.perpus-btn-submit.is-loading .perpus-btn-icon {
    display: none;
}

@keyframes perpus-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.perpus-btn-cancel {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 48px;
    min-width: 48px;
    padding: 12px 24px;
    border-radius: var(--radius-md);
    background: transparent;
    border: 1.5px solid rgba(148, 163, 184, 0.35);
    color: var(--perpus-text-secondary);
    font-size: var(--font-base);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.perpus-btn-cancel:hover {
    border-color: #cbd5e1;
    background: rgba(255, 255, 255, 0.05);
    color: #ffffff;
}

@media (max-width: 640px) {
    .perpus-form-actions {
        flex-direction: column;
        width: 100%;
        gap: var(--space-3);
    }
    .perpus-btn-submit,
    .perpus-btn-cancel {
        width: 100% !important;
    }
}

/* ═══════════════════════════════════════════════════════════
   D.3: ACCESSIBILITY FOCUS VISIBLE ON ALL INTERACTIVE ELEMENTS
   ═══════════════════════════════════════════════════════════ */
a:focus-visible,
button:focus-visible,
input:focus-visible,
textarea:focus-visible,
[tabindex]:focus-visible {
    outline: 2px solid var(--perpus-focus-ring) !important;
    outline-offset: 2px !important;
}

/* ═══════════════════════════════════════════════════════════
   F.2: PREFERS REDUCED MOTION ACCESSIBILITY
   ═══════════════════════════════════════════════════════════ */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
    .animate-pulse,
    .animate-spin,
    .perpus-btn-spinner {
        animation: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pinjamForm');
    const phoneInput = document.getElementById('phone');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');

    // Auto sanitize phone input to numeric and + only
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    }

    // Anti double submit guard with standard .is-loading class
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            const fullName = document.getElementById('full_name')?.value.trim();
            const phone = phoneInput?.value.trim();
            const agreeTerms = document.getElementById('agree_terms')?.checked;

            if (!fullName || !phone || !agreeTerms) {
                return; // Let browser/native validation handle empty or unchecked fields
            }

            // Apply reusable loading state
            submitBtn.disabled = true;
            submitBtn.classList.add('is-loading');
            if (submitText) {
                submitText.innerText = 'Memproses Pengajuan...';
            }
        });
    }
});
</script>
@endsection
