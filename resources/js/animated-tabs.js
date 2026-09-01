// resources/js/animated-tabs.js
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-animated-tabs]').forEach(initAnimatedTabs);
});

function initAnimatedTabs(root) {
    const buttons = root.querySelectorAll('.tab-btn');
    const panels = root.querySelectorAll('.tab-panel');

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.tabId;
            if (btn.dataset.active === 'true') return;

            buttons.forEach((b) => {
                const isActive = b === btn;
                b.dataset.active = isActive ? 'true' : 'false';
                const highlight = b.querySelector('.tab-highlight');
                if (highlight) {
                    highlight.classList.toggle('hidden', !isActive);
                }
            });

            panels.forEach((panel) => {
                if (panel.dataset.tabPanel === targetId) {
                    panel.classList.remove('hidden', 'tab-panel-enter');
                    void panel.offsetWidth; // Force DOM reflow to restart animation
                    panel.classList.add('tab-panel-enter');
                } else {
                    panel.classList.add('hidden');
                }
            });
        });
    });
}
