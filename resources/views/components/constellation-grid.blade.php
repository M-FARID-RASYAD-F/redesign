{{--
    resources/views/components/constellation-grid.blade.php

    Background "Beams" ambient — berkas cahaya lembut yang mengambang naik perlahan,
    diadaptasi dari komponen "Beams Background" (kokonutui.com, MIT) versi vanilla JS
    (situs publik ini tidak pakai React/Framer Motion). Warna beam mengikuti palet
    Forest situs: hijau di dark mode, amber/emas di light mode.

    Dibuat seringan mungkin: canvas transparan (background asli tema tetap kepakai),
    blur cukup lewat CSS filter (bukan ctx.filter tiap frame), dan animasi berhenti
    total via IntersectionObserver saat section ini di luar layar.
--}}

<div
    {{ $attributes->merge(['class' => 'relative w-full overflow-hidden select-none content-area-constellation']) }}
>
    <canvas id="constellation-canvas" class="absolute inset-0 block w-full h-full pointer-events-none" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none; filter: blur(22px);"></canvas>

    <div class="constellation-slot-wrapper relative w-full" style="position: relative; z-index: 10;">
        {{ $slot }}
    </div>
</div>

<script>
(function () {
    const canvas = document.getElementById('constellation-canvas');
    if (!canvas) return;

    const root = canvas.parentElement;
    const isMobile = () => window.innerWidth <= 768;
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (isMobile()) {
        canvas.style.display = 'none';
        return;
    }

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    let animationFrameId = null;
    let width = 0;
    let height = 0;
    let isDark = true;
    let isIntersecting = true;

    function readTheme() {
        isDark = document.documentElement.getAttribute('data-theme') !== 'light';
    }
    readTheme();
    window.addEventListener('theme-changed', readTheme);
    new MutationObserver(readTheme)
        .observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

    let beams = [];

    function createBeam(canvasWidth, canvasHeight) {
        const hueBase = isDark ? 150 : 42;
        const hueRange = 22;
        return {
            x: Math.random() * canvasWidth,
            y: Math.random() * canvasHeight,
            width: 36 + Math.random() * 70,
            length: window.innerHeight * 1.3,
            angle: -35 + Math.random() * 10,
            speed: 0.35 + Math.random() * 0.6,
            opacity: 0.10 + Math.random() * 0.14,
            hue: hueBase + Math.random() * hueRange,
            pulse: Math.random() * Math.PI * 2,
            pulseSpeed: 0.015 + Math.random() * 0.02,
        };
    }

    function resetBeam(beam, index, total) {
        const column = index % 3;
        const spacing = width / 3;
        const hueBase = isDark ? 150 : 42;

        beam.y = height + 100;
        beam.x = column * spacing + spacing / 2 + (Math.random() - 0.5) * spacing * 0.6;
        beam.width = 60 + Math.random() * 90;
        beam.speed = 0.35 + Math.random() * 0.45;
        beam.hue = hueBase + (index * 22) / total;
        beam.opacity = 0.12 + Math.random() * 0.1;
    }

    function initBeams() {
        // Kepadatan beam mengikuti tinggi kanvas (wrapper bisa membentang beberapa section),
        // dibatasi supaya tidak meledak jumlahnya di halaman yang sangat panjang.
        const count = Math.min(36, Math.max(14, Math.round(height / 340)));
        beams = Array.from({ length: count }, () => createBeam(width, height));
    }

    function handleResize() {
        if (isMobile()) {
            canvas.style.display = 'none';
            return;
        }
        canvas.style.display = 'block';

        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        const slotWrapper = root.querySelector('.constellation-slot-wrapper') || root;

        canvas.style.width = '100%';
        canvas.style.height = '100%';

        const rect = slotWrapper.getBoundingClientRect();
        width = Math.round(rect.width || root.clientWidth || window.innerWidth);
        height = Math.round(rect.height || slotWrapper.offsetHeight || root.clientHeight || window.innerHeight);

        if (width <= 0 || height <= 0) return;

        canvas.width = Math.floor(width * dpr);
        canvas.height = Math.floor(height * dpr);

        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.scale(dpr, dpr);
        initBeams();
        if (prefersReducedMotion) paintFrame(0);
    }

    handleResize();
    window.addEventListener('resize', handleResize);
    window.addEventListener('load', handleResize);
    document.addEventListener('DOMContentLoaded', handleResize);

    // Re-check ukuran setelah gambar/font selesai load (tinggi wrapper bisa berubah)
    setTimeout(handleResize, 200);
    setTimeout(handleResize, 800);
    setTimeout(handleResize, 1800);

    if (window.ResizeObserver) {
        const slotWrapper = root.querySelector('.constellation-slot-wrapper') || root;
        new ResizeObserver(() => handleResize()).observe(slotWrapper);
    }

    function drawBeam(beam) {
        ctx.save();
        ctx.translate(beam.x, beam.y);
        ctx.rotate((beam.angle * Math.PI) / 180);

        const pulsingOpacity = beam.opacity * (0.8 + Math.sin(beam.pulse) * 0.2);
        const saturation = isDark ? '85%' : '75%';
        const lightness = isDark ? '65%' : '45%';

        const gradient = ctx.createLinearGradient(0, 0, 0, beam.length);
        gradient.addColorStop(0, `hsla(${beam.hue}, ${saturation}, ${lightness}, 0)`);
        gradient.addColorStop(0.1, `hsla(${beam.hue}, ${saturation}, ${lightness}, ${pulsingOpacity * 0.5})`);
        gradient.addColorStop(0.4, `hsla(${beam.hue}, ${saturation}, ${lightness}, ${pulsingOpacity})`);
        gradient.addColorStop(0.6, `hsla(${beam.hue}, ${saturation}, ${lightness}, ${pulsingOpacity})`);
        gradient.addColorStop(0.9, `hsla(${beam.hue}, ${saturation}, ${lightness}, ${pulsingOpacity * 0.5})`);
        gradient.addColorStop(1, `hsla(${beam.hue}, ${saturation}, ${lightness}, 0)`);

        ctx.fillStyle = gradient;
        ctx.fillRect(-beam.width / 2, 0, beam.width, beam.length);
        ctx.restore();
    }

    function paintFrame(dt) {
        ctx.clearRect(0, 0, width, height);

        const total = beams.length;
        for (let i = 0; i < total; i++) {
            const beam = beams[i];
            if (dt > 0) {
                beam.y -= beam.speed;
                beam.pulse += beam.pulseSpeed;
                if (beam.y + beam.length < -100) {
                    resetBeam(beam, i, total);
                }
            }
            drawBeam(beam);
        }
    }

    let lastTime = performance.now();

    function render(now) {
        if (isMobile() || !isIntersecting) {
            animationFrameId = null;
            return;
        }
        const dt = Math.min((now - lastTime) / 1000, 0.05);
        lastTime = now;
        paintFrame(dt);
        animationFrameId = requestAnimationFrame(render);
    }

    function startLoop() {
        if (animationFrameId || prefersReducedMotion) return;
        lastTime = performance.now();
        animationFrameId = requestAnimationFrame(render);
    }

    // Hemat CPU/GPU: animasi total berhenti saat section ini tidak terlihat di layar
    if (window.IntersectionObserver) {
        new IntersectionObserver((entries) => {
            isIntersecting = entries[0].isIntersecting;
            if (isIntersecting) startLoop();
        }, { rootMargin: '300px 0px' }).observe(root);
    }

    if (prefersReducedMotion) {
        paintFrame(0);
    } else {
        startLoop();
    }

    window.addEventListener('beforeunload', () => {
        if (animationFrameId) cancelAnimationFrame(animationFrameId);
        window.removeEventListener('resize', handleResize);
    });
})();
</script>
