@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Siswa Baru (PPDB) — PKBM Tahfizh At-Tamam')

@section('konten_utama')
<div class="ppdb-page-container">
    <div style="max-width: 840px; margin: 0 auto;">
        
        <!-- Header Formulir -->
        <div style="text-align: center; margin-bottom: 35px;">
            <a href="{{ route('ppdb.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem; font-weight: 700; color: #38bdf8; margin-bottom: 12px; text-decoration: none;">
                ← Kembali ke Portal PPDB
            </a>
            <h1 class="ppdb-section-title" style="font-size: clamp(1.8rem, 3vw, 2.4rem); margin: 0;">Formulir Pendaftaran Siswa Baru</h1>
            <p class="ppdb-section-desc" style="margin-top: 6px;">Tahun Ajaran 2026/2027 · Silakan lengkapi data calon siswa dengan jujur dan teliti.</p>
        </div>

        @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 16px; padding: 18px 24px; margin-bottom: 30px; color: #fca5a5;">
            <div style="font-weight: 700; margin-bottom: 6px; color: #ffffff;">⚠️ Terdapat beberapa kolom yang belum terisi dengan benar:</div>
            <ul style="padding-left: 20px; font-size: 0.9rem; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Kartu Formulir Pendaftaran -->
        <div class="ppdb-form-card">
            <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- BAGIAN 1: DATA CALON SISWA -->
                <div style="margin-bottom: 35px;">
                    <div class="ppdb-step-header">
                        <span class="ppdb-step-badge badge-blue">1</span>
                        <h2 class="ppdb-step-heading">Data Calon Peserta Didik</h2>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="full_name" class="ppdb-form-label">
                            Nama Lengkap Calon Siswa <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required placeholder="Contoh: Muhammad Fatih Al-Ayyubi" class="ppdb-form-input">
                        @error('full_name')
                            <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin & Tanggal Lahir (2 Kolom) -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label for="gender" class="ppdb-form-label">
                                Jenis Kelamin <span style="color: #ef4444;">*</span>
                            </label>
                            <select id="gender" name="gender" required class="ppdb-form-select">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki (Ikhwan)</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan (Akhwat)</option>
                            </select>
                            @error('gender')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="birth_date" class="ppdb-form-label">
                                Tanggal Lahir <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required class="ppdb-form-input">
                            @error('birth_date')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pilihan Program Keahlian / Jurusan -->
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="major_choice" class="ppdb-form-label">
                            Pilihan Program Keahlian (Jurusan) <span style="color: #ef4444;">*</span>
                        </label>
                        <select id="major_choice" name="major_choice" required class="ppdb-form-select">
                            <option value="">-- Pilih Jurusan Impian Anda --</option>
                            @foreach($majors as $major)
                                <option value="{{ $major->slug }}" {{ old('major_choice') == $major->slug ? 'selected' : '' }}>
                                    {{ $major->icon ?? '⚡' }} {{ $major->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('major_choice')
                            <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="form-group">
                        <label for="address" class="ppdb-form-label">
                            Alamat Domisili / Tempat Tinggal <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea id="address" name="address" rows="3" required placeholder="Jl. Nama Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten" class="ppdb-form-textarea">{{ old('address') }}</textarea>
                        @error('address')
                            <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- BAGIAN 2: DATA ORANG TUA / WALI -->
                <div style="margin-bottom: 35px;">
                    <div class="ppdb-step-header">
                        <span class="ppdb-step-badge badge-amber">2</span>
                        <h2 class="ppdb-step-heading">Data Orang Tua / Wali</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
                        <div>
                            <label for="parent_name" class="ppdb-form-label">
                                Nama Lengkap Orang Tua / Wali <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: H. Agus Sulaiman, S.T." class="ppdb-form-input">
                            @error('parent_name')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parent_phone" class="ppdb-form-label">
                                Nomor WhatsApp / Telepon Aktif <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="tel" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" required placeholder="Contoh: 081234567890" class="ppdb-form-input">
                            <span style="font-size: 0.75rem; color: #94a3b8; display: block; margin-top: 4px;">Akan digunakan panitia untuk konfirmasi dan notifikasi status</span>
                            @error('parent_phone')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: UNGGAH DOKUMEN PERSYARATAN -->
                <div style="margin-bottom: 35px;">
                    <div class="ppdb-step-header">
                        <span class="ppdb-step-badge badge-emerald">3</span>
                        <div>
                            <h2 class="ppdb-step-heading">Unggah Berkas & Dokumen</h2>
                            <span style="font-size: 0.8rem; color: #94a3b8;">(Opsional saat pendaftaran awal, namun disarankan untuk mempercepat verifikasi)</span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
                        <!-- KK -->
                        <div class="ppdb-upload-box">
                            <label for="doc_kk" class="ppdb-upload-title">📄 Kartu Keluarga (KK)</label>
                            <span class="ppdb-upload-sub">PDF/JPG/PNG (Maks. 3 MB)</span>
                            <input type="file" id="doc_kk" name="doc_kk" accept=".pdf,.jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%; color: #cbd5e1;">
                        </div>

                        <!-- Akta Lahir -->
                        <div class="ppdb-upload-box">
                            <label for="doc_akta" class="ppdb-upload-title">📜 Akta Kelahiran</label>
                            <span class="ppdb-upload-sub">PDF/JPG/PNG (Maks. 3 MB)</span>
                            <input type="file" id="doc_akta" name="doc_akta" accept=".pdf,.jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%; color: #cbd5e1;">
                        </div>

                        <!-- Pas Foto -->
                        <div class="ppdb-upload-box">
                            <label for="doc_foto" class="ppdb-upload-title">🖼️ Pas Foto Siswa (3x4)</label>
                            <span class="ppdb-upload-sub">JPG/PNG (Maks. 3 MB)</span>
                            <input type="file" id="doc_foto" name="doc_foto" accept=".jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%; color: #cbd5e1;">
                        </div>

                        <!-- Rapor / SKL -->
                        <div class="ppdb-upload-box">
                            <label for="doc_rapor" class="ppdb-upload-title">📑 Rapor Terakhir / SKL</label>
                            <span class="ppdb-upload-sub">PDF/JPG/PNG (Maks. 3 MB)</span>
                            <input type="file" id="doc_rapor" name="doc_rapor" accept=".pdf,.jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%; color: #cbd5e1;">
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 4: PRIVACY NOTICE (UU PDP 27/2022) & PERSETUJUAN -->
                <div class="ppdb-pdp-notice">
                    <div style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 12px;">
                        <span style="font-size: 1.3rem;">🛡️</span>
                        <div>
                            <h4 class="ppdb-pdp-title">Kebijakan Pelindungan Data Pribadi (UU PDP No. 27/2022)</h4>
                            <p class="ppdb-pdp-desc">
                                Seluruh informasi dan berkas yang Anda kirimkan hanya akan digunakan untuk keperluan seleksi dan administrasi PPDB sekolah. Data tersimpan di server terenkripsi dan tidak akan dipindahtangankan kepada pihak ketiga tanpa izin orang tua/wali.
                            </p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 10px; margin-top: 14px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 12px;">
                        <input type="checkbox" id="agreement" name="agreement" value="1" required style="margin-top: 4px; width: 18px; height: 18px; cursor: pointer;">
                        <label for="agreement" style="font-size: 0.85rem; color: #e2e8f0; line-height: 1.5; cursor: pointer;">
                            <strong>Saya menyatakan bahwa seluruh data yang diisikan adalah benar dan valid.</strong> Saya menyetujui data ini diproses oleh Panitia PPDB PKBM Tahfizh At-Tamam. <span style="color: #ef4444;">*</span>
                        </label>
                    </div>
                    @error('agreement')
                        <p style="color: #ef4444; font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; max-width: 400px; padding: 15px 30px; font-size: 1.05rem; font-weight: 800; border-radius: 12px; cursor: pointer;">
                        🚀 Kirim Pendaftaran PPDB
                    </button>
                    <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 12px;">Nomor Pendaftaran resmi akan otomatis digenerate setelah pengiriman berhasil.</p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
