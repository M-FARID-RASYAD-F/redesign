{{-- resources/views/components/sidebar.blade.php --}}
@props([
    'active' => 'perpustakaan'
])

{{-- ── Desktop Sidebar (Docked Left, 56-60px width) ── --}}
<aside class="sidebar-dashboard hidden md:flex flex-col items-center justify-between py-5 fixed left-0 top-0 bottom-0 w-[58px] bg-[#040914]/95 backdrop-blur-xl border-r border-cyan-500/20 z-40 select-none shadow-[4px_0_24px_rgba(0,0,0,0.5)]" aria-label="Sidebar Navigasi Dashboard">
    
    {{-- Top: School Mini Logo / Brand Icon --}}
    <div class="flex flex-col items-center gap-6 w-full">
        <a href="{{ route('home') }}" class="group relative flex items-center justify-center w-10 h-10 rounded-xl bg-white p-1 shadow-md hover:shadow-cyan-500/30 transition-all duration-200 hover:scale-105" title="PKBM Tahfizh At-Tamam - Beranda">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo PKBM Tahfizh At-Tamam" class="w-8 h-8 object-contain rounded-lg">
            <span class="sidebar-tooltip">PKBM Tahfizh At-Tamam</span>
        </a>

        <div class="w-7 h-[1px] bg-cyan-500/20"></div>

        {{-- Nav Item Icons --}}
        <nav class="flex flex-col items-center gap-3.5 w-full" aria-label="Menu Utama">
            
            {{-- 1. Beranda --}}
            <a href="{{ route('home') }}" 
               class="sidebar-nav-item group relative {{ $active === 'home' || Request::routeIs('home') ? 'active' : '' }}" 
               aria-label="Beranda" 
               title="Beranda">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span class="sidebar-tooltip">Beranda</span>
            </a>

            {{-- 2. Perpustakaan Digital (ACTIVE) --}}
            <a href="{{ route('perpus.index') }}" 
               class="sidebar-nav-item group relative {{ $active === 'perpustakaan' || Request::is('perpustakaan*') ? 'active' : '' }}" 
               aria-label="Perpustakaan Digital" 
               title="Perpustakaan Digital">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                    <path d="M6 6h10M6 10h10"/>
                </svg>
                <span class="sidebar-tooltip">Perpustakaan Digital</span>
            </a>

            {{-- 3. PPDB Online / Akademik --}}
            <a href="{{ route('ppdb.index') }}" 
               class="sidebar-nav-item group relative {{ $active === 'ppdb' || Request::is('ppdb*') ? 'active' : '' }}" 
               aria-label="PPDB Online" 
               title="PPDB Online">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
                <span class="sidebar-tooltip">PPDB Online</span>
            </a>

            {{-- 4. Berita & Kegiatan Sekolah --}}
            <a href="{{ route('berita.index') }}" 
               class="sidebar-nav-item group relative {{ $active === 'berita' || Request::is('berita*') ? 'active' : '' }}" 
               aria-label="Portal Berita" 
               title="Portal Berita">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/>
                    <path d="M18 14h-8"/>
                    <path d="M15 18h-5"/>
                    <path d="M10 6h8v4h-8V6Z"/>
                </svg>
                <span class="sidebar-tooltip">Berita &amp; Artikel</span>
            </a>

            {{-- 5. Lacak Status Peminjaman --}}
            <a href="{{ route('perpus.tracking') }}" 
               class="sidebar-nav-item group relative {{ $active === 'tracking' || Request::is('perpustakaan/status*') ? 'active' : '' }}" 
               aria-label="Cek Status Peminjaman" 
               title="Cek Status Peminjaman">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <span class="sidebar-tooltip">Lacak Status Buku</span>
            </a>

            {{-- 6. Spotlight Search Quick Finder --}}
            <button type="button" 
                    onclick="openSpotlight()" 
                    class="sidebar-nav-item group relative" 
                    aria-label="Pencarian Cepat" 
                    title="Cari (Cmd+K)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <span class="sidebar-tooltip">Pencarian Cepat</span>
            </button>

        </nav>
    </div>

    {{-- Bottom: Support & Account Action Icons --}}
    <div class="flex flex-col items-center gap-3.5 w-full">
        <div class="w-7 h-[1px] bg-cyan-500/20"></div>

        {{-- WhatsApp Helpdesk --}}
        <a href="{{ config('school.whatsapp_url', 'https://wa.me/6281270001920') }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="sidebar-nav-item text-emerald-400 hover:text-emerald-300 hover:bg-emerald-500/15 group relative" 
           aria-label="WhatsApp Bantuan" 
           title="WhatsApp Helpdesk">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
            </svg>
            <span class="sidebar-tooltip">Bantuan WhatsApp</span>
        </a>

        {{-- Admin Portal / Login Icon --}}
        @auth
            <a href="{{ auth()->user()->dashboard_url }}" 
               class="sidebar-nav-item text-amber-400 hover:text-amber-300 hover:bg-amber-500/15 group relative" 
               aria-label="Panel Admin" 
               title="Dashboard Admin">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <span class="sidebar-tooltip">Panel Admin</span>
            </a>
        @else
            <a href="{{ route('login') }}" 
               class="sidebar-nav-item text-slate-400 hover:text-white hover:bg-white/10 group relative" 
               aria-label="Login Pengguna" 
               title="Login">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="7.5" cy="15.5" r="5.5"/>
                    <path d="m21 2-9.6 9.6"/>
                    <path d="m15.5 7.5 3 3L22 7l-3-3"/>
                </svg>
                <span class="sidebar-tooltip">Login Petugas / Guru</span>
            </a>
        @endauth
    </div>
