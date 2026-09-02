{{-- Modal Konfirmasi Logout (Scale-in / Zoom-in Pop Effect) --}}
<div id="logoutModal" class="logout-modal-overlay" aria-hidden="true" role="dialog" aria-labelledby="logoutModalTitle">
    <div class="logout-modal-backdrop" id="logoutModalBackdrop"></div>
    <div class="logout-modal-container">
        <div class="logout-modal-card" id="logoutModalCard">
            
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
                <a href="{{ route('logout') }}" class="btn-logout-confirm" id="btnConfirmLogout">
                    <span>🚪 Ya, Logout</span>
                </a>
            </div>

        </div>
    </div>
</div>

<style>
/* ═══════════════════════════════════════════════════════════
   LOGOUT MODAL — SCALE-IN / ZOOM-IN (POP EFFECT) STYLES
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
    background: rgba(7, 13, 30, 0.78);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    transition: opacity 0.28s ease;
}

.logout-modal-container {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 420px;
    margin: auto;
}

/* Pop In Card with Zoom-in & Spring Physics */
.logout-modal-card {
    background: rgba(15, 23, 42, 0.96);
    border: 1.5px solid rgba(239, 68, 68, 0.35);
    border-radius: 26px;
    padding: 2.25rem 2rem;
    text-align: center;
    box-shadow: 0 25px 65px rgba(0, 0, 0, 0.65), 0 0 35px rgba(239, 68, 68, 0.2);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    transform: scale(0.6) translateY(25px);
    opacity: 0;
    filter: blur(8px);
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

/* Badge Glow & Icon Animation */
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
    text-decoration: none;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.35);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
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

/* Light Theme Adjustments */
[data-theme="light"] .logout-modal-backdrop {
    background: rgba(15, 23, 42, 0.65);
}
[data-theme="light"] .logout-modal-card {
    background: #ffffff;
    border-color: rgba(239, 68, 68, 0.3);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.22), 0 0 35px rgba(239, 68, 68, 0.12);
}
[data-theme="light"] .logout-modal-title {
    color: #0f172a;
}
[data-theme="light"] .logout-modal-desc {
    color: #475569;
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
        
        if (!modal) return;

        function openModal(e) {
            if (e) e.preventDefault();
            modal.classList.remove('is-closing');
            modal.classList.add('is-active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            if (!modal.classList.contains('is-active')) return;
            modal.classList.add('is-closing');
            setTimeout(function() {
                modal.classList.remove('is-active', 'is-closing');
                modal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
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
            // Avoid attaching twice
            if (link.id !== 'btnConfirmLogout') {
                link.addEventListener('click', openModal);
            }
        });

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
