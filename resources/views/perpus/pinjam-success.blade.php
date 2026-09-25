@extends('layouts.app')

@section('title', 'Pengajuan Berhasil - Kode: ' . $loan->loan_code)

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-compact">

        <!-- Official Print Receipt Header (Printed on paper / PDF only) -->
        <div class="print-only text-black mb-6 border-b-2 border-black pb-4 text-center">
            <h2 class="text-xl font-bold uppercase tracking-wider">PKBM Tahfizh At-Tamam Edu</h2>
            <p class="text-xs text-slate-700">Unit Pelayanan Perpustakaan &amp; Sirkulasi Literasi Mandiri</p>
            <p class="text-xs text-slate-700">Jl. Hangtuah No. 45, Pekanbaru | Telp/WA: 0812-7000-1920</p>
            <div class="mt-3 text-sm font-bold border-t border-b border-black py-1">
                BUKTI PENGAJUAN PEMINJAMAN BUKU
            </div>
        </div>
        
        <div class="perpus-card-surface text-center p-6 sm:p-10 overflow-hidden">
            
            <!-- Success Icon (Screen only) -->
            <div class="w-20 h-20 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto mb-5 shadow-inner border border-emerald-500/30 no-print">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <span class="inline-block px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 uppercase tracking-wider mb-3 border border-emerald-500/30 no-print">
                Pengajuan Berhasil Dikirim
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-2 leading-tight">
                Peminjaman Buku Telah Tercatat
            </h1>
            <p class="text-slate-300 text-sm sm:text-base mb-6 max-w-md mx-auto leading-relaxed">
                Permintaan Anda telah tersimpan di sistem perpustakaan sekolah. Silakan simpan kode referensi di bawah ini.
            </p>

            <!-- Loan Code Display Box -->
            <div class="perpus-card-subsurface p-6 mb-6 text-center relative overflow-hidden print-receipt-border">
                <div class="text-xs uppercase tracking-widest text-slate-400 font-semibold mb-2">Kode Referensi Peminjaman</div>
                <div id="loanCodeText" class="text-2xl sm:text-4xl font-extrabold font-mono text-emerald-400 tracking-wider select-all mb-4">
                    {{ $loan->loan_code }}
                </div>
                
                <div class="flex items-center justify-center gap-2 flex-wrap no-print">
                    <button type="button" id="copyBtn" onclick="copyLoanCode('{{ $loan->loan_code }}')" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white/10 hover:bg-white/20 text-white text-xs font-semibold rounded-lg transition-colors border border-white/15 cursor-pointer">
                        <svg id="copyIcon" class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span id="copyBtnText">Salin Kode</span>
                    </button>
                    <span id="copyLiveNotice" class="sr-only" role="status" aria-live="polite"></span>

                    @php
                        $waText = urlencode("Halo, berikut kode peminjaman buku perpustakaan saya di PKBM Tahfizh At-Tamam:\n\n*Kode:* {$loan->loan_code}\n*Judul Buku:* {$loan->book->title}\n*Status:* Menunggu Verifikasi\n\nCek status: " . route('perpus.tracking'));
                    @endphp
                    <a href="https://wa.me/?text={{ $waText }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-emerald-600/30 hover:bg-emerald-600/50 text-emerald-300 text-xs font-semibold rounded-lg transition-colors border border-emerald-500/40">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Simpan ke WhatsApp</span>
                    </a>

                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white/5 hover:bg-white/15 text-slate-300 text-xs font-semibold rounded-lg transition-colors border border-white/10 cursor-pointer">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Bukti Fisik</span>
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
                    <span class="text-slate-400">Peminjam</span>
                    <span class="font-semibold text-white">{{ $loan->member->full_name }}</span>
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

            <!-- Print-Only Verification & Signature Box -->
            <div class="print-only mt-8 pt-4 border-t border-black text-xs text-left">
                <div class="grid grid-cols-2 gap-8 text-center pt-4">
                    <div>
                        <p class="font-medium text-slate-800">Tanda Tangan Peminjam,</p>
                        <div class="h-16"></div>
                        <p class="font-bold">({{ $loan->member->full_name }})</p>
                    </div>
                    <div>
                        <p class="font-medium text-slate-800">Petugas Perpustakaan,</p>
                        <div class="h-16"></div>
                        <p class="font-bold">( ........................................ )</p>
                    </div>
                </div>
            </div>

            <!-- Instructions Step Cards (Screen only) -->
            <div class="p-5 rounded-2xl bg-cyan-500/10 border border-cyan-500/25 text-left mb-8 no-print">
                <h3 class="font-bold text-white text-sm mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Langkah Selanjutnya untuk Mengambil Buku:</span>
                </h3>
                <ol class="space-y-2 text-xs sm:text-sm text-slate-200 list-decimal list-inside leading-relaxed">
                    <li>Simpan atau tangkap layar (screenshot) kode <strong class="text-emerald-300 font-mono">{{ $loan->loan_code }}</strong> di atas.</li>
                    <li>Kunjungi ruang perpustakaan sekolah pada jam layanan sirkulasi.</li>
                    <li>Tunjukkan kode peminjaman kepada petugas perpustakaan untuk verifikasi.</li>
                    <li>Bawa buku fisik dan selamat membaca!</li>
                </ol>
            </div>

            <!-- Action Buttons (Screen only) -->
            <div class="flex flex-col sm:flex-row items-center gap-3 no-print">
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
    const notice = document.getElementById('copyLiveNotice');
    
    function onSuccess() {
        if (btnText) btnText.innerText = 'Tersalin!';
        if (notice) notice.innerText = 'Kode peminjaman ' + code + ' berhasil disalin ke clipboard';
        setTimeout(() => {
            if (btnText) btnText.innerText = 'Salin Kode';
            if (notice) notice.innerText = '';
        }, 2500);
    }

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(code).then(onSuccess).catch(() => fallbackCopy(code, onSuccess));
    } else {
        fallbackCopy(code, onSuccess);
    }
}

function fallbackCopy(code, callback) {
    const textArea = document.createElement("textarea");
    textArea.value = code;
    textArea.style.position = "fixed";
    textArea.style.opacity = "0";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand('copy');
        callback();
    } catch (err) {}
    document.body.removeChild(textArea);
}
</script>
@endsection
