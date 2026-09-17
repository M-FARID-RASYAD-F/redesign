{{-- resources/views/components/animated-tabs.blade.php --}}
@props([
    'tabs' => [
        [
            'id' => 'tab1',
            'label' => 'Tab 1',
            'title' => 'Tab 1',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
            'image' => null,
        ],
        [
            'id' => 'tab2',
            'label' => 'Tab 2',
            'title' => 'Tab 2',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
            'image' => null,
        ],
        [
            'id' => 'tab3',
            'label' => 'Tab 3',
            'title' => 'Tab 3',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
            'image' => null,
        ],
    ],
    'defaultTab' => null,
])

@php
    $active = $defaultTab ?? ($tabs[0]['id'] ?? null);
@endphp

<div class="animated-tabs-wrapper w-full flex flex-col gap-y-3" data-animated-tabs>
    {{-- Tabs Navigation Bar --}}
    <div class="tab-nav-bar bg-[#11111198] bg-opacity-50 backdrop-blur-md p-1.5 rounded-xl relative border border-white/10 shadow-lg">
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
                        src="{{ $tab['image'] ?? asset('images/sch1.jpeg') }}"
                        alt="{{ $tab['label'] ?? $tab['title'] ?? 'Fasilitas' }}"
                        class="tab-panel-img"
                        loading="lazy"
                        onerror="this.onerror=null; this.src='{{ asset('images/sch1.jpeg') }}';"
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
                                <span class="tab-location-pin">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                </span>
                                <div class="tab-location-body">
                                    <strong class="tab-location-label">Alamat Kampus:</strong>
                                    <span class="tab-location-address">{{ $tab['alamat'] }}</span>
                                </div>
                            </div>
                            @if(isset($tab['jam']))
                                <div class="tab-hours-row">
                                    <span class="tab-hours-icon">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    </span>
                                    <span class="tab-hours-text">{{ $tab['jam'] }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(isset($tab['features']) && is_array($tab['features']))
                        <div class="tab-features-grid">
                            @foreach($tab['features'] as $feat)
                                <div class="tab-feature-item">
                                    <span class="tab-feature-check">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                                    </span>
                                    <span class="tab-feature-text">{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(isset($tab['maps_url']) || isset($tab['wa_url']) || isset($tab['telepon']))
                        <div class="tab-action-buttons">
                            @if(isset($tab['maps_url']))
                                <a href="{{ $tab['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="btn-tab-action btn-tab-maps" title="Buka Petunjuk Arah di Google Maps">
                                    <span class="btn-tab-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                    </span>
                                    <span class="btn-tab-text">Petunjuk Arah (Maps)</span>
                                </a>
                            @endif
                            @if(isset($tab['wa_url']))
                                <a href="{{ $tab['wa_url'] }}" target="_blank" rel="noopener noreferrer" class="btn-tab-action btn-tab-wa" title="Hubungi WhatsApp Cabang">
                                    <span class="btn-tab-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
                                    </span>
                                    <span class="btn-tab-text">Hubungi Cabang</span>
                                </a>
                            @endif
                            @if(isset($tab['telepon']))
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', $tab['telepon']) }}" class="btn-tab-action btn-tab-tel" title="Hubungi Telepon Langsung">
                                    <span class="btn-tab-icon">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    </span>
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
