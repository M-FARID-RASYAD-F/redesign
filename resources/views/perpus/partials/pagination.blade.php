@if ($paginator->hasPages())
<nav role="navigation" aria-label="Navigasi Halaman Perpustakaan" class="perpus-pagination-wrapper">
    {{-- Info Counter (Kiri) --}}
    <div class="perpus-pagination-info">
        <div class="perpus-pagination-badge">
            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span>
                Menampilkan <strong class="perpus-page-highlight">{{ $paginator->firstItem() }}&ndash;{{ $paginator->lastItem() }}</strong> dari <strong class="perpus-page-highlight">{{ $paginator->total() }}</strong> buku
            </span>
        </div>
        <span class="perpus-pagination-pages-badge">
            Hal. {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
        </span>
    </div>

    {{-- Navigasi Tombol Angka & Arah (Kanan) --}}
    <div class="perpus-pagination-controls">
        {{-- Tombol Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="perpus-page-nav-btn perpus-page-nav-disabled" aria-disabled="true" aria-label="Halaman Sebelumnya">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="perpus-page-nav-text">Sebelumnya</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="perpus-page-nav-btn perpus-page-nav-link" aria-label="Halaman Sebelumnya">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="perpus-page-nav-text">Sebelumnya</span>
            </a>
        @endif

        {{-- Daftar Angka Halaman --}}
        <div class="perpus-page-numbers">
            @foreach ($elements as $element)
                {{-- Separator Titik Tiga --}}
                @if (is_string($element))
                    <span class="perpus-page-dots" aria-disabled="true">
                        <span>{{ $element }}</span>
                    </span>
                @endif

                {{-- Array Link Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="perpus-page-item perpus-page-active" aria-current="page">
                                <span class="perpus-page-btn">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}" class="perpus-page-item perpus-page-link" aria-label="Halaman {{ $page }}">
                                <span class="perpus-page-btn">{{ $page }}</span>
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Tombol Selanjutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="perpus-page-nav-btn perpus-page-nav-link" aria-label="Halaman Selanjutnya">
                <span class="perpus-page-nav-text">Selanjutnya</span>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @else
            <span class="perpus-page-nav-btn perpus-page-nav-disabled" aria-disabled="true" aria-label="Halaman Selanjutnya">
                <span class="perpus-page-nav-text">Selanjutnya</span>
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        @endif
    </div>
</nav>
@endif
