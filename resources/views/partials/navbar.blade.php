<header class="navbar">
    <div class="navbar-container">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="navbar-brand">
            <div class="brand-icon">🏫</div>
            <div>
                <span>SMKN 1 NUSANTARA</span>
            </div>
        </a>

        <!-- Navigation Menu Links -->
        <ul class="nav-links">
            <li><a href="#beranda" class="nav-link">Beranda</a></li>
            <li><a href="#sambutan" class="nav-link">Sambutan</a></li>
            <li><a href="#jurusan" class="nav-link">Jurusan</a></li>
            <li><a href="#fasilitas" class="nav-link">Fasilitas</a></li>
            <li><a href="#berita" class="nav-link">Berita</a></li>
            <li><a href="#kontak" class="nav-link">PPDB & Kontak</a></li>
        </ul>

        <!-- Authentication Badge (Edukasi Blade Auth) -->
        <div>
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.85rem;">
                    🔑 Login Guru
                </a>
            @endguest

            @auth
                <div class="auth-badge">
                    <span>👨‍🏫 {{ auth()->user()->name }}</span>
                    <a href="{{ route('logout') }}" style="color: #f87171; font-weight: 700; margin-left: 8px;">[ Logout ]</a>
                </div>
            @endauth
        </div>
    </div>
</header>