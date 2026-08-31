{{--
    resources/views/components/constellation-grid.blade.php

    Komponen Background Animasi Grid Interaktif Constellation (Vanilla JS Canvas)
    Berdasarkan spesifikasi bck.md
--}}

<div
    {{ $attributes->merge(['class' => 'relative w-full overflow-hidden select-none bg-slate-950 content-area-constellation']) }}
>
    <canvas id="constellation-canvas" class="absolute inset-0 block w-full h-full pointer-events-none" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></canvas>

    @if(isset($slot) && !empty(trim($slot)))
        <div class="relative w-full" style="position: relative; z-index: 10;">
            {{ $slot }}
        </div>
    @else
        {{-- Overlay judul default --}}
        <div class="relative z-10 flex h-full min-h-[400px] flex-col items-center justify-center text-center px-4 pointer-events-none mix-blend-difference text-white">
            <h1 class="font-mono text-6xl md:text-9xl font-black tracking-tighter uppercase leading-none">
                Constellation
            </h1>
            <p class="mt-4 font-mono text-xs md:text-sm max-w-lg opacity-70">
                High-velocity dynamic mesh. Sweep your cursor quickly across the grid to unleash kinetic shockwaves.
            </p>
        </div>
    @endif
</div>

<script>
(function () {
    const canvas = document.getElementById('constellation-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d', { alpha: false });
    if (!ctx) return;

    let animationFrameId;
    let width = 0;
    let height = 0;

    // Deteksi mode tema dari data-theme dan preferensi sistem
    function checkIsLight() {
        return document.documentElement.getAttribute('data-theme') === 'light';
    }
    let isLightMode = checkIsLight();
    let isDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    window.addEventListener('theme-changed', (e) => {
        isLightMode = e.detail?.theme === 'light';
    });

    const themeObserver = new MutationObserver(() => {
        isLightMode = checkIsLight();
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });

    const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');
    if (darkModeQuery && darkModeQuery.addEventListener) {
        darkModeQuery.addEventListener('change', (e) => {
            isDarkMode = e.matches;
        });
    }

    // Mouse velocity & inertial tracking
    const mouse = {
        x: -1000,
        y: -1000,
        prevX: -1000,
        prevY: -1000,
        vx: 0,
        vy: 0,
        radius: 240,
    };

    let nodes = [];

    function initNodes() {
        nodes = [];
        const spacing = 58; // Kerapatan grid
        const cols = Math.ceil(width / spacing) + 1;
        const rows = Math.ceil(height / spacing) + 1;

        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {
                const x = i * spacing;
                const y = j * spacing;
                nodes.push({
                    x,
                    y,
                    vx: 0,
                    vy: 0,
                    baseX: x,
                    baseY: y,
                    radius: Math.random() * 1.4 + 1.4,
                    label: `${(i * 7).toString(16).toUpperCase()}:${(j * 11).toString(16).toUpperCase()}`,
                    pulse: Math.random() * Math.PI * 2,
                });
            }
        }
    }

    function handleResize() {
        const dpr = Math.min(window.devicePixelRatio || 1, 2);
        const parent = canvas.parentElement || document.body;
        width = parent.clientWidth || window.innerWidth;
        // Pastikan tinggi canvas menutupi seluruh tinggi konten scroll parent
        height = Math.max(parent.clientHeight, parent.scrollHeight, parent.offsetHeight || 0, window.innerHeight);
        
        canvas.width = width * dpr;
        canvas.height = height * dpr;
        canvas.style.width = `${width}px`;
        canvas.style.height = `${height}px`;
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.scale(dpr, dpr);
        initNodes();
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
    window.addEventListener('mousemove', handleMouseMove);
    window.addEventListener('mouseleave', handleMouseLeave);

    // Re-check size after images / fonts load
    setTimeout(handleResize, 200);
    setTimeout(handleResize, 800);
    setTimeout(handleResize, 1800);

    if (window.ResizeObserver && canvas.parentElement) {
        const ro = new ResizeObserver(() => handleResize());
        ro.observe(canvas.parentElement);
    }

    let lastTime = performance.now();

    function render(now) {
        const dt = Math.min((now - lastTime) / 1000, 0.05);
        lastTime = now;

        // Kecepatan mouse
        mouse.vx = (mouse.x - mouse.prevX) / (dt * 1000 || 1);
        mouse.vy = (mouse.y - mouse.prevY) / (dt * 1000 || 1);
        mouse.prevX = mouse.x;
        mouse.prevY = mouse.y;

        const speed = Math.sqrt(mouse.vx * mouse.vx + mouse.vy * mouse.vy);

        // Palet warna adaptif Dark Mode vs White Mode
        const bgColor = isLightMode ? '#ffffff' : (isDarkMode ? '#030407' : '#030712');
        const nodeColor = isLightMode ? '229, 36, 68' : (isDarkMode ? '255, 255, 255' : '226, 232, 240');
        const accentColor = isLightMode ? '229, 36, 68' : (isDarkMode ? '56, 189, 248' : '0, 180, 216');

        ctx.fillStyle = bgColor;
        ctx.fillRect(0, 0, width, height);

        // Physics: Spring-Mass-Damping
        const SPRING_K = 18;
        const DAMPING = 0.82;

        // Viewport bounds untuk culling (hanya proses node yang terlihat di layar agar 60fps konstan)
        const rect = canvas.getBoundingClientRect();
        const canvasScrollY = -rect.top;
        const viewTop = Math.max(0, canvasScrollY - 250);
        const viewBottom = canvasScrollY + window.innerHeight + 250;

        for (let i = 0; i < nodes.length; i++) {
            const n = nodes[i];
            
            // Skip node yang jauh di luar viewport saat ini
            if (n.baseY < viewTop - 100 || n.baseY > viewBottom + 100) continue;

            n.pulse += dt * 3;

            const dx = mouse.x - n.x;
            const dy = mouse.y - n.y;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < mouse.radius && dist > 0) {
                const power = (1 - dist / mouse.radius);
                const force = power * (1600 + speed * 160);
                const angle = Math.atan2(dy, dx);

                n.vx -= Math.cos(angle) * force * dt;
                n.vy -= Math.sin(angle) * force * dt;
            }

            const homeDx = n.baseX - n.x;
            const homeDy = n.baseY - n.y;

            n.vx += homeDx * SPRING_K * dt;
            n.vy += homeDy * SPRING_K * dt;

            n.vx *= DAMPING;
            n.vy *= DAMPING;

            n.x += n.vx * dt * 60;
            n.y += n.vy * dt * 60;
        }

        // Garis koneksi antar node (Visible & Sharp)
        const MAX_CONN_DIST = 75;
        const MAX_CONN_DIST_SQ = MAX_CONN_DIST * MAX_CONN_DIST;
        const lineBaseAlphaFactor = isLightMode ? 0.38 : 0.20;

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
                    const alpha = (1 - nDist / MAX_CONN_DIST) * lineBaseAlphaFactor;

                    ctx.strokeStyle = `rgba(${nodeColor}, ${alpha})`;
                    ctx.lineWidth = isLightMode ? 0.9 : 0.7;
                    ctx.beginPath();
                    ctx.moveTo(n.x, n.y);
                    ctx.lineTo(n2.x, n2.y);
                    ctx.stroke();
                }
            }
        }

        // Render titik node + highlight interaktif (High Contrast & Visible)
        for (let i = 0; i < nodes.length; i++) {
            const n = nodes[i];
            if (n.baseY < viewTop || n.baseY > viewBottom) continue;

            const dx = mouse.x - n.x;
            const dy = mouse.y - n.y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            const isNear = dist < mouse.radius;

            const baseAlpha = isLightMode
                ? (isNear ? 1.0 : 0.65 + Math.sin(n.pulse) * 0.15)
                : (isNear ? 0.95 : 0.35 + Math.sin(n.pulse) * 0.1);

            ctx.fillStyle = isNear
                ? `rgba(${accentColor}, ${baseAlpha})`
                : `rgba(${nodeColor}, ${baseAlpha})`;

            const currentRadius = isNear
                ? n.radius * 2.2
                : n.radius + Math.sin(n.pulse) * 0.3;

            ctx.beginPath();
            ctx.arc(n.x, n.y, Math.max(0.8, currentRadius), 0, Math.PI * 2);
            ctx.fill();

            if (dist < 90) {
                const pulseRing = ((n.pulse * 20) % 30) + 4;
                const ringAlpha = isLightMode
                    ? (1 - pulseRing / 34) * 0.7
                    : (1 - pulseRing / 34) * 0.45;

                ctx.strokeStyle = `rgba(${accentColor}, ${ringAlpha})`;
                ctx.lineWidth = isLightMode ? 1.4 : 1;
                ctx.beginPath();
                ctx.arc(n.x, n.y, pulseRing, 0, Math.PI * 2);
                ctx.stroke();

                ctx.font = '8px ui-monospace, SFMono-Regular, Consolas, monospace';
                ctx.fillStyle = `rgba(${accentColor}, ${isLightMode ? 0.95 : 0.85})`;
                ctx.fillText(n.label, n.x + 10, n.y - 10);
            }
        }

        animationFrameId = requestAnimationFrame(render);
    }

    animationFrameId = requestAnimationFrame(render);

    // Cleanup kalau elemen dilepas dari DOM
    window.addEventListener('beforeunload', () => {
        cancelAnimationFrame(animationFrameId);
        window.removeEventListener('resize', handleResize);
        window.removeEventListener('mousemove', handleMouseMove);
        window.removeEventListener('mouseleave', handleMouseLeave);
    });
})();
</script>
