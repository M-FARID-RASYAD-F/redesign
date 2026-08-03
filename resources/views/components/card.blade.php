@props(['title' => null, 'badge' => null, 'icon' => null, 'subtitle' => null])

<div class="custom-card">
    @if($title || $badge)
        <div class="card-header">
            <div>
                @if($icon) <span style="font-size: 1.5rem; margin-right: 6px; vertical-align: middle;">{{ $icon }}</span> @endif
                <h3 class="card-title" style="display: inline-block; vertical-align: middle;">{{ $title }}</h3>
                @if($subtitle)
                    <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">{{ $subtitle }}</div>
                @endif
            </div>
            @if($badge)
                <span class="badge">{{ $badge }}</span>
            @endif
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>
</div>