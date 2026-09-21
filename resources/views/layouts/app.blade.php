<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PKBM Tahfizh At-Tamam - Website Resmi Sekolah')</title>
    
    <!-- Meta SEO & Social Graph (OpenGraph / Twitter) -->
    <meta name="description" content="Portal Resmi PKBM Tahfizh At-Tamam Edu — Sekolah berkarakter Qurani, unggul teknologi, dan siap kerja dengan pilihan jenjang SD, SMP, dan SMK.">
    <meta name="keywords" content="At-Tamam Edu, PKBM Tahfizh, PPDB Online, SD Tahfizh, SMP Tahfizh, SMK Pekanbaru, Sekolah Islam">
    <meta property="og:title" content="@yield('title', 'PKBM Tahfizh At-Tamam — Portal Resmi Sekolah')">
    <meta property="og:description" content="Mencetak Generasi Qurani, Berkarakter & Siap Kerja di Era Digital. Pendaftaran PPDB Online SD, SMP, SMK telah dibuka.">
    <meta property="og:image" content="{{ asset('images/logo.jpeg') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;0,800;1,400;1,700&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">
    
    <!-- CSS Custom App -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ file_exists(public_path('css/style.css')) ? filemtime(public_path('css/style.css')) : time() }}">

    <!-- Vite React & Tailwind Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Theme Initialization (Anti-Flicker) -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('site_theme');
            if (savedTheme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    
    @stack('styles')
</head>
<body>


    <!-- Partial Navbar Header (di luar smooth-wrapper — tetap fixed ke viewport) -->
    @include('partials.navbar')

    <!-- Smooth Scroll Wrapper (ScrollSmoother) — bungkus semua konten yang ikut scroll -->
    <div id="smooth-wrapper">
        <div id="smooth-content">

            <!-- Flash Message Notifikasi -->
            @if(session('success'))
                <div class="alert-success" style="display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Main Content Dynamic Section -->
            <main class="main-content">
                @yield('konten_utama')
            </main>

            <!-- Partial Footer -->
            @include('partials.footer')

        </div>
    </div>

    <!-- Floating WhatsApp Button (Pojok Kiri Bawah) — di luar smooth-wrapper, tetap fixed -->
    @include('partials.whatsapp-button')

    {{-- Modal Konfirmasi Logout — hanya relevan untuk user yang sudah login (tautan logout
         cuma muncul di dalam @auth), jadi SweetAlert2 (~79KB) & markup modal ini tidak perlu
         ikut didownload/parse oleh pengunjung tamu (mayoritas trafik: calon siswa/wali cek PPDB). --}}
    @auth
        @include('partials.logout-modal')
    @endauth

    {{--
        Semua script lokal dipasangi ?v={filemtime} (sama seperti style.css di <head>)
        supaya aman dipasangi Cache-Control 1 tahun di .htaccess — begitu file ini diubah,
        URL-nya otomatis berubah, jadi tidak ada risiko browser mengunci versi lama.
    --}}
    @php
        $jsv = fn (string $path) => asset($path) . '?v=' . (file_exists(public_path($path)) ? filemtime(public_path($path)) : time());
    @endphp

    <!-- 3D Tilt Card Interactive Physics Engine -->
    <script defer src="{{ $jsv('js/tilt-card.js') }}"></script>

    <!-- Animated Tabs Engine -->
    <script defer src="{{ $jsv('js/animated-tabs.js') }}"></script>

    <!-- GSAP + Plugin (ScrollTrigger, ScrollSmoother) untuk smooth scroll -->
    <script defer src="{{ $jsv('js/gsap.min.js') }}"></script>
    <script defer src="{{ $jsv('js/ScrollTrigger.min.js') }}"></script>
    <script defer src="{{ $jsv('js/ScrollSmoother.min.js') }}"></script>
    <script defer src="{{ $jsv('js/smooth-scroll.js') }}"></script>

    <!-- Bidirectional Cubic-Bezier Scroll Reveal Engine -->
    <script defer src="{{ $jsv('js/scroll-reveal.js') }}"></script>
    <!-- Global Spotlight Search Modal -->
    @include('partials.spotlight-search')
    @stack('scripts')
</body>
</html>