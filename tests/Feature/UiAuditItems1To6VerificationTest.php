<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UiAuditItems1To6VerificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Item 1: PPDB Client-side Step Validation on Multi-step Wizard
     */
    public function test_item_1_ppdb_form_contains_client_side_validation_and_guards(): void
    {
        $response = $this->get(route('ppdb.create'));

        $response->assertOk();
        $content = $response->getContent();

        // Validasi JavaScript functions exist
        $this->assertStringContainsString('function validateStep(step)', $content);
        $this->assertStringContainsString('function clearFieldErrors(container)', $content);
        $this->assertStringContainsString('function markInvalid(input, message)', $content);

        // Guard on submit exists
        $this->assertStringContainsString("form.addEventListener('submit', function (e)", $content);
        $this->assertStringContainsString('validateStep(1)', $content);
        $this->assertStringContainsString('validateStep(2)', $content);
        $this->assertStringContainsString('validateStep(3)', $content);

        // Navigation button hooks exist
        $this->assertStringContainsString('onclick="nextSlide(2)"', $content);
        $this->assertStringContainsString('onclick="nextSlide(3)"', $content);

        // Required field validation targets exist
        $this->assertStringContainsString('id="full_name"', $content);
        $this->assertStringContainsString('id="gender"', $content);
        $this->assertStringContainsString('id="birth_date"', $content);
        $this->assertStringContainsString('id="address"', $content);
        $this->assertStringContainsString('id="parent_phone"', $content);
        $this->assertStringContainsString('id="doc_kk"', $content);
        $this->assertStringContainsString('id="agreement"', $content);
    }

    /**
     * Item 2: Mobile Login Layout & iOS Safari Auto-Zoom Prevention
     */
    public function test_item_2_login_mobile_layout_and_ios_zoom_prevention(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $content = $response->getContent();

        // Anti auto-zoom 16px rule present for mobile
        $this->assertStringContainsString('font-size: 16px !important; /* Anti iOS Safari auto-zoom */', $content);

        // Container min-height optimized for mobile keyboard
        $this->assertStringContainsString('min-height: 680px;', $content);
        $this->assertStringContainsString('min-height: 750px;', $content);
    }

    /**
     * Item 3: Dead Social Logins Removed and Replaced with Official Helpdesk Notice
     */
    public function test_item_3_dead_social_logins_removed_and_replaced_with_helpdesk(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $content = $response->getContent();

        // Dead social platform texts removed
        $this->assertStringNotContainsString('Or sign in with social platforms', $content);
        $this->assertStringNotContainsString('Or sign up with social platforms', $content);

        // Official WhatsApp Helpdesk notice present
        $this->assertStringContainsString('auth-help-notice', $content);
        $this->assertStringContainsString('WhatsApp Helpdesk', $content);
        $this->assertStringContainsString('https://wa.me/6281270001920', $content);
    }

    /**
     * Item 4: Floating WhatsApp & Back to Top Buttons + Phantom 88px Bottom Gap Eliminated
     */
    public function test_item_4_floating_buttons_and_bottom_gap_eliminated(): void
    {
        $cssContent = file_get_contents(public_path('css/style.css'));
        $waBladeContent = file_get_contents(resource_path('views/partials/whatsapp-button.blade.php'));

        // Mobile body no longer has padding-bottom: calc(76px + ...)
        $this->assertStringNotContainsString('padding-bottom: calc(76px +', $cssContent);

        // Floating buttons bottom adjusted to 16px safe-area (no 76px offset)
        $this->assertStringContainsString('.floating-back-to-top {', $cssContent);
        $this->assertStringContainsString('bottom: calc(16px + max(0px, env(safe-area-inset-bottom, 0px)));', $cssContent);

        $this->assertStringContainsString('.floating-wa-wrapper {', $waBladeContent);
        $this->assertStringContainsString('bottom: calc(16px + max(0px, env(safe-area-inset-bottom, 0px)));', $waBladeContent);
        $this->assertStringNotContainsString('bottom: calc(76px +', $waBladeContent);
    }

    /**
     * Item 5: Dual Theme Engine Card Clash Fix
     */
    public function test_item_5_dual_theme_card_clash_fix(): void
    {
        $cssContent = file_get_contents(public_path('css/style.css'));

        // CSS Variables defined for both root and light theme
        $this->assertStringContainsString('--card-bg: rgba(0, 33, 71, 0.85);', $cssContent);
        $this->assertStringContainsString('--card-bg: oklch(27.1% 0.105 12.094 / 0.94);', $cssContent);

        // Detail News has matching light theme overrides
        $author = User::factory()->create(['role' => 'admin_cms']);
        $category = NewsCategory::create(['name' => 'Akademik', 'slug' => 'akademik-test']);

        $news = News::create([
            'title' => 'Pengumuman Uji Coba Tema',
            'slug' => 'pengumuman-uji-coba-tema',
            'category_id' => $category->id,
            'author_id' => $author->id,
            'content' => 'Konten pengujian dual theme light mode.',
            'published_at' => now(),
        ]);

        $response = $this->get(route('news.show', $news->slug));
        $response->assertOk();
        $newsHtml = $response->getContent();

        $this->assertStringContainsString('[data-theme="light"] .news-header-card', $newsHtml);
        $this->assertStringContainsString('[data-theme="light"] .news-content', $newsHtml);
        $this->assertStringContainsString('[data-theme="light"] .related-card', $newsHtml);
    }

    /**
     * Item 6: Missing Form Labels Added to Login and Register
     */
    public function test_item_6_missing_form_labels_are_present(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $content = $response->getContent();

        // Form field groups present
        $this->assertStringContainsString('class="form-field-group"', $content);

        // Sign-in labels
        $this->assertStringContainsString('<label for="login_email" class="field-label">', $content);
        $this->assertStringContainsString('Alamat Email', $content);
        $this->assertStringContainsString('<label for="login_password" class="field-label">', $content);
        $this->assertStringContainsString('Kata Sandi', $content);

        // Sign-up labels
        $this->assertStringContainsString('<label for="reg_name" class="field-label">', $content);
        $this->assertStringContainsString('Nama Lengkap / Username', $content);
        $this->assertStringContainsString('<label for="reg_email" class="field-label">', $content);
        $this->assertStringContainsString('<label for="reg_password" class="field-label">', $content);
        $this->assertStringContainsString('<label for="reg_password_confirmation" class="field-label">', $content);
        $this->assertStringContainsString('Konfirmasi Kata Sandi', $content);
    }
}
