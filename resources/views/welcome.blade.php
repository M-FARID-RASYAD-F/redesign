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
                    ★ Akreditasi {{ $sekolah['akreditasi'] }} &bull; Est. {{ $sekolah['tahun_berdiri'] }}
                </span>
                <h1 class="hero-title">{{ $sekolah['nama'] }}</h1>
                <p class="hero-subtitle">{{ $sekolah['slogan'] }}</p>
                <p class="hero-desc">{{ $sekolah['deskripsi'] }}</p>

                <div class="hero-actions">
                    <a href="{{ route('ppdb.index') }}" class="btn btn-primary">
                        📝 Daftar PPDB Online
                    </a>
                    <a href="#jenjang" class="btn btn-outline">
                        🔍 Lihat Jenjang & Jurusan
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
                        <span class="pc-12__pfp-icon">{{ $j['icon'] ?? '🎓' }}</span>
                        <span class="pc-12__pfp-abbr">{{ $j['kode'] ?? substr($j['nama'], 0, 3) }}</span>
                    </div>
                    <h3>{{ $j['nama'] }}</h3>
                    <p class="pc-12__role">{{ $j['badge'] }} · {{ $j['kategori'] }}</p>
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
                        <span class="pc-12__prospek-label">{{ $j['keunggulan_label'] ?? '🎯 Keunggulan Program:' }}</span>
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
        console.log('Website Sekolah SMKN 1 Nusantara - Dimuat dengan sukses!');
    </script>
@endpush