{{-- ═══════════════════════════════════════════════════════════
     SPOTLIGHT QUICK SEARCH MODAL (Cmd+K / Ctrl+K)
     Pencarian Global Cepat — PKBM Tahfizh At-Tamam
     ═══════════════════════════════════════════════════════════ --}}
<div id="spotlightModal" class="spotlight-overlay" style="display: none;" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Pencarian Cepat Portal Sekolah">
    <div class="spotlight-dialog">
        {{-- Search Input Header --}}
        <div class="spotlight-header">
            <svg class="spotlight-search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="spotlightInput" class="spotlight-input" placeholder="Ketik kata kunci pencarian (misal: PPDB, beasiswa, SD, RPL, biaya)..." autocomplete="off" spellcheck="false">
            <div class="spotlight-header-actions">
                <button type="button" id="spotlightClearBtn" class="spotlight-clear-btn" aria-label="Hapus kata kunci" style="display: none;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
                <kbd class="spotlight-kbd">ESC</kbd>
            </div>
        </div>

        {{-- Quick Category Filter Chips --}}
        <div class="spotlight-chips-row">
            <span class="spotlight-chip active" data-filter="all">Semua</span>
            <span class="spotlight-chip" data-filter="PPDB">PPDB</span>
            <span class="spotlight-chip" data-filter="Jenjang">Jenjang</span>
            <span class="spotlight-chip" data-filter="Kejuruan">Kejuruan</span>
            <span class="spotlight-chip" data-filter="Cabang">Cabang</span>
            <span class="spotlight-chip" data-filter="Berita">Berita</span>
        </div>

        {{-- Search Results Container --}}
        <div id="spotlightResultsList" class="spotlight-results-list" role="listbox">
            <div class="spotlight-loading" id="spotlightLoading" style="display: none;">
                <div class="spotlight-spinner"></div>
                <span>Mencari informasi...</span>
            </div>
            <div class="spotlight-items-wrap" id="spotlightItemsWrap">
                {{-- Dynamic items will be injected here via JS --}}
            </div>
            <div class="spotlight-empty" id="spotlightEmpty" style="display: none;">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #64748b; margin-bottom: 8px;">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <p style="margin: 0; font-weight: 600; color: #cbd5e1;">Tidak ada hasil yang cocok</p>
                <span style="font-size: 0.8rem; color: #94a3b8;">Coba gunakan kata kunci lain atau pilih filter di atas</span>
            </div>
        </div>

        {{-- Modal Footer with Shortcuts --}}
        <div class="spotlight-footer">
            <div class="spotlight-footer-shortcuts">
                <span><kbd class="spotlight-mini-kbd">&uarr;</kbd><kbd class="spotlight-mini-kbd">&darr;</kbd> Navigasi</span>
                <span><kbd class="spotlight-mini-kbd">&crarr;</kbd> Buka</span>
                <span><kbd class="spotlight-mini-kbd">ESC</kbd> Tutup</span>
            </div>
            <div class="spotlight-brand-pill">
                PKBM Tahfizh At-Tamam Edu
            </div>
        </div>
    </div>
</div>

<style>
.spotlight-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: rgba(0, 15, 30, 0.78);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding: clamp(40px, 10vh, 100px) 16px 24px;
    animation: spotlightFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes spotlightFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.spotlight-dialog {
    width: 100%;
    max-width: 660px;
    background: #001e3d;
    border: 1px solid rgba(0, 180, 216, 0.35);
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.08);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    animation: spotlightScaleUp 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

[data-theme="light"] .spotlight-dialog {
    background: #ffffff;
    border-color: oklch(58.6% 0.253 17.585 / 0.4);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2), 0 0 24px oklch(58.6% 0.253 17.585 / 0.15);
}

@keyframes spotlightScaleUp {
    from { transform: scale(0.96) translateY(-10px); }
    to { transform: scale(1) translateY(0); }
}

.spotlight-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

[data-theme="light"] .spotlight-header {
    border-bottom-color: #f1f5f9;
}

.spotlight-search-icon {
    color: #38bdf8;
    flex-shrink: 0;
}

[data-theme="light"] .spotlight-search-icon {
    color: oklch(58.6% 0.253 17.585);
}

.spotlight-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    font-size: 1.05rem;
    color: #ffffff;
    font-weight: 500;
}

[data-theme="light"] .spotlight-input {
    color: #0f172a;
}

.spotlight-input::placeholder {
    color: #64748b;
    font-size: 0.95rem;
}

.spotlight-header-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.spotlight-clear-btn {
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: #94a3b8;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.spotlight-clear-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
}

.spotlight-kbd {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.18);
    color: #cbd5e1;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 3px 7px;
    border-radius: 6px;
    font-family: inherit;
}

[data-theme="light"] .spotlight-kbd {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #475569;
}

