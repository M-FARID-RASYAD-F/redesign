@extends('layouts.app')

@section('title', 'Portal Berita & Warta Sekolah — PKBM Tahfizh At-Tamam')

@section('konten_utama')
{{-- Area Konten Animasi Constellation Beams Background --}}
<x-constellation-grid class="content-area-constellation news-portal-page">
    <div class="news-portal-container">


        {{-- 2. Section Header --}}
        <x-section-header 
            tag="KABAR & WARTA RESMI" 
            title="Warta & Berita PKBM Tahfizh At-Tamam" 
            subtitle="Pusat informasi resmi seputar dinamika pembelajaran, prestasi santri, agenda sekolah, dan kegiatan kejuruan."
        />


        {{-- 4. Toolbar: Form Pencarian & Tab Kategori --}}
        <div class="news-toolbar-wrapper">
            <div class="news-toolbar-top">
                {{-- Form Pencarian Artikel --}}
                <form action="{{ route('berita.index') }}" method="GET" class="news-search-form" role="search">
                    @if($kategori)
                        <input type="hidden" name="kategori" value="{{ $kategori }}">
                    @endif
                    <div class="news-search-input-group">
                        <svg class="news-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input 
                            type="search" 
                            name="search" 
                            class="news-search-input" 
                            placeholder="Cari berita, topik, atau kata kunci..." 
                            value="{{ $search }}"
                            aria-label="Cari Berita"
                        >
                        @if($search)
                            <a href="{{ route('berita.index', array_filter(['kategori' => $kategori])) }}" class="news-search-clear" title="Hapus pencarian" aria-label="Hapus kata kunci">&times;</a>
                        @endif
                        <button type="submit" class="news-search-btn">
                            <span>Cari</span>
                        </button>
                    </div>
                </form>

                {{-- Status Hasil Pencarian / Filter Aktif --}}
                @if($search || $kategori)
                    <div class="news-filter-status">
                        <span class="status-text">
                            Menampilkan hasil
                            @if($search) untuk kata kunci "<strong>{{ $search }}</strong>"@endif
                            @if($kategori) pada kategori "<strong>{{ $categories->firstWhere('slug', $kategori)?->name ?? $kategori }}</strong>"@endif
                        </span>
                        <a href="{{ route('berita.index') }}" class="reset-filter-link">✕ Reset Semua Filter</a>
                    </div>
                @endif
            </div>

            {{-- Kategori Filter Pills --}}
            @if($categories->count() > 0)
                <div class="news-categories-bar" role="tablist" aria-label="Filter Kategori Berita">
                    <a 
                        href="{{ route('berita.index', array_filter(['search' => $search])) }}" 
                        class="news-category-pill {{ empty($kategori) ? 'active' : '' }}"
                    >
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a 
                            href="{{ route('berita.index', array_filter(['search' => $search, 'kategori' => $cat->slug])) }}" 
                            class="news-category-pill {{ $kategori === $cat->slug ? 'active' : '' }}"
                        >
                            {{ $cat->name }}
                            @if($cat->news_count > 0)
                                <span class="cat-count-badge">{{ $cat->news_count }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 5. Grid Container Berita (Mengadopsi <x-card> identik halaman beranda) --}}
        @if($news->count() > 0)
            <div class="grid-3 news-cards-grid news-portal-grid">
                @foreach($news as $b)
                    @php
                        $theme = match($loop->iteration % 3) {
                            1 => 'primary',
                            2 => 'secondary',
                            0 => 'accent',
                        };
                        $newsImage = !empty($b->thumbnail) ? $b->thumbnail : $localNewsImages[$loop->index % count($localNewsImages)];
                        $newsSlug = $b->slug ?? \Illuminate\Support\Str::slug($b->title);
                        $newsUrl = route('news.show', $newsSlug);
                        $formattedDate = $b->created_at ? $b->created_at->translatedFormat('d F Y') : 'Terbaru';
                        $readTime = '3 menit baca';
                        $excerpt = \Illuminate\Support\Str::limit(strip_tags($b->content), 130);
                    @endphp
                    <x-card 
                        :title="$b->title" 
                        :badge="$b->category ? $b->category->name : 'Umum'"
                        :subtitle="$formattedDate . ' • ' . $readTime"
                        :date="$formattedDate"
                        :read-time="$readTime"
                        :theme="$theme"
                        :image="$newsImage"
                        :link="$newsUrl"
                    >
                        <p class="news-excerpt">{{ $excerpt }}</p>
                        
                        <a href="{{ $newsUrl }}" class="card-read-more">
                            <span>Baca Selengkapnya</span>
                            <span class="read-more-arrow">&rarr;</span>
                        </a>
                    </x-card>
                @endforeach
            </div>

            {{-- 6. Pagination Navigator --}}
            @if($news->hasPages())
                <div class="news-pagination-section">
                    {{ $news->links() }}
                </div>
            @endif

        @else
            {{-- State Kosong (Empty State) --}}
            <div class="news-empty-container">
                <div class="empty-icon-wrap">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                </div>
                <h3 class="empty-title">Tidak Ada Berita Ditemukan</h3>
                <p class="empty-desc">
                    @if($search && $kategori)
                        Tidak ditemukan artikel berita dengan kata kunci "<strong>{{ $search }}</strong>" pada kategori "<strong>{{ $kategori }}</strong>".
                    @elseif($search)
                        Tidak ditemukan artikel berita dengan kata kunci pencarian "<strong>{{ $search }}</strong>". Silakan coba kata kunci lain.
                    @elseif($kategori)
                        Belum ada artikel berita yang dipublikasikan dalam kategori ini.
                    @else
                        Belum ada artikel berita yang dipublikasikan saat ini. Kunjungi kembali nanti untuk informasi terbaru.
                    @endif
                </p>
                <div class="empty-actions">
                    <a href="{{ route('berita.index') }}" class="btn btn-primary">
                        Lihat Semua Berita
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-constellation-grid>
@endsection
