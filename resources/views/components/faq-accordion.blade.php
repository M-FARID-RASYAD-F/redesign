@props(['faqs' => []])

<div class="faq-accordion-section" id="faq-section">
    <div class="faq-container">
        
        <div class="faq-header">
            <span class="faq-tag">Pusat Bantuan &amp; Tanya Jawab</span>
            <h2 class="faq-title">Pertanyaan yang Sering Diajukan (FAQ)</h2>
            <p class="faq-desc">Temukan jawaban cepat atas pertanyaan seputar kurikulum tahfizh, legalitas ijazah, beasiswa, dan tata cara pendaftaran santri baru.</p>
            
            {{-- FAQ Live Search Bar --}}
            <div class="faq-search-box">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="faq-search-icon" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="faqSearchInput" placeholder="Cari pertanyaan... (contoh: beasiswa, ijazah, tes, antar-jemput)" class="faq-search-input" autocomplete="off">
            </div>
        </div>

        {{-- Category Filters --}}
        <div class="faq-filter-chips">
            <button type="button" class="faq-chip active" data-filter="all">Semua Topik</button>
            <button type="button" class="faq-chip" data-filter="Akademik">Akademik &amp; Ijazah</button>
            <button type="button" class="faq-chip" data-filter="Tahfizh">Target Tahfizh</button>
            <button type="button" class="faq-chip" data-filter="Beasiswa">Beasiswa</button>
            <button type="button" class="faq-chip" data-filter="Fasilitas">Asrama &amp; Boarding</button>
            <button type="button" class="faq-chip" data-filter="Seleksi">Alur Seleksi</button>
        </div>

        {{-- Accordion List --}}
        <div class="faq-list" id="faqAccordionList">
            @foreach($faqs as $idx => $f)
            <div class="faq-item" data-category="{{ $f['category'] ?? 'Umum' }}">
                <button type="button" class="faq-question-btn" aria-expanded="{{ $idx === 0 ? 'true' : 'false' }}" aria-controls="faq-ans-{{ $idx }}">
                    <span class="faq-q-text">
                        <span class="faq-badge-category">{{ $f['category'] ?? 'Umum' }}</span>
                        <strong class="faq-question-title">{{ $f['q'] }}</strong>
                    </span>
                    <span class="faq-chevron" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </span>
                </button>
                <div id="faq-ans-{{ $idx }}" class="faq-answer-panel {{ $idx === 0 ? 'show' : '' }}" role="region">
                    <div class="faq-answer-inner">
                        <p>{{ $f['a'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Empty state when search produces no matches --}}
        <div id="faqEmptySearch" class="faq-empty-state" style="display: none;">
            <p>Tidak menemukan jawaban yang sesuai dengan pencarian Anda.</p>
            <a href="https://wa.me/6281270001920?text=Halo%20Admin%20At-Tamam,%20saya%20ingin%20bertanya%20seputar%20sekolah%20dan%20PPDB" target="_blank" rel="noopener noreferrer" class="btn btn-outline" style="margin-top: 10px; display: inline-flex; align-items: center; gap: 8px;">
                <span>Tanyakan Langsung ke Panitia via WhatsApp &rarr;</span>
            </a>
        </div>

    </div>
</div>

<style>
.faq-accordion-section {
    padding: 30px 0 60px;
}

.faq-container {
    max-width: 900px;
    margin: 0 auto;
}

.faq-header {
    text-align: center;
    margin-bottom: 28px;
}

.faq-tag {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 9999px;
    background: rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.35);
    color: #34d399;
    font-size: 0.8rem;
    font-weight: 700;
    margin-bottom: 10px;
}

[data-theme="light"] .faq-tag {
    background: #dcfce7;
    border-color: #86efac;
    color: #059669;
}

.faq-title {
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    font-weight: 800;
    color: #ffffff;
    margin: 0 0 10px;
}

[data-theme="light"] .faq-title {
    color: #0f172a;
}

.faq-desc {
    font-size: 0.95rem;
    color: #cbd5e1;
    margin: 0 auto 24px;
    line-height: 1.6;
    max-width: 680px;
}

[data-theme="light"] .faq-desc {
    color: #64748b;
}

.faq-search-box {
    max-width: 520px;
    margin: 0 auto;
    position: relative;
    display: flex;
    align-items: center;
}

.faq-search-icon {
    position: absolute;
    left: 16px;
    color: #38bdf8;
    pointer-events: none;
}

[data-theme="light"] .faq-search-icon {
    color: #0284c7;
}

