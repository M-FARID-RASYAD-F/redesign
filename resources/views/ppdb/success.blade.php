@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil — PPDB Online At-Tamam Edu')

@section('konten_utama')
<section style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); padding: 60px 20px 90px;">
    <div style="max-width: 720px; margin: 0 auto;">
        
        <!-- Header Sukses -->
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="width: 72px; height: 72px; background: #ecfdf5; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; margin: 0 auto 16px; box-shadow: 0 10px 25px rgba(16, 185, 129, 0.2);">
                ✓
            </div>
            <h1 style="font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">Pendaftaran PPDB Berhasil!</h1>
            <p style="color: #64748b; font-size: 1rem;">Data calon peserta didik baru telah tersimpan di sistem kami.</p>
        </div>

        <!-- Kartu Bukti Pendaftaran Digital (Printable Card) -->
        <div id="printable-card" style="background: white; border-radius: 20px; border: 2px solid #e2e8f0; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08); overflow: hidden; margin-bottom: 30px;">
            
            <!-- Header Kartu -->
            <div style="background: linear-gradient(135deg, #0f172a, #1e3a8a); color: white; padding: 24px 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 14px;">
                <div>
                    <span style="font-size: 0.8rem; color: #93c5fd; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">KARTU BUKTI PENDAFTARAN</span>
                    <h2 style="font-size: 1.25rem; font-weight: 800; margin: 2px 0 0;">PKBM Tahfizh At-Tamam / SMKN 1 Nusantara</h2>
                </div>
                <div style="background: rgba(255,255,255,0.15); padding: 8px 16px; border-radius: 10px; text-align: right;">
                    <span style="font-size: 0.75rem; color: #cbd5e1; display: block;">Tahun Ajaran</span>
                    <strong style="font-size: 0.95rem;">2026 / 2027</strong>
                </div>
            </div>

            <!-- Box Nomor Pendaftaran -->
            <div style="background: #f8fafc; padding: 20px 30px; border-bottom: 1px dashed #cbd5e1; text-align: center;">
                <span style="font-size: 0.85rem; color: #64748b; font-weight: 600;">SIMPAN & CATAT NOMOR PENDAFTARAN ANDA:</span>
                <div style="font-size: 2rem; font-weight: 900; color: var(--primary); font-family: monospace; letter-spacing: 2px; margin: 6px 0;">
                    {{ $registration->no_pendaftaran }}
                </div>
                <span style="font-size: 0.8rem; color: #64748b;">Gunakan nomor di atas untuk melakukan pengecekan / pelacakan status seleksi.</span>
            </div>

            <!-- Detail Data Calon Siswa -->
            <div style="padding: 30px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem;">
                    <tbody>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 0; color: #64748b; width: 40%;">Nama Calon Siswa</td>
                            <td style="padding: 10px 0; font-weight: 700; color: #0f172a;">{{ $registration->full_name }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 0; color: #64748b;">Jenis Kelamin</td>
                            <td style="padding: 10px 0; font-weight: 600; color: #0f172a;">{{ $registration->gender == 'L' ? 'Laki-laki (Ikhwan)' : 'Perempuan (Akhwat)' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 0; color: #64748b;">Tanggal Lahir</td>
                            <td style="padding: 10px 0; font-weight: 600; color: #0f172a;">{{ $registration->birth_date ? $registration->birth_date->translatedFormat('d F Y') : '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 0; color: #64748b;">Pilihan Jurusan</td>
                            <td style="padding: 10px 0; font-weight: 700; color: var(--primary);">
                                <span style="background: #eff6ff; padding: 4px 10px; border-radius: 6px;">{{ strtoupper($registration->major_choice) }}</span>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 0; color: #64748b;">Nama Orang Tua / Wali</td>
                            <td style="padding: 10px 0; font-weight: 600; color: #0f172a;">{{ $registration->parent_name }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 0; color: #64748b;">Nomor WhatsApp</td>
                            <td style="padding: 10px 0; font-weight: 600; color: #0f172a;">{{ $registration->parent_phone }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 0; color: #64748b;">Alamat</td>
                            <td style="padding: 10px 0; font-size: 0.9rem; color: #334155;">{{ $registration->address }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 0; color: #64748b;">Status Awal</td>
                            <td style="padding: 10px 0;">
                                <span style="background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 9999px; font-weight: 700; font-size: 0.85rem;">
                                    ⏳ Menunggu Verifikasi Panitia
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; color: #64748b;">Waktu Pengajuan</td>
                            <td style="padding: 10px 0; font-size: 0.85rem; color: #64748b;">{{ $registration->created_at ? $registration->created_at->translatedFormat('l, d F Y - H:i') . ' WIB' : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Bukti -->
            <div style="background: #f8fafc; padding: 16px 30px; border-top: 1px solid #e2e8f0; font-size: 0.8rem; color: #64748b; text-align: center;">
                Kartu ini diterbitkan secara sah oleh Sistem PPDB Online PKBM Tahfizh At-Tamam / SMKN 1 Nusantara.
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-bottom: 35px;">
            <button onclick="window.print()" class="btn btn-primary" style="padding: 12px 24px; font-weight: 700; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                🖨️ Cetak Kartu Bukti
            </button>
            <a href="{{ route('ppdb.tracking') }}" class="btn btn-outline" style="padding: 12px 24px; font-weight: 700; border-radius: 10px; color: var(--primary); border-color: var(--primary); display: inline-flex; align-items: center; gap: 8px;">
                🔍 Lacak Status Pendaftaran
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline" style="padding: 12px 20px; font-weight: 600; border-radius: 10px; color: #64748b; border-color: #cbd5e1;">
                🏠 Kembali ke Beranda
            </a>
        </div>

        <!-- Panduan Tahap Selanjutnya -->
        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 14px; padding: 22px 26px;">
            <h3 style="font-size: 1.05rem; font-weight: 800; color: #92400e; margin-bottom: 8px;">📌 Langkah Selanjutnya:</h3>
            <ol style="color: #78350f; font-size: 0.9rem; padding-left: 20px; line-height: 1.7;">
                <li>Panitia PPDB akan memverifikasi data dan berkas yang Anda unggah dalam 1x24 jam kerja.</li>
                <li>Simpan atau tangkap layar (*screenshot*) <strong>Nomor Pendaftaran</strong> Anda.</li>
                <li>Anda dapat memantau status verifikasi dan hasil seleksi secara berkala pada menu <strong>Cek Status PPDB</strong>.</li>
                <li>Jika terdapat kendala atau pertanyaan, silakan hubungi kontak panitia di <strong>(021) 555-0192</strong> atau WhatsApp <strong>0812-3456-7890</strong>.</li>
            </ol>
        </div>
    </div>
</section>

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
    }
    .navbar, .footer {
        display: none !important;
    }
}
</style>
@endsection
