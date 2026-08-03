@props(['label', 'value', 'icon' => '⭐', 'color' => '#eff6ff'])

<div class="stat-card">
    <div class="stat-icon-wrapper" style="background-color: {{ $color }};">
        <span>{{ $icon }}</span>
    </div>
    <div>
        <div class="stat-value">{{ $value }}</div>
        <div class="stat-label">{{ $label }}</div>
    </div>
</div>