.faq-search-input {
    width: 100%;
    padding: 12px 18px 12px 46px;
    border-radius: 9999px;
    background: rgba(0, 33, 71, 0.7);
    border: 1px solid rgba(0, 180, 216, 0.35);
    color: #ffffff;
    font-size: 0.92rem;
    outline: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease;
}

[data-theme="light"] .faq-search-input {
    background: #ffffff;
    border-color: #cbd5e1;
    color: #0f172a;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.faq-search-input:focus {
    border-color: #00B4D8;
    box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.25);
}

.faq-filter-chips {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.faq-chip {
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.12);
    color: #cbd5e1;
    padding: 6px 14px;
    border-radius: 9999px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.faq-chip:hover {
    background: rgba(0, 180, 216, 0.15);
    border-color: #38bdf8;
    color: #ffffff;
}

.faq-chip.active {
    background: #00B4D8;
    border-color: #00B4D8;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 180, 216, 0.3);
}

[data-theme="light"] .faq-chip {
    background: #f1f5f9;
    border-color: #e2e8f0;
    color: #475569;
}

[data-theme="light"] .faq-chip.active {
    background: #0284c7;
    border-color: #0284c7;
    color: #ffffff;
}

.faq-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.faq-item {
    background: rgba(0, 33, 71, 0.65);
    border: 1px solid rgba(0, 180, 216, 0.25);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.25s ease;
}

[data-theme="light"] .faq-item {
    background: #ffffff;
    border-color: #e2e8f0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
}

.faq-item:hover {
    border-color: rgba(0, 180, 216, 0.5);
}

.faq-question-btn {
    width: 100%;
    padding: 18px 22px;
    background: transparent;
    border: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    text-align: left;
    cursor: pointer;
    color: inherit;
}

.faq-q-text {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.faq-badge-category {
    font-size: 0.72rem;
    font-weight: 700;
    color: #38bdf8;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

[data-theme="light"] .faq-badge-category {
    color: #0284c7;
}

.faq-question-title {
    font-size: 1.02rem;
    color: #ffffff;
    line-height: 1.4;
}

[data-theme="light"] .faq-question-title {
    color: #0f172a;
}

.faq-chevron {
    color: #94a3b8;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    flex-shrink: 0;
}

.faq-question-btn[aria-expanded="true"] .faq-chevron {
    transform: rotate(180deg);
    color: #38bdf8;
}

[data-theme="light"] .faq-question-btn[aria-expanded="true"] .faq-chevron {
    color: #0284c7;
}

.faq-answer-panel {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}

.faq-answer-panel.show {
    max-height: 400px;
}

.faq-answer-inner {
    padding: 0 22px 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.06);
    padding-top: 14px;
}

[data-theme="light"] .faq-answer-inner {
    border-top-color: #f1f5f9;
}

.faq-answer-inner p {
    margin: 0;
    font-size: 0.92rem;
    line-height: 1.7;
    color: #cbd5e1;
}

[data-theme="light"] .faq-answer-inner p {
    color: #475569;
}

.faq-empty-state {
    text-align: center;
    padding: 30px;
    background: rgba(255, 255, 255, 0.04);
    border-radius: 16px;
    color: #94a3b8;
    margin-top: 20px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('faqSearchInput');
    const filterChips = document.querySelectorAll('.faq-chip');
    const faqItems = document.querySelectorAll('.faq-item');
    const emptyState = document.getElementById('faqEmptySearch');

    let currentFilter = 'all';

    // Toggle accordion panels
    faqItems.forEach(item => {
        const btn = item.querySelector('.faq-question-btn');
        const panel = item.querySelector('.faq-answer-panel');

        btn.addEventListener('click', function() {
            const isExpanded = btn.getAttribute('aria-expanded') === 'true';
            
            // Close other panels
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.querySelector('.faq-question-btn').setAttribute('aria-expanded', 'false');
                    otherItem.querySelector('.faq-answer-panel').classList.remove('show');
                }
            });

            // Toggle current
            btn.setAttribute('aria-expanded', !isExpanded);
            panel.classList.toggle('show', !isExpanded);
        });
    });

    function applyFilterAndSearch() {
        const query = (searchInput ? searchInput.value : '').trim().toLowerCase();
        let visibleCount = 0;

        faqItems.forEach(item => {
            const cat = item.dataset.category || '';
            const text = item.textContent.toLowerCase();

            const matchesCategory = currentFilter === 'all' || cat.toLowerCase() === currentFilter.toLowerCase();
            const matchesQuery = !query || text.includes(query);

            if (matchesCategory && matchesQuery) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilterAndSearch);
    }

    filterChips.forEach(chip => {
        chip.addEventListener('click', function() {
            filterChips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            applyFilterAndSearch();
        });
    });
});
</script>
