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
                <a href="{{ route('home') }}#beranda" class="nav-link active" data-section="beranda"><span class="nav-link-text">Beranda</span></a>
                <a href="{{ route('home') }}#jenjang" class="nav-link" data-section="jenjang"><span class="nav-link-text">Jenjang</span></a>
                <a href="{{ route('home') }}#cabang" class="nav-link" data-section="cabang"><span class="nav-link-text">Cabang</span></a>
                <a href="{{ route('home') }}#berita" class="nav-link" data-section="berita"><span class="nav-link-text">Berita</span></a>
                <a href="{{ route('ppdb.index') }}" class="nav-link" data-section="ppdb"><span class="nav-link-text">PPDB</span></a>
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

            {{-- Island Menu: kapsul kecil yang melebar jadi panel (orkestrasi GSAP easeReverse) --}}
            <div class="nav-island" id="navIsland">
                <button class="nav-island-toggle" id="navToggle" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="navMobilePanel">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                        <line class="island-bar island-bar-top" x1="3" y1="5" x2="13" y2="5"/>
                        <line class="island-bar island-bar-mid" x1="3" y1="8" x2="13" y2="8"/>
                        <line class="island-bar island-bar-bot" x1="3" y1="11" x2="13" y2="11"/>
                    </svg>
                    <span class="nav-link-text island-toggle-label">Menu</span>
                </button>

                <div class="nav-island-backdrop" id="navIslandBackdrop"></div>

                {{-- ── Panel Menu (terbuka dari dalam island) ── --}}
                <div class="nav-mobile-panel" id="navMobilePanel" role="menu">
                    <a href="{{ route('home') }}#beranda" class="nav-mobile-link active" data-section="beranda" tabindex="-1"><span class="nav-link-text">🏠 Beranda</span></a>
                    <a href="{{ route('home') }}#jenjang" class="nav-mobile-link" data-section="jenjang" tabindex="-1"><span class="nav-link-text">📚 Jenjang</span></a>
                    <a href="{{ route('home') }}#cabang" class="nav-mobile-link" data-section="cabang" tabindex="-1"><span class="nav-link-text">🏫 Cabang Sekolah</span></a>
                    <a href="{{ route('home') }}#berita" class="nav-mobile-link" data-section="berita" tabindex="-1"><span class="nav-link-text">📰 Berita</span></a>
                    <a href="{{ route('ppdb.tracking') }}" class="nav-mobile-link" tabindex="-1"><span class="nav-link-text">🔍 Cek Status Pendaftaran</span></a>
                    <hr class="nav-mobile-divider">
                    <button class="nav-mobile-theme-btn" id="mobileThemeToggleBtn" type="button" tabindex="-1">
                        <span class="theme-mobile-icon">🌗</span>
                        <span class="theme-mobile-text">Ganti Tema (Dark / White)</span>
                    </button>
                    <hr class="nav-mobile-divider">
                    <a href="{{ route('ppdb.index') }}" class="nav-mobile-cta" data-section="ppdb" tabindex="-1"><span class="nav-link-text">🎓 Daftar PPDB Online</span></a>

                    @auth
                    <hr class="nav-mobile-divider">
                    <a href="{{ route('admin.dashboard') }}" class="nav-mobile-link" tabindex="-1"><span class="nav-link-text">🛡️ Admin Panel</span></a>
                    <a href="{{ route('logout') }}" class="nav-mobile-link" style="color: #f87171;" tabindex="-1"><span class="nav-link-text">🚪 Logout</span></a>
                    @endauth

                    @guest
                    <a href="{{ route('login') }}" class="nav-mobile-link" tabindex="-1"><span class="nav-link-text">🔑 Login Guru</span></a>
                    @endguest
                </div>
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

    // ── Island Menu Toggle (lihat public/js/nav-island.js untuk animasi GSAP) ──
    // Tutup island saat klik link/menu item di dalamnya
    document.querySelectorAll('.nav-mobile-link, .nav-mobile-cta').forEach(link => {
        link.addEventListener('click', () => window.closeNavIsland?.());
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

    function handleSamePageNavigation(e, link, targetId) {
        const targetEl = document.getElementById(targetId);
        if (!targetEl) return;

        e.preventDefault();

        // Feedback tactile animation pada link yang diklik (cubic-bezier)
        link.classList.add('nav-link-pressed');
        setTimeout(() => link.classList.remove('nav-link-pressed'), 250);

        // Tutup island menu jika sedang terbuka
        window.closeNavIsland?.();

        const navHeight = 78;
        const targetPosition = targetId === 'beranda' ? 0 : Math.max(0, targetEl.getBoundingClientRect().top + window.pageYOffset - navHeight);

        // Pindah posisi langsung tanpa animasi scrolling lambat
        window.scrollTo({ top: targetPosition, behavior: 'auto' });

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
                        window.scrollTo({ top: 0, behavior: 'auto' });
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
                window.scrollTo({ top: targetPosition, behavior: 'auto' });
                triggerSectionTransition(initialTargetEl);
                setActiveNav(initialTargetId);
            }, 50);
        }
    }

    // ── Scrollspy Otomatis: Beranda di paling atas, lalu Jurusan, Fasilitas, Berita ──
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