<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Guru — PKBM Tahfiz At-Tamam</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "Plus Jakarta Sans", system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            color: #1e293b;
        }
        .login-left {
            flex: 1;
            position: relative;
            display: none;
            overflow: hidden;
        }
        @media (min-width: 900px) {
            .login-left { display: block; }
        }
        .login-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        .login-left-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(127, 29, 29, 0.75) 0%, rgba(15, 23, 42, 0.85) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
            color: #fff;
        }
        .login-left-overlay h2 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            line-height: 1.25;
        }
        .login-left-overlay p {
            font-size: 0.95rem;
            opacity: 0.9;
            max-width: 360px;
            line-height: 1.6;
        }
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.12);
            padding: 2.25rem 2rem;
            border: 1px solid #e2e8f0;
        }
        .login-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 1.75rem;
        }
        .login-brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #b91c1c, #7f1d1d);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(185, 28, 28, 0.35);
        }
        .login-brand-text h1 {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }
        .login-brand-text span {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }
        .login-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.35rem;
        }
        .login-subtitle {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 1.75rem;
        }
        .form-group { margin-bottom: 1.15rem; }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.4rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #f8fafc;
        }
        .form-input:focus {
            outline: none;
            border-color: #b91c1c;
            box-shadow: 0 0 0 3px rgba(185, 28, 28, 0.15);
            background: #fff;
        }
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .remember {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #475569;
            cursor: pointer;
        }
        .remember input { width: 16px; height: 16px; accent-color: #b91c1c; }
        .btn-login {
            width: 100%;
            padding: 0.85rem 1.25rem;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #b91c1c 0%, #7f1d1d 100%);
            color: #fff;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 10px 25px -5px rgba(185, 28, 28, 0.4);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px -5px rgba(185, 28, 28, 0.5);
        }
        .back-home {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid #e2e8f0;
            font-size: 0.9rem;
            font-weight: 600;
            color: #475569;
            text-decoration: none;
            transition: color 0.2s;
        }
        .back-home:hover { color: #b91c1c; }
        .alert-status {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }
        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }
    </style>
</head>
<body>
    <div class="login-left">
        <img src="{{ asset("sekolah.jpg") }}" alt="PKBM Tahfiz At-Tamam">
        <div class="login-left-overlay">
            <h2>PKBM Tahfiz At-Tamam</h2>
            <p>Portal internal untuk guru & staf. Kelola berita, PPDB, dan data akademik dengan aman.</p>
        </div>
    </div>
    <div class="login-right">
        <div class="login-card">
            <div class="login-brand">
                <div class="login-brand-icon">🏫</div>
                <div class="login-brand-text">
                    <h1>PKBM Tahfiz At-Tamam</h1>
                    <span>Panel Guru & Admin</span>
                </div>
            </div>
            <h2 class="login-title">Masuk ke Akun Anda</h2>
            <p class="login-subtitle">Gunakan email dan kata sandi yang terdaftar.</p>
            @if (session("status"))
                <div class="alert-status">{{ session("status") }}</div>
            @endif
            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ url("/login-process") }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input class="form-input" id="email" type="email" name="email" value="{{ old("email") }}" required autofocus autocomplete="username" placeholder="guru@attamam.sch.id">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Kata Sandi</label>
                    <input class="form-input" id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                </div>
                <div class="form-row">
                    <label class="remember">
                        <input type="checkbox" name="remember">
                        Ingat saya
                    </label>
                </div>
                <button type="submit" class="btn-login">Masuk ke Admin Panel</button>
            </form>
            <a href="{{ url("/") }}" class="back-home">← Kembali ke Halaman Utama</a>
        </div>
    </div>
</body>
</html>
