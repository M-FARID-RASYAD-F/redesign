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
        :root, [data-theme="dark"] {
            --bg-gradient: radial-gradient(circle at 12% 18%, rgba(0, 180, 216, 0.18) 0%, transparent 45%),
                           radial-gradient(circle at 88% 82%, rgba(0, 33, 71, 0.85) 0%, transparent 55%),
                           #001529;
            --circle-gradient: linear-gradient(-45deg, #00B4D8 0%, #0077B6 50%, #002147 100%);
            --card-bg: #002147;
            --card-border: rgba(0, 180, 216, 0.35);
            --card-shadow: 0 25px 70px rgba(0, 12, 28, 0.75), 0 0 45px rgba(0, 180, 216, 0.22);
            --title-color: #ffffff;
            --input-bg: rgba(0, 21, 41, 0.82);
            --input-hover-bg: rgba(0, 33, 71, 0.95);
            --input-border: rgba(0, 180, 216, 0.28);
            --input-text: #ffffff;
            --input-placeholder: #94a3b8;
            --input-icon: #00B4D8;
            --primary-btn: linear-gradient(135deg, #00B4D8 0%, #0077B6 100%);
            --primary-btn-hover: linear-gradient(135deg, #38bdf8 0%, #0096c7 100%);
            --primary-btn-shadow: rgba(0, 180, 216, 0.45);
            --social-border: rgba(0, 180, 216, 0.32);
            --social-color: #00B4D8;
            --social-hover-border: #38bdf8;
            --social-text: #cbd5e1;
            --panel-text: #ffffff;
            --panel-desc: rgba(255, 255, 255, 0.92);
            --nav-btn-bg: rgba(0, 33, 71, 0.85);
            --nav-btn-border: rgba(0, 180, 216, 0.35);
            --nav-btn-text: #ffffff;
            --badge-bg: rgba(0, 180, 216, 0.12);
            --badge-border: rgba(0, 180, 216, 0.35);
            --badge-text: #38bdf8;
        }

        [data-theme="light"] {
            /* White / Light Mode: Deep Maroon & Crimson Rose ☀️ (Sesuai btnswitch.md & Admin Dashboard) */
            --bg-gradient: radial-gradient(circle at 12% 18%, oklch(58.6% 0.253 17.585 / 0.22) 0%, transparent 45%),
                           radial-gradient(circle at 88% 82%, oklch(27.1% 0.105 12.094 / 0.85) 0%, transparent 50%),
                           oklch(41% 0.159 10.272);
            --circle-gradient: linear-gradient(-45deg, oklch(58.6% 0.253 17.585) 0%, oklch(48% 0.22 17) 50%, oklch(27.1% 0.105 12.094) 100%);
            --card-bg: oklch(27.1% 0.105 12.094);
            --card-border: oklch(58.6% 0.253 17.585 / 0.45);
            --card-shadow: 0 25px 70px rgba(45, 10, 15, 0.65), 0 0 40px oklch(58.6% 0.253 17.585 / 0.25);
            --title-color: #ffffff;
            --input-bg: oklch(20% 0.08 11 / 0.85);
            --input-hover-bg: oklch(24% 0.095 11.5 / 0.95);
            --input-border: oklch(58.6% 0.253 17.585 / 0.38);
            --input-text: #ffffff;
            --input-placeholder: oklch(75% 0.18 18 / 0.65);
            --input-icon: oklch(58.6% 0.253 17.585);
            --primary-btn: linear-gradient(135deg, oklch(58.6% 0.253 17.585) 0%, oklch(48% 0.22 17) 100%);
            --primary-btn-hover: linear-gradient(135deg, oklch(65% 0.26 18) 0%, oklch(55% 0.24 17) 100%);
            --primary-btn-shadow: oklch(58.6% 0.253 17.585 / 0.48);
            --social-border: oklch(58.6% 0.253 17.585 / 0.38);
            --social-color: oklch(58.6% 0.253 17.585);
            --social-hover-border: oklch(65% 0.26 18);
            --social-text: #ffe4e6;
            --panel-text: #ffffff;
            --panel-desc: #ffe4e6;
            --nav-btn-bg: oklch(27.1% 0.105 12.094 / 0.85);
            --nav-btn-border: oklch(58.6% 0.253 17.585 / 0.4);
            --nav-btn-text: #ffffff;
            --badge-bg: oklch(58.6% 0.253 17.585 / 0.18);
            --badge-border: oklch(58.6% 0.253 17.585 / 0.45);
            --badge-text: #ffe4e6;
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
            border: 1.5px solid var(--card-border);
            border-radius: 28px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: background 0.4s ease, box-shadow 0.4s ease, border-color 0.4s ease;
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
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 0.85rem;
            padding: 0.35rem 0.95rem;
            border-radius: 9999px;
            background: var(--badge-bg);
            border: 1px solid var(--badge-border);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .brand-badge img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            border-radius: 6px;
        }

        .brand-badge span {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--badge-text);
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
            border: 1.5px solid var(--input-border);
            overflow: hidden;
        }

        .input-field.no-toggle {
            grid-template-columns: 15% 85%;
        }

        .input-field:focus-within {
            background-color: var(--input-hover-bg);
            border-color: var(--input-icon);
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
            background: transparent !important;
            background-color: transparent !important;
            outline: none !important;
            border: none !important;
            box-shadow: none !important;
            line-height: 1;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--input-text) !important;
            -webkit-text-fill-color: var(--input-text) !important;
            caret-color: var(--input-text) !important;
            width: 100%;
            height: 100%;
            font-family: inherit;
        }

        .input-field input::placeholder {
            color: var(--input-placeholder);
            opacity: 0.75;
            font-weight: 400;
        }

        /* ═══════════════════════════════════════════════════════════
           BROWSER AUTOFILL & TYPING INVISIBILITY FIX (Chrome, Edge, Safari, Firefox)
           Mencegah background input berubah jadi putih dan teks hilang saat mengetik / autofill
           ═══════════════════════════════════════════════════════════ */
        .input-field input:-webkit-autofill,
        .input-field input:-webkit-autofill:hover, 
        .input-field input:-webkit-autofill:focus, 
        .input-field input:-webkit-autofill:active,
        .input-field input:-internal-autofill-selected {
            -webkit-box-shadow: 0 0 0 1000px var(--input-bg) inset !important;
            box-shadow: 0 0 0 1000px var(--input-bg) inset !important;
            -webkit-text-fill-color: var(--input-text) !important;
            color: var(--input-text) !important;
            caret-color: var(--input-text) !important;
            border-radius: 50px !important;
            font-size: 0.95rem !important;
            font-weight: 600 !important;
            font-family: inherit !important;
            transition: background-color 50000s ease-in-out 0s !important;
        }

        .input-field:focus-within input:-webkit-autofill,
        .input-field:focus-within input:-webkit-autofill:hover, 
        .input-field:focus-within input:-webkit-autofill:focus, 
        .input-field:focus-within input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px var(--input-hover-bg) inset !important;
            box-shadow: 0 0 0 1000px var(--input-hover-bg) inset !important;
            -webkit-text-fill-color: var(--input-text) !important;
            color: var(--input-text) !important;
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
            accent-color: var(--input-icon);
            width: 15px;
            height: 15px;
            cursor: pointer;
        }

        /* Buttons */
        .btn {
            width: 160px;
            background: var(--primary-btn);
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
            background: var(--primary-btn-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px var(--primary-btn-shadow);
        }

        .btn:active {
            transform: translateY(1px) scale(0.98);
        }

        .btn.transparent {
            margin: 0;
            background: none;
            border: 2px solid #ffffff;
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
            background: #ffffff;
            color: #0077B6;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        }

        [data-theme="light"] .btn.transparent:hover {
            color: oklch(48% 0.22 17);
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
            color: var(--input-icon);
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .mobile-switch-text a:hover {
            text-decoration: underline;
            filter: brightness(1.25);
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

        /* ═══════════════════════════════════════════════════════════
           SIGN IN LOADING MODAL (GLASSMORPHISM DUAL-RING ORBIT SPINNER)
           Identical to Logout Loading Transition
           ═══════════════════════════════════════════════════════════ */
        .login-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.28s ease, visibility 0.28s ease;
        }

        .login-modal-overlay.is-active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .login-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(7, 13, 30, 0.84);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: opacity 0.28s ease;
        }

        .login-modal-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 430px;
            margin: auto;
        }

        .login-modal-card {
            background: rgba(15, 23, 42, 0.96);
            border: 1.5px solid rgba(56, 189, 248, 0.45);
            border-radius: 28px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.75), 0 0 50px rgba(56, 189, 248, 0.25);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            transform: scale(0.6) translateY(25px);
            opacity: 0;
            filter: blur(8px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .login-modal-overlay.is-active .login-modal-card {
            animation: loginPopIn 0.42s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .login-modal-overlay.is-closing .login-modal-card {
            animation: loginPopOut 0.22s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes loginPopIn {
            0% {
                opacity: 0;
                transform: scale(0.6) translateY(25px);
                filter: blur(8px);
            }
            70% {
                opacity: 1;
                transform: scale(1.05) translateY(-3px);
                filter: blur(0px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
                filter: blur(0px);
            }
        }

        @keyframes loginPopOut {
            0% {
                opacity: 1;
                transform: scale(1) translateY(0);
                filter: blur(0px);
            }
            100% {
                opacity: 0;
                transform: scale(0.7) translateY(15px);
                filter: blur(6px);
            }
        }

        /* Orbit Spinner Container */
        .orbit-spinner-container {
            position: relative;
            width: 104px;
            height: 104px;
            margin: 0 auto 1.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .orbit-ambient-glow {
            position: absolute;
            inset: -16px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.35) 0%, rgba(99, 102, 241, 0.22) 50%, transparent 75%);
            filter: blur(14px);
            animation: orbitAmbientPulse 2s ease-in-out infinite alternate;
        }

        @keyframes orbitAmbientPulse {
            0% { transform: scale(0.88); opacity: 0.6; }
            100% { transform: scale(1.18); opacity: 1; }
        }

        /* Outer Ring (Cyan Orbit) */
        .orbit-ring-outer {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 2.5px solid transparent;
            border-top-color: #38bdf8;
            border-right-color: #0284c7;
            border-bottom-color: rgba(56, 189, 248, 0.15);
            box-shadow: 0 0 18px rgba(56, 189, 248, 0.45);
            animation: orbitClockwise 1.35s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
        }

        .orbit-satellite-outer {
            position: absolute;
            top: 5px;
            right: 12px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #38bdf8;
            box-shadow: 0 0 10px 2.5px #38bdf8;
        }

        /* Inner Ring (Indigo/Purple Orbit) */
        .orbit-ring-inner {
            position: absolute;
            width: 68px;
            height: 68px;
            border-radius: 50%;
            border: 2.5px solid transparent;
            border-top-color: #818cf8;
            border-left-color: #6366f1;
            border-bottom-color: rgba(99, 102, 241, 0.15);
            box-shadow: 0 0 14px rgba(99, 102, 241, 0.45);
            animation: orbitCounterClockwise 1.05s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
        }

        .orbit-satellite-inner {
            position: absolute;
            bottom: 3px;
            left: 8px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #818cf8;
            box-shadow: 0 0 9px 2px #818cf8;
        }

        /* Core Glass Center */
        .orbit-core {
            position: relative;
            z-index: 5;
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: rgba(15, 23, 42, 0.85);
            border: 1.5px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(16px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            animation: corePulse 1.8s ease-in-out infinite;
        }

        @keyframes orbitClockwise {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes orbitCounterClockwise {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }

        @keyframes corePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); box-shadow: 0 0 20px rgba(56, 189, 248, 0.45); }
        }

        .orbit-loading-content {
            width: 100%;
        }

        .orbit-loading-title {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 0.45rem;
            background: linear-gradient(135deg, #ffffff 0%, #bae6fd 60%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.01em;
        }

        .orbit-loading-desc {
            font-size: 0.86rem;
            color: #94a3b8;
            line-height: 1.55;
            margin-bottom: 1.5rem;
        }

        /* Progress Track & Animated Bar */
        .orbit-progress-track {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 9999px;
            overflow: hidden;
            position: relative;
        }

        .orbit-progress-bar {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #38bdf8 0%, #6366f1 50%, #10b981 100%);
            box-shadow: 0 0 12px rgba(56, 189, 248, 0.6);
            border-radius: 9999px;
        }

        .login-modal-overlay.is-active .orbit-progress-bar {
            animation: orbitProgressFill 1.1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes orbitProgressFill {
            0% { width: 0%; }
            40% { width: 65%; }
            80% { width: 88%; }
            100% { width: 100%; }
        }

        @keyframes errorShake {
            10%, 90% { transform: translate3d(-3px, 0, 0); }
            20%, 80% { transform: translate3d(4px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-6px, 0, 0); }
            40%, 60% { transform: translate3d(6px, 0, 0); }
        }

        /* Light Theme (Deep Maroon & Crimson Rose ☀️) Overrides */
        [data-theme="light"] .login-modal-backdrop {
            background: rgba(45, 10, 15, 0.78);
        }
        [data-theme="light"] .login-modal-card {
            background: oklch(27.1% 0.105 12.094 / 0.98);
            border-color: oklch(58.6% 0.253 17.585 / 0.6);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.75), 0 0 50px oklch(58.6% 0.253 17.585 / 0.35);
        }
        [data-theme="light"] .orbit-ambient-glow {
            background: radial-gradient(circle, oklch(58.6% 0.253 17.585 / 0.4) 0%, oklch(48% 0.22 17 / 0.25) 50%, transparent 75%);
        }
        [data-theme="light"] .orbit-ring-outer {
            border-top-color: oklch(58.6% 0.253 17.585);
            border-right-color: oklch(65% 0.26 18);
            border-bottom-color: oklch(58.6% 0.253 17.585 / 0.18);
            box-shadow: 0 0 18px oklch(58.6% 0.253 17.585 / 0.55);
        }
        [data-theme="light"] .orbit-satellite-outer {
            background: oklch(58.6% 0.253 17.585);
            box-shadow: 0 0 10px 2.5px oklch(58.6% 0.253 17.585);
        }
        [data-theme="light"] .orbit-ring-inner {
            border-top-color: oklch(75% 0.18 18);
            border-left-color: oklch(65% 0.26 18);
            border-bottom-color: oklch(58.6% 0.253 17.585 / 0.18);
            box-shadow: 0 0 14px oklch(65% 0.26 18 / 0.45);
        }
        [data-theme="light"] .orbit-satellite-inner {
            background: oklch(75% 0.18 18);
            box-shadow: 0 0 9px 2px oklch(75% 0.18 18);
        }
        [data-theme="light"] .orbit-loading-title {
            background: linear-gradient(135deg, #ffffff 0%, #ffe4e6 60%, oklch(58.6% 0.253 17.585) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        [data-theme="light"] .orbit-loading-desc {
            color: #fecdd3;
        }
        [data-theme="light"] .orbit-core {
            background: oklch(22% 0.09 11 / 0.95);
            border-color: oklch(58.6% 0.253 17.585 / 0.45);
        }
        [data-theme="light"] .orbit-progress-bar {
            background: linear-gradient(90deg, oklch(58.6% 0.253 17.585) 0%, #fb7185 50%, #f43f5e 100%);
            box-shadow: 0 0 12px oklch(58.6% 0.253 17.585 / 0.65);
        }

        /* SweetAlert2 Styling */
        .swal2-container.swal-logout-container {
            z-index: 1000000 !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            background: rgba(15, 23, 42, 0.75) !important;
        }

        .swal2-popup.swal-logout-popup {
            border-radius: 26px !important;
            padding: 2.2rem 2.2rem 2rem !important;
            background: linear-gradient(145deg, rgba(15, 23, 42, 0.96) 0%, rgba(30, 41, 59, 0.97) 100%) !important;
            border: 1.5px solid rgba(255, 255, 255, 0.14) !important;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.65), 0 0 40px rgba(16, 185, 129, 0.16) !important;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
            color: #ffffff !important;
        }

        .swal-logout-popup .swal2-icon.swal2-success {
            border-color: #10b981 !important;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.35) !important;
            margin: 0.6rem auto 1.4rem !important;
            width: 82px !important;
            height: 82px !important;
        }

        .swal-logout-popup .swal2-icon.swal2-success [class^='swal2-success-line'] {
            background-color: #10b981 !important;
        }

        .swal-logout-popup .swal2-icon.swal2-success .swal2-success-ring {
            border-color: rgba(16, 185, 129, 0.35) !important;
            width: 100% !important;
            height: 100% !important;
        }

        .swal-logout-popup .swal2-icon.swal2-success [class^='swal2-circular-line'],
        .swal-logout-popup .swal2-icon.swal2-success .swal2-success-fix {
            background: transparent !important;
        }

        .swal-logout-title {
            font-size: 1.45rem !important;
            font-weight: 800 !important;
            letter-spacing: -0.015em !important;
            color: #ffffff !important;
            background: linear-gradient(135deg, #ffffff 0%, #a7f3d0 50%, #34d399 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            margin-bottom: 0.5rem !important;
            padding: 0 !important;
        }

        .swal-logout-msg {
            font-size: 1.08rem;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 0.4rem;
            letter-spacing: -0.01em;
        }

        .swal-logout-sub {
            font-size: 0.88rem;
            color: #94a3b8;
            line-height: 1.55;
            margin: 0;
        }

        .swal-logout-popup .swal2-actions {
            margin-top: 1.6rem !important;
            gap: 0.75rem;
        }

        .swal-logout-popup .swal2-confirm.swal-logout-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 0.95rem !important;
            border-radius: 14px !important;
            padding: 0.72rem 2.4rem !important;
            border: 1px solid rgba(255, 255, 255, 0.22) !important;
            box-shadow: 0 4px 18px rgba(16, 185, 129, 0.4) !important;
            cursor: pointer !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .swal-logout-popup .swal2-confirm.swal-logout-btn:hover {
            transform: translateY(-2px) scale(1.02) !important;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.55) !important;
        }

        .swal-logout-popup .swal2-timer-progress-bar.swal-logout-progress {
            background: linear-gradient(90deg, #10b981 0%, #06b6d4 50%, #3b82f6 100%) !important;
            height: 4px !important;
            border-radius: 9999px !important;
        }

        [data-theme="light"] .swal2-container.swal-logout-container {
            background: rgba(45, 10, 15, 0.75) !important;
        }
        [data-theme="light"] .swal2-popup.swal-logout-popup {
            background: linear-gradient(145deg, oklch(27.1% 0.105 12.094 / 0.98) 0%, oklch(22% 0.09 11 / 0.99) 100%) !important;
            border: 1.5px solid oklch(58.6% 0.253 17.585 / 0.45) !important;
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.65), 0 0 40px oklch(58.6% 0.253 17.585 / 0.3) !important;
            color: #ffffff !important;
        }
        [data-theme="light"] .swal-logout-title {
            background: linear-gradient(135deg, #ffffff 0%, #fecdd3 50%, oklch(58.6% 0.253 17.585) 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }
        [data-theme="light"] .swal-logout-msg {
            color: #ffffff !important;
        }
        [data-theme="light"] .swal-logout-sub {
            color: #ffe4e6 !important;
        }
        [data-theme="light"] .swal-logout-popup .swal2-confirm.swal-logout-btn {
            background: linear-gradient(135deg, oklch(58.6% 0.253 17.585) 0%, oklch(48% 0.22 17) 100%) !important;
            box-shadow: 0 4px 18px oklch(58.6% 0.253 17.585 / 0.45) !important;
        }
        [data-theme="light"] .swal-logout-popup .swal2-timer-progress-bar.swal-logout-progress {
            background: linear-gradient(90deg, oklch(58.6% 0.253 17.585) 0%, #fb7185 50%, #f43f5e 100%) !important;
        }
    </style>
</head>
<body>
    <script>
        // Set initial theme before paint to prevent flashing
        (function() {
            const savedTheme = localStorage.getItem('auth_theme') || localStorage.getItem('site_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
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
                        <input type="email" name="email" id="login_email" value="{{ old('form_type') === 'register' ? '' : old('email') }}" placeholder="Email" required autofocus autocomplete="email" spellcheck="false" />
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
                        <input type="email" name="email" id="reg_email" value="{{ old('form_type') === 'register' ? old('email') : '' }}" placeholder="Email" required autocomplete="email" spellcheck="false" />
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

    {{-- Modal Loading Autentikasi (Glassmorphism Dual-Ring Orbit Spinner — Identik dengan Transisi Logout) --}}
    <div id="loginLoadingModal" class="login-modal-overlay" aria-hidden="true" role="dialog" aria-labelledby="loginLoadingTitle">
        <div class="login-modal-backdrop"></div>
        <div class="login-modal-container">
            <div class="login-modal-card">
                <div class="orbit-spinner-container">
                    <div class="orbit-ambient-glow"></div>
                    
                    {{-- Outer Clockwise Orbit Ring (Cyan) --}}
                    <div class="orbit-ring-outer">
                        <div class="orbit-satellite-outer"></div>
                    </div>
                    
                    {{-- Inner Counter-Clockwise Orbit Ring (Purple/Indigo) --}}
                    <div class="orbit-ring-inner">
                        <div class="orbit-satellite-inner"></div>
                    </div>
                    
                    {{-- Core Glassmorphism Center --}}
                    <div class="orbit-core">
                        <span>🔐</span>
                    </div>
                </div>

                <div class="orbit-loading-content">
                    <h3 class="orbit-loading-title" id="loginLoadingTitle">Memverifikasi Kredensial...</h3>
                    <p class="orbit-loading-desc">Menghubungkan ke sistem & menyiapkan Dashboard Admin...</p>
                    
                    <div class="orbit-progress-track">
                        <div class="orbit-progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 Library --}}
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

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
            const signInForm = document.querySelector('form.sign-in-form');
            const loginModal = document.getElementById('loginLoadingModal');

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

            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            updateThemeUI(currentTheme);

            if (themeBtn) {
                themeBtn.addEventListener('click', () => {
                    const activeTheme = document.documentElement.getAttribute('data-theme') || 'dark';
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

            // 6. Fix Background Putih Saat Mengetik / Autofill Browser
            document.querySelectorAll('.input-field input').forEach(input => {
                const fixInputColor = () => {
                    input.style.setProperty('background', 'transparent', 'important');
                    input.style.setProperty('background-color', 'transparent', 'important');
                    input.style.setProperty('color', 'var(--input-text)', 'important');
                    input.style.setProperty('-webkit-text-fill-color', 'var(--input-text)', 'important');
                };
                input.addEventListener('input', fixInputColor);
                input.addEventListener('focus', fixInputColor);
                input.addEventListener('blur', fixInputColor);
                input.addEventListener('change', fixInputColor);
            });

            // 7. SIGN IN DUAL-RING ORBIT SPINNER & SWEETALERT (SEPERTI TRANSISI LOGOUT)
            if (signInForm && loginModal) {
                signInForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const emailInput = signInForm.querySelector('input[name="email"]');
                    const passwordInput = signInForm.querySelector('input[name="password"]');

                    if (!emailInput.value.trim() || !passwordInput.value.trim()) {
                        signInForm.reportValidity();
                        return;
                    }

                    // Tampilkan Orbit Loading Modal dengan Pop-In Animation
                    loginModal.classList.remove('is-closing');
                    loginModal.classList.add('is-active');
                    loginModal.setAttribute('aria-hidden', 'false');

                    const formData = new FormData(signInForm);
                    const actionUrl = signInForm.getAttribute('action') || '{{ route("login.process") }}';
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    const startTime = Date.now();
                    const minLoadingDuration = 1150; // Durasi transisi agar animasi orbit dinikmati user

                    fetch(actionUrl, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData,
                        credentials: 'same-origin'
                    })
                    .then(async (response) => {
                        const data = await response.json().catch(() => ({}));
                        const elapsedTime = Date.now() - startTime;
                        const remainingTime = Math.max(0, minLoadingDuration - elapsedTime);

                        setTimeout(() => {
                            // Tutup Loading Modal dengan Pop-Out Transition
                            loginModal.classList.add('is-closing');
                            setTimeout(() => {
                                loginModal.classList.remove('is-active', 'is-closing');
                                loginModal.setAttribute('aria-hidden', 'true');
                            }, 220);

                            if (response.ok && data.status === 'success') {
                                const redirectUrl = data.redirect || '{{ route("admin.dashboard") }}';

                                // Tampilkan SweetAlert2 Animasi Berhasil Masuk
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        title: 'Berhasil Masuk!',
                                        html: `
                                            <div class="swal-logout-body">
                                                <p class="swal-logout-msg">Autentikasi Berhasil!</p>
                                                <p class="swal-logout-sub">Selamat datang kembali di Dashboard Admin. Membuka sesi...</p>
                                            </div>
                                        `,
                                        icon: 'success',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: true,
                                        confirmButtonText: 'Buka Dashboard',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        customClass: {
                                            container: 'swal-logout-container',
                                            popup: 'swal-logout-popup',
                                            title: 'swal-logout-title',
                                            confirmButton: 'swal-logout-btn',
                                            timerProgressBar: 'swal-logout-progress'
                                        }
                                    }).then(() => {
                                        window.location.href = redirectUrl;
                                    });
                                } else {
                                    window.location.href = redirectUrl;
                                }
                            } else {
                                // Error kredensial / validasi gagal
                                const errorMsg = data.errors?.email?.[0] || data.message || 'Email atau password yang Anda masukkan salah. Silakan periksa kembali.';
                                
                                let alertBox = signInForm.querySelector('.alert-box.danger');
                                if (!alertBox) {
                                    alertBox = document.createElement('div');
                                    alertBox.className = 'alert-box danger';
                                    alertBox.innerHTML = '<span>⚠️</span><span class="error-msg-text"></span>';
                                    const titleEl = signInForm.querySelector('.subtitle-text') || signInForm.querySelector('.title');
                                    if (titleEl) titleEl.after(alertBox);
                                }
                                const msgText = alertBox.querySelector('.error-msg-text') || alertBox.querySelector('span:last-child');
                                if (msgText) msgText.textContent = errorMsg;
                                alertBox.style.display = 'flex';

                                // Animasi getar (shake) pada card
                                const card = document.getElementById('authContainer');
                                if (card) {
                                    card.style.animation = 'none';
                                    void card.offsetWidth;
                                    card.style.animation = 'errorShake 0.45s cubic-bezier(0.36, 0.07, 0.19, 0.97) both';
                                }

                                passwordInput.focus();
                                passwordInput.select();
                            }
                        }, remainingTime);
                    })
                    .catch((err) => {
                        console.error('Sign In Error:', err);
                        loginModal.classList.remove('is-active', 'is-closing');
                        loginModal.setAttribute('aria-hidden', 'true');
                        // Fallback browser standard submit
                        signInForm.submit();
                    });
                });
            }
        });
    </script>
</body>
</html>
