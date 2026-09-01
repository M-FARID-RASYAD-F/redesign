{{-- resources/views/components/animated-tabs.blade.php --}}
@props([
    'tabs' => [
        [
            'id' => 'tab1',
            'label' => 'Tab 1',
            'title' => 'Tab 1',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
            'image' => 'https://images.unsplash.com/photo-1493552152660-f915ab47ae9d?q=80&w=3087&auto=format&fit=crop',
        ],
        [
            'id' => 'tab2',
            'label' => 'Tab 2',
            'title' => 'Tab 2',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
            'image' => 'https://images.unsplash.com/photo-1506543730435-e2c1d4553a84?q=80&w=2362&auto=format&fit=crop',
        ],
        [
            'id' => 'tab3',
            'label' => 'Tab 3',
            'title' => 'Tab 3',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
            'image' => 'https://images.unsplash.com/photo-1522428938647-2baa7c899f2f?q=80&w=2000&auto=format&fit=crop',
        ],
    ],
    'defaultTab' => null,
])

@php
    $active = $defaultTab ?? ($tabs[0]['id'] ?? null);
@endphp

<div class="animated-tabs-wrapper w-full flex flex-col gap-y-3" data-animated-tabs>
    {{-- Tabs Navigation Bar --}}
    <div class="tab-nav-bar flex gap-2 flex-wrap bg-[#11111198] bg-opacity-50 backdrop-blur-md p-1.5 rounded-xl relative border border-white/10 shadow-lg">
        @foreach ($tabs as $tab)
            <button
                type="button"
                data-tab-id="{{ $tab['id'] }}"
                class="tab-btn relative px-4 py-2 text-sm font-semibold rounded-lg text-white/80 hover:text-white outline-none transition-colors cursor-pointer flex items-center gap-2"
                data-active="{{ $tab['id'] === $active ? 'true' : 'false' }}"
            >
                <span class="tab-highlight absolute inset-0 bg-[#00B4D8]/25 border border-[#00B4D8]/60 shadow-[0_0_20px_rgba(0,180,216,0.35)] backdrop-blur-sm !rounded-lg {{ $tab['id'] === $active ? '' : 'hidden' }}"></span>
                @if(isset($tab['icon']))
                    <span class="tab-btn-icon relative z-10 text-base">{{ $tab['icon'] }}</span>
                @endif
                <span class="tab-btn-label relative z-10">{{ $tab['label'] ?? $tab['nama'] ?? $tab['title'] }}</span>
            </button>
        @endforeach
    </div>

    {{-- Tabs Content Panel Box --}}
    <div class="tab-content-box p-5 md:p-6 bg-[#11111198] shadow-[0_16px_40px_rgba(0,0,0,0.4)] text-white bg-opacity-60 backdrop-blur-md rounded-2xl border border-white/10 min-h-[300px] h-full relative overflow-hidden">
        @foreach ($tabs as $tab)
            <div
                data-tab-panel="{{ $tab['id'] }}"
                class="tab-panel grid grid-cols-1 md:grid-cols-2 gap-6 w-full h-full items-center {{ $tab['id'] === $active ? '' : 'hidden' }}"
            >
                <div class="tab-image-container relative rounded-xl overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.5)] border border-white/10 group">
                    <img
                        src="{{ $tab['image'] ?? 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=1200&auto=format&fit=crop' }}"
                        alt="{{ $tab['label'] ?? $tab['title'] ?? 'Fasilitas' }}"
                        class="tab-panel-img w-full h-56 md:h-72 object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy"
                    />
                    <div class="tab-image-overlay absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    @if(isset($tab['icon']) || isset($tab['label']))
                        <div class="tab-image-badge absolute bottom-3 left-3 flex items-center gap-2 bg-black/65 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-cyan-300 border border-cyan-500/30">
                            <span>{{ $tab['icon'] ?? '✨' }}</span>
                            <span>{{ $tab['label'] ?? $tab['title'] }}</span>
                        </div>
                    @endif
                </div>

                <div class="tab-info-container flex flex-col gap-y-3 justify-center">
                    <div class="tab-badge-tag">
                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold uppercase tracking-wider rounded-md bg-[#00B4D8]/20 text-[#38bdf8] border border-[#00B4D8]/30">
                            🏛️ Sarana Unggulan
                        </span>
                    </div>
                    <h2 class="tab-title text-2xl md:text-3xl font-bold text-white tracking-tight leading-snug">
                        {{ $tab['title'] ?? $tab['nama'] }}
                    </h2>
                    <p class="tab-desc text-sm md:text-base text-gray-200 leading-relaxed">
                        {{ $tab['desc'] ?? $tab['deskripsi'] }}
                    </p>

                    @if(isset($tab['features']) && is_array($tab['features']))
                        <div class="tab-features-grid grid grid-cols-2 gap-2 pt-3 border-t border-white/10 mt-1">
                            @foreach($tab['features'] as $feat)
                                <div class="flex items-center gap-2 text-xs font-medium text-gray-300">
                                    <span class="text-emerald-400 font-bold">✓</span>
                                    <span>{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
