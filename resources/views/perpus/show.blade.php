@extends('layouts.app')

@section('title', $book->title . ' - Perpustakaan Digital')

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-medium">
        
        <!-- Breadcrumbs & Quick Back Navigation -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
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
                <a href="{{ route('perpus.index') }}" class="perpus-btn-detail inline-flex items-center gap-2 px-3.5 py-2 text-xs sm:text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Katalog</span>
                </a>
                <a href="{{ route('perpus.tracking') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm text-emerald-400 hover:text-emerald-300 font-semibold transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Lacak Status &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Book Detail Card (Responsive 2-col on desktop, stacked on mobile) -->
        <div class="perpus-card-surface overflow-hidden mb-12">
            <div class="perpus-detail-grid">
                <!-- Visual Panel (Left Column) -->
                <div class="detail-visual-col p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden bg-slate-950/40">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                                {{ $book->category ? $book->category->name : 'Umum' }}
                            </span>
                            @if($book->rack_location)
                            <span class="text-xs font-mono text-cyan-300 font-semibold bg-cyan-500/10 px-2.5 py-1 rounded-lg border border-cyan-500/20">
                                Rak: {{ $book->rack_location }}
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
                    <div class="pt-5 border-t border-white/15">
                        <div class="text-xs text-slate-300 mb-1.5 font-medium">Status Ketersediaan Fisik:</div>
                        <div class="flex items-center gap-2" role="status" aria-label="Status: {{ $book->available > 0 ? $book->available . ' eksemplar siap dipinjam' : 'stok habis sedang dipinjam' }}">
                            <div class="w-3 h-3 rounded-full {{ $book->available > 0 ? 'bg-emerald-400 animate-pulse' : 'bg-rose-500' }}" aria-hidden="true"></div>
                            <span class="font-bold text-sm sm:text-base {{ $book->available > 0 ? 'text-emerald-300' : 'text-rose-300' }}">
                                {{ $book->available > 0 ? $book->available . ' Eksemplar Tersedia' : 'Seluruh Buku Sedang Dipinjam' }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-400 mt-1">Total Koleksi Perpustakaan: <strong>{{ $book->stock }} eksemplar</strong></div>
                    </div>
                </div>

                <!-- Info and Synopsis Panel (Right Column) -->
                <div class="p-6 sm:p-10 flex flex-col justify-between">
                    <div>
                        <!-- Category Subtitle -->
                        <div class="text-xs uppercase tracking-wider text-emerald-400 font-bold mb-2">
                            {{ $book->category ? $book->category->name : 'Koleksi Umum' }}
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-4 leading-tight">
                            {{ $book->title }}
                        </h1>

                        <!-- Metadata Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-2 gap-3 sm:gap-4 py-4 border-y border-white/10 text-sm mb-6">
                            <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-slate-400 block text-xs mb-1">Penulis / Pengarang</span>
                                <span class="font-semibold text-white text-sm sm:text-base line-clamp-1" title="{{ $book->author }}">{{ $book->author }}</span>
                            </div>
                            <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-slate-400 block text-xs mb-1">Penerbit</span>
                                <span class="font-semibold text-white text-sm sm:text-base line-clamp-1" title="{{ $book->publisher ?: '-' }}">{{ $book->publisher ?: '-' }}</span>
                            </div>
                            <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-slate-400 block text-xs mb-1">Nomor ISBN</span>
                                <span class="font-mono text-cyan-300 text-xs sm:text-sm font-semibold truncate block">{{ $book->isbn ?: 'Tidak Terdaftar' }}</span>
                            </div>
                            <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                                <span class="text-slate-400 block text-xs mb-1">Durasi Pinjam Standar</span>
                                <span class="font-bold text-emerald-400 text-sm sm:text-base">7 Hari Kalender</span>
                            </div>
                        </div>

                        <!-- Synopsis with Expandable Toggle -->
                        <div>
                            <h3 class="font-bold text-white text-sm uppercase tracking-wider mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Sinopsis &amp; Deskripsi Buku</span>
                            </h3>
                            <div id="synopsisBox" class="text-slate-300 text-sm sm:text-base leading-relaxed whitespace-pre-line bg-white/5 p-4 rounded-xl border border-white/5 transition-all">
                                {{ $book->synopsis ?: 'Buku ini tersedia untuk dibaca di tempat maupun dipinjam pulang oleh seluruh santri, siswa, guru, dan masyarakat umum yang terdaftar.' }}
                            </div>
                        </div>
                    </div>

                    <!-- Call To Action -->
                    <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center gap-4">
                        @if($book->available > 0)
                        <a href="{{ route('perpus.pinjam.create', $book->id) }}" class="perpus-btn-borrow w-full sm:w-auto flex-1 text-center py-4 px-6 text-base font-bold min-h-[48px] justify-center">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>Ajukan Peminjaman Buku Ini</span>
                        </a>
                        @else
                        <div class="w-full sm:w-auto flex-1 py-3.5 px-6 perpus-btn-disabled text-center font-bold min-h-[48px] flex items-center justify-center">
                            Seluruh Eksemplar Sedang Dipinjam
                        </div>
                        @endif
                        <a href="{{ route('perpus.index') }}" class="perpus-btn-detail w-full sm:w-auto px-6 py-4 text-center text-sm font-semibold min-h-[48px] flex items-center justify-center">
                            Cari Buku Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Books Section -->
        @if($related->count() > 0)
        <div>
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>Buku Terkait dalam Kategori yang Sama</span>
                </h3>
                <a href="{{ route('perpus.index', ['category' => $book->category_id]) }}" class="text-sm font-semibold text-emerald-400 hover:text-emerald-300">
                    Lihat Semua &rarr;
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
