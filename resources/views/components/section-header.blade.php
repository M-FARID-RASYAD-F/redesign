@props(['tag' => null, 'title', 'subtitle' => null])

<div class="section-header">
    @if($tag)
        <span class="section-tag">{{ $tag }}</span>
    @endif
    <h2 class="section-title">{{ $title }}</h2>
    @if($subtitle)
        <p class="section-subtitle">{{ $subtitle }}</p>
    @endif
</div>
