{{-- resources/views/components/animated-tabs.blade.php --}}
@props([
    'tabs' => [
        [
            'id' => 'tab1',
            'label' => 'Tab 1',
            'title' => 'Tab 1',
            'desc' => 'Konten contoh — isi properti "tabs" untuk data sebenarnya.',
            'image' => 'https://picsum.photos/seed/animated-tabs-1/1200/800',
        ],
        [
            'id' => 'tab2',
            'label' => 'Tab 2',
            'title' => 'Tab 2',
            'desc' => 'Konten contoh — isi properti "tabs" untuk data sebenarnya.',
            'image' => 'https://picsum.photos/seed/animated-tabs-2/1200/800',
        ],
        [
            'id' => 'tab3',
            'label' => 'Tab 3',
            'title' => 'Tab 3',
            'desc' => 'Konten contoh — isi properti "tabs" untuk data sebenarnya.',
            'image' => 'https://picsum.photos/seed/animated-tabs-3/1200/800',
        ],
    ],
    'defaultTab' => null,
])

@php
    $active = $defaultTab ?? ($tabs[0]['id'] ?? null);
@endphp

<div class="animated-tabs-wrapper" data-animated-tabs>
    {{-- Tabs Navigation Bar --}}
    <div class="tab-nav-bar">
        @foreach ($tabs as $tab)
            <button
                type="button"
                data-tab-id="{{ $tab['id'] }}"
                class="tab-btn"
                data-active="{{ $tab['id'] === $active ? 'true' : 'false' }}"
            >
                <span class="tab-highlight {{ $tab['id'] === $active ? '' : 'hidden' }}"></span>
                @if(!empty($tab['icon']))
                    <span class="tab-btn-icon">{{ $tab['icon'] }}</span>
                @endif
                <span class="tab-btn-label">{{ $tab['label'] ?? $tab['nama'] ?? $tab['title'] }}</span>
            </button>
        @endforeach
    </div>

    {{-- Tabs Content Panel Box --}}
    <div class="tab-content-box">
        @foreach ($tabs as $tab)
            <div
                data-tab-panel="{{ $tab['id'] }}"
                class="tab-panel {{ $tab['id'] === $active ? '' : 'hidden' }}"
            >
                <div class="tab-image-container">
                    <img
                        src="{{ $tab['image'] ?? 'https://picsum.photos/seed/animated-tabs-fallback/1200/800' }}"
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
                                <span class="tab-location-pin"><x-icon name="map-pin" /></span>
                                <div class="tab-location-body">
                                    <strong class="tab-location-label">Alamat Kampus:</strong>
                                    <span class="tab-location-address">{{ $tab['alamat'] }}</span>
                                </div>
                            </div>
                            @if(isset($tab['jam']))
                                <div class="tab-hours-row">
                                    <span class="tab-hours-icon"><x-icon name="clock" /></span>
                                    <span class="tab-hours-text">{{ $tab['jam'] }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if(isset($tab['features']) && is_array($tab['features']))
                        <div class="tab-features-grid">
                            @foreach($tab['features'] as $feat)
                                <div class="tab-feature-item">
                                    <span class="tab-feature-check"><x-icon name="check-circle" /></span>
                                    <span class="tab-feature-text">{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if(isset($tab['maps_url']) || isset($tab['wa_url']) || isset($tab['telepon']))
                        <div class="tab-action-buttons">
                            @if(isset($tab['maps_url']))
                                <a href="{{ $tab['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="btn-tab-action btn-tab-maps" title="Buka Petunjuk Arah di Google Maps">
                                    <span class="btn-tab-icon"><x-icon name="map-pin" /></span>
                                    <span class="btn-tab-text">Petunjuk Arah (Maps)</span>
                                </a>
                            @endif
                            @if(isset($tab['wa_url']))
                                <a href="{{ $tab['wa_url'] }}" target="_blank" rel="noopener noreferrer" class="btn-tab-action btn-tab-wa" title="Hubungi WhatsApp Cabang">
                                    <span class="btn-tab-icon"><x-icon name="whatsapp" /></span>
                                    <span class="btn-tab-text">Hubungi Cabang</span>
                                </a>
                            @endif
                            @if(isset($tab['telepon']))
                                <a href="tel:{{ preg_replace('/[^0-9]/', '', $tab['telepon']) }}" class="btn-tab-action btn-tab-tel" title="Hubungi Telepon Langsung">
                                    <span class="btn-tab-icon"><x-icon name="phone" /></span>
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
