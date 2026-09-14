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

        {{-- 2. Kapsul Tengah: Menu Navigasi Utama --}}
        <div class="navbar-capsule navbar-center">
            <nav class="nav-desktop-links">
                <a href="{{ route('home') }}#beranda" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" data-section="beranda"><span class="nav-link-text">Beranda</span></a>
                <a href="{{ route('home') }}#jenjang" class="nav-link" data-section="jenjang"><span class="nav-link-text">Jenjang</span></a>
                <a href="{{ route('home') }}#cabang" class="nav-link" data-section="cabang"><span class="nav-link-text">Cabang</span></a>
                <a href="{{ route('home') }}#berita" class="nav-link" data-section="berita"><span class="nav-link-text">Berita</span></a>
                <a href="{{ route('ppdb.index') }}" class="nav-link {{ Request::is('ppdb*') ? 'active' : '' }}" data-section="ppdb"><span class="nav-link-text">PPDB</span></a>
            </nav>
        </div>

        {{-- 3. Kapsul Kanan: Theme Switcher, Login / Admin & Menu Mobile --}}
        <div class="navbar-capsule navbar-right">
            {{-- Tombol Toggle Theme (Dark / White) --}}
            <button class="nav-theme-toggle" id="themeToggleBtn" type="button" aria-label="Ganti Tema Tampilan" title="Ganti Tema (Dark / White Mode)">
                <span class="theme-icon theme-icon-sun" aria-hidden="true">☀️</span>
                <span class="theme-icon theme-icon-moon" aria-hidden="true">🌙</span>
            </button>

            <div class="nav-auth-desktop">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="nav-admin-link"><span class="nav-link-text">🛡️ Admin</span></a>
                    <a href="{{ route('logout') }}" class="nav-logout-link"><span class="nav-link-text">Logout</span></a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="nav-btn-search"><span class="nav-link-text">🔑 Login</span></a>
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
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="nav-mobile-pill-logo">
                    <span class="nav-mobile-pill-text">PKBM Tahfizh At-Tamam</span>
                </div>
                <span class="nav-mobile-status-badge">Edu Portal</span>
            </div>

            {{-- 1. Navigasi Halaman Utama --}}
            <div class="nav-mobile-nav-list">
                <a href="{{ route('home') }}#beranda" class="nav-mobile-link {{ Request::routeIs('home') ? 'active' : '' }}" data-section="beranda">
                    <span class="nav-mobile-icon-box">🏠</span>
                    <span class="nav-mobile-link-text">Beranda</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('home') }}#jenjang" class="nav-mobile-link" data-section="jenjang">
                    <span class="nav-mobile-icon-box">📚</span>
                    <span class="nav-mobile-link-text">Jenjang Pendidikan</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('home') }}#cabang" class="nav-mobile-link" data-section="cabang">
                    <span class="nav-mobile-icon-box">🏫</span>
                    <span class="nav-mobile-link-text">Cabang Sekolah</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
                <a href="{{ route('home') }}#berita" class="nav-mobile-link" data-section="berita">
                    <span class="nav-mobile-icon-box">📰</span>
                    <span class="nav-mobile-link-text">Berita & Informasi</span>
                    <span class="nav-mobile-arrow" aria-hidden="true">›</span>
                </a>
            </div>

            {{-- 2. Kartu Layanan PPDB Online --}}
            <div class="nav-mobile-ppdb-box">
                <a href="{{ route('ppdb.index') }}" class="nav-mobile-cta {{ Request::is('ppdb*') ? 'active' : '' }}" data-section="ppdb">
                    <span class="nav-cta-text">🎓 Daftar PPDB Online</span>
                </a>
                <a href="{{ route('ppdb.tracking') }}" class="nav-mobile-sublink">
                    <span class="nav-sublink-icon">🔍</span>
                    <span class="nav-sublink-text">Cek Status Pendaftaran</span>
                    <span class="nav-sublink-badge">Online</span>
                </a>
            </div>

            {{-- 3. Utility & Akun Footer --}}
            <div class="nav-mobile-footer-row">
                <button class="nav-mobile-theme-btn" id="mobileThemeToggleBtn" type="button" aria-label="Ganti Tema Tampilan">
                    <span class="theme-btn-content theme-btn-dark">
                        <span class="theme-mobile-icon">☀️</span>
                        <span class="theme-mobile-text">Mode Terang</span>
                    </span>
                    <span class="theme-btn-content theme-btn-light">
                        <span class="theme-mobile-icon">🌙</span>
                        <span class="theme-mobile-text">Mode Gelap</span>
                    </span>
                </button>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="nav-mobile-auth-btn nav-mobile-auth-admin">
                        <span>🛡️ Admin</span>
                    </a>
                    <a href="{{ route('logout') }}" class="nav-mobile-auth-btn nav-mobile-auth-logout">
                        <span>🚪 Keluar</span>
                    </a>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="nav-mobile-auth-btn nav-mobile-auth-login">
                        <span>🔑 Login Guru</span>
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
    document.querySelectorAll('.nav-mobile-link, .nav-mobile-cta, .nav-mobile-sublink, .nav-mobile-auth-btn').forEach(link => {
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

    const navLinks = document.querySelectorAll('.nav-desktop-links .nav-link, .nav-mobile-panel .nav-mobile-link, .nav-mobile-panel .nav-mobile-cta');

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