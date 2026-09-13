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

    <!-- Partial Navbar Header -->
    @include('partials.navbar')

    <!-- Flash Message Notifikasi -->
    @if(session('success'))
        <div class="alert-success">
            ✨ {{ session('success') }}
        </div>
    @endif

    <!-- Main Content Dynamic Section -->
    <main class="main-content">
        @yield('konten_utama')
    </main>

    <!-- Partial Footer -->
    @include('partials.footer')

    <!-- Floating WhatsApp Button (Pojok Kiri Bawah) -->
    @include('partials.whatsapp-button')

    <!-- SweetAlert2 Standalone Engine -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <!-- Modal Konfirmasi Logout (Scale-in / Zoom-in Pop Effect) -->
    @include('partials.logout-modal')

    <!-- 3D Tilt Card Interactive Physics Engine -->
    <script src="{{ asset('js/tilt-card.js') }}"></script>
    
    <!-- Animated Tabs Engine -->
    <script src="{{ asset('js/animated-tabs.js') }}"></script>

    <!-- GSAP + Nav Island Menu (orkestrasi easeReverse) -->
    <script src="{{ asset('js/gsap.min.js') }}"></script>
    <script src="{{ asset('js/nav-island.js') }}"></script>
    @stack('scripts')
</body>
</html>