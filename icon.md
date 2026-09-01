You are given a task to integrate an existing UI component into a Laravel codebase.

The codebase should support:
- Laravel Blade component structure
- Tailwind CSS
- Vanilla JavaScript (no React/framework runtime required)

If it doesn't, provide instructions on how to set up Tailwind CSS in a Laravel project via `npm install -D tailwindcss` and configuring `tailwind.config.js` with the Blade content paths.

Determine the default path for components and assets.
If the default path for Blade components is not `resources/views/components/`, provide instructions on why it's important to create this folder.

Copy-paste this component into the correct directories:


```blade
{{-- resources/views/components/dock.blade.php --}}
@props([
    'items' => [
        ['id' => 'home', 'label' => 'Home', 'icon' => 'home', 'href' => '#'],
        ['id' => 'products', 'label' => 'Products', 'icon' => 'package', 'href' => '#'],
        ['id' => 'components', 'label' => 'Components', 'icon' => 'component', 'href' => '#'],
        ['id' => 'activity', 'label' => 'Activity', 'icon' => 'activity', 'href' => '#'],
        ['id' => 'changelog', 'label' => 'Change Log', 'icon' => 'scroll-text', 'href' => '#'],
        ['id' => 'email', 'label' => 'Email', 'icon' => 'mail', 'href' => '#'],
        ['id' => 'theme', 'label' => 'Theme', 'icon' => 'sun-moon', 'href' => '#'],
    ],
    'panelHeight' => 64,
    'magnification' => 80,
    'distance' => 150,
])

<div class="absolute bottom-2 left-1/2 max-w-full -translate-x-1/2">
    <div
        data-dock
        data-panel-height="{{ $panelHeight }}"
        data-magnification="{{ $magnification }}"
        data-distance="{{ $distance }}"
        class="mx-2 flex max-w-full items-end overflow-x-auto transition-[height] duration-200 ease-out"
        style="scrollbar-width: none;"
    >
        <div
            data-dock-panel
            role="toolbar"
            aria-label="Application dock"
            class="mx-auto flex w-fit items-end gap-4 rounded-2xl bg-gray-50 px-4 pb-3 dark:bg-neutral-900"
            style="height: {{ $panelHeight }}px"
        >
            @foreach ($items as $item)
                <div
                    data-dock-item
                    tabindex="0"
                    role="button"
                    aria-haspopup="true"
                    class="relative inline-flex aspect-square items-center justify-center rounded-full bg-gray-200 transition-[width] duration-150 ease-out dark:bg-neutral-800"
                    style="width: 40px"
                >
                    <span
                        data-dock-label
                        role="tooltip"
                        class="pointer-events-none absolute -top-6 left-1/2 w-fit -translate-x-1/2 whitespace-pre rounded-md border border-gray-200 bg-gray-100 px-2 py-0.5 text-xs text-neutral-700 opacity-0 transition-all duration-200 dark:border-neutral-900 dark:bg-neutral-800 dark:text-white"
                    >
                        {{ $item['label'] }}
                    </span>
                    <div data-dock-icon class="flex items-center justify-center" style="width: 20px">
                        {{-- Ganti dengan <img> atau inline SVG icon sesuai kebutuhan --}}
                        <i data-lucide="{{ $item['icon'] }}" class="h-full w-full text-neutral-600 dark:text-neutral-300"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
```

```css
/* resources/css/app.css */
[data-dock-item]:hover [data-dock-label],
[data-dock-item]:focus [data-dock-label] {
    opacity: 1;
    transform: translate(-50%, -10px);
}

[data-dock-label] {
    transform: translate(-50%, 0);
}
```

```js
// resources/js/dock.js
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-dock]').forEach(initDock);
});

function initDock(dockRoot) {
    const panel = dockRoot.querySelector('[data-dock-panel]');
    const items = Array.from(dockRoot.querySelectorAll('[data-dock-item]'));

    const panelHeight = Number(dockRoot.dataset.panelHeight) || 64;
    const magnification = Number(dockRoot.dataset.magnification) || 80;
    const distance = Number(dockRoot.dataset.distance) || 150;
    const maxHeight = Math.max(128, magnification + magnification / 2 + 4);

    const MIN_WIDTH = 40;

    // Interpolasi linear sederhana sebagai pengganti useTransform milik framer-motion
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
            if (icon) icon.style.width = `${width / 2}px`;
        });
    }

    function resetItemWidths() {
        items.forEach((item) => {
            item.style.width = `${MIN_WIDTH}px`;
            const icon = item.querySelector('[data-dock-icon]');
            if (icon) icon.style.width = `${MIN_WIDTH / 2}px`;
        });
    }

    dockRoot.addEventListener('mousemove', (e) => {
        dockRoot.style.height = `${maxHeight}px`;
        updateItemWidths(e.pageX);
    });

    dockRoot.addEventListener('mouseleave', () => {
        dockRoot.style.height = `${panelHeight}px`;
        resetItemWidths();
    });

    // Aksesibilitas: keyboard focus juga memicu efek magnify pada item itu sendiri
    items.forEach((item) => {
        item.addEventListener('focus', () => {
            const rect = item.getBoundingClientRect();
            updateItemWidths(rect.x + rect.width / 2);
        });
        item.addEventListener('blur', resetItemWidths);
    });

    resetItemWidths();
}
```

No external NPM dependencies are required (no framer-motion) — the magnify-on-hover and spring-like resizing effect is approximated using `getBoundingClientRect()`, linear interpolation, and CSS `transition` for smoothing instead of physics-based spring animation.

Implementation Guidelines
1. Analyze the component structure and identify the props passed via `@props` (`items`, `panelHeight`, `magnification`, `distance`)
2. Review how mouse position drives per-item width via `data-dock-item` elements instead of React `MotionValue`/`useTransform`
3. Import `resources/js/dock.js` into `resources/js/app.js`; if using Lucide icons, include `lucide` via CDN (`<script src="https://unpkg.com/lucide@latest"></script>`) and call `lucide.createIcons()` after mount
4. Questions to Ask
   - What dock items/icons will be passed to `<x-dock :items="..." />`?
   - Will icons be Lucide (via `<i data-lucide="...">`), inline SVG, or image assets?
   - Is a true spring/elastic easing required, or is CSS `transition` smoothing acceptable?
   - What is the expected mobile/touch behavior (hover doesn't exist on touch devices — consider tap-to-reveal label instead)?
   - Where in the Blade layout should `<x-dock />` be mounted (e.g. fixed bottom nav)?

Steps to integrate
0. Copy-paste all the code above into the correct directories
1. Register `dock.js` import inside `resources/js/app.js`
2. Add Lucide via CDN script tag and call `lucide.createIcons()`, or swap `<i data-lucide="...">` for inline SVGs / image assets
3. Run `npm run build` (or `npm run dev`) to compile Tailwind and JS assets
4. Test hover magnification behavior across desktop widths, and verify a graceful fallback (e.g. no magnify, just tap) on touch devices