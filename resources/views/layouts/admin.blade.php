<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>@yield('title', 'Admin Panel - At-Tamam Edu')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Script Anti-Flicker Sinkronisasi Tema dengan Halaman Utama -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('site_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    
    <style>
        /* ═══════════════════════════════════════════════════════════
           CSS CUSTOM PROPERTIES / TOKENS (DUAL THEME ENGINE)
           ═══════════════════════════════════════════════════════════ */
        
        /* 1. Tipe 1: Dark Mode (Oxford Navy & Cyan Neon 🌙) */
        :root, [data-theme="dark"] {
            --adm-bg: #001529;
            --adm-bg-gradient: radial-gradient(circle at 12% 18%, rgba(0, 180, 216, 0.16) 0%, transparent 45%),
                               radial-gradient(circle at 88% 82%, rgba(0, 40, 90, 0.6) 0%, transparent 50%),
                               #001529;
            --adm-sidebar-bg: linear-gradient(180deg, rgba(0, 33, 71, 0.98) 0%, rgba(6, 16, 32, 0.99) 100%);
            --adm-topbar-bg: rgba(0, 21, 41, 0.88);
            --adm-card-bg: rgba(0, 33, 71, 0.78);
            --adm-card-solid: #002147;
            --adm-card-hover: rgba(0, 48, 96, 0.92);
            --adm-border: rgba(0, 180, 216, 0.32);
            --adm-border-hover: rgba(56, 189, 248, 0.65);
            --adm-border-glow: rgba(0, 180, 216, 0.48);
            --adm-primary: #00B4D8;
            --adm-primary-hover: #38bdf8;
            --adm-primary-gradient: linear-gradient(135deg, #00B4D8 0%, #0077b6 100%);
            --adm-primary-glow: rgba(0, 180, 216, 0.42);
            
            /* Teks Sangat Kontras & Tajam */
            --adm-text-title: #ffffff;
            --adm-text-main: #ffffff;
            --adm-text-sub: #f1f5f9;
            --adm-text-muted: #cbd5e1; /* Terang dan tajam di atas latar navy */
            
            --adm-accent-cyan: #00B4D8;
            --adm-accent-sky: #38bdf8;
            --adm-badge-info-bg: rgba(0, 180, 216, 0.22);
            --adm-badge-info-text: #38bdf8;
            --adm-table-hover: rgba(0, 180, 216, 0.10);
            --adm-table-border: rgba(255, 255, 255, 0.12);
            --adm-shadow: 0 14px 40px rgba(0, 12, 28, 0.65), 0 0 25px rgba(0, 180, 216, 0.15);
            --adm-orb-color: rgba(0, 180, 216, 0.18);

            /* Mapping ke variabel legacy */
            --primary: #00B4D8;
            --primary-hover: #38bdf8;
            --secondary: #001529;
            --bg-body: var(--adm-bg);
            --bg-card: var(--adm-card-bg);
            --text-main: var(--adm-text-main);
            --text-muted: var(--adm-text-muted);
            --border: var(--adm-border);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow: var(--adm-shadow);
        }

        /* 2. Tipe 2: White / Light Mode (Deep Maroon & Crimson Rose ☀️ - btnswitch.md) */
        [data-theme="light"] {
            --adm-bg: oklch(41% 0.159 10.272); /* Sesuai btnswitch.md */
            --adm-bg-gradient: radial-gradient(circle at 12% 18%, oklch(58.6% 0.253 17.585 / 0.18) 0%, transparent 45%),
                               radial-gradient(circle at 88% 82%, oklch(27.1% 0.105 12.094 / 0.7) 0%, transparent 50%),
                               oklch(41% 0.159 10.272);
            --adm-sidebar-bg: linear-gradient(180deg, oklch(27.1% 0.105 12.094 / 0.98) 0%, oklch(18% 0.08 11 / 0.99) 100%);
            --adm-topbar-bg: oklch(27.1% 0.105 12.094 / 0.88);
            --adm-card-bg: oklch(27.1% 0.105 12.094 / 0.86);
            --adm-card-solid: oklch(27.1% 0.105 12.094);
            --adm-card-hover: oklch(33% 0.125 13 / 0.94);
            --adm-border: oklch(58.6% 0.253 17.585 / 0.42);
            --adm-border-hover: oklch(58.6% 0.253 17.585 / 0.72);
            --adm-border-glow: oklch(58.6% 0.253 17.585 / 0.5);
            --adm-primary: oklch(58.6% 0.253 17.585); /* Crimson Neon */
            --adm-primary-hover: oklch(65% 0.26 18);
            --adm-primary-gradient: linear-gradient(135deg, oklch(58.6% 0.253 17.585) 0%, oklch(48% 0.22 17) 100%);
            --adm-primary-glow: oklch(58.6% 0.253 17.585 / 0.48);
            
            /* Teks Sangat Kontras & Tajam */
            --adm-text-title: #ffffff;
            --adm-text-main: #ffffff;
            --adm-text-sub: #ffe4e6;
            --adm-text-muted: #fecdd3; /* Rose cerah, sangat kontras di atas maroon */
            
            --adm-accent-cyan: oklch(58.6% 0.253 17.585);
            --adm-accent-sky: #fb7185;
            --adm-badge-info-bg: oklch(58.6% 0.253 17.585 / 0.28);
            --adm-badge-info-text: #ffffff;
            --adm-table-hover: oklch(58.6% 0.253 17.585 / 0.12);
            --adm-table-border: rgba(255, 255, 255, 0.12);
            --adm-shadow: 0 14px 40px rgba(30, 4, 10, 0.65), 0 0 25px oklch(58.6% 0.253 17.585 / 0.25);
            --adm-orb-color: oklch(58.6% 0.253 17.585 / 0.2);

            /* Mapping ke variabel legacy */
            --primary: oklch(58.6% 0.253 17.585);
            --primary-hover: oklch(65% 0.26 18);
            --secondary: oklch(27.1% 0.105 12.094);
            --bg-body: var(--adm-bg);
            --bg-card: var(--adm-card-bg);
            --text-main: var(--adm-text-main);
            --text-muted: var(--adm-text-muted);
            --border: var(--adm-border);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow: var(--adm-shadow);
        }

        /* ═══════════════════════════════════════════════════════════
           RESET & BASE STYLES
           ═══════════════════════════════════════════════════════════ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }

        html, body {
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
        }

        body {
            background: var(--adm-bg-gradient);
            background-color: var(--adm-bg);
            color: var(--adm-text-main);
            min-height: 100vh;
            display: flex;
            transition: background 0.35s cubic-bezier(0.16, 1, 0.3, 1), color 0.25s ease;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: -120px;
            right: -100px;
            width: 480px;
            height: 480px;
            background: var(--adm-orb-color);
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
            transition: background 0.5s ease;
        }

        /* ═══════════════════════════════════════════════════════════
           HIGH CONTRAST TEXT OVERRIDES (SOLUSI TULISAN KURANG JELAS)
           ═══════════════════════════════════════════════════════════ */
        
        /* Paksa warna putih terang pada elemen yang sebelumnya memakai hardcoded dark color */
        [style*="color: #0f172a"], [style*="color:#0f172a"],
        [style*="color: #334155"], [style*="color:#334155"],
        [style*="color: #475569"], [style*="color:#475569"],
        [style*="color: #1e293b"], [style*="color:#1e293b"] {
            color: #ffffff !important;
            font-weight: 700 !important;
        }

        /* Paksa teks muted menjadi terang & tajam */
        .text-muted,
        [style*="color: var(--text-muted)"],
        [style*="color:var(--text-muted)"] {
            color: var(--adm-text-muted) !important;
        }

        .header-title, h1, h2, h3, h4, h5, h6,
        .card h3, .card h4, .card-title {
            color: #ffffff !important;
            font-weight: 800 !important;
            letter-spacing: -0.01em;
        }

        .header p {
            color: var(--adm-text-sub) !important;
            font-size: 0.92rem;
            line-height: 1.5;
            margin-top: 4px;
        }

        /* Avatar default guru yang sebelumnya kusam */
        div[style*="background: #e2e8f0"],
        div[style*="background:#e2e8f0"] {
            background: var(--adm-primary-gradient) !important;
            color: #ffffff !important;
            border: 1.5px solid var(--adm-border) !important;
        }

        /* ═══════════════════════════════════════════════════════════
           SIDEBAR STYLING & DRAWER
           ═══════════════════════════════════════════════════════════ */
        .sidebar {
            width: 275px;
            background: var(--adm-sidebar-bg);
            border-right: 1.5px solid var(--adm-border);
            color: #ffffff;
            padding: 22px 18px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 6px 0 35px rgba(0, 0, 0, 0.4);
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        }

        .sidebar-brand-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 22px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            padding: 8px 10px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--adm-border);
            flex: 1;
            transition: all 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .sidebar-brand:hover {
            border-color: var(--adm-primary);
            box-shadow: 0 0 20px var(--adm-primary-glow);
            transform: translateY(-2px);
        }

        .brand-logo-wrap {
            width: 38px;
            height: 38px;
            background: #ffffff;
            border-radius: 10px;
            padding: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            flex-shrink: 0;
        }

        .brand-logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-meta {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .brand-title {
            font-size: 0.92rem;
            font-weight: 800;
            color: #ffffff;
            white-space: nowrap;
            letter-spacing: 0.01em;
        }

        .brand-badge {
            font-size: 0.66rem;
            font-weight: 700;
            color: var(--adm-primary);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .sidebar-close-btn {
            display: none;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.08);
            border: 1.5px solid var(--adm-border);
            color: #ffffff;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .sidebar-close-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.5);
            color: #fca5a5;
        }

        .sidebar-category {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--adm-text-muted);
            padding: 8px 12px 4px 12px;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
            overflow-y: auto;
            padding-right: 2px;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: var(--adm-border);
            border-radius: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            color: var(--adm-text-sub);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: 10px;
            position: relative;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .sidebar-link-icon {
            font-size: 1.15rem;
            width: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: var(--adm-primary-gradient);
            color: #ffffff;
            box-shadow: 0 4px 20px var(--adm-primary-glow);
            font-weight: 700;
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 15%;
            height: 70%;
            width: 4px;
            background: #ffffff;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px #ffffff;
        }

        .sidebar-footer {
            margin-top: auto;
            border-top: 1px solid var(--adm-border);
            padding-top: 14px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .user-card-widget {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 11px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--adm-border);
            border-radius: 12px;
        }

        .user-avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--adm-primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #ffffff;
            font-size: 0.95rem;
            box-shadow: 0 2px 10px var(--adm-primary-glow);
            flex-shrink: 0;
        }

        .user-meta-info {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .user-meta-name {
            font-size: 0.84rem;
            font-weight: 700;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-meta-role {
            font-size: 0.68rem;
            color: var(--adm-text-muted);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .role-indicator-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px #10b981;
        }

        .btn-sidebar-action {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 11px;
            color: var(--adm-text-sub);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-sidebar-action:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
        }

        .btn-sidebar-logout {
            color: #fca5a5 !important;
        }
        .btn-sidebar-logout:hover {
            background: rgba(239, 68, 68, 0.18) !important;
            color: #ffffff !important;
        }

        /* ═══════════════════════════════════════════════════════════
           MAIN CONTAINER & TOPBAR
           ═══════════════════════════════════════════════════════════ */
        .main-container {
            margin-left: 275px;
            flex: 1;
            padding: 24px 32px 50px 32px;
            width: calc(100% - 275px);
            min-height: 100vh;
            position: relative;
            z-index: 1;
            overflow-x: hidden;
        }

        .admin-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            margin-bottom: 26px;
            border-radius: 16px;
            background: var(--adm-topbar-bg);
            border: 1.5px solid var(--adm-border);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: var(--adm-shadow);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-hamburger {
            display: none;
            background: rgba(255, 255, 255, 0.06);
            border: 1.5px solid var(--adm-border);
            color: #ffffff;
            padding: 8px 10px;
            border-radius: 10px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .topbar-hamburger:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: var(--adm-primary);
        }

        .topbar-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--adm-text-sub);
            background: rgba(255, 255, 255, 0.05);
            padding: 6px 12px;
            border-radius: 20px;
            border: 1px solid var(--adm-border);
            white-space: nowrap;
        }

        .status-dot-live {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            box-shadow: 0 0 10px #10b981;
            animation: pulseDot 2s infinite;
            flex-shrink: 0;
        }

        @keyframes pulseDot {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); opacity: 0.7; }
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .adm-theme-toggle {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
            border: 1.5px solid var(--adm-border);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            flex-shrink: 0;
        }

        .adm-theme-toggle:hover {
            border-color: var(--adm-primary);
            background: rgba(255, 255, 255, 0.14);
            box-shadow: 0 0 16px var(--adm-primary-glow);
            transform: translateY(-2px);
        }

        [data-theme="dark"] .icon-moon { display: inline-block; }
        [data-theme="dark"] .icon-sun  { display: none; }
        [data-theme="light"] .icon-moon { display: none; }
        [data-theme="light"] .icon-sun  { display: inline-block; }

        .btn-topbar-web {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.06);
            border: 1.5px solid var(--adm-border);
            white-space: nowrap;
            transition: all 0.28s ease;
        }

        .btn-topbar-web:hover {
            background: var(--adm-primary);
            border-color: var(--adm-primary);
            box-shadow: 0 4px 15px var(--adm-primary-glow);
            transform: translateY(-2px);
        }

        /* ═══════════════════════════════════════════════════════════
           KOMPONEN CONTENT, CARD, BUTTONS, & TABLES
           ═══════════════════════════════════════════════════════════ */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 26px;
        }

        .card {
            background: var(--adm-card-bg);
            border-radius: 16px;
            border: 1.5px solid var(--adm-border);
            box-shadow: var(--adm-shadow);
            padding: 24px;
            margin-bottom: 24px;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.3s ease;
            max-width: 100%;
            overflow: hidden;
        }

        .card:hover {
            border-color: var(--adm-border-hover);
        }

        /* Buttons System */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--adm-primary-gradient);
            color: #ffffff !important;
            box-shadow: 0 4px 16px var(--adm-primary-glow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 22px var(--adm-primary-glow);
            filter: brightness(1.1);
        }

        .btn-outline {
            border: 1.5px solid var(--adm-border);
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff !important;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: var(--adm-primary);
            color: var(--adm-primary) !important;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
        }
        .btn-danger:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
        }
        .btn-success:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        /* Table Styling with Smooth Horizontal Scrolling */
        .table-responsive {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 12px;
            border: 1px solid var(--adm-table-border);
            margin-bottom: 6px;
        }

        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: var(--adm-border);
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            padding: 14px 16px;
            font-weight: 800;
            color: #ffffff !important;
            border-bottom: 2px solid var(--adm-border);
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: rgba(0, 0, 0, 0.28);
            white-space: nowrap;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--adm-table-border);
            color: #ffffff !important;
            font-size: 0.9rem;
            transition: background 0.15s ease;
        }

        tr:hover td {
            background: var(--adm-table-hover);
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            font-size: 0.88rem;
            color: #ffffff !important;
        }

        .form-control {
            width: 100%;
            padding: 11px 16px;
            border: 1.5px solid var(--adm-border);
            border-radius: 10px;
            font-size: 0.9rem;
            color: #ffffff !important;
            background: rgba(0, 16, 36, 0.75) !important;
            transition: all 0.2s;
        }

        [data-theme="light"] .form-control {
            background: rgba(35, 8, 16, 0.75) !important;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--adm-primary) !important;
            box-shadow: 0 0 16px var(--adm-primary-glow) !important;
        }

        select.form-control option {
            background: #002147 !important;
            color: #ffffff !important;
        }
        [data-theme="light"] select.form-control option {
            background: oklch(27.1% 0.105 12.094) !important;
            color: #ffffff !important;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: capitalize;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.22);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.25);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.45);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.45);
        }

        .badge-info {
            background: var(--adm-badge-info-bg);
            color: var(--adm-badge-info-text);
            border: 1px solid var(--adm-border);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.18);
            color: #34d399;
            padding: 14px 18px;
            border-radius: 12px;
            border: 1px solid rgba(16, 185, 129, 0.4);
            margin-bottom: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
        }

        /* Backdrop Overlay Mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 999;
        }

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE MOBILE ENGINE (RAPI & ANTI-TERPOTONG)
           ═══════════════════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .sidebar {
                width: min(290px, 85vw);
                transform: translateX(-100%);
            }
            .sidebar.is-open {
                transform: translateX(0);
            }
            .sidebar-overlay.is-open {
                display: block;
            }
            .main-container {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100vw !important;
                padding: 14px 14px 45px 14px !important;
            }
            .topbar-hamburger {
                display: inline-flex !important;
            }
            .sidebar-close-btn {
                display: flex !important;
            }
        }

        @media (max-width: 768px) {
            .admin-topbar {
                padding: 10px 14px !important;
                margin-bottom: 18px !important;
                border-radius: 14px !important;
            }

            .topbar-left {
                gap: 8px !important;
            }

            .topbar-status-badge {
                padding: 5px 10px !important;
                font-size: 0.72rem !important;
            }
            .topbar-status-text-full {
                display: none !important;
            }
            .topbar-status-text-mobile {
                display: inline !important;
            }

            .topbar-right {
                gap: 8px !important;
            }

            .btn-topbar-web {
                padding: 7px 10px !important;
                font-size: 0.76rem !important;
            }
            .btn-topbar-web span.web-text-long {
                display: none !important;
            }
            .btn-topbar-web span.web-text-short {
                display: inline !important;
            }

            .header {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
                margin-bottom: 20px !important;
            }

            .header-title {
                font-size: 1.5rem !important;
            }

            .header > div:last-child,
            .header .btn {
                width: 100% !important;
                justify-content: center !important;
            }

            .card {
                padding: 18px 14px !important;
                border-radius: 14px !important;
                margin-bottom: 16px !important;
            }

            /* Mencegah kolom tabel terhimpit */
            .table-responsive table {
                min-width: 600px !important;
            }

            .table-responsive th,
            .table-responsive td {
                padding: 11px 12px !important;
            }

            /* Responsive reset untuk grid 2-kolom child views */
            .main-container div[style*="grid-template-columns: 1fr 320px"],
            .main-container div[style*="grid-template-columns:1fr 320px"] {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }
        }

        /* ═══════════════════════════════════════════════════════════
           CRUD SKELETON LOADING ENGINE (FOR ALL CRUD METHODS)
           ═══════════════════════════════════════════════════════════ */
        :root {
            --adm-skeleton-base: rgba(255, 255, 255, 0.08);
            --adm-skeleton-shimmer: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(0, 180, 216, 0.22) 50%,
                rgba(255, 255, 255, 0) 100%
            );
        }

        [data-theme="light"] {
            --adm-skeleton-base: rgba(255, 255, 255, 0.12);
            --adm-skeleton-shimmer: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                oklch(58.6% 0.253 17.585 / 0.32) 50%,
                rgba(255, 255, 255, 0) 100%
            );
        }

        .skeleton-shimmer {
            position: relative;
            overflow: hidden;
            background-color: var(--adm-skeleton-base) !important;
            border-radius: 8px;
            pointer-events: none;
        }

        .skeleton-shimmer::after {
            content: '';
            position: absolute;
            inset: 0;
            transform: translateX(-100%);
            background: var(--adm-skeleton-shimmer);
            animation: skeletonWave 1.5s infinite cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }

        @keyframes skeletonWave {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Wrappers & Smooth Hydration */
        .crud-skeleton-wrapper {
            width: 100%;
            transition: opacity 0.26s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.26s;
        }

        .crud-skeleton-wrapper.is-hidden {
            display: none !important;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .crud-content-wrapper {
            opacity: 1;
            transform: translateY(0);
            transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .crud-content-wrapper.is-loading {
            opacity: 0;
            transform: translateY(6px);
            pointer-events: none;
            position: absolute;
            width: 100%;
            visibility: hidden;
        }

        /* Skeleton Layout Switcher */
        .skeleton-layout {
            display: none;
            width: 100%;
        }

        .skeleton-layout.is-active {
            display: block;
        }

        /* Header Skeleton */
        .skeleton-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 26px;
        }

        .skeleton-header-texts {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .skeleton-title-bar {
            height: 32px;
            width: 220px;
            border-radius: 8px;
        }

        .skeleton-subtitle-bar {
            height: 16px;
            width: 320px;
            border-radius: 6px;
        }

        .skeleton-action-btn {
            height: 42px;
            width: 160px;
            border-radius: 10px;
        }

        /* Table Skeleton */
        .skeleton-card {
            pointer-events: none;
            user-select: none;
        }

        .skeleton-table {
            width: 100%;
            border-collapse: collapse;
        }

        .skeleton-th-cell {
            height: 14px;
            border-radius: 4px;
        }

        .skeleton-row-item td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--adm-table-border);
        }

        .skeleton-cell-identity {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .skeleton-avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .skeleton-identity-texts {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .skeleton-item-title {
            height: 16px;
            border-radius: 4px;
        }

        .skeleton-item-subtitle {
            height: 12px;
            border-radius: 4px;
        }

        .skeleton-badge-pill, .skeleton-badge-status {
            height: 24px;
            border-radius: 6px;
        }

        .skeleton-text-bar {
            height: 15px;
            border-radius: 4px;
        }

        .skeleton-action-group {
            display: inline-flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .skeleton-btn-sm {
            height: 30px;
            border-radius: 8px;
        }

        /* Form Skeleton */
        .skeleton-form-group {
            margin-bottom: 22px;
        }

        .skeleton-form-label {
            height: 16px;
            border-radius: 4px;
            margin-bottom: 8px;
        }

        .skeleton-form-input {
            height: 46px;
            width: 100%;
            border-radius: 10px;
        }

        .skeleton-form-hint {
            height: 12px;
            border-radius: 4px;
            margin-top: 6px;
        }

        .skeleton-form-textarea {
            height: 160px;
            width: 100%;
            border-radius: 10px;
        }

        .skeleton-form-actions {
            display: flex;
            gap: 12px;
            margin-top: 26px;
        }

        .skeleton-btn-primary, .skeleton-btn-outline {
            height: 44px;
            border-radius: 10px;
        }

        /* Detail Skeleton */
        .skeleton-detail-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 24px;
            align-items: start;
        }

        .skeleton-card-heading {
            height: 20px;
            border-radius: 6px;
            margin-bottom: 18px;
        }

        .skeleton-kv-table {
            display: flex;
            flex-direction: column;
        }

        .skeleton-kv-row {
            display: flex;
            gap: 16px;
            padding: 12px 0;
            border-bottom: 1px solid var(--adm-table-border);
        }

        .skeleton-kv-key {
            height: 16px;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .skeleton-kv-val {
            height: 16px;
            border-radius: 4px;
        }

        .skeleton-doc-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--adm-table-border);
        }

        .skeleton-doc-name {
            height: 16px;
            border-radius: 4px;
        }

        .skeleton-status-box {
            height: 90px;
            width: 100%;
            border-radius: 10px;
        }

        /* Dashboard Skeleton */
        .skeleton-dashboard-hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 22px;
            padding: 30px 32px;
            margin-bottom: 26px;
        }

        .skeleton-hero-actions-wrap {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .skeleton-stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 26px;
        }

        .skeleton-stat-card {
            padding: 24px;
        }

        .skeleton-stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
        }

        .skeleton-dash-content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        @media (max-width: 900px) {
            .skeleton-dash-content-grid {
                grid-template-columns: 1fr;
            }
            .skeleton-dashboard-hero {
                flex-direction: column;
                align-items: flex-start;
            }
            .skeleton-hero-actions-wrap {
                width: 100%;
                flex-direction: row;
            }
            .skeleton-hero-actions-wrap > div {
                flex: 1;
            }
        }

        @media (max-width: 768px) {
            .skeleton-header {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 12px !important;
            }
            .skeleton-header-texts .skeleton-subtitle-bar {
                width: 100% !important;
            }
            .skeleton-action-btn {
                width: 100% !important;
            }
            .skeleton-detail-grid {
                grid-template-columns: 1fr !important;
            }
            .skeleton-table {
                min-width: 600px !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Mobile Overlay Backdrop -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar Glassmorphism Drawer -->
    <aside class="sidebar" id="mainSidebar">
        <div class="sidebar-brand-wrapper">
            <a href="{{ route('home') }}" class="sidebar-brand">
                <div class="brand-logo-wrap">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam">
                </div>
                <div class="brand-meta">
                    <span class="brand-title">At-Tamam Edu</span>
                    <span class="brand-badge">⚡ Admin Center</span>
                </div>
            </a>
            <button class="sidebar-close-btn" id="sidebarCloseBtn" type="button" aria-label="Tutup Menu Sidebar">
                ✕
            </button>
        </div>

        <div class="sidebar-category">Menu Navigasi</div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <span class="sidebar-link-icon">📊</span>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.news.index') }}" class="sidebar-link {{ Route::is('admin.news.*') ? 'active' : '' }}">
                    <span class="sidebar-link-icon">📰</span>
                    <span>Berita (CMS)</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.teachers.index') }}" class="sidebar-link {{ Route::is('admin.teachers.*') ? 'active' : '' }}">
                    <span class="sidebar-link-icon">👨‍🏫</span>
                    <span>Guru & Staf</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.ppdb.index') }}" class="sidebar-link {{ Route::is('admin.ppdb.*') ? 'active' : '' }}">
                    <span class="sidebar-link-icon">📝</span>
                    <span>PPDB Online</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.majors.index') }}" class="sidebar-link {{ Route::is('admin.majors.*') ? 'active' : '' }}">
                    <span class="sidebar-link-icon">💻</span>
                    <span>Program Jurusan</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="user-card-widget">
                <div class="user-avatar-circle">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-meta-info">
                    <span class="user-meta-name">{{ auth()->user()->name }}</span>
                    <span class="user-meta-role">
                        <span class="role-indicator-dot"></span>
                        {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                    </span>
                </div>
            </div>

            <a href="{{ route('home') }}" class="btn-sidebar-action">
                <span>🌐</span> Lihat Website
            </a>
            <a href="{{ route('logout') }}" class="btn-sidebar-action btn-sidebar-logout">
                <span>🚪</span> Logout Sesi
            </a>
        </div>
    </aside>

    <!-- Main Content Container -->
    <main class="main-container">
        <!-- Topbar Floating Header -->
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="topbar-hamburger" id="sidebarToggleBtn" type="button" aria-label="Buka Menu Sidebar">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <div class="topbar-status-badge">
                    <span class="status-dot-live"></span>
                    <span class="topbar-status-text-full">PKBM Tahfizh At-Tamam · Sistem Terhubung</span>
                    <span class="topbar-status-text-mobile" style="display: none;">Online</span>
                </div>
            </div>

            <div class="topbar-right">
                <!-- Theme Switcher Button (Dark / White Mode) -->
                <button class="adm-theme-toggle" id="adminThemeToggleBtn" type="button" aria-label="Ganti Tema Tampilan" title="Ganti Tema (Dark / White Mode)">
                    <span class="icon-sun" aria-hidden="true">☀️</span>
                    <span class="icon-moon" aria-hidden="true">🌙</span>
                </button>

                <!-- Tombol Shortcut ke Website Depan -->
                <a href="{{ route('home') }}" class="btn-topbar-web" title="Lihat Tampilan Website">
                    <span>🏠</span>
                    <span class="web-text-long">Portal Sekolah</span>
                    <span class="web-text-short" style="display: none;">Web</span>
                    <span>↗</span>
                </a>
            </div>
        </header>

        @if(session('success'))
            <div class="alert-success">
                <span>✨</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- CRUD Skeleton Loading State (All CRUD Methods) -->
        @include('partials.crud-skeleton')

        <!-- Real Page Content Wrapper -->
        <div id="crudPageContent" class="crud-content-wrapper is-loading">
            @yield('content')
        </div>
    </main>

    <!-- SweetAlert2 Standalone Engine -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <!-- Modal Konfirmasi Logout (Scale-in / Zoom-in Pop Effect) -->
    @include('partials.logout-modal')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ── Theme Switcher Handler ──
            const themeBtn = document.getElementById('adminThemeToggleBtn');
            
            function toggleAdminTheme() {
                const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('site_theme', newTheme);

                // Feedback rotasi animasi 360-derajat
                if (themeBtn) {
                    themeBtn.style.transition = 'transform 0.55s cubic-bezier(0.68, -0.6, 0.32, 1.6)';
                    themeBtn.style.transform = 'scale(0.85) rotate(360deg)';
                    setTimeout(() => {
                        themeBtn.style.transform = '';
                    }, 550);
                }

                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: newTheme } }));
            }

            themeBtn?.addEventListener('click', toggleAdminTheme);

            // ── Mobile Sidebar Drawer Handler ──
            const sidebarToggle = document.getElementById('sidebarToggleBtn');
            const sidebarClose = document.getElementById('sidebarCloseBtn');
            const sidebar = document.getElementById('mainSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function openSidebar() {
                sidebar?.classList.add('is-open');
                overlay?.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                sidebar?.classList.remove('is-open');
                overlay?.classList.remove('is-open');
                document.body.style.overflow = '';
            }

            sidebarToggle?.addEventListener('click', openSidebar);
            sidebarClose?.addEventListener('click', closeSidebar);
            overlay?.addEventListener('click', closeSidebar);

            // Menutup drawer otomatis saat link diklik pada mobile
            sidebar?.querySelectorAll('.sidebar-link, .btn-sidebar-action').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 1024) {
                        closeSidebar();
                    }
                });
            });

            // ── CRUD Skeleton Transition & Loading Manager ──
            const skeleton = document.getElementById('crudSkeletonLoader');
            const content = document.getElementById('crudPageContent');
            
            function showContent() {
                if (!content || !skeleton) return;
                skeleton.classList.add('is-hidden');
                content.classList.remove('is-loading');
            }

            function showSkeleton(targetType) {
                if (!content || !skeleton) return;
                clearInitialTimer();
                
                // Aktifkan layout skeleton yang sesuai target
                if (targetType) {
                    skeleton.querySelectorAll('.skeleton-layout').forEach(el => el.classList.remove('is-active'));
                    const targetLayout = skeleton.querySelector('.skeleton-layout-' + targetType);
                    if (targetLayout) targetLayout.classList.add('is-active');
                    skeleton.setAttribute('data-active-type', targetType);
                }

                content.classList.add('is-loading');
                skeleton.classList.remove('is-hidden');
            }

            // Expose globally agar bisa dipanggil dari child view atau AJAX
            window.showCrudSkeleton = showSkeleton;
            window.hideCrudSkeleton = showContent;

            // Transisi smooth initial skeleton saat halaman dimuat (280ms)
            let initialTimer = setTimeout(showContent, 280);

            // Batalkan timeout inisial jika showSkeleton dipanggil manual
            function clearInitialTimer() {
                if (initialTimer) {
                    clearTimeout(initialTimer);
                    initialTimer = null;
                }
            }

            // ── Intercept Navigasi CRUD Links ──
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;

                const href = link.getAttribute('href');
                if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.target === '_blank' || href.includes('/logout')) return;
                
                // Deteksi jika link mengarah ke rute CRUD Admin
                if (href.includes('/admin') || link.classList.contains('sidebar-link') || link.closest('.header') || link.closest('table')) {
                    let type = 'table';
                    if (href.includes('/create') || href.includes('/edit')) {
                        type = 'form';
                    } else if (href.includes('/ppdb/') && !href.includes('/export')) {
                        type = 'detail';
                    } else if (href.includes('/dashboard')) {
                        type = 'dashboard';
                    }

                    showSkeleton(type);
                }
            });

            // ── Intercept CRUD Form Submissions (Create/Store, Edit/Update, Status, Delete) ──
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (!form) return;

                const action = form.getAttribute('action') || '';
                const method = (form.querySelector('input[name="_method"]')?.value || form.getAttribute('method') || 'POST').toUpperCase();

                if (action.includes('/admin') || form.closest('.main-container')) {
                    let type = 'table';
                    if (method === 'DELETE') {
                        type = 'table';
                    } else if (action.includes('/news') || action.includes('/teachers') || action.includes('/majors')) {
                        type = 'form';
                    } else if (action.includes('/ppdb')) {
                        type = 'detail';
                    }

                    showSkeleton(type);
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
