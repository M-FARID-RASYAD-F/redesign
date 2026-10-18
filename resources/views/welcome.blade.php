@extends('layouts.app')

@section('title', $sekolah['nama'] . ' - Portal Resmi Sekolah')

@push('styles')
    {{-- Hero pakai background-image CSS — browser baru tahu URL-nya setelah parse CSS,
         jadi LCP telat mulai fetch. Preload di <head> supaya request-nya mulai sejak awal. --}}
    <link rel="preload" as="image" href="{{ asset('images/sch5.jpg') }}" fetchpriority="high">
@endpush

@section('konten_utama')

    <!-- 1. Hero Banner & Statistics Section -->
    <section class="hero" id="beranda">
        <div class="hero-container">
            <div class="hero-main-grid">
                <div class="hero-content">
                    <span class="hero-badge">
                        Akreditasi {{ $sekolah['akreditasi'] }}, berdiri sejak {{ $sekolah['tahun_berdiri'] }}
                    </span>

                    <h1 class="hero-title">{{ $sekolah['nama'] }}</h1>
                    <p class="hero-subtitle">{{ $sekolah['slogan'] }}</p>
                    <p class="hero-desc">{{ $sekolah['deskripsi'] }}</p>
                </div>

                <div class="hero-visual">
                    <figure class="hero-photo-card">
                        <img
                            src="{{ asset('images/sch5.jpg') }}"
                            alt="Gedung {{ $sekolah['nama'] }}"
                            class="hero-photo-img"
                            fetchpriority="high"
                            decoding="async"
                        >
                        <figcaption class="hero-photo-caption">
                            Gedung {{ $sekolah['nama'] }}
                        </figcaption>
                    </figure>
                </div>

                <div class="hero-actions">
                    <a href="{{ route('ppdb.index') }}" class="btn btn-primary hero-btn-primary" aria-label="Daftar PPDB online">
                        <span>Daftar PPDB online</span>
                    </a>
                    <a href="#jenjang" class="btn btn-outline hero-btn-secondary" aria-label="Lihat jenjang dan jurusan">
                        <span>Lihat jenjang dan jurusan</span>
                    </a>
                    <a href="{{ route('perpus.index') }}" class="hero-btn-tertiary" aria-label="Buka perpustakaan digital">
                        <span>Perpustakaan digital</span>
                    </a>
                </div>
            </div>

            <!-- 2. Statistics Counter Bar -->
            <div class="stats-section" aria-label="Statistik sekolah">
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
        </div>
    </section>

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

    <!-- 7. Perpustakaan Digital & Pojok Literasi Sekolah -->
    <section class="section perpus-landing-section" id="perpustakaan">
        <x-section-header 
            tag="LITERASI & PERPUSTAKAAN DIGITAL" 
            title="Pusat Referensi & Perpustakaan Digital" 
            subtitle="Jelajahi ribuan koleksi literatur keislaman, sains, teknologi, dan kejuruan modern. Ajukan peminjaman buku mandiri secara online dan pantau statusnya dengan mudah."
        />

        {{-- Highlight Stats Bar --}}
        <div class="perpus-landing-stats-bar">
            <div class="perpus-landing-stat-item">
                <div class="perpus-landing-stat-icon stat-blue">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10"/></svg>
                </div>
                <div>
                    <div class="perpus-landing-stat-val">{{ ($perpusStats['total_books'] ?? 0) > 0 ? $perpusStats['total_books'] : 18 }}+</div>
                    <div class="perpus-landing-stat-lbl">Judul Buku Pilihan</div>
                </div>
            </div>

            <div class="perpus-landing-stat-item">
                <div class="perpus-landing-stat-icon stat-green">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="perpus-landing-stat-val text-emerald-400">{{ ($perpusStats['total_available'] ?? 0) > 0 ? $perpusStats['total_available'] : 65 }}+</div>
                    <div class="perpus-landing-stat-lbl">Eksemplar Siap Pinjam</div>
                </div>
            </div>

            <div class="perpus-landing-stat-item">
                <div class="perpus-landing-stat-icon stat-purple">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <div class="perpus-landing-stat-val">{{ ($perpusStats['total_categories'] ?? 0) > 0 ? $perpusStats['total_categories'] : 8 }}</div>
                    <div class="perpus-landing-stat-lbl">Kategori Disiplin Ilmu</div>
                </div>
            </div>

            <div class="perpus-landing-stat-item">
                <div class="perpus-landing-stat-icon stat-amber">
                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="perpus-landing-stat-val text-amber-400">7 Hari</div>
                    <div class="perpus-landing-stat-lbl">Masa Peminjaman Mandiri</div>
                </div>
            </div>
        </div>

        {{-- Quick Search Form (Redirects to Full Catalog) --}}
        <div class="perpus-landing-search-wrap">
            <form action="{{ route('perpus.index') }}" method="GET" class="perpus-landing-search-form" role="search">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" style="color: var(--text-muted); flex-shrink: 0;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" placeholder="Cari judul buku, pengarang, atau topik ilmu..." class="perpus-landing-search-input" autocomplete="off">
                <button type="submit" class="perpus-landing-search-btn">
                    <span>Cari Katalog</span>
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </button>
            </form>
        </div>

        {{-- Featured Books Grid --}}
        <div class="perpus-landing-books-grid">
            @foreach($bukuPerpusList as $buku)
            <div class="perpus-landing-card">
                <div class="perpus-landing-cover-box">
                    <img src="{{ !empty($buku['cover']) ? $buku['cover'] : asset('images/book-placeholder.svg') }}" 
                         alt="{{ $buku['title'] }}" 
                         loading="lazy" 
                         onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.svg') }}';"
                         class="perpus-landing-cover-img">
                    
                    <span class="perpus-landing-cat-badge">
                        {{ $buku['category_name'] }}
                    </span>

                    <span class="perpus-landing-stock-badge {{ ($buku['available'] ?? 0) > 0 ? 'is-available' : 'is-empty' }}">
                        @if(($buku['available'] ?? 0) > 0)
                            <span class="pulse-dot"></span> {{ $buku['available'] }} Tersedia
                        @else
                            Habis
                        @endif
                    </span>
                </div>

                <div class="perpus-landing-card-body">
                    <h3 class="perpus-landing-book-title" title="{{ $buku['title'] }}">
                        <a href="{{ route('perpus.show', $buku['id']) }}">{{ $buku['title'] }}</a>
                    </h3>

                    <div class="perpus-landing-book-author">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>{{ $buku['author'] }}</span>
                    </div>

                    @if(!empty($buku['rack_location']))
                    <div class="perpus-landing-book-rack">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ $buku['rack_location'] }}</span>
                    </div>
                    @endif

                    <p class="perpus-landing-book-synopsis">
                        {{ $buku['synopsis'] }}
                    </p>

                    <div class="perpus-landing-card-footer">
                        @if(($buku['available'] ?? 0) > 0)
                        <a href="{{ route('perpus.pinjam.create', $buku['id']) }}" class="btn-perpus-pinjam">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                            <span>Pinjam</span>
                        </a>
                        @else
                        <button type="button" disabled class="btn-perpus-disabled">
                            <span>Habis</span>
                        </button>
                        @endif

                        <a href="{{ route('perpus.show', $buku['id']) }}" class="btn-perpus-detail" title="Lihat Detail Buku">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bottom Action Box --}}
        <div class="perpus-landing-bottom-actions">
            <div class="perpus-landing-cta-info">
                <h4>Ingin membaca atau mencari judul buku lainnya?</h4>
                <p>Katalog kami memiliki koleksi pustaka lengkap yang diperbarui secara berkala oleh pustakawan sekolah.</p>
            </div>
            <div class="perpus-landing-cta-buttons">
                <a href="{{ route('perpus.tracking') }}" class="btn-perpus-landing-outline">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <span>Cek Status Pinjam</span>
                </a>
                <a href="{{ route('perpus.index') }}" class="btn-perpus-landing-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10M6 10h10"/></svg>
                    <span>Buka Katalog Lengkap</span>
                    <span class="cta-arrow">&rarr;</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 8. Galeri Fasilitas & Suasana Kampus (Virtual Showcase) -->
    <section class="section reveal" id="fasilitas-tour">
        <x-facility-showcase :items="$galeriFasilitas" />
    </section>

    <!-- 8. Kisah Sukses & Kepercayaan Wali Santri (Testimonials) -->
    <x-testimonials-slider :testimonials="$testimoni" />
    </x-constellation-grid>{{-- end .content-area-constellation --}}

@endsection


@push('scripts')
    <script>
        console.log('Website PKBM Tahfizh At-Tamam - Dimuat dengan sukses!');
    </script>
@endpush