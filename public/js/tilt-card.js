/**
 * 3D Tilt Card — High-Performance Physics Engine (Silky Smooth Lerp)
 * Vanilla JavaScript (Zero External Dependencies)
 * Implements smooth linear interpolation (LERP), subpixel damping, and mouse tracking
 */
(function () {
  'use strict';

  function init3DTiltCards() {
    const cards = document.querySelectorAll('.tilt-card-3d, .custom-card');
    if (!cards.length) return;

    // Disable 3D tilt calculations on mobile/touch screens to preserve 60-120fps touch scrolling
    const isTouch = ('ontouchstart' in window || navigator.maxTouchPoints > 0) && window.innerWidth < 768;
    if (isTouch) return;

    cards.forEach((card) => {
      if (card.dataset.tiltActive === 'true') return;
      card.dataset.tiltActive = 'true';

      const maxTilt = parseFloat(card.dataset.maxTilt) || 12; // Maximum tilt angle in degrees
      const maxTranslateZ = parseFloat(card.dataset.translateZ) || 16; // Lift in px
      const lerpSpeed = 0.095; // Damping interpolation speed (0.08–0.1 = ultra silky smooth)

      let isHovered = false;
      let targetX = 0;
      let targetY = 0;
      let targetZ = 0;
      let targetGlareX = 50;
      let targetGlareY = 50;
      let targetGlareOpacity = 0;

      let currentX = 0;
      let currentY = 0;
      let currentZ = 0;
      let currentGlareX = 50;
      let currentGlareY = 50;
      let currentGlareOpacity = 0;

      let rafId = null;
      let cardRect = null;

      function lerp(start, end, factor) {
        return start + (end - start) * factor;
      }

      function updatePhysicsLoop() {
        currentX = lerp(currentX, targetX, lerpSpeed);
        currentY = lerp(currentY, targetY, lerpSpeed);
        currentZ = lerp(currentZ, targetZ, lerpSpeed);
        currentGlareX = lerp(currentGlareX, targetGlareX, lerpSpeed * 1.2);
        currentGlareY = lerp(currentGlareY, targetGlareY, lerpSpeed * 1.2);
        currentGlareOpacity = lerp(currentGlareOpacity, targetGlareOpacity, 0.12);

        // Apply hardware-accelerated 3D transform directly
        card.style.transform = `perspective(1200px) rotateX(${currentX.toFixed(3)}deg) rotateY(${currentY.toFixed(3)}deg) translateZ(${currentZ.toFixed(2)}px)`;
        card.style.setProperty('--glare-x', `${currentGlareX.toFixed(2)}%`);
        card.style.setProperty('--glare-y', `${currentGlareY.toFixed(2)}%`);
        card.style.setProperty('--glare-opacity', currentGlareOpacity.toFixed(3));

        // Determine if movement has completely settled
        const velocity = Math.abs(currentX - targetX) +
                         Math.abs(currentY - targetY) +
                         Math.abs(currentZ - targetZ) +
                         Math.abs(currentGlareOpacity - targetGlareOpacity);

        if (isHovered || velocity > 0.005) {
          rafId = requestAnimationFrame(updatePhysicsLoop);
        } else {
          // Clean settlement to neutral
          card.style.transform = '';
          card.style.removeProperty('--glare-opacity');
          rafId = null;
        }
      }

      function startPhysicsLoop() {
        if (!rafId) {
          rafId = requestAnimationFrame(updatePhysicsLoop);
        }
      }

      function onMouseEnter(e) {
        isHovered = true;
        cardRect = card.getBoundingClientRect();
        targetZ = maxTranslateZ;
        targetGlareOpacity = 1;
        startPhysicsLoop();
      }

      function onMouseMove(e) {
        if (!cardRect) {
          cardRect = card.getBoundingClientRect();
        }

        const x = e.clientX - cardRect.left;
        const y = e.clientY - cardRect.top;

        // Bounded coordinates
        const clampedX = Math.max(0, Math.min(x, cardRect.width));
        const clampedY = Math.max(0, Math.min(y, cardRect.height));

        const centerX = cardRect.width / 2;
        const centerY = cardRect.height / 2;

        targetX = ((clampedY - centerY) / centerY) * -maxTilt;
        targetY = ((clampedX - centerX) / centerX) * maxTilt;
        targetZ = maxTranslateZ;

        targetGlareX = (clampedX / cardRect.width) * 100;
        targetGlareY = (clampedY / cardRect.height) * 100;
        targetGlareOpacity = 1;

        startPhysicsLoop();
      }

      function onMouseLeave() {
        isHovered = false;
        cardRect = null;
        targetX = 0;
        targetY = 0;
        targetZ = 0;
        targetGlareOpacity = 0;
        startPhysicsLoop();
      }

      card.addEventListener('mouseenter', onMouseEnter, { passive: true });
      card.addEventListener('mousemove', onMouseMove, { passive: true });
      card.addEventListener('mouseleave', onMouseLeave, { passive: true });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init3DTiltCards);
  } else {
    init3DTiltCards();
  }

  window.init3DTiltCards = init3DTiltCards;
})();
