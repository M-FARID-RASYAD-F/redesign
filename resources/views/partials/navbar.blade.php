<header class="navbar" id="mainNavbar">
    {{-- ── Desktop Bar ── --}}
    <div class="navbar-container">

        {{-- Brand Logo --}}
        <a href="{{ route('home') }}" class="navbar-brand">
            <div class="brand-icon">🏫</div>
            <span>SMKN 1 NUSANTARA</span>
        </a>

        {{-- Desktop Navigation Links --}}
        <nav class="nav-desktop-links">
            <a href="{{ route('home') }}" class="nav-link">Beranda</a>
            <a href="{{ route('home') }}#jurusan" class="nav-link">Jurusan</a>
            <a href="{{ route('home') }}#fasilitas" class="nav-link">Fasilitas</a>
            <a href="{{ route('home') }}#berita" class="nav-link">Berita</a>
            <a href="{{ route('ppdb.tracking') }}" class="nav-cta-status">🔍 Cek Status</a>
            <a href="{{ route('ppdb.index') }}" class="nav-cta-ppdb">🎓 PPDB Online</a>
        </nav>

        {{-- Desktop Auth --}}
        <div class="nav-auth-desktop">
            @guest
                <a href="{{ route('login') }}" class="btn-nav-login">🔑 Login Guru</a>
            @endguest

            @auth
                <div class="nav-auth-pill">
                    <div class="nav-auth-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    <span class="nav-auth-name">{{ auth()->user()->name }}</span>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="nav-admin-link">🛡️ Admin</a>
                <a href="{{ route('logout') }}" class="nav-logout-link">Logout</a>
            @endauth
        </div>

        {{-- Hamburger (mobile only) --}}
        <button class="nav-hamburger" id="navToggle" aria-label="Toggle menu" aria-expanded="false">
            <svg id="iconHamburger" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
            <svg id="iconClose" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    {{-- ── Mobile Panel ── --}}
    <div class="nav-mobile-panel" id="navMobilePanel">
        <a href="{{ route('home') }}" class="nav-mobile-link">🏠 Beranda</a>
        <a href="{{ route('home') }}#jurusan" class="nav-mobile-link">📚 Jurusan</a>
        <a href="{{ route('home') }}#fasilitas" class="nav-mobile-link">🏢 Fasilitas</a>
        <a href="{{ route('home') }}#berita" class="nav-mobile-link">📰 Berita</a>
        <a href="{{ route('ppdb.tracking') }}" class="nav-mobile-link">🔍 Cek Status Pendaftaran</a>
        <hr class="nav-mobile-divider">
        <a href="{{ route('ppdb.index') }}" class="nav-mobile-cta">🎓 Daftar PPDB Online</a>

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
});
</script>
@endpush