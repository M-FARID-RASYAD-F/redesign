@extends('layouts.app')

@section('title', $sekolah['nama'] . ' - Portal Resmi Sekolah')

@section('konten_utama')

    <!-- 1. Hero Banner Section -->
    <section class="hero" id="beranda">
        <div class="hero-container">
            <div>
                <span class="hero-badge">
                    🌟 Akreditasi {{ $sekolah['akreditasi'] }} &bull; Berdiri Sejak {{ $sekolah['tahun_berdiri'] }}
                </span>
                <h1 class="hero-title">{{ $sekolah['nama'] }}</h1>
                <p class="hero-subtitle">{{ $sekolah['slogan'] }}</p>
                <p class="hero-desc">
                    {{ $sekolah['deskripsi'] }}
                </p>

                <div class="hero-actions">
                    <a href="#kontak" class="btn btn-primary">
                        📝 Daftar PPDB Online
                    </a>
                    <a href="#jurusan" class="btn btn-outline">
                        🔍 Lihat Jurusan
                    </a>
                </div>
            </div>

            <!-- Visual Hero Card -->
            <div class="hero-card">
                <div style="font-size: 0.85rem; font-weight: 700; color: #93c5fd; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.5rem;">
                    💡 Informasi PPDB 2026/2027
                </div>
                <h3 style="font-size: 1.35rem; font-weight: 700; margin-bottom: 1rem; color: #ffffff;">
                    Penerimaan Siswa Baru Telah Dibuka!
                </h3>
                <ul style="list-style: none; color: #cbd5e1; font-size: 0.9rem; margin-bottom: 1.5rem; line-height: 2;">
                    <li>✔️ Bebas Biaya Pendaftaran Online</li>
                    <li>✔️ Beasiswa Prestasi & Kurang Mampu</li>
                    <li>✔️ Penyaluran Kerja Sebelum Lulus</li>
                    <li>✔️ Lab Komputer Standar Industri</li>
                </ul>
                <div style="background: rgba(255,255,255,0.08); padding: 12px; border-radius: 8px; text-align: center; font-size: 0.85rem; color: #f1f5f9;">
                    📞 Layanan Informasi: <strong>{{ $sekolah['telepon'] }}</strong>
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

    <!-- 3. Sambutan Kepala Sekolah -->
    <section class="section reveal" id="sambutan">
        <div class="principal-card">
            <div class="principal-avatar">
                {{ $sambutan['foto_initials'] }}
            </div>
            <div>
                <span class="quote-icon">“</span>
                <p class="principal-text">
                    {{ $sambutan['pesan'] }}
                </p>
                <div class="principal-name">{{ $sambutan['nama'] }}</div>
                <div class="principal-role">{{ $sambutan['jabatan'] }}</div>
            </div>
        </div>
    </section>

    <!-- 4. Program Keahlian / Jurusan -->
    <section class="section" id="jurusan">
        <x-section-header 
            tag="PROGRAM KEAHLIAN" 
            title="Pilih Masa Depanmu di Jurusan Unggulan" 
            subtitle="Kurikulum disesuaikan langsung dengan kebutuhan industri teknologi & bisnis masa kini."
        />

        <div class="grid-2 reveal">
            @foreach($jurusan as $j)
                <x-card 
                    :title="$j['nama']" 
                    :badge="$j['badge']" 
                    :icon="$j['icon']"
                    :subtitle="$j['kategori']"
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

    <!-- 5. Fasilitas Sekolah -->
    <section class="section" id="fasilitas">
        <div class="fasilitas-section">
        <x-section-header 
            tag="SARANA & PRASARANA" 
            title="Fasilitas Modern Penunjang Pembelajaran" 
            subtitle="Lingkungan belajar yang nyaman, kondusif, dan didukung perangkat berteknologi tinggi."
        />

        <div class="grid-4">
            @foreach($fasilitas as $f)
                <div class="facility-card reveal">
                    <div class="facility-icon">{{ $f['icon'] }}</div>
                    <h3 class="facility-title">{{ $f['nama'] }}</h3>
                    <p class="facility-desc">{{ $f['deskripsi'] }}</p>
                </div>
            @endforeach
        </div>
        </div>
    </section>

    <!-- 6. Berita & Pengumuman Terbaru -->
    <section class="section reveal" id="berita" style="margin-top: 5rem;">
        <x-section-header 
            tag="KABAR SEKOLAH" 
            title="Berita & Pengumuman Terbaru" 
            subtitle="Ikuti perkembangan aktivitas, prestasi, dan agenda kegiatan sekolah kami."
        />

        <div class="grid-3">
            @foreach($berita as $b)
                <x-card 
                    :title="$b['judul']" 
                    :badge="$b['kategori']"
                    :subtitle="$b['tanggal'] . ' • ' . $b['baca_waktu']"
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
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: var(--text-main);">
                    Punya Pertanyaan atau Ingin Mendaftar?
                </h2>
                <p style="color: var(--text-muted); margin-bottom: 2rem; line-height: 1.7;">
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
                            <option value="akl" {{ old('jurusan_minat') == 'akl' ? 'selected' : '' }}>Akuntansi & Keuangan Lembaga (AKL)</option>
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