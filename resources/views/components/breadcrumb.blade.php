{{-- resources/views/components/breadcrumb.blade.php --}}
@props([
    'book' => null,
    'title' => null,
    'current' => 'Form pinjam',
    'backUrl' => null,
    'backText' => 'Kembali ke detail buku',
])

@php
    $bookTitle = $title ?? ($book ? $book->title : 'Buku');
    $resolvedBackUrl = $backUrl ?? ($book ? route('perpus.show', $book->id) : route('perpus.index'));
@endphp

<div class="mb-5 sm:mb-6 flex flex-wrap items-center justify-between gap-3 text-xs sm:text-[13px] text-slate-400 pb-1" aria-label="Breadcrumb">
    <nav class="flex items-center gap-1.5 flex-wrap min-w-0" aria-label="Jalur navigasi">
        <a href="{{ route('home') }}" class="breadcrumb-link hover:text-cyan-300 text-slate-400 transition-colors">Beranda</a>
        <span class="text-slate-600" aria-hidden="true">/</span>
        <a href="{{ route('perpus.index') }}" class="breadcrumb-link hover:text-cyan-300 text-slate-400 transition-colors">Perpustakaan</a>
        <span class="text-slate-600" aria-hidden="true">/</span>
        @if($book)
            <a href="{{ route('perpus.show', $book->id) }}" class="breadcrumb-link hover:text-cyan-300 text-slate-300 transition-colors truncate max-w-[150px] sm:max-w-[240px]" title="{{ $bookTitle }}">
                {{ Str::limit($bookTitle, 22) }}
            </a>
            <span class="text-slate-600" aria-hidden="true">/</span>
        @endif
        <span class="text-white font-medium" aria-current="page">{{ $current }}</span>
    </nav>

    <a href="{{ $resolvedBackUrl }}" 
       class="btn-breadcrumb-back inline-flex items-center gap-2 px-3.5 sm:px-4 py-2 rounded-xl text-xs sm:text-[13px] font-semibold transition-all duration-200 shadow-sm hover:-translate-y-0.5 shrink-0"
       style="padding: 7px 16px; border-radius: 10px; text-decoration: none;">
        <svg class="w-4 h-4 shrink-0 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
        <span>{{ $backText }}</span>
    </a>
</div>
