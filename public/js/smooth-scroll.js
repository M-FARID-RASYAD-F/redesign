/**
 * Smooth Scroll — momentum scrolling ala demo resmi GSAP "Smooth Scrolling"
 * (https://demos.gsap.com/demo/smooth-scrolling/), pakai plugin ScrollSmoother.
 *
 * ScrollSmoother tetap pakai native scroll browser (window.scrollY, window.scrollTo,
 * event 'scroll' semua tetap jalan normal) — cuma menambah efek "lag" halus saat
 * konten mengejar posisi scroll asli. Elemen position:fixed (navbar, tombol WhatsApp,
 * FAB back-to-top, modal) SENGAJA diletakkan di luar #smooth-wrapper supaya tetap
 * nempel ke viewport, bukan ikut ter-transform bareng konten.
 *
 * FIX (2026-09-13): ScrollSmoother mengunci tinggi #smooth-wrapper ke nilai desktop
 * saat DevTools switch ke mobile — karena ignoreMobileResize:true mencegah recalculate.
 * Solusi: tambah debounced resize handler yang memanggil smoother.kill() + re-init
 * saat viewport width melewati breakpoint desktop/mobile (768px), dan langsung
 * disable ScrollSmoother di mobile agar tidak lock height sama sekali.
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
    var MOBILE_BREAKPOINT = 768;

    function isMobile() {
        return window.innerWidth <= MOBILE_BREAKPOINT;
    }

    function createSmoother() {
        // Jangan inisialisasi ScrollSmoother di mobile — biarkan native scroll biasa
        // agar tidak ada height locking yang menyebabkan ruang kosong
        if (isMobile()) return null;

        return ScrollSmoother.create({
            wrapper: '#smooth-wrapper',
            content: '#smooth-content',
            // Reduced-motion: matikan efek "lag" tapi tetap pertahankan struktur wrapper
            smooth: prefersReducedMotion ? 0 : 1,
            smoothTouch: 0,          // Matikan di touch — native scroll lebih baik
            effects: false,
            normalizeScroll: false,
            // FIX: ganti ignoreMobileResize:true → false agar height di-recalculate saat resize
            ignoreMobileResize: false,
        });
    }

    window.smoother = createSmoother();

    // ── Debounced resize handler ──
    // Saat DevTools switch desktop↔mobile, kill smoother lama dan buat baru
    // (atau matikan total jika sekarang mobile) supaya height tidak ter-lock ke nilai lama.
    var resizeTimer = null;
    var lastIsMobile = isMobile();

    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            var nowMobile = isMobile();

            if (nowMobile === lastIsMobile) {
                // Ukuran berubah tapi masih dalam mode yang sama — cukup refresh
                if (window.smoother) {
                    ScrollTrigger.refresh();
                }
                return;
            }

            // Mode berubah (desktop→mobile atau sebaliknya)
            lastIsMobile = nowMobile;

            // Kill smoother lama beserta semua ScrollTrigger-nya
            if (window.smoother) {
                window.smoother.kill();
                window.smoother = null;
            }
            document.body.style.removeProperty('height');
            ScrollTrigger.refresh();

            // Buat ulang hanya jika sekarang desktop
            if (!nowMobile) {
                window.smoother = createSmoother();
            }
        }, 150); // debounce 150ms — cukup untuk tunggu reflow DevTools selesai
    });
})();
