@php
    $defaultTab = $defaultTab ?? request()->query('tab', old('form_type') === 'register' || $errors->has('name') || $errors->has('password_confirmation') ? 'register' : 'login');
    $isRegister = $defaultTab === 'register';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Masuk & Registrasi — PKBM Tahfizh At-Tamam</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --circle-gradient: linear-gradient(-45deg, #667eea 0%, #764ba2 100%);
            --card-bg: #ffffff;
            --card-shadow: 0 25px 60px rgba(0, 0, 0, 0.22);
            --title-color: #333333;
            --input-bg: #f0f0f0;
            --input-hover-bg: #e8e8e8;
            --input-text: #333333;
            --input-placeholder: #888888;
            --input-icon: #667eea;
            --primary-btn: #667eea;
            --primary-btn-hover: #5568d3;
            --primary-btn-shadow: rgba(102, 126, 234, 0.45);
            --social-border: #e2e8f0;
            --social-color: #667eea;
            --social-hover-border: #764ba2;
            --social-text: #666666;
            --panel-text: #ffffff;
            --panel-desc: rgba(255, 255, 255, 0.9);
            --nav-btn-bg: rgba(255, 255, 255, 0.2);
            --nav-btn-border: rgba(255, 255, 255, 0.4);
            --nav-btn-text: #ffffff;
        }

        [data-theme="dark"] {
            --bg-gradient: linear-gradient(135deg, #090e1a 0%, #171d34 100%);
            --circle-gradient: linear-gradient(-45deg, #4f46e5 0%, #7c3aed 100%);
            --card-bg: #0f172a;
            --card-shadow: 0 25px 60px rgba(0, 0, 0, 0.55);
            --title-color: #f8fafc;
            --input-bg: #1e293b;
            --input-hover-bg: #283548;
            --input-text: #f8fafc;
            --input-placeholder: #64748b;
            --input-icon: #818cf8;
            --primary-btn: #6366f1;
            --primary-btn-hover: #4f46e5;
            --primary-btn-shadow: rgba(99, 102, 241, 0.5);
            --social-border: #334155;
            --social-color: #818cf8;
            --social-hover-border: #a855f7;
            --social-text: #94a3b8;
            --panel-text: #ffffff;
            --panel-desc: rgba(255, 255, 255, 0.88);
            --nav-btn-bg: rgba(15, 23, 42, 0.7);
            --nav-btn-border: rgba(255, 255, 255, 0.15);
            --nav-btn-text: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
            transition: background 0.4s ease;
        }

        /* ═══════════════════════════════════════════════════════════
           TOP ACTION BAR
           ═══════════════════════════════════════════════════════════ */
        .top-action-bar {
            position: fixed;
            top: 1.25rem;
            left: 1.5rem;
            right: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
            pointer-events: none;
        }

        .top-action-bar > * {
            pointer-events: auto;
        }

        .btn-top-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--nav-btn-bg);
            border: 1px solid var(--nav-btn-border);
            color: var(--nav-btn-text);
            text-decoration: none;
            padding: 0.6rem 1.15rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-top-nav:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.3);
        }

        .btn-top-nav svg {
            transition: transform 0.25s ease;
        }

        .btn-top-nav:hover svg {
            transform: translateX(-3px);
        }

        .btn-theme-toggle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--nav-btn-bg);
            border: 1px solid var(--nav-btn-border);
            color: var(--nav-btn-text);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            font-size: 1.1rem;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), background 0.3s ease;
        }

        .btn-theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            background: rgba(255, 255, 255, 0.3);
        }

        /* ═══════════════════════════════════════════════════════════
           MAIN 21ST AUTH-SWITCH CONTAINER
           ═══════════════════════════════════════════════════════════ */
        .container {
            position: relative;
            width: 100%;
            max-width: 950px;
            min-height: 620px;
            background: var(--card-bg);
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: background 0.4s ease, box-shadow 0.4s ease;
            margin: auto;
        }

        .forms-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .signin-signup {
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            left: 75%;
            width: 50%;
            transition: 1s 0.7s ease-in-out;
            display: grid;
            grid-template-columns: 1fr;
            z-index: 5;
        }

        form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 1.5rem 4rem;
            transition: all 0.2s 0.7s;
            overflow: hidden;
            grid-column: 1 / 2;
            grid-row: 1 / 2;
            width: 100%;
        }

        form.sign-up-form {
            opacity: 0;
            z-index: 1;
            pointer-events: none;
        }

        form.sign-in-form {
            opacity: 1;
            z-index: 2;
            pointer-events: auto;
        }

        .brand-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 0.8rem;
        }

        .brand-badge img {
            width: 32px;
            height: 32px;
            object-fit: contain;
            border-radius: 8px;
        }

        .brand-badge span {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--social-text);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .title {
            font-size: 2.1rem;
            color: var(--title-color);
            margin-bottom: 8px;
            font-weight: 800;
            letter-spacing: -0.02em;
            text-align: center;
        }

        .subtitle-text {
            font-size: 0.85rem;
            color: var(--social-text);
            margin-bottom: 1rem;
            text-align: center;
        }

        /* Input Fields */
        .input-field {
            max-width: 380px;
            width: 100%;
            background-color: var(--input-bg);
            margin: 8px 0;
            height: 52px;
            border-radius: 55px;
            display: grid;
            grid-template-columns: 15% 72% 13%;
            padding: 0 0.8rem 0 0.4rem;
            position: relative;
            transition: 0.3s ease;
            border: 1px solid transparent;
        }

        .input-field.no-toggle {
            grid-template-columns: 15% 85%;
        }

        .input-field:focus-within {
            background-color: var(--input-hover-bg);
            border-color: var(--primary-btn);
            box-shadow: 0 0 0 3px var(--primary-btn-shadow);
        }

        .input-field i {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--input-icon);
            transition: 0.3s ease;
            font-size: 1.1rem;
        }

        .input-field i svg {
            width: 20px;
            height: 20px;
        }

        .input-field input {
            background: none;
            outline: none;
            border: none;
            line-height: 1;
            font-weight: 500;
            font-size: 0.95rem;
            color: var(--input-text);
            width: 100%;
            font-family: inherit;
        }

        .input-field input::placeholder {
            color: var(--input-placeholder);
            font-weight: 400;
        }

        .btn-field-toggle {
            background: none;
            border: none;
            outline: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--social-text);
            padding: 0;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .btn-field-toggle:hover {
            color: var(--title-color);
            transform: scale(1.15);
        }

        .form-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 380px;
            margin: 6px 0 10px 0;
            font-size: 0.82rem;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--social-text);
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        .remember-label input {
            accent-color: var(--primary-btn);
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        /* Buttons */
        .btn {
            width: 160px;
            background-color: var(--primary-btn);
            border: none;
            outline: none;
            height: 48px;
            border-radius: 49px;
            color: #fff;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.03em;
            margin: 10px 0;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-size: 0.88rem;
            font-family: inherit;
            box-shadow: 0 4px 14px var(--primary-btn-shadow);
        }

        .btn:hover {
            background-color: var(--primary-btn-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--primary-btn-shadow);
        }

        .btn:active {
            transform: translateY(1px) scale(0.98);
        }

        .btn.transparent {
            margin: 0;
            background: none;
            border: 2px solid #fff;
            width: 140px;
            height: 44px;
            font-weight: 700;
            font-size: 0.84rem;
            color: #ffffff;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            border-radius: 49px;
            cursor: pointer;
            outline: none;
            transition: all 0.35s ease;
        }

        .btn.transparent:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Social Media Section */
        .social-text {
            padding: 0.6rem 0 0.4rem 0;
            font-size: 0.88rem;
            color: var(--social-text);
            text-align: center;
        }

        .social-media {
            display: flex;
            justify-content: center;
            gap: 14px;
            margin-top: 4px;
        }

        .social-icon {
            height: 44px;
            width: 44px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1.5px solid var(--social-border);
            border-radius: 50%;
            color: var(--social-color);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            text-decoration: none;
            background: var(--card-bg);
        }

        .social-icon:hover {
            border-color: var(--social-hover-border);
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .social-icon svg {
            width: 20px;
            height: 20px;
            transition: 0.3s ease;
        }

        /* Panels Container */
        .panels-container {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            pointer-events: none;
        }

        .panel {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-around;
            text-align: center;
            z-index: 6;
            pointer-events: none;
        }

        .left-panel {
            padding: 3rem 17% 2rem 12%;
            pointer-events: all;
        }

        .right-panel {
            padding: 3rem 12% 2rem 17%;
            pointer-events: none;
        }

        .panel .content {
            color: var(--panel-text);
            transition: transform 0.9s ease-in-out;
            transition-delay: 0.6s;
            max-width: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .panel-logo {
            width: 68px;
            height: 68px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.96);
            padding: 8px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .panel-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .panel h3 {
            font-weight: 700;
            line-height: 1.2;
            font-size: 1.65rem;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .panel p {
            font-size: 0.92rem;
            padding: 0.5rem 0 1.5rem 0;
            color: var(--panel-desc);
            line-height: 1.55;
        }

        .right-panel .content {
            transform: translateX(800px);
        }

        /* ═══════════════════════════════════════════════════════════
           THE SIGNATURE ANIMATED CIRCLE (:before)
           ═══════════════════════════════════════════════════════════ */
        .container:before {
            content: "";
            position: absolute;
            height: 2000px;
            width: 2000px;
            top: -10%;
            right: 48%;
            transform: translateY(-50%);
            background: var(--circle-gradient);
            transition: 1.8s ease-in-out;
            border-radius: 50%;
            z-index: 6;
        }

        /* ═══════════════════════════════════════════════════════════
           SIGN-UP MODE TRANSITION STATES
           ═══════════════════════════════════════════════════════════ */
        .container.sign-up-mode:before {
            transform: translate(100%, -50%);
            right: 52%;
        }

        .container.sign-up-mode .left-panel .content {
            transform: translateX(-800px);
        }

        .container.sign-up-mode .signin-signup {
            left: 25%;
        }

        .container.sign-up-mode form.sign-up-form {
            opacity: 1;
            z-index: 2;
            pointer-events: auto;
        }

        .container.sign-up-mode form.sign-in-form {
            opacity: 0;
            z-index: 1;
            pointer-events: none;
        }

        .container.sign-up-mode .right-panel .content {
            transform: translateX(0%);
        }

        .container.sign-up-mode .left-panel {
            pointer-events: none;
        }

        .container.sign-up-mode .right-panel {
            pointer-events: all;
        }

        /* Alert notifications */
        .alert-box {
            width: 100%;
            max-width: 380px;
            padding: 0.65rem 0.95rem;
            border-radius: 12px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 8px;
            line-height: 1.4;
        }

        .alert-box.danger {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.35);
        }

        .alert-box.success {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.35);
        }

        /* Mobile switch link */
        .mobile-switch-text {
            display: none;
            font-size: 0.82rem;
            color: var(--social-text);
            margin-top: 1rem;
            text-align: center;
        }

        .mobile-switch-text a {
            color: var(--primary-btn);
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .mobile-switch-text a:hover {
            text-decoration: underline;
        }

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE DESIGN (<= 870px)
           ═══════════════════════════════════════════════════════════ */
        @media (max-width: 870px) {
            body {
                padding: 4.5rem 1rem 1.5rem 1rem;
            }

            .container {
                min-height: 780px;
                height: auto;
                max-width: 520px;
            }

            .signin-signup {
                width: 100%;
                top: 92%;
                transform: translate(-50%, -100%);
                transition: 1s 0.8s ease-in-out;
            }

            .signin-signup,
            .container.sign-up-mode .signin-signup {
                left: 50%;
            }

            .panels-container {
                grid-template-columns: 1fr;
                grid-template-rows: 1fr 2fr 1fr;
            }

            .panel {
                flex-direction: row;
                justify-content: space-around;
                align-items: center;
                padding: 2.2rem 8%;
                grid-column: 1 / 2;
            }

            .right-panel {
                grid-row: 3 / 4;
            }

            .left-panel {
                grid-row: 1 / 2;
            }

            .panel .content {
                padding-right: 5%;
                transition: transform 0.9s ease-in-out;
                transition-delay: 0.8s;
                align-items: flex-start;
                text-align: left;
            }

            .panel-logo {
                display: none;
            }

            .panel h3 {
                font-size: 1.25rem;
                margin-bottom: 4px;
            }

            .panel p {
                font-size: 0.76rem;
                padding: 0.25rem 0 0.75rem 0;
            }

            .btn.transparent {
                width: 115px;
                height: 38px;
                font-size: 0.74rem;
            }

            .container:before {
                width: 1500px;
                height: 1500px;
                transform: translateX(-50%);
                left: 30%;
                bottom: 68%;
                right: initial;
                top: initial;
                transition: 2s ease-in-out;
            }

            .container.sign-up-mode:before {
                transform: translate(-50%, 100%);
                bottom: 32%;
                right: initial;
            }

            .container.sign-up-mode .left-panel .content {
                transform: translateY(-300px);
            }

            .container.sign-up-mode .right-panel .content {
                transform: translateY(0px);
            }

            .right-panel .content {
                transform: translateY(300px);
            }

            .container.sign-up-mode .signin-signup {
                top: 8%;
                transform: translate(-50%, 0);
            }

            .mobile-switch-text {
                display: block;
            }
        }

        @media (max-width: 570px) {
            body {
                padding: 4.25rem 0.75rem 1rem 0.75rem;
            }

            .container {
                border-radius: 20px;
            }

            form {
                padding: 1rem 1.5rem;
            }

            .panel .content {
                padding: 0.5rem 0.5rem;
            }

            .title {
                font-size: 1.8rem;
            }

            .input-field {
                height: 48px;
            }

            .top-action-bar {
                left: 1rem;
                right: 1rem;
                top: 1rem;
            }
        }
    </style>
</head>
<body>
    <script>
        // Set initial theme before paint to prevent flashing
        (function() {
            const savedTheme = localStorage.getItem('auth_theme') || localStorage.getItem('site_theme');
            if (savedTheme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else if (savedTheme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    {{-- Top Floating Navigation Bar --}}
    <div class="top-action-bar">
        <a href="{{ route('home') }}" class="btn-top-nav" aria-label="Kembali ke Beranda">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Beranda</span>
        </a>

        <button class="btn-theme-toggle" id="themeToggleBtn" type="button" aria-label="Ganti Tema" title="Ganti Mode Tampilan">
            <span id="themeIcon">🌓</span>
        </button>
    </div>

    {{-- Main Container (with .sign-up-mode toggle) --}}
    <div class="container {{ $isRegister ? 'sign-up-mode' : '' }}" id="authContainer">
        <div class="forms-container">
            <div class="signin-signup">
                
                {{-- ═══════════════════════════════════════════════════════════
                     SIGN IN FORM
                     ═══════════════════════════════════════════════════════════ --}}
                <form class="sign-in-form" method="POST" action="{{ route('login.process') }}">
                    @csrf
                    <input type="hidden" name="form_type" value="login">

                    <div class="brand-badge">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam">
                        <span>Portal Pendidik & Staf</span>
                    </div>

                    <h2 class="title">Sign in</h2>
                    <p class="subtitle-text">Selamat datang kembali! Masuk untuk melanjutkan.</p>

                    @if (session('status'))
                        <div class="alert-box success">
                            <span>✓</span>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    @if ($errors->any() && old('form_type') !== 'register')
                        <div class="alert-box danger">
                            <span>⚠️</span>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    {{-- Email Field --}}
                    <div class="input-field no-toggle">
                        <i>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </i>
                        <input type="email" name="email" value="{{ old('form_type') === 'register' ? '' : old('email') }}" placeholder="Email" required autofocus autocomplete="username" />
                    </div>

                    {{-- Password Field --}}
                    <div class="input-field">
                        <i>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </i>
                        <input type="password" name="password" id="login_password" placeholder="Password" required autocomplete="current-password" />
                        <button type="button" class="btn-field-toggle" data-toggle-password="login_password" aria-label="Tampilkan kata sandi">
                            <span class="eye-icon">👁️</span>
                        </button>
                    </div>

                    <div class="form-meta-row">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <input type="submit" value="Login" class="btn solid" />

                    <div class="mobile-switch-text">
                        Belum punya akun? <a href="javascript:void(0)" data-switch-action="signup">Daftar sekarang</a>
                    </div>

                    <p class="social-text">Or sign in with social platforms</p>

                    {{-- Social Icons --}}
                    <div class="social-media">
                        {{-- Google --}}
                        <a href="javascript:void(0)" class="social-icon" title="Google" aria-label="Google">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                            </svg>
                        </a>
                        {{-- Facebook --}}
                        <a href="javascript:void(0)" class="social-icon" title="Facebook" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="#1877F2">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        {{-- Twitter (X) --}}
                        <a href="javascript:void(0)" class="social-icon" title="Twitter" aria-label="Twitter">
                            <svg viewBox="0 0 24 24" fill="#1DA1F2">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        {{-- LinkedIn --}}
                        <a href="javascript:void(0)" class="social-icon" title="LinkedIn" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" fill="#0A66C2">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    </div>
                </form>

                {{-- ═══════════════════════════════════════════════════════════
                     SIGN UP FORM
                     ═══════════════════════════════════════════════════════════ --}}
                <form class="sign-up-form" method="POST" action="{{ route('register.process') }}">
                    @csrf
                    <input type="hidden" name="form_type" value="register">

                    <div class="brand-badge">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam">
                        <span>Pendaftaran Akun Baru</span>
                    </div>

                    <h2 class="title">Sign up</h2>
                    <p class="subtitle-text">Lengkapi formulir untuk membuat akun staf atau guru.</p>

                    @if ($errors->any() && (old('form_type') === 'register' || $isRegister))
                        <div class="alert-box danger">
                            <span>⚠️</span>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    {{-- Username / Name Field --}}
                    <div class="input-field no-toggle">
                        <i>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </i>
                        <input type="text" name="name" value="{{ old('form_type') === 'register' ? old('name') : '' }}" placeholder="Username / Nama Lengkap" required autocomplete="name" />
                    </div>

                    {{-- Email Field --}}
                    <div class="input-field no-toggle">
                        <i>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </i>
                        <input type="email" name="email" value="{{ old('form_type') === 'register' ? old('email') : '' }}" placeholder="Email" required autocomplete="email" />
                    </div>

                    {{-- Password Field --}}
                    <div class="input-field">
                        <i>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </i>
                        <input type="password" name="password" id="reg_password" placeholder="Password" required autocomplete="new-password" />
                        <button type="button" class="btn-field-toggle" data-toggle-password="reg_password" aria-label="Tampilkan kata sandi">
                            <span class="eye-icon">👁️</span>
                        </button>
                    </div>

                    {{-- Password Confirmation Field --}}
                    <div class="input-field">
                        <i>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </i>
                        <input type="password" name="password_confirmation" id="reg_password_confirmation" placeholder="Ulangi Password" required autocomplete="new-password" />
                        <button type="button" class="btn-field-toggle" data-toggle-password="reg_password_confirmation" aria-label="Tampilkan kata sandi">
                            <span class="eye-icon">👁️</span>
                        </button>
                    </div>

                    <input type="submit" value="Sign up" class="btn" />

                    <div class="mobile-switch-text">
                        Sudah punya akun? <a href="javascript:void(0)" data-switch-action="signin">Masuk sekarang</a>
                    </div>

                    <p class="social-text">Or sign up with social platforms</p>

                    {{-- Social Icons --}}
                    <div class="social-media">
                        {{-- Google --}}
                        <a href="javascript:void(0)" class="social-icon" title="Google" aria-label="Google">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                            </svg>
                        </a>
                        {{-- Facebook --}}
                        <a href="javascript:void(0)" class="social-icon" title="Facebook" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="#1877F2">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        {{-- Twitter (X) --}}
                        <a href="javascript:void(0)" class="social-icon" title="Twitter" aria-label="Twitter">
                            <svg viewBox="0 0 24 24" fill="#1DA1F2">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                        {{-- LinkedIn --}}
                        <a href="javascript:void(0)" class="social-icon" title="LinkedIn" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" fill="#0A66C2">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                    </div>
                </form>

            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             PANELS CONTAINER (LEFT & RIGHT)
             ═══════════════════════════════════════════════════════════ --}}
        <div class="panels-container">
            {{-- Left Panel: shown when in Sign-in mode --}}
            <div class="panel left-panel">
                <div class="content">
                    <div class="panel-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo At-Tamam">
                    </div>
                    <h3>New here?</h3>
                    <p>Join us today and discover a world of possibilities. Create your account in seconds!</p>
                    <button class="btn transparent" id="sign-up-btn" type="button">Sign up</button>
                </div>
            </div>

            {{-- Right Panel: shown when in Sign-up mode --}}
            <div class="panel right-panel">
                <div class="content">
                    <div class="panel-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo At-Tamam">
                    </div>
                    <h3>One of us?</h3>
                    <p>Welcome back! Sign in to continue your journey with us.</p>
                    <button class="btn transparent" id="sign-in-btn" type="button">Sign in</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         VANILLA JAVASCRIPT LOGIC (REPLACING REACT)
         ═══════════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('authContainer');
            const signUpBtn = document.getElementById('sign-up-btn');
            const signInBtn = document.getElementById('sign-in-btn');
            const themeBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');

            // 1. Core Auth Switch Function
            function setSignUpMode(isSignUp) {
                if (!container) return;
                
                if (isSignUp) {
                    container.classList.add('sign-up-mode');
                } else {
                    container.classList.remove('sign-up-mode');
                }

                // Smooth URL state update without page reloading
                if (window.history && window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.set('tab', isSignUp ? 'register' : 'login');
                    window.history.replaceState({}, '', url);
                }

                // Focus first input in newly active form
                setTimeout(() => {
                    const activeForm = isSignUp 
                        ? container.querySelector('.sign-up-form') 
                        : container.querySelector('.sign-in-form');
                    if (activeForm) {
                        const firstInput = activeForm.querySelector('input:not([type="hidden"])');
                        if (firstInput) firstInput.focus();
                    }
                }, 350);
            }

            // 2. Click Listeners on Main Action Buttons
            if (signUpBtn) {
                signUpBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    setSignUpMode(true);
                });
            }

            if (signInBtn) {
                signInBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    setSignUpMode(false);
                });
            }

            // 3. Mobile / Secondary Switch Links
            document.querySelectorAll('[data-switch-action]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const action = btn.getAttribute('data-switch-action');
                    setSignUpMode(action === 'signup');
                });
            });

            // 4. Password Visibility Toggle Logic
            document.querySelectorAll('[data-toggle-password]').forEach(toggleBtn => {
                toggleBtn.addEventListener('click', () => {
                    const targetId = toggleBtn.getAttribute('data-toggle-password');
                    const input = document.getElementById(targetId);
                    const icon = toggleBtn.querySelector('.eye-icon');
                    if (!input) return;

                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    if (icon) {
                        icon.textContent = isPassword ? '🙈' : '👁️';
                    }
                    toggleBtn.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
                });
            });

            // 5. Dark / Light Theme Toggle Logic
            function updateThemeUI(theme) {
                if (themeIcon) {
                    themeIcon.textContent = theme === 'dark' ? '🌙' : '☀️';
                }
            }

            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            updateThemeUI(currentTheme);

            if (themeBtn) {
                themeBtn.addEventListener('click', () => {
                    const activeTheme = document.documentElement.getAttribute('data-theme') || 'light';
                    const nextTheme = activeTheme === 'dark' ? 'light' : 'dark';
                    document.documentElement.setAttribute('data-theme', nextTheme);
                    localStorage.setItem('auth_theme', nextTheme);
                    localStorage.setItem('site_theme', nextTheme);
                    updateThemeUI(nextTheme);

                    // Spring rotation feedback
                    themeBtn.style.transition = 'transform 0.5s cubic-bezier(0.68, -0.6, 0.32, 1.6)';
                    themeBtn.style.transform = 'scale(0.85) rotate(360deg)';
                    setTimeout(() => {
                        themeBtn.style.transform = '';
                    }, 500);
                });
            }
        });
    </script>
</body>
</html>
