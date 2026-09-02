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
    <title>Portal Guru & Staf — PKBM Tahfizh At-Tamam</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-base: #070d1e;
            --bg-card: rgba(15, 23, 42, 0.94);
            --border-card: rgba(0, 180, 216, 0.35);
            --card-glow: rgba(0, 180, 216, 0.18);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            --input-bg: rgba(30, 41, 59, 0.7);
            --input-border: rgba(255, 255, 255, 0.12);
            --input-focus-border: #00B4D8;
            --input-focus-glow: rgba(0, 180, 216, 0.3);
            --btn-gradient: linear-gradient(135deg, #00B4D8 0%, #0077B6 100%);
            --btn-shadow: 0 10px 25px rgba(0, 180, 216, 0.35);
            --btn-shadow-hover: 0 14px 30px rgba(0, 180, 216, 0.55);
            --overlay-gradient: linear-gradient(135deg, #00B4D8 0%, #0077B6 50%, #03045E 100%);
            --overlay-blob-1: rgba(255, 255, 255, 0.18);
            --overlay-blob-2: rgba(0, 180, 216, 0.35);
            --tab-bg: rgba(30, 41, 59, 0.85);
            --tab-pill-bg: linear-gradient(135deg, rgba(0, 180, 216, 0.3) 0%, rgba(0, 119, 182, 0.45) 100%);
            --tab-pill-border: rgba(0, 180, 216, 0.7);
            --tab-pill-shadow: 0 0 20px rgba(0, 180, 216, 0.3);
            --tab-active-text: #38bdf8;
            --accent-link: #38bdf8;
            --top-btn-bg: rgba(15, 23, 42, 0.75);
            --top-btn-border: rgba(255, 255, 255, 0.12);
            --orb-1: rgba(0, 180, 216, 0.2);
            --orb-2: rgba(0, 119, 182, 0.16);
            --grid-line: rgba(255, 255, 255, 0.03);
            --role-info-bg: rgba(56, 189, 248, 0.1);
            --role-info-border: rgba(56, 189, 248, 0.25);
            --role-info-text: #38bdf8;
            --divider-glow: #00B4D8;
        }

        [data-theme="light"] {
            --bg-base: #f8fafc;
            --bg-card: rgba(255, 255, 255, 0.98);
            --border-card: rgba(226, 232, 240, 0.9);
            --card-glow: rgba(185, 28, 28, 0.08);
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --input-bg: #f8fafc;
            --input-border: #cbd5e1;
            --input-focus-border: oklch(58.6% 0.253 17.585);
            --input-focus-glow: rgba(225, 29, 72, 0.18);
            --btn-gradient: linear-gradient(135deg, oklch(58.6% 0.253 17.585) 0%, oklch(41% 0.159 10.272) 100%);
            --btn-shadow: 0 10px 25px rgba(225, 29, 72, 0.22);
            --btn-shadow-hover: 0 14px 30px rgba(225, 29, 72, 0.38);
            --overlay-gradient: linear-gradient(135deg, oklch(58.6% 0.253 17.585) 0%, oklch(41% 0.159 10.272) 60%, oklch(27.1% 0.105 12.094) 100%);
            --overlay-blob-1: rgba(255, 255, 255, 0.22);
            --overlay-blob-2: rgba(255, 228, 230, 0.28);
            --tab-bg: #f1f5f9;
            --tab-pill-bg: #ffffff;
            --tab-pill-border: #cbd5e1;
            --tab-pill-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
            --tab-active-text: oklch(58.6% 0.253 17.585);
            --accent-link: oklch(58.6% 0.253 17.585);
            --top-btn-bg: rgba(255, 255, 255, 0.85);
            --top-btn-border: #e2e8f0;
            --orb-1: rgba(225, 29, 72, 0.08);
            --orb-2: rgba(185, 28, 28, 0.06);
            --grid-line: rgba(0, 0, 0, 0.035);
            --role-info-bg: #fff1f2;
            --role-info-border: #fecdd3;
            --role-info-text: #be123c;
            --divider-glow: oklch(58.6% 0.253 17.585);
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
            padding: 2rem 1.25rem;
            transition: background 0.4s cubic-bezier(0.16, 1, 0.3, 1), color 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* ═══════════════════════════════════════════════════════════
           AMBIENT BACKGROUND GLOWS & GRID
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
            filter: blur(95px);
            opacity: 0.85;
            pointer-events: none;
        }

        .orb-top-left {
            width: 480px;
            height: 480px;
            top: -120px;
            left: -120px;
            background: var(--orb-1);
            animation: orbFloat 14s ease-in-out infinite alternate;
        }

        .orb-bottom-right {
            width: 520px;
            height: 520px;
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
            background-size: 38px 38px;
            mask-image: radial-gradient(circle at center, black 45%, transparent 85%);
            -webkit-mask-image: radial-gradient(circle at center, black 45%, transparent 85%);
        }

        @keyframes orbFloat {
            0% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(40px, 35px) scale(1.08); }
            100% { transform: translate(-25px, 55px) scale(0.94); }
        }

        /* ═══════════════════════════════════════════════════════════
           TOP FLOATING ACTION BAR
           ═══════════════════════════════════════════════════════════ */
        .top-action-bar {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            right: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 50;
            pointer-events: none;
        }

        .top-action-bar > * {
            pointer-events: auto;
        }

        .btn-top-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--top-btn-bg);
            border: 1px solid var(--top-btn-border);
            color: var(--text-primary);
            text-decoration: none;
            padding: 0.6rem 1.15rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .btn-top-nav:hover {
            transform: translateY(-2px);
            border-color: var(--input-focus-border);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
            color: var(--tab-active-text);
        }

        .btn-top-nav svg {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .btn-top-nav:hover svg {
            transform: translateX(-4px);
        }

        .btn-theme-toggle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--top-btn-bg);
            border: 1px solid var(--top-btn-border);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            font-size: 1.15rem;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.3s ease;
        }

        .btn-theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            border-color: var(--input-focus-border);
        }

        /* ═══════════════════════════════════════════════════════════
           AUTH-SWITCH CONTAINER (DUAL-PANEL SLIDING CHASSIS)
           ═══════════════════════════════════════════════════════════ */
        .auth-switch-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 940px;
            margin: auto;
            animation: cardEntrance 0.75s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(35px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .auth-switch-container {
            position: relative;
            width: 100%;
            min-height: 640px;
            background: var(--bg-card);
            border: 1.5px solid var(--border-card);
            border-radius: 28px;
            box-shadow: 0 35px 80px rgba(0, 0, 0, 0.45), 0 0 45px var(--card-glow);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            overflow: hidden;
            display: flex;
        }

        /* ═══════════════════════════════════════════════════════════
           ONLOAD ENTRANCE KEYFRAMES (FADE RIGHT / FADE LEFT)
           ═══════════════════════════════════════════════════════════ */
        @keyframes formEntranceLeft {
            0% {
                opacity: 0;
                transform: translateX(-55px);
                filter: blur(8px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
                filter: blur(0px);
            }
        }

        @keyframes formEntranceRight {
            0% {
                opacity: 0;
                transform: translateX(calc(100% + 55px));
                filter: blur(8px);
            }
            100% {
                opacity: 1;
                transform: translateX(100%);
                filter: blur(0px);
            }
        }

        @keyframes overlayEntranceRight {
            0% {
                opacity: 0;
                transform: translateX(65px);
                filter: blur(10px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
                filter: blur(0px);
            }
        }

        @keyframes overlayEntranceLeft {
            0% {
                opacity: 0;
                transform: translateX(calc(-100% - 65px));
                filter: blur(10px);
            }
            100% {
                opacity: 1;
                transform: translateX(-100%);
                filter: blur(0px);
            }
        }

        @keyframes dividerLineDrop {
            0% {
                opacity: 0;
                transform: scaleY(0);
            }
            60% {
                opacity: 1;
            }
            100% {
                opacity: 0.9;
                transform: scaleY(1);
            }
        }

        /* Initial Onload Animation Execution */
        .auth-switch-container:not(.is-animated-ready):not(.is-register-active) .sign-in-slot {
            animation: formEntranceLeft 0.85s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .auth-switch-container:not(.is-animated-ready):not(.is-register-active) .overlay-chassis {
            animation: overlayEntranceRight 0.85s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .auth-switch-container:not(.is-animated-ready).is-register-active .sign-up-slot {
            animation: formEntranceRight 0.85s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .auth-switch-container:not(.is-animated-ready).is-register-active .overlay-chassis {
            animation: overlayEntranceLeft 0.85s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        /* ═══════════════════════════════════════════════════════════
           MOBILE TABS (VISIBLE ONLY <= 860px)
           ═══════════════════════════════════════════════════════════ */
        .mobile-tab-switch {
            display: none;
            position: relative;
            background: var(--tab-bg);
            border-radius: 14px;
            padding: 5px;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 1.5rem;
            border: 1px solid var(--input-border);
            user-select: none;
        }

        .mobile-tab-pill {
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

        .mobile-tab-switch[data-active-tab="register"] .mobile-tab-pill {
            transform: translateX(100%);
        }

        .mobile-tab-btn {
            position: relative;
            z-index: 2;
            background: none;
            border: none;
            padding: 0.7rem 0.85rem;
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

        .mobile-tab-btn.is-active {
            color: var(--tab-active-text);
        }

        /* ═══════════════════════════════════════════════════════════
           DESKTOP FORM SLOTS & PANELS
           ═══════════════════════════════════════════════════════════ */
        .form-slot {
            position: absolute;
            top: 0;
            height: 100%;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.75rem 3rem;
            transition: transform 0.65s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.5s ease;
            overflow-y: auto;
            scrollbar-width: thin;
        }

        /* SIGN IN SLOT */
        .sign-in-slot {
            left: 0;
            z-index: 2;
            opacity: 1;
            transform: translateX(0);
        }

        .auth-switch-container.is-register-active .sign-in-slot {
            transform: translateX(100%);
            opacity: 0;
            pointer-events: none;
            z-index: 1;
        }

        /* SIGN UP / REGISTER SLOT */
        .sign-up-slot {
            left: 0;
            opacity: 0;
            z-index: 1;
            pointer-events: none;
            transform: translateX(0);
        }

        .auth-switch-container.is-register-active .sign-up-slot {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            pointer-events: auto;
        }

        /* ═══════════════════════════════════════════════════════════
           SLIDING OVERLAY CONTAINER (HERO PEMBATAS INTERAKTIF)
           ═══════════════════════════════════════════════════════════ */
        .overlay-chassis {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.65s cubic-bezier(0.77, 0, 0.175, 1), border-radius 0.65s ease;
            z-index: 100;
        }

        .auth-switch-container.is-register-active .overlay-chassis {
            transform: translateX(-100%);
        }

        /* Glowing Vertical Divider Edge */
        .overlay-divider-glow {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 2px;
            background: linear-gradient(180deg, transparent 0%, rgba(255, 255, 255, 0.85) 25%, var(--divider-glow) 50%, rgba(255, 255, 255, 0.85) 75%, transparent 100%);
            box-shadow: 0 0 16px var(--divider-glow), 0 0 32px var(--divider-glow);
            z-index: 120;
            pointer-events: none;
            transform-origin: center;
            animation: dividerLineDrop 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both;
            transition: left 0.65s cubic-bezier(0.77, 0, 0.175, 1), right 0.65s cubic-bezier(0.77, 0, 0.175, 1);
        }

        .auth-switch-container.is-register-active .overlay-divider-glow {
            left: auto;
            right: 0;
        }

        .overlay-inner {
            background: var(--overlay-gradient);
            color: #ffffff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.65s cubic-bezier(0.77, 0, 0.175, 1);
            overflow: hidden;
        }

        .auth-switch-container.is-register-active .overlay-inner {
            transform: translateX(50%);
        }

        /* Ambient Glow & Blobs inside Overlay */
        .overlay-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(50px);
            pointer-events: none;
        }

        .overlay-blob-1 {
            width: 260px;
            height: 260px;
            top: -40px;
            right: 20%;
            background: var(--overlay-blob-1);
            animation: blobPulse 8s ease-in-out infinite alternate;
        }

        .overlay-blob-2 {
            width: 320px;
            height: 320px;
            bottom: -60px;
            left: 15%;
            background: var(--overlay-blob-2);
            animation: blobPulse 11s ease-in-out infinite alternate-reverse;
        }

        @keyframes blobPulse {
            0% { transform: scale(1) translate(0, 0); }
            50% { transform: scale(1.15) translate(20px, 15px); }
            100% { transform: scale(0.92) translate(-15px, 25px); }
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 3.25rem;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.65s cubic-bezier(0.77, 0, 0.175, 1);
            z-index: 10;
        }

        .overlay-panel-left {
            transform: translateX(-20%);
        }

        .auth-switch-container.is-register-active .overlay-panel-left {
            transform: translateX(0);
        }

        .overlay-panel-right {
            right: 0;
            transform: translateX(0);
        }

        .auth-switch-container.is-register-active .overlay-panel-right {
            transform: translateX(20%);
        }

        .overlay-brand-icon {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(255, 255, 255, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
            margin-bottom: 1.5rem;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            animation: floatBadge 6s ease-in-out infinite;
        }

        @keyframes floatBadge {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .overlay-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .overlay-title {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 0.85rem;
            color: #ffffff;
            letter-spacing: -0.02em;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .overlay-desc {
            font-size: 0.92rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.88);
            margin-bottom: 2rem;
            max-width: 320px;
        }

        /* GHOST SWITCH BUTTON */
        .btn-ghost-switch {
            background: rgba(255, 255, 255, 0.16);
            border: 1.5px solid rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 9999px;
            color: #ffffff;
            font-size: 0.94rem;
            font-weight: 800;
            font-family: inherit;
            padding: 0.85rem 2.25rem;
            cursor: pointer;
            outline: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .btn-ghost-switch:hover {
            background: #ffffff;
            color: #0077B6;
            border-color: #ffffff;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.25);
        }

        [data-theme="light"] .btn-ghost-switch:hover {
            color: oklch(41% 0.159 10.272);
        }

        .btn-ghost-switch:active {
            transform: translateY(0) scale(0.98);
        }

        /* ═══════════════════════════════════════════════════════════
           FORM HEADER & CONTROLS
           ═══════════════════════════════════════════════════════════ */
        .form-brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .form-brand-mini-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #ffffff;
            border: 1.5px solid var(--border-card);
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .form-brand-mini-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .form-brand-text h3 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .form-brand-text span {
            font-size: 0.76rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .form-heading {
            margin-bottom: 1.25rem;
        }

        .form-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--text-primary);
            letter-spacing: -0.015em;
            line-height: 1.25;
            margin-bottom: 0.35rem;
        }

        .form-subtitle {
            font-size: 0.86rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 1.05rem;
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

        .input-icon-left {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .form-input {
            width: 100%;
            padding: 0.76rem 2.8rem 0.76rem 2.75rem;
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            font-size: 0.88rem;
            font-family: inherit;
            background: rgba(30, 41, 59, 0.75);
            color: #ffffff;
            caret-color: #38bdf8;
            outline: none;
            transition: border-color 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        .form-input::placeholder {
            color: #64748b;
            opacity: 1;
        }

        .form-input:hover {
            border-color: rgba(255, 255, 255, 0.25);
        }

        .form-input:focus {
            border-color: var(--input-focus-border);
            box-shadow: 0 0 0 4px var(--input-focus-glow);
            background: rgba(30, 41, 59, 0.95);
            color: #ffffff;
        }

        /* ═══════════════════════════════════════════════════════════
           BROWSER AUTOFILL & FILLED INPUT CONTRAST FIX
           ═══════════════════════════════════════════════════════════ */
        .form-input:-webkit-autofill,
        .form-input:-webkit-autofill:hover, 
        .form-input:-webkit-autofill:focus, 
        .form-input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #1e293b inset !important;
            -webkit-text-fill-color: #ffffff !important;
            color: #ffffff !important;
            caret-color: #38bdf8 !important;
            transition: background-color 50000s ease-in-out 0s;
            border-color: var(--input-border) !important;
            font-size: 0.88rem !important;
            font-family: inherit !important;
        }

        .form-input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #1e293b inset, 0 0 0 4px var(--input-focus-glow) !important;
            border-color: var(--input-focus-border) !important;
        }

        /* Light Mode Input Overrides */
        [data-theme="light"] .form-input {
            background: #ffffff;
            color: #0f172a;
            border-color: #cbd5e1;
            caret-color: oklch(58.6% 0.253 17.585);
        }

        [data-theme="light"] .form-input::placeholder {
            color: #94a3b8;
        }

        [data-theme="light"] .form-input:hover {
            border-color: #94a3b8;
        }

        [data-theme="light"] .form-input:focus {
            background: #ffffff;
            color: #0f172a;
            border-color: oklch(58.6% 0.253 17.585);
            box-shadow: 0 0 0 4px rgba(225, 29, 72, 0.18);
        }

        [data-theme="light"] .form-input:-webkit-autofill,
        [data-theme="light"] .form-input:-webkit-autofill:hover, 
        [data-theme="light"] .form-input:-webkit-autofill:focus, 
        [data-theme="light"] .form-input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #0f172a !important;
            color: #0f172a !important;
            caret-color: oklch(58.6% 0.253 17.585) !important;
            border-color: #cbd5e1 !important;
        }

        [data-theme="light"] .form-input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset, 0 0 0 4px rgba(225, 29, 72, 0.18) !important;
            border-color: oklch(58.6% 0.253 17.585) !important;
        }

        .form-input:focus + .input-icon-left,
        .input-wrap:focus-within .input-icon-left {
            color: var(--input-focus-border);
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
            transition: color 0.2s ease, transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .toggle-password-btn:hover {
            color: var(--text-primary);
            transform: scale(1.18);
        }

        .form-options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
            gap: 0.5rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.82rem;
            color: var(--text-secondary);
            cursor: pointer;
            user-select: none;
            font-weight: 500;
        }

        .remember-label input {
            width: 16px;
            height: 16px;
            accent-color: #00B4D8;
            cursor: pointer;
        }

        [data-theme="light"] .remember-label input {
            accent-color: oklch(58.6% 0.253 17.585);
        }

        .role-badge-info {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--role-info-bg);
            border: 1px solid var(--role-info-border);
            padding: 0.65rem 0.85rem;
            border-radius: 10px;
            font-size: 0.78rem;
            color: var(--role-info-text);
            margin-bottom: 1.15rem;
            line-height: 1.4;
        }

        .btn-submit-action {
            width: 100%;
            padding: 0.86rem 1.4rem;
            border: none;
            border-radius: 12px;
            background: var(--btn-gradient);
            color: #ffffff;
            font-size: 0.94rem;
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

        .btn-submit-action:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: var(--btn-shadow-hover);
        }

        .btn-submit-action:active {
            transform: translateY(1px) scale(0.98);
            transition-duration: 0.12s;
        }

        /* Mobile Switch Prompt */
        .mobile-switch-prompt {
            display: none;
            margin-top: 1.15rem;
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-secondary);
        }

        .mobile-switch-prompt a {
            color: var(--accent-link);
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .mobile-switch-prompt a:hover {
            text-decoration: underline;
        }

        /* ═══════════════════════════════════════════════════════════
           ALERT NOTIFICATIONS
           ═══════════════════════════════════════════════════════════ */
        .alert-status {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.35);
            padding: 0.7rem 0.95rem;
            border-radius: 12px;
            font-size: 0.84rem;
            margin-bottom: 1.15rem;
            font-weight: 600;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.4);
            padding: 0.7rem 0.95rem;
            border-radius: 12px;
            font-size: 0.84rem;
            margin-bottom: 1.15rem;
            font-weight: 600;
            animation: errorShake 0.45s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
        }

        @keyframes errorShake {
            10%, 90% { transform: translate3d(-2px, 0, 0); }
            20%, 80% { transform: translate3d(3px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        /* ═══════════════════════════════════════════════════════════
           RESPONSIVE BREAKPOINTS
           ═══════════════════════════════════════════════════════════ */
        @media (max-width: 860px) {
            body {
                padding: 5rem 1rem 2rem 1rem;
            }

            .top-action-bar {
                top: 1rem;
                left: 1rem;
                right: 1rem;
            }

            .auth-switch-container {
                min-height: auto;
                flex-direction: column;
                padding: 1.75rem 1.25rem;
                border-radius: 22px;
            }

            .overlay-chassis {
                display: none !important;
            }

            .mobile-tab-switch {
                display: grid;
            }

            .mobile-switch-prompt {
                display: block;
            }

            .form-slot {
                position: relative !important;
                width: 100% !important;
                height: auto !important;
                padding: 0 !important;
                transform: none !important;
                opacity: 1 !important;
                display: none;
                animation: none !important;
            }

            .auth-switch-container:not(.is-register-active) .sign-in-slot {
                display: block;
                animation: mobileSlotEnter 0.4s cubic-bezier(0.16, 1, 0.3, 1) both !important;
            }

            .auth-switch-container.is-register-active .sign-up-slot {
                display: block;
                animation: mobileSlotEnter 0.4s cubic-bezier(0.16, 1, 0.3, 1) both !important;
            }

            @keyframes mobileSlotEnter {
                from {
                    opacity: 0;
                    transform: translateY(16px);
                    filter: blur(4px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                    filter: blur(0);
                }
            }
        }
    </style>
</head>
<body>
    <script>
        // Synchronize Theme immediately
        (function() {
            const savedTheme = localStorage.getItem('site_theme');
            if (savedTheme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>

    {{-- Ambient Lighting & Kinetic Grid Background --}}
    <div class="ambient-bg">
        <div class="ambient-orb orb-top-left"></div>
        <div class="ambient-orb orb-bottom-right"></div>
        <div class="ambient-grid"></div>
    </div>

    {{-- Top Floating Navigation Bar --}}
    <div class="top-action-bar">
        <a href="{{ route('home') }}" class="btn-top-nav" aria-label="Kembali ke Beranda">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            <span>Beranda</span>
        </a>

        <button class="btn-theme-toggle" id="themeToggleBtn" type="button" aria-label="Ganti Tema" title="Ganti Tema (Dark / Light Mode)">
            <span id="themeIcon">🌓</span>
        </button>
    </div>

    {{-- Auth Switch Main Chassis --}}
    <div class="auth-switch-wrapper">
        <div class="auth-switch-container {{ $isRegister ? 'is-register-active' : '' }}" id="authSwitchContainer" data-current-tab="{{ $defaultTab }}">
            
            {{-- Mobile Segmented Switch Pill (Visible <= 860px) --}}
            <div class="mobile-tab-switch" id="mobileTabSwitch" data-active-tab="{{ $defaultTab }}">
                <div class="mobile-tab-pill"></div>
                <button type="button" class="mobile-tab-btn {{ !$isRegister ? 'is-active' : '' }}" data-mobile-tab="login">
                    <span>🔑 Masuk</span>
                </button>
                <button type="button" class="mobile-tab-btn {{ $isRegister ? 'is-active' : '' }}" data-mobile-tab="register">
                    <span>📝 Daftar Akun</span>
                </button>
            </div>

            {{-- ═══════════════════════════════════════════════════════════
                 SLOT 1: SIGN IN FORM (MASUK) — ENTERS FADE-LEFT ON LOAD
                 ═══════════════════════════════════════════════════════════ --}}
            <div class="form-slot sign-in-slot">
                <div class="form-brand-header">
                    <div class="form-brand-mini-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam">
                    </div>
                    <div class="form-brand-text">
                        <h3>PKBM Tahfizh At-Tamam</h3>
                        <span>Portal Pendidik & Staf</span>
                    </div>
                </div>

                <div class="form-heading">
                    <h2 class="form-title">Masuk ke Akun</h2>
                    <p class="form-subtitle">Selamat datang kembali! Masukkan kredensial Anda untuk melanjutkan.</p>
                </div>

                {{-- Status & Error Messages --}}
                @if (session('status'))
                    <div class="alert-status">✓ {{ session('status') }}</div>
                @endif

                @if ($errors->any() && old('form_type') !== 'register')
                    <div class="alert-error">⚠️ {{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf
                    <input type="hidden" name="form_type" value="login">

                    <div class="form-group">
                        <label class="form-label" for="login_email">Alamat Email</label>
                        <div class="input-wrap">
                            <span class="input-icon-left">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <input class="form-input" id="login_email" type="email" name="email" value="{{ old('form_type') === 'register' ? '' : old('email') }}" required autofocus autocomplete="username" placeholder="guru@attamam.sch.id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="login_password">Kata Sandi</label>
                        <div class="input-wrap">
                            <span class="input-icon-left">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input class="form-input" id="login_password" type="password" name="password" data-password-input required autocomplete="current-password" placeholder="••••••••">
                            <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                                <span data-eye-icon>👁️</span>
                            </button>
                        </div>
                    </div>

                    <div class="form-options-row">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-submit-action">
                        <span>🚀 Masuk ke Portal</span>
                    </button>
                </form>

                <div class="mobile-switch-prompt">
                    Belum memiliki akun? <a href="javascript:void(0)" data-switch-trigger="register">Daftar staf/guru baru</a>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════
                 SLOT 2: SIGN UP FORM (DAFTAR AKUN)
                 ═══════════════════════════════════════════════════════════ --}}
            <div class="form-slot sign-up-slot">
                <div class="form-brand-header">
                    <div class="form-brand-mini-logo">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam">
                    </div>
                    <div class="form-brand-text">
                        <h3>PKBM Tahfizh At-Tamam</h3>
                        <span>Pendaftaran Akun Baru</span>
                    </div>
                </div>

                <div class="form-heading">
                    <h2 class="form-title">Daftar Akun Pendidik</h2>
                    <p class="form-subtitle">Lengkapi formulir untuk membuat akun pengajar / staf administrasi.</p>
                </div>

                <div class="role-badge-info">
                    <span>ℹ️</span>
                    <span>Akun baru otomatis didaftarkan sebagai <strong>Editor Akademik & Staf</strong>.</span>
                </div>

                @if ($errors->any() && (old('form_type') === 'register' || $isRegister))
                    <div class="alert-error">⚠️ {{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('register.process') }}">
                    @csrf
                    <input type="hidden" name="form_type" value="register">

                    <div class="form-group">
                        <label class="form-label" for="reg_name">Nama Lengkap & Gelar</label>
                        <div class="input-wrap">
                            <span class="input-icon-left">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input class="form-input" id="reg_name" type="text" name="name" value="{{ old('form_type') === 'register' ? old('name') : '' }}" required autocomplete="name" placeholder="Contoh: Ahmad Dahlan, S.Pd">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_email">Alamat Email</label>
                        <div class="input-wrap">
                            <span class="input-icon-left">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <input class="form-input" id="reg_email" type="email" name="email" value="{{ old('form_type') === 'register' ? old('email') : '' }}" required autocomplete="username" placeholder="nama@attamam.sch.id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_password">Kata Sandi</label>
                        <div class="input-wrap">
                            <span class="input-icon-left">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input class="form-input" id="reg_password" type="password" name="password" data-password-input required autocomplete="new-password" placeholder="Minimal 8 karakter">
                            <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                                <span data-eye-icon>👁️</span>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="reg_password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="input-wrap">
                            <span class="input-icon-left">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                            </span>
                            <input class="form-input" id="reg_password_confirmation" type="password" name="password_confirmation" data-password-input required autocomplete="new-password" placeholder="Ulangi kata sandi">
                            <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                                <span data-eye-icon>👁️</span>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit-action">
                        <span>✨ Daftarkan Akun</span>
                    </button>
                </form>

                <div class="mobile-switch-prompt">
                    Sudah memiliki akun? <a href="javascript:void(0)" data-switch-trigger="login">Masuk ke akun Anda</a>
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════════
                 SLIDING OVERLAY CHASSIS (PEMBATAS DENGAN ONLOAD FADE-RIGHT)
                 ═══════════════════════════════════════════════════════════ --}}
            <div class="overlay-chassis">
                {{-- Glowing Animated Divider Line on Edge --}}
                <div class="overlay-divider-glow"></div>

                <div class="overlay-inner">
                    <div class="overlay-blob overlay-blob-1"></div>
                    <div class="overlay-blob overlay-blob-2"></div>

                    {{-- Overlay Panel Left (Shown when in REGISTER mode) --}}
                    <div class="overlay-panel overlay-panel-left">
                        <div class="overlay-brand-icon">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo At-Tamam">
                        </div>
                        <h2 class="overlay-title">Selamat Datang Kembali!</h2>
                        <p class="overlay-desc">Sudah memiliki akun pengajar atau staf administrasi? Masuk sekarang untuk melanjutkan pengelolaan kelas dan data.</p>
                        <button class="btn-ghost-switch" type="button" data-switch-trigger="login">
                            <span>← Masuk ke Akun</span>
                        </button>
                    </div>

                    {{-- Overlay Panel Right (Shown when in LOGIN mode) --}}
                    <div class="overlay-panel overlay-panel-right">
                        <div class="overlay-brand-icon">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo At-Tamam">
                        </div>
                        <h2 class="overlay-title">Halo, Rekan Pendidik!</h2>
                        <p class="overlay-desc">Belum memiliki akun portal? Daftarkan diri Anda dan mari berkolaborasi bersama PKBM Tahfizh At-Tamam.</p>
                        <button class="btn-ghost-switch" type="button" data-switch-trigger="register">
                            <span>Daftar Akun Baru ➔</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         INTERACTIVE SWITCHER & FORM SCRIPTS
         ═══════════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('authSwitchContainer');
            const mobileTabsWrapper = document.getElementById('mobileTabSwitch');
            const mobileTabBtns = document.querySelectorAll('[data-mobile-tab]');
            const switchTriggers = document.querySelectorAll('[data-switch-trigger]');
            const themeBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');

            // Ready onload state removal after entrance animation completes
            setTimeout(() => {
                if (container) {
                    container.classList.add('is-animated-ready');
                }
            }, 900);

            // Theme toggle logic
            function updateThemeUI(theme) {
                if (themeIcon) {
                    themeIcon.textContent = theme === 'light' ? '☀️' : '🌙';
                }
            }

            const initialTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            updateThemeUI(initialTheme);

            if (themeBtn) {
                themeBtn.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('site_theme', newTheme);
                    updateThemeUI(newTheme);

                    // Spring 360-deg spin animation feedback
                    themeBtn.style.transition = 'transform 0.55s cubic-bezier(0.68, -0.6, 0.32, 1.6)';
                    themeBtn.style.transform = 'scale(0.85) rotate(360deg)';
                    setTimeout(() => {
                        themeBtn.style.transform = '';
                    }, 550);
                });
            }

            // Auth Switch Tab Handler
            function setAuthMode(mode) {
                const isReg = mode === 'register';

                // Ensure onload animations don't block interactive transitions
                if (container) {
                    container.classList.add('is-animated-ready');
                    container.classList.toggle('is-register-active', isReg);
                    container.setAttribute('data-current-tab', mode);
                }

                // Update mobile segmented tab pill
                if (mobileTabsWrapper) {
                    mobileTabsWrapper.setAttribute('data-active-tab', mode);
                }

                mobileTabBtns.forEach(btn => {
                    btn.classList.toggle('is-active', btn.getAttribute('data-mobile-tab') === mode);
                });

                // Auto-focus the first visible input
                setTimeout(() => {
                    const activeSlot = isReg ? container.querySelector('.sign-up-slot') : container.querySelector('.sign-in-slot');
                    if (activeSlot) {
                        const firstInput = activeSlot.querySelector('input:not([type="hidden"])');
                        if (firstInput) {
                            firstInput.focus();
                        }
                    }
                }, 350);

                // Update URL parameter without page reload
                if (window.history && window.history.replaceState) {
                    const url = new URL(window.location);
                    url.searchParams.set('tab', mode);
                    window.history.replaceState({}, '', url);
                }
            }

            // Switch button click triggers
            switchTriggers.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetMode = btn.getAttribute('data-switch-trigger');
                    setAuthMode(targetMode);
                });
            });

            // Mobile segmented tab buttons
            mobileTabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetMode = btn.getAttribute('data-mobile-tab');
                    setAuthMode(targetMode);
                });
            });

            // Show/Hide Password Toggle Logic
            document.querySelectorAll('[data-password-toggle]').forEach(toggleBtn => {
                toggleBtn.addEventListener('click', () => {
                    const inputWrap = toggleBtn.closest('.input-wrap');
                    if (!inputWrap) return;

                    const passwordInput = inputWrap.querySelector('[data-password-input]') || inputWrap.querySelector('input[type="password"], input[type="text"]');
                    const eyeIcon = toggleBtn.querySelector('[data-eye-icon]');
                    if (!passwordInput) return;

                    const isCurrentlyPassword = passwordInput.type === 'password';
                    passwordInput.type = isCurrentlyPassword ? 'text' : 'password';
                    if (eyeIcon) {
                        eyeIcon.textContent = isCurrentlyPassword ? '🙈' : '👁️';
                    }
                    toggleBtn.setAttribute('aria-label', isCurrentlyPassword ? 'Sembunyikan kata sandi' : 'Lihat kata sandi');
                });
            });
        });
    </script>
</body>
</html>
