{{-- Modal Konfirmasi Logout (Scale-in Pop Effect + Glassmorphism Dual-Ring Orbit Spinner) --}}
<div id="logoutModal" class="logout-modal-overlay" aria-hidden="true" role="dialog" aria-labelledby="logoutModalTitle">
    <div class="logout-modal-backdrop" id="logoutModalBackdrop"></div>
    <div class="logout-modal-container">
        <div class="logout-modal-card" id="logoutModalCard">
            
            {{-- STAGE 1: CONFIRMATION VIEW (Pop Effect) --}}
            <div id="logoutConfirmStage" class="logout-confirm-stage">
                {{-- Glowing Badge & Icon Pop --}}
                <div class="logout-modal-badge-wrap">
                    <div class="logout-modal-badge-glow"></div>
                    <div class="logout-modal-badge-icon">
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </div>
                </div>

                {{-- Text Content --}}
                <div class="logout-modal-header">
                    <h3 class="logout-modal-title" id="logoutModalTitle">Konfirmasi Keluar Akun</h3>
                    <p class="logout-modal-desc">
                        Apakah Anda yakin ingin keluar dari sistem? Seluruh sesi login aktif Anda saat ini akan diakhiri.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="logout-modal-actions">
                    <button type="button" class="btn-logout-cancel" id="btnCancelLogout">
                        <span>Batal</span>
                    </button>
                    <button type="button" class="btn-logout-confirm" id="btnConfirmLogout" data-logout-url="{{ route('logout') }}">
                        <span>🚪 Ya, Logout</span>
                    </button>
                </div>
            </div>

            {{-- STAGE 2: GLASSMORPHISM + DUAL-RING / ORBIT SPINNER LOADING STAGE --}}
            <div id="logoutLoadingStage" class="logout-loading-stage" style="display: none;">
                <div class="orbit-spinner-container">
                    <div class="orbit-ambient-glow"></div>
                    
                    {{-- Outer Clockwise Orbit Ring --}}
                    <div class="orbit-ring-outer">
                        <div class="orbit-satellite-outer"></div>
                    </div>
                    
                    {{-- Inner Counter-Clockwise Orbit Ring --}}
                    <div class="orbit-ring-inner">
                        <div class="orbit-satellite-inner"></div>
                    </div>
                    
                    {{-- Core Glassmorphism Center --}}
                    <div class="orbit-core">
                        <span>🔒</span>
                    </div>
                </div>

                <div class="orbit-loading-content">
                    <h3 class="orbit-loading-title">Mengakhiri Sesi...</h3>
                    <p class="orbit-loading-desc">Membersihkan autentikasi aman & mengalihkan halaman Anda.</p>
                    
                    <div class="orbit-progress-track">
                        <div class="orbit-progress-bar"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* ═══════════════════════════════════════════════════════════
   1. LOGOUT MODAL OVERLAY & POP-IN SPRING PHYSICS
   ═══════════════════════════════════════════════════════════ */
.logout-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1.25rem;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.28s ease, visibility 0.28s ease;
}

.logout-modal-overlay.is-active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.logout-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(7, 13, 30, 0.82);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    transition: opacity 0.28s ease;
}

.logout-modal-container {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 430px;
    margin: auto;
}

/* Glassmorphism Card with Scale-in Pop Effect */
.logout-modal-card {
    background: rgba(15, 23, 42, 0.95);
    border: 1.5px solid rgba(239, 68, 68, 0.35);
    border-radius: 28px;
    padding: 2.25rem 2rem;
    text-align: center;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.7), 0 0 40px rgba(239, 68, 68, 0.18);
    backdrop-filter: blur(28px);
    -webkit-backdrop-filter: blur(28px);
    transform: scale(0.6) translateY(25px);
    opacity: 0;
    filter: blur(8px);
    transition: border-color 0.4s ease, box-shadow 0.4s ease;
}

.logout-modal-overlay.is-loading-active .logout-modal-card {
    border-color: rgba(56, 189, 248, 0.45);
    box-shadow: 0 30px 80px rgba(0, 0, 0, 0.75), 0 0 50px rgba(56, 189, 248, 0.25);
}

