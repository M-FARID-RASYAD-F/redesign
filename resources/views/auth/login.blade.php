<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Guru & Admin — PKBM Tahfizh At-Tamam</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-base: #0b1329;
            --bg-card: rgba(15, 23, 42, 0.95);
            --border-card: rgba(0, 180, 216, 0.35);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --input-bg: rgba(30, 41, 59, 0.7);
            --input-border: rgba(255, 255, 255, 0.12);
            --input-focus-border: #00B4D8;
            --input-focus-glow: rgba(0, 180, 216, 0.3);
            --btn-gradient: linear-gradient(135deg, #00B4D8 0%, #0077B6 100%);
            --btn-shadow: 0 10px 25px rgba(0, 180, 216, 0.4);
            --btn-shadow-hover: 0 14px 30px rgba(0, 180, 216, 0.6);
            --overlay-gradient: linear-gradient(135deg, rgba(0, 33, 71, 0.85) 0%, rgba(11, 19, 41, 0.92) 100%);
            --back-link-hover: #38bdf8;
        }

        [data-theme="light"] {
            --bg-base: oklch(41% 0.159 10.272);
            --bg-card: #ffffff;
            --border-card: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --input-bg: #f8fafc;
            --input-border: #cbd5e1;
            --input-focus-border: #b91c1c;
            --input-focus-glow: rgba(185, 28, 28, 0.2);
            --btn-gradient: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            --btn-shadow: 0 10px 25px rgba(185, 28, 28, 0.35);
            --btn-shadow-hover: 0 14px 30px rgba(185, 28, 28, 0.5);
            --overlay-gradient: linear-gradient(135deg, rgba(127, 29, 29, 0.85) 0%, rgba(15, 23, 42, 0.9) 100%);
            --back-link-hover: #b91c1c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: "Plus Jakarta Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--bg-base);
            color: var(--text-primary);
            transition: background 0.4s cubic-bezier(0.16, 1, 0.3, 1), color 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .login-left {
            flex: 1.1;
            position: relative;
            display: none;
            overflow: hidden;
        }

        @media (min-width: 960px) {
            .login-left { display: block; }
        }

        .login-left-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transform: scale(1.02);
            transition: transform 10s ease-out;
        }

        .login-left:hover .login-left-img {
            transform: scale(1.08);
        }

        .login-left-overlay {
            position: absolute;
            inset: 0;
            background: var(--overlay-gradient);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3.5rem;
            color: #ffffff;
            backdrop-filter: blur(2px);
        }

        .login-badge-hero {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1rem;
            width: fit-content;
        }

        .login-left-overlay h2 {
            font-size: clamp(1.8rem, 2.8vw, 2.3rem);
            font-weight: 800;
            margin-bottom: 0.6rem;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .login-left-overlay p {
            font-size: 0.95rem;
            opacity: 0.85;
            max-width: 440px;
            line-height: 1.6;
        }

        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 1.5rem;
            background: transparent;
            position: relative;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: var(--bg-card);
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
            padding: 2.5rem 2.25rem;
            border: 1.5px solid var(--border-card);
            backdrop-filter: blur(20px);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
            animation: cardEntrance 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 1.75rem;
        }

        .login-brand-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: #ffffff;
            border: 2px solid rgba(0, 180, 216, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            flex-shrink: 0;
        }

        .login-card:hover .login-brand-icon {
            transform: scale(1.08) rotate(-4deg);
        }

        .login-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login-brand-text h1 {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .login-brand-text span {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .login-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 0.35rem;
            letter-spacing: -0.01em;
        }

        .login-subtitle {
            font-size: 0.88rem;
            color: var(--text-secondary);
            margin-bottom: 1.75rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.45rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            background: var(--input-bg);
            color: var(--text-primary);
            outline: none;
            transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .form-input:focus {
            border-color: var(--input-focus-border);
            box-shadow: 0 0 0 4px var(--input-focus-glow);
            background: rgba(255, 255, 255, 0.04);
        }

        [data-theme="light"] .form-input:focus {
            background: #ffffff;
        }

        .toggle-password-btn {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-secondary);
            font-size: 1.1rem;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s cubic-bezier(0.4, 0, 0.2, 1), transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .toggle-password-btn:hover {
            color: var(--text-primary);
            transform: scale(1.15);
        }

        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            gap: 0.5rem;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        .remember input {
            width: 17px;
            height: 17px;
            accent-color: #00B4D8;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: 0.9rem 1.5rem;
            border: none;
            border-radius: 12px;
            background: var(--btn-gradient);
            color: #ffffff;
            font-size: 1rem;
            font-weight: 800;
            font-family: inherit;
            cursor: pointer;
            box-shadow: var(--btn-shadow);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--btn-shadow-hover);
        }

        .btn-login:active {
            transform: translateY(1px) scale(0.97);
            transition-duration: 0.12s;
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--input-border);
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-secondary);
            text-decoration: none;
            width: 100%;
            transition: color 0.25s cubic-bezier(0.4, 0, 0.2, 1), transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .back-home:hover {
            color: var(--back-link-hover);
            transform: translateX(-4px);
        }

        .alert-status {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            font-weight: 600;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.4);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            font-weight: 600;
            animation: shake 0.4s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-3px, 0, 0); }
            40%, 60% { transform: translate3d(3px, 0, 0); }
        }
    </style>
