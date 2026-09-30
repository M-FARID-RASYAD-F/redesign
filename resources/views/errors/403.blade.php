<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | PKBM Tahfizh At-Tamam</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}">

    <!-- Theme Initialization Script -->
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

    <style>
        :root, [data-theme="dark"] {
            --bg-base: #001529;
            --bg-gradient: radial-gradient(circle at 50% 20%, rgba(0, 180, 216, 0.15) 0%, transparent 60%),
                           radial-gradient(circle at 80% 80%, rgba(2, 62, 138, 0.25) 0%, transparent 50%),
                           #001529;
            --card-bg: rgba(0, 33, 71, 0.85);
            --card-border: rgba(0, 180, 216, 0.35);
            --text-title: #ffffff;
            --text-body: #cbd5e1;
            --text-muted: #94a3b8;
            --primary: #00B4D8;
            --primary-hover: #38bdf8;
            --primary-text: #001529;
            --danger: #f87171;
            --danger-bg: rgba(239, 68, 68, 0.15);
            --danger-border: rgba(239, 68, 68, 0.35);
            --btn-outline-border: rgba(255, 255, 255, 0.2);
            --btn-outline-text: #f1f5f9;
            --btn-outline-hover: rgba(255, 255, 255, 0.08);
            --shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.6), 0 0 30px rgba(0, 180, 216, 0.12);
        }

        [data-theme="light"] {
            --bg-base: #f8fafc;
            --bg-gradient: radial-gradient(circle at 50% 10%, rgba(0, 180, 216, 0.08) 0%, transparent 50%), #f8fafc;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-title: #0f172a;
            --text-body: #475569;
            --text-muted: #64748b;
            --primary: #0284c7;
            --primary-hover: #0369a1;
            --primary-text: #ffffff;
            --danger: #dc2626;
            --danger-bg: #fee2e2;
            --danger-border: #fca5a5;
            --btn-outline-border: #cbd5e1;
            --btn-outline-text: #334155;
            --btn-outline-hover: #f1f5f9;
            --shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: var(--bg-gradient);
            background-color: var(--bg-base);
            color: var(--text-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            text-align: center;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .error-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 44px 36px;
            max-width: 540px;
            width: 100%;
            box-shadow: var(--shadow);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-header {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            text-decoration: none;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
        }

        .brand-text-block {
            text-align: left;
        }

        .brand-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-title);
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.72rem;
            color: var(--text-muted);
            letter-spacing: 0.02em;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            color: var(--danger);
            border-radius: 999px;
            font-size: 0.82rem;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .status-badge svg {
            flex-shrink: 0;
        }

        .error-code {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.04em;
            color: var(--text-title);
            margin-bottom: 8px;
        }

        .error-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 12px;
        }

        .error-message {
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--text-body);
            margin-bottom: 28px;
        }

        .actions-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 10px;
            font-size: 0.92rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            font-family: inherit;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .btn-primary {
            background: var(--primary);
            color: var(--primary-text);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-secondary {
            background: rgba(0, 180, 216, 0.15);
            color: var(--primary);
            border-color: rgba(0, 180, 216, 0.35);
        }

        .btn-secondary:hover {
            background: rgba(0, 180, 216, 0.25);
        }

        .btn-outline {
            background: transparent;
            color: var(--btn-outline-text);
            border-color: var(--btn-outline-border);
        }

        .btn-outline:hover {
            background: var(--btn-outline-hover);
        }

        .footer-note {
            margin-top: 24px;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        @media (max-width: 480px) {
            .error-card {
                padding: 32px 20px;
            }
            .error-code {
                font-size: 3.8rem;
            }
            .actions-group {
                flex-direction: column;
                width: 100%;
            }
            .actions-group .btn,
            .actions-group form {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="error-card">
        <!-- Logo & Branding Sekolah -->
        <a href="{{ route('home') }}" class="brand-header" title="Kembali ke Beranda Utama">
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo Resmi PKBM Tahfizh At-Tamam" class="brand-logo">
            <div class="brand-text-block">
                <div class="brand-title">PKBM Tahfizh At-Tamam</div>
                <div class="brand-subtitle">Sekolah Unggulan Berkarakter Qurani</div>
            </div>
        </a>

        <!-- Badge Status -->
        <div>
            <span class="status-badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                </svg>
                HTTP 403 Forbidden
            </span>
        </div>

        <div class="error-code">403</div>
        <h1 class="error-title">Akses Ditolak!</h1>
        <p class="error-message">
            {{ $exception->getMessage() ?: 'Anda tidak diizinkan mengakses halaman ini. Periksa kembali peran akun Anda atau hubungi Administrator jika ini merupakan kesalahan.' }}
        </p>

        <!-- Tombol Aksi Terintegrasi -->
        <div class="actions-group">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                Kembali ke Beranda
            </a>

            @auth
                <a href="{{ Auth::user()->dashboard_url }}" class="btn btn-secondary">Dashboard {{ Auth::user()->role_label }}</a>

                <form method="POST" action="{{ route('logout') }}" style="display: inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    Halaman Login
                </a>
            @endauth
        </div>
    </div>

    <div class="footer-note">
        &copy; {{ date('Y') }} PKBM Tahfizh At-Tamam Edu Portal. Hak Cipta Dilindungi.
    </div>

</body>
</html>
