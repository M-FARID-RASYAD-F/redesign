/**
 * Bidirectional Cubic-Bezier Scroll Reveal Engine
 * Kompatibel dengan GSAP ScrollSmoother, ScrollTrigger, dan native fallback.
 * - Scroll ke bawah: Masuk meluncur dari bawah (translateY: 32px -> 0)
 * - Scroll ke atas: Masuk meluncur dari atas (translateY: -32px -> 0)
 * - Keluar layar: Reset posisi sehingga animasi terulang selamanya (forever)
 */
(function () {
    'use strict';

    function initReveal() {
        const elements = document.querySelectorAll('.reveal');
        if (!elements.length) return;

        // Mobile screens: Langsung tampilkan semua komponen tanpa delay/fade
        // agar komponen tidak hilang saat di-scroll pada layar kecil
        const isMobile = window.innerWidth <= 768;
        if (isMobile) {
            elements.forEach((el) => {
                el.classList.remove('reveal-reverse');
                el.classList.add('visible');
            });
            return;
        }

        // 1. Prioritas Utama: Integrasi GSAP ScrollTrigger (Sempurna dengan ScrollSmoother)
        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            elements.forEach((el) => {
                ScrollTrigger.create({
                    trigger: el,
                    start: 'top 90%',
                    // Masuk saat scroll ke bawah — sekali terlihat, tetap terlihat
                    onEnter: () => {
                        el.classList.remove('reveal-reverse');
                        void el.offsetWidth;
                        el.classList.add('visible');
                    },
                    // Masuk kembali saat scroll ke atas
                    onEnterBack: () => {
                        el.classList.remove('reveal-reverse');
                        void el.offsetWidth;
                        el.classList.add('visible');
                    },
                });
            });

            // Langsung munculkan elemen yang sudah berada di viewport saat halaman pertama dibuka
            ScrollTrigger.refresh();
            return;
        }

        // 2. Fallback: IntersectionObserver jika GSAP tidak tersedia
        if ('IntersectionObserver' in window) {
            const obs = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    const el = entry.target;
                    if (entry.isIntersecting) {
                        el.classList.remove('reveal-reverse');
                        el.classList.add('visible');
                        obs.unobserve(el); // Sekali tampil, pertahankan tetap terlihat
                    }
                });
            }, {
                threshold: 0.05,
                rootMargin: '0px 0px 40px 0px'
            });

            elements.forEach((el) => obs.observe(el));
            return;
        }

        // 3. Fallback browser lawas: Langsung tampilkan
        elements.forEach((el) => el.classList.add('visible'));
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initReveal();
            setTimeout(initReveal, 80);
        });
    } else {
        initReveal();
        setTimeout(initReveal, 80);
    }

    window.addEventListener('load', () => {
        initReveal();
        if (typeof ScrollTrigger !== 'undefined') {
            ScrollTrigger.refresh();
        }
    });

    // Re-check saat resize window (misal rotasi smartphone atau DevTools toggle)
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.reveal').forEach(el => {
                el.classList.remove('reveal-reverse');
                el.classList.add('visible');
            });
        }
    });

    window.refreshScrollReveal = initReveal;
})();
