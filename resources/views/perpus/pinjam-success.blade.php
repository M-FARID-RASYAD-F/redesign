@extends('layouts.app')

@section('title', 'Pengajuan Berhasil - Kode: ' . $loan->loan_code)

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-compact">
        
        <div class="perpus-card-surface text-center p-6 sm:p-10 overflow-hidden">
            
            <!-- Success Icon -->
            <div class="w-20 h-20 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto mb-5 shadow-inner border border-emerald-500/30">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <span class="inline-block px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 uppercase tracking-wider mb-3 border border-emerald-500/30">
                Pengajuan Berhasil Dikirim
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-2 leading-tight">
                Peminjaman Buku Telah Tercatat
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mb-6 max-w-md mx-auto leading-relaxed">
                Permintaan Anda telah tersimpan di sistem perpustakaan sekolah. Silakan simpan kode referensi di bawah ini.
            </p>

            <!-- Loan Code Display Box -->
            <div class="perpus-card-subsurface p-6 mb-6 text-center relative overflow-hidden">
                <div class="text-xs uppercase tracking-widest text-slate-400 font-semibold mb-2">Kode Referensi Peminjaman</div>
                <div id="loanCodeText" class="text-2xl sm:text-4xl font-extrabold font-mono text-emerald-400 tracking-wider select-all mb-4">
                    {{ $loan->loan_code }}
                </div>
                
                <div class="flex items-center justify-center gap-2 flex-wrap">
                    <button type="button" id="copyBtn" onclick="copyLoanCode('{{ $loan->loan_code }}')" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-lg transition-colors border border-white/15">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span id="copyBtnText">Salin Kode</span>
                    </button>

                    @php
                        $waText = urlencode("Halo, berikut kode peminjaman buku perpustakaan saya di PKBM Tahfizh At-Tamam:\n\n*Kode:* {$loan->loan_code}\n*Judul Buku:* {$loan->book->title}\n*Status:* Menunggu Verifikasi\n\nCek status: " . route('perpus.tracking'));
                    @endphp
                    <a href="https://wa.me/?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600/30 hover:bg-emerald-600/50 text-emerald-300 text-xs font-semibold rounded-lg transition-colors border border-emerald-500/40">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
                        <span>Simpan ke WhatsApp</span>
                    </a>

                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/5 hover:bg-white/15 text-slate-300 text-xs font-semibold rounded-lg transition-colors border border-white/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Bukti</span>
                    </button>
                </div>
            </div>

            <!-- Details Summary Receipt Card -->
            <div class="perpus-card-subsurface p-5 mb-6 text-left text-sm space-y-3">
                <div class="flex justify-between items-center pb-2.5 border-b border-white/10">
                    <span class="text-slate-400">Judul Buku</span>
                    <span class="font-bold text-white text-right max-w-[65%]">{{ $loan->book->title }}</span>
                </div>
                <div class="flex justify-between items-center pb-2.5 border-b border-white/10">
                    <span class="text-slate-400">Lokasi Rak Fisik</span>
                    <span class="font-mono text-cyan-300 font-semibold">{{ $loan->book->rack_location ?: '-' }}</span>
                </div>
                <div class="flex justify-between items-center pb-2.5 border-b border-white/10">
                    <span class="text-slate-400">Durasi Peminjaman</span>
                    <span class="font-bold text-emerald-400">7 Hari Kalender</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400">Status Saat Ini</span>
                    <span class="px-3 py-1 bg-amber-500/20 text-amber-300 border border-amber-500/30 rounded-full text-xs font-bold">
                        ● {{ $loan->status_label }}
                    </span>
                </div>
            </div>

            <!-- Instructions Step Cards -->
            <div class="p-5 rounded-2xl bg-cyan-500/10 border border-cyan-500/25 text-left mb-8">
                <h4 class="font-bold text-white text-sm mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Langkah Selanjutnya untuk Mengambil Buku:</span>
                </h4>
                <ol class="space-y-2 text-xs sm:text-sm text-slate-200 list-decimal list-inside leading-relaxed">
                    <li>Simpan atau tangkap layar (screenshot) kode <strong class="text-emerald-300 font-mono">{{ $loan->loan_code }}</strong> di atas.</li>
                    <li>Kunjungi ruang perpustakaan sekolah pada jam layanan sirkulasi.</li>
                    <li>Tunjukkan kode peminjaman kepada petugas perpustakaan untuk verifikasi.</li>
                    <li>Bawa buku fisik dan selamat membaca!</li>
                </ol>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <a href="{{ route('perpus.tracking') }}" class="perpus-btn-borrow w-full sm:w-auto flex-1 py-3.5 px-6 text-sm">
                    Lacak Status Peminjaman
                </a>
                <a href="{{ route('perpus.index') }}" class="perpus-btn-detail w-full sm:w-auto flex-1 py-3.5 px-6 text-sm">
                    Kembali ke Katalog Buku
                </a>
            </div>

        </div>

    </div>
</div>

<script>
function copyLoanCode(code) {
    const btnText = document.getElementById('copyBtnText');
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(code).then(() => {
            btnText.innerText = 'Tersalin!';
            setTimeout(() => btnText.innerText = 'Salin Kode', 2000);
        }).catch(() => fallbackCopy(code));
    } else {
        fallbackCopy(code);
    }
}

function fallbackCopy(code) {
    const textArea = document.createElement("textarea");
    textArea.value = code;
    textArea.style.position = "fixed";
    textArea.style.opacity = "0";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        const btnText = document.getElementById('copyBtnText');
        btnText.innerText = 'Tersalin!';
        setTimeout(() => btnText.innerText = 'Salin Kode', 2000);
    } catch (err) {}
    document.body.removeChild(textArea);
}
</script>
@endsection
