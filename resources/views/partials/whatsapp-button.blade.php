{{-- resources/views/partials/whatsapp-button.blade.php --}}
@if(!request()->is('admin*'))
<style>
/* ═══════════════════════════════════════════════════════════
   FLOATING WHATSAPP BUTTON (Pojok Kiri Bawah)
   ═══════════════════════════════════════════════════════════ */
.floating-wa-wrapper {
  position: fixed;
  bottom: 24px;
  left: 24px;
  z-index: 9999;
  display: flex;
  align-items: center;
  gap: 12px;
  pointer-events: auto;
  font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
}

.floating-wa-btn {
  position: relative;
  display: inline-flex;
  align-items: center;
  gap: 11px;
  background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
  color: #ffffff !important;
  text-decoration: none !important;
  padding: 8px 18px 8px 10px;
  border-radius: 9999px;
  box-shadow: 0 8px 24px -2px rgba(18, 140, 126, 0.45), 0 4px 12px rgba(0, 0, 0, 0.22);
  border: 1.5px solid rgba(255, 255, 255, 0.35);
  transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.28s ease, filter 0.25s ease;
  cursor: pointer;
  user-select: none;
  -webkit-user-select: none;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

.floating-wa-btn:hover {
  transform: translateY(-3px) scale(1.03);
  box-shadow: 0 14px 30px -2px rgba(18, 140, 126, 0.65), 0 6px 16px rgba(0, 0, 0, 0.3);
  filter: brightness(1.05);
  color: #ffffff !important;
}

.floating-wa-btn:active {
  transform: translateY(-1px) scale(0.98);
  box-shadow: 0 6px 16px -2px rgba(18, 140, 126, 0.45);
}

/* Radar Pulse Effect */
.floating-wa-pulse {
  position: absolute;
  inset: -4px;
  border-radius: 9999px;
  background: rgba(37, 211, 102, 0.45);
  z-index: -1;
  pointer-events: none;
  animation: waPulseRing 2.4s cubic-bezier(0.16, 1, 0.3, 1) infinite;
}

@keyframes waPulseRing {
  0% {
    transform: scale(0.95);
    opacity: 0.85;
  }
  50% {
    transform: scale(1.18);
    opacity: 0;
  }
  100% {
    transform: scale(1.18);
    opacity: 0;
  }
}

/* Icon Box with slight glossy inset */
.floating-wa-icon-box {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  background: rgba(255, 255, 255, 0.22);
  border-radius: 50%;
  flex-shrink: 0;
  box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.45);
}

.floating-wa-icon {
  width: 24px;
  height: 24px;
  fill: #ffffff;
  filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.18));
  transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.floating-wa-btn:hover .floating-wa-icon {
  transform: rotate(-8deg) scale(1.1);
}

/* Live Online Indicator Dot */
.floating-wa-dot {
  position: absolute;
  top: 0px;
  right: 0px;
  width: 10px;
  height: 10px;
  background: #4ade80;
  border: 2px solid #ffffff;
  border-radius: 50%;
  box-shadow: 0 0 8px #22c55e;
}

/* Text Container */
.floating-wa-label {
  display: flex;
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
  font-size: 0.7rem;
  font-weight: 600;
  color: #dcfce7;
  opacity: 0.95;
  letter-spacing: 0.02em;
}

/* Tooltip Balon Sapaan (Muncul Saat Kursor Diarahkan) */
.floating-wa-tooltip {
  position: absolute;
  left: 0;
  bottom: calc(100% + 12px);
  background: rgba(15, 23, 42, 0.92);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  color: #ffffff;
  padding: 9px 15px;
  border-radius: 12px;
  font-size: 0.78rem;
  font-weight: 600;
  white-space: nowrap;
  box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.4), 0 0 1px 1px rgba(255, 255, 255, 0.15);
  border: 1px solid rgba(255, 255, 255, 0.12);
  opacity: 0;
  visibility: hidden;
  transform: translateY(6px);
  transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.25s;
  pointer-events: none;
}

