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
                    <a href="#jenjang" class="btn btn-outline">
                        🔍 Lihat Jenjang
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

    <!-- 6b. Modul Pengumuman & Agenda (3.3.3 & 3.4) -->
    <section class="section reveal" id="pengumuman">
        <div class="section-header">
            <span class="section-tag">INFORMASI TERKINI</span>
            <h2 class="section-title">Pengumuman & Agenda Kegiatan</h2>
            <p class="section-desc">Pemberitahuan resmi dan jadwal kegiatan akademik serta kesiswaan di PKBM Tahfizh At-Tamam.</p>
        </div>

        <div class="pengumuman-agenda-grid">
            <!-- Kolom Pengumuman -->
            <div class="glass-card" style="padding: 24px; border-radius: 16px; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px;">
                        <span>📢</span> Pengumuman Resmi
                    </h3>
                    <span class="badge badge-info">{{ count($pengumuman) }} Aktif</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @forelse($pengumuman as $p)
                        <div style="padding: 14px; background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 10px;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                                <span style="font-size: 0.75rem; color: #38bdf8; font-weight: 600; text-transform: uppercase;">{{ $p->type ?? 'Umum' }}</span>
                                <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $p->start_date ? $p->start_date->format('d M Y') : '' }}</span>
                            </div>
                            <h4 style="font-size: 0.95rem; font-weight: 600; color: #fff; margin-bottom: 6px;">{{ $p->title }}</h4>
                            <p style="font-size: 0.82rem; color: var(--text-muted); line-height: 1.4;">{{ Str::limit(strip_tags($p->content), 120) }}</p>
                        </div>
                    @empty
                        <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center; padding: 20px 0;">Belum ada pengumuman aktif.</p>
                    @endforelse
                </div>
            </div>

            <!-- Kolom Agenda -->
            <div class="glass-card" style="padding: 24px; border-radius: 16px; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
                    <h3 style="font-size: 1.15rem; font-weight: 700; color: #fff; display: flex; align-items: center; gap: 8px;">
                        <span>📅</span> Agenda Mendatang
                    </h3>
                    <span class="badge badge-info">{{ count($agendaList) }} Kegiatan</span>
                </div>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @forelse($agendaList as $a)
                        <div style="padding: 14px; background: rgba(255,255,255,0.02); border: 1px solid var(--border); border-radius: 10px; display: flex; gap: 14px; align-items: center;">
                            <div style="min-width: 55px; text-align: center; background: var(--adm-primary, #b91c1c); padding: 8px 6px; border-radius: 8px; color: #fff;">
                                <div style="font-size: 1.1rem; font-weight: 800; line-height: 1;">{{ $a->date ? $a->date->format('d') : '01' }}</div>
                                <div style="font-size: 0.7rem; text-transform: uppercase; font-weight: 600;">{{ $a->date ? $a->date->format('M') : 'JAN' }}</div>
                            </div>
                            <div style="flex: 1;">
                                <h4 style="font-size: 0.95rem; font-weight: 600; color: #fff; margin-bottom: 4px;">{{ $a->title }}</h4>
                                <div style="font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 4px;">
                                    <span>📍</span> {{ $a->location ?? 'Kampus Sekolah' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center; padding: 20px 0;">Belum ada jadwal agenda mendatang.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- 6c. Modul Galeri Foto (3.3.2) -->
    <section class="section reveal" id="galeri">
        <div class="section-header">
            <span class="section-tag">DOKUMENTASI SEKOLAH</span>
            <h2 class="section-title">Galeri Kegiatan & Fasilitas</h2>
            <p class="section-desc">Potret aktivitas santri, pembelajaran kejuruan, dan fasilitas pendukung di lingkungan sekolah.</p>
        </div>

        <div class="galeri-grid">
            @forelse($galeriList as $g)
                <div style="border-radius: 12px; overflow: hidden; position: relative; border: 1px solid var(--border); aspect-ratio: 4/3; background: #000;">
                    <img src="{{ str_starts_with($g->image_path, 'http') ? $g->image_path : asset($g->image_path) }}" 
                         alt="{{ $g->title }}" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                         onmouseover="this.style.transform='scale(1.05)'"
                         onmouseout="this.style.transform='scale(1)'"
                         onerror="this.src='https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?w=600'">
                    <div style="position: absolute; inset: auto 0 0 0; padding: 14px; background: linear-gradient(transparent, rgba(0,0,0,0.85)); color: #fff;">
                        <span style="font-size: 0.72rem; color: #38bdf8; font-weight: 600; text-transform: uppercase;">{{ $g->category ?? 'Kegiatan' }}</span>
                        <div style="font-size: 0.88rem; font-weight: 600; margin-top: 2px;">{{ $g->title }}</div>
                    </div>
                </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 30px;">Belum ada dokumentasi foto.</p>
            @endforelse
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