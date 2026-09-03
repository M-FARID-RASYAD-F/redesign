{{-- resources/views/components/login-form.blade.php --}}
@props([
    'defaultTab' => 'login',
    'loginAction' => null,
    'registerAction' => null,
    'email' => null,
])

@php
    $requestedTab = request()->query('tab');
    $defaultTab = $requestedTab ?? $defaultTab ?? (old('form_type') === 'register' || $errors->has('name') || $errors->has('password_confirmation') ? 'register' : 'login');
    $isRegister = $defaultTab === 'register';
    $loginAction = $loginAction ?? route('login.process');
    $registerAction = $registerAction ?? route('register.process');
    $email = $email ?? old('email');
@endphp

<div class="container {{ $isRegister ? 'sign-up-mode' : '' }}" id="authContainer" data-auth-container>
    <div class="forms-container">
        <div class="signin-signup">
            
            {{-- SIGN IN FORM --}}
            <form class="sign-in-form" method="POST" action="{{ $loginAction }}">
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

                <div class="input-field no-toggle">
                    <i>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </i>
                    <input type="email" name="email" value="{{ old('form_type') === 'register' ? '' : $email }}" placeholder="Email" required autofocus autocomplete="email" spellcheck="false" />
                </div>

                <div class="input-field">
                    <i>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </i>
                    <input type="password" name="password" id="comp_login_password" placeholder="Password" required autocomplete="current-password" />
                    <button type="button" class="btn-field-toggle" data-toggle-password="comp_login_password" aria-label="Tampilkan kata sandi">
                        <span class="eye-icon">👁️</span>
                    </button>
                </div>

                <div class="form-meta-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="comp_remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat saya</span>
                    </label>
                </div>

                <input type="submit" value="Login" class="btn solid" />

                <div class="mobile-switch-text">
                    Belum punya akun? <a href="javascript:void(0)" data-switch-action="signup">Daftar sekarang</a>
                </div>

                <p class="social-text">Or sign in with social platforms</p>

                <div class="social-media">
                    <a href="javascript:void(0)" class="social-icon" title="Google" aria-label="Google">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon" title="Facebook" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="#1877F2" width="20" height="20">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon" title="Twitter" aria-label="Twitter">
                        <svg viewBox="0 0 24 24" fill="#1DA1F2" width="20" height="20">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon" title="LinkedIn" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="#0A66C2" width="20" height="20">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </form>

            {{-- SIGN UP FORM --}}
            <form class="sign-up-form" method="POST" action="{{ $registerAction }}">
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

                <div class="input-field no-toggle">
                    <i>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </i>
                    <input type="text" name="name" value="{{ old('form_type') === 'register' ? old('name') : '' }}" placeholder="Username / Nama Lengkap" required autocomplete="name" />
                </div>

                <div class="input-field no-toggle">
                    <i>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </i>
                    <input type="email" name="email" value="{{ old('form_type') === 'register' ? old('email') : '' }}" placeholder="Email" required autocomplete="email" spellcheck="false" />
                </div>

                <div class="input-field">
                    <i>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </i>
                    <input type="password" name="password" id="comp_reg_password" placeholder="Password" required autocomplete="new-password" />
                    <button type="button" class="btn-field-toggle" data-toggle-password="comp_reg_password" aria-label="Tampilkan kata sandi">
                        <span class="eye-icon">👁️</span>
                    </button>
                </div>

                <div class="input-field">
                    <i>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </i>
                    <input type="password" name="password_confirmation" id="comp_reg_password_confirmation" placeholder="Ulangi Password" required autocomplete="new-password" />
                    <button type="button" class="btn-field-toggle" data-toggle-password="comp_reg_password_confirmation" aria-label="Tampilkan kata sandi">
                        <span class="eye-icon">👁️</span>
                    </button>
                </div>

                <input type="submit" value="Sign up" class="btn" />

                <div class="mobile-switch-text">
                    Sudah punya akun? <a href="javascript:void(0)" data-switch-action="signin">Masuk sekarang</a>
                </div>

                <p class="social-text">Or sign up with social platforms</p>

                <div class="social-media">
                    <a href="javascript:void(0)" class="social-icon" title="Google" aria-label="Google">
                        <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon" title="Facebook" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="#1877F2" width="20" height="20">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon" title="Twitter" aria-label="Twitter">
                        <svg viewBox="0 0 24 24" fill="#1DA1F2" width="20" height="20">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="social-icon" title="LinkedIn" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="#0A66C2" width="20" height="20">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                </div>
            </form>

        </div>
    </div>

    {{-- PANELS CONTAINER --}}
    <div class="panels-container">
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
