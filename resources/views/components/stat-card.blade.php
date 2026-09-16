@props([
    'label',
    'value',
    'icon' => 'users',
    'color' => '#00B4D8',
    'bg' => null,
    'border' => null,
])

@php
    $labelLower = strtolower($label);

    // Menentukan warna aksen neon khas navigasi jika tidak ditentukan
    $accentColor = match(true) {
        str_contains($labelLower, 'siswa') || in_array($icon, ['users', '👥', '👨‍🎓']) => '#00B4D8',
        str_contains($labelLower, 'guru') || in_array($icon, ['teachers', '👩‍🏫']) => '#10b981',
        str_contains($labelLower, 'jenjang') || in_array($icon, ['school', '🏫']) => '#f59e0b',
        str_contains($labelLower, 'serapan') || str_contains($labelLower, 'prestasi') || in_array($icon, ['rocket', 'trending-up', '🚀']) => '#a855f7',
        default => $color ?? '#00B4D8'
    };

    $wrapperBg = $bg ?? match($accentColor) {
        '#00B4D8' => 'rgba(0, 180, 216, 0.14)',
        '#10b981' => 'rgba(16, 185, 129, 0.14)',
        '#f59e0b' => 'rgba(245, 158, 11, 0.14)',
        '#a855f7' => 'rgba(168, 85, 247, 0.14)',
        default => 'rgba(0, 180, 216, 0.14)'
    };

    $wrapperBorder = $border ?? match($accentColor) {
        '#00B4D8' => '1.5px solid rgba(0, 180, 216, 0.45)',
        '#10b981' => '1.5px solid rgba(16, 185, 129, 0.45)',
        '#f59e0b' => '1.5px solid rgba(245, 158, 11, 0.45)',
        '#a855f7' => '1.5px solid rgba(168, 85, 247, 0.45)',
        default => '1.5px solid rgba(0, 180, 216, 0.45)'
    };
@endphp

<div class="stat-card">
    <div class="stat-icon-wrapper" style="background: {{ $wrapperBg }}; border: {{ $wrapperBorder }}; color: {{ $accentColor }};">
        @if(in_array($icon, ['users', '👥', '👨‍🎓']) || str_contains($labelLower, 'siswa'))
            {{-- Lucide Users SVG Line Icon (Identik dengan Style Navigasi) --}}
            <svg class="stat-svg-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        @elseif(in_array($icon, ['teachers', 'guru', '👩‍🏫']) || str_contains($labelLower, 'guru'))
            {{-- Lucide GraduationCap / Teacher SVG Line Icon --}}
            <svg class="stat-svg-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21.42 10.922a1 1 0 0 0-.019-.838L12.83 3.18a2 2 0 0 0-1.66 0L2.6 10.084a1 1 0 0 0 0 1.832l8.57 6.908a2 2 0 0 0 1.66 0l8.57-6.908a1 1 0 0 0 .02-.994z"/>
                <path d="M6 12.5v5a6 3 0 0 0 12 0v-5"/>
            </svg>
        @elseif(in_array($icon, ['school', 'jenjang', '🏫']) || str_contains($labelLower, 'jenjang'))
            {{-- Lucide Building2 SVG Line Icon (Identik dengan Ikon Cabang Navigasi) --}}
            <svg class="stat-svg-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
                <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
                <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
                <path d="M10 6h4"/>
                <path d="M10 10h4"/>
                <path d="M10 14h4"/>
                <path d="M10 18h4"/>
            </svg>
        @elseif(in_array($icon, ['rocket', 'trending-up', '🚀', 'prestasi']) || str_contains($labelLower, 'serapan') || str_contains($labelLower, 'prestasi'))
            {{-- Lucide TrendingUp SVG Line Icon --}}
            <svg class="stat-svg-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/>
                <polyline points="16 7 22 7 22 13"/>
            </svg>
        @elseif(Str::startsWith(trim($icon), '<svg'))
            {!! $icon !!}
        @else
            <span>{{ $icon }}</span>
        @endif
    </div>
    <div class="stat-info">
        <div class="stat-value">{{ $value }}</div>
        <div class="stat-label">{{ $label }}</div>
    </div>
</div>
