@extends('layouts.app')

@section('title', $sekolah['nama'] . ' - Portal Resmi Sekolah')

@section('konten_utama')

    <!-- 1. Hero Banner Section -->
    <section class="hero" id="beranda">
        <div class="hero-container">
            <div>
                <span class="badge" style="background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(147, 197, 253, 0.3); padding: 6px 16px; margin-bottom: 1.5rem; display: inline-block;">
                    🌟 Akreditasi {{ $sekolah['akreditasi'] }} • Berdiri Sejak {{ $sekolah['tahun_berdiri'] }}
                </span>
                <h1 class="hero-title">{{ $sekolah['nama'] }}</h1>
                <p class="hero-subtitle">{{ $sekolah['slogan'] }}</p>
                <p style="color: #cbd5e1; font-size: 0.95rem; margin-bottom: 2rem; line-height: 1.7;">
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
    <div class="stats-section">
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
    <section class="section" id="sambutan">
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

        <div class="grid-2">
            @foreach($jurusan as $j)
                <x-card 
                    :title="$j['nama']" 
                    :badge="$j['badge']" 
                    :icon="$j['icon']"
                    :subtitle="$j['kategori']"
                >
                    <p style="margin-bottom: 1rem; line-height: 1.6;">{{ $j['deskripsi'] }}</p>
                    
                    <div style="background: #f8fafc; padding: 12px 16px; border-radius: 8px; border: 1px dashed #cbd5e1; font-size: 0.85rem;">
                        <strong style="color: var(--text-main);">💼 Prospek Karir Lulusan:</strong><br>
                        <span style="color: var(--primary-hover); font-weight: 600;">{{ $j['prospek'] }}</span>
                    </div>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- 5. Fasilitas Sekolah -->
    <section class="section" id="fasilitas" style="background: #ffffff; padding: 4rem 2rem; border-radius: var(--radius-lg); border: 1px solid var(--border);">
        <x-section-header 
            tag="SARANA & PRASARANA" 
            title="Fasilitas Modern Penunjang Pembelajaran" 
            subtitle="Lingkungan belajar yang nyaman, kondusif, dan didukung perangkat berteknologi tinggi."
        />

        <div class="grid-4">
            @foreach($fasilitas as $f)
                <div style="padding: 1.5rem; background: #f8fafc; border-radius: var(--radius-md); border: 1px solid var(--border);">
                    <div style="font-size: 2.25rem; margin-bottom: 0.75rem;">{{ $f['icon'] }}</div>
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $f['nama'] }}</h3>
                    <p style="font-size: 0.875rem; color: var(--text-muted); line-height: 1.5;">{{ $f['deskripsi'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 6. Berita & Pengumuman Terbaru -->
    <section class="section" id="berita" style="margin-top: 5rem;">
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
                    
                    <a href="#" style="font-weight: 700; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 4px;">
                        Baca Selengkapnya &rarr;
                    </a>
                </x-card>
            @endforeach
        </div>
    </section>

    <!-- 7. Form Kontak & Pendaftaran PPDB -->
    <section class="section" id="kontak">
        <div class="contact-container">
            <div>
                <span class="section-tag">HUBUNGI KAMI</span>
                <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: var(--text-main);">
                    Punya Pertanyaan atau Ingin Mendaftar?
                </h2>
                <p style="color: var(--text-muted); margin-bottom: 2rem; line-height: 1.7;">
                    Isi formulir di sebelah kanan untuk berkonsultasi mengenai pemilihan jurusan, biaya pendidikan, atau pendaftaran siswa baru. Tim kami akan merespons pesan Anda secara cepat.
                </p>

                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 44px; height: 44px; background: var(--primary-light); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📍</div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">ALAMAT SEKOLAH</div>
                            <div style="font-weight: 700; font-size: 0.95rem;">{{ $sekolah['alamat'] }}</div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 44px; height: 44px; background: #ecfdf5; color: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📞</div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">CALL CENTER / WA</div>
                            <div style="font-weight: 700; font-size: 0.95rem;">{{ $sekolah['telepon'] }}</div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 44px; height: 44px; background: #fffbeb; color: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">✉️</div>
                        <div>
                            <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 600;">EMAIL OFFICIAL</div>
                            <div style="font-weight: 700; font-size: 0.95rem;">{{ $sekolah['email'] }}</div>
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

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px;">
                        🚀 Kirim Pesan & Konsultasi
                    </button>
                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        console.log('Website Sekolah SMKN 1 Nusantara - Dimuat dengan sukses!');
    </script>
@endpush