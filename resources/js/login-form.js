// resources/js/login-form.js
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-auth-container]').forEach(initAuthCard);
});

export function initAuthCard(container) {
    if (!container) return;

    const tabsWrapper = container.querySelector('[data-tabs-wrapper]');
    const tabButtons = container.querySelectorAll('[data-tab-target]');
    const panels = container.querySelectorAll('[data-panel]');
    const switchLinks = container.querySelectorAll('[data-switch-to]');

    function switchTab(targetTab) {
        // Update tabs container active state for pill slide animation
        if (tabsWrapper) {
            tabsWrapper.setAttribute('data-active-tab', targetTab);
        }

        // Update tab buttons
        tabButtons.forEach(btn => {
            const isActive = btn.getAttribute('data-tab-target') === targetTab;
            btn.classList.toggle('is-active', isActive);
        });

        // Update panels with entrance animation
        panels.forEach(panel => {
            const isTarget = panel.getAttribute('data-panel') === targetTab;
            if (isTarget) {
                panel.classList.remove('is-active');
                void panel.offsetWidth; // Force DOM reflow to trigger CSS keyframes
                panel.classList.add('is-active');

                // Focus the first input inside the active panel
                const firstInput = panel.querySelector('input:not([type="hidden"])');
                if (firstInput) {
                    setTimeout(() => firstInput.focus(), 150);
                }
            } else {
                panel.classList.remove('is-active');
            }
        });

        // Update URL parameter without reload (if supported)
        if (window.history && window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.set('tab', targetTab);
            window.history.replaceState({}, '', url);
        }
    }

    // Tab button click listeners
    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-tab-target');
            switchTab(target);
        });
    });

    // Quick switch links ("Daftar sekarang" / "Masuk sekarang")
    switchLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const target = link.getAttribute('data-switch-to');
            switchTab(target);
        });
    });

    // Password Toggle Logic
    container.querySelectorAll('[data-password-toggle]').forEach(btn => {
        btn.addEventListener('click', () => {
            const wrap = btn.closest('.input-wrap');
            if (!wrap) return;
            const input = wrap.querySelector('[data-password-input]') || wrap.querySelector('input[type="password"], input[type="text"]');
            const eye = btn.querySelector('[data-eye-icon]');
            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            if (eye) {
                eye.textContent = isPassword ? '🙈' : '👁️';
            }
            btn.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Lihat kata sandi');
        });
    });
}
