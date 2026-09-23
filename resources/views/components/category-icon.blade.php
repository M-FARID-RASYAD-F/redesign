@props([
    'icon' => null,
    'category' => null,
    'size' => 16,
    'class' => '',
    'strokeWidth' => 2,
])

@php
    $key = strtolower(trim((string)($icon ?? '')));
    $slug = $category?->slug ?? '';
    $name = strtolower($category?->name ?? '');

    // Cek apakah key berupa raw SVG
    $isRawSvg = str_starts_with($key, '<svg');

    // Normalisasi jenis icon berdasarkan nama, slug, atau identifier
    $iconType = match (true) {
        $isRawSvg => 'raw_svg',
        in_array($key, ['book-open', 'quran', 'islam', 'tahfizh', 'agama', '🕌', '📖']) 
            || str_contains($slug, 'agama') 
            || str_contains($slug, 'tahfizh') 
            || str_contains($name, 'agama') 
            || str_contains($name, 'tahfizh') => 'book-open',
        in_array($key, ['laptop', 'code', 'komputer', 'teknologi', 'it', '💻', '🖥️']) 
            || str_contains($slug, 'teknologi') 
            || str_contains($slug, 'komputer') 
            || str_contains($name, 'teknologi') 
            || str_contains($name, 'komputer') => 'laptop',
        in_array($key, ['microscope', 'science', 'sains', 'matematika', 'ipa', '🔬', '🧪', '📐']) 
            || str_contains($slug, 'sains') 
            || str_contains($slug, 'matematika') 
            || str_contains($name, 'sains') 
            || str_contains($name, 'matematika') => 'microscope',
        in_array($key, ['book', 'books', 'sastra', 'fiksi', 'literasi', '📚']) 
            || str_contains($slug, 'sastra') 
            || str_contains($slug, 'fiksi') 
            || str_contains($name, 'sastra') 
            || str_contains($name, 'fiksi') => 'book',
        in_array($key, ['landmark', 'sejarah', 'budaya', 'sosial', 'museum', '🏛️', '🏛']) 
            || str_contains($slug, 'sejarah') 
            || str_contains($slug, 'sosial') 
            || str_contains($name, 'sejarah') 
            || str_contains($name, 'sosial') => 'landmark',
        in_array($key, ['trending-up', 'vokasi', 'kewirausahaan', 'bisnis', 'ekonomi', '📈', '🚀', '💼']) 
            || str_contains($slug, 'vokasi') 
            || str_contains($slug, 'kewirausahaan') 
            || str_contains($name, 'vokasi') 
            || str_contains($name, 'kewirausahaan') => 'trending-up',
        default => 'default-book'
    };
@endphp

@if($iconType === 'raw_svg')
    {!! $key !!}
@elseif($iconType === 'book-open')
    {{-- Lucide BookOpen SVG Line Icon (Agama Islam, Tahfizh & Al-Qur'an) --}}
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}" aria-hidden="true" {{ $attributes }}>
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
    </svg>
@elseif($iconType === 'laptop')
    {{-- Lucide Laptop SVG Line Icon (Teknologi Informasi & Komputer) --}}
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}" aria-hidden="true" {{ $attributes }}>
        <path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"/>
    </svg>
@elseif($iconType === 'microscope')
    {{-- Lucide Microscope SVG Line Icon (Sains & Matematika) --}}
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}" aria-hidden="true" {{ $attributes }}>
        <path d="M6 18h8"/>
        <path d="M3 22h18"/>
        <path d="M14 22a7 7 0 1 0 0-14h-1"/>
        <path d="M9 14h2"/>
        <path d="M9 12a2 2 0 0 1-2-2V6h6v4a2 2 0 0 1-2 2Z"/>
        <path d="M12 6V3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3"/>
    </svg>
@elseif($iconType === 'book')
    {{-- Lucide Book SVG Line Icon (Sastra, Fiksi & Literasi) --}}
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}" aria-hidden="true" {{ $attributes }}>
        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
    </svg>
@elseif($iconType === 'landmark')
    {{-- Lucide Landmark SVG Line Icon (Sejarah & Sosial Budaya) --}}
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}" aria-hidden="true" {{ $attributes }}>
        <line x1="3" x2="21" y1="22" y2="22"/>
        <line x1="6" x2="6" y1="18" y2="11"/>
        <line x1="10" x2="10" y1="18" y2="11"/>
        <line x1="14" x2="14" y1="18" y2="11"/>
        <line x1="18" x2="18" y1="18" y2="11"/>
        <polygon points="12 2 20 7 4 7"/>
    </svg>
@elseif($iconType === 'trending-up')
    {{-- Lucide TrendingUp SVG Line Icon (Kewirausahaan & Vokasi) --}}
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}" aria-hidden="true" {{ $attributes }}>
        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/>
        <polyline points="16 7 22 7 22 13"/>
    </svg>
@else
    {{-- Lucide Book (Default Fallback) --}}
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $strokeWidth }}" stroke-linecap="round" stroke-linejoin="round" class="{{ $class }}" aria-hidden="true" {{ $attributes }}>
        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
    </svg>
@endif
