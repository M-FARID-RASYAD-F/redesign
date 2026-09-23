@extends('layouts.app')

@section('title', "{$book->title} — Katalog Perpustakaan PKBM Tahfizh At-Tamam")

@section('konten_utama')
<x-constellation-grid class="content-area-constellation news-portal-page">
    <div class="news-portal-container" style="max-width: 1080px; margin: 0 auto; padding-top: 20px;">

        {{-- Breadcrumb Navigasi --}}
        <nav aria-label="Breadcrumb" style="margin-bottom: 24px;">
            <ol style="display: flex; gap: 8px; align-items: center; list-style: none; padding: 0; margin: 0; font-size: 0.85rem; color: var(--text-muted); flex-wrap: wrap;">
                <li>
                    <a href="{{ route('home') }}" style="color: var(--text-muted); text-decoration: none;">Beranda</a>
                </li>
                <li>/</li>
                <li>
                    <a href="{{ route('catalog.index') }}" style="color: var(--text-muted); text-decoration: none;">Katalog Perpustakaan</a>
                </li>
                @if($book->category)
                    <li>/</li>
                    <li>
                        <a href="{{ route('catalog.index', ['kategori' => $book->category->slug]) }}" style="color: #38bdf8; text-decoration: none;">
                            {{ $book->category->name }}
                        </a>
                    </li>
                @endif
                <li>/</li>
                <li style="color: #ffffff; font-weight: 600;">
                    {{ Str::limit($book->title, 40) }}
                </li>
            </ol>
        </nav>

        {{-- Main Book Detail Card --}}
        <div style="background: rgba(15, 23, 42, 0.75); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 18px; padding: 32px; margin-bottom: 48px; backdrop-filter: blur(12px);">
            <div style="display: grid; grid-template-columns: 280px 1fr; gap: 36px;">
                
                {{-- Left Column: Cover & Lokasi Rak --}}
                <div>
                    {{-- Cover Box --}}
                    <div style="width: 100%; aspect-ratio: 3/4; border-radius: 12px; overflow: hidden; box-shadow: 0 16px 32px rgba(0, 0, 0, 0.45); border: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 20px; background: #0f172a;">
                        <img 
                            src="{{ $book->cover_url }}" 
                            alt="{{ $book->title }}" 
                            style="width: 100%; height: 100%; object-fit: cover;"
                        >
                    </div>

                    {{-- Status Ketersediaan Card --}}
                    <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.07); border-radius: 12px; padding: 16px; margin-bottom: 16px;">
                        <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); margin-bottom: 6px;">
                            Status Ketersediaan
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 1.1rem; font-weight: 700; color: {{ $book->available_stock > 0 ? '#10b981' : '#ef4444' }};">
                                {{ $book->available_stock > 0 ? 'Tersedia' : 'Sedang Dipinjam' }}
                            </span>
                            <span style="font-size: 0.85rem; color: #94a3b8;">
                                {{ $book->available_stock }} / {{ $book->stock }} Eks.
                            </span>
                        </div>
                        <div style="width: 100%; height: 6px; background: rgba(255, 255, 255, 0.1); border-radius: 3px; margin-top: 10px; overflow: hidden;">
                            @php
                                $percent = $book->stock > 0 ? round(($book->available_stock / $book->stock) * 100) : 0;
                            @endphp
                            <div style="width: {{ $percent }}%; height: 100%; background: {{ $book->available_stock > 0 ? '#10b981' : '#ef4444' }}; border-radius: 3px;"></div>
                        </div>
                    </div>

                    {{-- Lokasi Rak Fisik --}}
                    @if($book->rack)
                        <div style="background: rgba(16, 185, 129, 0.06); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 12px; padding: 16px;">
                            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: #10b981; margin-bottom: 4px; font-weight: 700;">
                                Lokasi Fisik di Perpustakaan
                            </div>
                            <div style="font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 2px;">
                                {{ $book->rack->code }}
                            </div>
                            <div style="font-size: 0.85rem; color: #94a3b8; line-height: 1.4;">
                                {{ $book->rack->name }}
                                @if($book->rack->location)
                                    <br><span style="color: #38bdf8;">📍 {{ $book->rack->location }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right Column: Information & Details --}}
                <div style="display: flex; flex-direction: column;">
                    
                    {{-- Badges --}}
                    <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 12px; flex-wrap: wrap;">
                        @if($book->category)
                            <a href="{{ route('catalog.index', ['kategori' => $book->category->slug]) }}" style="text-decoration: none; background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); font-size: 0.75rem; font-weight: 700; padding: 4px 12px; border-radius: 9999px; text-transform: uppercase; letter-spacing: 0.5px;">
                                @if($book->category->icon) {{ $book->category->icon }} @endif {{ $book->category->name }}
                            </a>
                        @endif
                        @if($book->publication_year)
                            <span style="background: rgba(255, 255, 255, 0.06); color: #cbd5e1; font-size: 0.75rem; padding: 4px 10px; border-radius: 9999px;">
                                Tahun {{ $book->publication_year }}
                            </span>
                        @endif
                    </div>

                    {{-- Title --}}
                    <h1 style="font-size: 2rem; font-weight: 800; color: #ffffff; margin: 0 0 8px 0; line-height: 1.25;">
                        {{ $book->title }}
                    </h1>

                    {{-- Author --}}
                    <div style="font-size: 1rem; color: #94a3b8; margin-bottom: 24px;">
                        Karya: <strong style="color: #f8fafc;">{{ $book->author }}</strong>
                        @if($book->publisher)
                            · Diterbitkan oleh: <span style="color: #cbd5e1;">{{ $book->publisher }}</span>
                        @endif
                    </div>

                    {{-- Spesifikasi Buku (Table-like grid) --}}
                    <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; padding: 18px; margin-bottom: 24px;">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 16px;">
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">ISBN</span>
                                <strong style="font-size: 0.9rem; color: #ffffff; font-family: monospace;">{{ $book->isbn ?? '—' }}</strong>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Halaman</span>
                                <strong style="font-size: 0.9rem; color: #ffffff;">{{ $book->pages ? "{$book->pages} Halaman" : '—' }}</strong>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Kategori</span>
                                <strong style="font-size: 0.9rem; color: #ffffff;">{{ $book->category->name ?? 'Umum' }}</strong>
                            </div>
                            <div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">Lokasi Rak</span>
                                <strong style="font-size: 0.9rem; color: #38bdf8;">{{ $book->rack->code ?? 'Perpus Pusat' }}</strong>
                            </div>
                        </div>
                    </div>

                    {{-- Sinopsis / Ringkasan --}}
                    <div style="margin-bottom: 30px;">
                        <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 10px;">
                            Sinopsis & Deskripsi Buku
                        </h2>
                        <div style="font-size: 0.95rem; color: #cbd5e1; line-height: 1.7; white-space: pre-line;">
                            {{ $book->description ?? 'Belum ada ringkasan atau sinopsis resmi untuk buku ini.' }}
                        </div>
                    </div>

                    {{-- CTA Peminjaman Buku (Siap untuk Modul B & Kontak) --}}
                    <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.08); display: flex; gap: 14px; flex-wrap: wrap; align-items: center;">
                        @if($book->available_stock > 0)
                            <a 
                                href="{{ config('school.whatsapp_url', 'https://wa.me/6281270001920') }}?text={{ urlencode('Halo Admin Perpustakaan At-Tamam, saya ingin bertanya / meminjam buku: ' . $book->title . ' (ISBN: ' . ($book->isbn ?? '-') . ')') }}" 
                                target="_blank" 
                                class="btn btn-primary" 
                                style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; font-weight: 600;"
                            >
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                <span>Ajukan Peminjaman Buku</span>
                            </a>
                        @else
                            <button disabled class="btn btn-outline" style="opacity: 0.6; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px;">
                                <span>Stok Sedang Kosong (Habis Dipinjam)</span>
                            </button>
                        @endif

                        <a href="{{ route('catalog.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                            <span>Kembali ke Katalog</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- Buku Terkait dalam Kategori yang Sama --}}
        @if($relatedBooks->count() > 0)
            <div style="margin-top: 40px; margin-bottom: 60px;">
                <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <span>Buku Lainnya di Kategori Ini</span>
                    <span style="font-size: 0.8rem; font-weight: 600; background: rgba(56, 189, 248, 0.15); color: #38bdf8; padding: 2px 10px; border-radius: 9999px;">{{ $book->category->name }}</span>
                </h2>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
                    @foreach($relatedBooks as $rb)
                        <div style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column;">
                            <div style="width: 100%; aspect-ratio: 3/4; background: #0f172a; overflow: hidden;">
                                <img src="{{ $rb->cover_url }}" alt="{{ $rb->title }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                            </div>
                            <div style="padding: 14px; display: flex; flex-direction: column; flex-grow: 1;">
                                <h3 style="font-size: 0.95rem; font-weight: 700; color: #ffffff; margin: 0 0 6px 0; line-height: 1.35;">
                                    <a href="{{ route('catalog.show', $rb->slug) }}" style="color: inherit; text-decoration: none;">
                                        {{ Str::limit($rb->title, 45) }}
                                    </a>
                                </h3>
                                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 12px;">
                                    {{ $rb->author }}
                                </div>
                                <div style="margin-top: auto;">
                                    <a href="{{ route('catalog.show', $rb->slug) }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center; font-size: 0.78rem;">
                                        Lihat Buku
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-constellation-grid>
@endsection
