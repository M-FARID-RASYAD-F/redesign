@props(['items' => []])

<div class="facility-showcase-section" id="galeri-fasilitas">
    <x-section-header 
        tag="FASILITAS & LINGKUNGAN BELAJAR" 
        title="Jelajahi Sarana &amp; Fasilitas Modern At-Tamam" 
        subtitle="Didukung sarana pendidikan berstandar tinggi yang menunjang kenyamanan ibadah, ketuntasan tahfizh Al-Qur'an, dan penguasaan kejuruan teknologi."
    />

    {{-- Filter Category Tabs --}}
    <div class="facility-filter-tabs">
        <button type="button" class="facility-tab-btn active" data-filter="all">Semua Fasilitas</button>
        <button type="button" class="facility-tab-btn" data-filter="ibadah">Masjid &amp; Tahfizh</button>
        <button type="button" class="facility-tab-btn" data-filter="lab">Lab IT &amp; Multimedia</button>
        <button type="button" class="facility-tab-btn" data-filter="akademik">Ruang Belajar</button>
        <button type="button" class="facility-tab-btn" data-filter="asrama">Asrama Santri</button>
    </div>

    {{-- Facility Cards Grid --}}
    <div class="facility-grid" id="facilityGrid">
        @foreach($items as $idx => $f)
        <div class="facility-card" data-category="{{ $f['category'] ?? 'kampus' }}" data-index="{{ $idx }}" data-img="{{ $f['image'] }}" data-title="{{ $f['title'] }}" data-desc="{{ $f['desc'] }}">
            <div class="facility-img-wrap">
                <img src="{{ $f['image'] }}" alt="{{ $f['title'] }}" class="facility-img" loading="lazy">
                <div class="facility-overlay">
                    <span class="facility-zoom-icon" aria-label="Perbesar foto">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                    </span>
                </div>
                <span class="facility-badge">{{ $f['category_label'] ?? 'Fasilitas' }}</span>
            </div>
            <div class="facility-body">
                <h3 class="facility-name">{{ $f['title'] }}</h3>
                <p class="facility-desc">{{ $f['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Interactive Lightbox Modal --}}
    <div id="facilityLightbox" class="facility-lightbox" style="display: none;" aria-hidden="true" role="dialog">
        <div class="lightbox-overlay" id="lightboxBackdrop"></div>
        <div class="lightbox-content">
            <button type="button" class="lightbox-close-btn" id="lightboxCloseBtn" aria-label="Tutup pratinjau foto">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            <button type="button" class="lightbox-nav-btn prev" id="lightboxPrevBtn" aria-label="Foto sebelumnya">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button type="button" class="lightbox-nav-btn next" id="lightboxNextBtn" aria-label="Foto selanjutnya">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
            
            <div class="lightbox-img-box">
                <img src="" alt="" id="lightboxImg" class="lightbox-img">
            </div>
            <div class="lightbox-caption">
                <h4 id="lightboxTitle" class="lightbox-title"></h4>
                <p id="lightboxDesc" class="lightbox-desc"></p>
            </div>
        </div>
    </div>
</div>

<style>
.facility-showcase-section {
    margin: 50px 0 70px;
}

[data-theme="light"] .facility-showcase-section {
    position: relative;
    background: #2b0b12;
    background: oklch(27.1% 0.105 12.094 / 0.94);
    border: 1px solid rgba(225, 29, 72, 0.35);
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.35);
    border-radius: 20px;
    padding: 52px 32px 46px;
    box-shadow: 0 16px 45px -5px rgba(0, 0, 0, 0.35);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    overflow: hidden;
}

[data-theme="light"] .facility-showcase-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #be123c 0%, #e11d48 50%, #f43f5e 100%);
    background: linear-gradient(90deg, oklch(41% 0.159 10.272) 0%, oklch(58.6% 0.253 17.585) 100%);
    border-radius: 20px 20px 0 0;
}

[data-theme="light"] .facility-showcase-section .section-title {
    color: #ffffff !important;
}

[data-theme="light"] .facility-showcase-section .section-subtitle {
    color: #ffe4e6 !important;
}

[data-theme="light"] .facility-showcase-section .section-tag {
    color: #fda4af !important;
    color: oklch(75% 0.18 18) !important;
}

.facility-filter-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.facility-tab-btn {
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(0, 180, 216, 0.25);
    color: #cbd5e1;
    padding: 8px 18px;
    border-radius: 9999px;
    font-size: 0.84rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
}

.facility-tab-btn:hover {
    background: rgba(0, 180, 216, 0.18);
    border-color: #38bdf8;
    color: #ffffff;
}

.facility-tab-btn.active {
    background: #00B4D8;
    border-color: #00B4D8;
    color: #ffffff;
    box-shadow: 0 4px 16px rgba(0, 180, 216, 0.35);
}

[data-theme="light"] .facility-tab-btn {
    background: #190508;
    background: oklch(20% 0.08 11 / 0.85);
    border: 1px solid rgba(225, 29, 72, 0.35);
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.35);
    color: #ffe4e6;
}

