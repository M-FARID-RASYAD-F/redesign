@extends('layouts.app')

@section('title', $book->title . ' - Perpustakaan Digital')

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-medium">
        
        <!-- Breadcrumbs / Back Navigation -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route('perpus.index') }}" class="perpus-hero-track-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Katalog</span>
            </a>
            <a href="{{ route('perpus.tracking') }}" class="text-xs sm:text-sm text-emerald-400 hover:text-emerald-300 font-semibold transition-colors">
                Cek Status Pinjaman &rarr;
            </a>
        </div>

        <!-- Book Detail Card (Responsive 2-col on desktop, stacked on mobile) -->
        <div class="perpus-card-surface overflow-hidden mb-12">
            <div class="perpus-detail-grid">
                <!-- Visual / Illustration Panel -->
                <div class="p-6 sm:p-8 flex flex-col justify-between relative overflow-hidden perpus-card-subsurface">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                                {{ $book->category ? $book->category->name : 'Umum' }}
                            </span>
                            <span class="text-xs font-mono text-emerald-300 font-semibold">
                                Rak: {{ $book->rack_location ?: '-' }}
                            </span>
                        </div>

                        <!-- Book Cover Image with Placeholder Fallback -->
                        <div class="w-full h-64 sm:h-72 rounded-2xl overflow-hidden shadow-2xl border border-white/20 bg-slate-900 mb-6 flex items-center justify-center">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('images/book-placeholder.png') }}"
                                 alt="{{ $book->title }}"
                                 onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';"
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-white/15">
                        <div class="text-xs text-slate-300 mb-1">Status Ketersediaan:</div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full {{ $book->available > 0 ? 'bg-emerald-400 animate-pulse' : 'bg-rose-400' }}"></div>
                            <span class="font-bold text-sm {{ $book->available > 0 ? 'text-emerald-300' : 'text-rose-300' }}">
                                {{ $book->available > 0 ? $book->available . ' Eksemplar Tersedia' : 'Semua Buku Sedang Dipinjam' }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-400 mt-1">Total Koleksi: {{ $book->stock }} eksemplar</div>
                    </div>
                </div>

                <!-- Info and Synopsis Panel -->
                <div class="p-6 sm:p-10 flex flex-col justify-between">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-3 leading-tight">
                            {{ $book->title }}
                        </h1>

                        <!-- Metadata Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-4 border-y border-white/10 text-sm mb-6">
                            <div>
                                <span class="text-slate-400 block text-xs">Penulis</span>
                                <span class="font-semibold text-slate-100">{{ $book->author }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-xs">Penerbit</span>
                                <span class="font-semibold text-slate-100">{{ $book->publisher ?: '-' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-xs">ISBN</span>
                                <span class="font-mono text-slate-100">{{ $book->isbn ?: 'Tidak Terdaftar' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-xs">Durasi Pinjam Standar</span>
                                <span class="font-semibold text-emerald-400">7 Hari Kalender</span>
                            </div>
                        </div>

                        <!-- Synopsis -->
                        <div>
                            <h3 class="font-bold text-white text-sm uppercase tracking-wider mb-2">Sinopsis & Deskripsi</h3>
                            <div class="text-slate-300 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                                {{ $book->synopsis ?: 'Buku ini tersedia untuk dibaca di tempat maupun dipinjam pulang oleh civitas akademika dan masyarakat umum yang terdaftar.' }}
                            </div>
                        </div>
                    </div>

                    <!-- Call To Action -->
                    <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center gap-4">
                        @if($book->available > 0)
                        <a href="{{ route('perpus.pinjam.create', $book->id) }}" class="perpus-btn-borrow w-full sm:w-auto flex-1 text-center py-3.5 px-6 text-sm">
                            Ajukan Peminjaman Buku Ini
                        </a>
                        @else
                        <div class="w-full sm:w-auto flex-1 py-3 px-6 perpus-btn-disabled text-center font-bold">
                            Seluruh Eksemplar Sedang Dipinjam
                        </div>
                        @endif
                        <a href="{{ route('perpus.index') }}" class="perpus-btn-detail w-full sm:w-auto px-6 py-3.5 text-center text-sm font-semibold">
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
                <h3 class="text-xl font-bold text-white">Buku Terkait dalam Kategori yang Sama</h3>
                <a href="{{ route('perpus.index', ['category' => $book->category_id]) }}" class="text-sm font-semibold text-emerald-400 hover:text-emerald-300">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="perpus-related-grid">
                @foreach($related as $rel)
                <div class="perpus-book-card p-5 justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-3 border border-emerald-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h4 class="font-bold text-white text-sm mb-1 line-clamp-2">
                            <a href="{{ route('perpus.show', $rel->id) }}" class="hover:text-emerald-400 transition-colors">{{ $rel->title }}</a>
                        </h4>
                        <div class="text-xs text-slate-400 mb-4">{{ $rel->author }}</div>
                    </div>
                    <a href="{{ route('perpus.show', $rel->id) }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300 pt-3 border-t border-white/10 flex items-center justify-between">
                        <span>Lihat Detail</span>
                        <span>&rarr;</span>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