.spotlight-chips-row {
    display: flex;
    gap: 8px;
    padding: 10px 20px;
    background: rgba(0, 15, 30, 0.4);
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    overflow-x: auto;
    scrollbar-width: none;
}

[data-theme="light"] .spotlight-chips-row {
    background: #f8fafc;
    border-bottom-color: #e2e8f0;
}

.spotlight-chip {
    font-size: 0.78rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 9999px;
    background: rgba(255, 255, 255, 0.06);
    color: #94a3b8;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.spotlight-chip:hover {
    color: #ffffff;
    background: rgba(255, 255, 255, 0.12);
}

.spotlight-chip.active {
    background: rgba(0, 180, 216, 0.2);
    color: #38bdf8;
    border-color: rgba(0, 180, 216, 0.4);
}

[data-theme="light"] .spotlight-chip {
    background: #e2e8f0;
    color: #475569;
}

[data-theme="light"] .spotlight-chip.active {
    background: oklch(58.6% 0.253 17.585);
    color: #ffffff;
}

.spotlight-results-list {
    max-height: 380px;
    overflow-y: auto;
    padding: 10px 12px;
}

.spotlight-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
    transition: all 0.18s ease;
    margin-bottom: 4px;
    border: 1px solid transparent;
}

.spotlight-item:hover,
.spotlight-item.selected {
    background: rgba(0, 180, 216, 0.12);
    border-color: rgba(0, 180, 216, 0.3);
    transform: translateX(3px);
}

[data-theme="light"] .spotlight-item:hover,
[data-theme="light"] .spotlight-item.selected {
    background: oklch(58.6% 0.253 17.585 / 0.1);
    border-color: oklch(58.6% 0.253 17.585 / 0.35);
}

.spotlight-item-main {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 0;
}

.spotlight-item-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: rgba(0, 180, 216, 0.15);
    color: #38bdf8;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

[data-theme="light"] .spotlight-item-icon {
    background: oklch(58.6% 0.253 17.585 / 0.12);
    color: oklch(58.6% 0.253 17.585);
}

.spotlight-item-info {
    min-width: 0;
    flex: 1;
}

.spotlight-item-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

[data-theme="light"] .spotlight-item-title {
    color: #0f172a;
}