[data-theme="light"] .facility-tab-btn:hover {
    background: rgba(225, 29, 72, 0.25);
    background: oklch(58.6% 0.253 17.585 / 0.25);
    border-color: #e11d48;
    border-color: oklch(58.6% 0.253 17.585);
    color: #ffffff;
}

[data-theme="light"] .facility-tab-btn.active {
    background: #e11d48;
    background: oklch(58.6% 0.253 17.585);
    border-color: #e11d48;
    border-color: oklch(58.6% 0.253 17.585);
    color: #ffffff;
    box-shadow: 0 4px 16px rgba(225, 29, 72, 0.45), 0 0 16px oklch(58.6% 0.253 17.585 / 0.45);
}

.facility-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 22px;
}

.facility-card {
    background: rgba(0, 33, 71, 0.7);
    border: 1px solid rgba(0, 180, 216, 0.25);
    border-radius: 18px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    display: flex;
    flex-direction: column;
}

[data-theme="light"] .facility-card {
    background: #23060b;
    background: oklch(22% 0.09 11 / 0.92);
    border: 1px solid rgba(225, 29, 72, 0.3);
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.3);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

[data-theme="light"] .facility-card:hover {
    background: #300a12;
    background: oklch(30% 0.12 13 / 0.96);
    border-color: #e11d48;
    border-color: oklch(58.6% 0.253 17.585);
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.45), 0 0 24px rgba(225, 29, 72, 0.35), 0 0 24px oklch(58.6% 0.253 17.585 / 0.35);
}

.facility-card:hover {
    transform: translateY(-6px);
    border-color: #00B4D8;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.45);
}

.facility-img-wrap {
    position: relative;
    width: 100%;
    height: 190px;
    overflow: hidden;
}

.facility-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.45s ease;
}

.facility-card:hover .facility-img {
    transform: scale(1.08);
}

.facility-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 20, 45, 0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.25s ease;
}

.facility-card:hover .facility-overlay {
    opacity: 1;
}

.facility-zoom-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: rgba(0, 180, 216, 0.85);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: scale(0.8);
    transition: transform 0.25s ease;
}

.facility-card:hover .facility-zoom-icon {
    transform: scale(1);
}

.facility-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(0, 15, 30, 0.75);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #38bdf8;
    font-size: 0.72rem;
    font-weight: 800;
    padding: 3px 10px;
    border-radius: 9999px;
    letter-spacing: 0.03em;
}

[data-theme="light"] .facility-badge {
    background: rgba(20, 4, 7, 0.88);
    background: oklch(20% 0.08 11 / 0.88);
    color: #fda4af;
    border: 1px solid rgba(225, 29, 72, 0.5);
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.5);
}

.facility-body {
    padding: 18px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.facility-name {
    font-size: 1.05rem;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 6px 0;
    line-height: 1.35;
}

[data-theme="light"] .facility-name {
    color: #ffffff;
}

.facility-desc {
    font-size: 0.84rem;
    color: #cbd5e1;
    margin: 0;
    line-height: 1.5;
}

[data-theme="light"] .facility-desc {
    color: #ffe4e6;
}

/* Lightbox Modal */
.facility-lightbox {
    position: fixed;
    inset: 0;
    z-index: 100000;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
}

.lightbox-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 10, 25, 0.92);
    backdrop-filter: blur(10px);
}

.lightbox-content {
    position: relative;
    z-index: 10;
    max-width: 860px;
    width: 100%;
    background: #001e3d;
    border: 1px solid rgba(0, 180, 216, 0.4);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8);
    display: flex;
    flex-direction: column;
    animation: lightboxPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

