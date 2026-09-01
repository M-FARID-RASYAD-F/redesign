<header class="navbar" id="mainNavbar">
    {{-- ── Desktop Bar ── --}}
    <div class="navbar-container">

        {{-- 1. Kapsul Kiri: Brand & Logo Sekolah --}}
        <div class="navbar-capsule navbar-left">
            <a href="{{ route('home') }}" class="navbar-brand">
                <div class="brand-icon">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam" class="brand-logo-img">
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
                <a href="{{ route('home') }}#beranda" class="nav-link active" data-section="beranda">Beranda</a>
                <a href="{{ route('home') }}#jurusan" class="nav-link" data-section="jurusan">Jurusan</a>
                <a href="{{ route('home') }}#fasilitas" class="nav-link" data-section="fasilitas">Fasilitas</a>
                <a href="{{ route('home') }}#berita" class="nav-link" data-section="berita">Berita</a>
                <a href="{{ route('ppdb.index') }}" class="nav-link" data-section="ppdb">PPDB</a>
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
                    <a href="{{ route('admin.dashboard') }}" class="nav-admin-link">🛡️ Admin</a>
                    <a href="{{ route('logout') }}" class="nav-logout-link">Logout</a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="nav-btn-search">🔑 Login</a>
                @endguest
            </div>

            {{-- Tombol Menu (kotak border putih) — hamburger --}}
            <button class="nav-btn-menu" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
                <svg id="iconHamburger" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
                <svg id="iconClose" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" style="display:none;">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
                <span>Menu</span>
            </button>
        </div>
    </div>

    {{-- ── Mobile Panel ── --}}
    <div class="nav-mobile-panel" id="navMobilePanel">
        <a href="{{ route('home') }}#beranda" class="nav-mobile-link active" data-section="beranda">🏠 Beranda</a>
        <a href="{{ route('home') }}#jurusan" class="nav-mobile-link" data-section="jurusan">📚 Jurusan</a>
        <a href="{{ route('home') }}#fasilitas" class="nav-mobile-link" data-section="fasilitas">🏢 Fasilitas</a>
        <a href="{{ route('home') }}#berita" class="nav-mobile-link" data-section="berita">📰 Berita</a>
        <a href="{{ route('ppdb.tracking') }}" class="nav-mobile-link">🔍 Cek Status Pendaftaran</a>
        <hr class="nav-mobile-divider">
        <button class="nav-mobile-theme-btn" id="mobileThemeToggleBtn" type="button">
            <span class="theme-mobile-icon">🌗</span>
            <span class="theme-mobile-text">Ganti Tema (Dark / White)</span>
        </button>
        <hr class="nav-mobile-divider">
        <a href="{{ route('ppdb.index') }}" class="nav-mobile-cta" data-section="ppdb">🎓 Daftar PPDB Online</a>

        @auth
        <hr class="nav-mobile-divider">
        <a href="{{ route('admin.dashboard') }}" class="nav-mobile-link">🛡️ Admin Panel</a>
        <a href="{{ route('logout') }}" class="nav-mobile-link" style="color: #f87171;">🚪 Logout</a>
        @endauth

        @guest
        <a href="{{ route('login') }}" class="nav-mobile-link">🔑 Login Guru</a>
        @endguest
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

    // ── Hamburger Toggle ──
    const toggleBtn   = document.getElementById('navToggle');
    const mobilePanel = document.getElementById('navMobilePanel');
    const iconOpen    = document.getElementById('iconHamburger');
    const iconClose   = document.getElementById('iconClose');

    toggleBtn?.addEventListener('click', function () {
        const isOpen = mobilePanel.classList.toggle('is-open');
        this.setAttribute('aria-expanded', isOpen);
        iconOpen.style.display  = isOpen ? 'none'  : 'block';
        iconClose.style.display = isOpen ? 'block' : 'none';
    });

    // Tutup menu saat klik link
    document.querySelectorAll('.nav-mobile-link, .nav-mobile-cta').forEach(link => {
        link.addEventListener('click', () => {
            mobilePanel?.classList.remove('is-open');
            if (iconOpen && iconClose) {
                iconOpen.style.display  = 'block';
                iconClose.style.display = 'none';
                toggleBtn?.setAttribute('aria-expanded', 'false');
            }
        });
    });

    // ── Navbar Scroll Shadow ──
    const nav = document.getElementById('mainNavbar');
    window.addEventListener('scroll', () => {
        nav?.classList.toggle('scrolled', window.scrollY > 60);
    }, { passive: true });

    // ── Animasi Smooth Eased Scroll Menuju Section ──
    function smoothScrollToTarget(targetY, duration = 800) {
        const startY = window.pageYOffset;
        const diff = targetY - startY;
        let startTime = null;

        function easeInOutCubic(t) {
            return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
        }

        function step(currentTime) {
            if (!startTime) startTime = currentTime;
            const progress = Math.min((currentTime - startTime) / duration, 1);
            const ease = easeInOutCubic(progress);
            window.scrollTo(0, startY + diff * ease);

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }
        requestAnimationFrame(step);
    }

    const navLinks = document.querySelectorAll('.nav-desktop-links .nav-link, .nav-mobile-panel .nav-mobile-link');

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

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (!href) return;

        try {
            const url = new URL(href, window.location.origin);
            if (url.pathname === window.location.pathname && url.hash) {
                link.addEventListener('click', function (e) {
                    const targetId = url.hash.substring(1);
                    const targetEl = document.getElementById(targetId);
                    if (targetEl) {
                        e.preventDefault();

                        // Feedback animasi tekan tombol
                        link.classList.add('nav-link-pressed');
                        setTimeout(() => link.classList.remove('nav-link-pressed'), 250);

                        const navHeight = 78;
                        const targetPosition = targetId === 'beranda' ? 0 : (targetEl.getBoundingClientRect().top + window.pageYOffset - navHeight);

                        smoothScrollToTarget(targetPosition, 850);

                        setActiveNav(link.getAttribute('data-section') || targetId);
                        history.pushState(null, null, url.hash);
                    }
                });
            }
        } catch (err) {}
    });

    // ── Scrollspy Otomatis: Beranda di paling atas, lalu Jurusan, Fasilitas, Berita ──
    function updateScrollspy() {
        const scrollY = window.pageYOffset;

        if (window.location.pathname.includes('/ppdb')) {
            setActiveNav('ppdb');
            return;
        }

        const jurusanEl   = document.getElementById('jurusan');
        const fasilitasEl = document.getElementById('fasilitas');
        const beritaEl    = document.getElementById('berita');

        const navHeight = 90;
        const jurusanTop   = jurusanEl   ? (jurusanEl.getBoundingClientRect().top + scrollY - navHeight) : 1200;
        const fasilitasTop = fasilitasEl ? (fasilitasEl.getBoundingClientRect().top + scrollY - navHeight) : 2200;
        const beritaTop    = beritaEl    ? (beritaEl.getBoundingClientRect().top + scrollY - navHeight) : 3200;

        if (scrollY < jurusanTop - 80) {
            setActiveNav('beranda');
        } else if (scrollY >= jurusanTop - 80 && scrollY < fasilitasTop - 80) {
            setActiveNav('jurusan');
        } else if (scrollY >= fasilitasTop - 80 && scrollY < beritaTop - 80) {
            setActiveNav('fasilitas');
        } else {
            setActiveNav('berita');
        }
    }

    window.addEventListener('scroll', updateScrollspy, { passive: true });
    updateScrollspy();
});
</script>
@endpush