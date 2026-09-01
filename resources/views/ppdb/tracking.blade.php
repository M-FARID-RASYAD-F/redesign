@extends('layouts.app')

@section('title', 'Lacak Status Pendaftaran PPDB — PKBM Tahfizh At-Tamam')

@section('konten_utama')
<div class="ppdb-page-container">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <!-- Header Halaman Tracking -->
        <div style="text-align: center; margin-bottom: 35px;">
            <span class="ppdb-section-tag">Tracking Sistem</span>
            <h1 class="ppdb-section-title" style="font-size: clamp(1.8rem, 3vw, 2.4rem); margin: 6px 0 0;">Lacak Status PPDB Online</h1>
            <p class="ppdb-section-desc" style="margin-top: 6px;">Masukkan Nomor Pendaftaran resmi untuk memantau progres seleksi calon siswa.</p>
        </div>

        <!-- Form Pencarian Nomor Pendaftaran -->
        <div class="ppdb-tracking-box">
            <form action="{{ route('ppdb.check') }}" method="POST">
                @csrf
                <label for="no_pendaftaran" class="ppdb-form-label" style="margin-bottom: 8px;">
                    Nomor Pendaftaran PPDB:
                </label>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <input type="text" id="no_pendaftaran" name="no_pendaftaran" value="{{ old('no_pendaftaran', $search ?? '') }}" required placeholder="Contoh: PPDB-2026-0001" class="ppdb-form-input" style="flex: 1; min-width: 240px; font-family: monospace; font-weight: 700; text-transform: uppercase;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-weight: 700; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                        🔍 Cari Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Alert Jika Nomor Tidak Ditemukan -->
        @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 16px; padding: 20px; color: #fca5a5; margin-bottom: 30px; display: flex; align-items: flex-start; gap: 12px;">
            <span style="font-size: 1.4rem;">❌</span>
            <div>
                <strong style="display: block; font-size: 0.95rem; margin-bottom: 2px; color: #ffffff;">Data Tidak Ditemukan!</strong>
                <span style="font-size: 0.9rem;">{{ session('error') }}</span>
            </div>
        </div>
        @endif

        <!-- TAMPILAN HASIL JIKA REGISTRATION DITEMUKAN -->
        @if(isset($registration))
        <div class="ppdb-result-card">
            
            <!-- Header Status Box -->
            <div class="ppdb-result-header">
                <div>
                    <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">NOMOR PENDAFTARAN</span>
                    <h2 class="ppdb-reg-number" style="font-size: 1.5rem; margin: 2px 0 0; text-align: left;">{{ $registration->no_pendaftaran }}</h2>
                </div>

                <!-- Status Badge -->
                <div>
                    @if($registration->status == 'pending')
                        <span style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            ⏳ Status: Pending (Menunggu Verifikasi)
                        </span>
                    @elseif($registration->status == 'diverifikasi')
                        <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            📋 Status: Berkas Diverifikasi (Dalam Seleksi)
                        </span>
                    @elseif($registration->status == 'diterima')
                        <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            🎉 Status: DITERIMA (LULUS SELEKSI)
                        </span>
                    @elseif($registration->status == 'ditolak')
                        <span style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            ❌ Status: Ditolak / Belum Memenuhi Syarat
                        </span>
                    @endif
                </div>
            </div>

            <!-- Visual Step Progress Bar -->
            <div class="ppdb-timeline-bar">
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; text-align: center;">
                    
                    <!-- Step 1: Pengajuan -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);">✓</div>
                        <span style="font-size: 0.85rem; font-weight: 700; color: #ffffff;">1. Pendaftaran</span>
                        <span style="font-size: 0.75rem; color: #94a3b8;">Selesai diajukan</span>
                    </div>

                    <!-- Step 2: Verifikasi -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        @if($registration->status == 'pending')
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #f59e0b; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(245, 158, 11, 0.4);">2</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #fbbf24;">2. Verifikasi</span>
                            <span style="font-size: 0.75rem; color: #fbbf24;">Sedang diproses</span>
                        @else
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);">✓</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #ffffff;">2. Verifikasi</span>
                            <span style="font-size: 0.75rem; color: #34d399;">Berkas selesai dicek</span>
                        @endif
                    </div>

                    <!-- Step 3: Keputusan -->
                    <div style="display: flex; flex-direction: column; align-items: center;">
                        @if($registration->status == 'diterima')
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #10b981; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);">✓</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #34d399;">3. Diterima</span>
                            <span style="font-size: 0.75rem; color: #34d399;">Siap daftar ulang</span>
                        @elseif($registration->status == 'ditolak')
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #ef4444; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px; box-shadow: 0 0 12px rgba(239, 68, 68, 0.4);">✕</div>
                            <span style="font-size: 0.85rem; font-weight: 700; color: #f87171;">3. Ditolak</span>
                            <span style="font-size: 0.75rem; color: #f87171;">Tidak lolos seleksi</span>
                        @else
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,0.1); color: #94a3b8; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem; margin-bottom: 6px;">3</div>
                            <span style="font-size: 0.85rem; font-weight: 600; color: #94a3b8;">3. Pengumuman</span>
                            <span style="font-size: 0.75rem; color: #64748b;">Menunggu hasil</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Catatan / Catatan Panitia PPDB -->
            <div style="padding: 24px 30px; background: rgba(30, 41, 59, 0.4); border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                <h4 style="font-size: 0.95rem; font-weight: 800; color: #ffffff; margin-bottom: 6px;">
                    📝 Catatan dari Panitia PPDB:
                </h4>
                <p style="font-size: 0.9rem; color: #cbd5e1; line-height: 1.6; margin: 0;">
                    {{ $registration->notes ?? 'Belum ada catatan khusus dari panitia pemeriksa berkas.' }}
                </p>

                @if($registration->status == 'diterima')
                    <div style="margin-top: 14px; padding-top: 12px; border-top: 1px dashed rgba(255,255,255,0.15);">
                        <strong style="color: #34d399; font-size: 0.9rem;">Selamat bergabung di keluarga besar PKBM Tahfizh At-Tamam!</strong>
                        <p style="font-size: 0.85rem; color: #a7f3d0; margin-top: 4px;">Silakan datang ke sekolah membawa berkas fisik asli pada jadwal daftar ulang yang ditentukan.</p>
                    </div>
                @endif
            </div>

            <!-- Detail Data Calon Siswa Terdaftar -->
            <div style="padding: 30px;">
                <h4 style="font-size: 1rem; font-weight: 800; color: #ffffff; margin-bottom: 16px;">Ringkasan Data Calon Siswa</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; font-size: 0.9rem;">
                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Nama Calon Siswa:</span>
                        <strong style="color: #ffffff;">{{ $registration->full_name }}</strong>
                    </div>

                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Pilihan Jurusan:</span>
                        <strong style="color: #38bdf8; font-weight: 800;">{{ strtoupper($registration->major_choice) }}</strong>
                    </div>

                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Nama Orang Tua / Wali:</span>
                        <strong style="color: #ffffff;">{{ $registration->parent_name }}</strong>
                    </div>

                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Waktu Pendaftaran:</span>
                        <strong style="color: #ffffff;">{{ $registration->created_at ? $registration->created_at->translatedFormat('d F Y - H:i') : '-' }} WIB</strong>
                    </div>
                </div>

                <!-- Dokumen yang Terunggah -->
                <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                    <h5 style="font-size: 0.85rem; font-weight: 700; color: #cbd5e1; margin-bottom: 10px;">Status Dokumen Pendukung:</h5>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @forelse($registration->documents as $doc)
                            <span style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; color: #ffffff; display: inline-flex; align-items: center; gap: 6px;">
                                📄 {{ strtoupper(str_replace('_', ' ', $doc->doc_type)) }}
                                <span style="color: {{ $doc->verification_status == 'valid' ? '#34d399' : ($doc->verification_status == 'tidak_valid' ? '#f87171' : '#fbbf24') }}; font-weight: 700;">
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
            <div style="background: rgba(30, 41, 59, 0.4); padding: 18px 30px; border-top: 1px solid rgba(255, 255, 255, 0.08); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <a href="{{ route('ppdb.success', $registration->no_pendaftaran) }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 8px 16px; border-radius: 8px;">
                    🖨️ Buka Kartu Pendaftaran
                </a>
                <span style="font-size: 0.8rem; color: #94a3b8;">Pembaruan status terakhir: {{ $registration->updated_at ? $registration->updated_at->diffForHumans() : '-' }}</span>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
