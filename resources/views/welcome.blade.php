@extends('layouts.app')

@section('title', $sekolah['nama'] . ' - Portal Resmi Sekolah')

@push('styles')
    {{-- Hero pakai background-image CSS — browser baru tahu URL-nya setelah parse CSS,
         jadi LCP telat mulai fetch. Preload di <head> supaya request-nya mulai sejak awal. --}}
    <link rel="preload" as="image" href="{{ asset('images/sch5.jpg') }}" fetchpriority="high">
@endpush

@section('konten_utama')

    <!-- 1. Hero Banner Section — Full Width Academic Style -->
    <section class="hero" id="beranda">
        <div class="hero-container">
            <div class="hero-content">
                <span class="hero-badge">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="none" style="display:inline-block; vertical-align: -1px; margin-right: 4px; color: #fbbf24;" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Akreditasi {{ $sekolah['akreditasi'] }} &bull; Est. {{ $sekolah['tahun_berdiri'] }}
                </span>

                <h1 class="hero-title">{{ $sekolah['nama'] }}</h1>
                <p class="hero-subtitle">{{ $sekolah['slogan'] }}</p>
                <p class="hero-desc">{{ $sekolah['deskripsi'] }}</p>

                <div class="hero-actions">
                    <a href="{{ route('ppdb.index') }}" class="btn btn-primary">
                        <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <span>Daftar PPDB Online</span>
                    </a>
                    <a href="#jenjang" class="btn btn-outline">
                        <svg class="btn-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <span>Lihat Jenjang & Jurusan</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Statistics Counter Bar -->
    <div class="stats-section reveal">
        <div class="stats-grid">
            @foreach($stats as $st)
                <x-stat-card 
                    :label="$st['label']" 
                    :value="$st['value']" 
                    :icon="$st['icon']" 
                    :color="$st['color']" 
                />
            @endforeach
        </div>
    </div>

    <!-- 3. Sambutan Kepala Sekolah — Navy Oxford Section -->
    <section class="principal-section reveal" id="sambutan">
        <div class="principal-section-inner">

            {{-- Foto Kepsek (kiri) --}}
            <div class="principal-photo-col">
                <div class="principal-photo-frame">
                    <div class="principal-photo-initials">
                        {{ $sambutan['foto_initials'] }}
                    </div>
                </div>
            </div>

            {{-- Teks Sambutan (kanan) --}}
            <div class="principal-text-col">
                <div class="principal-eyebrow">Kata Sambutan</div>
                <h2 class="principal-heading">
                    Membangun Generasi<br>Unggul dan Berkarakter
                </h2>
                <blockquote class="principal-quote">
                    {{ $sambutan['pesan'] }}
                </blockquote>
                <div class="principal-name-block">
                    <div class="principal-name">{{ $sambutan['nama'] }}</div>
                    <div class="principal-role">{{ $sambutan['jabatan'] }}</div>
                </div>
            </div>

        </div>
    </section>

    {{-- ═══ Area Konten Animasi Constellation Grid (bck.md) ═══ --}}
    <x-constellation-grid class="content-area-constellation">

    <!-- 4. Jenjang Pendidikan (SD, SMP, SMK) -->
    <section class="section reveal" id="jenjang">
        {{-- Hidden anchor fallback untuk kompatibilitas tautan lama --}}
        <span id="jurusan" style="position: relative; top: -90px; display: block; visibility: hidden;"></span>

        <x-section-header 
            tag="JENJANG PENDIDIKAN" 
            title="Pilihan Jenjang Pendidikan di PKBM At-Tamam" 
            subtitle="Menyediakan pendidikan berjenjang mulai dari tingkat dasar, menengah pertama, hingga kejuruan berbasis karakter Qurani dan vokasi modern."
        />

        <div class="pc-12-jenjang-stage pc-12-jurusan-stage">
            @foreach($jenjang as $j)
                <div class="pc-12__card">
                    <div class="pc-12__pfp">
                        <span class="pc-12__pfp-icon">
                            @if(($j['id'] ?? '') === 'sd' || in_array($j['icon'] ?? '', ['🎒', 'sd', 'book-open']))
                                {{-- Lucide BookOpen SVG Line Icon --}}
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            @elseif(($j['id'] ?? '') === 'smp' || in_array($j['icon'] ?? '', ['📚', 'smp', 'compass']))
                                {{-- Lucide Compass SVG Line Icon --}}
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                            @elseif(($j['id'] ?? '') === 'smk' || in_array($j['icon'] ?? '', ['💻', 'smk', 'laptop']))
                                {{-- Lucide Laptop SVG Line Icon --}}
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"/></svg>
                            @else
                                {{-- Default GraduationCap SVG Line Icon --}}
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21.42 10.922a1 1 0 0 0-.019-.838L12.83 3.18a2 2 0 0 0-1.66 0L2.6 10.084a1 1 0 0 0 0 1.832l8.57 6.908a2 2 0 0 0 1.66 0l8.57-6.908a1 1 0 0 0 .02-.994z"/><path d="M6 12.5v5a6 3 0 0 0 12 0v-5"/></svg>
                            @endif
                        </span>
                        <span class="pc-12__pfp-abbr">{{ $j['kode'] ?? substr($j['nama'], 0, 3) }}</span>
                    </div>
                    <h3>{{ $j['nama'] }}</h3>
                    <p class="pc-12__role">
                        @if(str_contains($j['badge'] ?? '', '🌱') || ($j['badge_icon'] ?? '') === 'sprout' || ($j['id'] ?? '') === 'sd')
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-1px; margin-right:3px;" aria-hidden="true"><path d="M7 20h10"/><path d="M10 20c5.5-2.5.8-6.4 3-10"/><path d="M9.5 9.4c1.1.8 1.8 2.2 2.3 3.7-2 .4-3.5.4-4.8-.3-1.2-.6-2.3-1.9-3-4.2 2.8-.5 4.4 0 5.5.8z"/><path d="M14.1 6a7 7 0 0 1 1.1 4c-1.2 0-2.8-.6-3.8-1.5-.9-.9-1.4-2.1-1.4-3.5 2.5 0 3.4.5 4.1 1z"/></svg>
                        @elseif(str_contains($j['badge'] ?? '', '🌟') || ($j['badge_icon'] ?? '') === 'sparkles' || ($j['id'] ?? '') === 'smp')
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#38bdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-1px; margin-right:3px;" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        @elseif(str_contains($j['badge'] ?? '', '🚀') || ($j['badge_icon'] ?? '') === 'rocket' || ($j['id'] ?? '') === 'smk')
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#c084fc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-1px; margin-right:3px;" aria-hidden="true"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                        @endif
                        {{ trim(preg_replace('/[\x{1F300}-\x{1F9FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]\s*/u', '', $j['badge'] ?? '')) }} · {{ $j['kategori'] }}
                    </p>
                    <p class="pc-12__bio">{{ $j['deskripsi'] }}</p>
                    
                    <div class="pc-12__row">
                        <div class="pc-12__stat">
                            <b>{{ $j['masa_studi'] ?? '3 Thn' }}</b>
                            <span>Masa Studi</span>
                        </div>
                        <div class="pc-12__stat">
                            <b>{{ $j['fokus_kurikulum'] ?? 'Kurikulum' }}</b>
                            <span>Fokus Utama</span>
                        </div>
                    </div>

                    <div class="pc-12__prospek">
                        <span class="pc-12__prospek-label">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;" aria-hidden="true"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                            {{ trim(str_replace(['🎯', '🎯 '], '', $j['keunggulan_label'] ?? 'Keunggulan Program:')) }}
                        </span>
                        <span class="pc-12__prospek-val">{{ $j['keunggulan'] ?? '' }}</span>
                    </div>

                    <a href="{{ $j['link_daftar'] ?? route('ppdb.create') }}" class="pc-12__cta">Daftar {{ $j['kode'] }} Ini &rarr;</a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 5. Info Cabang-Cabang Sekolah At-Tamam -->
    <section class="section reveal" id="cabang">
        {{-- Hidden anchor fallback untuk kompatibilitas tautan lama --}}
        <span id="fasilitas" style="position: relative; top: -90px; display: block; visibility: hidden;"></span>

        <div class="cabang-section fasilitas-section">
            <x-section-header 
                tag="JARINGAN KAMPUS & PUSAT BELAJAR" 
                title="Cabang & Lokasi Belajar PKBM Tahfizh At-Tamam" 
                subtitle="Hadir lebih dekat untuk mencetak generasi Qurani dan unggul teknologi dengan fasilitas representatif dan lingkungan kondusif di setiap kampus."
            />

            {{-- Interactive Animated Tabs Component (Menampilkan detail cabang aktif) --}}
            <x-animated-tabs :tabs="$cabang" />
        </div>
    </section>

    <!-- 6. Berita & Pengumuman Terbaru -->
    <section class="section reveal" id="berita">
        <x-section-header 
            tag="KABAR SEKOLAH" 
            title="Berita & Pengumuman Terbaru" 
            subtitle="Ikuti perkembangan aktivitas, prestasi, dan agenda kegiatan sekolah kami."
        />

        <div class="grid-3 news-cards-grid">
            @php
                $localImagePool = [
                    'images/sch1.jpeg',
                    'images/sch2.jpeg',
                    'images/sch3.jpeg',
                    'images/sch5.jpg',
                ];
            @endphp
            @foreach($berita as $b)
                @php
                    $theme = match($loop->iteration % 3) {
                        1 => 'primary',
                        2 => 'secondary',
                        0 => 'accent',
                    };
                    $newsImage = !empty($b['gambar']) ? $b['gambar'] : $localImagePool[$loop->index % count($localImagePool)];
                    $newsSlug = $b['slug'] ?? Str::slug($b['judul']);
                    $newsUrl = route('news.show', $newsSlug);
                @endphp
                <x-card 
                    :title="$b['judul']" 
                    :badge="$b['kategori']"
                    :subtitle="$b['tanggal'] . ' • ' . $b['baca_waktu']"
                    :date="$b['tanggal']"
                    :read-time="$b['baca_waktu']"
                    :theme="$theme"
                    :image="$newsImage"
                    :link="$newsUrl"
                >
                    <p class="news-excerpt">{{ $b['ringkasan'] }}</p>
                    
                    <a href="{{ $newsUrl }}" class="card-read-more">
                        <span>Baca Selengkapnya</span>
                        <span class="read-more-arrow">&rarr;</span>
                    </a>
                </x-card>
            @endforeach
        </div>
    </section>
    </x-constellation-grid>{{-- end .content-area-constellation --}}

@endsection


@push('scripts')
    <script>
        console.log('Website PKBM Tahfizh At-Tamam - Dimuat dengan sukses!');
    </script>
@endpush