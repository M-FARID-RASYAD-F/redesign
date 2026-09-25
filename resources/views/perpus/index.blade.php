@extends('layouts.app')

@section('title', 'Perpustakaan Digital - PKBM Tahfizh At-Tamam')

@section('konten_utama')
@php
    $categoryId = $categoryId ?? null;
    $search = $search ?? null;
@endphp
<div class="perpus-page-wrapper">
    <div class="perpus-container">
        
        <!-- Header / Hero Section (2-Column Balanced Layout with Live Stats) -->
        <div class="perpus-hero-banner">
            <div class="perpus-hero-grid relative z-10">
                <!-- Left Column: Branding, Title, Intro & Search -->
                <div class="perpus-hero-content">
                    <div class="perpus-hero-badge">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Pusat Literasi &amp; Referensi Sekolah</span>
                    </div>

                    <h1 class="perpus-hero-title">
                        Perpustakaan Digital <br class="hidden sm:inline"> At-Tamam Edu
                    </h1>

                    <p class="perpus-hero-desc">
                        Akses ribuan referensi keislaman, sains, teknologi modern, dan literatur pilihan. Ajukan peminjaman buku secara mandiri dengan cepat, mudah, dan transparan.
                    </p>

                    <!-- Search Bar Form with Real-Time Clear -->
                    <form action="{{ route('perpus.index') }}" method="GET" class="perpus-search-form" role="search">
                        <div class="perpus-search-input-wrap">
                            <svg class="w-5 h-5 absolute left-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text"
                                   id="perpusSearchInput"
                                   name="search"
                                   value="{{ $search }}"
                                   placeholder="Cari judul buku, nama penulis, atau ISBN..."
                                   class="perpus-search-input"
                                   autocomplete="off">
                            <a href="{{ route('perpus.index', array_filter(['category' => $categoryId])) }}" 
                               id="perpusSearchClear" 
                               class="perpus-search-clear {{ $search ? '' : '!hidden' }}" 
                               title="Hapus pencarian">&times;</a>
                        </div>
                        @if($categoryId)
                            <input type="hidden" name="category" value="{{ $categoryId }}">
                        @endif
                        <button type="submit" class="perpus-search-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <span>Cari Buku</span>
                        </button>
                    </form>
                </div>

                <!-- Right Column: Glassmorphism Stats Showcase & Fast Tracking CTA -->
                <div class="perpus-hero-stats-panel">
                    <div class="perpus-hero-stats-grid">
                        <!-- Stat 1: Total Judul -->
                        <div class="perpus-stat-chip">
                            <div class="perpus-stat-icon-wrap stat-blue">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div>
                                <div class="perpus-stat-number">{{ $stats['total_books'] ?? $books->total() }}</div>
                                <div class="perpus-stat-label">Judul Buku</div>
                            </div>
                        </div>

                        <!-- Stat 2: Eksemplar Tersedia -->
                        <div class="perpus-stat-chip">
                            <div class="perpus-stat-icon-wrap stat-green">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <div class="perpus-stat-number text-emerald-400">{{ $stats['total_available'] ?? $books->sum('available') }}</div>
                                <div class="perpus-stat-label">Siap Dipinjam</div>
                            </div>
                        </div>

                        <!-- Stat 3: Kategori Koleksi -->
                        <div class="perpus-stat-chip">
                            <div class="perpus-stat-icon-wrap stat-purple">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                            <div>
                                <div class="perpus-stat-number">{{ $stats['total_categories'] ?? $categories->count() }}</div>
                                <div class="perpus-stat-label">Kategori Ilmu</div>
                            </div>
                        </div>

                        <!-- Stat 4: Durasi Pinjam -->
                        <div class="perpus-stat-chip">
                            <div class="perpus-stat-icon-wrap stat-amber">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <div class="perpus-stat-number text-amber-400">7 Hari</div>
                                <div class="perpus-stat-label">Masa Pinjam</div>
                            </div>
                        </div>
                    </div>

                    <!-- Fast Tracking Action Button -->
                    <a href="{{ route('perpus.tracking') }}" class="perpus-hero-track-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span>Lacak Status Peminjaman Saya &rarr;</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Filter Kategori Row (Horizontal Touch Scroll on Mobile, Pills on Desktop) -->
        <div class="relative w-full">
            <div class="perpus-pills-row" role="navigation" aria-label="Filter Kategori Buku">
                <a href="{{ route('perpus.index', array_filter(['search' => $search])) }}" 
                   class="perpus-pill-item {{ !$categoryId ? 'perpus-pill-active' : 'perpus-pill-inactive' }}">
                    <span>Semua Kategori</span>
                    <span class="perpus-pill-count">{{ $stats['total_books'] ?? $books->total() }}</span>
                </a>
                @foreach($categories as $category)
                <a href="{{ route('perpus.index', array_filter(['category' => $category->id, 'search' => $search])) }}" 
                   class="perpus-pill-item {{ $categoryId == $category->id ? 'perpus-pill-active' : 'perpus-pill-inactive' }}">
                    <span>{{ $category->name }}</span>
                    <span class="perpus-pill-count">{{ $category->books_count ?? 0 }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Active Filter Indicator -->
        @if($search || $categoryId)
        <div class="perpus-filter-indicator">
            <div class="flex items-center gap-2 flex-wrap">
                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                <span>
                    Menampilkan hasil untuk:
                    @if($search) kata kunci <strong>"{{ $search }}"</strong> @endif
                    @if($search && $categoryId) &bull; @endif
                    @if($categoryId)
                        kategori <strong>{{ $categories->firstWhere('id', $categoryId)?->name }}</strong>
                    @endif
                </span>
            </div>
            <a href="{{ route('perpus.index') }}" class="perpus-filter-reset">✕ Hapus Semua Filter</a>
        </div>
        @endif

        <!-- Book Cards Grid -->
        <div class="perpus-books-grid">
            @forelse($books as $book)
            <div class="perpus-book-card">
                <!-- Cover Buku dengan 3D Shadow dan Fallback Placeholder -->
                <div class="perpus-book-cover-wrap">
                    <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('images/book-placeholder.png') }}"
                         alt="Sampul buku {{ $book->title }}"
                         width="160"
                         height="220"
                         loading="lazy"
                         onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';"
                         class="perpus-book-cover-img">
                    
                    <!-- Kategori Badge -->
                    <span class="perpus-book-badge-cat">
                        {{ $book->category ? $book->category->name : 'Umum' }}
                    </span>

                    <!-- Stok Tersedia Badge -->
                    <span class="perpus-book-badge-stock {{ $book->available > 0 ? 'stock-available' : 'stock-empty' }}"
                          aria-label="Status ketersediaan: {{ $book->available > 0 ? $book->available . ' eksemplar tersedia' : 'stok habis' }}">
                        @if($book->available > 0)
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-white animate-pulse mr-1" aria-hidden="true"></span>{{ $book->available }} Tersedia
                        @else
                            Habis
                        @endif
                    </span>
                </div>

                <!-- Book Details Body -->
                <div class="perpus-book-body">
                    <div>
                        <h2 class="perpus-book-title" title="{{ $book->title }}">
                            <a href="{{ route('perpus.show', $book->id) }}">{{ $book->title }}</a>
                        </h2>

                        <div class="perpus-book-meta">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="truncate">{{ $book->author }}</span>
                        </div>

                        @if($book->rack_location)
                        <div class="perpus-book-rack">
                            <svg class="w-3 h-3 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Rak: {{ $book->rack_location }}</span>
                        </div>
                        @endif

                        <p class="perpus-book-synopsis">
                            {{ $book->synopsis ?: 'Buku ini tersedia di perpustakaan sekolah untuk dipinjam dan dibaca.' }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="perpus-card-actions">
                        <a href="{{ route('perpus.show', $book->id) }}" class="perpus-btn-detail flex-1">
                            Detail Buku
                        </a>
                        @if($book->available > 0)
                        <a href="{{ route('perpus.pinjam.create', $book->id) }}" class="perpus-btn-borrow flex-1">
                            Pinjam Buku
                        </a>
                        @else
                        <button disabled class="perpus-btn-disabled flex-1" title="Stok buku sedang dipinjam seluruhnya" aria-disabled="true">
                            Stok Habis
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full perpus-empty-card">
                <div class="w-16 h-16 rounded-full bg-white/10 text-emerald-400 flex items-center justify-center mx-auto mb-4 border border-white/10">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Koleksi Buku Tidak Ditemukan</h3>
                <p class="text-slate-300 text-sm max-w-md mx-auto mb-6 leading-relaxed">
                    Buku dengan kata kunci atau kategori yang Anda cari belum tersedia. Silakan coba kata kunci lain atau tampilkan seluruh koleksi.
                </p>
                <a href="{{ route('perpus.index') }}" class="perpus-btn-borrow px-6 py-3">
                    Lihat Semua Koleksi Buku
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="perpus-pagination-card mb-12">
            {{ $books->links('perpus.partials.pagination') }}
        </div>
        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('perpusSearchInput');
    const searchClear = document.getElementById('perpusSearchClear');
    if (searchInput && searchClear) {
        searchInput.addEventListener('input', function() {
            if (this.value.trim().length > 0) {
                searchClear.classList.remove('!hidden');
            } else {
                searchClear.classList.add('!hidden');
            }
        });
    }
});
</script>
@endsection
