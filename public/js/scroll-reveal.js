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

        // 1. Prioritas Utama: Integrasi GSAP ScrollTrigger (Sempurna dengan ScrollSmoother)
        if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            elements.forEach((el) => {
                ScrollTrigger.create({
                    trigger: el,
                    start: 'top 88%',
                    end: 'bottom 12%',
                    // Masuk saat scroll ke bawah
                    onEnter: () => {
                        el.classList.remove('reveal-reverse');
                        void el.offsetWidth;
                        el.classList.add('visible');
                    },
                    // Keluar saat scroll ke bawah (lewat atas)
                    onLeave: () => {
                        el.classList.remove('visible');
                        el.classList.add('reveal-reverse');
                    },
                    // Masuk kembali saat scroll ke atas (REVERSE)
                    onEnterBack: () => {
                        el.classList.add('reveal-reverse');
                        void el.offsetWidth;
                        el.classList.add('visible');
                    },
                    // Keluar saat scroll ke atas (lewat bawah)
                    onLeaveBack: () => {
                        el.classList.remove('visible');
                        el.classList.remove('reveal-reverse');
                    },
                });
            });

            // Langsung munculkan elemen yang sudah berada di viewport saat halaman pertama dibuka
            ScrollTrigger.refresh();
            return;
        }

        // 2. Fallback: IntersectionObserver jika GSAP tidak tersedia
        if ('IntersectionObserver' in window) {
            let lastY = window.pageYOffset || document.documentElement.scrollTop;
            let currentDir = 'down';

            window.addEventListener('scroll', () => {
                const y = window.pageYOffset || document.documentElement.scrollTop;
                if (Math.abs(y - lastY) > 2) {
                    currentDir = y > lastY ? 'down' : 'up';
                    lastY = y <= 0 ? 0 : y;
                }
            }, { passive: true });

            const obs = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    const el = entry.target;
                    if (entry.isIntersecting) {
                        if (currentDir === 'up') {
                            el.classList.add('reveal-reverse');
                        } else {
                            el.classList.remove('reveal-reverse');
                        }
                        void el.offsetWidth;
                        el.classList.add('visible');
                    } else {
                        el.classList.remove('visible');
                        if (entry.boundingClientRect.top < 0) {
                            el.classList.add('reveal-reverse');
                        } else {
                            el.classList.remove('reveal-reverse');
                        }
                    }
                });
            }, {
                threshold: 0.08,
                rootMargin: '0px 0px -20px 0px'
            });

            elements.forEach((el) => obs.observe(el));
            return;
        }

        // 3. Fallback browser lawas: Langsung tampilkan
        elements.forEach((el) => el.classList.add('visible'));
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(initReveal, 60);
        });
    } else {
        setTimeout(initReveal, 60);
    }

    window.refreshScrollReveal = initReveal;
})();
