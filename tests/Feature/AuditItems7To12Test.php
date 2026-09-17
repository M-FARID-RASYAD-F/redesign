<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditItems7To12Test extends TestCase
{
    use RefreshDatabase;

    /**
     * Item 7: Ketergantungan Gambar Eksternal Tanpa Fallback (Aset lokal & onerror fallback)
     */
    public function test_item_7_external_images_replaced_with_local_and_fallback_present(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
        $content = $response->getContent();

        // Tidak ada lagi dependensi ke images.unsplash.com di homepage
        $this->assertStringNotContainsString('images.unsplash.com', $content);

        // Komponen tab memiliki atribut onerror fallback ke sch1.jpeg lokal
        $this->assertStringContainsString('onerror="this.onerror=null; this.src=\'' . asset('images/sch1.jpeg') . '\';"', $content);

        // Cek file komponen animated-tabs dan card
        $tabsBlade = file_get_contents(resource_path('views/components/animated-tabs.blade.php'));
        $this->assertStringNotContainsString('images.unsplash.com', $tabsBlade);
        $this->assertStringContainsString("asset('images/sch1.jpeg')", $tabsBlade);

        $cardBlade = file_get_contents(resource_path('views/components/card.blade.php'));
        $this->assertStringContainsString("onerror=\"this.onerror=null; this.src='{{ asset('images/sch1.jpeg') }}';\"", $cardBlade);
    }

    /**
     * Item 8: Grid Tab Cabang Sekolah Timpang pada Mobile (Flex horizontal scroll)
     */
    public function test_item_8_branch_tab_grid_on_mobile_is_responsive_flex_scroll(): void
    {
        $cssContent = file_get_contents(public_path('css/style.css'));

        // Cek bahwa rule tab-nav-bar pada mobile menggunakan flex scroll, bukan grid 2-kolom yang timpang
        $this->assertStringContainsString('.tab-nav-bar {', $cssContent);
        $this->assertStringContainsString('overflow-x: auto !important;', $cssContent);
        $this->assertStringContainsString('scroll-snap-type: x mandatory;', $cssContent);
        $this->assertStringContainsString('-webkit-overflow-scrolling: touch;', $cssContent);
        $this->assertStringNotContainsString('grid-template-columns: repeat(2, 1fr) !important;', $cssContent);
    }

    /**
     * Item 9: Tipografi Sub-12px & Kontras Rendah Neumorphism (Font >= 0.82rem & saturasi warna)
     */
    public function test_item_9_neumorphism_card_typography_meets_minimum_12px_and_contrast(): void
    {
        $cssContent = file_get_contents(public_path('css/style.css'));

        // Pastikan typography pada kartu jenjang (.pc-12) dinaikkan ke minimal 0.82rem (~13.1px) dan warna kontras tinggi
        $this->assertStringContainsString(".pc-12__stat span {\n  font-size: 0.82rem;\n  font-weight: 600;\n  color: #7dd3fc;", $cssContent);
        $this->assertStringContainsString(".pc-12__prospek-label {\n  display: block;\n  font-weight: 700;\n  color: #00B4D8;\n  margin-bottom: 4px;\n  font-size: 0.82rem;", $cssContent);
        $this->assertStringContainsString(".pc-12__prospek-val {\n  color: #e2e8f0;\n  display: block;\n  font-size: 0.82rem;", $cssContent);
    }

    /**
     * Item 10: Data Kontak Dummy Tidak Konsisten (Tersentralisasi di config/school.php)
     */
    public function test_item_10_contact_data_is_centralized_in_config_and_consistent(): void
    {
        // 1. Config school tersedia dengan nilai resmi Pekanbaru
        $this->assertEquals('(0761) 555-0192', config('school.phone'));
        $this->assertEquals('081270001920', config('school.whatsapp'));
        $this->assertEquals('0812-7000-1920', config('school.whatsapp_formatted'));
        $this->assertEquals('https://wa.me/6281270001920', config('school.whatsapp_url'));

        // 2. Footer menggunakan config resmi
        $footerBlade = file_get_contents(resource_path('views/partials/footer.blade.php'));
        $this->assertStringNotContainsString('6281200000000', $footerBlade);
        $this->assertStringContainsString("config('school.whatsapp_url'", $footerBlade);

        // 3. Floating WA button menggunakan config resmi
        $waBlade = file_get_contents(resource_path('views/partials/whatsapp-button.blade.php'));
        $this->assertStringNotContainsString('6281200000000', $waBlade);
        $this->assertStringContainsString("config('school.whatsapp_url'", $waBlade);

        // 4. PPDB Success page menggunakan config resmi (tidak lagi kode area 021 Jakarta atau nomor dummy)
        $successBlade = file_get_contents(resource_path('views/ppdb/success.blade.php'));
        $this->assertStringNotContainsString('(021) 555-0192', $successBlade);
        $this->assertStringNotContainsString('0812-0000-0000', $successBlade);
        $this->assertStringContainsString("config('school.phone'", $successBlade);
        $this->assertStringContainsString("config('school.whatsapp_formatted'", $successBlade);
    }

    /**
     * Item 11: Tabel Admin PPDB: Ketiadaan Swipe Hint di Layar Mobile
     */
    public function test_item_11_ppdb_admin_table_has_swipe_hint_and_fade_shadow_on_mobile(): void
    {
        $adminView = file_get_contents(resource_path('views/admin/ppdb/index.blade.php'));

        // Fade shadow kanan pada pembungkus tabel
        $this->assertStringContainsString('box-shadow: inset -14px 0 12px -8px rgba(0, 0, 0, 0.45);', $adminView);

        // Komponen petunjuk swipe untuk mobile
        $this->assertStringContainsString('.ppdb-swipe-hint {', $adminView);
        $this->assertStringContainsString('Geser tabel ke kanan untuk melihat kolom aksi', $adminView);
    }

    /**
     * Item 12: Inkonsistensi Karakter Emoji Mentah sebagai Ikon UI (Ganti dengan SVG terstandarisasi)
     */
    public function test_item_12_raw_emojis_replaced_with_svg_vector_icons(): void
    {
        $showBlade = file_get_contents(resource_path('views/news/show.blade.php'));
        $indexBlade = file_get_contents(resource_path('views/news/index.blade.php'));

        // News show tidak lagi memiliki emoji mentah
        $this->assertStringNotContainsString('📅', $showBlade);
        $this->assertStringNotContainsString('✍️', $showBlade);
        $this->assertStringNotContainsString('⏱️', $showBlade);
        $this->assertStringNotContainsString('📰', $showBlade);

        // News index tidak lagi memiliki emoji mentah
        $this->assertStringNotContainsString('⭐', $indexBlade);
        $this->assertStringNotContainsString('📰', $indexBlade);

        // Pastikan SVG icons hadir menggantikannya
        $this->assertStringContainsString('<svg width="15" height="15" viewBox="0 0 24 24"', $showBlade);
        $this->assertStringContainsString('<svg width="20" height="20" viewBox="0 0 24 24"', $showBlade);
    }
}
