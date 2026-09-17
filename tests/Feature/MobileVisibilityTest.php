<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileVisibilityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Pastikan navigasi bottom dock dihilangkan dari DOM sesuai permintaan user.
     */
    public function test_mobile_bottom_dock_navigation_removed(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);

        // Pastikan markup Mobile Bottom Dock benar-benar dihilangkan dari DOM
        $response->assertDontSee('class="mobile-bottom-dock"', false);
        $response->assertDontSee('id="mobileBottomDock"', false);
    }

    /**
     * Pastikan fallback gambar lokal (onerror) tersedia pada animated tabs dan kartu berita.
     */
    public function test_image_onerror_fallbacks_present(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);

        // Cek onerror pada gambar tab fasilitas / cabang
        $response->assertSee('onerror="this.onerror=null; this.src=\'' . asset('images/sch1.jpeg') . '\';"', false);
    }

    /**
     * Pastikan file style.css dan scroll-reveal.js memiliki aturan visibilitas mobile & PC terpisah.
     */
    public function test_mobile_css_and_reveal_rules_exist(): void
    {
        $css = file_get_contents(public_path('css/style.css'));
        $js = file_get_contents(public_path('js/scroll-reveal.js'));

        // CSS harus memastikan transisi cubic-bezier aktif pada mobile
        $this->assertStringContainsString('@media (max-width: 768px)', $css);
        $this->assertStringContainsString('.reveal {', $css);
        $this->assertStringContainsString('cubic-bezier(0.16, 1, 0.3, 1)', $css);

        // JS scroll-reveal harus menjalankan engine scroll biasa pada mobile tanpa perlu refresh manual
        $this->assertStringContainsString('KHUSUS TAMPILAN HP (MOBILE <= 768px)', $js);
        $this->assertStringContainsString('IntersectionObserver', $js);
        $this->assertStringContainsString('updateMobileReveals', $js);
        $this->assertStringContainsString('onMobileScroll', $js);

        // JS scroll-reveal harus mempertahankan 100% Bidirectional Engine asli untuk tampilan PC / Desktop
        $this->assertStringContainsString("KHUSUS TAMPILAN PC (DESKTOP > 768px)", $js);
        $this->assertStringContainsString("onLeaveBack:", $js);
        $this->assertStringContainsString("start: 'top 88%'", $js);
        $this->assertStringContainsString("end: 'bottom 12%'", $js);
    }
}
