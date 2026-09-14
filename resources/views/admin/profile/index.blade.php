@extends('layouts.admin')

@section('title', 'Profil & Cabang Sekolah - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">🏛️ Profil &amp; Cabang Sekolah</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola identitas resmi sekolah, sambutan kepala sekolah, data cabang, dan konfigurasi statistik marketing tanpa perlu deploy ulang kode.</p>
    </div>
</div>

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; color: #a7f3d0; display: flex; align-items: center; gap: 10px;">
    <span style="font-size: 1.2rem;">✓</span>
    <span>{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; color: #fca5a5;">
    <div style="font-weight: 700; margin-bottom: 6px;">⚠️ Terdapat kesalahan input:</div>
    <ul style="margin: 0; padding-left: 20px; font-size: 0.9rem;">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Tab Navigasi --}}
<div style="display: flex; gap: 8px; margin-bottom: 24px; border-bottom: 1px solid var(--border-color, rgba(255,255,255,0.1)); padding-bottom: 12px; overflow-x: auto;">
    <a href="{{ route('admin.profile.index', ['tab' => 'general']) }}" class="btn {{ $activeTab === 'general' ? 'btn-primary' : 'btn-outline' }}" style="border-radius: 10px;">
        🏫 Identitas &amp; Kontak Utama
    </a>
    <a href="{{ route('admin.profile.index', ['tab' => 'sambutan']) }}" class="btn {{ $activeTab === 'sambutan' ? 'btn-primary' : 'btn-outline' }}" style="border-radius: 10px;">
        👨‍🏫 Sambutan Kepala Sekolah
    </a>
    <a href="{{ route('admin.profile.index', ['tab' => 'cabang']) }}" class="btn {{ $activeTab === 'cabang' ? 'btn-primary' : 'btn-outline' }}" style="border-radius: 10px;">
        📍 Informasi Cabang ({{ count($cabang ?? []) }})
    </a>
    <a href="{{ route('admin.profile.index', ['tab' => 'stats']) }}" class="btn {{ $activeTab === 'stats' ? 'btn-primary' : 'btn-outline' }}" style="border-radius: 10px;">
        📊 Statistik Marketing &amp; PPDB
    </a>
</div>

{{-- TAB 1: IDENTITAS UMUM --}}
@if($activeTab === 'general')
<div class="card">
    <div class="card-header" style="margin-bottom: 20px;">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: #ffffff;">Identitas Resmi &amp; Kontak Utama Sekolah</h2>
        <p style="color: var(--text-muted); font-size: 0.85rem;">Data ini ditampilkan di Hero section, Footer, dan kartu informasi sekolah.</p>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        <input type="hidden" name="section" value="general">

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 18px;">
            <div class="form-group">
                <label class="form-label" for="nama">Nama Resmi Sekolah</label>
                <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama', $general['nama'] ?? '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="slogan">Slogan / Tagline</label>
                <input type="text" id="slogan" name="slogan" class="form-control" value="{{ old('slogan', $general['slogan'] ?? '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="tahun_berdiri">Tahun Berdiri</label>
                <input type="text" id="tahun_berdiri" name="tahun_berdiri" class="form-control" value="{{ old('tahun_berdiri', $general['tahun_berdiri'] ?? '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="akreditasi">Status Akreditasi</label>
                <input type="text" id="akreditasi" name="akreditasi" class="form-control" value="{{ old('akreditasi', $general['akreditasi'] ?? '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="telepon">Nomor Telepon Kantor</label>
                <input type="text" id="telepon" name="telepon" class="form-control" value="{{ old('telepon', $general['telepon'] ?? '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Alamat Email Resmi</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $general['email'] ?? '') }}" required>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 18px;">
            <label class="form-label" for="alamat">Alamat Utama Sekolah</label>
            <input type="text" id="alamat" name="alamat" class="form-control" value="{{ old('alamat', $general['alamat'] ?? '') }}" required>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label class="form-label" for="deskripsi">Deskripsi Singkat Profil</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" required>{{ old('deskripsi', $general['deskripsi'] ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">💾 Simpan Identitas Sekolah</button>
    </form>
</div>
@endif

