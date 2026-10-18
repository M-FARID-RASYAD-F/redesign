{{-- resources/views/partials/whatsapp-button.blade.php --}}
@if(!request()->is('admin*'))
<style>
/* ═══════════════════════════════════════════════════════════
   FLOATING WHATSAPP BUTTON (Pojok Kiri Bawah)
   ═══════════════════════════════════════════════════════════ */
.floating-wa-wrapper {
  position: fixed;
  bottom: max(20px, calc(16px + env(safe-area-inset-bottom, 0px)));
  left: max(20px, calc(16px + env(safe-area-inset-left, 0px)));
  z-index: 9999;
  display: flex;
  align-items: center;
  pointer-events: auto;
  font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
}

/* Mobile-first (< 1000px): Bulat 56px */
.floating-wa-btn {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 56px;
  height: 56px;
  min-width: 56px;
  min-height: 56px;
  padding: 0;
  background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
  color: #ffffff !important;
  text-decoration: none !important;
  border-radius: 50%;
  box-shadow: 0 8px 24px -2px rgba(18, 140, 126, 0.45), 0 4px 12px rgba(0, 0, 0, 0.22);
  border: 1.5px solid rgba(255, 255, 255, 0.35);
  transition: transform 0.18s ease, box-shadow 0.2s ease, filter 0.2s ease;
  cursor: pointer;
  user-select: none;
  -webkit-user-select: none;
}

.floating-wa-btn:hover {
  filter: brightness(1.04);
  color: #ffffff !important;
}

.floating-wa-btn:active {
  transform: scale(0.97);
}

.floating-wa-btn:focus-visible {
  outline: 3px solid #38bdf8;
  outline-offset: 3px;
}

.floating-wa-pulse {
  display: none;
}

/* Icon Box */
.floating-wa-icon-box {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  flex-shrink: 0;
}

.floating-wa-icon {
  width: 24px;
  height: 24px;
  fill: #ffffff;
}

.floating-wa-dot {
  display: none;
}

/* Sembunyikan label di mobile (< 1000px) */
.floating-wa-label {
  display: none;
  flex-direction: column;
  line-height: 1.25;
  text-align: left;
}

.floating-wa-title {
  font-size: 0.88rem;
  font-weight: 800;
  color: #ffffff;
  letter-spacing: 0.01em;
}

.floating-wa-sub {
  font-size: 0.72rem;
  font-weight: 600;
  color: #dcfce7;
  opacity: 0.95;
}

.floating-wa-tooltip {
  display: none;
}

/* Desktop (>= 1000px): Bentuk Pil setinggi 56px */
@media (min-width: 1000px) {
  .floating-wa-wrapper {
    bottom: max(24px, calc(20px + env(safe-area-inset-bottom, 0px)));
    left: max(24px, calc(20px + env(safe-area-inset-left, 0px)));
  }

  .floating-wa-btn {
    width: auto;
    height: 56px;
    min-height: 56px;
    padding: 0 20px 0 10px;
    border-radius: 9999px;
    gap: 11px;
  }

  .floating-wa-label {
    display: flex;
  }
}

@media (prefers-reduced-motion: reduce) {
  .floating-wa-btn {
    transition: none !important;
  }
}
</style>

<div class="floating-wa-wrapper" id="floatingWaWrapper">
    <!-- Tombol WhatsApp Mengambang (Pojok Kiri Bawah) -->
    <a href="{{ config('school.whatsapp_url', 'https://wa.me/6281270001920') }}?text=Halo%20Admin%20PKBM%20Tahfizh%20At-Tamam,%20saya%20ingin%20konsultasi%20pendaftaran" 
       target="_blank" 
       rel="noopener noreferrer" 
       class="floating-wa-btn" 
       id="floatingWaBtn"
       aria-label="WhatsApp, online, hubungi kami"
       title="Chat WhatsApp resmi PKBM Tahfizh Attamam">
        
        <!-- Ikon WhatsApp -->
        <span class="floating-wa-icon-box" aria-hidden="true">
            <svg class="floating-wa-icon" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.42 0-2.82-.37-4.06-1.07l-.29-.17-3.12.82.83-3.04-.19-.3a8.19 8.19 0 0 1-1.26-4.47c0-4.54 3.7-8.24 8.24-8.24m4.53 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.03-1.25-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.38-.44.13-.15.17-.25.25-.42.08-.17.04-.32-.02-.45-.06-.13-.56-1.35-.77-1.85-.2-.48-.4-.42-.56-.43h-.47c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.78 2.72 4.31 3.81.6.26 1.07.42 1.44.53.61.2 1.16.17 1.6.1.49-.07 1.47-.6 1.68-1.18.21-.59.21-1.09.15-1.19-.06-.09-.22-.16-.47-.28z"/>
            </svg>
        </span>

        <!-- Label Teks WhatsApp -->
        <span class="floating-wa-label">
            <span class="floating-wa-title">WhatsApp</span>
            <span class="floating-wa-sub">Online, hubungi kami</span>
        </span>
    </a>
</div>
@endif
