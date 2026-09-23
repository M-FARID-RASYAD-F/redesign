@extends('layouts.app')

@section('title', 'Katalog Perpustakaan & Koleksi Buku — PKBM Tahfizh At-Tamam')

@section('konten_utama')
<x-constellation-grid class="content-area-constellation news-portal-page">
    <div class="news-portal-container">

        {{-- 1. Section Header --}}
        <x-section-header 
            tag="PERPUSTAKAAN DIGITAL" 
            title="Katalog Koleksi Buku & Pustaka" 
            subtitle="Jelajahi berbagai koleksi buku keilmuan, keagamaan, sains, teknologi, dan literatur umum yang tersedia di perpustakaan sekolah."
        />

        {{-- 2. Statistik Ringkas Koleksi --}}
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-bottom: 30px;">
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); padding: 10px 20px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #e2e8f0;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #00b4d8;"></span>
                <span>Total Koleksi: <strong>{{ $totalBooksCount }} Judul</strong></span>
            </div>
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); padding: 10px 20px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #e2e8f0;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></span>
                <span>Stok Siap Pinjam: <strong>{{ $totalAvailableCount }} Eksemplar</strong></span>
            </div>
            <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); padding: 10px 20px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #e2e8f0;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #f59e0b;"></span>
                <span>Klasifikasi: <strong>{{ $totalCategoriesCount }} Kategori</strong></span>
            </div>
        </div>

        {{-- 3. Toolbar: Pencarian & Filter --}}
        <div class="news-toolbar-wrapper" style="margin-bottom: 40px;">
            <div class="news-toolbar-top">
                {{-- Form Pencarian Utama --}}
                <form action="{{ route('catalog.index') }}" method="GET" class="news-search-form" role="search">
                    @if($categorySlug)
                        <input type="hidden" name="kategori" value="{{ $categorySlug }}">
                    @endif
                    @if($rackId)
                        <input type="hidden" name="rak" value="{{ $rackId }}">
                    @endif
                    @if($availability)
                        <input type="hidden" name="ketersediaan" value="{{ $availability }}">
                    @endif
                    @if($sort && $sort !== 'terbaru')
                        <input type="hidden" name="sort" value="{{ $sort }}">
                    @endif

                    <div class="news-search-input-group">
                        <svg class="news-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input 
                            type="search" 
                            name="q" 
                            class="news-search-input" 
                            placeholder="Cari judul buku, pengarang, penerbit, atau nomor ISBN..." 
                            value="{{ $search }}"
                            aria-label="Cari Buku"
                        >
                        @if($search)
                            <a href="{{ route('catalog.index', array_filter(['kategori' => $categorySlug, 'rak' => $rackId, 'ketersediaan' => $availability, 'sort' => $sort])) }}" class="news-search-clear" title="Hapus pencarian" aria-label="Hapus kata kunci">&times;</a>
                        @endif
                        <button type="submit" class="news-search-btn">
                            <span>Cari Buku</span>
                        </button>
                    </div>
                </form>

                {{-- Status Hasil Pencarian & Reset --}}
                @if($search || $categorySlug || $rackId || $availability)
                    <div class="news-filter-status" style="margin-top: 14px;">
                        <span class="status-text">
                            Menampilkan hasil
                            @if($search) untuk kata kunci "<strong>{{ $search }}</strong>"@endif
                            @if($activeCategory) pada kategori "<strong>{{ $activeCategory->name }}</strong>"@endif
                            @if($activeRack) di rak "<strong>{{ $activeRack->code }} - {{ $activeRack->name }}</strong>"@endif
                            @if($availability === 'tersedia') (hanya stok yang tersedia)@endif
                        </span>
                        <a href="{{ route('catalog.index') }}" class="reset-filter-link">✕ Reset Semua Filter</a>
                    </div>
                @endif
            </div>

            {{-- Filter Kategori Pills Horizontal Scroll --}}
            @if($categories->count() > 0)
                <div class="news-categories-bar" role="tablist" aria-label="Filter Kategori Buku" style="margin-top: 16px;">
                    <a 
                        href="{{ route('catalog.index', array_filter(['q' => $search, 'rak' => $rackId, 'ketersediaan' => $availability, 'sort' => $sort])) }}" 
                        class="news-category-pill {{ empty($categorySlug) ? 'active' : '' }}"
                    >
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a 
                            href="{{ route('catalog.index', array_filter(['q' => $search, 'kategori' => $cat->slug, 'rak' => $rackId, 'ketersediaan' => $availability, 'sort' => $sort])) }}" 
                            class="news-category-pill {{ $categorySlug === $cat->slug ? 'active' : '' }}"
                        >
                            @if($cat->icon)
                                <span>{{ $cat->icon }}</span>
                            @endif
                            <span>{{ $cat->name }}</span>
                            @if($cat->books_count > 0)
                                <span class="cat-count-badge">{{ $cat->books_count }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Sub-Filter: Rak, Ketersediaan, dan Pengurutan --}}
            <div style="margin-top: 16px; padding-top: 14px; border-top: 1px solid rgba(255, 255, 255, 0.07); display: flex; gap: 12px; flex-wrap: wrap; align-items: center; justify-content: space-between;">
                <form action="{{ route('catalog.index') }}" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    @if($search)
                        <input type="hidden" name="q" value="{{ $search }}">
                    @endif
                    @if($categorySlug)
                        <input type="hidden" name="kategori" value="{{ $categorySlug }}">
                    @endif

                    {{-- Filter Lokasi Rak --}}
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <label for="filterRak" style="font-size: 0.8rem; color: var(--text-muted);">Lokasi Rak:</label>
                        <select id="filterRak" name="rak" onchange="this.form.submit()" style="background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.12); color: #f8fafc; font-size: 0.82rem; padding: 6px 12px; border-radius: 8px; outline: none;">
                            <option value="">Semua Rak</option>
                            @foreach($racks as $r)
                                <option value="{{ $r->id }}" {{ $rackId == $r->id ? 'selected' : '' }}>{{ $r->code }} ({{ $r->name }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Ketersediaan --}}
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <label for="filterAvail" style="font-size: 0.8rem; color: var(--text-muted);">Stok:</label>
                        <select id="filterAvail" name="ketersediaan" onchange="this.form.submit()" style="background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.12); color: #f8fafc; font-size: 0.82rem; padding: 6px 12px; border-radius: 8px; outline: none;">
                            <option value="">Semua Buku</option>
                            <option value="tersedia" {{ $availability === 'tersedia' ? 'selected' : '' }}>Hanya Siap Pinjam</option>
                        </select>
                    </div>

                    {{-- Pengurutan --}}
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <label for="filterSort" style="font-size: 0.8rem; color: var(--text-muted);">Urutan:</label>
                        <select id="filterSort" name="sort" onchange="this.form.submit()" style="background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.12); color: #f8fafc; font-size: 0.82rem; padding: 6px 12px; border-radius: 8px; outline: none;">
                            <option value="terbaru" {{ $sort === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="judul_asc" {{ $sort === 'judul_asc' ? 'selected' : '' }}>Judul (A - Z)</option>
                            <option value="judul_desc" {{ $sort === 'judul_desc' ? 'selected' : '' }}>Judul (Z - A)</option>
                            <option value="tahun_desc" {{ $sort === 'tahun_desc' ? 'selected' : '' }}>Tahun Terbaru</option>
                        </select>
                    </div>
                </form>

                <div style="font-size: 0.82rem; color: var(--text-muted);">
                    Menampilkan <strong>{{ $books->total() }}</strong> buku
                </div>
            </div>
        </div>

        {{-- 4. Grid Katalog Buku --}}
        @if($books->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px; margin-bottom: 50px;">
                @foreach($books as $book)
                    <div class="tilt-card-wrapper" style="display: flex; flex-direction: column;">
                        <article class="news-card-inner" style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; height: 100%; transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;">
                            
                            {{-- Cover Image Container --}}
                            <div style="position: relative; width: 100%; aspect-ratio: 3/4; background: #0f172a; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <img 
                                    src="{{ $book->cover_url }}" 
                                    alt="Cover {{ $book->title }}" 
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                                    loading="lazy"
                                    onmouseover="this.style.transform='scale(1.04)'"
                                    onmouseout="this.style.transform='scale(1)'"
                                >
                                
                                {{-- Kategori Badge Over Cover --}}
                                @if($book->category)
                                    <span style="position: absolute; top: 12px; left: 12px; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(8px); color: #38bdf8; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; border: 1px solid rgba(56, 189, 248, 0.3); text-transform: uppercase; letter-spacing: 0.5px;">
                                        {{ $book->category->name }}
                                    </span>
                                @endif

                                {{-- Stock Status Badge Over Cover --}}
                                <span style="position: absolute; top: 12px; right: 12px; background: {{ $book->available_stock > 0 ? 'rgba(16, 185, 129, 0.9)' : 'rgba(239, 68, 68, 0.9)' }}; backdrop-filter: blur(8px); color: #ffffff; font-size: 0.72rem; font-weight: 700; padding: 4px 9px; border-radius: 9999px; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                                    @if($book->available_stock > 0)
                                        ✓ {{ $book->available_stock }} Eks.
                                    @else
                                        Dipinjam
                                    @endif
                                </span>
                            </div>

                            {{-- Book Details Body --}}
                            <div style="padding: 18px; display: flex; flex-direction: column; flex-grow: 1;">
                                {{-- Rak Location Tag --}}
                                @if($book->rack)
                                    <div style="display: flex; align-items: center; gap: 6px; font-size: 0.75rem; color: #10b981; margin-bottom: 8px; font-weight: 600;">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
                                        <span>{{ $book->rack->code }} ({{ $book->rack->name }})</span>
                                    </div>
                                @endif

                                {{-- Book Title --}}
                                <h3 style="font-size: 1.05rem; font-weight: 700; color: #ffffff; margin: 0 0 8px 0; line-height: 1.4;">
                                    <a href="{{ route('catalog.show', $book->slug) }}" style="color: inherit; text-decoration: none; transition: color 0.2s ease;" onmouseover="this.style.color='#38bdf8'" onmouseout="this.style.color='#ffffff'">
                                        {{ Str::limit($book->title, 55) }}
                                    </a>
                                </h3>

                                {{-- Author & Year --}}
                                <div style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 12px; line-height: 1.4;">
                                    <span>Penulis: <strong>{{ $book->author }}</strong></span>
                                    @if($book->publication_year)
                                        <span style="margin-left: 6px;">({{ $book->publication_year }})</span>
                                    @endif
                                </div>

                                {{-- Description Excerpt --}}
                                <p style="font-size: 0.8rem; color: #94a3b8; line-height: 1.5; margin: 0 0 16px 0; flex-grow: 1;">
                                    {{ Str::limit($book->description ?? 'Tidak ada sinopsis singkat untuk buku ini.', 90) }}
                                </p>

                                {{-- Bottom Action Footer --}}
                                <div style="padding-top: 12px; border-top: 1px solid rgba(255, 255, 255, 0.06); display: flex; align-items: center; justify-content: space-between;">
                                    <span style="font-size: 0.75rem; color: var(--text-muted);">
                                        @if($book->pages) {{ $book->pages }} Halaman @endif
                                    </span>
                                    <a href="{{ route('catalog.show', $book->slug) }}" class="btn btn-outline btn-sm" style="font-size: 0.78rem; padding: 5px 12px; border-radius: 6px; display: inline-flex; align-items: center; gap: 5px; color: #38bdf8; border-color: rgba(56, 189, 248, 0.3);">
                                        <span>Lihat Detail</span>
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            {{-- 5. Pagination Controls --}}
            <div style="display: flex; justify-content: center; margin-top: 30px; margin-bottom: 50px;">
                {{ $books->links() }}
            </div>

        @else
            {{-- Empty State --}}
            <div style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; padding: 60px 20px; text-align: center; margin-bottom: 50px;">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(56, 189, 248, 0.1); color: #38bdf8; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: #ffffff; margin-bottom: 8px;">Koleksi Buku Tidak Ditemukan</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 480px; margin: 0 auto 24px auto;">
                    Tidak ada buku yang cocok dengan kriteria pencarian atau filter yang dipilih. Silakan coba gunakan kata kunci lain atau reset filter.
                </p>
                <a href="{{ route('catalog.index') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                    <span>Reset Semua Filter</span>
                </a>
            </div>
        @endif

    </div>
</x-constellation-grid>
@endsection