{{-- TAB 2: SAMBUTAN KEPALA SEKOLAH --}}
@if($activeTab === 'sambutan')
<div class="card">
    <div class="card-header" style="margin-bottom: 20px;">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: #ffffff;">Sambutan Kepala Sekolah</h2>
        <p style="color: var(--text-muted); font-size: 0.85rem;">Pesan ini ditampilkan pada section sambutan pimpinan di halaman utama landing page.</p>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        <input type="hidden" name="section" value="sambutan">

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 18px;">
            <div class="form-group">
                <label class="form-label" for="sambutan_nama">Nama Lengkap &amp; Gelar</label>
                <input type="text" id="sambutan_nama" name="nama" class="form-control" value="{{ old('nama', $sambutan['nama'] ?? '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="sambutan_jabatan">Jabatan</label>
                <input type="text" id="sambutan_jabatan" name="jabatan" class="form-control" value="{{ old('jabatan', $sambutan['jabatan'] ?? '') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="sambutan_initials">Inisial Avatar (2 Huruf)</label>
                <input type="text" id="sambutan_initials" name="foto_initials" class="form-control" maxlength="4" value="{{ old('foto_initials', $sambutan['foto_initials'] ?? 'AF') }}">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 24px;">
            <label class="form-label" for="sambutan_pesan">Isi Pesan Sambutan</label>
            <textarea id="sambutan_pesan" name="pesan" class="form-control" rows="5" required>{{ old('pesan', $sambutan['pesan'] ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">💾 Simpan Sambutan Kepala Sekolah</button>
    </form>
</div>
@endif

{{-- TAB 3: CABANG-CABANG SEKOLAH --}}
@if($activeTab === 'cabang')
<div class="card">
    <div class="card-header" style="margin-bottom: 20px;">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: #ffffff;">Kelola Data Cabang Sekolah</h2>
        <p style="color: var(--text-muted); font-size: 0.85rem;">Ubah alamat, kontak WhatsApp, tautan peta Google Maps, dan fasilitas tiap kampus/cabang tanpa perlu menyentuh file kode controller.</p>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        <input type="hidden" name="section" value="cabang">

        <div style="display: flex; flex-direction: column; gap: 24px;">
            @foreach($cabang as $index => $item)
            <div style="background: rgba(15, 23, 42, 0.5); border: 1px solid var(--border-color, rgba(255,255,255,0.1)); border-radius: 14px; padding: 20px;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                    <div style="font-weight: 700; font-size: 1.1rem; color: var(--primary, #38bdf8);">
                        📍 Cabang #{{ $index + 1 }}: {{ $item['label'] ?? '' }}
                    </div>
                    <span style="font-size: 0.8rem; background: rgba(56, 189, 248, 0.15); color: #38bdf8; padding: 4px 10px; border-radius: 9999px;">
                        ID: {{ $item['id'] ?? '' }}
                    </span>
                </div>

                <input type="hidden" name="cabang[{{ $index }}][id]" value="{{ $item['id'] ?? '' }}">

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; margin-bottom: 14px;">
                    <div class="form-group">
                        <label class="form-label">Nama / Label Cabang</label>
                        <input type="text" name="cabang[{{ $index }}][label]" class="form-control" value="{{ $item['label'] ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Judul Lengkap Kartu</label>
                        <input type="text" name="cabang[{{ $index }}][title]" class="form-control" value="{{ $item['title'] ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Badge Tag (misal: KAMPUS PUSAT &amp; ASRAMA)</label>
                        <input type="text" name="cabang[{{ $index }}][tag]" class="form-control" value="{{ $item['tag'] ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kota / Daerah</label>
                        <input type="text" name="cabang[{{ $index }}][kota]" class="form-control" value="{{ $item['kota'] ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jam Operasional</label>
                        <input type="text" name="cabang[{{ $index }}][jam]" class="form-control" value="{{ $item['jam'] ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="cabang[{{ $index }}][telepon]" class="form-control" value="{{ $item['telepon'] ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor WhatsApp CS</label>
                        <input type="text" name="cabang[{{ $index }}][wa]" class="form-control" value="{{ $item['wa'] ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tautan WhatsApp Langsung (wa.me)</label>
                        <input type="text" name="cabang[{{ $index }}][wa_url]" class="form-control" value="{{ $item['wa_url'] ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tautan Google Maps</label>
                        <input type="text" name="cabang[{{ $index }}][maps_url]" class="form-control" value="{{ $item['maps_url'] ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">URL Gambar Sampul Cabang</label>
                        <input type="text" name="cabang[{{ $index }}][image]" class="form-control" value="{{ $item['image'] ?? '' }}">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label">Alamat Lengkap</label>
                    <input type="text" name="cabang[{{ $index }}][alamat]" class="form-control" value="{{ $item['alamat'] ?? '' }}" required>
                </div>

                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label">Deskripsi Cabang</label>
                    <textarea name="cabang[{{ $index }}][desc]" class="form-control" rows="2">{{ $item['desc'] ?? '' }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Daftar Fasilitas Utama (Tulis 1 baris per fasilitas)</label>
                    <textarea name="cabang[{{ $index }}][features]" class="form-control" rows="3" placeholder="Contoh:&#10;Asrama Santri Nyaman&#10;Lab Komputer High-End&#10;Masjid Jami">{{ is_array($item['features'] ?? null) ? implode("\n", $item['features']) : ($item['features'] ?? '') }}</textarea>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">💾 Simpan Seluruh Perubahan Cabang</button>
        </div>
    </form>
</div>
@endif

{{-- TAB 4: STATISTIK MARKETING & PPDB --}}
@if($activeTab === 'stats')
<div class="card">
    <div class="card-header" style="margin-bottom: 20px;">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: #ffffff;">Konfigurasi Statistik Landing Page &amp; PPDB</h2>
        <p style="color: var(--text-muted); font-size: 0.85rem;">Sesuaikan angka baseline marketing secara transparan dan terisolasi tanpa menanam angka magic di kode logika controller.</p>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf
        <input type="hidden" name="section" value="stats">

        <h3 style="font-size: 1.05rem; color: #38bdf8; margin-bottom: 14px;">📈 Statistik Utama Landing Page</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 24px;">
            <div class="form-group">
                <label class="form-label" for="siswa_baseline">Baseline Siswa Terdaftar (Offset Marketing)</label>
                <input type="number" id="siswa_baseline" name="siswa_baseline" class="form-control" value="{{ old('siswa_baseline', $stats['siswa_baseline'] ?? 1250) }}" required min="0">
                <small style="color: var(--text-muted); font-size: 0.78rem;">Ditambahkan ke jumlah riil PpdbRegistration di database.</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="guru_fallback">Fallback Jumlah Guru &amp; Staf</label>
                <input type="number" id="guru_fallback" name="guru_fallback" class="form-control" value="{{ old('guru_fallback', $stats['guru_fallback'] ?? 85) }}" required min="1">
                <small style="color: var(--text-muted); font-size: 0.78rem;">Digunakan bila data guru aktif di database masih kosong.</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="jenjang_label">Label Card Jenjang</label>
                <input type="text" id="jenjang_label" name="jenjang_label" class="form-control" value="{{ old('jenjang_label', $stats['jenjang_label'] ?? '3 Jenjang (SD, SMP, SMK)') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="serapan_prestasi">Label Serapan Kerja &amp; Prestasi</label>
                <input type="text" id="serapan_prestasi" name="serapan_prestasi" class="form-control" value="{{ old('serapan_prestasi', $stats['serapan_prestasi'] ?? '96% Sukses') }}" required>
            </div>
        </div>

        <h3 style="font-size: 1.05rem; color: #38bdf8; margin-bottom: 14px;">📝 Statistik Portal Informasi PPDB (/ppdb)</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 24px;">
            <div class="form-group">
                <label class="form-label" for="baseline_pendaftar">Baseline Total Pendaftar</label>
                <input type="number" id="baseline_pendaftar" name="baseline_pendaftar" class="form-control" value="{{ old('baseline_pendaftar', $ppdbStats['baseline_pendaftar'] ?? 85) }}" required min="0">
            </div>

            <div class="form-group">
                <label class="form-label" for="baseline_diterima">Baseline Pendaftar Diterima</label>
                <input type="number" id="baseline_diterima" name="baseline_diterima" class="form-control" value="{{ old('baseline_diterima', $ppdbStats['baseline_diterima'] ?? 60) }}" required min="0">
            </div>

            <div class="form-group">
                <label class="form-label" for="gelombang">Label Gelombang Aktif</label>
                <input type="text" id="gelombang" name="gelombang" class="form-control" value="{{ old('gelombang', $ppdbStats['gelombang'] ?? 'Gelombang II (Tahun Ajaran 2026/2027)') }}" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="deadline">Batas Akhir Pendaftaran</label>
                <input type="text" id="deadline" name="deadline" class="form-control" value="{{ old('deadline', $ppdbStats['deadline'] ?? '30 Agustus 2026') }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="padding: 10px 24px;">💾 Simpan Konfigurasi Statistik</button>
    </form>
</div>
@endif
@endsection
