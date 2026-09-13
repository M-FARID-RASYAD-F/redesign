/**
 * Nav Island — kapsul menu mobile yang melebar dengan orkestrasi GSAP easeReverse.
 * Terinspirasi dari demo resmi GSAP "Orchestrated easeReverse".
 * Tiap tween di timeline bisa punya easing sendiri untuk arah reverse (menutup),
 * independen dari easing saat membuka — jadi buka terasa bouncy, tutup terasa halus.
 */
(function () {
    const island = document.getElementById('navIsland');
    const toggleBtn = document.getElementById('navToggle');
    const panel = document.getElementById('navMobilePanel');
    const backdrop = document.getElementById('navIslandBackdrop');

    if (!island || !toggleBtn || !panel || !backdrop || typeof gsap === 'undefined') {
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const links = panel.querySelectorAll('.nav-mobile-link, .nav-mobile-cta, .nav-mobile-theme-btn');

    let isOpen = false;
    let tl;

    function buildTimeline() {
        tl && tl.revert();

        if (prefersReducedMotion) {
            tl = gsap.timeline({ paused: true })
                .set(panel, { pointerEvents: 'auto', clipPath: 'circle(150% at 100% 0%)' })
                .to(panel, { autoAlpha: 1, duration: 0.01 }, 0)
                .to(backdrop, { autoAlpha: 1, duration: 0.01 }, 0);
            return;
        }

        tl = gsap.timeline({ paused: true })
            .set(panel, { pointerEvents: 'auto' })
            // Kapsul toggle "melebar" — feedback bouncy saat buka, susut cepat & halus saat tutup
            .to(toggleBtn, { scale: 1.08, duration: 0.4, ease: 'back.out(2)', easeReverse: 'power3.out' }, 0)
            // Bar hamburger morph jadi X (garis atas & bawah), bar tengah memudar
            .to('.island-bar-mid', { opacity: 0, duration: 0.15, ease: 'power2.in', easeReverse: true }, 0)
            .to('.island-bar-top', { attr: { x1: 3, y1: 3, x2: 13, y2: 13 }, duration: 0.32, ease: 'power3.inOut', easeReverse: 'power2.in' }, 0.02)
            .to('.island-bar-bot', { attr: { x1: 13, y1: 3, x2: 3, y2: 11 }, duration: 0.32, ease: 'power3.inOut', easeReverse: 'power2.in' }, 0.02)
            // Backdrop tipis di belakang panel
            .to(backdrop, { autoAlpha: 1, duration: 0.3, ease: 'power2.out', easeReverse: 'power1.in' }, 0)
            // Panel benar-benar "melebar" keluar dari sudut tombol island (clip-path circle reveal),
            // bukan sekadar fade/scale — buka terasa expo yang meluncur, tutup menyusut mulus & cepat
            .fromTo(panel,
                { autoAlpha: 0, clipPath: 'circle(0% at 100% 0%)' },
                { autoAlpha: 1, clipPath: 'circle(150% at 100% 0%)', duration: 0.55, ease: 'expo.out', easeReverse: 'power2.inOut' },
                0.04
            )
            // Item menu meluncur masuk dari samping dengan stagger, keluar cepat & rapi (bukan mirror)
            .from(links, { opacity: 0, x: 16, duration: 0.36, ease: 'back.out(1.6)', easeReverse: 'power2.in', stagger: 0.045 }, 0.22);
    }

    function setLinksFocusable(focusable) {
        links.forEach((el) => el.setAttribute('tabindex', focusable ? '0' : '-1'));
    }

    function open() {
        isOpen = true;
        island.classList.add('is-open');
        toggleBtn.setAttribute('aria-expanded', 'true');
        toggleBtn.setAttribute('aria-label', 'Tutup menu navigasi');
        setLinksFocusable(true);
        tl.timeScale(1).play();
    }

    function close() {
        if (!isOpen) return;
        isOpen = false;
        island.classList.remove('is-open');
        toggleBtn.setAttribute('aria-expanded', 'false');
        toggleBtn.setAttribute('aria-label', 'Buka menu navigasi');
        setLinksFocusable(false);
        tl.eventCallback('onReverseComplete', () => gsap.set(panel, { pointerEvents: 'none' }));
        tl.timeScale(1.4).reverse();
    }

    function toggle() {
        isOpen ? close() : open();
    }

    buildTimeline();
    setLinksFocusable(false);

    toggleBtn.addEventListener('click', toggle);
    backdrop.addEventListener('click', close);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen) {
            close();
            toggleBtn.focus();
        }
    });

    // Focus trap sederhana selama panel terbuka
    panel.addEventListener('keydown', (e) => {
        if (!isOpen || e.key !== 'Tab') return;
        const focusable = [...panel.querySelectorAll('[tabindex="0"]')];
        if (!focusable.length) return;
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (e.shiftKey && document.activeElement === first) {
            e.preventDefault();
            last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    });

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(buildTimeline, 200);
    });

    // Dipakai script navbar lain (klik link, navigasi anchor) untuk menutup island
    window.closeNavIsland = close;
})();
