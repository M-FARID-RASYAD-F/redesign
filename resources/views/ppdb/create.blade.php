@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Siswa Baru (PPDB) — At-Tamam Edu')

@section('konten_utama')
<section style="background: linear-gradient(180deg, #f1f5f9 0%, #ffffff 100%); padding: 50px 20px 80px;">
    <div style="max-width: 840px; margin: 0 auto;">
        
        <!-- Header Formulir -->
        <div style="text-align: center; margin-bottom: 35px;">
            <a href="{{ route('ppdb.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.9rem; font-weight: 600; color: var(--primary); margin-bottom: 12px; text-decoration: none;">
                ← Kembali ke Portal PPDB
            </a>
            <h1 style="font-size: clamp(1.8rem, 3vw, 2.4rem); font-weight: 800; color: #0f172a;">Formulir Pendaftaran Siswa Baru</h1>
            <p style="color: #64748b; font-size: 1rem; margin-top: 6px;">Tahun Ajaran 2026/2027 · Silakan lengkapi data calon siswa dengan jujur dan teliti.</p>
        </div>

        @if($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 18px 24px; margin-bottom: 30px; color: #b91c1c;">
            <div style="font-weight: 700; margin-bottom: 6px;">⚠️ Terdapat beberapa kolom yang belum terisi dengan benar:</div>
            <ul style="padding-left: 20px; font-size: 0.9rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Kartu Formulir Pendaftaran -->
        <div style="background: white; border-radius: 20px; box-shadow: 0 15px 35px -5px rgba(0,0,0,0.08); border: 1px solid #e2e8f0; padding: clamp(24px, 5vw, 45px);">
            <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- BAGIAN 1: DATA CALON SISWA -->
                <div style="margin-bottom: 35px;">
                    <div style="display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 22px;">
                        <span style="background: #eff6ff; color: var(--primary); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800;">1</span>
                        <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0;">Data Calon Peserta Didik</h2>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="full_name" style="display: block; font-weight: 700; font-size: 0.9rem; color: #334155; margin-bottom: 6px;">
                            Nama Lengkap Calon Siswa <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required placeholder="Contoh: Muhammad Fatih Al-Ayyubi" class="form-control" style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid {{ $errors->has('full_name') ? '#ef4444' : '#cbd5e1' }}; font-size: 0.95rem;">
                        @error('full_name')
                            <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin & Tanggal Lahir (2 Kolom) -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label for="gender" style="display: block; font-weight: 700; font-size: 0.9rem; color: #334155; margin-bottom: 6px;">
                                Jenis Kelamin <span style="color: #ef4444;">*</span>
                            </label>
                            <select id="gender" name="gender" required style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid {{ $errors->has('gender') ? '#ef4444' : '#cbd5e1' }}; font-size: 0.95rem; background: white;">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki (Ikhwan)</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan (Akhwat)</option>
                            </select>
                            @error('gender')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="birth_date" style="display: block; font-weight: 700; font-size: 0.9rem; color: #334155; margin-bottom: 6px;">
                                Tanggal Lahir <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid {{ $errors->has('birth_date') ? '#ef4444' : '#cbd5e1' }}; font-size: 0.95rem;">
                            @error('birth_date')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pilihan Program Keahlian / Jurusan -->
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="major_choice" style="display: block; font-weight: 700; font-size: 0.9rem; color: #334155; margin-bottom: 6px;">
                            Pilihan Program Keahlian (Jurusan) <span style="color: #ef4444;">*</span>
                        </label>
                        <select id="major_choice" name="major_choice" required style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid {{ $errors->has('major_choice') ? '#ef4444' : '#cbd5e1' }}; font-size: 0.95rem; background: white;">
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
                        <label for="address" style="display: block; font-weight: 700; font-size: 0.9rem; color: #334155; margin-bottom: 6px;">
                            Alamat Domisili / Tempat Tinggal <span style="color: #ef4444;">*</span>
                        </label>
                        <textarea id="address" name="address" rows="3" required placeholder="Jl. Nama Jalan, No. Rumah, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten" style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid {{ $errors->has('address') ? '#ef4444' : '#cbd5e1' }}; font-size: 0.95rem; font-family: inherit;">{{ old('address') }}</textarea>
                        @error('address')
                            <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- BAGIAN 2: DATA ORANG TUA / WALI -->
                <div style="margin-bottom: 35px;">
                    <div style="display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 22px;">
                        <span style="background: #fffbeb; color: #d97706; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800;">2</span>
                        <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0;">Data Orang Tua / Wali</h2>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
                        <div>
                            <label for="parent_name" style="display: block; font-weight: 700; font-size: 0.9rem; color: #334155; margin-bottom: 6px;">
                                Nama Lengkap Orang Tua / Wali <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: H. Agus Sulaiman, S.T." style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid {{ $errors->has('parent_name') ? '#ef4444' : '#cbd5e1' }}; font-size: 0.95rem;">
                            @error('parent_name')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parent_phone" style="display: block; font-weight: 700; font-size: 0.9rem; color: #334155; margin-bottom: 6px;">
                                Nomor WhatsApp / Telepon Aktif <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="tel" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}" required placeholder="Contoh: 081234567890" style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid {{ $errors->has('parent_phone') ? '#ef4444' : '#cbd5e1' }}; font-size: 0.95rem;">
                            <span style="font-size: 0.75rem; color: #64748b;">Akan digunakan panitia untuk konfirmasi dan notifikasi status</span>
                            @error('parent_phone')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: UNGGAH DOKUMEN PERSYARATAN -->
                <div style="margin-bottom: 35px;">
                    <div style="display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 22px;">
                        <span style="background: #ecfdf5; color: #059669; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800;">3</span>
                        <div>
                            <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0;">Unggah Berkas & Dokumen</h2>
                            <span style="font-size: 0.8rem; color: #64748b;">(Opsional saat pendaftaran awal, namun disarankan untuk mempercepat verifikasi)</span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
                        <!-- KK -->
                        <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                            <label for="doc_kk" style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 4px;">📄 Kartu Keluarga (KK)</label>
                            <span style="display: block; font-size: 0.75rem; color: #64748b; margin-bottom: 8px;">PDF/JPG/PNG (Maks. 3 MB)</span>
                            <input type="file" id="doc_kk" name="doc_kk" accept=".pdf,.jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%;">
                        </div>

                        <!-- Akta Lahir -->
                        <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                            <label for="doc_akta" style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 4px;">📜 Akta Kelahiran</label>
                            <span style="display: block; font-size: 0.75rem; color: #64748b; margin-bottom: 8px;">PDF/JPG/PNG (Maks. 3 MB)</span>
                            <input type="file" id="doc_akta" name="doc_akta" accept=".pdf,.jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%;">
                        </div>

                        <!-- Pas Foto -->
                        <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                            <label for="doc_foto" style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 4px;">🖼️ Pas Foto Siswa (3x4)</label>
                            <span style="display: block; font-size: 0.75rem; color: #64748b; margin-bottom: 8px;">JPG/PNG (Maks. 3 MB)</span>
                            <input type="file" id="doc_foto" name="doc_foto" accept=".jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%;">
                        </div>

                        <!-- Rapor / SKL -->
                        <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                            <label for="doc_rapor" style="display: block; font-weight: 700; font-size: 0.85rem; color: #334155; margin-bottom: 4px;">📑 Rapor Terakhir / SKL</label>
                            <span style="display: block; font-size: 0.75rem; color: #64748b; margin-bottom: 8px;">PDF/JPG/PNG (Maks. 3 MB)</span>
                            <input type="file" id="doc_rapor" name="doc_rapor" accept=".pdf,.jpg,.jpeg,.png" style="font-size: 0.85rem; width: 100%;">
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 4: PRIVACY NOTICE (UU PDP 27/2022) & PERSETUJUAN -->
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 14px; padding: 20px; margin-bottom: 30px;">
                    <div style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 12px;">
                        <span style="font-size: 1.3rem;">🛡️</span>
                        <div>
                            <h4 style="font-size: 0.95rem; font-weight: 800; color: #1e3a8a; margin: 0 0 4px;">Kebijakan Pelindungan Data Pribadi (UU PDP No. 27/2022)</h4>
                            <p style="font-size: 0.8rem; color: #3b82f6; line-height: 1.5; margin: 0;">
                                Seluruh informasi dan berkas yang Anda kirimkan hanya akan digunakan untuk keperluan seleksi dan administrasi PPDB sekolah. Data tersimpan di server terenkripsi dan tidak akan dipindahtangankan kepada pihak ketiga tanpa izin orang tua/wali.
                            </p>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 10px; margin-top: 14px; border-top: 1px solid #dbeafe; padding-top: 12px;">
                        <input type="checkbox" id="agreement" name="agreement" value="1" required style="margin-top: 4px; width: 18px; height: 18px; cursor: pointer;">
                        <label for="agreement" style="font-size: 0.85rem; color: #1e293b; line-height: 1.5; cursor: pointer;">
                            <strong>Saya menyatakan bahwa seluruh data yang diisikan adalah benar dan valid.</strong> Saya menyetujui data ini diproses oleh Panitia PPDB PKBM Tahfizh At-Tamam / SMKN 1 Nusantara. <span style="color: #ef4444;">*</span>
                        </label>
                    </div>
                    @error('agreement')
                        <p style="color: #ef4444; font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; max-width: 400px; padding: 15px 30px; font-size: 1.05rem; font-weight: 800; border-radius: 12px; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35); cursor: pointer;">
                        🚀 Kirim Pendaftaran PPDB
                    </button>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 12px;">Nomor Pendaftaran resmi akan otomatis digenerate setelah pengiriman berhasil.</p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
