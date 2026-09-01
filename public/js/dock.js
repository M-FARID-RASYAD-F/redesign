// public/js/dock.js
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-dock]').forEach(initDock);
});

function initDock(dockRoot) {
    const panel = dockRoot.querySelector('[data-dock-panel]');
    const items = Array.from(dockRoot.querySelectorAll('[data-dock-item]'));

    const panelHeight = Number(dockRoot.dataset.panelHeight) || 56;
    const magnification = Number(dockRoot.dataset.magnification) || 68;
    const distance = Number(dockRoot.dataset.distance) || 120;
    const maxHeight = Math.max(96, magnification + magnification / 2 + 4);

    const MIN_WIDTH = 40;

    // Linear interpolation algorithm from icon.md
    function lerp(value, inMin, inMax, outMin, outMax) {
        if (value <= inMin) return outMin;
        if (value >= inMax) return outMax;
        const t = (value - inMin) / (inMax - inMin);
        return outMin + t * (outMax - outMin);
    }

    function updateItemWidths(mouseX) {
        items.forEach((item) => {
            const rect = item.getBoundingClientRect();
            const itemCenter = rect.x + rect.width / 2;
            const dist = mouseX - itemCenter;

            let width;
            if (dist < -distance || dist > distance) {
                width = MIN_WIDTH;
            } else if (dist <= 0) {
                width = lerp(dist, -distance, 0, MIN_WIDTH, magnification);
            } else {
                width = lerp(dist, 0, distance, magnification, MIN_WIDTH);
            }

            item.style.width = `${width}px`;
            const icon = item.querySelector('[data-dock-icon]');
            if (icon) {
                const iconSize = Math.round(width * 0.5);
                icon.style.width = `${iconSize}px`;
                icon.style.height = `${iconSize}px`;
            }
        });
    }

    function resetItemWidths() {
        items.forEach((item) => {
            item.style.width = `${MIN_WIDTH}px`;
            const icon = item.querySelector('[data-dock-icon]');
            if (icon) {
                icon.style.width = '20px';
                icon.style.height = '20px';
            }
        });
    }

    dockRoot.addEventListener('mousemove', (e) => {
        dockRoot.style.height = `${maxHeight}px`;
        updateItemWidths(e.clientX);
    });

    dockRoot.addEventListener('mouseleave', () => {
        dockRoot.style.height = `${panelHeight}px`;
        resetItemWidths();
    });

    // Keyboard focus accessibility
    items.forEach((item) => {
        item.addEventListener('focus', () => {
            const rect = item.getBoundingClientRect();
            updateItemWidths(rect.x + rect.width / 2);
        });
        item.addEventListener('blur', resetItemWidths);
    });

    resetItemWidths();
}
