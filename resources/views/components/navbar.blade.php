{{-- resources/views/components/navbar.blade.php --}}
@props([
    'active' => 'perpustakaan'
])

<header class="navbar" id="mainNavbar">
    {{-- ── Desktop Bar ── --}}
    <div class="navbar-container">

        {{-- 1. Kapsul Kiri: Brand & Logo Sekolah --}}
        <div class="navbar-capsule navbar-left">
            <a href="{{ route('home') }}" class="navbar-brand">
                <div class="brand-icon">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo PKBM Tahfizh At-Tamam" class="brand-logo-img">
                </div>
                <div class="brand-text">
                    <span class="brand-text-main">PKBM Tahfizh At-Tamam</span>
                    <span class="brand-text-sub">Sekolah Unggulan Berkarakter</span>
                </div>
            </a>
        </div>

        {{-- 2. Kapsul Tengah: Menu Navigasi Utama (Rounded Container) --}}
        <div class="navbar-capsule navbar-center">
            <div id="react-main-nav" class="react-main-nav-wrapper">
                <nav class="expandable-nav-tabs" aria-label="Navigasi Utama">
                    {{-- Home --}}
                    <a href="{{ route('home') }}#beranda" class="expandable-tab-btn {{ Request::routeIs('home') ? 'active' : '' }}" data-section="beranda" aria-label="Beranda">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        <span class="tab-label">Beranda</span>
                    </a>

                    {{-- Jenjang / Akademik --}}
                    <a href="{{ route('home') }}#jenjang" class="expandable-tab-btn" data-section="jenjang" aria-label="Jenjang">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-.838L12.83 3.18a2 2 0 0 0-1.66 0L2.6 10.084a1 1 0 0 0 0 1.832l8.57 6.908a2 2 0 0 0 1.66 0l8.57-6.908a1 1 0 0 0 .02-.994z"/><path d="M6 12.5v5a6 3 0 0 0 12 0v-5"/></svg>
                        <span class="tab-label">Jenjang</span>
                    </a>

                    {{-- Cabang Kampus --}}
                    <a href="{{ route('home') }}#cabang" class="expandable-tab-btn" data-section="cabang" aria-label="Cabang">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                        <span class="tab-label">Cabang</span>
                    </a>

                    {{-- Fasilitas --}}
                    <a href="{{ route('home') }}#fasilitas" class="expandable-tab-btn" data-section="fasilitas" aria-label="Fasilitas">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16M9 9h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1"/></svg>
                        <span class="tab-label">Fasilitas</span>
                    </a>

                    {{-- Berita --}}
                    <a href="{{ route('home') }}#berita" class="expandable-tab-btn" data-section="berita" aria-label="Berita">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                        <span class="tab-label">Berita</span>
                    </a>

                    {{-- Perpustakaan (ACTIVE MENU) --}}
                    <a href="{{ route('perpus.index') }}" class="expandable-tab-btn {{ Request::is('perpustakaan*') ? 'active' : '' }}" data-section="perpustakaan" aria-label="Perpustakaan">
                        <svg class="tab-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10"/></svg>
                        <span class="tab-label">Perpustakaan</span>
                    </a>

                    <div class="expandable-tab-separator" aria-hidden="true"></div>

                    {{-- PPDB Online --}}
                    <a href="{{ route('ppdb.index') }}" class="expandable-tab-btn {{ Request::is('ppdb*') ? 'active' : '' }}" data-section="ppdb" aria-label="PPDB Online">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                        <span class="tab-label">PPDB Online</span>
                    </a>
                </nav>
            </div>
        </div>

        {{-- 3. Kapsul Kanan: Search, Dark Mode, Admin & Logout --}}
        <div class="navbar-capsule navbar-right">
            {{-- Tombol Spotlight Quick Search --}}
            <button class="nav-search-trigger-btn" type="button" onclick="openSpotlight()" aria-label="Buka Pencarian Cepat" title="Cari di website">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span class="nav-search-btn-label">Cari</span>
            </button>

            {{-- Tombol Toggle Theme (Dark / White) --}}
            <button class="nav-theme-toggle" id="themeToggleBtn" type="button" aria-label="Ganti Tema Tampilan" title="Ganti Tema (Dark / White Mode)">
                <span class="theme-icon theme-icon-sun" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                </span>
                <span class="theme-icon theme-icon-moon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                </span>
            </button>

            <div class="nav-auth-desktop">
                @auth
                    {{-- Badge / Tombol Admin --}}
                    <a href="{{ auth()->user()->dashboard_url }}" class="nav-admin-link">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span class="nav-link-text">Admin</span>
                    </a>

                    {{-- Tombol Logout --}}
                    <a href="{{ route('logout') }}" class="nav-logout-link">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        <span class="nav-link-text">Logout</span>
                    </a>
                @else
                    {{-- Tombol Login (Guest) --}}
                    <a href="{{ route('login') }}" class="nav-btn-search">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><circle cx="7.5" cy="15.5" r="5.5"/><path d="m21 2-9.6 9.6"/><path d="m15.5 7.5 3 3L22 7l-3-3"/></svg>
                        <span class="nav-link-text">Login</span>
                    </a>
                @endauth
            </div>

            {{-- Tombol Menu Mobile --}}
            <button class="nav-btn-menu" id="navToggle" type="button" aria-label="Buka Menu Navigasi" aria-expanded="false">
                <svg id="iconHamburger" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <line x1="4" y1="12" x2="20" y2="12"/>
                    <line x1="4" y1="18" x2="20" y2="18"/>
                </svg>
                <svg id="iconClose" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="display:none;">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Backdrop Overlay saat Menu Mobile Terbuka --}}
    <div class="nav-mobile-backdrop" id="navMobileBackdrop"></div>

    {{-- Mobile Panel Sheet --}}
    <div class="nav-mobile-panel" id="navMobilePanel">
        <div class="nav-mobile-inner">
            <div class="nav-mobile-header">
                <div class="nav-mobile-brand-pill">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Resmi PKBM Tahfizh At-Tamam" class="nav-mobile-pill-logo">
                    <span class="nav-mobile-pill-text">PKBM Tahfizh At-Tamam</span>
                </div>
                <span class="nav-mobile-status-badge">Edu Portal</span>
            </div>

            <div class="nav-mobile-nav-list">
                <a href="{{ route('home') }}#beranda" class="nav-mobile-link {{ Request::routeIs('home') ? 'active' : '' }}" data-section="beranda">
                    <span class="nav-mobile-icon-box">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    </span>
                    <span class="nav-mobile-link-text">Beranda</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('home') }}#jenjang" class="nav-mobile-link" data-section="jenjang">
                    <span class="nav-mobile-icon-box">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-.838L12.83 3.18a2 2 0 0 0-1.66 0L2.6 10.084a1 1 0 0 0 0 1.832l8.57 6.908a2 2 0 0 0 1.66 0l8.57-6.908a1 1 0 0 0 .02-.994z"/><path d="M6 12.5v5a6 3 0 0 0 12 0v-5"/></svg>
                    </span>
                    <span class="nav-mobile-link-text">Jenjang Pendidikan</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('home') }}#cabang" class="nav-mobile-link" data-section="cabang">
                    <span class="nav-mobile-icon-box">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                    </span>
                    <span class="nav-mobile-link-text">Cabang Kampus</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('home') }}#fasilitas" class="nav-mobile-link" data-section="fasilitas">
                    <span class="nav-mobile-icon-box">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16M9 9h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1"/></svg>
                    </span>
                    <span class="nav-mobile-link-text">Galeri Fasilitas</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('home') }}#berita" class="nav-mobile-link" data-section="berita">
                    <span class="nav-mobile-icon-box">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                    </span>
                    <span class="nav-mobile-link-text">Warta &amp; Berita</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('perpus.index') }}" class="nav-mobile-link {{ Request::is('perpustakaan*') ? 'active' : '' }}" data-section="perpustakaan">
                    <span class="nav-mobile-icon-box">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10"/></svg>
                    </span>
                    <span class="nav-mobile-link-text">Perpustakaan Digital</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('ppdb.index') }}" class="nav-mobile-link {{ Request::is('ppdb*') ? 'active' : '' }}" data-section="ppdb">
                    <span class="nav-mobile-icon-box">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    </span>
                    <span class="nav-mobile-link-text">PPDB Online Mandiri</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
            </div>
        </div>
    </div>
</header>
