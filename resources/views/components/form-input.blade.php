{{-- resources/views/components/form-input.blade.php --}}
@props([
    'name',
    'id' => null,
    'label' => '',
    'type' => 'text',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'helper' => null,
    'icon' => null,
    'rows' => 3,
])

@php
    $inputId = $id ?? $name;
    $hasError = $errors->has($name);
    $resolvedValue = old($name, $value);
@endphp

<div class="f w-full">
    @if($label)
        <label for="{{ $inputId }}" class="flex items-center gap-1 text-[13px] font-medium text-white">
            <span>{{ $label }}</span>
            @if($required)
                <span class="text-rose-400 font-bold" aria-hidden="true">*</span>
            @else
                <span class="text-xs font-normal text-slate-400 ml-0.5">(opsional)</span>
            @endif
        </label>
    @endif

    <div class="ip {{ $hasError ? 'has-error' : '' }}">
        @if($icon === 'user')
            <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
        @elseif($icon === 'phone' || $icon === 'whatsapp')
            <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
            </svg>
        @elseif($icon === 'building' || $icon === 'home')
            <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/>
                <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/>
                <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/>
                <path d="M10 6h4M10 10h4M10 14h4M10 18h4"/>
            </svg>
        @elseif($icon === 'map-pin')
            <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                <circle cx="12" cy="10" r="3"/>
            </svg>
        @else
            <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
        @endif

        @if($type === 'textarea')
            <textarea
                name="{{ $name }}"
                id="{{ $inputId }}"
                rows="{{ $rows }}"
                placeholder="{{ $placeholder }}"
                @if($required) required @endif
                aria-invalid="{{ $hasError ? 'true' : 'false' }}"
                @if($hasError) aria-describedby="{{ $inputId }}_error" @endif
            >{{ $resolvedValue }}</textarea>
        @else
            <input
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $inputId }}"
                value="{{ $resolvedValue }}"
                placeholder="{{ $placeholder }}"
                @if($required) required @endif
                @if($type === 'tel') inputmode="tel" @endif
                aria-invalid="{{ $hasError ? 'true' : 'false' }}"
                @if($hasError) aria-describedby="{{ $inputId }}_error" @endif
            >
        @endif
    </div>

    @error($name)
        <p id="{{ $inputId }}_error" class="text-xs text-rose-400 font-medium" role="alert">
            {{ $message }}
        </p>
    @else
        @if($helper)
            <small class="text-xs text-slate-400">{{ $helper }}</small>
        @endif
    @enderror
</div>
