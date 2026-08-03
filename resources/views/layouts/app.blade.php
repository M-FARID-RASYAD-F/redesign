<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SMK Negeri 1 Nusantara - Website Official Sekolah')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- CSS Custom App -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
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

    @stack('scripts')
</body>
</html>