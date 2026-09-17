@props([
    'title' => null,
    'badge' => null,
    'icon' => null,
    'subtitle' => null,
    'theme' => 'primary',
    'image' => null,
    'imageAlt' => null,
    'date' => null,
    'readTime' => null,
    'link' => null,
])

<div {{ $attributes->merge(['class' => 'custom-card tilt-card-3d theme-' . $theme . ($image ? ' card-with-image news-card' : '')]) }} data-tilt="true">
    {{-- 1. Layer Efek Shine / Glare (Refleksi 3D Tilt) --}}
    <div class="card-glare" aria-hidden="true"></div>

    {{-- 2. Indikator Status (Pulsing Dot) di pojok kanan atas --}}
    <span class="card-status-dot" aria-hidden="true" title="Status Aktif"></span>

    @if($image)
        {{-- Area Gambar Berita dengan Flush Layout --}}
        <div class="card-image-wrap">
            <img src="{{ asset($image) }}" alt="{{ $imageAlt ?? $title }}" class="card-image" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('images/sch1.jpeg') }}';">
            
            {{-- Gradasi Overlay Blur Warna Transisi ke Body (seperti gradasi pada hero head) --}}
            <div class="card-image-overlay" aria-hidden="true"></div>

            {{-- Frosted Badge dengan Blur Warna sebelum teks (persis hero-badge pada head) --}}
            @if($badge)
                <div class="card-badge-container">
                    <span class="card-badge-blur theme-{{ $theme }}">
                        <span class="badge-dot" aria-hidden="true"></span>
                        {{ $badge }}
                    </span>
                </div>
            @endif
        </div>

        {{-- Ambient Color Blur Glow sebelum teks (efek pendaran warna seperti pada head) --}}
        <div class="card-ambient-glow theme-{{ $theme }}" aria-hidden="true"></div>

        {{-- Konten Body Berita --}}
        <div class="card-content-wrap">
            {{-- Meta Bar: Tanggal & Estimasi Waktu Baca sebelum Judul --}}
            @if($date || $subtitle)
                <div class="card-meta-row">
                    <span class="card-meta-date">
                        <svg class="meta-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="18" y2="10"></line></svg>
                        {{ $date ?? (str_contains($subtitle, ' • ') ? explode(' • ', $subtitle)[0] : $subtitle) }}
                    </span>
                    @php
                        $timeStr = $readTime ?? (isset($subtitle) && str_contains($subtitle, ' • ') ? explode(' • ', $subtitle)[1] : null);
                    @endphp
                    @if($timeStr)
                        <span class="card-meta-sep">•</span>
                        <span class="card-meta-read">
                            <svg class="meta-icon" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            {{ $timeStr }}
                        </span>
                    @endif
                </div>
            @endif

            {{-- Judul Berita --}}
            @if($title)
                <h3 class="card-title">
                    @if($link)
                        <a href="{{ $link }}" class="card-title-link">{{ $title }}</a>
                    @else
                        {{ $title }}
                    @endif
                </h3>
            @endif

            {{-- Slot Body (Ringkasan & Link Baca Selengkapnya) --}}
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    @else
        {{-- 3. Header Card Standar (Icon, Title, Subtitle, Badge) --}}
        @if($title || $badge)
            <div class="card-header">
                <div class="card-header-main">
                    @if($icon)
                        <span class="card-icon-3d">{{ $icon }}</span>
                    @endif
                    <div class="card-title-group">
                        <h3 class="card-title">{{ $title }}</h3>
                        @if($subtitle)
                            <div class="card-subtitle">{{ $subtitle }}</div>
                        @endif
                    </div>
                </div>
                @if($badge)
                    <span class="badge">{{ $badge }}</span>
                @endif
            </div>
        @endif

        {{-- 4. Konten Body (Layer Depan 3D) --}}
        <div class="card-body">
            {{ $slot }}
        </div>
    @endif

    {{-- 5. Elemen CTA Reveal (Explore Hint) --}}
    <div class="card-explore-hint" aria-hidden="true">
        <span class="explore-line"></span>
        <span class="explore-text">{{ $image ? 'Buka Artikel →' : 'Explore →' }}</span>
    </div>
</div>