@props(['label', 'value', 'icon' => 'check-circle', 'color' => 'var(--primary-light)'])

<div class="stat-card">
    <div class="stat-icon-wrapper" style="background-color: {{ $color }};">
        <x-app-icon :name="$icon" />
    </div>
    <div>
        <div class="stat-value">{{ $value }}</div>
        <div class="stat-label">{{ $label }}</div>
    </div>
</div>
