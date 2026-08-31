@props(['title' => null, 'badge' => null, 'icon' => null, 'subtitle' => null, 'theme' => 'primary'])

<div {{ $attributes->merge(['class' => 'custom-card tilt-card-3d theme-' . $theme]) }} data-tilt="true">
    {{-- 1. Layer Efek Shine / Glare --}}
    <div class="card-glare" aria-hidden="true"></div>

    {{-- 2. Indikator Status (Pulsing Dot) di pojok kanan atas --}}
    <span class="card-status-dot" aria-hidden="true" title="Status Aktif"></span>

    {{-- 3. Header Card (Icon, Title, Subtitle, Badge) --}}
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

    {{-- 5. Elemen CTA Reveal (Explore Hint) --}}
    <div class="card-explore-hint" aria-hidden="true">
        <span class="explore-line"></span>
        <span class="explore-text">Explore &rarr;</span>
    </div>
</div>