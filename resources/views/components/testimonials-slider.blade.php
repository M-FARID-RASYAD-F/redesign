@props(['testimonials' => []])

<section class="testimonials-section reveal" id="testimoni">
    <div class="testimonials-container">
        {{-- Section Header: Title without eyebrow tag, centered, balanced word-wrap --}}
        <div class="testimonials-header">
            <h2 class="testimonials-title">Apa Kata Mereka Tentang PKBM Tahfizh At-Tamam?</h2>
            <p class="testimonials-subtitle">Mendengar langsung pengalaman wali santri dan alumni yang merasakan keberkahan lingkungan belajar berakhlak Qurani dan berkompetensi digital.</p>
        </div>

        {{-- Testimonials Grid (4 cards on desktop, 2 on tablet, 1 on mobile) --}}
        <div class="testimonials-grid">
            @foreach($testimonials as $t)
                @php
                    $isTeal = ($loop->iteration % 2 === 1);
                    $accentClass = $isTeal ? 'accent-teal' : 'accent-gold';

                    // Parse/Normalize role format: [hubungan dengan lembaga], [pencapaian atau status terkini]
                    $roleText = $t['role'] ?? '';
                    if (str_contains($roleText, '—') && !empty($t['badge'])) {
                        $parts = explode('—', $roleText);
                        $status = trim($parts[1] ?? '');
                        $status = preg_replace('/^Mahasiswa /i', 'kini di ', $status);
                        $roleText = $t['badge'] . ', ' . $status;
                    }
                @endphp
                <div class="testimonial-card {{ $accentClass }}">
                    {{-- Large Serif Quotation Mark (Selang-seling Teal & Gold) --}}
                    <div class="testimonial-quote-mark {{ $accentClass }}" aria-hidden="true">&ldquo;</div>

                    {{-- Quote Content (Normal Non-Italic Body) --}}
                    <p class="testimonial-quote">
                        {{ $t['quote'] }}
                    </p>

                    {{-- Author Meta --}}
                    <div class="testimonial-author">
                        <div class="testimonial-avatar {{ $accentClass }}" aria-hidden="true">
                            <span>{{ $t['avatar_initials'] ?? 'AT' }}</span>
                        </div>
                        <div class="testimonial-info">
                            <h4 class="testimonial-name">{{ $t['name'] }}</h4>
                            <span class="testimonial-role">{{ $roleText }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Strip Kepercayaan / Legalitas (3 poin dengan ikon centang) --}}
        <div class="testimonials-trust-strip">
            <div class="trust-item">
                <span class="trust-icon" aria-hidden="true">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
                <span class="trust-text">Status Terdaftar di Kementerian Agama RI</span>
            </div>
            <div class="trust-divider" aria-hidden="true"></div>
            <div class="trust-item">
                <span class="trust-icon" aria-hidden="true">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
                <span class="trust-text">Izin Operasional PKBM Aktif</span>
            </div>
            <div class="trust-divider" aria-hidden="true"></div>
            <div class="trust-item">
                <span class="trust-icon" aria-hidden="true">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </span>
                <span class="trust-text">Kurikulum Terintegrasi Kemendikbudristek</span>
            </div>
        </div>

        {{-- CTA Bottom Action Buttons --}}
        <div class="testimonials-cta">
            <a href="{{ route('ppdb.index') }}" class="btn-testimonial-primary">
                <span>Daftar Santri Baru</span>
            </a>
            <a href="{{ route('berita.index') }}" class="btn-testimonial-secondary">
                <span>Lihat kisah lainnya</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>
    </div>
</section>

<style>
/* ═══════════════════════════════════════════════════════════
   TESTIMONIALS SECTION - THEME & DUAL MODE (DARK & LIGHT)
   ═══════════════════════════════════════════════════════════ */
