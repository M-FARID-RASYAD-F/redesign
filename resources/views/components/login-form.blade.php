{{-- resources/views/components/login-form.blade.php --}}
@props([
    'defaultTab' => 'login',
    'loginAction' => null,
    'registerAction' => null,
    'email' => null,
])

@php
    $defaultTab = $defaultTab ?? request()->query('tab', old('form_type') === 'register' || $errors->has('name') || $errors->has('password_confirmation') ? 'register' : 'login');
    $loginAction = $loginAction ?? route('login.process');
    $registerAction = $registerAction ?? route('register.process');
    $email = $email ?? old('email');
@endphp

<div class="auth-card" data-auth-container data-default-tab="{{ $defaultTab }}">
    {{-- Brand Header --}}
    <div class="login-brand">
        <div class="login-brand-icon">
            <img src="{{ asset('images/logo.png') }}" alt="Logo At-Tamam">
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
            <h2 class="login-title">Masuk ke Akun Anda</h2>
            <p class="login-subtitle">Masukkan email dan kata sandi yang telah terdaftar.</p>

            <form method="POST" action="{{ $loginAction }}">
                @csrf
                <input type="hidden" name="form_type" value="login">

                <div class="form-group">
                    <label class="form-label" for="comp_login_email">Alamat Email</label>
                    <div class="input-wrap">
                        <input class="form-input" id="comp_login_email" type="email" name="email" value="{{ old('form_type') === 'register' ? '' : $email }}" required autofocus autocomplete="username" placeholder="guru@attamam.sch.id">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="comp_login_password">Kata Sandi</label>
                    <div class="input-wrap">
                        <input class="form-input" id="comp_login_password" type="password" name="password" data-password-input required autocomplete="current-password" placeholder="••••••••">
                        <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                            <span data-eye-icon>👁️</span>
                        </button>
                    </div>
                </div>

                <div class="form-row">
                    <label class="remember">
                        <input type="checkbox" name="remember" id="comp_remember" {{ old('remember') ? 'checked' : '' }}>
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
            <h2 class="login-title">Pendaftaran Akun Baru</h2>
            <p class="login-subtitle">Lengkapi formulir untuk membuat akun pendidik/staf.</p>

            <div class="role-badge-info">
                <span>ℹ️</span>
                <span>Akun baru otomatis didaftarkan sebagai <strong>Editor Akademik & Staf</strong>.</span>
            </div>

            <form method="POST" action="{{ $registerAction }}">
                @csrf
                <input type="hidden" name="form_type" value="register">

                <div class="form-group">
                    <label class="form-label" for="comp_reg_name">Nama Lengkap & Gelar</label>
                    <div class="input-wrap">
                        <input class="form-input" id="comp_reg_name" type="text" name="name" value="{{ old('form_type') === 'register' ? old('name') : '' }}" required autocomplete="name" placeholder="Contoh: Ahmad Dahlan, S.Pd">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="comp_reg_email">Alamat Email</label>
                    <div class="input-wrap">
                        <input class="form-input" id="comp_reg_email" type="email" name="email" value="{{ old('form_type') === 'register' ? old('email') : '' }}" required autocomplete="username" placeholder="nama@attamam.sch.id">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="comp_reg_password">Kata Sandi</label>
                    <div class="input-wrap">
                        <input class="form-input" id="comp_reg_password" type="password" name="password" data-password-input required autocomplete="new-password" placeholder="Minimal 8 karakter">
                        <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                            <span data-eye-icon>👁️</span>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="comp_reg_password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="input-wrap">
                        <input class="form-input" id="comp_reg_password_confirmation" type="password" name="password_confirmation" data-password-input required autocomplete="new-password" placeholder="Ulangi kata sandi">
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
