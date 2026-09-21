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

        {{-- 2. Kapsul Tengah: Menu Navigasi Utama (Expandable Tabs) --}}
        <div class="navbar-capsule navbar-center">
            <div id="react-main-nav" class="react-main-nav-wrapper">
                <nav class="expandable-nav-tabs" aria-label="Navigasi Utama">
                    <a href="{{ route('home') }}#beranda" class="expandable-tab-btn {{ Request::routeIs('home') ? 'active' : '' }}" data-section="beranda" aria-label="Beranda">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        <span class="tab-label">Beranda</span>
                    </a>
                    <a href="{{ route('home') }}#jenjang" class="expandable-tab-btn" data-section="jenjang" aria-label="Jenjang">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.42 10.922a1 1 0 0 0-.019-.838L12.83 3.18a2 2 0 0 0-1.66 0L2.6 10.084a1 1 0 0 0 0 1.832l8.57 6.908a2 2 0 0 0 1.66 0l8.57-6.908a1 1 0 0 0 .02-.994z"/><path d="M6 12.5v5a6 3 0 0 0 12 0v-5"/></svg>
                        <span class="tab-label">Jenjang</span>
                    </a>
                    <a href="{{ route('home') }}#cabang" class="expandable-tab-btn" data-section="cabang" aria-label="Cabang">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                        <span class="tab-label">Cabang</span>
                    </a>
                    <a href="{{ route('berita.index') }}" class="expandable-tab-btn {{ Request::is('berita*') ? 'active' : '' }}" data-section="berita" aria-label="Berita">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                        <span class="tab-label">Berita</span>
                    </a>
                    <div class="expandable-tab-separator" aria-hidden="true"></div>
                    <a href="{{ route('ppdb.index') }}" class="expandable-tab-btn {{ Request::is('ppdb*') ? 'active' : '' }}" data-section="ppdb" aria-label="PPDB Online">
                        <svg class="tab-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                        <span class="tab-label">PPDB Online</span>
                    </a>
                </nav>
            </div>
        </div>

        {{-- 3. Kapsul Kanan: Theme Switcher, Login / Admin & Menu Mobile --}}
        <div class="navbar-capsule navbar-right">
            {{-- Tombol Spotlight Quick Search (Ctrl+K) --}}
            <button class="nav-search-trigger-btn" type="button" onclick="openSpotlight()" aria-label="Buka Pencarian Cepat (Ctrl+K)" title="Cari di website (Ctrl+K)">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span class="nav-search-btn-label">Cari</span>
                <kbd class="nav-search-badge">⌘K</kbd>
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
                    <a href="{{ route('admin.dashboard') }}" class="nav-admin-link">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span class="nav-link-text">Admin</span>
                    </a>
                    <a href="{{ route('logout') }}" class="nav-logout-link">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        <span class="nav-link-text">Logout</span>
                    </a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="nav-btn-search">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><circle cx="7.5" cy="15.5" r="5.5"/><path d="m21 2-9.6 9.6"/><path d="m15.5 7.5 3 3L22 7l-3-3"/></svg>
                        <span class="nav-link-text">Login</span>
                    </a>
                @endguest
            </div>

            {{-- Tombol Menu Mobile — ikon hamburger minimalist tanpa teks --}}
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

    {{-- ── Backdrop Overlay saat Menu Mobile Terbuka ── --}}
    <div class="nav-mobile-backdrop" id="navMobileBackdrop"></div>

    {{-- ── Mobile Panel Sheet ── --}}
    <div class="nav-mobile-panel" id="navMobilePanel">
        <div class="nav-mobile-inner">
            {{-- Header Mini Panel --}}
            <div class="nav-mobile-header">
                <div class="nav-mobile-brand-pill">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Resmi PKBM Tahfizh At-Tamam" class="nav-mobile-pill-logo">
                    <span class="nav-mobile-pill-text">PKBM Tahfizh At-Tamam</span>
                </div>
                <span class="nav-mobile-status-badge">Edu Portal</span>
            </div>

            {{-- Quick Search Input Button (Mobile) --}}
            <div style="padding: 10px 16px 4px;">
                <button type="button" onclick="openSpotlight(); const p = document.getElementById('navMobilePanel'); if(p) p.classList.remove('active'); const b = document.getElementById('navMobileBackdrop'); if(b) b.classList.remove('active');" style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; background: rgba(0, 180, 216, 0.12); border: 1px solid rgba(0, 180, 216, 0.35); border-radius: 12px; color: #cbd5e1; cursor: pointer; font-size: 0.86rem; font-family: inherit;">
                    <span style="display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Cari informasi sekolah...</span>
                    </span>
                    <kbd style="background: rgba(0, 180, 216, 0.2); border-radius: 4px; padding: 2px 6px; font-size: 0.7rem; color: #38bdf8; font-weight: 700;">Cari</kbd>
                </button>
            </div>

            {{-- 1. Navigasi Halaman Utama --}}
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
                    <span class="nav-mobile-link-text">Cabang Sekolah</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('berita.index') }}" class="nav-mobile-link {{ Request::is('berita*') ? 'active' : '' }}" data-section="berita">
                    <span class="nav-mobile-icon-box">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                    </span>
                    <span class="nav-mobile-link-text">Berita & Informasi</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
            </div>

            {{-- 2. Kartu Layanan PPDB Online --}}
            <div class="nav-mobile-ppdb-box">
                <a href="{{ route('ppdb.index') }}" class="nav-mobile-cta {{ Request::is('ppdb*') ? 'active' : '' }}" data-section="ppdb">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    <span class="nav-cta-text">Daftar PPDB Online</span>
                </a>
                <a href="{{ route('ppdb.tracking') }}" class="nav-mobile-sublink">
                    <span class="nav-sublink-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </span>
                    <span class="nav-sublink-text">Cek Status Pendaftaran</span>
                    <span class="nav-sublink-badge">Online</span>
                </a>
            </div>

            {{-- 3. Utility & Akun Footer --}}
            <div class="nav-mobile-footer-row">
                <button class="nav-mobile-theme-btn" id="mobileThemeToggleBtn" type="button" aria-label="Ganti Tema Tampilan">
                    <span class="theme-btn-content theme-btn-dark">
                        <span class="theme-mobile-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                        </span>
                        <span class="theme-mobile-text">Mode Terang</span>
                    </span>
                    <span class="theme-btn-content theme-btn-light">
                        <span class="theme-mobile-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                        </span>
                        <span class="theme-mobile-text">Mode Gelap</span>
                    </span>
                </button>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="nav-mobile-auth-btn nav-mobile-auth-admin">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>Admin</span>
                    </a>
                    <a href="{{ route('logout') }}" class="nav-mobile-auth-btn nav-mobile-auth-logout">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        <span>Keluar</span>
                    </a>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="nav-mobile-auth-btn nav-mobile-auth-login">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="7.5" cy="15.5" r="5.5"/><path d="m21 2-9.6 9.6"/><path d="m15.5 7.5 3 3L22 7l-3-3"/></svg>
                        <span>Login Guru</span>
                    </a>
                @endguest
            </div>
        </div>
    </div>