.logout-modal-overlay.is-active .logout-modal-card {
    animation: logoutPopIn 0.42s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

.logout-modal-overlay.is-closing .logout-modal-card {
    animation: logoutPopOut 0.22s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes logoutPopIn {
    0% {
        opacity: 0;
        transform: scale(0.6) translateY(25px);
        filter: blur(8px);
    }
    70% {
        opacity: 1;
        transform: scale(1.05) translateY(-3px);
        filter: blur(0px);
    }
    100% {
        opacity: 1;
        transform: scale(1) translateY(0);
        filter: blur(0px);
    }
}

@keyframes logoutPopOut {
    0% {
        opacity: 1;
        transform: scale(1) translateY(0);
        filter: blur(0px);
    }
    100% {
        opacity: 0;
        transform: scale(0.7) translateY(15px);
        filter: blur(6px);
    }
}

/* ═══════════════════════════════════════════════════════════
   2. STAGE 1: CONFIRMATION VIEW
   ═══════════════════════════════════════════════════════════ */
.logout-confirm-stage {
    transition: opacity 0.25s ease, transform 0.25s ease;
}

.logout-modal-badge-wrap {
    position: relative;
    width: 68px;
    height: 68px;
    margin: 0 auto 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logout-modal-badge-glow {
    position: absolute;
    inset: -8px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(239, 68, 68, 0.5) 0%, transparent 70%);
    animation: badgePulse 2s ease-in-out infinite alternate;
}

@keyframes badgePulse {
    0% { transform: scale(0.88); opacity: 0.5; }
    100% { transform: scale(1.22); opacity: 1; }
}

.logout-modal-badge-icon {
    position: relative;
    z-index: 2;
    width: 68px;
    height: 68px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(185, 28, 28, 0.38) 100%);
    border: 1.5px solid rgba(239, 68, 68, 0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f87171;
    box-shadow: 0 10px 25px rgba(239, 68, 68, 0.25);
    transform: scale(0);
}

.logout-modal-overlay.is-active .logout-modal-badge-icon {
    animation: iconPopBounce 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.06s forwards;
}

@keyframes iconPopBounce {
    0% { transform: scale(0) rotate(-18deg); }
    70% { transform: scale(1.2) rotate(6deg); }
    100% { transform: scale(1) rotate(0deg); }
}

.logout-modal-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 0.5rem;
    letter-spacing: -0.01em;
}

.logout-modal-desc {
    font-size: 0.88rem;
    color: #94a3b8;
    line-height: 1.55;
    margin-bottom: 1.75rem;
}

.logout-modal-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.btn-logout-cancel {
    background: rgba(255, 255, 255, 0.08);
    border: 1.5px solid rgba(255, 255, 255, 0.14);
    color: #e2e8f0;
    font-size: 0.9rem;
    font-weight: 700;
    font-family: inherit;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    cursor: pointer;
    outline: none;
    transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.btn-logout-cancel:hover {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    color: #ffffff;
}

.btn-logout-confirm {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #991b1b 100%);
    border: 1.5px solid rgba(239, 68, 68, 0.6);
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 800;
    font-family: inherit;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.35);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    outline: none;
    transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.btn-logout-confirm:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 12px 28px rgba(239, 68, 68, 0.5);
    background: linear-gradient(135deg, #f87171 0%, #ef4444 50%, #b91c1c 100%);
    color: #ffffff;
}

.btn-logout-confirm:active,
.btn-logout-cancel:active {
    transform: translateY(0) scale(0.98);
}

/* ═══════════════════════════════════════════════════════════
   3. STAGE 2: GLASSMORPHISM + DUAL-RING / ORBIT SPINNER
   ═══════════════════════════════════════════════════════════ */
.logout-loading-stage {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 0.5rem;
    animation: orbitStageEnter 0.38s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

@keyframes orbitStageEnter {
    0% {
        opacity: 0;
        transform: scale(0.85);
        filter: blur(8px);
    }
    100% {
        opacity: 1;
        transform: scale(1);
        filter: blur(0px);
    }
}

.orbit-spinner-container {
    position: relative;
    width: 104px;
    height: 104px;
    margin: 0 auto 1.6rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Ambient Radial Background Glow */
.orbit-ambient-glow {
    position: absolute;
    inset: -16px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(56, 189, 248, 0.3) 0%, rgba(244, 63, 94, 0.18) 50%, transparent 75%);
    filter: blur(14px);
    animation: orbitAmbientPulse 2s ease-in-out infinite alternate;
}

@keyframes orbitAmbientPulse {
    0% { transform: scale(0.88); opacity: 0.6; }
    100% { transform: scale(1.18); opacity: 1; }
}

/* Outer Orbit Ring (Clockwise Rotation with Cyan Accent) */
.orbit-ring-outer {
    position: absolute;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    border: 2.5px solid transparent;
    border-top-color: #38bdf8;
    border-right-color: #0284c7;
    border-bottom-color: rgba(56, 189, 248, 0.15);
    box-shadow: 0 0 18px rgba(56, 189, 248, 0.45);
    animation: orbitClockwise 1.35s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
}

.orbit-satellite-outer {
    position: absolute;
    top: 5px;
    right: 12px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #38bdf8;
    box-shadow: 0 0 10px 2.5px #38bdf8;
}

/* Inner Orbit Ring (Counter-Clockwise Rotation with Rose Accent) */
.orbit-ring-inner {
    position: absolute;
    width: 68px;
    height: 68px;
    border-radius: 50%;
    border: 2.5px solid transparent;
    border-top-color: #f43f5e;
    border-left-color: #e11d48;
    border-bottom-color: rgba(244, 63, 94, 0.15);
    box-shadow: 0 0 14px rgba(244, 63, 94, 0.45);
    animation: orbitCounterClockwise 1.05s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
}

.orbit-satellite-inner {
    position: absolute;
    bottom: 3px;
    left: 8px;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #f43f5e;
    box-shadow: 0 0 9px 2px #f43f5e;
}

/* Core Center Glass Element */
.orbit-core {
    position: relative;
    z-index: 5;
    width: 42px;
    height: 42px;
    border-radius: 14px;
    background: rgba(15, 23, 42, 0.85);
    border: 1.5px solid rgba(255, 255, 255, 0.22);
    backdrop-filter: blur(16px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
    animation: corePulse 1.8s ease-in-out infinite;
}

@keyframes orbitClockwise {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes orbitCounterClockwise {
    from { transform: rotate(0deg); }
    to { transform: rotate(-360deg); }
}

@keyframes corePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.08); box-shadow: 0 0 20px rgba(56, 189, 248, 0.45); }
}

/* Orbit Loading Text */
.orbit-loading-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 0.45rem;
    background: linear-gradient(135deg, #ffffff 0%, #bae6fd 60%, #38bdf8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    letter-spacing: -0.01em;
}

.orbit-loading-desc {
    font-size: 0.86rem;
    color: #94a3b8;
    line-height: 1.5;
    margin-bottom: 1.6rem;
    max-width: 320px;
}

/* Progress Shimmer Bar */
.orbit-progress-track {
    width: 100%;
    max-width: 250px;
    height: 5px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 9999px;
    overflow: hidden;
    position: relative;
    margin: 0 auto;
}

.orbit-progress-bar {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent 0%, #38bdf8 45%, #f43f5e 80%, transparent 100%);
    animation: orbitShimmer 1.15s infinite cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes orbitShimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Light Theme Adjustments */
[data-theme="light"] .logout-modal-backdrop {
    background: rgba(15, 23, 42, 0.65);
}
[data-theme="light"] .logout-modal-card {
    background: #ffffff;
    border-color: rgba(239, 68, 68, 0.3);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.22), 0 0 35px rgba(239, 68, 68, 0.12);
}
[data-theme="light"] .logout-modal-overlay.is-loading-active .logout-modal-card {
    border-color: rgba(14, 165, 233, 0.4);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.22), 0 0 35px rgba(14, 165, 233, 0.18);
}
[data-theme="light"] .logout-modal-title {
    color: #0f172a;
}
[data-theme="light"] .logout-modal-desc {
    color: #475569;
}
[data-theme="light"] .orbit-loading-title {
    background: linear-gradient(135deg, #0f172a 0%, #0369a1 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
[data-theme="light"] .orbit-loading-desc {
    color: #475569;
}
[data-theme="light"] .orbit-core {
    background: #ffffff;
    border-color: #cbd5e1;
}
[data-theme="light"] .btn-logout-cancel {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #334155;
}
[data-theme="light"] .btn-logout-cancel:hover {
    background: #e2e8f0;
    color: #0f172a;
}
</style>

<script>
(function() {
    function initLogoutModal() {
        const modal = document.getElementById('logoutModal');
        const backdrop = document.getElementById('logoutModalBackdrop');
        const btnCancel = document.getElementById('btnCancelLogout');
        const btnConfirm = document.getElementById('btnConfirmLogout');
        const confirmStage = document.getElementById('logoutConfirmStage');
        const loadingStage = document.getElementById('logoutLoadingStage');
        
        if (!modal) return;

        function resetStages() {
            if (confirmStage) confirmStage.style.display = 'block';
            if (loadingStage) loadingStage.style.display = 'none';
            modal.classList.remove('is-loading-active');
        }

        function openModal(e) {
            if (e) e.preventDefault();
            resetStages();
            modal.classList.remove('is-closing');
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            if (!modal.classList.contains('is-active')) return;
            // Prevent close while loading
            if (modal.classList.contains('is-loading-active')) return;

            modal.classList.add('is-closing');
            setTimeout(function() {
                modal.classList.remove('is-active', 'is-closing');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                resetStages();
            }, 220);
        }

        // Attach to all logout links across desktop navbar, mobile menu, and admin sidebar
        const logoutSelectors = [
            '.nav-logout-link',
            'a[href*="/logout"]',
            'a[href$="logout"]',
            '.sidebar-link[href*="logout"]'
        ];

        document.querySelectorAll(logoutSelectors.join(',')).forEach(function(link) {
            if (link.id !== 'btnConfirmLogout') {
                link.addEventListener('click', openModal);
            }
        });

        // Trigger Glassmorphism + Dual-Ring Orbit Spinner on Confirm
        if (btnConfirm) {
            btnConfirm.addEventListener('click', function(e) {
                e.preventDefault();
                const logoutUrl = btnConfirm.getAttribute('data-logout-url') || '/logout';

                // Switch to Orbit Loading Stage
                modal.classList.add('is-loading-active');
                if (confirmStage) confirmStage.style.display = 'none';
                if (loadingStage) loadingStage.style.display = 'flex';

                // Graceful delay to let the elegant Orbit animation run before navigation
                setTimeout(function() {
                    window.location.href = logoutUrl;
                }, 950);
            });
        }

        // Close triggers
        if (backdrop) backdrop.addEventListener('click', closeModal);
        if (btnCancel) btnCancel.addEventListener('click', closeModal);

        // Escape Key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('is-active')) {
                closeModal();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLogoutModal);
    } else {
        initLogoutModal();
    }
})();
</script>
