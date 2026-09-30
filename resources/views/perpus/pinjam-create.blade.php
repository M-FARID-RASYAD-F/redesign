@extends('layouts.app')

@section('title', 'Formulir Pengajuan Peminjaman - ' . $book->title)

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-narrow">
        
        <!-- Breadcrumb Navigation -->
        <div class="mb-6 sm:mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
            <nav class="flex items-center flex-wrap gap-2 text-xs sm:text-sm text-slate-300 font-medium" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <span class="text-slate-500" aria-hidden="true">/</span>
                <a href="{{ route('perpus.index') }}" class="hover:text-white transition-colors">Perpustakaan</a>
                <span class="text-slate-500" aria-hidden="true">/</span>
                <a href="{{ route('perpus.show', $book->id) }}" class="hover:text-emerald-300 transition-colors text-emerald-400 font-semibold truncate max-w-[160px] sm:max-w-[240px]" title="{{ $book->title }}">
                    {{ $book->title }}
                </a>
                <span class="text-slate-500" aria-hidden="true">/</span>
                <span class="text-slate-200 font-semibold" aria-current="page">Form Pinjam</span>
            </nav>

            <a href="{{ route('perpus.show', $book->id) }}" class="perpus-btn-detail inline-flex items-center gap-2 px-4 py-2 text-xs sm:text-sm font-semibold rounded-xl self-start sm:self-auto transition-all shadow-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Detail Buku</span>
            </a>
        </div>

        <div class="perpus-card-surface overflow-hidden shadow-2xl">
            <!-- Header Banner (Dual-theme harmonized) -->
            <div class="perpus-form-hero px-6 py-7 sm:px-10 sm:py-9 text-white border-b border-white/10 bg-gradient-to-r from-teal-900 via-emerald-950 to-slate-900">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold mb-3 sm:mb-3.5 border border-emerald-500/35 shadow-sm">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Layanan Sirkulasi Mandiri Online</span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-[2rem] font-extrabold text-white mb-2.5 tracking-tight leading-tight">
                    Ajukan Peminjaman Buku
                </h1>
                <p class="text-slate-200 text-sm sm:text-base max-w-2xl leading-relaxed">
                    Silakan lengkapi data diri Anda di bawah ini. Anda dapat menggunakan nomor WhatsApp aktif sebagai identitas peminjaman di perpustakaan sekolah tanpa perlu registrasi yang rumit.
                </p>
            </div>

            <div class="p-6 sm:p-9 md:p-10">
                <!-- Book Selected Card with Cover Thumbnail -->
                <div class="perpus-card-subsurface p-5 sm:p-6 mb-8 sm:mb-9 flex flex-col md:flex-row items-start md:items-center justify-between gap-5 sm:gap-6 border border-white/15 shadow-sm rounded-2xl">
                    <div class="flex items-center gap-4 sm:gap-5 flex-1 min-w-0">
                        <!-- Book Cover Thumbnail -->
                        <div class="w-16 sm:w-20 aspect-[3/4] rounded-xl overflow-hidden bg-slate-950/80 border border-white/20 shrink-0 flex items-center justify-center p-1 shadow-md">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('images/book-placeholder.png') }}"
                                 alt="Sampul buku {{ $book->title }}"
                                 width="80"
                                 height="106"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';"
                                 class="max-h-full max-w-full object-contain">
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-400 uppercase tracking-wider mb-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 shrink-0" aria-hidden="true"></span>
                                <span>Buku yang Akan Dipinjam:</span>
                            </div>
                            <h2 class="font-extrabold text-white text-base sm:text-lg md:text-xl leading-snug tracking-tight mb-2">{{ $book->title }}</h2>
                            <div class="text-xs sm:text-sm text-slate-300 flex flex-wrap items-center gap-2 sm:gap-3">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>Penulis: <strong class="text-white">{{ $book->author }}</strong></span>
                                </span>
                                @if($book->category)
                                <span class="text-slate-500 hidden sm:inline">&bull;</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-semibold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30">
                                    {{ $book->category->name }}
                                </span>
                                @endif
                                @if($book->rack_location)
                                <span class="text-slate-500 hidden sm:inline">&bull;</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md text-xs font-mono font-semibold bg-cyan-500/15 text-cyan-300 border border-cyan-500/30">
                                    <svg class="w-3.5 h-3.5 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    <span>Rak: {{ $book->rack_location }}</span>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="shrink-0 w-full md:w-auto pt-4 md:pt-0 border-t md:border-t-0 md:border-l md:border-white/15 md:pl-6 flex md:flex-col items-center md:items-end justify-between md:justify-center gap-1.5">
                        <div class="text-xs font-medium text-slate-300 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Masa Pinjam Standar</span>
                        </div>
                        <div class="text-sm sm:text-base font-extrabold text-emerald-400 bg-emerald-500/15 md:bg-transparent px-3 py-1 md:p-0 rounded-lg border md:border-0 border-emerald-500/30">
                            7 Hari Kalender
                        </div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="mb-7 p-4 sm:p-5 rounded-2xl bg-rose-500/15 border border-rose-500/30 text-rose-200 text-sm leading-relaxed" role="alert" aria-live="assertive">
                    <div class="font-bold mb-2 flex items-center gap-2 text-rose-300">
                        <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Pengajuan belum dapat diproses:</span>
                    </div>
                    <ul class="list-disc list-outside pl-5 space-y-1.5 text-rose-200/90 text-xs sm:text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Application Form -->
                <form action="{{ route('perpus.pinjam.store', $book->id) }}" method="POST" class="space-y-7 sm:space-y-8" id="pinjamForm" novalidate>
                    @csrf

                    <div>
                        <label for="full_name" class="block text-sm sm:text-base font-bold text-slate-100 mb-2 sm:mb-2.5">
                            Nama Lengkap Peminjam <span class="text-rose-400 font-extrabold" title="Wajib diisi">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400" aria-hidden="true">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required placeholder="Contoh: Muhammad Rayhan" 
                                aria-invalid="{{ $errors->has('full_name') ? 'true' : 'false' }}"
                                @if($errors->has('full_name')) aria-describedby="full_name_error" @else aria-describedby="full_name_help" @endif
                                class="perpus-form-input w-full pl-12 pr-4 py-3.5 sm:py-4 rounded-xl bg-white/5 border {{ $errors->has('full_name') ? 'border-rose-500 ring-2 ring-rose-500/40' : 'border-white/15 hover:border-white/25' }} focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-white placeholder-slate-400 text-base transition-all shadow-inner">
                        </div>
                        @error('full_name')
                            <p id="full_name_error" class="text-xs sm:text-sm text-rose-400 mt-2 flex items-center gap-1.5 font-medium" role="alert">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @else
                            <p id="full_name_help" class="text-xs sm:text-sm text-slate-300 mt-2 flex items-center gap-1.5 leading-relaxed">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Terbuka untuk Santri, Siswa, Guru, Karyawan, Wali Siswa, dan Pengunjung Perpustakaan.</span>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm sm:text-base font-bold text-slate-100 mb-2 sm:mb-2.5">
                            Nomor WhatsApp / HP Aktif <span class="text-rose-400 font-extrabold" title="Wajib diisi">*</span>
                        </label>
                        <div class="relative flex items-center">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400" aria-hidden="true">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Contoh: 081234567890" 
                                aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                @if($errors->has('phone')) aria-describedby="phone_error" @else aria-describedby="phone_help" @endif
                                class="perpus-form-input w-full pl-12 pr-4 py-3.5 sm:py-4 rounded-xl bg-white/5 border {{ $errors->has('phone') ? 'border-rose-500 ring-2 ring-rose-500/40' : 'border-white/15 hover:border-white/25' }} focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-white placeholder-slate-400 text-base transition-all shadow-inner">
                        </div>
                        @error('phone')
                            <p id="phone_error" class="text-xs sm:text-sm text-rose-400 mt-2 flex items-center gap-1.5 font-medium" role="alert">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @else
                            <p id="phone_help" class="text-xs sm:text-sm text-emerald-400/90 mt-2 flex items-center gap-1.5 leading-relaxed">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Nomor ini menjadi identitas peminjaman dan dapat dipakai untuk melacak status peminjaman Anda.</span>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm sm:text-base font-bold text-slate-100 mb-2 sm:mb-2.5 flex items-center justify-between">
                            <span>Kelas / Asrama / Alamat Domisili</span>
                            <span class="text-xs font-normal text-slate-400 uppercase tracking-wider">(Opsional)</span>
                        </label>
                        <div class="relative">
                            <textarea id="address" name="address" rows="3" placeholder="Contoh: Kelas X Tahfizh A / Asrama Kampus Panam / Jl. Hangtuah No. 45" 
                                aria-invalid="{{ $errors->has('address') ? 'true' : 'false' }}"
                                @if($errors->has('address')) aria-describedby="address_error" @else aria-describedby="address_help" @endif
                                class="perpus-form-input w-full px-4 py-3 sm:py-3.5 rounded-xl bg-white/5 border {{ $errors->has('address') ? 'border-rose-500 ring-2 ring-rose-500/40' : 'border-white/15 hover:border-white/25' }} focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-white placeholder-slate-400 text-base transition-all shadow-inner leading-relaxed">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <p id="address_error" class="text-xs sm:text-sm text-rose-400 mt-2 flex items-center gap-1.5 font-medium" role="alert">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @else
                            <p id="address_help" class="text-xs sm:text-sm text-slate-300 mt-2 flex items-center gap-1.5 leading-relaxed">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Isi dengan kelas/asrama bagi santri/siswa, atau alamat rumah bagi peminjam umum.</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Terms agreement note -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-amber-500/10 border border-amber-500/25 text-amber-200">
                        <div class="flex items-center gap-2.5 text-amber-300 font-bold text-sm sm:text-base mb-3 pb-2.5 border-b border-amber-500/20">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Ketentuan &amp; Tata Tertib Peminjaman:</span>
                        </div>
                        <ul class="space-y-2 text-xs sm:text-sm text-slate-200/90 leading-relaxed list-outside pl-5 list-disc marker:text-amber-400">
                            <li>Batas waktu peminjaman buku adalah <strong class="text-amber-300 font-semibold">7 hari kalender</strong> sejak buku fisik diambil di perpustakaan.</li>
                            <li>Buku wajib dijaga keutuhannya, bebas dari coretan, sobekan, noda, atau kerusakan fisik lainnya.</li>
                            <li>Tunjukkan bukti kode peminjaman kepada petugas perpustakaan sekolah untuk verifikasi fisik saat pengambilan buku.</li>
                        </ul>
                    </div>

                    <div class="pt-6 sm:pt-8 border-t border-white/10 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 sm:gap-4">
                        <a href="{{ route('perpus.show', $book->id) }}" class="perpus-btn-detail w-full sm:w-auto px-6 py-3.5 sm:py-4 text-center text-sm sm:text-base font-semibold min-h-[48px] sm:min-h-[52px] flex items-center justify-center rounded-xl transition-all">
                            Batal
                        </a>
                        <button type="submit" id="submitBtn" class="perpus-btn-borrow w-full sm:w-auto flex-1 sm:flex-initial sm:min-w-[280px] py-3.5 sm:py-4 px-8 text-base min-h-[48px] sm:min-h-[52px] justify-center font-bold rounded-xl transition-all shadow-md inline-flex items-center">
                            <svg id="submitIcon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <svg id="submitSpinner" class="w-5 h-5 mr-2 animate-spin hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                            <span id="submitText">Kirim Pengajuan Peminjaman</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pinjamForm');
    const phoneInput = document.getElementById('phone');
    const submitBtn = document.getElementById('submitBtn');
    const submitIcon = document.getElementById('submitIcon');
    const submitSpinner = document.getElementById('submitSpinner');
    const submitText = document.getElementById('submitText');

    // Auto sanitize phone input to numeric
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    }

    // Anti double submit guard
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            const fullName = document.getElementById('full_name')?.value.trim();
            const phone = phoneInput?.value.trim();

            if (!fullName || !phone) {
                return; // Let browser/native validation handle empty fields
            }

            // Disable button and show spinner
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            if (submitIcon) submitIcon.classList.add('hidden');
            if (submitSpinner) submitSpinner.classList.remove('hidden');
            if (submitText) submitText.innerText = 'Memproses Pengajuan...';
        });
    }
});
</script>
@endsection