.testimonials-section {
    /* ── Dark Mode Tokens (Default) ── */
    --testi-bg: rgba(0, 21, 41, 0.72);
    --testi-bg-gradient: radial-gradient(ellipse 80% 360px at 50% 0%, rgba(0, 180, 216, 0.12) 0%, rgba(0, 21, 41, 0.75) 100%);
    --testi-border: rgba(0, 180, 216, 0.25);
    --testi-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.45);
    --testi-title: #ffffff;
    --testi-subtitle: #94a3b8;

    --testi-card-bg: rgba(0, 33, 71, 0.7);
    --testi-card-border: rgba(0, 180, 216, 0.22);
    --testi-card-border-hover: #00B4D8;
    --testi-card-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    --testi-card-shadow-hover: 0 16px 36px rgba(0, 0, 0, 0.45), 0 0 20px rgba(0, 180, 216, 0.2);

    --testi-quote: #f1f5f9;
    --testi-author-border: rgba(255, 255, 255, 0.08);
    --testi-name: #ffffff;
    --testi-role: #94a3b8;

    --testi-teal: #00B4D8;
    --testi-teal-bg: rgba(0, 180, 216, 0.14);
    --testi-teal-border: rgba(0, 180, 216, 0.35);

    --testi-gold: #f59e0b;
    --testi-gold-bg: rgba(245, 158, 11, 0.14);
    --testi-gold-border: rgba(245, 158, 11, 0.35);

    --testi-trust-bg: rgba(0, 33, 71, 0.55);
    --testi-trust-border: rgba(0, 180, 216, 0.2);
    --testi-trust-text: #f1f5f9;
    --testi-trust-icon-bg: rgba(0, 180, 216, 0.15);
    --testi-trust-icon-color: #00B4D8;
    --testi-trust-divider: rgba(255, 255, 255, 0.12);

    --testi-btn-primary-bg: linear-gradient(135deg, #00B4D8 0%, #0077b6 100%);
    --testi-btn-primary-hover-bg: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
    --testi-btn-primary-color: #ffffff;
    --testi-btn-primary-shadow: 0 4px 14px rgba(0, 180, 216, 0.35);

    --testi-btn-secondary-color: #94a3b8;
    --testi-btn-secondary-hover: #38bdf8;

    position: relative;
    background-color: var(--testi-bg);
    background-image: var(--testi-bg-gradient);
    border: 1px solid var(--testi-border);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border-radius: 20px;
    padding: 64px 32px 56px;
    margin: 40px auto 70px;
    max-width: 1200px;
    width: calc(100% - 3rem);
    box-sizing: border-box;
    overflow: hidden;
    box-shadow: var(--testi-shadow);
    transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}

/* ── Light Mode Tokens (data-theme="light") ── */
[data-theme="light"] .testimonials-section {
    --testi-bg: oklch(27.1% 0.105 12.094 / 0.94);
    --testi-bg-gradient: radial-gradient(ellipse 80% 360px at 50% 0%, oklch(34% 0.13 13 / 0.5) 0%, oklch(24% 0.095 11.5 / 0.98) 100%);
    --testi-border: oklch(58.6% 0.253 17.585 / 0.35);
    --testi-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.45), 0 0 35px oklch(58.6% 0.253 17.585 / 0.2);
    --testi-title: #ffffff;
    --testi-subtitle: #ffe4e6;

    --testi-card-bg: oklch(22% 0.09 11 / 0.92);
    --testi-card-border: oklch(58.6% 0.253 17.585 / 0.3);
    --testi-card-border-hover: oklch(58.6% 0.253 17.585);
    --testi-card-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    --testi-card-shadow-hover: 0 16px 36px rgba(0, 0, 0, 0.5), 0 0 24px oklch(58.6% 0.253 17.585 / 0.35);

    --testi-quote: #ffffff;
    --testi-author-border: rgba(255, 255, 255, 0.12);
    --testi-name: #ffffff;
    --testi-role: #fda4af;

    --testi-teal: oklch(75% 0.18 18);
    --testi-teal-bg: oklch(58.6% 0.253 17.585 / 0.25);
    --testi-teal-border: oklch(58.6% 0.253 17.585 / 0.5);

    --testi-gold: #f59e0b;
    --testi-gold-bg: rgba(245, 158, 11, 0.18);
    --testi-gold-border: rgba(245, 158, 11, 0.45);

    --testi-trust-bg: oklch(20% 0.08 11 / 0.85);
    --testi-trust-border: oklch(58.6% 0.253 17.585 / 0.35);
    --testi-trust-text: #ffffff;
    --testi-trust-icon-bg: oklch(58.6% 0.253 17.585 / 0.25);
    --testi-trust-icon-color: oklch(75% 0.18 18);
    --testi-trust-divider: oklch(58.6% 0.253 17.585 / 0.3);

    --testi-btn-primary-bg: linear-gradient(135deg, oklch(58.6% 0.253 17.585) 0%, oklch(48% 0.22 17) 100%);
    --testi-btn-primary-hover-bg: linear-gradient(135deg, oklch(65% 0.25 18) 0%, oklch(55% 0.23 17) 100%);
    --testi-btn-primary-color: #ffffff;
    --testi-btn-primary-shadow: 0 4px 18px oklch(58.6% 0.253 17.585 / 0.45);

    --testi-btn-secondary-color: #ffe4e6;
    --testi-btn-secondary-hover: #ffffff;

    background-color: var(--testi-bg);
    background-image: var(--testi-bg-gradient);
    border: 1px solid var(--testi-border);
    box-shadow: var(--testi-shadow);
}

