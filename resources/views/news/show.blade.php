@extends('layouts.app')

@section('title', $news->title . ' — PKBM Tahfizh At-Tamam')

@section('konten_utama')
<style>
    .news-detail-wrapper {
        max-width: 900px;
        margin: 40px auto 60px;
        padding: 0 20px;
    }

    .news-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.88rem;
        color: var(--text-muted, #a8c4b0);
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .news-breadcrumb a {
        color: var(--primary, #c9962b);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .news-breadcrumb a:hover {
        text-decoration: underline;
    }

    .news-header-card {
        background: var(--card-bg, rgba(15, 36, 25, 0.8));
        border: 1px solid var(--border, rgba(201, 150, 43, 0.3));
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 30px;
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
    }

    .news-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: rgba(201, 150, 43, 0.15);
        color: var(--primary, #c9962b);
        border: 1px solid rgba(201, 150, 43, 0.35);
        margin-bottom: 14px;
    }

    .news-title {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.3;
        color: #ffffff;
        margin: 0 0 16px 0;
    }

    .news-meta {
        display: flex;
        align-items: center;
        gap: 18px;
        font-size: 0.86rem;
        color: var(--text-muted, #a8c4b0);
        flex-wrap: wrap;
        padding-top: 14px;
        border-top: 1px solid var(--border, rgba(255, 255, 255, 0.1));
    }

    .news-thumbnail {
        width: 100%;
        max-height: 440px;
        object-fit: cover;
        border-radius: 14px;
        margin-bottom: 30px;
        border: 1px solid var(--border, rgba(201, 150, 43, 0.25));
    }

    .news-content {
        background: var(--card-bg, rgba(15, 36, 25, 0.6));
        border: 1px solid var(--border, rgba(201, 150, 43, 0.25));
        border-radius: 16px;
        padding: 32px;
        color: #f1f5f9;
        font-size: 1.05rem;
        line-height: 1.8;
        margin-bottom: 40px;
    }

    .news-content p {
        margin-bottom: 1.4rem;
    }

    .related-news-section {
        margin-top: 50px;
    }

    .related-news-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
    }

    .related-card {
        background: var(--card-bg, rgba(15, 36, 25, 0.7));
        border: 1px solid var(--border, rgba(201, 150, 43, 0.25));
        border-radius: 12px;
        padding: 20px;
        text-decoration: none;
        display: block;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .related-card:hover {
        transform: translateY(-3px);
        border-color: var(--primary, #c9962b);
    }

    .related-card h4 {
        color: #ffffff;
        font-size: 1rem;
        font-weight: 700;
        margin: 8px 0;
        line-height: 1.4;
    }

    .related-card span {
        font-size: 0.78rem;
        color: var(--text-muted, #a8c4b0);
    }

    @media (max-width: 640px) {
        .news-header-card,
        .news-content {
            padding: 20px;
        }
        .news-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="news-detail-wrapper">
    <!-- Breadcrumb Navigasi -->
    <div class="news-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span>&rsaquo;</span>
        <a href="{{ route('home') }}#berita">Kabar Berita</a>
        <span>&rsaquo;</span>
        <span>{{ Str::limit($news->title, 40) }}</span>
    </div>

    <!-- Header Artikel -->
    <div class="news-header-card">
        <span class="news-badge">{{ $news->category ? $news->category->name : 'Umum' }}</span>
        <h1 class="news-title">{{ $news->title }}</h1>
        <div class="news-meta">
            <span><x-icon name="calendar" /> {{ $news->created_at ? $news->created_at->format('d F Y') : '-' }}</span>
            <span>{{ $news->author ? $news->author->name : 'Admin Sekolah' }}</span>
            <span>⏱️ {{ ceil(str_word_count(strip_tags($news->content)) / 200) }} menit baca</span>
        </div>
    </div>

    <!-- Thumbnail jika ada -->
    @if($news->thumbnail)
        <img src="{{ Str::startsWith($news->thumbnail, 'http') ? $news->thumbnail : asset($news->thumbnail) }}" alt="{{ $news->title }}" class="news-thumbnail">
    @endif

    <!-- Isi Konten Artikel -->
    <article class="news-content">
        {!! nl2br(e($news->content)) !!}
    </article>

    <!-- Artikel Terkait -->
    @if($relatedNews->isNotEmpty())
    <div class="related-news-section">
        <h3 class="related-news-title">
            <span><x-icon name="newspaper" /></span>
            <span>Berita & Pengumuman Lainnya</span>
        </h3>
        <div class="related-grid">
            @foreach($relatedNews as $item)
            <a href="{{ route('news.show', $item->slug) }}" class="related-card">
                <span>{{ $item->category ? $item->category->name : 'Umum' }} &bull; {{ $item->created_at ? $item->created_at->format('d M Y') : '' }}</span>
                <h4>{{ $item->title }}</h4>
                <p style="font-size: 0.85rem; color: #cbd5e1; margin-top: 6px; line-height: 1.4;">
                    {{ Str::limit(strip_tags($item->content), 90) }}
                </p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Tombol Kembali -->
    <div style="margin-top: 40px; text-align: center;">
        <a href="{{ route('home') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <span>&larr; Kembali ke Beranda Sekolah</span>
        </a>
    </div>
</div>
@endsection