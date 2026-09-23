@extends('layouts.app')

@section('title', 'Pengajuan Berhasil - Kode: ' . $loan->loan_code)

@section('konten_utama')
<div class="bg-gradient-to-b from-slate-50 to-white min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl overflow-hidden text-center p-8 sm:p-12">
            
            <!-- Success Icon -->
            <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-6 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <span class="inline-block px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 uppercase tracking-wider mb-3">
                Pengajuan Peminjaman Terkirim
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3">
                Terima Kasih, Pengajuan Berhasil!
            </h1>
            <p class="text-slate-600 text-sm sm:text-base mb-8 max-w-md mx-auto">
                Permintaan peminjaman buku Anda telah tercatat di sistem perpustakaan dan sedang menunggu verifikasi petugas.
            </p>

            <!-- Loan Code Display Box -->
            <div class="bg-slate-900 text-white rounded-2xl p-6 mb-8 shadow-lg relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl"></div>
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
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-8 text-left text-sm space-y-3">
                <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                    <span class="text-slate-500">Judul Buku</span>
                    <span class="font-bold text-slate-900 text-right">{{ $loan->book->title }}</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                    <span class="text-slate-500">Lokasi Rak</span>
                    <span class="font-mono text-slate-700 font-semibold">{{ $loan->book->rack_location ?: '-' }}</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b border-slate-200">
                    <span class="text-slate-500">Estimasi Jatuh Tempo</span>
                    <span class="font-bold text-emerald-700">{{ $loan->due_at ? $loan->due_at->format('d F Y') : '7 hari setelah buku diambil' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-500">Status Saat Ini</span>
                    <span class="px-2.5 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">
                        {{ $loan->status_label }}
                    </span>
                </div>
            </div>

            <!-- Instructions Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 mb-8 text-left text-xs sm:text-sm text-blue-900 leading-relaxed flex gap-3.5">
                <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <strong class="font-semibold block mb-1">Langkah Selanjutnya:</strong>
                    Simpan atau tangkap layar (screenshot) kode peminjaman di atas. Tunjukkan kode ini kepada petugas perpustakaan di sekolah saat Anda mengambil fisik buku.
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <a href="{{ route('perpus.tracking') }}" class="w-full sm:w-auto flex-1 py-3.5 px-6 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-md transition-colors text-sm">
                    Lacak Status Peminjaman
                </a>
                <a href="{{ route('perpus.index') }}" class="w-full sm:w-auto flex-1 py-3.5 px-6 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-xl transition-colors text-sm">
                    Kembali ke Katalog
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
