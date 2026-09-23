@extends('layouts.app')

@section('title', 'Perpustakaan Digital - PKBM Tahfizh At-Tamam')

@section('konten_utama')
<div class="bg-gradient-to-b from-slate-50 to-white min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header / Hero Section -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-teal-800 via-emerald-800 to-slate-900 text-white p-8 sm:p-12 mb-10 shadow-xl">
            <div class="relative z-10 max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 text-xs sm:text-sm font-medium mb-4 backdrop-blur-sm border border-emerald-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Koleksi Literasi & Referensi Sekolah
                </div>
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight mb-4 text-white">
                    Perpustakaan Digital
                </h1>
                <p class="text-slate-200 text-base sm:text-lg mb-8 leading-relaxed">
                    Eksplorasi ribuan judul buku, literatur keislaman, sains, teknologi, dan karya sastra. Ajukan peminjaman buku secara online dengan cepat dan mudah.
                </p>

                <!-- Search Form -->
                <form action="{{ route('perpus.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 bg-white/10 backdrop-blur-md p-2 rounded-2xl border border-white/20">
                    <div class="flex-1 relative">
                        <svg class="w-5 h-5 absolute left-3.5 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul buku, penulis, atau topik..." class="w-full pl-11 pr-4 py-3 bg-white text-slate-800 placeholder-slate-400 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium text-sm sm:text-base">
                    </div>
                    @if($categoryId)
                        <input type="hidden" name="category" value="{{ $categoryId }}">
                    @endif
                    <button type="submit" class="px-7 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <span>Cari Koleksi</span>
                    </button>
                </form>
            </div>
            
            <div class="mt-6 flex flex-wrap items-center justify-between gap-4 pt-6 border-t border-white/15">
                <div class="text-sm text-slate-300">
                    Punya kode peminjaman?
                </div>
                <a href="{{ route('perpus.tracking') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-300 hover:text-white transition-colors bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg border border-white/15">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Lacak Status Peminjaman Saya &rarr;
                </a>
            </div>
        </div>

        <!-- Filter Kategori Tabs -->
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 scrollbar-thin">
            <a href="{{ route('perpus.index', array_filter(['search' => $search])) }}" 
               class="whitespace-nowrap px-4 py-2 rounded-xl text-sm font-medium transition-all {{ !$categoryId ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                Semua Kategori
            </a>
            @foreach($categories as $category)
            <a href="{{ route('perpus.index', array_filter(['category' => $category->id, 'search' => $search])) }}" 
               class="whitespace-nowrap px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $categoryId == $category->id ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ $category->name }}
            </a>
            @endforeach
        </div>

        <!-- Active Filter Indicator -->
        @if($search || $categoryId)
        <div class="flex items-center justify-between bg-slate-100 p-4 rounded-xl mb-6 text-sm">
            <div class="text-slate-700">
                Menampilkan hasil untuk:
                @if($search) <span class="font-semibold text-emerald-800">"{{ $search }}"</span> @endif
                @if($search && $categoryId) dan @endif
                @if($categoryId)
                    kategori <span class="font-semibold text-emerald-800">{{ $categories->firstWhere('id', $categoryId)?->name }}</span>
                @endif
            </div>
            <a href="{{ route('perpus.index') }}" class="text-rose-600 hover:text-rose-800 font-medium">Hapus Filter &times;</a>
        </div>
        @endif

        <!-- Book Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
            @forelse($books as $book)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">
                <!-- Book Cover / Aesthetic Illustration Header -->
                <div class="h-48 bg-gradient-to-br from-slate-800 to-emerald-950 p-6 flex flex-col justify-between relative overflow-hidden text-white">
                    <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-emerald-500/20 rounded-full blur-2xl group-hover:scale-150 transition-transform"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <span class="inline-block px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-500/30 text-emerald-200 backdrop-blur-sm border border-emerald-400/20">
                            {{ $book->category ? $book->category->name : 'Umum' }}
                        </span>
                        <span class="px-2.5 py-1 rounded-md text-xs font-bold {{ $book->available > 0 ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                            {{ $book->available > 0 ? $book->available . ' Tersedia' : 'Habis' }}
                        </span>
                    </div>
                    <div class="relative z-10">
                        <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-emerald-300 mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div class="text-xs text-slate-300 font-mono">
                            {{ $book->rack_location ? 'Rak: ' . $book->rack_location : 'Koleksi Umum' }}
                        </div>
                    </div>
                </div>

                <!-- Book Details Body -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h2 class="font-bold text-slate-900 text-lg leading-snug group-hover:text-emerald-700 transition-colors line-clamp-2 mb-2">
                            <a href="{{ route('perpus.show', $book->id) }}">{{ $book->title }}</a>
                        </h2>
                        <div class="text-sm text-slate-600 mb-1 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="truncate">{{ $book->author }}</span>
                        </div>
                        @if($book->publisher)
                        <div class="text-xs text-slate-400 mb-3">
                            Penerbit: {{ $book->publisher }}
                        </div>
                        @endif
                        <p class="text-xs text-slate-500 line-clamp-2 mb-4 leading-relaxed">
                            {{ $book->synopsis ?: 'Belum ada sinopsis untuk buku ini. Silakan kunjungi detail untuk informasi ketersediaan lengkap.' }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-3 border-t border-slate-100 flex items-center gap-2">
                        <a href="{{ route('perpus.show', $book->id) }}" class="flex-1 text-center py-2 px-3 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                            Detail Buku
                        </a>
                        @if($book->available > 0)
                        <a href="{{ route('perpus.pinjam.create', $book->id) }}" class="flex-1 text-center py-2 px-3 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors shadow-sm">
                            Pinjam Buku
                        </a>
                        @else
                        <button disabled class="flex-1 text-center py-2 px-3 text-xs font-semibold text-slate-400 bg-slate-100 rounded-lg cursor-not-allowed">
                            Stok Habis
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-16 text-center">
                <div class="w-20 h-20 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">Koleksi Buku Tidak Ditemukan</h3>
                <p class="text-slate-500 text-sm max-w-md mx-auto mb-6">
                    Buku dengan kata kunci atau filter yang Anda cari belum tersedia. Coba gunakan istilah pencarian lain.
                </p>
                <a href="{{ route('perpus.index') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-emerald-700 transition-colors">
                    Lihat Semua Buku
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            {{ $books->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
