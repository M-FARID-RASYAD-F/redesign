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
                <div class="ppdb-tracking-form-row" style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <input type="text" id="no_pendaftaran" name="no_pendaftaran" value="{{ old('no_pendaftaran', $search ?? '') }}" required placeholder="Contoh: PPDB-2026-0001" class="ppdb-form-input" style="flex: 1; min-width: 240px; font-family: monospace; font-weight: 700; text-transform: uppercase;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 28px; font-weight: 700; border-radius: 12px; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <span>Cari Data</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Alert Jika Nomor Tidak Ditemukan -->
        @if(session('error'))
        <div style="background: rgba(239, 68, 68, 0.12); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 16px; padding: 20px; color: #fca5a5; margin-bottom: 30px; display: flex; align-items: flex-start; gap: 12px;">
            <span style="display: flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 50%; background: rgba(239, 68, 68, 0.2); color: #f87171; flex-shrink: 0;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </span>
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
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>Status: Pending (Menunggu Verifikasi)</span>
                        </span>
                    @elseif($registration->status == 'diverifikasi')
                        <span style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            <span>Status: Berkas Diverifikasi (Dalam Seleksi)</span>
                        </span>
                    @elseif($registration->status == 'diterima')
                        <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            <span>Status: DITERIMA (LULUS SELEKSI)</span>
                        </span>
                    @elseif($registration->status == 'ditolak')
                        <span style="background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); font-weight: 800; font-size: 0.9rem; padding: 8px 18px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            <span>Status: Ditolak / Belum Memenuhi Syarat</span>
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
                <h4 style="font-size: 0.95rem; font-weight: 800; color: #ffffff; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    <span>Catatan dari Panitia PPDB:</span>
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
            <div class="ppdb-result-body" style="padding: 30px;">
                <h4 style="font-size: 1rem; font-weight: 800; color: #ffffff; margin-bottom: 16px;">Ringkasan Data Calon Siswa</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; font-size: 0.9rem;">
                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Nama Calon Siswa:</span>
                        <strong style="color: #ffffff;">{{ $registration->full_name }}</strong>
                    </div>

                    <div>
                        <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Jenjang Pendidikan:</span>
                        <strong style="color: #38bdf8; display: inline-flex; align-items: center; gap: 6px;">
                            @if($registration->jenjang === 'sd')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            @elseif($registration->jenjang === 'smp')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                            @elseif($registration->jenjang === 'smk')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16"/></svg>
                            @else
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21.42 10.922a1 1 0 0 0-.019-.838L12.83 3.18a2 2 0 0 0-1.66 0L2.6 10.084a1 1 0 0 0 0 1.832l8.57 6.908a2 2 0 0 0 1.66 0l8.57-6.908a1 1 0 0 0 .02-.994z"/><path d="M6 12.5v5a6 3 0 0 0 12 0v-5"/></svg>
                            @endif
                            <span>{{ $registration->jenjang_label }}</span>
                        </strong>
                        @if($registration->jenjang === 'smk' && $registration->major_choice)
                            <div style="font-size: 0.78rem; color: #c084fc; margin-top: 2px;">
                                Jurusan: <strong>{{ $registration->major_choice }}</strong>
                            </div>
                        @endif
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
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                <span>{{ strtoupper(str_replace('_', ' ', $doc->doc_type)) }}</span>
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
                <a href="{{ route('ppdb.success', $registration->no_pendaftaran) }}" class="btn btn-outline" style="font-size: 0.85rem; padding: 8px 16px; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                    <span>Buka Kartu Pendaftaran</span>
                </a>
                <span style="font-size: 0.8rem; color: #94a3b8;">Pembaruan status terakhir: {{ $registration->updated_at ? $registration->updated_at->diffForHumans() : '-' }}</span>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
