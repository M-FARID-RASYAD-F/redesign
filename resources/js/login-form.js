// resources/js/login-form.js
// Handles 21st @appvibed01/components/auth-switch animated sliding container

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('authContainer') || document.querySelector('.container[id*="auth"], [data-auth-container]');
    if (container) {
        initAuthSwitch(container);
    }
});

export function initAuthSwitch(container) {
    if (!container) return;

    const signUpBtn = container.querySelector('#sign-up-btn') || container.querySelector('[data-switch-action="signup"]');
    const signInBtn = container.querySelector('#sign-in-btn') || container.querySelector('[data-switch-action="signin"]');

    function setSignUpMode(isSignUp) {
        if (isSignUp) {
            container.classList.add('sign-up-mode');
        } else {
            container.classList.remove('sign-up-mode');
        }

        // Sync browser URL history
        if (window.history && window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.set('tab', isSignUp ? 'register' : 'login');
            window.history.replaceState({}, '', url);
        }

        // Auto-focus active input
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

    container.querySelectorAll('[data-switch-action]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const action = btn.getAttribute('data-switch-action');
            setSignUpMode(action === 'signup');
        });
    });

    // Password Visibility Toggle
    container.querySelectorAll('[data-toggle-password]').forEach(toggleBtn => {
        toggleBtn.addEventListener('click', () => {
            const targetId = toggleBtn.getAttribute('data-toggle-password');
            const input = document.getElementById(targetId) || toggleBtn.closest('.input-field').querySelector('input[type="password"], input[type="text"]');
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
}