</head>
<body>
    <script>
        // Synchronize Theme immediately before render
        (function() {
            const savedTheme = localStorage.getItem('site_theme');
            if (savedTheme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>

    {{-- Left Side: Hero Image & Branding Overlay --}}
    <div class="login-left">
        <img src="{{ asset('sekolah.jpg') }}" alt="PKBM Tahfizh At-Tamam" class="login-left-img" onerror="this.src='{{ asset('images/hero.png') }}'">
        <div class="login-left-overlay">
            <span class="login-badge-hero">🛡️ Portal Akademik & Administrasi</span>
            <h2>PKBM Tahfizh At-Tamam</h2>
            <p>Sistem manajemen terintegrasi untuk pendidik dan staf. Kelola konten berita, pendaftaran PPDB, dan data akademik secara aman dan terpadu.</p>
        </div>
    </div>

    {{-- Right Side: Login Form Card --}}
    <div class="login-right">
        <div class="login-card">
            <div class="login-brand">
                <div class="login-brand-icon">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo At-Tamam">
                </div>
                <div class="login-brand-text">
                    <h1>PKBM Tahfizh At-Tamam</h1>
                    <span>Portal Guru & Admin</span>
                </div>
            </div>

            <h2 class="login-title">Masuk ke Akun Anda</h2>
            <p class="login-subtitle">Masukkan kredensial yang telah didaftarkan sekolah.</p>

            @if (session('status'))
                <div class="alert-status">✓ {{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert-error">⚠️ {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <div class="input-wrap">
                        <input class="form-input" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="guru@attamam.sch.id">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <div class="input-wrap">
                        <input class="form-input" id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                        <button type="button" class="toggle-password-btn" id="togglePasswordBtn" aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                            <span id="eyeIcon">👁️</span>
                        </button>
                    </div>
                </div>

                <div class="form-row">
                    <label class="remember">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    <span>🚀 Masuk ke Admin Panel</span>
                </button>
            </form>

            <a href="{{ route('home') }}" class="back-home">
                <span>← Kembali ke Halaman Utama</span>
            </a>
        </div>
    </div>

    <script>
        // Password Visibility Toggle Logic
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleBtn && passwordInput) {
            toggleBtn.addEventListener('click', function() {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                eyeIcon.textContent = isPassword ? '🙈' : '👁️';
                toggleBtn.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Lihat kata sandi');
            });
        }
    </script>
</body>
</html>
