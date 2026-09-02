{{-- resources/views/components/login-form.blade.php --}}
@props([
    'defaultTab' => 'login',
    'loginAction' => null,
    'registerAction' => null,
    'email' => null,
])

@php
    $defaultTab = $defaultTab ?? request()->query('tab', old('form_type') === 'register' || $errors->has('name') || $errors->has('password_confirmation') ? 'register' : 'login');
    $isRegister = $defaultTab === 'register';
    $loginAction = $loginAction ?? route('login.process');
    $registerAction = $registerAction ?? route('register.process');
    $email = $email ?? old('email');
@endphp

<div class="auth-switch-wrapper">
    <div class="auth-switch-container {{ $isRegister ? 'is-register-active' : '' }}" data-auth-container data-current-tab="{{ $defaultTab }}">
        
        {{-- Mobile Segmented Switch Pill (Visible <= 860px) --}}
        <div class="mobile-tab-switch" data-mobile-tabs data-active-tab="{{ $defaultTab }}">
            <div class="mobile-tab-pill"></div>
            <button type="button" class="mobile-tab-btn {{ !$isRegister ? 'is-active' : '' }}" data-mobile-tab="login">
                <span>🔑 Masuk</span>
            </button>
            <button type="button" class="mobile-tab-btn {{ $isRegister ? 'is-active' : '' }}" data-mobile-tab="register">
                <span>📝 Daftar Akun</span>
            </button>
        </div>

        {{-- SLOT 1: SIGN IN FORM --}}
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

            @if (session('status'))
                <div class="alert-status">✓ {{ session('status') }}</div>
            @endif

            @if ($errors->any() && old('form_type') !== 'register')
                <div class="alert-error">⚠️ {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ $loginAction }}">
                @csrf
                <input type="hidden" name="form_type" value="login">

                <div class="form-group">
                    <label class="form-label" for="comp_login_email">Alamat Email</label>
                    <div class="input-wrap">
                        <span class="input-icon-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                        <input class="form-input" id="comp_login_email" type="email" name="email" value="{{ old('form_type') === 'register' ? '' : $email }}" required autofocus autocomplete="username" placeholder="guru@attamam.sch.id">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="comp_login_password">Kata Sandi</label>
                    <div class="input-wrap">
                        <span class="input-icon-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input class="form-input" id="comp_login_password" type="password" name="password" data-password-input required autocomplete="current-password" placeholder="••••••••">
                        <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                            <span data-eye-icon>👁️</span>
                        </button>
                    </div>
                </div>

                <div class="form-options-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="comp_remember" {{ old('remember') ? 'checked' : '' }}>
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

        {{-- SLOT 2: SIGN UP FORM --}}
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

            <form method="POST" action="{{ $registerAction }}">
                @csrf
                <input type="hidden" name="form_type" value="register">

                <div class="form-group">
                    <label class="form-label" for="comp_reg_name">Nama Lengkap & Gelar</label>
                    <div class="input-wrap">
                        <span class="input-icon-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <input class="form-input" id="comp_reg_name" type="text" name="name" value="{{ old('form_type') === 'register' ? old('name') : '' }}" required autocomplete="name" placeholder="Contoh: Ahmad Dahlan, S.Pd">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="comp_reg_email">Alamat Email</label>
                    <div class="input-wrap">
                        <span class="input-icon-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                        <input class="form-input" id="comp_reg_email" type="email" name="email" value="{{ old('form_type') === 'register' ? old('email') : '' }}" required autocomplete="username" placeholder="nama@attamam.sch.id">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="comp_reg_password">Kata Sandi</label>
                    <div class="input-wrap">
                        <span class="input-icon-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                        <input class="form-input" id="comp_reg_password" type="password" name="password" data-password-input required autocomplete="new-password" placeholder="Minimal 8 karakter">
                        <button type="button" class="toggle-password-btn" data-password-toggle aria-label="Lihat kata sandi" title="Lihat/Sembunyikan kata sandi">
                            <span data-eye-icon>👁️</span>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="comp_reg_password_confirmation">Konfirmasi Kata Sandi</label>
                    <div class="input-wrap">
                        <span class="input-icon-left">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>
                        </span>
                        <input class="form-input" id="comp_reg_password_confirmation" type="password" name="password_confirmation" data-password-input required autocomplete="new-password" placeholder="Ulangi kata sandi">
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

        {{-- SLIDING OVERLAY CHASSIS --}}
        <div class="overlay-chassis">
            {{-- Glowing Animated Divider Line on Edge --}}
            <div class="overlay-divider-glow"></div>

            <div class="overlay-inner">
                <div class="overlay-blob overlay-blob-1"></div>
                <div class="overlay-blob overlay-blob-2"></div>

                {{-- Overlay Panel Left (In REGISTER mode) --}}
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

                {{-- Overlay Panel Right (In LOGIN mode) --}}
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
