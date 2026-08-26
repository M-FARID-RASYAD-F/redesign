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
            <li><a href="{{ route('home') }}" class="nav-link">Beranda</a></li>
            <li><a href="{{ route('home') }}#jurusan" class="nav-link">Jurusan</a></li>
            <li><a href="{{ route('home') }}#fasilitas" class="nav-link">Fasilitas</a></li>
            <li><a href="{{ route('home') }}#berita" class="nav-link">Berita</a></li>
            <li><a href="{{ route('ppdb.index') }}" class="nav-link" style="color: #60a5fa; font-weight: 700;">🎓 PPDB Online</a></li>
            <li><a href="{{ route('ppdb.tracking') }}" class="nav-link" style="color: #fde047; font-weight: 600;">🔍 Cek Status</a></li>
        </ul>

        <!-- Authentication Badge (Edukasi Blade Auth) -->
        <div>
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 8px 16px; font-size: 0.85rem;">
                    🔑 Login Guru
                </a>
            @endguest

            @auth
                <div class="auth-badge" style="display: flex; align-items: center; gap: 10px;">
                    <span>👨‍🏫 {{ auth()->user()->name }}</span>
                    <a href="{{ route('admin.dashboard') }}" class="btn-admin-link" style="color: #f59e0b; font-weight: 600; text-decoration: none; margin-left: 8px; font-size: 0.85rem;">🛡️ Admin Panel</a>
                    <a href="{{ route('logout') }}" style="color: #f87171; font-weight: 700; margin-left: 8px; text-decoration: none;">[ Logout ]</a>
                </div>
            @endauth
        </div>
    </div>
</header>