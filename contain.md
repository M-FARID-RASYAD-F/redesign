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
{{-- resources/views/components/animated-tabs.blade.php --}}
@props([
    'tabs' => [
        [
            'id' => 'tab1',
            'label' => 'Tab 1',
            'title' => 'Tab 1',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
            'image' => 'https://images.unsplash.com/photo-1493552152660-f915ab47ae9d?q=80&w=3087&auto=format&fit=crop',
        ],
        [
            'id' => 'tab2',
            'label' => 'Tab 2',
            'title' => 'Tab 2',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
            'image' => 'https://images.unsplash.com/photo-1506543730435-e2c1d4553a84?q=80&w=2362&auto=format&fit=crop',
        ],
        [
            'id' => 'tab3',
            'label' => 'Tab 3',
            'title' => 'Tab 3',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.',
            'image' => 'https://images.unsplash.com/photo-1522428938647-2baa7c899f2f?q=80&w=2000&auto=format&fit=crop',
        ],
    ],
    'defaultTab' => null,
])

@php
    $active = $defaultTab ?? ($tabs[0]['id'] ?? null);
@endphp

<div class="w-full max-w-lg flex flex-col gap-y-1" data-animated-tabs>
    <div class="flex gap-2 flex-wrap bg-[#11111198] bg-opacity-50 backdrop-blur-sm p-1 rounded-xl relative">
        @foreach ($tabs as $tab)
            <button
                type="button"
                data-tab-id="{{ $tab['id'] }}"
                class="tab-btn relative px-3 py-1.5 text-sm font-medium rounded-lg text-white outline-none transition-colors"
                data-active="{{ $tab['id'] === $active ? 'true' : 'false' }}"
            >
                <span class="tab-highlight absolute inset-0 bg-[#111111d1] bg-opacity-50 shadow-[0_0_20px_rgba(0,0,0,0.2)] backdrop-blur-sm !rounded-lg {{ $tab['id'] === $active ? '' : 'hidden' }}"></span>
                <span class="relative z-10">{{ $tab['label'] }}</span>
            </button>
        @endforeach
    </div>

    <div class="p-4 bg-[#11111198] shadow-[0_0_20px_rgba(0,0,0,0.2)] text-white bg-opacity-50 backdrop-blur-sm rounded-xl border min-h-60 h-full relative overflow-hidden">
        @foreach ($tabs as $tab)
            <div
                data-tab-panel="{{ $tab['id'] }}"
                class="tab-panel grid grid-cols-2 gap-4 w-full h-full {{ $tab['id'] === $active ? '' : 'hidden' }}"
            >
                <img
                    src="{{ $tab['image'] }}"
                    alt="{{ $tab['label'] }}"
                    class="rounded-lg w-full h-60 object-cover mt-0 !m-0 shadow-[0_0_20px_rgba(0,0,0,0.2)] border-none"
                />
                <div class="flex flex-col gap-y-2">
                    <h2 class="text-2xl font-bold mb-0 text-white mt-0 !m-0">{{ $tab['title'] }}</h2>
                    <p class="text-sm text-gray-200 mt-0">{{ $tab['desc'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
```

```css
/* resources/css/app.css */
@keyframes tabFadeIn {
    from {
        opacity: 0;
        transform: scale(0.95) translateX(-10px);
        filter: blur(10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateX(0);
        filter: blur(0px);
    }
}

.tab-panel-enter {
    animation: tabFadeIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) both;
}

.tab-highlight {
    transition: opacity 0.3s ease;
}
```

```js
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
                highlight.classList.toggle('hidden', !isActive);
            });

            panels.forEach((panel) => {
                if (panel.dataset.tabPanel === targetId) {
                    panel.classList.remove('hidden', 'tab-panel-enter');
                    void panel.offsetWidth;
                    panel.classList.add('tab-panel-enter');
                } else {
                    panel.classList.add('hidden');
                }
            });
        });
    });
}
```

No external NPM dependencies are required (no framer-motion) — animation is handled by native CSS keyframes and vanilla JS.

Implementation Guidelines
1. Analyze the component structure and identify the props passed via `@props` in the Blade component
2. Review the component's data attributes (`data-tab-id`, `data-tab-panel`, `data-active`) which drive the JS state instead of React state
3. Import `resources/js/animated-tabs.js` into `resources/js/app.js` and ensure `tailwind.config.js` scans `./resources/**/*.blade.php`
4. Questions to Ask
   - What tabs data will be passed to `<x-animated-tabs :tabs="..." />`?
   - Is Alpine.js already used in this project? If so, offer an `x-data`/`x-show` version instead of raw JS
   - Are there any required image assets, or should Unsplash placeholders be used?
   - What is the expected responsive behavior on mobile widths?
   - Where in the Blade layout should `<x-animated-tabs />` be placed?

Steps to integrate
0. Copy-paste all the code above into the correct directories
1. Register `animated-tabs.js` import inside `resources/js/app.js`
2. Fill image assets with Unsplash stock images you know exist, or replace with local asset paths
3. Use lucide icons (via CDN or `blade-ui-kit/blade-icons`) if the component requires icons/SVGs
4. Run `npm run build` (or `npm run dev`) to compile Tailwind and JS assets