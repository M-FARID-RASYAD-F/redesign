<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialsSectionRedesignTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test verification of redesigned testimonials section requirements
     */
    public function test_testimonials_section_meets_all_redesign_specifications(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();

        // 1. Eyebrow label removed, title stands alone
        $response->assertDontSee('KISAH SUKSES & KEPERCAYAAN WALI SANTRI');
        $response->assertDontSee('KISAH SUKSES &amp; KEPERCAYAAN WALI SANTRI', false);
        $response->assertSee('Apa Kata Mereka Tentang PKBM Tahfizh At-Tamam?');
        $response->assertSee('Mendengar langsung pengalaman wali santri dan alumni', false);

        // 2. Star ratings removed
        $response->assertDontSee('testimonial-stars');
        $response->assertDontSee('Rating 5 dari 5 bintang');

        // 3. Opening quotation marks (selang-seling teal & gold)
        $response->assertSee('testimonial-quote-mark');
        $response->assertSee('accent-teal');
        $response->assertSee('accent-gold');

        // 4. Duplicate green chip badge removed
        $response->assertDontSee('testimonial-badge');

        // 5. Authentic testimonials, names, and merged single-line role format preserved
        $response->assertSee('Ustadz H. Hendra Kurniawan, S.Pd.I');
        $response->assertSee('Muhammad Farhan Al-Fatih');
        $response->assertSee('Rizky Pratama');
        $response->assertSee('dr. Hj. Nurul Hidayah, Sp.A');

        $response->assertSee('Alumni Tahfizh 30 Juz, kini di Al-Azhar Kairo');
        $response->assertSee('Alumni SMK RPL, kini Software Engineer di Tech Studio');
        $response->assertSee('Wali Santri Boarding School, Dokter Spesialis Anak');
        $response->assertSee('Wali Santri SD Tahfizh, putra mutqin Juz 29 &amp; 30', false);

        // 6. Non-italic body styling class & quotes intact
        $response->assertSee('Alhamdulillah, dalam 2 tahun anak kami di SD At-Tamam');
        $response->assertSee('Kurikulum vokasi di SMK At-Tamam sangat aplikatif');

        // 7. Trust / legitimacy strip with 3 points
        $response->assertSee('testimonials-trust-strip');
        $response->assertSee('Status Terdaftar di Kementerian Agama RI');
        $response->assertSee('Izin Operasional PKBM Aktif');
        $response->assertSee('Kurikulum Terintegrasi Kemendikbudristek');

        // 8. CTAs at the bottom of section
        $response->assertSee('testimonials-cta');
        $response->assertSee('Daftar Santri Baru');
        $response->assertSee(route('ppdb.index'));
        $response->assertSee('Lihat kisah lainnya');
        $response->assertSee(route('berita.index'));
    }

    /**
     * Test verification of theme-based dual mode (Dark and Light) styling in testimonials section
     */
    public function test_testimonials_section_supports_dual_theme_dark_and_light_modes(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();

        // 1. Dark mode tokens configured
        $response->assertSee('--testi-title: #ffffff', false);
        $response->assertSee('--testi-subtitle: #94a3b8', false);
        $response->assertSee('--testi-quote: #f1f5f9', false);

        // 2. Light mode tokens configured
        $response->assertSee('[data-theme="light"] .testimonials-section', false);
        $response->assertSee('--testi-title: #ffffff', false);
        $response->assertSee('--testi-subtitle: #ffe4e6', false);
        $response->assertSee('--testi-quote: #ffffff', false);
        $response->assertSee('--testi-card-bg: oklch(22% 0.09 11 / 0.92)', false);

        // 3. No longer white washed out background in light mode
        $response->assertDontSee('[data-theme="light"] .testimonials-section {
    --testi-bg: #f8fafc;', false);

        // 4. Trust icons use currentColor for seamless theme adaptation
        $response->assertSee('stroke="currentColor"', false);

        // 5. Comprehensive direct light mode selectors for all testimonial sub-elements
        $response->assertSee('[data-theme="light"] .testimonial-card', false);
        $response->assertSee('[data-theme="light"] .testimonial-card.accent-teal', false);
        $response->assertSee('[data-theme="light"] .testimonial-card.accent-gold', false);
        $response->assertSee('[data-theme="light"] .testimonial-quote-mark.accent-teal', false);
        $response->assertSee('[data-theme="light"] .testimonial-quote-mark.accent-gold', false);
        $response->assertSee('[data-theme="light"] .testimonial-quote', false);
        $response->assertSee('[data-theme="light"] .testimonial-author', false);
        $response->assertSee('[data-theme="light"] .testimonial-avatar.accent-teal', false);
        $response->assertSee('[data-theme="light"] .testimonial-avatar.accent-gold', false);
        $response->assertSee('[data-theme="light"] .testimonial-name', false);
        $response->assertSee('[data-theme="light"] .testimonial-role', false);
        $response->assertSee('[data-theme="light"] .testimonials-trust-strip', false);
        $response->assertSee('[data-theme="light"] .trust-icon', false);
        $response->assertSee('[data-theme="light"] .trust-text', false);
        $response->assertSee('[data-theme="light"] .trust-divider', false);
        $response->assertSee('[data-theme="light"] .btn-testimonial-primary', false);
        $response->assertSee('[data-theme="light"] .btn-testimonial-secondary', false);
    }
}
