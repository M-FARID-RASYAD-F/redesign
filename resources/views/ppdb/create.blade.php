@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Siswa Baru (PPDB) — PKBM Tahfizh At-Tamam')

@push('styles')
<style>
/* Panggung Pergeseran Kertas Modern (Smooth Tactile Paper Track - Zero Layout Reflow) */
.ppdb-slide-deck {
    position: relative;
    width: 100%;
    overflow: hidden;
    border-radius: 20px;
}

/* Track horizontal yang menampung seluruh lembaran secara fleksibel & sejajar */
.ppdb-slide-track {
    display: flex;
    width: 100%;
    align-items: stretch;
    transition: transform 0.5s cubic-bezier(0.22, 1, 0.36, 1);
    will-change: transform;
}

/* Setiap Slide adalah selembar kertas fisik modern */
.ppdb-slide {
    display: flex;
    flex-direction: column;
    flex: 0 0 100%;
    min-width: 100%;
    width: 100%;
    min-height: 580px;
    background: #141f36;
    border: 1px solid rgba(56, 189, 248, 0.22);
    border-radius: 20px;
    padding: clamp(22px, 3.5vw, 36px);
    box-shadow: 0 14px 36px rgba(0, 0, 0, 0.45);
    box-sizing: border-box;
    transition: opacity 0.35s ease;
}

[data-theme="light"] .ppdb-slide {
    background: oklch(27.1% 0.105 12.094 / 0.98);
    border-color: oklch(58.6% 0.253 17.585 / 0.45);
    box-shadow: 0 14px 36px rgba(0, 0, 0, 0.35);
}

.ppdb-slide:not(.active) {
    opacity: 0.85;
}

