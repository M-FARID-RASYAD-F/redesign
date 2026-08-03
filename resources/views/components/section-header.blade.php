@props(['tag', 'title', 'subtitle' => null])

<div class="section-header">
    <span class="section-tag">{{ $tag }}</span>
    <h2 class="section-title">{{ $title }}</h2>
    @if($subtitle)
        <p class="section-subtitle">{{ $subtitle }}</p>
    @endif
</div>
