<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileVisibilityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Pastikan komponen Mobile Bottom Dock Navigation dan elemen beranda muncul lengkap pada view.
     */
    public function test_mobile_bottom_dock_navigation_rendered(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);

        // Pastikan markup Mobile Bottom Dock ada di DOM
        $response->assertSee('class="mobile-bottom-dock"', false);
        $response->assertSee('id="mobileBottomDock"', false);
        $response->assertSee('data-section="beranda"', false);
        $response->assertSee('data-section="jenjang"', false);
        $response->assertSee('data-section="cabang"', false);
        $response->assertSee('data-section="berita"', false);
        $response->assertSee('data-section="ppdb"', false);
        $response->assertSee('mobile-dock-ppdb', false);
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
     * Pastikan file style.css dan scroll-reveal.js memiliki aturan visibilitas mobile.
     */
    public function test_mobile_css_and_reveal_rules_exist(): void
    {
        $css = file_get_contents(public_path('css/style.css'));
        $js = file_get_contents(public_path('js/scroll-reveal.js'));

        // CSS harus memastikan transisi cubic-bezier aktif pada mobile
        $this->assertStringContainsString('@media (max-width: 768px)', $css);
        $this->assertStringContainsString('.reveal {', $css);
        $this->assertStringContainsString('cubic-bezier(0.16, 1, 0.3, 1)', $css);

        // CSS harus memastikan .mobile-bottom-dock tampil di mobile
        $this->assertStringContainsString('.mobile-bottom-dock {', $css);
        $this->assertStringContainsString('display: block !important', $css);

        // JS scroll-reveal harus menjalankan Bidirectional Cubic-Bezier Engine pada mobile
        $this->assertStringContainsString('KHUSUS TAMPILAN HP (MOBILE <= 768px)', $js);
        $this->assertStringContainsString("start: 'top 92%'", $js);
        $this->assertStringContainsString("end: 'bottom top'", $js);

        // JS scroll-reveal harus mempertahankan Bidirectional Engine asli untuk tampilan PC / Desktop
        $this->assertStringContainsString("KHUSUS TAMPILAN PC (DESKTOP > 768px)", $js);
        $this->assertStringContainsString("onLeaveBack:", $js);
        $this->assertStringContainsString("start: 'top 88%'", $js);
        $this->assertStringContainsString("end: 'bottom 12%'", $js);
    }
}
