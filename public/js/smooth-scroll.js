/**
 * Smooth Scroll — momentum scrolling ala demo resmi GSAP "Smooth Scrolling"
 * (https://demos.gsap.com/demo/smooth-scrolling/), pakai plugin ScrollSmoother.
 *
 * ScrollSmoother tetap pakai native scroll browser (window.scrollY, window.scrollTo,
 * event 'scroll' semua tetap jalan normal) — cuma menambah efek "lag" halus saat
 * konten mengejar posisi scroll asli. Elemen position:fixed (navbar, tombol WhatsApp,
 * FAB back-to-top, modal) SENGAJA diletakkan di luar #smooth-wrapper supaya tetap
 * nempel ke viewport, bukan ikut ter-transform bareng konten.
 */
(function () {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined' || typeof ScrollSmoother === 'undefined') {
        return;
    }

    var wrapper = document.getElementById('smooth-wrapper');
    var content = document.getElementById('smooth-content');
    if (!wrapper || !content) {
        return;
    }

    gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    window.smoother = ScrollSmoother.create({
        wrapper: '#smooth-wrapper',
        content: '#smooth-content',
        // Reduced-motion: matikan efek "lag" tapi tetap pertahankan struktur wrapper
        // supaya layout tidak berubah — praktis jadi native scroll biasa.
        smooth: prefersReducedMotion ? 0 : 1,
        smoothTouch: prefersReducedMotion ? 0 : 0.1,
        effects: false,
        normalizeScroll: false,
        ignoreMobileResize: true,
    });
})();
