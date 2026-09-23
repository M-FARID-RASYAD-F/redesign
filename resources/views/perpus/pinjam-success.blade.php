@extends('layouts.app')

@section('title', 'Pengajuan Berhasil - Kode: ' . $loan->loan_code)

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-compact">
        
        <div class="perpus-card-surface text-center p-6 sm:p-12 overflow-hidden">
            
            <!-- Success Icon -->
            <div class="w-20 h-20 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto mb-6 shadow-inner border border-emerald-500/30">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <span class="inline-block px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 uppercase tracking-wider mb-3 border border-emerald-500/30">
                Pengajuan Peminjaman Terkirim
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">
                Terima Kasih, Pengajuan Berhasil!
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mb-8 max-w-md mx-auto leading-relaxed">
                Permintaan peminjaman buku Anda telah tercatat di sistem perpustakaan dan sedang menunggu verifikasi petugas.
            </p>

            <!-- Loan Code Display Box -->
            <div class="perpus-card-subsurface p-6 mb-8 text-center relative overflow-hidden">
                <div class="text-xs uppercase tracking-widest text-slate-400 font-semibold mb-2">Kode Referensi Peminjaman</div>
                <div id="loanCodeText" class="text-2xl sm:text-4xl font-extrabold font-mono text-emerald-400 tracking-wider select-all mb-3">
                    {{ $loan->loan_code }}
                </div>
                <button type="button" onclick="navigator.clipboard.writeText('{{ $loan->loan_code }}'); this.innerText='Tersalin!'; setTimeout(()=>this.innerText='Salin Kode', 2000)" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 hover:bg-white/20 text-slate-200 text-xs font-semibold rounded-lg transition-colors border border-white/15">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span>Salin Kode</span>
                </button>
            </div>

            <!-- Details Summary -->
            <div class="perpus-card-subsurface p-5 mb-8 text-left text-sm space-y-3">
                <div class="flex justify-between items-center pb-2 border-b border-white/10">
                    <span class="text-slate-400">Judul Buku</span>
                    <span class="font-bold text-white text-right">{{ $loan->book->title }}</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b border-white/10">
                    <span class="text-slate-400">Lokasi Rak</span>
                    <span class="font-mono text-emerald-400 font-semibold">{{ $loan->book->rack_location ?: '-' }}</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b border-white/10">
                    <span class="text-slate-400">Estimasi Jatuh Tempo</span>
                    <span class="font-bold text-emerald-400">{{ $loan->due_at ? $loan->due_at->format('d F Y') : '7 hari setelah buku diambil' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400">Status Saat Ini</span>
                    <span class="px-2.5 py-1 bg-amber-500/20 text-amber-300 border border-amber-500/30 rounded-full text-xs font-bold">
                        {{ $loan->status_label }}
                    </span>
                </div>
            </div>

            <!-- Instructions Notice -->
            <div class="bg-blue-500/10 border border-blue-500/30 rounded-2xl p-5 mb-8 text-left text-xs sm:text-sm text-blue-200 leading-relaxed flex gap-3.5">
                <svg class="w-5 h-5 text-blue-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <strong class="font-semibold block mb-1 text-blue-300">Langkah Selanjutnya:</strong>
                    Simpan atau tangkap layar (screenshot) kode peminjaman di atas. Tunjukkan kode ini kepada petugas perpustakaan di sekolah saat Anda mengambil fisik buku.
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <a href="{{ route('perpus.tracking') }}" class="perpus-btn-borrow w-full sm:w-auto flex-1 py-3.5 px-6 text-sm">
                    Lacak Status Peminjaman
                </a>
                <a href="{{ route('perpus.index') }}" class="perpus-btn-detail w-full sm:w-auto flex-1 py-3.5 px-6 text-sm">
                    Kembali ke Katalog
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
