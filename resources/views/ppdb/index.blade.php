@extends('layouts.app')

@section('title', 'Portal PPDB Online 2026/2027 — PKBM Tahfizh At-Tamam / SMKN 1 Nusantara')

@section('konten_utama')
<!-- Hero Section PPDB -->
<section style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%); color: white; padding: 70px 20px; text-align: center; position: relative; overflow: hidden;">
    <div style="max-width: 900px; margin: 0 auto; position: relative; z-index: 2;">
        <span style="display: inline-block; background: rgba(37, 99, 235, 0.3); border: 1px solid rgba(59, 130, 246, 0.5); color: #93c5fd; padding: 6px 18px; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">
            🎓 Penerimaan Peserta Didik Baru (PPDB) Online
        </span>
        <h1 style="font-size: clamp(2rem, 4vw, 3.2rem); font-weight: 800; line-height: 1.2; margin-bottom: 20px;">
            Raih Masa Depan Gemilang & Berkarakter Mulia
        </h1>
        <p style="font-size: 1.1rem; color: #cbd5e1; max-width: 720px; margin: 0 auto 35px; line-height: 1.7;">
            Pendaftaran peserta didik baru Tahun Ajaran 2026/2027 telah dibuka secara daring. Daftar mandiri dari rumah dengan mudah, cepat, dan transparan.
        </p>

        <!-- CTA Buttons -->
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('ppdb.create') }}" class="btn btn-primary" style="padding: 14px 32px; font-size: 1rem; font-weight: 700; border-radius: 12px; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4); display: inline-flex; align-items: center; gap: 8px;">
                ✍️ Isi Formulir Pendaftaran Sekarang
            </a>
            <a href="{{ route('ppdb.tracking') }}" class="btn btn-outline" style="padding: 14px 28px; font-size: 1rem; font-weight: 700; border-radius: 12px; border-color: rgba(255,255,255,0.4); color: white; display: inline-flex; align-items: center; gap: 8px;">
                🔍 Lacak / Cek Status Pendaftaran
            </a>
        </div>
    </div>
</section>

<!-- Statistik & Informasi Gelombang -->
<section style="max-width: 1100px; margin: -30px auto 50px; padding: 0 20px; position: relative; z-index: 10;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px;">
        <div style="background: white; padding: 24px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.06); border-top: 4px solid var(--primary); text-align: center;">
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Status Pendaftaran</div>
            <div style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 6px;">{{ $stats['gelombang'] }}</div>
            <div style="font-size: 0.8rem; color: #10b981; margin-top: 4px; font-weight: 600;">● Pendaftaran Sedang Dibuka</div>
        </div>

        <div style="background: white; padding: 24px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.06); border-top: 4px solid #f59e0b; text-align: center;">
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Batas Akhir Gelombang</div>
            <div style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 6px;">{{ $stats['deadline'] }}</div>
            <div style="font-size: 0.8rem; color: #f59e0b; margin-top: 4px; font-weight: 600;">⏰ Segera Lengkapi Berkas</div>
        </div>

        <div style="background: white; padding: 24px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.06); border-top: 4px solid #10b981; text-align: center;">
            <div style="font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Calon Siswa Terdaftar</div>
            <div style="font-size: 1.8rem; font-weight: 800; color: var(--primary); margin-top: 4px;">{{ $stats['total'] }}+ Pendaftar</div>
            <div style="font-size: 0.8rem; color: #64748b;">dari berbagai sekolah asal</div>
        </div>
    </div>
</section>

<!-- Alur Pendaftaran PPDB 4 Langkah -->
<section style="max-width: 1100px; margin: 0 auto 70px; padding: 0 20px;">
    <div style="text-align: center; margin-bottom: 45px;">
        <span style="color: var(--primary); font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Prosedur PPDB</span>
        <h2 style="font-size: 2rem; font-weight: 800; color: #0f172a; margin-top: 6px;">4 Langkah Mudah Pendaftaran Online</h2>
        <p style="color: #64748b; max-width: 600px; margin: 10px auto 0;">Seluruh tahapan seleksi transparan dan dapat dipantau setiap saat secara daring.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px;">
        <!-- Langkah 1 -->
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; position: relative;">
            <div style="width: 44px; height: 44px; background: #eff6ff; color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 800; margin-bottom: 18px;">1</div>
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Pengisian Formulir</h3>
            <p style="font-size: 0.9rem; color: #64748b; line-height: 1.6;">Mengisi data diri, identitas orang tua/wali, memilih jurusan impian, serta mengunggah berkas syarat (KK/Akta/Foto).</p>
        </div>

        <!-- Langkah 2 -->
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; position: relative;">
            <div style="width: 44px; height: 44px; background: #fffbeb; color: #d97706; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 800; margin-bottom: 18px;">2</div>
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Verifikasi Berkas</h3>
            <p style="font-size: 0.9rem; color: #64748b; line-height: 1.6;">Panitia PPDB memeriksa kelengkapan dan keabsahan dokumen dalam waktu 1x24 jam kerja secara cermat.</p>
        </div>

        <!-- Langkah 3 -->
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; position: relative;">
            <div style="width: 44px; height: 44px; background: #ecfdf5; color: #059669; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 800; margin-bottom: 18px;">3</div>
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Pengumuman Hasil</h3>
            <p style="font-size: 0.9rem; color: #64748b; line-height: 1.6;">Cek status kelulusan penerimaan secara langsung melalui fitur Pelacakan Status menggunakan Nomor Registrasi Anda.</p>
        </div>

        <!-- Langkah 4 -->
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 28px; position: relative;">
            <div style="width: 44px; height: 44px; background: #faf5ff; color: #9333ea; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 800; margin-bottom: 18px;">4</div>
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 10px;">Daftar Ulang</h3>
            <p style="font-size: 0.9rem; color: #64748b; line-height: 1.6;">Calon siswa yang diterima melakukan konfirmasi daftar ulang dan mengikuti orientasi peserta didik baru.</p>
        </div>
    </div>