[data-theme="light"] .testimonials-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #be123c 0%, #e11d48 50%, #f43f5e 100%);
    background: linear-gradient(90deg, oklch(41% 0.159 10.272) 0%, oklch(58.6% 0.253 17.585) 100%);
    border-radius: 20px 20px 0 0;
}

.testimonials-container {
    width: 100%;
    margin: 0 auto;
}

/* Header */
.testimonials-header {
    text-align: center;
    margin-bottom: 44px;
}

.testimonials-title {
    font-family: var(--font-display, 'Playfair Display', Georgia, serif);
    font-size: clamp(1.85rem, 3.2vw, 2.35rem);
    font-weight: 700;
    color: var(--testi-title);
    margin: 0 auto 14px;
    max-width: 680px;
    line-height: 1.3;
    text-wrap: balance;
    transition: color 0.3s ease;
}

[data-theme="light"] .testimonials-title {
    color: #ffffff;
}

.testimonials-subtitle {
    font-family: var(--font-family, 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif);
    font-size: 0.98rem;
    line-height: 1.65;
    color: var(--testi-subtitle);
    margin: 0 auto;
    max-width: 620px;
    text-wrap: balance;
    transition: color 0.3s ease;
}

[data-theme="light"] .testimonials-subtitle {
    color: #ffe4e6;
}

/* Grid Layout */
.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 36px;
}

/* Testimonial Card */
.testimonial-card {
    background-color: var(--testi-card-bg);
    border: 1px solid var(--testi-card-border);
    border-radius: 14px;
    padding: 26px 22px 22px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: var(--testi-card-shadow);
    transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1), 
                border-color 0.22s ease, 
                box-shadow 0.22s ease, 
                background-color 0.3s ease;
    position: relative;
    box-sizing: border-box;
}

.testimonial-card.accent-teal {
    border-top: 3px solid rgba(0, 180, 216, 0.85);
}

.testimonial-card.accent-gold {
    border-top: 3px solid rgba(245, 158, 11, 0.85);
}

.testimonial-card:hover {
    border-color: var(--testi-card-border-hover);
    box-shadow: var(--testi-card-shadow-hover);
    transform: translateY(-5px);
}

/* Light Mode Overrides for Cards */
[data-theme="light"] .testimonial-card {
    background-color: oklch(22% 0.09 11 / 0.92);
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.3);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
}

[data-theme="light"] .testimonial-card.accent-teal {
    border-top: 3px solid oklch(58.6% 0.253 17.585);
}

[data-theme="light"] .testimonial-card.accent-gold {
    border-top: 3px solid #f59e0b;
}

