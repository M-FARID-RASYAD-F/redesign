<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_can_access_news_portal_index(): void
    {
        $author = User::factory()->create(['role' => 'admin_cms']);
        $cat = NewsCategory::create(['name' => 'Prestasi', 'slug' => 'prestasi']);

        $news1 = News::create([
            'title' => 'Santri At-Tamam Raih Medali Emas',
            'slug' => 'santri-at-tamam-raih-medali-emas',
            'category_id' => $cat->id,
            'author_id' => $author->id,
            'thumbnail' => 'images/sch1.jpeg',
            'content' => 'Prestasi membanggakan kembali diukir oleh santri dalam kejuaraan sains.',
            'published_at' => now()->subDay(),
        ]);

        $news2 = News::create([
            'title' => 'Agenda Ujian Semester Genap',
            'slug' => 'agenda-ujian-semester-genap',
            'category_id' => $cat->id,
            'author_id' => $author->id,
            'thumbnail' => 'images/sch2.jpeg',
            'content' => 'Jadwal pelaksanaan asesmen dan ujian sumatif semester genap.',
            'published_at' => now()->subHours(2),
        ]);

        $response = $this->get(route('berita.index'));

        $response->assertOk()
            ->assertSee('Warta & Berita PKBM Tahfizh At-Tamam')
            ->assertSee('Prestasi')
            ->assertSee($news1->title)
            ->assertSee($news2->title)
            ->assertSee('custom-card tilt-card-3d', false);
    }

    public function test_visitor_can_search_news_by_keyword(): void
    {
        $author = User::factory()->create(['role' => 'admin_cms']);
        $cat = NewsCategory::create(['name' => 'Umum', 'slug' => 'umum']);

        News::create([
            'title' => 'Pelatihan Robotika dan IoT Tingkat SMK',
            'slug' => 'pelatihan-robotika-iot',
            'category_id' => $cat->id,
            'author_id' => $author->id,
            'content' => 'Siswa SMK antusias mengikuti workshop mikroprosesor dan IoT.',
            'published_at' => now()->subDay(),
        ]);

        News::create([
            'title' => 'Kegiatan Wisuda Tahfizh Angkatan Ke-5',
            'slug' => 'kegiatan-wisuda-tahfizh',
            'category_id' => $cat->id,
            'author_id' => $author->id,
            'content' => 'Sebanyak 45 santri telah menyelesaikan hafalan Al-Quran 30 juz mutqin.',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('berita.index', ['search' => 'Robotika']));

        $response->assertOk()
            ->assertSee('Pelatihan Robotika dan IoT Tingkat SMK')
            ->assertDontSee('Kegiatan Wisuda Tahfizh Angkatan Ke-5');
    }

    public function test_visitor_can_filter_news_by_category(): void
    {
        $author = User::factory()->create(['role' => 'admin_cms']);
        $catPrestasi = NewsCategory::create(['name' => 'Prestasi', 'slug' => 'prestasi']);
        $catAkademik = NewsCategory::create(['name' => 'Akademik', 'slug' => 'akademik']);

        News::create([
            'title' => 'Juara Olimpiade Matematika',
            'slug' => 'juara-olimpiade-matematika',
            'category_id' => $catPrestasi->id,
            'author_id' => $author->id,
            'content' => 'Meraih juara dalam olimpiade matematika se-provinsi.',
            'published_at' => now()->subDay(),
        ]);

        News::create([
            'title' => 'Kalender Akademik Tahun Ajaran Baru',
            'slug' => 'kalender-akademik-tahun-ajaran-baru',
            'category_id' => $catAkademik->id,
            'author_id' => $author->id,
            'content' => 'Informasi penting mengenai kalender akademik tahun ajaran baru.',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('berita.index', ['kategori' => 'akademik']));

        $response->assertOk()
            ->assertSee('Kalender Akademik Tahun Ajaran Baru')
            ->assertDontSee('Juara Olimpiade Matematika');
    }

    public function test_empty_state_shown_when_no_news_found(): void
    {
        $response = $this->get(route('berita.index', ['search' => 'kataKunciYangPastiTidakAda999']));

        $response->assertOk()
            ->assertSee('Tidak Ada Berita Ditemukan')
            ->assertSee('kataKunciYangPastiTidakAda999')
            ->assertSee('Lihat Semua Berita');
    }

    public function test_draft_or_future_news_is_not_displayed_to_public(): void
    {
        $author = User::factory()->create(['role' => 'admin_cms']);
        $cat = NewsCategory::create(['name' => 'Umum', 'slug' => 'umum']);

        News::create([
            'title' => 'Berita Terjadwal Masa Depan',
            'slug' => 'berita-terjadwal-masa-depan',
            'category_id' => $cat->id,
            'author_id' => $author->id,
            'content' => 'Konten rahasia yang belum waktunya terbit.',
            'published_at' => now()->addDays(5),
        ]);

        $response = $this->get(route('berita.index'));

        $response->assertOk()
            ->assertDontSee('Berita Terjadwal Masa Depan');
    }

    public function test_news_created_by_admin_appears_on_public_portal(): void
    {
        $admin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);
        $cat = NewsCategory::create(['name' => 'Pengumuman', 'slug' => 'pengumuman']);

        $this->actingAs($admin)->post(route('admin.news.store'), [
            'title' => 'Pengumuman Libur Hari Raya Idul Fitri',
            'category_id' => $cat->id,
            'content' => 'Diberitahukan kepada seluruh wali santri bahwa kegiatan belajar mengajar diliburkan.',
            'thumbnail' => 'images/sch3.jpeg',
            'published_at' => now()->format('Y-m-d\TH:i'),
        ])->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseHas('news', [
            'title' => 'Pengumuman Libur Hari Raya Idul Fitri',
        ]);

        // Verifikasi langsung muncul di portal berita publik
        $response = $this->get(route('berita.index'));

        $response->assertOk()
            ->assertSee('Pengumuman Libur Hari Raya Idul Fitri');
    }

    public function test_navbar_contains_link_to_berita_index(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk()
            ->assertSee(route('berita.index'));
    }
}
