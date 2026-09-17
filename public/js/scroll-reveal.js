/**
 * Bidirectional Cubic-Bezier Scroll Reveal Engine
 * Kompatibel dengan GSAP ScrollSmoother, ScrollTrigger, dan native fallback.
 * - Scroll ke bawah: Masuk meluncur dari bawah (translateY: 32px -> 0)
 * - Scroll ke atas: Masuk meluncur dari atas (translateY: -32px -> 0)
 * - Keluar layar: Reset posisi sehingga animasi terulang selamanya (forever)
 */
(function () {
    'use strict';

    function isMobile() {
        return window.innerWidth <= 768;
    }

    function initReveal() {
        const elements = document.querySelectorAll('.reveal');
        if (!elements.length) return;

        // ══════════════════════════════════════════════════════════
        // KHUSUS TAMPILAN HP (MOBILE <= 768px):
        // Bidirectional Cubic-Bezier Engine untuk Layar HP
        // ══════════════════════════════════════════════════════════
        if (isMobile()) {
            // 1. Prioritas Utama di Mobile: GSAP ScrollTrigger
            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);

                elements.forEach((el) => {
                    ScrollTrigger.create({
                        trigger: el,
                        start: 'top 92%',
                        end: 'bottom top',
                        // Masuk saat scroll ke bawah — transisi cubic-bezier
                        onEnter: () => {
                            el.classList.remove('reveal-reverse');
                            void el.offsetWidth;
                            el.classList.add('visible');
                        },
                        // Keluar saat benar-benar lewat atas layar
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
                        // Keluar saat benar-benar lewat bawah layar
                        onLeaveBack: () => {
                            el.classList.remove('visible');
                            el.classList.remove('reveal-reverse');
                        },
                    });
                });

                ScrollTrigger.refresh();
                return;
            }

            // 2. Fallback di Mobile: IntersectionObserver
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

                const mobileObs = new IntersectionObserver((entries) => {
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
                    threshold: 0.05,
                    rootMargin: '0px 0px -20px 0px'
                });

                elements.forEach((el) => mobileObs.observe(el));
                return;
            }

            // 3. Fallback browser lawas: Langsung tampilkan
            elements.forEach((el) => el.classList.add('visible'));
            return;
        }

        // ══════════════════════════════════════════════════════════
        // KHUSUS TAMPILAN PC (DESKTOP > 768px):
        // 100% Bidirectional Cubic-Bezier Engine Asli (Sebelum Prompt Terakhir)
        // ══════════════════════════════════════════════════════════

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

    // Re-check saat resize window (misal rotasi smartphone atau DevTools toggle ke HP)
    let resizeTimer = null;
    let lastMode = isMobile();

    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            const currentMode = isMobile();
            if (currentMode !== lastMode) {
                lastMode = currentMode;
                initReveal();
            } else if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.refresh();
            }
        }, 120);
    });

    window.refreshScrollReveal = initReveal;
})();
