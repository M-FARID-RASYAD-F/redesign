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
        color: var(--text-muted, #94a3b8);
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .news-breadcrumb a {
        color: var(--primary, #00B4D8);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .news-breadcrumb a:hover {
        text-decoration: underline;
    }

    .news-header-card {
        background: var(--card-bg, rgba(0, 33, 71, 0.8));
        border: 1px solid var(--border, rgba(0, 180, 216, 0.3));
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
        background: rgba(0, 180, 216, 0.15);
        color: var(--primary, #00B4D8);
        border: 1px solid rgba(0, 180, 216, 0.35);
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
        color: var(--text-muted, #cbd5e1);
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
        border: 1px solid var(--border, rgba(0, 180, 216, 0.25));
    }

    .news-content {
        background: var(--card-bg, rgba(0, 33, 71, 0.6));
        border: 1px solid var(--border, rgba(0, 180, 216, 0.25));
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

    .news-content h1, .news-content h2, .news-content h3, .news-content h4 {
        color: #ffffff;
        margin-top: 1.6rem;
        margin-bottom: 0.8rem;
        font-weight: 700;
        line-height: 1.35;
    }

    .news-content ul, .news-content ol {
        margin-bottom: 1.4rem;
        padding-left: 1.6rem;
    }

    .news-content li {
        margin-bottom: 0.4rem;
    }

    .news-content blockquote {
        border-left: 4px solid var(--primary, #00B4D8);
        padding-left: 1rem;
        margin: 1.2rem 0;
        color: var(--text-muted, #cbd5e1);
        font-style: italic;
    }

    .news-content a {
        color: var(--primary, #00B4D8);
        text-decoration: underline;
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
        background: var(--card-bg, rgba(0, 33, 71, 0.7));
        border: 1px solid var(--border, rgba(0, 180, 216, 0.25));
        border-radius: 12px;
        padding: 20px;
        text-decoration: none;
        display: block;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .related-card:hover {
        transform: translateY(-3px);
        border-color: var(--primary, #00B4D8);
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
        color: var(--text-muted, #94a3b8);
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

    /* Light Theme Engine Overrides (Anti Card Clash) */
    [data-theme="light"] .news-header-card,
    [data-theme="light"] .news-content,
    [data-theme="light"] .related-card {
        background: oklch(27.1% 0.105 12.094 / 0.94);
        border-color: oklch(58.6% 0.253 17.585 / 0.35);
        box-shadow: 0 16px 45px -5px rgba(0, 0, 0, 0.35);
    }

    [data-theme="light"] .news-badge {
        background: oklch(58.6% 0.253 17.585 / 0.2);
        color: oklch(75% 0.18 18);
        border-color: oklch(58.6% 0.253 17.585 / 0.45);
    }

    [data-theme="light"] .news-breadcrumb a {
        color: oklch(75% 0.18 18);
    }

    [data-theme="light"] .news-breadcrumb span {
        color: #fecdd3;
    }

    [data-theme="light"] .news-meta {
        border-top-color: oklch(58.6% 0.253 17.585 / 0.25);
        color: #fecdd3;
    }

    [data-theme="light"] .news-thumbnail {
        border-color: oklch(58.6% 0.253 17.585 / 0.35);
    }

    [data-theme="light"] .related-card:hover {
        border-color: oklch(58.6% 0.253 17.585);
        background: oklch(33% 0.125 13 / 0.98);
    }

    [data-theme="light"] .related-card p {
        color: #fecdd3 !important;
    }

    [data-theme="light"] .related-card span {
        color: #fda4af;
    }
</style>

<div class="news-detail-wrapper">
    <!-- Breadcrumb Navigasi -->
    <div class="news-breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span>&rsaquo;</span>
        <a href="{{ route('berita.index') }}">Portal Berita</a>
        <span>&rsaquo;</span>
        <span title="{{ $news->title }}">{{ Str::limit($news->title, 40) }}</span>
    </div>

    <!-- Header Artikel -->
    <div class="news-header-card">
        <span class="news-badge">{{ $news->category ? $news->category->name : 'Umum' }}</span>
        <h1 class="news-title">{{ $news->title }}</h1>
        <div class="news-meta">
            <span>📅 {{ $news->created_at ? $news->created_at->format('d F Y') : '-' }}</span>
            <span>✍️ {{ $news->author ? $news->author->name : 'Admin Sekolah' }}</span>
            <span>⏱️ {{ ceil(str_word_count(strip_tags($news->content)) / 200) }} menit baca</span>
        </div>
    </div>

    <!-- Thumbnail jika ada -->
    @if($news->thumbnail)
        <img src="{{ Str::startsWith($news->thumbnail, 'http') ? $news->thumbnail : asset($news->thumbnail) }}" alt="{{ $news->title }}" class="news-thumbnail">
    @endif

    <!-- Isi Konten Artikel -->
    <article class="news-content">
        @if(strip_tags($news->content) !== $news->content)
            {!! strip_tags($news->content, '<p><br><b><strong><i><em><u><s><h1><h2><h3><h4><h5><h6><blockquote><ul><ol><li><a><hr><span><div>') !!}
        @else
            {!! nl2br(e($news->content)) !!}
        @endif
    </article>

    <!-- Artikel Terkait -->
    @if($relatedNews->isNotEmpty())
    <div class="related-news-section">
        <h3 class="related-news-title">
            <span>📰</span>
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