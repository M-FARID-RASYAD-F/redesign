{{--
    resources/views/components/constellation-grid.blade.php

    Background grid ambient — titik-titik halus yang bergeser lembut menjauhi kursor,
    warnanya mengikuti tema situs (dark navy/cyan atau light/merah) lewat CSS variable
    di .content-area-constellation, bukan warna yang di-hardcode terpisah di JS.
--}}

<div
    {{ $attributes->merge(['class' => 'relative w-full overflow-hidden select-none content-area-constellation']) }}
>
    <canvas id="constellation-canvas" class="absolute inset-0 block w-full h-full pointer-events-none" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1; pointer-events: none;"></canvas>

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

    const ctx = canvas.getContext('2d', { alpha: false });
    if (!ctx) return;

    let animationFrameId;
    let width = 0;
    let height = 0;

    // ── Warna mengikuti tema situs (CSS variable di .content-area-constellation) ──
    let colors = { bg: '#020617', line: '148, 163, 184', node: '226, 232, 240', accent: '0, 180, 216' };

    function readThemeColors() {
        const cs = getComputedStyle(root);
        colors = {
            bg: (cs.getPropertyValue('--constellation-bg') || colors.bg).trim(),
            line: (cs.getPropertyValue('--constellation-line-rgb') || colors.line).trim(),
            node: (cs.getPropertyValue('--constellation-node-rgb') || colors.node).trim(),
            accent: (cs.getPropertyValue('--constellation-accent-rgb') || colors.accent).trim(),
        };
    }
    readThemeColors();

    window.addEventListener('theme-changed', readThemeColors);
    new MutationObserver(readThemeColors)
        .observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

    // Posisi kursor halus (tidak ada lagi kecepatan/shockwave — cuma tarikan lembut menjauh)
    const mouse = { x: -1000, y: -1000, radius: 130 };

    let nodes = [];

    function initNodes() {
        nodes = [];
        const spacing = 66; // Grid lega — ambient, bukan pusat perhatian
        const cols = Math.ceil(width / spacing) + 1;
        const rows = Math.ceil(height / spacing) + 1;

        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {
                const x = i * spacing;
                const y = j * spacing;
                nodes.push({
                    x, y,
                    vx: 0, vy: 0,
                    baseX: x, baseY: y,
                    radius: Math.random() * 1.1 + 1.1,
                    pulse: Math.random() * Math.PI * 2,
                });
            }
        }
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
        initNodes();
        if (prefersReducedMotion) drawStatic();
    }

    function handleMouseMove(e) {
        const rect = canvas.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
    }

    function handleMouseLeave() {
        mouse.x = -1000;
        mouse.y = -1000;
    }

    handleResize();
    window.addEventListener('resize', handleResize);
    window.addEventListener('load', handleResize);
    document.addEventListener('DOMContentLoaded', handleResize);

    if (!prefersReducedMotion) {
        window.addEventListener('mousemove', handleMouseMove);
        window.addEventListener('mouseleave', handleMouseLeave);
    }

    // Re-check ukuran setelah gambar/font selesai load
    setTimeout(handleResize, 200);
    setTimeout(handleResize, 800);
    setTimeout(handleResize, 1800);

    if (window.ResizeObserver) {
        const slotWrapper = root.querySelector('.constellation-slot-wrapper') || root;
        new ResizeObserver(() => handleResize()).observe(slotWrapper);
    }

    // Fisika lembut: spring-damping ringan, tanpa lonjakan kecepatan kursor
    const SPRING_K = 22;
    const DAMPING = 0.88;
    const MAX_CONN_DIST = 64;
    const MAX_CONN_DIST_SQ = MAX_CONN_DIST * MAX_CONN_DIST;

    function paintFrame(dt) {
        ctx.fillStyle = colors.bg;
        ctx.fillRect(0, 0, width, height);

        const canvasTop = -canvas.getBoundingClientRect().top;
        const viewTop = Math.max(0, canvasTop - 250);
        const viewBottom = canvasTop + window.innerHeight + 250;

        for (let i = 0; i < nodes.length; i++) {
            const n = nodes[i];
            if (n.baseY < viewTop - 100 || n.baseY > viewBottom + 100) continue;

            n.pulse += dt * 1.6;

            if (dt > 0) {
                const dx = mouse.x - n.x;
                const dy = mouse.y - n.y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < mouse.radius && dist > 0) {
                    // Dorongan halus menjauhi kursor — bukan ledakan/shockwave
                    const power = 1 - dist / mouse.radius;
                    const force = power * 180;
                    const angle = Math.atan2(dy, dx);
                    n.vx -= Math.cos(angle) * force * dt;
                    n.vy -= Math.sin(angle) * force * dt;
                }

                n.vx += (n.baseX - n.x) * SPRING_K * dt;
                n.vy += (n.baseY - n.y) * SPRING_K * dt;
                n.vx *= DAMPING;
                n.vy *= DAMPING;
                n.x += n.vx * dt * 60;
                n.y += n.vy * dt * 60;
            }
        }

        // Garis koneksi — tipis & redup, sekadar tekstur ambient
        const lineAlphaFactor = 0.12;
        for (let i = 0; i < nodes.length; i++) {
            const n = nodes[i];
            if (n.baseY < viewTop || n.baseY > viewBottom) continue;

            for (let j = i + 1; j < nodes.length; j++) {
                const n2 = nodes[j];
                if (Math.abs(n.y - n2.y) > MAX_CONN_DIST) continue;

                const ndx = n.x - n2.x;
                const ndy = n.y - n2.y;
                const distSq = ndx * ndx + ndy * ndy;

                if (distSq < MAX_CONN_DIST_SQ) {
                    const nDist = Math.sqrt(distSq);
                    const alpha = (1 - nDist / MAX_CONN_DIST) * lineAlphaFactor;

                    ctx.strokeStyle = `rgba(${colors.line}, ${alpha})`;
                    ctx.lineWidth = 0.7;
                    ctx.beginPath();
                    ctx.moveTo(n.x, n.y);
                    ctx.lineTo(n2.x, n2.y);
                    ctx.stroke();
                }
            }
        }

        // Titik node — redup, sedikit menyala lembut saat dekat kursor (tanpa ring/label)
        for (let i = 0; i < nodes.length; i++) {
            const n = nodes[i];
            if (n.baseY < viewTop || n.baseY > viewBottom) continue;

            const dx = mouse.x - n.x;
            const dy = mouse.y - n.y;
            const isNear = Math.sqrt(dx * dx + dy * dy) < mouse.radius;

            const baseAlpha = isNear ? 0.6 : 0.22 + Math.sin(n.pulse) * 0.06;

            ctx.fillStyle = isNear
                ? `rgba(${colors.accent}, ${baseAlpha})`
                : `rgba(${colors.node}, ${baseAlpha})`;

            const r = isNear ? n.radius * 1.5 : n.radius;
            ctx.beginPath();
            ctx.arc(n.x, n.y, Math.max(0.7, r), 0, Math.PI * 2);
            ctx.fill();
        }
    }

    function drawStatic() {
        paintFrame(0);
    }

    let lastTime = performance.now();

    function render(now) {
        if (isMobile()) {
            animationFrameId = requestAnimationFrame(render);
            return;
        }
        const dt = Math.min((now - lastTime) / 1000, 0.05);
        lastTime = now;
        paintFrame(dt);
        animationFrameId = requestAnimationFrame(render);
    }

    if (prefersReducedMotion) {
        drawStatic();
    } else {
        animationFrameId = requestAnimationFrame(render);
    }

    window.addEventListener('beforeunload', () => {
        cancelAnimationFrame(animationFrameId);
        window.removeEventListener('resize', handleResize);
        window.removeEventListener('mousemove', handleMouseMove);
        window.removeEventListener('mouseleave', handleMouseLeave);
    });
})();
</script>
