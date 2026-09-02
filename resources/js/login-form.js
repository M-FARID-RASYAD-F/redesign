// resources/js/login-form.js
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-auth-container]').forEach(initAuthCard);
});

export function initAuthCard(container) {
    if (!container) return;

    const mobileTabsWrapper = container.querySelector('[data-mobile-tabs]');
    const mobileTabBtns = container.querySelectorAll('[data-mobile-tab]');
    const switchTriggers = container.querySelectorAll('[data-switch-trigger]');

    // Ready onload state removal after entrance animation completes
    setTimeout(() => {
        container.classList.add('is-animated-ready');
    }, 900);

    function setAuthMode(mode) {
        const isReg = mode === 'register';

        container.classList.add('is-animated-ready');
        container.classList.toggle('is-register-active', isReg);
        container.setAttribute('data-current-tab', mode);

        if (mobileTabsWrapper) {
            mobileTabsWrapper.setAttribute('data-active-tab', mode);
        }

        mobileTabBtns.forEach(btn => {
            btn.classList.toggle('is-active', btn.getAttribute('data-mobile-tab') === mode);
        });

        // Focus the first input inside the active slot
        setTimeout(() => {
            const activeSlot = isReg ? container.querySelector('.sign-up-slot') : container.querySelector('.sign-in-slot');
            if (activeSlot) {
                const firstInput = activeSlot.querySelector('input:not([type="hidden"])');
                if (firstInput) {
                    firstInput.focus();
                }
            }
        }, 350);

        // Update URL parameter without reload
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
    container.querySelectorAll('[data-password-toggle]').forEach(toggleBtn => {
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
}
