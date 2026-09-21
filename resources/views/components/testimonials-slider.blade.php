@props(['testimonials' => []])

<section class="testimonials-section reveal" id="testimoni">
    <x-section-header 
        tag="KISAH SUKSES & KEPERCAYAAN WALI SANTRI" 
        title="Apa Kata Mereka Tentang PKBM Tahfizh At-Tamam?" 
        subtitle="Mendengar langsung pengalaman wali santri dan alumni yang merasakan keberkahan lingkungan belajar berakhlak Qurani dan berkompetensi digital."
    />

    <div class="testimonials-grid">
        @foreach($testimonials as $t)
        <div class="testimonial-card">
            {{-- Star Rating --}}
            <div class="testimonial-stars" aria-label="Rating 5 dari 5 bintang">
                @for($i = 0; $i < ($t['rating'] ?? 5); $i++)
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#fbbf24" stroke="none" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                @endfor
            </div>

            {{-- Quote Content --}}
            <blockquote class="testimonial-quote">
                &ldquo;{{ $t['quote'] }}&rdquo;
            </blockquote>

            {{-- Author Meta --}}
            <div class="testimonial-author">
                <div class="testimonial-avatar">
                    <span>{{ $t['avatar_initials'] ?? 'AT' }}</span>
                </div>
                <div class="testimonial-info">
                    <h4 class="testimonial-name">{{ $t['name'] }}</h4>
                    <span class="testimonial-role">{{ $t['role'] }}</span>
                    @if(!empty($t['badge']))
                    <span class="testimonial-badge">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>{{ $t['badge'] }}</span>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<style>
.testimonials-section {
    margin: 60px 0 80px;
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-top: 36px;
}

.testimonial-card {
    background: rgba(0, 33, 71, 0.7);
    border: 1px solid rgba(0, 180, 216, 0.28);
    border-radius: 20px;
    padding: 28px 24px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
}

[data-theme="light"] .testimonial-card {
    background: #ffffff;
    border-color: #e2e8f0;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

.testimonial-card:hover {
    transform: translateY(-5px);
    border-color: #00B4D8;
    box-shadow: 0 20px 45px rgba(0, 0, 0, 0.45);
}

.testimonial-stars {
    display: flex;
    gap: 3px;
    margin-bottom: 16px;
}

.testimonial-quote {
    margin: 0 0 22px 0;
    font-size: 0.95rem;
    line-height: 1.65;
    color: #f1f5f9;
    font-style: italic;
    flex: 1;
}

[data-theme="light"] .testimonial-quote {
    color: #334155;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 14px;
    padding-top: 18px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

[data-theme="light"] .testimonial-author {
    border-top-color: #f1f5f9;
}

.testimonial-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00B4D8, #0077b6);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.95rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0, 180, 216, 0.3);
}

[data-theme="light"] .testimonial-avatar {
    background: linear-gradient(135deg, #0284c7, #0369a1);
}

.testimonial-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
}

.testimonial-name {
    font-size: 0.98rem;
    font-weight: 800;
    color: #ffffff;
    margin: 0;
    line-height: 1.3;
}

[data-theme="light"] .testimonial-name {
    color: #0f172a;
}

.testimonial-role {
    font-size: 0.78rem;
    color: #94a3b8;
    line-height: 1.3;
}

[data-theme="light"] .testimonial-role {
    color: #64748b;
}

.testimonial-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 0.7rem;
    font-weight: 700;
    color: #34d399;
    margin-top: 4px;
}
</style>
