@extends('layouts.app')

@section('title', $book->title . ' - Perpustakaan Digital')

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-medium">
        
        <!-- Breadcrumbs & Navigation Bar -->
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-300 font-medium" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <span class="text-slate-500">/</span>
                <a href="{{ route('perpus.index') }}" class="hover:text-white transition-colors">Perpustakaan</a>
                <span class="text-slate-500">/</span>
                @if($book->category)
                    <a href="{{ route('perpus.index', ['category' => $book->category_id]) }}" class="hover:text-emerald-300 transition-colors text-emerald-400">
                        {{ $book->category->name }}
                    </a>
                    <span class="text-slate-500">/</span>
                @endif
                <span class="text-slate-400 truncate max-w-[180px] sm:max-w-[280px]" aria-current="page">{{ $book->title }}</span>
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('perpus.index') }}" class="perpus-btn-detail inline-flex items-center gap-2 px-4 py-2.5 text-xs sm:text-sm rounded-xl">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali ke Katalog</span>
                </a>
                <a href="{{ route('perpus.tracking') }}" class="perpus-btn-top-track text-xs sm:text-sm">
                    <span>Lacak Status Pinjaman &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Book Detail Card (Responsive 2-col on desktop, stacked on mobile) -->
        <div class="perpus-card-surface perpus-detail-card mb-20 sm:mb-28">
            <div class="perpus-detail-grid">
                <!-- Visual / Illustration Panel (Left Column) -->
                <div class="perpus-detail-cover-panel perpus-card-subsurface">
                    <div>
                        <div class="perpus-cover-panel-header">
                            <span class="perpus-detail-cat-badge">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span>{{ $book->category ? $book->category->name : 'Umum' }}</span>
                            </span>
                            @if($book->rack_location)
                            <span class="perpus-detail-rack-badge">
                                <svg class="w-3.5 h-3.5 shrink-0 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Rak: {{ $book->rack_location }}</span>
                            </span>
                            @endif
                        </div>

                        <!-- Book Cover Showcase with Drop Shadow -->
                        <div class="perpus-detail-cover-box">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('images/book-placeholder.png') }}"
                                 alt="Sampul buku: {{ $book->title }}"
                                 width="200"
                                 height="280"
                                 onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';"
                                 class="perpus-book-cover-img">
                        </div>
                    </div>

                    <!-- Live Stock Status Widget -->
                    <div class="perpus-stock-widget">
                        <div class="perpus-stock-widget-label">Status Ketersediaan Fisik:</div>
                        <div class="perpus-stock-widget-status" role="status" aria-label="Status: {{ $book->available > 0 ? $book->available . ' eksemplar siap dipinjam' : 'stok habis sedang dipinjam' }}">
                            <div class="w-3 h-3 rounded-full {{ $book->available > 0 ? 'bg-emerald-400 animate-pulse' : 'bg-rose-500' }}" aria-hidden="true"></div>
                            <span class="font-bold text-sm sm:text-base {{ $book->available > 0 ? 'text-emerald-300' : 'text-rose-300' }}">
                                {{ $book->available > 0 ? $book->available . ' Eksemplar Tersedia' : 'Seluruh Buku Sedang Dipinjam' }}
                            </span>
                        </div>
                        <div class="perpus-stock-widget-total">Total Koleksi Perpustakaan: <strong>{{ $book->stock }} eksemplar</strong></div>
                    </div>
                </div>

                <!-- Info and Synopsis Panel (Right Column) -->
                <div class="perpus-detail-content-panel">
                    <div>
                        <!-- Category, Rack & Live Stock Tag Row -->
                        <div class="perpus-detail-tag-row">
                            <span class="perpus-detail-cat-badge">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span>{{ $book->category ? $book->category->name : 'Koleksi Umum' }}</span>
                            </span>

                            @if($book->rack_location)
                            <span class="perpus-detail-rack-badge">
                                <svg class="w-3.5 h-3.5 shrink-0 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Rak: {{ $book->rack_location }}</span>
                            </span>
                            @endif

                            <span class="perpus-detail-stock-badge {{ $book->available > 0 ? 'badge-in-stock' : 'badge-out-stock' }}">
                                <span class="badge-dot {{ $book->available > 0 ? 'animate-pulse' : '' }}"></span>
                                <span>{{ $book->available > 0 ? $book->available . ' Eksemplar Siap Pinjam' : 'Stok Habis Dipinjam' }}</span>
                            </span>
                        </div>

                        <!-- Book Title -->
                        <h1 class="perpus-detail-title">
                            {{ $book->title }}
                        </h1>

                        <!-- Editorial Byline: Penulis & Penerbit -->
                        <div class="perpus-detail-byline">
                            <div class="perpus-byline-item">
                                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <span>Penulis: <strong class="text-white">{{ $book->author }}</strong></span>
                            </div>
                            @if($book->publisher)
                            <span class="perpus-byline-separator">&bull;</span>
                            <div class="perpus-byline-item">
                                <svg class="w-4 h-4 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span>Penerbit: <strong class="text-slate-200">{{ $book->publisher }}</strong></span>
                            </div>
                            @endif
                        </div>

                        <!-- Specifications Matrix Grid -->
                        <div class="perpus-specs-matrix">
                            <!-- Card 1: Penulis -->
                            <div class="perpus-spec-card">
                                <div class="perpus-spec-icon stat-blue">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="perpus-spec-content">
                                    <span class="perpus-spec-label">Penulis Utama</span>
                                    <span class="perpus-spec-val" title="{{ $book->author }}">{{ $book->author }}</span>
                                </div>
                            </div>

                            <!-- Card 2: Penerbit -->
                            <div class="perpus-spec-card">
                                <div class="perpus-spec-icon stat-purple">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="perpus-spec-content">
                                    <span class="perpus-spec-label">Penerbit Buku</span>
                                    <span class="perpus-spec-val" title="{{ $book->publisher ?: '-' }}">{{ $book->publisher ?: 'Umum / Tidak Dicantumkan' }}</span>
                                </div>
                            </div>

                            <!-- Card 3: ISBN -->
                            <div class="perpus-spec-card">
                                <div class="perpus-spec-icon stat-cyan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                </div>
                                <div class="perpus-spec-content">
                                    <span class="perpus-spec-label">Nomor ISBN</span>
                                    <span class="perpus-spec-val font-mono text-cyan-300">{{ $book->isbn ?: 'Tidak Terdaftar' }}</span>
                                </div>
                            </div>

                            <!-- Card 4: Durasi Pinjam -->
                            <div class="perpus-spec-card">
                                <div class="perpus-spec-icon stat-green">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="perpus-spec-content">
                                    <span class="perpus-spec-label">Masa Peminjaman</span>
                                    <span class="perpus-spec-val text-emerald-400 font-bold">7 Hari Kalender</span>
                                </div>
                            </div>
                        </div>

                        <!-- Synopsis Section -->
                        <div class="perpus-synopsis-section">
                            <div class="perpus-synopsis-header">
                                <h3 class="perpus-synopsis-title">
                                    <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Sinopsis &amp; Deskripsi Buku</span>
                                </h3>
                                <span class="perpus-synopsis-tag">
                                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Referensi Resmi</span>
                                </span>
                            </div>

                            <div class="perpus-synopsis-card">
                                <div class="perpus-synopsis-prose">
                                    @if($book->synopsis)
                                        {!! nl2br(e($book->synopsis)) !!}
                                    @else
                                        Buku ini tersedia di perpustakaan sekolah untuk dibaca di tempat maupun dipinjam pulang oleh seluruh santri, siswa, guru, dan anggota perpustakaan yang terdaftar.
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Information Policy Callout -->
                        <div class="perpus-policy-callout">
                            <div class="perpus-policy-icon">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="perpus-policy-text">
                                <strong>Panduan Peminjaman Mandiri:</strong>
                                Pengajuan pinjam diproses secara langsung via sistem. Anda akan mendapatkan kode peminjaman untuk diverifikasi oleh petugas perpustakaan saat pengambilan buku fisik di sekolah.
                            </div>
                        </div>
                    </div>

                    <!-- Call To Action -->
                    <div class="perpus-detail-cta-bar">
                        @if($book->available > 0)
                        <a href="{{ route('perpus.pinjam.create', $book->id) }}" class="perpus-btn-borrow w-full sm:w-auto flex-1 text-center py-4 px-8 text-base font-bold min-h-[48px] inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2.5 inline-block shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>Ajukan Peminjaman Buku Ini</span>
                        </a>
                        @else
                        <div class="w-full sm:w-auto flex-1 py-4 px-8 perpus-btn-disabled text-center font-bold min-h-[48px] inline-flex items-center justify-center">
                            <svg class="w-4 h-4 mr-2.5 inline-block shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Seluruh Eksemplar Sedang Dipinjam</span>
                        </div>
                        @endif
                        <a href="{{ route('perpus.index') }}" class="perpus-btn-detail w-full sm:w-auto px-8 py-4 text-center text-sm font-semibold min-h-[48px] inline-flex items-center justify-center">
                            Cari Buku Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Books Section -->
        @if($related->count() > 0)
        <div class="perpus-related-section pt-8 sm:pt-12">
            <div class="flex flex-wrap items-center justify-between gap-6 mb-12">
                <h3 class="text-xl sm:text-2xl font-bold text-white flex items-center gap-3.5">
                    <svg class="w-6 h-6 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>Buku Terkait dalam Kategori yang Sama</span>
                </h3>
                <a href="{{ route('perpus.index', ['category' => $book->category_id]) }}" class="perpus-btn-see-all">
                    <span>Lihat Semua</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="perpus-related-grid">
                @foreach($related as $rel)
                <div class="perpus-book-card">
                    <!-- Thumbnail Cover Image -->
                    <div class="perpus-book-cover-wrap" style="height: 180px; padding: 10px;">
                        <img src="{{ $rel->cover ? asset('storage/' . $rel->cover) : asset('images/book-placeholder.png') }}"
                             alt="Sampul buku {{ $rel->title }}"
                             width="140"
                             height="180"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';"
                             class="perpus-book-cover-img"
                             style="max-height: 155px;">
                        
                        <span class="perpus-book-badge-stock {{ $rel->available > 0 ? 'stock-available' : 'stock-empty' }}" style="font-size: 0.65rem; padding: 2px 7px;">
                            {{ $rel->available > 0 ? $rel->available . ' Tersedia' : 'Habis' }}
                        </span>
                    </div>

                    <!-- Details Body -->
                    <div class="perpus-book-body p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-white text-sm mb-1 line-clamp-2" title="{{ $rel->title }}">
                                <a href="{{ route('perpus.show', $rel->id) }}" class="hover:text-emerald-400 transition-colors">{{ $rel->title }}</a>
                            </h4>
                            <div class="text-xs text-slate-400 mb-2 truncate">{{ $rel->author }}</div>
                        </div>

                        <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                            <a href="{{ route('perpus.show', $rel->id) }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 flex items-center gap-1">
                                <span>Lihat Detail</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
