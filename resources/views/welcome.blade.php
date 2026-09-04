@extends('layouts.app')

@section('title', $sekolah['nama'] . ' - Portal Resmi Sekolah')

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
                    <a href="#kontak" class="btn btn-primary">
                        📝 Daftar PPDB Online
                    </a>
                    <a href="#jurusan" class="btn btn-outline">
                        🔍 Lihat Jurusan
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

    <!-- 4. Program Keahlian / Jurusan -->
    <section class="section" id="jurusan">
        <x-section-header 
            tag="PROGRAM KEAHLIAN" 
            title="Pilih Masa Depanmu di Jurusan Unggulan" 
            subtitle="Kurikulum disesuaikan langsung dengan kebutuhan industri teknologi & bisnis masa kini."
        />

        <div class="grid-3 reveal">
            @foreach($jurusan as $j)
                @php
                    $theme = match($loop->iteration % 3) {
                        1 => 'primary',
                        2 => 'secondary',
                        0 => 'accent',
                    };
                @endphp
                <x-card 
                    :title="$j['nama']" 
                    :badge="$j['badge']" 
                    :icon="$j['icon']"
                    :subtitle="$j['kategori']"
                    :theme="$theme"
                >
                    <p style="margin-bottom: 1rem; line-height: 1.6;">{{ $j['deskripsi'] }}</p>
                    
                    <div class="card-prospek">
                        <strong>💼 Prospek Karir Lulusan:</strong><br>
                        <span>{{ $j['prospek'] }}</span>
                    </div>
                </x-card>
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

        <div class="grid-3">
            @foreach($berita as $b)
                @php
                    $theme = match($loop->iteration % 3) {
                        1 => 'primary',
                        2 => 'secondary',
                        0 => 'accent',
                    };
                @endphp
                <x-card 
                    :title="$b['judul']" 
                    :badge="$b['kategori']"
                    :subtitle="$b['tanggal'] . ' • ' . $b['baca_waktu']"
                    :theme="$theme"
                >
                    <p style="margin-bottom: 1rem; font-size: 0.9rem;">{{ $b['ringkasan'] }}</p>
                    
                    <a href="#" class="card-read-more">
                        Baca Selengkapnya &rarr;
                    </a>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- 7. Form Kontak & Pendaftaran PPDB -->
    <section class="section reveal" id="kontak">
        <div class="contact-container">
            <div>
                <span class="section-tag">HUBUNGI KAMI</span>
                <h2 class="contact-heading">
                    Punya Pertanyaan atau Ingin Mendaftar?
                </h2>
                <p class="contact-desc">
                    Isi formulir di sebelah kanan untuk berkonsultasi mengenai pemilihan jurusan, biaya pendidikan, atau pendaftaran siswa baru. Tim kami akan merespons pesan Anda secara cepat.
                </p>

                <div class="contact-info-list">
                    <div class="contact-info-item">
                        <div class="contact-info-icon blue">📍</div>
                        <div>
                            <div class="contact-info-label">ALAMAT SEKOLAH</div>
                            <div class="contact-info-value">{{ $sekolah['alamat'] }}</div>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon green">📞</div>
                        <div>
                            <div class="contact-info-label">CALL CENTER / WA</div>
                            <div class="contact-info-value">{{ $sekolah['telepon'] }}</div>
                        </div>
                    </div>

                    <div class="contact-info-item">
                        <div class="contact-info-icon yellow">✉️</div>
                        <div>
                            <div class="contact-info-label">EMAIL OFFICIAL</div>
                            <div class="contact-info-value">{{ $sekolah['email'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div>
                <form action="{{ route('kontak.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="nama">Nama Lengkap Siswa / Orang Tua:</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Contoh: Muhammad Rizky" value="{{ old('nama') }}">
                        @error('nama')
                            <span class="error-text">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Alamat Email Aktif:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Contoh: rizky@gmail.com" value="{{ old('email') }}">
                        @error('email')
                            <span class="error-text">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="jurusan_minat">Jurusan yang Diminati:</label>
                        <select id="jurusan_minat" name="jurusan_minat" class="form-control">
                            <option value="">-- Pilih Program Keahlian --</option>
                            <option value="rpl" {{ old('jurusan_minat') == 'rpl' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                            <option value="tkj" {{ old('jurusan_minat') == 'tkj' ? 'selected' : '' }}>Teknik Komputer & Jaringan (TKJ)</option>
                            <option value="dkv" {{ old('jurusan_minat') == 'dkv' ? 'selected' : '' }}>Desain Komunikasi Visual (DKV)</option>
                        </select>
                        @error('jurusan_minat')
                            <span class="error-text">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="pesan">Pesan / Pertanyaan Tambahan:</label>
                        <textarea id="pesan" name="pesan" rows="4" class="form-control" placeholder="Tuliskan pertanyaan Anda di sini...">{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <span class="error-text">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="berkas">Unggah Berkas PPDB (Raport/Ijazah - PDF/JPG, Max 2MB):</label>
                        <input type="file" id="berkas" name="berkas" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        @error('berkas')
                            <span class="error-text">⚠️ {{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit-ppdb">
                        🚀 Kirim Pesan & Konsultasi
                    </button>
                </form>
            </div>
        </div>
    </section>

    </x-constellation-grid>{{-- end .content-area-constellation --}}

@endsection


@push('scripts')
    <script>
        // ── Scroll Reveal ──
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(el => {
                if (el.isIntersecting) {
                    el.target.classList.add('visible');
                    observer.unobserve(el.target);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        console.log('Website Sekolah SMKN 1 Nusantara - Dimuat dengan sukses!');
    </script>
@endpush