.ppdb-slide.active {
    opacity: 1;
}
</style>
@endpush

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
            <!-- Stepper Header Navigation -->
            <div class="ppdb-stepper" id="ppdbStepper">
                <button type="button" class="ppdb-step-item active" data-step="1" onclick="jumpToStep(1)">
                    <div class="ppdb-step-circle">
                        <span class="step-num">1</span>
                        <span class="step-check">✓</span>
                    </div>
                    <div class="ppdb-step-info">
                        <span class="ppdb-step-label">Langkah 1</span>
                        <span class="ppdb-step-name">Data Calon Siswa</span>
                    </div>
                </button>

                <div class="ppdb-step-connector" id="connector-1"></div>

                <button type="button" class="ppdb-step-item" data-step="2" onclick="jumpToStep(2)">
                    <div class="ppdb-step-circle">
                        <span class="step-num">2</span>
                        <span class="step-check">✓</span>
                    </div>
                    <div class="ppdb-step-info">
                        <span class="ppdb-step-label">Langkah 2</span>
                        <span class="ppdb-step-name">Orang Tua / Wali</span>
                    </div>
                </button>

                <div class="ppdb-step-connector" id="connector-2"></div>

                <button type="button" class="ppdb-step-item" data-step="3" onclick="jumpToStep(3)">
                    <div class="ppdb-step-circle">
                        <span class="step-num">3</span>
                        <span class="step-check">✓</span>
                    </div>
                    <div class="ppdb-step-info">
                        <span class="ppdb-step-label">Langkah 3</span>
                        <span class="ppdb-step-name">Berkas & Selesai</span>
                    </div>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="ppdb-progress-track">
                <div class="ppdb-progress-bar" id="ppdbProgressBar" style="width: 33.33%;"></div>
            </div>

            <form id="ppdbForm" action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="ppdb-slide-deck">
                    <div class="ppdb-slide-track" id="ppdbSlideTrack">

                    <!-- SLIDE 1: DATA CALON SISWA -->
                    <div class="ppdb-slide active" id="slide-1">
                    <div class="ppdb-slide-body">
                        <div class="ppdb-step-header">
                            <span class="ppdb-step-badge badge-blue">1</span>
                            <div>
                                <h2 class="ppdb-step-heading">Data Calon Peserta Didik</h2>
                                <span style="font-size: 0.8rem; color: #94a3b8;">Isi data pribadi calon siswa sesuai dokumen resmi (KK / Akta Kelahiran).</span>
                            </div>
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

                    <!-- Slide 1 Action Buttons -->
                    <div class="ppdb-slide-actions">
                        <a href="{{ route('ppdb.index') }}" class="ppdb-btn-prev">
                            ← Ke Beranda PPDB
                        </a>
                        <button type="button" class="ppdb-btn-next" onclick="nextSlide(2)">
                            Lanjut ke Data Orang Tua →
                        </button>
                    </div>
                </div>

                <!-- SLIDE 2: DATA ORANG TUA / WALI -->
                <div class="ppdb-slide" id="slide-2">
                    <div class="ppdb-slide-body">
                        <div class="ppdb-step-header">
                            <span class="ppdb-step-badge badge-amber">2</span>
                            <div>
                                <h2 class="ppdb-step-heading">Data Orang Tua / Wali</h2>
                                <span style="font-size: 0.8rem; color: #94a3b8;">Kontak aktif orang tua / wali untuk notifikasi pengumuman seleksi.</span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 22px;">
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

                        <!-- Panduan & Info Komunikasi Orang Tua -->
                        <div class="ppdb-info-card">
                            <div style="display: flex; gap: 14px; align-items: flex-start;">
                                <span style="font-size: 1.6rem; line-height: 1;">📱</span>
                                <div>
                                    <h4 style="font-size: 0.95rem; font-weight: 800; color: #fbbf24; margin: 0 0 6px;">Pemberitahuan & Verifikasi Kontak</h4>
                                    <p style="font-size: 0.84rem; color: #cbd5e1; line-height: 1.6; margin: 0 0 10px;">
                                        Pastikan nomor WhatsApp orang tua/wali aktif. Panitia PPDB PKBM Tahfizh At-Tamam akan mengirimkan:
                                    </p>
                                    <ul style="margin: 0; padding-left: 18px; font-size: 0.82rem; color: #cbd5e1; line-height: 1.6;">
                                        <li>Surat tanda bukti registrasi & kode pendaftaran resmi.</li>
                                        <li>Jadwal pelaksanaan observasi / wawancara wali santri dan calon siswa.</li>
                                        <li>Hasil pengumuman kelulusan seleksi PPDB Tahun Ajaran 2026/2027.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 Action Buttons -->
                    <div class="ppdb-slide-actions">
                        <button type="button" class="ppdb-btn-prev" onclick="prevSlide(1)">
                            ← Kembali ke Data Siswa
                        </button>
                        <button type="button" class="ppdb-btn-next" onclick="nextSlide(3)">
                            Lanjut ke Unggah Berkas →
                        </button>
                    </div>
                </div>

                <!-- SLIDE 3: UNGGAH DOKUMEN PERSYARATAN & PERSETUJUAN -->
                <div class="ppdb-slide" id="slide-3">
                    <div class="ppdb-slide-body">
                        <div class="ppdb-step-header">
                            <span class="ppdb-step-badge badge-emerald">3</span>
                            <div>
                                <h2 class="ppdb-step-heading">Unggah Berkas & Dokumen</h2>
                                <span style="font-size: 0.8rem; color: #94a3b8;">(Opsional saat pendaftaran awal, namun disarankan untuk mempercepat verifikasi)</span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 22px;">
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

                        <!-- Privacy Notice & Persetujuan -->
                        <div class="ppdb-pdp-notice" style="margin-bottom: 10px;">
                            <div style="display: flex; gap: 10px; align-items: flex-start; margin-bottom: 12px;">
                                <span style="font-size: 1.3rem;">🛡️</span>
                                <div>
                                    <h4 class="ppdb-pdp-title">Kebijakan Pelindungan Data Pribadi (UU PDP No. 27/2022)</h4>
                                    <p class="ppdb-pdp-desc">
                                        Seluruh informasi dan berkas yang Anda kirimkan hanya akan digunakan untuk keperluan seleksi dan administrasi PPDB sekolah. Data tersimpan di server terenkripsi dan tidak akan dipindahtangankan kepada pihak ketiga tanpa izin orang tua/wali.
                                    </p>
                                </div>
                            </div>

                            <div style="display: flex; align-items: flex-start; gap: 10px; margin-top: 12px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px;">
                                <input type="checkbox" id="agreement" name="agreement" value="1" required style="margin-top: 4px; width: 18px; height: 18px; cursor: pointer;">
                                <label for="agreement" style="font-size: 0.85rem; color: #e2e8f0; line-height: 1.5; cursor: pointer;">
                                    <strong>Saya menyatakan bahwa seluruh data yang diisikan adalah benar dan valid.</strong> Saya menyetujui data ini diproses oleh Panitia PPDB PKBM Tahfizh At-Tamam. <span style="color: #ef4444;">*</span>
                                </label>
                            </div>
                            @error('agreement')
                                <p style="color: #ef4444; font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Slide 3 Action Buttons -->
                    <div class="ppdb-slide-actions">
                        <button type="button" class="ppdb-btn-prev" onclick="prevSlide(2)">
                            ← Kembali ke Data Orang Tua
                        </button>
                        <button type="submit" id="btnSubmitForm" class="ppdb-btn-submit">
                            🚀 Kirim Pendaftaran PPDB
                        </button>
                    </div>
                    <p style="text-align: center; font-size: 0.8rem; color: #94a3b8; margin-top: 12px; margin-bottom: 0;">
                        Nomor Pendaftaran resmi akan otomatis digenerate setelah pengiriman berhasil.
                    </p>
                </div>
                    </div> <!-- /.ppdb-slide-track -->
                </div> <!-- /.ppdb-slide-deck -->
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const totalSteps = 3;
    let currentStep = 1;

    // Deteksi error dari server-side Laravel validation
    @if($errors->hasAny(['doc_kk', 'doc_akta', 'doc_foto', 'doc_rapor', 'agreement']))
        currentStep = 3;
    @elseif($errors->hasAny(['parent_name', 'parent_phone']))
        currentStep = 2;
    @else
        currentStep = 1;
    @endif

    let isTransitioning = false;

    // Perbarui tampilan stepper dan progress bar
    function updateStepperUI(targetStep) {
        const stepItems = document.querySelectorAll('.ppdb-step-item');
        stepItems.forEach(item => {
            const stepNum = parseInt(item.getAttribute('data-step'));
            item.classList.remove('active', 'completed');
            if (stepNum === targetStep) {
                item.classList.add('active');
            } else if (stepNum < targetStep) {
                item.classList.add('completed');
            }
        });

        const conn1 = document.getElementById('connector-1');
        const conn2 = document.getElementById('connector-2');
        if (conn1) {
            if (targetStep > 1) conn1.classList.add('completed');
            else conn1.classList.remove('completed');
        }
        if (conn2) {
            if (targetStep > 2) conn2.classList.add('completed');
            else conn2.classList.remove('completed');
        }

        const progressBar = document.getElementById('ppdbProgressBar');
        if (progressBar) {
            const percent = (targetStep / totalSteps) * 100;
            progressBar.style.width = percent + '%';
            if (targetStep === 3) {
                progressBar.style.background = 'linear-gradient(90deg, #38bdf8, #10b981)';
            } else {
                progressBar.style.background = 'linear-gradient(90deg, #38bdf8, #2563eb)';
            }
        }
    }

    // Tampilkan slide tertentu melalui hardware-accelerated horizontal slide track (Zero Layout Reflow)
    function showSlide(targetStep, shouldScroll = true, immediate = false) {
        if (targetStep === currentStep && !immediate) return;
        if (isTransitioning) return;
        if (targetStep < 1 || targetStep > totalSteps) return;

        const track = document.getElementById('ppdbSlideTrack');
        if (!track) return;

        if (immediate) {
            track.style.transition = 'none';
            track.style.transform = `translateX(-${(targetStep - 1) * 100}%)`;
            void track.offsetWidth;
            track.style.transition = '';
        } else {
            isTransitioning = true;
            track.style.transform = `translateX(-${(targetStep - 1) * 100}%)`;
        }

        // Tandai slide aktif & pasang inert pada slide tidak aktif untuk aksesibilitas form
        for (let i = 1; i <= totalSteps; i++) {
            const s = document.getElementById('slide-' + i);
            if (s) {
                if (i === targetStep) {
                    s.classList.add('active');
                    s.removeAttribute('inert');
                } else {
                    s.classList.remove('active');
                    s.setAttribute('inert', '');
                }
            }
        }

        updateStepperUI(targetStep);
        currentStep = targetStep;

        if (shouldScroll) {
            setTimeout(() => {
                const card = document.querySelector('.ppdb-form-card');
                if (card) {
                    const rect = card.getBoundingClientRect();
                    if (rect.top < -40 || rect.top > 200) {
                        card.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            }, 100);
        }

        if (!immediate) {
            setTimeout(() => {
                isTransitioning = false;
            }, 500);
        }
    }

    // Fungsi global untuk navigasi tombol
    window.nextSlide = function (targetStep) {
        showSlide(targetStep);
    };

    window.prevSlide = function (targetStep) {
        showSlide(targetStep);
    };

    window.jumpToStep = function (targetStep) {
        if (targetStep === currentStep) return;
        showSlide(targetStep);
    };

    // Navigasi dengan tombol Enter di input slide 1 & 2
    const form = document.getElementById('ppdbForm');
    if (form) {
        form.querySelectorAll('#slide-1 input, #slide-2 input').forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    nextSlide(currentStep + 1);
                }
            });
        });

        // Submit form
        form.addEventListener('submit', function (e) {
            const submitBtn = document.getElementById('btnSubmitForm');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '⏳ Mengirim Data Pendaftaran...';
                submitBtn.style.opacity = '0.7';
                submitBtn.style.cursor = 'not-allowed';
            }
        });
    }

    // Feedback visual nama berkas yang diunggah
    document.querySelectorAll('.ppdb-upload-box input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const label = this.parentElement.querySelector('.ppdb-upload-sub');
            if (this.files && this.files.length > 0) {
                label.textContent = '✅ Berkas dipilih: ' + this.files[0].name;
                label.style.color = '#34d399';
                label.style.fontWeight = '700';
            }
        });
    });

    // Inisialisasi slide awal tanpa auto-scroll dan tanpa animasi membalik
    showSlide(currentStep, false, true);
});
</script>
@endpush
@endsection
