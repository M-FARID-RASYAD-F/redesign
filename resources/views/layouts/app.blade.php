<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMK Negeri 1 Nusantara - Website Official Sekolah')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,700;0,800;1,400;1,700&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- CSS Custom App -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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

    <!-- Modal Konfirmasi Logout (Scale-in / Zoom-in Pop Effect) -->
    @include('partials.logout-modal')

    <!-- 3D Tilt Card Interactive Physics Engine -->
    <script src="{{ asset('js/tilt-card.js') }}"></script>
    
    <!-- Animated Tabs Engine -->
    <script src="{{ asset('js/animated-tabs.js') }}"></script>

    <!-- macOS Interactive Dock Engine -->
    <script src="{{ asset('js/dock.js') }}"></script>

    @stack('scripts')
</body>
</html>