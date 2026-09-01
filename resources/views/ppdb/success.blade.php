@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil — PPDB Online PKBM Tahfizh At-Tamam')

@section('konten_utama')
<div class="ppdb-page-container">
    <div style="max-width: 760px; margin: 0 auto;">
        
        <!-- Header Sukses -->
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 72px; height: 72px; background: rgba(16, 185, 129, 0.15); color: #34d399; border: 2px solid #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 16px; box-shadow: 0 0 25px rgba(16, 185, 129, 0.35);">
                ✓
            </div>
            <h1 class="ppdb-section-title" style="font-size: 2.2rem; margin-bottom: 6px;">Pendaftaran PPDB Berhasil!</h1>
            <p class="ppdb-section-desc" style="font-size: 1rem;">Data calon peserta didik baru telah tersimpan di sistem kami.</p>
        </div>

        <!-- Kartu Bukti Pendaftaran Digital (Printable Card) -->
        <div id="printable-card" class="ppdb-printable-card">
            
            <!-- Header Kartu -->
            <div class="ppdb-card-header">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 48px; height: 48px; background: white; border-radius: 10px; padding: 3px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo PKBM Tahfizh At-Tamam" style="width: 100%; height: 100%; object-fit: contain; border-radius: 6px;">
                    </div>
                    <div>
                        <span style="font-size: 0.8rem; color: #93c5fd; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">KARTU BUKTI PENDAFTARAN</span>
                        <h2 style="font-size: 1.25rem; font-weight: 800; margin: 2px 0 0; color: #ffffff;">PKBM Tahfizh At-Tamam</h2>
                    </div>
                </div>
                <div style="background: rgba(255,255,255,0.15); padding: 8px 16px; border-radius: 10px; text-align: right;">
                    <span style="font-size: 0.75rem; color: #cbd5e1; display: block;">Tahun Ajaran</span>
                    <strong style="font-size: 0.95rem; color: #ffffff;">2026 / 2027</strong>
                </div>
            </div>

            <!-- Box Nomor Pendaftaran -->
            <div class="ppdb-reg-banner">
                <span style="font-size: 0.85rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">SIMPAN & CATAT NOMOR PENDAFTARAN ANDA:</span>
                <div class="ppdb-reg-number">
                    {{ $registration->no_pendaftaran }}
                </div>
                <span style="font-size: 0.8rem; color: #94a3b8;">Gunakan nomor di atas untuk melakukan pengecekan / pelacakan status seleksi.</span>
            </div>

            <!-- Detail Data Calon Siswa -->
            <div style="padding: 30px;">
                <table class="ppdb-summary-table">
                    <tbody>
                        <tr>
                            <td>Nama Calon Siswa</td>
                            <td>{{ $registration->full_name }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>{{ $registration->gender == 'L' ? 'Laki-laki (Ikhwan)' : 'Perempuan (Akhwat)' }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>{{ $registration->birth_date ? $registration->birth_date->translatedFormat('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td>Pilihan Jurusan</td>
                            <td>
                                <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); padding: 4px 10px; border-radius: 6px; font-weight: 700;">
                                    {{ strtoupper($registration->major_choice) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Orang Tua / Wali</td>
                            <td>{{ $registration->parent_name }}</td>
                        </tr>
                        <tr>
                            <td>Nomor WhatsApp</td>
                            <td>{{ $registration->parent_phone }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>{{ $registration->address }}</td>
                        </tr>
                        <tr>
                            <td>Status Awal</td>
                            <td>
                                <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); padding: 4px 12px; border-radius: 9999px; font-weight: 700; font-size: 0.85rem;">
                                    ⏳ Menunggu Verifikasi Panitia
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Waktu Pengajuan</td>
                            <td>{{ $registration->created_at ? $registration->created_at->translatedFormat('l, d F Y - H:i') . ' WIB' : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Bukti -->
            <div style="background: rgba(30, 41, 59, 0.5); padding: 16px 30px; border-top: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.8rem; color: #94a3b8; text-align: center;">
                Kartu ini diterbitkan secara sah oleh Sistem PPDB Online PKBM Tahfizh At-Tamam.
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-bottom: 35px;">
            <button onclick="window.print()" class="btn btn-primary" style="padding: 12px 24px; font-weight: 700; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                🖨️ Cetak Kartu Bukti
            </button>
            <a href="{{ route('ppdb.tracking') }}" class="btn btn-outline" style="padding: 12px 24px; font-weight: 700; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px;">
                🔍 Lacak Status Pendaftaran
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline" style="padding: 12px 20px; font-weight: 600; border-radius: 10px;">
                🏠 Kembali ke Beranda
            </a>
        </div>

        <!-- Panduan Tahap Selanjutnya -->
        <div style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.35); border-radius: 16px; padding: 22px 26px;">
            <h3 style="font-size: 1.05rem; font-weight: 800; color: #fbbf24; margin-bottom: 8px;">📌 Langkah Selanjutnya:</h3>
            <ol style="color: #cbd5e1; font-size: 0.9rem; padding-left: 20px; line-height: 1.7; margin: 0;">
                <li>Panitia PPDB akan memverifikasi data dan berkas yang Anda unggah dalam 1x24 jam kerja.</li>
                <li>Simpan atau tangkap layar (*screenshot*) <strong>Nomor Pendaftaran</strong> Anda.</li>
                <li>Anda dapat memantau status verifikasi dan hasil seleksi secara berkala pada menu <strong>Cek Status PPDB</strong>.</li>
                <li>Jika terdapat kendala atau pertanyaan, silakan hubungi kontak panitia di <strong>(021) 555-0192</strong> atau WhatsApp <strong>0812-0000-0000</strong>.</li>
            </ol>
        </div>
    </div>
</div>

<!-- Print Styling -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printable-card, #printable-card * {
        visibility: visible;
    }
    #printable-card {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none;
        border: 1px solid #000;
        background: #fff !important;
        color: #000 !important;
    }
    #printable-card table td {
        color: #000 !important;
        border-color: #ddd !important;
    }
    .navbar, .footer {
        display: none !important;
    }
}
</style>
@endsection
