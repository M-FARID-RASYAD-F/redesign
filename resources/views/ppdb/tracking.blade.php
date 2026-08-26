@extends('layouts.app')

@section('title', 'Lacak Status Pendaftaran PPDB — At-Tamam Edu')

@section('konten_utama')
<section style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%); padding: 60px 20px 90px; min-height: 70vh;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <!-- Header Halaman Tracking -->
        <div style="text-align: center; margin-bottom: 35px;">
            <span style="color: var(--primary); font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px;">Tracking Sistem</span>
            <h1 style="font-size: clamp(1.8rem, 3vw, 2.4rem); font-weight: 800; color: #0f172a; margin-top: 4px;">Lacak Status PPDB Online</h1>
            <p style="color: #64748b; font-size: 1rem; margin-top: 6px;">Masukkan Nomor Pendaftaran resmi untuk memantau progres seleksi calon siswa.</p>
        </div>

        <!-- Form Pencarian Nomor Pendaftaran -->
        <div style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; padding: 24px 28px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); margin-bottom: 35px;">
            <form action="{{ route('ppdb.check') }}" method="POST">
                @csrf
                <label for="no_pendaftaran" style="display: block; font-weight: 700; font-size: 0.9rem; color: #334155; margin-bottom: 8px;">
                    Nomor Pendaftaran PPDB:
                </label>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <input type="text" id="no_pendaftaran" name="no_pendaftaran" value="{{ old('no_pendaftaran', $search ?? '') }}" required placeholder="Contoh: PPDB-2026-0001 atau PPDB20260001" style="flex: 1; min-width: 240px; padding: 14px 18px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 1rem; font-family: monospace; font-weight: 700; text-transform: uppercase;">
                    <button type="submit" class="btn btn-primary" style="padding: 14px 28px; font-weight: 700; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                        🔍 Cari Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Alert Jika Nomor Tidak Ditemukan -->
        @if(session('error'))
        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 14px; padding: 20px; color: #b91c1c; margin-bottom: 30px; display: flex; align-items: flex-start; gap: 12px;">
            <span style="font-size: 1.4rem;">❌</span>
            <div>
                <strong style="display: block; font-size: 0.95rem; margin-bottom: 2px;">Data Tidak Ditemukan!</strong>
                <span style="font-size: 0.9rem;">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- TAMPILAN HASIL JIKA REGISTRATION DITEMUKAN -->
        @if(isset($registration))
        <div style="background: white; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 15px 35px rgba(0,0,0,0.06); overflow: hidden;">
            
            <!-- Header Status Box -->
            <div style="padding: 26px 30px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div>
                    <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">NOMOR PENDAFTARAN</span>
                    <h2 style="font-size: 1.4rem; font-weight: 900; font-family: monospace; color: var(--primary); margin: 2px 0 0;">{{ $registration->no_pendaftaran }}</h2>
                </div>

                <!-- Status Badge -->
                <div>
                    @if($registration->status == 'pending')
                        <span style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a; font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            ⏳ Status: Pending (Menunggu Verifikasi)
                        </span>
                    @elseif($registration->status == 'diverifikasi')
                        <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            📋 Status: Berkas Diverifikasi (Dalam Seleksi)
                        </span>
                    @elseif($registration->status == 'diterima')
                        <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            🎉 Status: DITERIMA (LULUS SELEKSI)
                        </span>
                    @elseif($registration->status == 'ditolak')
                        <span style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            ❌ Status: Ditolak / Belum Memenuhi Syarat
                        </span>
                    @endif
                </div>
            </div>

            <!-- Visual Step Progress Bar -->
            <div style="background: #f8fafc; padding: 26px 30px; border-bottom: 1px solid #e2e8f0;">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; text-align: center;">
                    
                    <!-- Step 1: Pengajuan -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px;">✓</div>
                        <span style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">1. Pendaftaran</span>
                        <span style="font-size: 0.75rem; color: #64748b;">Selesai diajukan</span>
                    </div>

                    <!-- Step 2: Verifikasi -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        @if($registration->status == 'pending')
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #f59e0b; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px;">2</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #d97706;">2. Verifikasi</span>
                            <span style="font-size: 0.75rem; color: #d97706;">Sedang diproses</span>
                        @else
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px;">✓</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #0f172a;">2. Verifikasi</span>
                            <span style="font-size: 0.75rem; color: #10b981;">Berkas selesai dicek</span>
                        @endif
                    </div>

                    <!-- Step 3: Keputusan -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        @if($registration->status == 'diterima')
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px;">✓</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #059669;">3. Diterima</span>
                            <span style="font-size: 0.75rem; color: #059669;">Siap daftar ulang</span>
                        @elseif($registration->status == 'ditolak')
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #ef4444; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px;">✕</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #b91c1c;">3. Ditolak</span>
                            <span style="font-size: 0.75rem; color: #b91c1c;">Tidak lolos seleksi</span>
                        @else
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px;">3</div>
                            <span style="font-size: 0.85rem; font-weight: 600; color: #64748b;">3. Pengumuman</span>
                            <span style="font-size: 0.75rem; color: #94a3b8;">Menunggu hasil</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Catatan / Catatan Panitia PPDB -->
            <div style="padding: 24px 30px; background: {{ $registration->status == 'diterima' ? '#ecfdf5' : ($registration->status == 'ditolak' ? '#fef2f2' : '#fffbeb') }}; border-bottom: 1px solid #e2e8f0;">
                <h4 style="font-size: 0.95rem; font-weight: 800; color: #0f172a; margin-bottom: 6px;">
                    📝 Catatan dari Panitia PPDB:
                </h4>
                <p style="font-size: 0.9rem; color: #334155; line-height: 1.6; margin: 0;">
                    {{ $registration->notes ?? 'Belum ada catatan khusus dari panitia pemeriksa berkas.' }}
                </p>

                @if($registration->status == 'diterima')
                    <div style="margin-top: 14px; padding-top: 12px; border-top: 1px dashed rgba(0,0,0,0.1);">
                        <strong style="color: #047857; font-size: 0.9rem;">Selamat bergabung di keluarga besar PKBM Tahfizh At-Tamam!</strong>
                        <p style="font-size: 0.85rem; color: #065f46; margin-top: 4px;">Silakan datang ke sekolah membawa berkas fisik asli pada jadwal daftar ulang yang ditentukan.</p>
                    </div>
                @endif
            </div>

            <!-- Detail Data Calon Siswa Terdaftar -->
            <div style="padding: 30px;">
                <h4 style="font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 16px;">Ringkasan Data Calon Siswa</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; font-size: 0.9rem;">
                    <div>
                        <span style="color: #64748b; font-size: 0.8rem; display: block;">Nama Calon Siswa:</span>
                        <strong style="color: #0f172a;">{{ $registration->full_name }}</strong>
                    </div>

                    <div>
                        <span style="color: #64748b; font-size: 0.8rem; display: block;">Pilihan Jurusan:</span>
                        <strong style="color: var(--primary); font-weight: 800;">{{ strtoupper($registration->major_choice) }}</strong>
                    </div>

                    <div>
                        <span style="color: #64748b; font-size: 0.8rem; display: block;">Nama Orang Tua / Wali:</span>
                        <strong style="color: #0f172a;">{{ $registration->parent_name }}</strong>
                    </div>

                    <div>
                        <span style="color: #64748b; font-size: 0.8rem; display: block;">Waktu Pendaftaran:</span>
                        <strong style="color: #0f172a;">{{ $registration->created_at ? $registration->created_at->translatedFormat('d F Y - H:i') : '-' }} WIB</strong>
                    </div>
                </div>

                <!-- Dokumen yang Terunggah -->
                <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                    <h5 style="font-size: 0.85rem; font-weight: 700; color: #475569; margin-bottom: 10px;">Status Dokumen Pendukung:</h5>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @forelse($registration->documents as $doc)
                            <span style="background: #f1f5f9; padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; color: #334155; display: inline-flex; align-items: center; gap: 6px;">
                                📄 {{ strtoupper(str_replace('_', ' ', $doc->doc_type)) }}
                                <span style="color: {{ $doc->verification_status == 'valid' ? '#10b981' : ($doc->verification_status == 'tidak_valid' ? '#ef4444' : '#f59e0b') }}; font-weight: 700;">
                                    ({{ ucfirst($doc->verification_status) }})
                                </span>
                            </span>
                        @empty
                            <span style="color: #94a3b8; font-size: 0.85rem;">Tidak ada berkas unggahan online (verifikasi berkas manual di sekolah).</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Footer Card Action -->
            <div style="background: #f8fafc; padding: 18px 30px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <a href="{{ route('ppdb.success', $registration->no_pendaftaran) }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 8px 16px; color: var(--primary); border-color: var(--primary);">
                    🖨️ Buka Kartu Pendaftaran
                </a>
                <span style="font-size: 0.8rem; color: #64748b;">Pembaruan status terakhir: {{ $registration->updated_at ? $registration->updated_at->diffForHumans() : '-' }}</span>
            </div>
        </div>
        @endif

    </div>
</section>
@endsection
