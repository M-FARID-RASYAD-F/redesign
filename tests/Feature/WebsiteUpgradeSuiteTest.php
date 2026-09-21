<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\PpdbRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteUpgradeSuiteTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminCms;
    protected NewsCategory $category;
    protected News $news;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminCms = User::factory()->create([
            'name' => 'Admin Test',
            'email' => 'admintest@attamam.sch.id',
            'role' => 'admin_cms',
            'is_active' => true,
        ]);

        $this->category = NewsCategory::create([
            'name' => 'Prestasi',
            'slug' => 'prestasi',
        ]);

        $this->news = News::create([
            'title' => 'Santri At-Tamam Raih Medali Emas Olimpiade Sains Nasional 2026',
            'slug' => 'santri-attamam-raih-medali-emas-osn-2026',
            'category_id' => $this->category->id,
            'author_id' => $this->adminCms->id,
            'content' => '<p>Prestasi membanggakan kembali ditorehkan santri dalam ajang sains tingkat nasional.</p>',
            'published_at' => now()->subDay(),
        ]);
    }

    /**
     * Test 1: Global Spotlight Search API returns JSON and supports search queries
     */
    public function test_api_search_returns_valid_json_results(): void
    {
        $response = $this->getJson(route('api.search'));
        $response->assertOk()
            ->assertJsonStructure([
                '*' => ['title', 'desc', 'url', 'category', 'badge', 'icon']
            ]);

        // Search for PPDB
        $responseSearch = $this->getJson(route('api.search', ['q' => 'PPDB']));
        $responseSearch->assertOk();
        $this->assertNotEmpty($responseSearch->json());

        // Search for specific news article
        $responseNews = $this->getJson(route('api.search', ['q' => 'Olimpiade']));
        $responseNews->assertOk();
        $titles = collect($responseNews->json())->pluck('title')->toArray();
        $this->assertTrue(collect($titles)->contains(fn ($t) => str_contains($t, 'Olimpiade')));
    }

    /**
     * Test 2: Homepage renders Facility Showcase, Testimonials, & Spotlight
     */
    public function test_homepage_renders_all_upgraded_sections(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk()
            ->assertDontSee('topAnnouncementBar')
            ->assertSee('spotlightModal')
            ->assertSee('galeri-fasilitas')
            ->assertSee('testimoni')
            ->assertSee('nav-search-trigger-btn');
    }

    /**
     * Test 3: PPDB Portal renders Tuition Simulator & FAQ Accordion
     */
    public function test_ppdb_portal_renders_tuition_simulator_and_faq(): void
    {
        $response = $this->get(route('ppdb.index'));
        $response->assertOk()
            ->assertSee('simulasi-biaya')
            ->assertSee('tuition-simulator-wrapper')
            ->assertSee('Kalkulator Estimasi Biaya &amp; Beasiswa PPDB', false)
            ->assertSee('faq-section')
            ->assertSee('Pertanyaan yang Sering Diajukan (FAQ)', false);
    }

    /**
     * Test 4: News Show page renders original article view without extra toolbars
     */
    public function test_news_show_renders_original_article_view(): void
    {
        $response = $this->get(route('news.show', $this->news->slug));
        $response->assertOk()
            ->assertSee($this->news->title)
            ->assertSee($this->news->content, false)
            ->assertDontSee('newsReadingBar')
            ->assertDontSee('article-toolbar');
    }

    /**
     * Test 5: PPDB Tracking supports searching by Registration Code OR Parent Phone
     */
    public function test_ppdb_tracking_supports_code_and_phone_search(): void
    {
        $registration = PpdbRegistration::create([
            'jenjang' => 'smp',
            'full_name' => 'Fadhil Al-Ghifari',
            'gender' => 'L',
            'birth_date' => '2012-05-14',
            'address' => 'Jl. Tuanku Tambusai No. 80, Pekanbaru',
            'parent_name' => 'Bambang Sudiro',
            'parent_phone' => '081299887766',
            'status' => 'pending',
            'notes' => 'Pendaftaran online baru.',
        ]);

        // Cari dengan nomor pendaftaran resmi
        $resCode = $this->post(route('ppdb.check'), [
            'no_pendaftaran' => $registration->no_pendaftaran,
        ]);
        $resCode->assertOk()
            ->assertSee($registration->no_pendaftaran)
            ->assertSee('Fadhil Al-Ghifari');

        // Cari dengan nomor WhatsApp orang tua
        $resPhone = $this->post(route('ppdb.check'), [
            'no_pendaftaran' => '081299887766',
        ]);
        $resPhone->assertOk()
            ->assertSee($registration->no_pendaftaran)
            ->assertSee('Fadhil Al-Ghifari');
    }
}
