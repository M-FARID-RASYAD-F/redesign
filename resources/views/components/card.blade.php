@props(['title' => null, 'badge' => null, 'icon' => null, 'subtitle' => null, 'theme' => 'primary'])

<div {{ $attributes->merge(['class' => 'custom-card theme-' . $theme]) }}>
    {{-- Header Card (Icon, Title, Subtitle, Badge) --}}
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

    {{-- Konten Body --}}
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