</aside>

{{-- ── Mobile Bottom Navigation (Responsive Floating Dock for Mobile Phones) ── --}}
<nav class="md:hidden fixed bottom-0 left-0 right-0 h-14 bg-[#040914]/95 backdrop-blur-xl border-t border-cyan-500/20 z-40 flex items-center justify-around px-3 shadow-[0_-4px_20px_rgba(0,0,0,0.5)]" aria-label="Navigasi Bawah Mobile">
    <a href="{{ route('home') }}" class="flex flex-col items-center justify-center p-2 text-slate-400 hover:text-cyan-300 {{ Request::routeIs('home') ? '!text-cyan-400 font-bold' : '' }}" aria-label="Beranda">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span class="text-[10px] mt-0.5">Beranda</span>
    </a>

    <a href="{{ route('perpus.index') }}" class="flex flex-col items-center justify-center p-2 text-cyan-400 font-bold" aria-label="Perpustakaan">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10"/></svg>
        <span class="text-[10px] mt-0.5 text-cyan-300">Katalog</span>
    </a>

    <a href="{{ route('perpus.tracking') }}" class="flex flex-col items-center justify-center p-2 text-slate-400 hover:text-cyan-300 {{ Request::is('perpustakaan/status*') ? '!text-cyan-400 font-bold' : '' }}" aria-label="Lacak Status">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <span class="text-[10px] mt-0.5">Status</span>
    </a>

    <button type="button" onclick="openSpotlight()" class="flex flex-col items-center justify-center p-2 text-slate-400 hover:text-cyan-300" aria-label="Cari">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <span class="text-[10px] mt-0.5">Cari</span>
    </button>

    <a href="{{ config('school.whatsapp_url', 'https://wa.me/6281270001920') }}" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center p-2 text-emerald-400 hover:text-emerald-300" aria-label="WhatsApp">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
        <span class="text-[10px] mt-0.5">Bantuan</span>
    </a>
</nav>

<style>
/* Sidebar Modern Tooltip and Item Styling */
.sidebar-nav-item {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 12px;
    color: #94a3b8;
    background: transparent;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.sidebar-nav-item:hover {
    color: #38bdf8;
    background: rgba(6, 182, 212, 0.12);
    border-color: rgba(6, 182, 212, 0.25);
    transform: translateX(2px);
}

.sidebar-nav-item.active {
    color: #00d4ff !important;
    background: rgba(6, 182, 212, 0.18) !important;
    border-color: rgba(0, 212, 255, 0.45) !important;
    box-shadow: 0 0 16px rgba(0, 212, 255, 0.25), inset 0 1px 0 rgba(255, 255, 255, 0.2);
}

.sidebar-tooltip {
    position: absolute;
    left: calc(100% + 12px);
    top: 50%;
    transform: translateY(-50%) translateX(-6px);
    background: rgba(3, 14, 28, 0.95);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(0, 212, 255, 0.3);
    color: #ffffff;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
    padding: 6px 12px;
    border-radius: 8px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5), 0 0 12px rgba(0, 212, 255, 0.15);
    opacity: 0;
    pointer-events: none;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    z-index: 50;
}

.sidebar-nav-item:hover .sidebar-tooltip {
    opacity: 1;
    transform: translateY(-50%) translateX(0);
}
</style>