</header>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ── Theme Switcher Handler ──
    const themeBtn = document.getElementById('themeToggleBtn');
    const mobileThemeBtn = document.getElementById('mobileThemeToggleBtn');
    
    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('site_theme', newTheme);

        // Spring 360-deg spin animation feedback
        if (themeBtn) {
            themeBtn.style.transition = 'transform 0.55s cubic-bezier(0.68, -0.6, 0.32, 1.6)';
            themeBtn.style.transform = 'scale(0.85) rotate(360deg)';
            setTimeout(() => {
                themeBtn.style.transform = '';
            }, 550);
        }

        window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: newTheme } }));
    }

    themeBtn?.addEventListener('click', toggleTheme);
    mobileThemeBtn?.addEventListener('click', toggleTheme);

    // ── Hamburger Toggle & Mobile Panel ──
    const toggleBtn   = document.getElementById('navToggle');
    const mobilePanel = document.getElementById('navMobilePanel');
    const backdrop    = document.getElementById('navMobileBackdrop');
    const iconOpen    = document.getElementById('iconHamburger');
    const iconClose   = document.getElementById('iconClose');

    function closeMobileMenu() {
        if (mobilePanel && mobilePanel.classList.contains('is-open')) {
            mobilePanel.classList.remove('is-open');
            backdrop?.classList.remove('is-open');
            document.body.classList.remove('nav-mobile-open');
            if (iconOpen && iconClose) {
                iconOpen.style.display  = 'block';
                iconClose.style.display = 'none';
            }
            toggleBtn?.setAttribute('aria-expanded', 'false');
            toggleBtn?.setAttribute('aria-label', 'Buka Menu Navigasi');
        }
    }

    function openMobileMenu() {
        if (mobilePanel) {
            mobilePanel.classList.add('is-open');
            backdrop?.classList.add('is-open');
            document.body.classList.add('nav-mobile-open');
            if (iconOpen && iconClose) {
                iconOpen.style.display  = 'none';
                iconClose.style.display = 'block';
            }
            toggleBtn?.setAttribute('aria-expanded', 'true');
            toggleBtn?.setAttribute('aria-label', 'Tutup Menu Navigasi');
        }
    }

    toggleBtn?.addEventListener('click', function (e) {
        e.stopPropagation();
        if (mobilePanel?.classList.contains('is-open')) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    });

    // Tutup saat backdrop diklik
    backdrop?.addEventListener('click', closeMobileMenu);

    // Tutup menu saat klik di luar area navbar
    document.addEventListener('click', function (e) {
        if (mobilePanel?.classList.contains('is-open')) {
            const navbar = document.getElementById('mainNavbar');
            if (navbar && !navbar.contains(e.target) && e.target !== backdrop) {
                closeMobileMenu();
            }
        }
    });

    // Tutup menu saat tekan tombol Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeMobileMenu();
        }
    });

    // Tutup menu saat klik link di panel mobile
    document.querySelectorAll('.nav-mobile-link, .nav-mobile-cta, .nav-mobile-sublink, .nav-mobile-auth-btn, .mobile-dock-btn').forEach(link => {
        link.addEventListener('click', () => {
            closeMobileMenu();
        });
    });

    // ── Navbar Scroll Shadow ──
    const nav = document.getElementById('mainNavbar');
    window.addEventListener('scroll', () => {
        nav?.classList.toggle('scrolled', window.scrollY > 60);
    }, { passive: true });

    // ── Trigger Efek Transisi Komponen pada Section Target (Cubic-Bezier) ──
    function triggerSectionTransition(targetEl) {
        if (!targetEl) return;

        // Reset dan jalankan animasi entrance cubic-bezier yang seragam dengan komponen lain
        targetEl.classList.remove('section-nav-enter');
        void targetEl.offsetWidth; // Force reflow
        targetEl.classList.add('section-nav-enter');

        // Pastikan child elemen yang memiliki scroll-reveal langsung terlihat
        targetEl.querySelectorAll('.reveal').forEach(el => {
            el.classList.add('visible');
        });
        if (targetEl.classList.contains('reveal')) {
            targetEl.classList.add('visible');
        }

        setTimeout(() => {
            targetEl.classList.remove('section-nav-enter');
        }, 700);
    }

    const navLinks = document.querySelectorAll('.expandable-tab-btn, .nav-desktop-links .nav-link, .nav-mobile-panel .nav-mobile-link, .nav-mobile-panel .nav-mobile-cta, .mobile-dock-btn');

    function setActiveNav(sectionName) {
        navLinks.forEach(link => {
            const sec = link.getAttribute('data-section');
            if (sec === sectionName) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }

    function handleSamePageNavigation(e, link, targetId) {
        const targetEl = document.getElementById(targetId);
        if (!targetEl) return;

        e.preventDefault();

        // Feedback tactile animation pada link yang diklik (cubic-bezier)
        link.classList.add('nav-link-pressed');
        setTimeout(() => link.classList.remove('nav-link-pressed'), 250);

        // Tutup mobile panel jika sedang terbuka
        closeMobileMenu();

        const navHeight = 78;
        const targetPosition = targetId === 'beranda' ? 0 : Math.max(0, targetEl.getBoundingClientRect().top + window.pageYOffset - navHeight);

        // Scroll mulus tersinkronisasi (ScrollSmoother di desktop atau native smooth scroll di mobile)
        if (window.smoother && typeof window.smoother.scrollTo === 'function') {
            window.smoother.scrollTo(targetId === 'beranda' ? 0 : targetEl, true, targetId === 'beranda' ? 'top' : 'top ' + navHeight + 'px');
        } else {
            window.scrollTo({ top: targetPosition, behavior: 'smooth' });
        }

        // Pertahankan efek transisi visual cubic-bezier pada section target
        triggerSectionTransition(targetEl);

        setActiveNav(link.getAttribute('data-section') || targetId);
        history.pushState(null, null, '#' + targetId);
    }

    // Pasang event handler untuk semua link navigasi yang menuju anchor halaman yang sama
    document.querySelectorAll('a[href*="#"]').forEach(link => {
        const href = link.getAttribute('href');
        if (!href || href === '#' || href.startsWith('#!')) return;

        try {
            const url = new URL(href, window.location.origin);
            if (url.pathname === window.location.pathname && url.hash) {
                link.addEventListener('click', function (e) {
                    const targetId = url.hash.substring(1);
                    if (targetId) {
                        handleSamePageNavigation(e, link, targetId);
                    }
                });
            }
        } catch (err) {}
    });

    // Logo Brand klik di homepage langsung pindah ke beranda dengan efek transisi
    const brandLink = document.querySelector('.navbar-brand');
    if (brandLink) {
        try {
            const brandUrl = new URL(brandLink.getAttribute('href'), window.location.origin);
            if (brandUrl.pathname === window.location.pathname) {
                brandLink.addEventListener('click', function (e) {
                    const berandaEl = document.getElementById('beranda');
                    if (berandaEl) {
                        e.preventDefault();
                        if (window.smoother && typeof window.smoother.scrollTo === 'function') {
                            window.smoother.scrollTo(0, true);
                        } else {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                        triggerSectionTransition(berandaEl);
                        setActiveNav('beranda');
                        history.pushState(null, null, window.location.pathname);
                    }
                });
            }
        } catch (err) {}
    }

    // Handle initial hash navigation on page load
    if (window.location.hash) {
        const initialTargetId = window.location.hash.substring(1);
        const initialTargetEl = document.getElementById(initialTargetId);
        if (initialTargetEl) {
            setTimeout(() => {
                const navHeight = 78;
                const targetPosition = initialTargetId === 'beranda' ? 0 : Math.max(0, initialTargetEl.getBoundingClientRect().top + window.pageYOffset - navHeight);
                if (window.smoother && typeof window.smoother.scrollTo === 'function') {
                    window.smoother.scrollTo(initialTargetId === 'beranda' ? 0 : initialTargetEl, false, initialTargetId === 'beranda' ? 'top' : 'top ' + navHeight + 'px');
                } else {
                    window.scrollTo({ top: targetPosition, behavior: 'auto' });
                }
                triggerSectionTransition(initialTargetEl);
                setActiveNav(initialTargetId);
            }, 50);
        }
    }

    // ── Scrollspy Otomatis: Beranda, Jenjang, Cabang, Berita ──
    function updateScrollspy() {
        const scrollY = window.pageYOffset;

        if (window.location.pathname.includes('/ppdb')) {
            setActiveNav('ppdb');
            return;
        }

        if (window.location.pathname.startsWith('/berita')) {
            setActiveNav('berita');
            return;
        }

        const jenjangEl   = document.getElementById('jenjang') || document.getElementById('jurusan');
        const cabangEl    = document.getElementById('cabang') || document.getElementById('fasilitas');
        const beritaEl    = document.getElementById('berita');

        const navHeight = 90;
        const jenjangTop   = jenjangEl ? (jenjangEl.getBoundingClientRect().top + scrollY - navHeight) : 1200;
        const cabangTop    = cabangEl  ? (cabangEl.getBoundingClientRect().top + scrollY - navHeight)  : 2200;
        const beritaTop    = beritaEl  ? (beritaEl.getBoundingClientRect().top + scrollY - navHeight)  : 3200;

        if (scrollY < jenjangTop - 80) {
            setActiveNav('beranda');
        } else if (scrollY >= jenjangTop - 80 && scrollY < cabangTop - 80) {
            setActiveNav('jenjang');
        } else if (scrollY >= cabangTop - 80 && scrollY < beritaTop - 80) {
            setActiveNav('cabang');
        } else {
            setActiveNav('berita');
        }
    }

    window.addEventListener('scroll', updateScrollspy, { passive: true });
    updateScrollspy();
});
</script>
@endpush