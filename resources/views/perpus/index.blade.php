@extends('layouts.app')

@section('title', 'Perpustakaan Digital - PKBM Tahfizh At-Tamam')

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container">
        
        <!-- Header / Hero Section (Centering sempurna, responsive desktop & mobile) -->
        <div class="perpus-hero-banner">
            <div class="max-w-3xl relative z-10">
                <!-- Tag Pill -->
                <div class="perpus-hero-badge">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>Koleksi Literasi &amp; Referensi Sekolah</span>
                </div>

                <!-- Judul Utama -->
                <h1 class="perpus-hero-title">
                    Perpustakaan Digital
                </h1>

                <!-- Teks Deskripsi -->
                <p class="perpus-hero-desc">
                    Eksplorasi ribuan judul buku, literatur keislaman, sains, teknologi, dan karya sastra. Ajukan peminjaman buku secara online dengan cepat dan mudah.
                </p>

                <!-- Search Bar Form (Input field rata kiri + tombol terpisah di kanan) -->
                <form action="{{ route('perpus.index') }}" method="GET" class="perpus-search-form">
                    <div class="perpus-search-input-wrap">
                        <svg class="w-5 h-5 absolute left-4 text-slate-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text"
                               name="search"
                               value="{{ $search }}"
                               placeholder="Cari judul buku atau penulis..."
                               class="perpus-search-input"
                               autocomplete="off">
                    </div>
                    @if($categoryId)
                        <input type="hidden" name="category" value="{{ $categoryId }}">
                    @endif
                    <button type="submit" class="perpus-search-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <span>Cari Koleksi</span>
                    </button>
                </form>
            </div>
            
            <!-- Hero Footer: Lacak Status -->
            <div class="perpus-hero-footer relative z-10">
                <div class="text-sm text-slate-300">
                    Sudah memiliki kode peminjaman buku?
                </div>
                <a href="{{ route('perpus.tracking') }}" class="perpus-hero-track-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Lacak Status Peminjaman Saya &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Filter Kategori Row (Flex wrap rapi dengan spacing nyaman di semua perangkat) -->
        <div class="perpus-pills-row">
            <a href="{{ route('perpus.index', array_filter(['search' => $search])) }}" 
               class="perpus-pill-item {{ !$categoryId ? 'perpus-pill-active' : 'perpus-pill-inactive' }}">
                Semua Kategori
            </a>
            @foreach($categories as $category)
            <a href="{{ route('perpus.index', array_filter(['category' => $category->id, 'search' => $search])) }}" 
               class="perpus-pill-item {{ $categoryId == $category->id ? 'perpus-pill-active' : 'perpus-pill-inactive' }}">
                {{ $category->name }}
            </a>
            @endforeach
        </div>

        <!-- Active Filter Indicator -->
        @if($search || $categoryId)
        <div class="perpus-filter-indicator">
            <div>
                Menampilkan hasil untuk:
                @if($search) <strong>"{{ $search }}"</strong> @endif
                @if($search && $categoryId) dan @endif
                @if($categoryId)
                    kategori <strong>{{ $categories->firstWhere('id', $categoryId)?->name }}</strong>
                @endif
            </div>
            <a href="{{ route('perpus.index') }}" class="perpus-filter-reset">Hapus Filter &times;</a>
        </div>
        @endif

        <!-- Book Cards Grid (Responsive 4 col desktop, 3 col laptop, 2 col tablet, 1 col mobile) -->
        <div class="perpus-books-grid">
            @forelse($books as $book)
            <div class="perpus-book-card">
                <!-- Cover Buku dengan Fallback Placeholder Image -->
                <div class="perpus-book-cover-wrap">
                    <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('images/book-placeholder.png') }}"
                         alt="{{ $book->title }}"
                         loading="lazy"
                         onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';"
                         class="w-full h-full object-cover">
                    
                    <!-- Kategori Badge -->
                    <span class="perpus-book-badge-cat">
                        {{ $book->category ? $book->category->name : 'Umum' }}
                    </span>

                    <!-- Stok Tersedia Badge -->
                    <span class="perpus-book-badge-stock {{ $book->available > 0 ? 'stock-available' : 'stock-empty' }}">
                        {{ $book->available > 0 ? $book->available . ' Tersedia' : 'Habis' }}
                    </span>
                </div>

                <!-- Book Details Body -->
                <div class="perpus-book-body">
                    <div>
                        <h2 class="perpus-book-title">
                            <a href="{{ route('perpus.show', $book->id) }}">{{ $book->title }}</a>
                        </h2>
                        <div class="perpus-book-meta">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="truncate">{{ $book->author }}</span>
                        </div>
                        @if($book->rack_location)
                        <div class="perpus-book-rack">
                            Rak: {{ $book->rack_location }}
                        </div>
                        @endif
                        <p class="perpus-book-synopsis line-clamp-2">
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
                        <button disabled class="perpus-btn-disabled flex-1">
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
                    Buku dengan kata kunci atau filter yang Anda cari belum tersedia. Coba gunakan istilah pencarian lain atau pilih kategori lain.
                </p>
                <a href="{{ route('perpus.index') }}" class="perpus-btn-borrow px-6 py-3">
                    Lihat Semua Koleksi
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="perpus-pagination-card mb-12">
            {{ $books->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