[data-theme="light"] .testimonial-card:hover {
    border-color: oklch(58.6% 0.253 17.585);
    transform: translateY(-5px);
}

[data-theme="light"] .testimonial-card.accent-teal:hover {
    border-color: oklch(58.6% 0.253 17.585);
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5), 0 0 24px oklch(58.6% 0.253 17.585 / 0.4);
}

[data-theme="light"] .testimonial-card.accent-gold:hover {
    border-color: #f59e0b;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.5), 0 0 24px rgba(245, 158, 11, 0.4);
}

/* Opening Serif Quote Mark (Alternating Teal & Gold) */
.testimonial-quote-mark {
    font-family: var(--font-display, 'Playfair Display', Georgia, serif);
    font-size: 3.5rem;
    font-weight: 700;
    line-height: 0.7;
    height: 32px;
    margin-bottom: 14px;
    user-select: none;
    display: inline-block;
    transition: color 0.3s ease;
}

.testimonial-quote-mark.accent-teal {
    color: var(--testi-teal);
}

.testimonial-quote-mark.accent-gold {
    color: var(--testi-gold);
}

[data-theme="light"] .testimonial-quote-mark.accent-teal {
    color: oklch(75% 0.18 18);
    opacity: 1;
}

[data-theme="light"] .testimonial-quote-mark.accent-gold {
    color: #f59e0b;
    opacity: 1;
}

/* Quote Body */
.testimonial-quote {
    font-family: var(--font-family, 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif);
    font-size: 0.92rem;
    line-height: 1.68;
    color: var(--testi-quote);
    font-style: normal;
    margin: 0 0 22px 0;
    flex: 1;
    transition: color 0.3s ease;
}

[data-theme="light"] .testimonial-quote {
    color: #ffffff;
    line-height: 1.7;
}

/* Author Meta */
.testimonial-author {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-top: 16px;
    margin-top: auto;
    border-top: 1px solid var(--testi-author-border);
    transition: border-color 0.3s ease;
}

[data-theme="light"] .testimonial-author {
    border-top-color: rgba(255, 255, 255, 0.12);
}

.testimonial-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-family, 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif);
    font-weight: 700;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    flex-shrink: 0;
    border: 1px solid transparent;
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}

.testimonial-avatar.accent-teal {
    border-color: var(--testi-teal-border);
    color: var(--testi-teal);
    background: var(--testi-teal-bg);
}

.testimonial-avatar.accent-gold {
    border-color: var(--testi-gold-border);
    color: var(--testi-gold);
    background: var(--testi-gold-bg);
}

[data-theme="light"] .testimonial-avatar.accent-teal {
    border: 1.5px solid oklch(58.6% 0.253 17.585 / 0.5);
    color: oklch(75% 0.18 18);
    background: oklch(58.6% 0.253 17.585 / 0.25);
}

[data-theme="light"] .testimonial-avatar.accent-gold {
    border: 1.5px solid rgba(245, 158, 11, 0.45);
    color: #fbbf24;
    background: rgba(245, 158, 11, 0.18);
}

.testimonial-info {
    display: flex;
    flex-direction: column;
    gap: 3px;
    min-width: 0;
}

.testimonial-name {
    font-family: var(--font-family, 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif);
    font-size: 0.92rem;
    font-weight: 700;
    color: var(--testi-name);
    margin: 0;
    line-height: 1.35;
    transition: color 0.3s ease;
}

[data-theme="light"] .testimonial-name {
    color: #ffffff;
}

.testimonial-role {
    font-family: var(--font-family, 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif);
    font-size: 0.78rem;
    color: var(--testi-role);
    line-height: 1.4;
    white-space: normal;
    transition: color 0.3s ease;
}

[data-theme="light"] .testimonial-role {
    color: #fda4af;
}

