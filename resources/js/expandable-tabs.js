/**
 * Expandable Tabs Engine (Pure Vanilla JavaScript)
 * Menyediakan interaktivitas tab navigasi kapsul:
 * - Keyboard accessibility (ArrowLeft / ArrowRight / Home / End)
 * - Tactile press micro-interaction feedback
 * - Pengaturan state aktif dan interaksi ekspansi tab yang mulus
 */

export function initExpandableTabs() {
    const tablists = document.querySelectorAll('.expandable-nav-tabs');
    if (!tablists.length) return;

    tablists.forEach((tablist) => {
        const tabs = Array.from(tablist.querySelectorAll('.expandable-tab-btn'));
        if (!tabs.length) return;

        if (!tablist.getAttribute('role')) {
            tablist.setAttribute('role', 'navigation');
        }

        tabs.forEach((tab, index) => {
            // Tactile press micro-interaction
            tab.addEventListener('mousedown', () => {
                tab.classList.add('nav-link-pressed');
            });
            ['mouseup', 'mouseleave'].forEach((evt) => {
                tab.addEventListener(evt, () => {
                    tab.classList.remove('nav-link-pressed');
                });
            });

            // Keyboard accessibility navigation
            tab.addEventListener('keydown', (e) => {
                let nextIdx = null;
                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    nextIdx = (index + 1) % tabs.length;
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    nextIdx = (index - 1 + tabs.length) % tabs.length;
                } else if (e.key === 'Home') {
                    e.preventDefault();
                    nextIdx = 0;
                } else if (e.key === 'End') {
                    e.preventDefault();
                    nextIdx = tabs.length - 1;
                }

                if (nextIdx !== null && tabs[nextIdx]) {
                    tabs[nextIdx].focus();
                }
            });
        });
    });
}

// Auto-initialize when DOM is ready
if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initExpandableTabs);
    } else {
        initExpandableTabs();
    }
}