[data-theme="light"] .lightbox-content {
    background: #24070c;
    background: oklch(24% 0.095 11.5);
    border-color: rgba(225, 29, 72, 0.5);
    border-color: oklch(58.6% 0.253 17.585 / 0.5);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 35px rgba(225, 29, 72, 0.35);
}

@keyframes lightboxPop {
    from { transform: scale(0.92); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.lightbox-img-box {
    width: 100%;
    max-height: 480px;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.lightbox-img {
    width: 100%;
    height: 100%;
    max-height: 480px;
    object-fit: contain;
}

.lightbox-caption {
    padding: 20px 24px;
    background: rgba(0, 20, 45, 0.85);
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

[data-theme="light"] .lightbox-caption {
    background: rgba(20, 4, 7, 0.95);
    background: oklch(20% 0.08 11 / 0.95);
    border-top-color: rgba(225, 29, 72, 0.3);
    border-top-color: oklch(58.6% 0.253 17.585 / 0.3);
}

.lightbox-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 6px 0;
}

[data-theme="light"] .lightbox-title {
    color: #ffffff;
}

.lightbox-desc {
    font-size: 0.88rem;
    color: #cbd5e1;
    margin: 0;
    line-height: 1.5;
}

[data-theme="light"] .lightbox-desc {
    color: #ffe4e6;
}

.lightbox-close-btn {
    position: absolute;
    top: 14px;
    right: 14px;
    z-index: 20;
    background: rgba(0, 0, 0, 0.65);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.lightbox-close-btn:hover {
    background: #ef4444;
}

.lightbox-nav-btn {
    position: absolute;
    top: 45%;
    transform: translateY(-50%);
    z-index: 20;
    background: rgba(0, 0, 0, 0.65);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #ffffff;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.lightbox-nav-btn:hover {
    background: #00B4D8;
}

.lightbox-nav-btn.prev {
    left: 14px;
}

.lightbox-nav-btn.next {
    right: 14px;
}

@media (max-width: 768px) {
    [data-theme="light"] .facility-showcase-section {
        padding: 36px 18px 30px;
        border-radius: 16px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.facility-tab-btn');
    const cards = document.querySelectorAll('.facility-card');
    const lightbox = document.getElementById('facilityLightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxTitle = document.getElementById('lightboxTitle');
    const lightboxDesc = document.getElementById('lightboxDesc');
    const closeBtn = document.getElementById('lightboxCloseBtn');
    const prevBtn = document.getElementById('lightboxPrevBtn');
    const nextBtn = document.getElementById('lightboxNextBtn');
    const backdrop = document.getElementById('lightboxBackdrop');

    let visibleCards = Array.from(cards);
    let activeIndex = 0;

    // Category Filter
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const filter = this.dataset.filter;

            visibleCards = [];
            cards.forEach(card => {
                const cat = card.dataset.category;
                if (filter === 'all' || cat === filter) {
                    card.style.display = 'flex';
                    visibleCards.push(card);
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    function showLightbox(index) {
        if (!visibleCards[index]) return;
        activeIndex = index;
        const card = visibleCards[index];
        lightboxImg.src = card.dataset.img;
        lightboxImg.alt = card.dataset.title;
        lightboxTitle.textContent = card.dataset.title;
        lightboxDesc.textContent = card.dataset.desc;
        lightbox.style.display = 'flex';
        lightbox.setAttribute('aria-hidden', 'false');
    }

    function closeLightbox() {
        lightbox.style.display = 'none';
        lightbox.setAttribute('aria-hidden', 'true');
    }

    cards.forEach(card => {
        card.addEventListener('click', function() {
            const idx = visibleCards.indexOf(this);
            if (idx !== -1) showLightbox(idx);
        });
    });

    if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
    if (backdrop) backdrop.addEventListener('click', closeLightbox);

    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (visibleCards.length === 0) return;
            activeIndex = (activeIndex - 1 + visibleCards.length) % visibleCards.length;
            showLightbox(activeIndex);
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (visibleCards.length === 0) return;
            activeIndex = (activeIndex + 1) % visibleCards.length;
            showLightbox(activeIndex);
        });
    }

    document.addEventListener('keydown', function(e) {
        if (lightbox && lightbox.style.display === 'flex') {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft' && prevBtn) prevBtn.click();
            if (e.key === 'ArrowRight' && nextBtn) nextBtn.click();
        }
    });
});
</script>