.floating-wa-tooltip::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 24px;
  border-width: 6px;
  border-style: solid;
  border-color: rgba(15, 23, 42, 0.92) transparent transparent transparent;
}

.floating-wa-wrapper:hover .floating-wa-tooltip {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

/* Responsive Mobile Screen: Bulatan Murni Logo WhatsApp */
@media (max-width: 768px) {
  .floating-wa-wrapper {
    bottom: 20px;
    left: 20px;
  }

  .floating-wa-btn {
    width: 54px;
    height: 54px;
    min-width: 54px;
    min-height: 54px;
    padding: 0 !important;
    border-radius: 50% !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 0 !important;
    box-shadow: 0 8px 24px -2px rgba(18, 140, 126, 0.55), 0 4px 10px rgba(0, 0, 0, 0.25);
  }

  /* Sembunyikan seluruh teks (label, title, subtitle) */
  .floating-wa-label,
  .floating-wa-title,
  .floating-wa-sub {
    display: none !important;
  }

  /* Bulatan icon box mengisi ruang tengah secara presisi */
  .floating-wa-icon-box {
    width: 100%;
    height: 100%;
    background: transparent;
    box-shadow: none;
  }

  .floating-wa-icon {
    width: 28px;
    height: 28px;
  }

  /* Indikator online di sudut atas bulatan */
  .floating-wa-dot {
    top: 4px;
    right: 4px;
    width: 11px;
    height: 11px;
  }

  /* Radar pulse melingkar sempurna */
  .floating-wa-pulse {
    border-radius: 50% !important;
  }

  .floating-wa-tooltip {
    display: none !important;
  }
}

@media (prefers-reduced-motion: reduce) {
  .floating-wa-pulse {
    animation: none !important;
  }
  .floating-wa-btn {
    transition: none !important;
  }
}
</style>

<div class="floating-wa-wrapper" id="floatingWaWrapper">
    <!-- Tooltip Balon Informasi saat Kursor Diarahkan -->
    <div class="floating-wa-tooltip" role="tooltip" aria-hidden="true">
        <span>Tanya seputar PPDB & program sekolah via WhatsApp 👋</span>
    </div>

    <!-- Tombol WhatsApp Mengambang (Pojok Kiri Bawah) -->
    <a href="https://wa.me/6281200000000?text=Halo%20Admin%20PKBM%20Tahfizh%20At-Tamam,%20saya%20ingin%20konsultasi%20pendaftaran" 
       target="_blank" 
       rel="noopener noreferrer" 
       class="floating-wa-btn" 
       id="floatingWaBtn"
       aria-label="Hubungi Admin PKBM At-Tamam via WhatsApp"
       title="Chat WhatsApp Resmi PKBM At-Tamam">
        
        <!-- Gelombang Radar Pulse -->
        <span class="floating-wa-pulse" aria-hidden="true"></span>
        
        <!-- Ikon WhatsApp + Status Online -->
        <span class="floating-wa-icon-box">
            <svg class="floating-wa-icon" viewBox="0 0 24 24" width="28" height="28" fill="currentColor" aria-hidden="true">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.42 0-2.82-.37-4.06-1.07l-.29-.17-3.12.82.83-3.04-.19-.3a8.19 8.19 0 0 1-1.26-4.47c0-4.54 3.7-8.24 8.24-8.24m4.53 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.03-1.25-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.38-.44.13-.15.17-.25.25-.42.08-.17.04-.32-.02-.45-.06-.13-.56-1.35-.77-1.85-.2-.48-.4-.42-.56-.43h-.47c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.78 2.72 4.31 3.81.6.26 1.07.42 1.44.53.61.2 1.16.17 1.6.1.49-.07 1.47-.6 1.68-1.18.21-.59.21-1.09.15-1.19-.06-.09-.22-.16-.47-.28z"/>
            </svg>
            <span class="floating-wa-dot" title="Online"></span>
        </span>

        <!-- Label Teks WhatsApp -->
        <span class="floating-wa-label">
            <span class="floating-wa-title">WhatsApp</span>
            <span class="floating-wa-sub">Online · Hubungi Kami</span>
        </span>
    </a>
</div>
@endif
