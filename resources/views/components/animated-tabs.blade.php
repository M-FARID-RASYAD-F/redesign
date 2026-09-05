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
                @if(!empty($tab['icon']))
                    <span class="tab-btn-icon relative z-10 text-base">{{ $tab['icon'] }}</span>
                @endif
                <span class="tab-btn-label relative z-10">{{ $tab['label'] ?? $tab['nama'] ?? $tab['title'] }}</span>
            </button>
        @endforeach
    </div>

    {{-- Tabs Content Panel Box --}}
    <div class="tab-content-box shadow-[0_16px_40px_rgba(0,0,0,0.4)] text-white relative overflow-hidden">
        @foreach ($tabs as $tab)
            <div
                data-tab-panel="{{ $tab['id'] }}"
                class="tab-panel {{ $tab['id'] === $active ? '' : 'hidden' }}"
            >
                <div class="tab-image-container group">
                    <img
                        src="{{ $tab['image'] ?? 'https://images.unsplash.com/photo-1562774053-701939374585?q=80&w=1200&auto=format&fit=crop' }}"
                        alt="{{ $tab['label'] ?? $tab['title'] ?? 'Fasilitas' }}"
                        class="tab-panel-img"
                        loading="lazy"
                    />
                    <div class="tab-image-overlay"></div>
                </div>

                <div class="tab-info-container">
                    <div class="tab-badge-tag">
                        <span>{{ $tab['tag'] ?? 'Sarana Unggulan' }}</span>
                    </div>

                    <h2 class="tab-title">
                        {{ $tab['title'] ?? $tab['nama'] }}
                    </h2>

                    <p class="tab-desc">
                        {{ $tab['desc'] ?? $tab['deskripsi'] }}
                    </p>

                    @if(isset($tab['alamat']))
                        <div class="tab-location-card">
                            <div class="tab-location-row">
                                <span class="tab-location-pin">📍</span>
                                <div class="tab-location-body">
                                    <strong class="tab-location-label">Alamat Kampus:</strong>
                                    <span class="tab-location-address">{{ $tab['alamat'] }}</span>
                                </div>
                            </div>
                            @if(isset($tab['jam']))
                                <div class="tab-hours-row">
                                    <span class="tab-hours-icon">🕒</span>
                                    <span class="tab-hours-text">{{ $tab['jam'] }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(isset($tab['features']) && is_array($tab['features']))
                        <div class="tab-features-grid">
                            @foreach($tab['features'] as $feat)
                                <div class="tab-feature-item">
                                    <span class="tab-feature-check">✓</span>
                                    <span class="tab-feature-text">{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(isset($tab['maps_url']) || isset($tab['wa_url']) || isset($tab['telepon']))
                        <div class="tab-action-buttons">
                            @if(isset($tab['maps_url']))
                                <a href="{{ $tab['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="btn-tab-action btn-tab-maps" title="Buka Petunjuk Arah di Google Maps">
                                    <span class="btn-tab-icon">📍</span>
                                    <span class="btn-tab-text">Petunjuk Arah (Maps)</span>
                                </a>
                            @endif
                            @if(isset($tab['wa_url']))
                                <a href="{{ $tab['wa_url'] }}" target="_blank" rel="noopener noreferrer" class="btn-tab-action btn-tab-wa" title="Hubungi WhatsApp Cabang">
                                    <span class="btn-tab-icon">💬</span>
                                    <span class="btn-tab-text">Hubungi Cabang</span>
                                </a>
                            @endif
                            @if(isset($tab['telepon']))
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', $tab['telepon']) }}" class="btn-tab-action btn-tab-tel" title="Hubungi Telepon Langsung">
                                    <span class="btn-tab-icon">📞</span>
                                    <span class="btn-tab-text">{{ $tab['telepon'] }}</span>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