.spotlight-item-desc {
    font-size: 0.8rem;
    color: #94a3b8;
    margin: 2px 0 0;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.spotlight-item-badge {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
    flex-shrink: 0;
}

[data-theme="light"] .spotlight-item-badge {
    background: oklch(58.6% 0.253 17.585 / 0.12);
    color: oklch(58.6% 0.253 17.585);
}

.spotlight-loading,
.spotlight-empty {
    padding: 36px 20px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.spotlight-spinner {
    width: 28px;
    height: 28px;
    border: 3px solid rgba(0, 180, 216, 0.2);
    border-top-color: #00B4D8;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin-bottom: 10px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.spotlight-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 18px;
    background: rgba(0, 15, 30, 0.5);
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    font-size: 0.75rem;
    color: #64748b;
}

[data-theme="light"] .spotlight-footer {
    background: #f8fafc;
    border-top-color: #e2e8f0;
}

.spotlight-footer-shortcuts {
    display: flex;
    gap: 14px;
}

.spotlight-mini-kbd {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 4px;
    padding: 1px 4px;
    font-size: 0.68rem;
    margin-right: 3px;
    color: #cbd5e1;
}

[data-theme="light"] .spotlight-mini-kbd {
    background: #e2e8f0;
    color: #475569;
}

.spotlight-brand-pill {
    font-weight: 700;
    color: #38bdf8;
    letter-spacing: 0.02em;
}

[data-theme="light"] .spotlight-brand-pill {
    color: #0284c7;
}
</style>

<script>
(function() {
    let allItems = [];
    let filteredItems = [];
    let selectedIndex = 0;
    let activeFilter = 'all';

    const modal = document.getElementById('spotlightModal');
    const input = document.getElementById('spotlightInput');
    const clearBtn = document.getElementById('spotlightClearBtn');
    const itemsWrap = document.getElementById('spotlightItemsWrap');
    const emptyState = document.getElementById('spotlightEmpty');
    const loadingState = document.getElementById('spotlightLoading');
    const chips = document.querySelectorAll('.spotlight-chip');

    // Fetch initial dataset once
    async function loadSearchData() {
        try {
            loadingState.style.display = 'flex';
            const res = await fetch('{{ route("api.search") }}');
            if (res.ok) {
                allItems = await res.json();
                renderItems();
            }
        } catch (e) {
            console.error('Gagal memuat index pencarian:', e);
        } finally {
            loadingState.style.display = 'none';
        }
    }

    function getIconSvg(icon) {
        switch(icon) {
            case 'form':
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>';
            case 'search':
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';
            case 'calculator':
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="8" y1="6" x2="16" y2="6"></line><line x1="16" y1="14" x2="16" y2="18"></line><path d="M16 10h.01"></path><path d="M12 10h.01"></path><path d="M8 10h.01"></path><path d="M12 14h.01"></path><path d="M8 14h.01"></path><path d="M12 18h.01"></path><path d="M8 18h.01"></path></svg>';
            case 'school':
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>';
            case 'compass':
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>';
            case 'code':
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>';
            case 'map-pin':
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>';
            case 'newspaper':
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"></path><path d="M18 14h-8"></path><path d="M15 18h-5"></path><path d="M10 6h8v4h-8V6Z"></path></svg>';
            case 'help':
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
            default:
                return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
        }
    }

    function renderItems() {
        const query = (input.value || '').trim().toLowerCase();
        
        filteredItems = allItems.filter(item => {
            const matchesCategory = activeFilter === 'all' || 
                (item.category && item.category.toLowerCase().includes(activeFilter.toLowerCase())) ||
                (item.badge && item.badge.toLowerCase().includes(activeFilter.toLowerCase()));
            
            if (!matchesCategory) return false;
            if (!query) return true;

            return (item.title && item.title.toLowerCase().includes(query)) ||
                   (item.desc && item.desc.toLowerCase().includes(query)) ||
                   (item.category && item.category.toLowerCase().includes(query));
        });

        if (selectedIndex >= filteredItems.length) {
            selectedIndex = Math.max(0, filteredItems.length - 1);
        }

        if (filteredItems.length === 0) {
            itemsWrap.innerHTML = '';
            emptyState.style.display = 'flex';
            return;
        }

        emptyState.style.display = 'none';
        itemsWrap.innerHTML = filteredItems.map((item, idx) => `
            <a href="${item.url}" class="spotlight-item ${idx === selectedIndex ? 'selected' : ''}" data-index="${idx}">
                <div class="spotlight-item-main">
                    <span class="spotlight-item-icon">${getIconSvg(item.icon)}</span>
                    <div class="spotlight-item-info">
                        <div class="spotlight-item-title">${item.title}</div>
                        <div class="spotlight-item-desc">${item.desc}</div>
                    </div>
                </div>
                <span class="spotlight-item-badge">${item.badge || item.category}</span>
            </a>
        `).join('');

        // Attach hover sync
        itemsWrap.querySelectorAll('.spotlight-item').forEach(el => {
            el.addEventListener('mouseenter', function() {
                selectedIndex = parseInt(this.dataset.index, 10);
                updateSelection();
            });
        });
    }

    function updateSelection() {
        const itemEls = itemsWrap.querySelectorAll('.spotlight-item');
        itemEls.forEach((el, idx) => {
            el.classList.toggle('selected', idx === selectedIndex);
        });
        if (itemEls[selectedIndex]) {
            itemEls[selectedIndex].scrollIntoView({ block: 'nearest' });
        }
    }

    window.openSpotlight = function() {
        if (!modal) return;
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
        if (allItems.length === 0) {
            loadSearchData();
        } else {
            renderItems();
        }
        setTimeout(() => input && input.focus(), 60);
    };

    window.closeSpotlight = function() {
        if (!modal) return;
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
    };

    // Keyboard Shortcuts
    document.addEventListener('keydown', function(e) {
        // Open with Ctrl+K / Cmd+K or "/" when not typing in an input
        const isInput = ['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName);
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            if (modal.style.display === 'flex') {
                closeSpotlight();
            } else {
                openSpotlight();
            }
            return;
        }

        if (e.key === '/' && !isInput && modal.style.display !== 'flex') {
            e.preventDefault();
            openSpotlight();
            return;
        }

        if (modal.style.display === 'flex') {
            if (e.key === 'Escape') {
                e.preventDefault();
                closeSpotlight();
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (selectedIndex < filteredItems.length - 1) {
                    selectedIndex++;
                    updateSelection();
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (selectedIndex > 0) {
                    selectedIndex--;
                    updateSelection();
                }
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (filteredItems[selectedIndex]) {
                    window.location.href = filteredItems[selectedIndex].url;
                }
            }
        }
    });

    // Close on backdrop click
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeSpotlight();
        });
    }

    // Input handlers
    if (input) {
        input.addEventListener('input', function() {
            clearBtn.style.display = this.value ? 'flex' : 'none';
            selectedIndex = 0;
            renderItems();
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            input.value = '';
            this.style.display = 'none';
            input.focus();
            selectedIndex = 0;
            renderItems();
        });
    }

    // Filter Chips
    chips.forEach(chip => {
        chip.addEventListener('click', function() {
            chips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.dataset.filter;
            selectedIndex = 0;
            renderItems();
        });
    });
})();
</script>
