@php
    $defaultTab = $defaultTab ?? request()->query('tab', old('form_type') === 'register' || $errors->has('name') || $errors->has('password_confirmation') ? 'register' : 'login');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Guru & Admin — PKBM Tahfizh At-Tamam</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-base: #070d1e;
            --bg-card: rgba(15, 23, 42, 0.92);
            --border-card: rgba(0, 180, 216, 0.35);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --input-bg: rgba(30, 41, 59, 0.65);
            --input-border: rgba(255, 255, 255, 0.12);
            --input-focus-border: #00B4D8;
            --input-focus-glow: rgba(0, 180, 216, 0.3);
            --btn-gradient: linear-gradient(135deg, #00B4D8 0%, #0077B6 100%);
            --btn-shadow: 0 10px 25px rgba(0, 180, 216, 0.35);
            --btn-shadow-hover: 0 14px 30px rgba(0, 180, 216, 0.55);
            --tab-bg: rgba(30, 41, 59, 0.8);
            --tab-pill-bg: linear-gradient(135deg, rgba(0, 180, 216, 0.28) 0%, rgba(0, 119, 182, 0.4) 100%);
            --tab-pill-border: rgba(0, 180, 216, 0.65);
            --tab-pill-shadow: 0 0 20px rgba(0, 180, 216, 0.3);
            --tab-active-text: #38bdf8;
            --back-link-hover: #38bdf8;
            --accent-link: #38bdf8;
            --orb-1: rgba(0, 180, 216, 0.18);
            --orb-2: rgba(0, 119, 182, 0.14);
            --grid-line: rgba(255, 255, 255, 0.03);
        }

        [data-theme="light"] {
            --bg-base: #f8fafc;
            --bg-card: rgba(255, 255, 255, 0.96);
            --border-card: #e2e8f0;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --input-bg: #f8fafc;
            --input-border: #cbd5e1;
            --input-focus-border: #b91c1c;
            --input-focus-glow: rgba(185, 28, 28, 0.2);
            --btn-gradient: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            --btn-shadow: 0 10px 25px rgba(185, 28, 28, 0.25);
            --btn-shadow-hover: 0 14px 30px rgba(185, 28, 28, 0.45);
            --tab-bg: #f1f5f9;
            --tab-pill-bg: #ffffff;
            --tab-pill-border: #cbd5e1;
            --tab-pill-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --tab-active-text: #b91c1c;
            --back-link-hover: #b91c1c;
            --accent-link: #b91c1c;
            --orb-1: rgba(185, 28, 28, 0.08);
            --orb-2: rgba(127, 29, 29, 0.06);
            --grid-line: rgba(0, 0, 0, 0.03);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: "Plus Jakarta Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-base);
            color: var(--text-primary);
            position: relative;
            overflow-x: hidden;
            padding: 2.5rem 1.25rem;
            transition: background 0.4s cubic-bezier(0.16, 1, 0.3, 1), color 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* ═══════════════════════════════════════════════════════════
           AMBIENT BACKGROUND GLOWS & GRID (NO EXTERNAL IMAGES)
           ═══════════════════════════════════════════════════════════ */
        .ambient-bg {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .ambient-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.8;
            pointer-events: none;
        }

        .orb-top-left {
            width: 450px;
            height: 450px;
            top: -120px;
            left: -120px;
            background: var(--orb-1);
            animation: orbFloat 14s ease-in-out infinite alternate;
        }

        .orb-bottom-right {
            width: 500px;
            height: 500px;
            bottom: -150px;
            right: -150px;
            background: var(--orb-2);
            animation: orbFloat 18s ease-in-out infinite alternate-reverse;
        }

        .ambient-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(to right, var(--grid-line) 1px, transparent 1px),
                linear-gradient(to bottom, var(--grid-line) 1px, transparent 1px);
            background-size: 36px 36px;
            mask-image: radial-gradient(circle at center, black 40%, transparent 80%);
            -webkit-mask-image: radial-gradient(circle at center, black 40%, transparent 80%);
        }

        @keyframes orbFloat {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, 30px) scale(1.08); }
            100% { transform: translate(-20px, 50px) scale(0.95); }
        }

        /* ═══════════════════════════════════════════════════════════
           AUTHENTICATION CARD
           ═══════════════════════════════════════════════════════════ */
        .auth-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            background: var(--bg-card);
            border-radius: 26px;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.45);
            padding: 2.75rem 2.5rem;
            border: 1.5px solid var(--border-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
            animation: cardEntrance 0.65s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @media (max-width: 540px) {
            .auth-card {
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(35px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ═══════════════════════════════════════════════════════════
           BRAND HEADER
           ═══════════════════════════════════════════════════════════ */
        .login-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .login-brand-icon {
            width: 62px;
            height: 62px;
            border-radius: 18px;
            background: #ffffff;
            border: 2px solid rgba(0, 180, 216, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.25);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            margin-bottom: 1rem;
        }

        .auth-card:hover .login-brand-icon {
            transform: scale(1.08) rotate(-4deg);
        }

        .login-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .login-brand-text h1 {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.01em;
            line-height: 1.25;
            margin-bottom: 0.25rem;
        }

        .login-brand-text span {
            font-size: 0.84rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        /* ═══════════════════════════════════════════════════════════
           1-CARD ANIMATED TABS SWITCHER (SLIDING PILL)
           ═══════════════════════════════════════════════════════════ */
        .auth-tabs-container {
            position: relative;
            background: var(--tab-bg);
            border-radius: 14px;
            padding: 5px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 1.75rem;
            border: 1px solid var(--input-border);
            user-select: none;
        }

        .auth-tab-pill {
            position: absolute;
            top: 5px;
            bottom: 5px;
            width: calc(50% - 5px);
            left: 5px;
            background: var(--tab-pill-bg);
            border: 1px solid var(--tab-pill-border);
            border-radius: 10px;
            box-shadow: var(--tab-pill-shadow);
            backdrop-filter: blur(8px);
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            pointer-events: none;
            z-index: 1;
        }

        .auth-tabs-container[data-active-tab="register"] .auth-tab-pill {
            transform: translateX(100%);
        }

        .auth-tab-btn {
            position: relative;
            z-index: 2;
            background: none;
            border: none;
            padding: 0.68rem 0.85rem;
            font-size: 0.88rem;
            font-weight: 700;
            font-family: inherit;
            color: var(--text-secondary);
            cursor: pointer;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: color 0.25s ease;
            outline: none;
        }

        .auth-tab-btn:hover {
            color: var(--text-primary);
        }

        .auth-tab-btn.is-active {
            color: var(--tab-active-text);
        }

        [data-theme="light"] .auth-tab-btn.is-active {
            color: #0f172a;
        }

        /* ═══════════════════════════════════════════════════════════
           PANELS & FORM STYLING
           ═══════════════════════════════════════════════════════════ */
        .auth-panels-wrapper {
            position: relative;
            width: 100%;
        }

        .auth-panel {
            display: none;
            width: 100%;
        }

        .auth-panel.is-active {
            display: block;
            animation: tabFadeSlideIn 0.42s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes tabFadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.98);
                filter: blur(4px);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0px);
            }
        }

        .panel-header {
            margin-bottom: 1.35rem;
        }

        .login-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 0.3rem;
            letter-spacing: -0.01em;
        }

        .login-subtitle {
            font-size: 0.84rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 1.15rem;
        }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.4rem;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            padding: 0.78rem 1rem;
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            font-size: 0.9rem;
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
            font-size: 1.05rem;
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
            margin-bottom: 1.35rem;
            gap: 0.5rem;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.82rem;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: #00B4D8;
            cursor: pointer;
        }

        .role-badge-info {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.25);
            padding: 0.65rem 0.85rem;
            border-radius: 10px;
            font-size: 0.78rem;
            color: #38bdf8;
            margin-bottom: 1.25rem;
            line-height: 1.4;
        }

        [data-theme="light"] .role-badge-info {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .btn-submit {
            width: 100%;
            padding: 0.88rem 1.4rem;
            border: none;
            border-radius: 12px;
            background: var(--btn-gradient);
            color: #ffffff;
            font-size: 0.96rem;
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

        .btn-submit:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--btn-shadow-hover);
        }

        .btn-submit:active {
            transform: translateY(1px) scale(0.97);
            transition-duration: 0.12s;
        }

        .switch-prompt {
            margin-top: 1.25rem;
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-secondary);
        }

        .switch-prompt a {
            color: var(--accent-link);
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: text-decoration 0.2s;
        }

        .switch-prompt a:hover {
            text-decoration: underline;
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 1.4rem;
            padding-top: 1.2rem;
            border-top: 1px solid var(--input-border);
            font-size: 0.84rem;
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
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
            font-weight: 600;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.4);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            font-size: 0.85rem;
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

    {{-- Ambient Lighting & Grid Background --}}
    <div class="ambient-bg">
        <div class="ambient-orb orb-top-left"></div>
        <div class="ambient-orb orb-bottom-right"></div>
        <div class="ambient-grid"></div>
    </div>

    {{-- Centered 1-Card Auth Interface --}}
    <div class="auth-card" data-auth-container data-default-tab="{{ $defaultTab }}">
        {{-- Brand Header --}}
        <div class="login-brand">
            <div class="login-brand-icon">
                <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam">
            </div>
            <div class="login-brand-text">
                <h1>PKBM Tahfizh At-Tamam</h1>
                <span>Portal Guru & Staf Administrasi</span>
            </div>
        </div>

        {{-- 1-Card Animated Tabs Switcher --}}
        <div class="auth-tabs-container" data-tabs-wrapper data-active-tab="{{ $defaultTab }}">
            <div class="auth-tab-pill"></div>
            <button
                type="button"
                class="auth-tab-btn {{ $defaultTab === 'login' ? 'is-active' : '' }}"
                data-tab-target="login"
            >
                <span>🔑 Masuk</span>
            </button>
            <button
                type="button"
                class="auth-tab-btn {{ $defaultTab === 'register' ? 'is-active' : '' }}"
                data-tab-target="register"
            >
                <span>📝 Daftar Akun</span>
            </button>
        </div>

        {{-- Status & Error Messages --}}
        @if (session('status'))
            <div class="alert-status">✓ {{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">⚠️ {{ $errors->first() }}</div>
        @endif

        {{-- Panels Container --}}
        <div class="auth-panels-wrapper">
            {{-- TAB 1: LOGIN PANEL --}}
            <div class="auth-panel {{ $defaultTab === 'login' ? 'is-active' : '' }}" data-panel="login">
                <div class="panel-header">
                    <h2 class="login-title">Masuk ke Akun Anda</h2>
                    <p class="login-subtitle">Masukkan email dan kata sandi yang telah terdaftar.</p>
                </div>

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf
                    <input type="hidden" name="form_type" value="login">

                    <div class="form-group">
                        <label class="form-label" for="login_email">Alamat Email</label>
                        <div class="input-wrap">
                            <input class="form-input" id="login_email" type="email" name="email" value="{{ old('form_type') === 'register' ? '' : old('email') }}" required autofocus autocomplete="username" placeholder="guru@attamam.sch.id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="login_password">Kata Sandi</label>
                        <div class="input-wrap">
                            <input class="form-input" id="login_password" type="password" name="password" data-password-input required autocomplete="current-password" placeholder="••••••••">
                            <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                                <span data-eye-icon>👁️</span>
                            </button>
                        </div>
                    </div>

                    <div class="form-row">
                        <label class="remember">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>🚀 Masuk ke Portal</span>
                    </button>
                </form>

                <div class="switch-prompt">
                    Belum memiliki akun? <a href="javascript:void(0)" data-switch-to="register">Daftar staf/guru baru</a>
                </div>
            </div>

            {{-- TAB 2: REGISTER PANEL --}}
            <div class="auth-panel {{ $defaultTab === 'register' ? 'is-active' : '' }}" data-panel="register">
                <div class="panel-header">
                    <h2 class="login-title">Pendaftaran Akun Baru</h2>
                    <p class="login-subtitle">Lengkapi formulir untuk membuat akun pendidik/staf.</p>
                </div>

                <div class="role-badge-info">
                    <span>ℹ️</span>
                    <span>Akun baru otomatis didaftarkan sebagai <strong>Editor Akademik & Staf</strong>.</span>
                </div>

                <form method="POST" action="{{ route('register.process') }}">
                    @csrf
                    <input type="hidden" name="form_type" value="register">

                    <div class="form-group">
                        <label class="form-label" for="reg_name">Nama Lengkap & Gelar</label>
                        <div class="input-wrap">
                            <input class="form-input" id="reg_name" type="text" name="name" value="{{ old('form_type') === 'register' ? old('name') : '' }}" required autocomplete="name" placeholder="Contoh: Ahmad Dahlan, S.Pd">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_email">Alamat Email</label>
                        <div class="input-wrap">
                            <input class="form-input" id="reg_email" type="email" name="email" value="{{ old('form_type') === 'register' ? old('email') : '' }}" required autocomplete="username" placeholder="nama@attamam.sch.id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_password">Kata Sandi</label>
                        <div class="input-wrap">
                            <input class="form-input" id="reg_password" type="password" name="password" data-password-input required autocomplete="new-password" placeholder="Minimal 8 karakter">
                            <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                                <span data-eye-icon>👁️</span>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="input-wrap">
                            <input class="form-input" id="reg_password_confirmation" type="password" name="password_confirmation" data-password-input required autocomplete="new-password" placeholder="Ulangi kata sandi">
                            <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                                <span data-eye-icon>👁️</span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <span>✨ Daftarkan Akun</span>
                    </button>
                </form>

                <div class="switch-prompt">
                    Sudah memiliki akun? <a href="javascript:void(0)" data-switch-to="login">Masuk ke akun Anda</a>
                </div>
            </div>
        </div>

        {{-- Back to Home --}}
        <a href="{{ route('home') }}" class="back-home">
            <span>← Kembali ke Halaman Utama</span>
        </a>
    </div>

    {{-- Interactive Tabs & Password Toggle Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('[data-auth-container]');
            if (!container) return;

            const tabsWrapper = container.querySelector('[data-tabs-wrapper]');
            const tabButtons = container.querySelectorAll('[data-tab-target]');
            const panels = container.querySelectorAll('[data-panel]');
            const switchLinks = container.querySelectorAll('[data-switch-to]');

            function switchTab(targetTab) {
                // Update tabs container active state for pill slide animation
                if (tabsWrapper) {
                    tabsWrapper.setAttribute('data-active-tab', targetTab);
                }

                // Update tab buttons
                tabButtons.forEach(btn => {
                    const isActive = btn.getAttribute('data-tab-target') === targetTab;
                    btn.classList.toggle('is-active', isActive);
                });

                // Update panels with entrance animation
                panels.forEach(panel => {
                    const isTarget = panel.getAttribute('data-panel') === targetTab;
                    if (isTarget) {
                        panel.classList.remove('is-active');
                        void panel.offsetWidth; // force DOM reflow to trigger animation
                        panel.classList.add('is-active');

                        // Focus the first input inside the active panel
                        const firstInput = panel.querySelector('input:not([type="hidden"])');
                        if (firstInput) {
                            setTimeout(() => firstInput.focus(), 150);
                        }
                    } else {
                        panel.classList.remove('is-active');
                    }
                });

                // Update URL parameter without reload (if supported)
                if (window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.set('tab', targetTab);
                    window.history.replaceState({}, '', url);
                }
            }

            // Tab button clicks
            tabButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = btn.getAttribute('data-tab-target');
                    switchTab(target);
                });
            });

            // Quick switch links ("Daftar sekarang" / "Masuk sekarang")
            switchLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = link.getAttribute('data-switch-to');
                    switchTab(target);
                });
            });

            // Password Toggle Logic
            container.querySelectorAll('[data-password-toggle]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const wrap = btn.closest('.input-wrap');
                    if (!wrap) return;
                    const input = wrap.querySelector('[data-password-input]') || wrap.querySelector('input[type="password"], input[type="text"]');
                    const eye = btn.querySelector('[data-eye-icon]');
                    if (!input) return;

                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    if (eye) {
                        eye.textContent = isPassword ? '🙈' : '👁️';
                    }
                    btn.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Lihat kata sandi');
                });
            });
        });
    </script>
</body>
</html>