</section>

<!-- Persyaratan Berkas & Pilihan Program Keahlian -->
<section style="background: #f8fafc; padding: 60px 20px; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; margin-bottom: 60px;">
    <div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; align-items: start;">
        
        <!-- Dokumen Persyaratan -->
        <div>
            <span style="color: var(--primary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase;">Checklist Syarat</span>
            <h3 style="font-size: 1.7rem; font-weight: 800; color: #0f172a; margin: 6px 0 16px;">Dokumen yang Perlu Disiapkan</h3>
            <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 24px;">Format file: PDF, JPG, atau PNG dengan ukuran maksimal 3 MB per berkas.</p>

            <ul style="list-style: none; display: flex; flex-direction: column; gap: 14px;">
                <li style="display: flex; gap: 12px; align-items: flex-start; background: white; padding: 14px 18px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <span style="color: #10b981; font-size: 1.2rem;">✔️</span>
                    <div>
                        <strong style="color: #0f172a; display: block; font-size: 0.95rem;">Kartu Keluarga (KK)</strong>
                        <span style="color: #64748b; font-size: 0.85rem;">Scan atau foto jelas KK yang masih berlaku</span>
                    </div>
                </li>

                <li style="display: flex; gap: 12px; align-items: flex-start; background: white; padding: 14px 18px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <span style="color: #10b981; font-size: 1.2rem;">✔️</span>
                    <div>
                        <strong style="color: #0f172a; display: block; font-size: 0.95rem;">Akta Kelahiran Calon Siswa</strong>
                        <span style="color: #64748b; font-size: 0.85rem;">Sebagai bukti keabsahan identitas dan usia</span>
                    </div>
                </li>

                <li style="display: flex; gap: 12px; align-items: flex-start; background: white; padding: 14px 18px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <span style="color: #10b981; font-size: 1.2rem;">✔️</span>
                    <div>
                        <strong style="color: #0f172a; display: block; font-size: 0.95rem;">Pas Foto Berwarna (3x4)</strong>
                        <span style="color: #64748b; font-size: 0.85rem;">Latar belakang merah atau biru berpakaian rapi</span>
                    </div>
                </li>

                <li style="display: flex; gap: 12px; align-items: flex-start; background: white; padding: 14px 18px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <span style="color: #10b981; font-size: 1.2rem;">✔️</span>
                    <div>
                        <strong style="color: #0f172a; display: block; font-size: 0.95rem;">Rapor Terakhir / SKL</strong>
                        <span style="color: #64748b; font-size: 0.85rem;">Surat Keterangan Lulus dari sekolah asal (SMP/MTs)</span>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Pilihan Jurusan -->
        <div>
            <span style="color: var(--primary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase;">Program Pilihan</span>
            <h3 style="font-size: 1.7rem; font-weight: 800; color: #0f172a; margin: 6px 0 16px;">Jurusan Kejuruan Tersedia</h3>
            <p style="color: #64748b; font-size: 0.95rem; margin-bottom: 24px;">Pilih program keahlian yang selaras dengan minat dan bakat Anda.</p>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                @foreach($majors as $m)
                <div style="background: white; padding: 16px 20px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <span style="font-size: 1.6rem;">{{ $m->icon ?? '💻' }}</span>
                        <div>
                            <h4 style="font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 2px;">{{ $m->name }}</h4>
                            <p style="font-size: 0.8rem; color: #64748b;">{{ Str::limit($m->description, 60) }}</p>
                        </div>
                    </div>
                    <span style="background: #eff6ff; color: var(--primary); font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 9999px; white-space: nowrap;">Tersedia</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

<!-- Banner Bantuan & Call To Action -->
<section style="max-width: 1100px; margin: 0 auto 80px; padding: 0 20px;">
    <div style="background: linear-gradient(135deg, #1e293b, #0f172a); color: white; padding: 40px; border-radius: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 24px;">
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 8px;">Butuh Bantuan saat Mengisi Formulir?</h3>
            <p style="color: #94a3b8; font-size: 0.95rem;">Hubungi Tim Helpdesk Panitia PPDB kami via WhatsApp di <strong>0812-3456-7890</strong> (Senin - Sabtu: 08.00 - 15.00 WIB).</p>
        </div>
        <div>
            <a href="{{ route('ppdb.create') }}" class="btn btn-primary" style="padding: 12px 28px; font-weight: 700; border-radius: 10px;">
                Mulai Pendaftaran ➜
            </a>
        </div>
    </div>
</section>
@endsection