/* Trust / Legitimacy Strip */
.testimonials-trust-strip {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 24px;
    background-color: var(--testi-trust-bg);
    border: 1px solid var(--testi-trust-border);
    border-radius: 10px;
    padding: 14px 24px;
    margin: 0 auto 36px;
    max-width: 960px;
    box-sizing: border-box;
    transition: background-color 0.3s ease, border-color 0.3s ease;
}

[data-theme="light"] .testimonials-trust-strip {
    background-color: oklch(20% 0.08 11 / 0.85);
    border: 1px solid oklch(58.6% 0.253 17.585 / 0.35);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
}

.trust-item {
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.trust-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: var(--testi-trust-icon-bg);
    color: var(--testi-trust-icon-color);
    flex-shrink: 0;
    transition: background-color 0.3s ease, color 0.3s ease;
}

[data-theme="light"] .trust-icon {
    background-color: oklch(58.6% 0.253 17.585 / 0.25);
    color: oklch(75% 0.18 18);
}

.trust-text {
    font-family: var(--font-family, 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif);
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--testi-trust-text);
    letter-spacing: 0.2px;
    transition: color 0.3s ease;
}

[data-theme="light"] .trust-text {
    color: #ffffff;
}

.trust-divider {
    width: 1px;
    height: 16px;
    background-color: var(--testi-trust-divider);
    transition: background-color 0.3s ease;
}

[data-theme="light"] .trust-divider {
    background-color: oklch(58.6% 0.253 17.585 / 0.3);
}

/* Bottom CTA Actions */
.testimonials-cta {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 8px;
}

.btn-testimonial-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: var(--testi-btn-primary-bg);
    color: var(--testi-btn-primary-color);
    font-family: var(--font-family, 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif);
    font-size: 0.95rem;
    font-weight: 700;
    padding: 12px 28px;
    border-radius: 8px;
    text-decoration: none;
    transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease, color 0.2s ease;
    border: none;
    line-height: 1.4;
    box-shadow: var(--testi-btn-primary-shadow);
}

.btn-testimonial-primary:hover {
    background: var(--testi-btn-primary-hover-bg);
    color: var(--testi-btn-primary-color);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 180, 216, 0.45);
}

[data-theme="light"] .btn-testimonial-primary {
    background: linear-gradient(135deg, oklch(58.6% 0.253 17.585) 0%, oklch(48% 0.22 17) 100%);
    color: #ffffff;
    box-shadow: 0 4px 18px oklch(58.6% 0.253 17.585 / 0.45);
}

[data-theme="light"] .btn-testimonial-primary:hover {
    background: linear-gradient(135deg, oklch(65% 0.25 18) 0%, oklch(55% 0.23 17) 100%);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 24px oklch(58.6% 0.253 17.585 / 0.6);
}

.btn-testimonial-secondary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--testi-btn-secondary-color);
    font-family: var(--font-family, 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif);
    font-size: 0.92rem;
    font-weight: 600;
    text-decoration: none;
    padding: 12px 14px;
    transition: color 0.2s ease, transform 0.2s ease;
    line-height: 1.4;
}

.btn-testimonial-secondary:hover {
    color: var(--testi-btn-secondary-hover);
    transform: translateX(3px);
}

[data-theme="light"] .btn-testimonial-secondary {
    color: #ffe4e6;
}

[data-theme="light"] .btn-testimonial-secondary:hover {
    color: #ffffff;
}

/* ═══════════════════════════════════════════════════════════
   RESPONSIVE MEDIA QUERIES
   ═══════════════════════════════════════════════════════════ */
@media (max-width: 1024px) {
    .testimonials-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }
}

@media (max-width: 860px) {
    .testimonials-trust-strip {
        gap: 14px;
        padding: 16px 20px;
    }
    .trust-divider {
        display: none;
    }
}

@media (max-width: 768px) {
    .testimonials-section {
        width: calc(100% - 2rem);
        padding: 40px 18px 36px;
        margin-bottom: 3.5rem;
        border-radius: 14px;
    }
}

@media (max-width: 640px) {
    .testimonials-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
}

@media (max-width: 580px) {
    .testimonials-trust-strip {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}
</style>
