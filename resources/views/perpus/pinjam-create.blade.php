@extends('layouts.app')

@section('title', 'Formulir Pengajuan Peminjaman - ' . $book->title)

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-narrow">
        
        <!-- Breadcrumb Navigation -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-300 font-medium" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <span class="text-slate-500">/</span>
                <a href="{{ route('perpus.index') }}" class="hover:text-white transition-colors">Perpustakaan</a>
                <span class="text-slate-500">/</span>
                <a href="{{ route('perpus.show', $book->id) }}" class="hover:text-emerald-300 transition-colors text-emerald-400 truncate max-w-[160px] sm:max-w-[240px]">
                    {{ $book->title }}
                </a>
                <span class="text-slate-500">/</span>
                <span class="text-slate-400" aria-current="page">Form Pinjam</span>
            </nav>

            <a href="{{ route('perpus.show', $book->id) }}" class="perpus-btn-detail inline-flex items-center gap-2 px-3.5 py-2 text-xs sm:text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Detail Buku</span>
            </a>
        </div>

        <div class="perpus-card-surface overflow-hidden">
            <!-- Header Banner (Dual-theme harmonized) -->
            <div class="perpus-form-hero p-6 sm:p-8 text-white border-b border-white/10 bg-gradient-to-r from-teal-900 via-emerald-950 to-slate-900">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold mb-3 border border-emerald-500/30">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Layanan Sirkulasi Mandiri Online</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">
                    Ajukan Peminjaman Buku
                </h1>
                <p class="text-slate-200 text-sm max-w-2xl leading-relaxed">
                    Silakan lengkapi data diri Anda di bawah ini. Anda dapat menggunakan nomor WhatsApp aktif sebagai identitas keanggotaan perpustakaan sekolah tanpa perlu registrasi berbelit.
                </p>
            </div>

            <div class="p-6 sm:p-10">
                <!-- Book Selected Card with Cover Thumbnail -->
                <div class="perpus-card-subsurface p-4 sm:p-5 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <!-- Book Cover Thumbnail -->
                        <div class="w-16 h-22 sm:w-18 sm:h-24 rounded-lg overflow-hidden bg-slate-950 border border-white/20 shrink-0 flex items-center justify-center p-1 shadow-md">
                            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('images/book-placeholder.png') }}"
                                 alt="Sampul buku {{ $book->title }}"
                                 width="72"
                                 height="96"
                                 onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';"
                                 class="max-h-full max-w-full object-contain">
                        </div>

                        <div>
                            <div class="text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400" aria-hidden="true"></span>
                                <span>Buku yang Akan Dipinjam:</span>
                            </div>
                            <h2 class="font-bold text-white text-base sm:text-lg leading-snug">{{ $book->title }}</h2>
                            <div class="text-xs text-slate-300 mt-1 flex flex-wrap items-center gap-2">
                                <span>Penulis: <strong>{{ $book->author }}</strong></span>
                                @if($book->rack_location)
                                <span>&bull;</span>
                                <span class="text-cyan-300 font-mono">Rak: {{ $book->rack_location }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="text-left sm:text-right sm:border-l sm:border-white/10 sm:pl-6 shrink-0 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-white/10">
                        <div class="text-xs text-slate-400">Masa Pinjam Standar</div>
                        <div class="text-base font-bold text-emerald-400">7 Hari Kalender</div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-sm" role="alert" aria-live="assertive">
                    <div class="font-bold mb-1 flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Pengajuan belum dapat diproses:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 pl-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Application Form -->
                <form action="{{ route('perpus.pinjam.store', $book->id) }}" method="POST" class="space-y-6" id="pinjamForm" novalidate>
                    @csrf

                    <div>
                        <label for="full_name" class="block text-sm font-bold text-slate-200 mb-2">
                            Nama Lengkap Peminjam <span class="text-rose-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-slate-400 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required placeholder="Contoh: Muhammad Rayhan" 
                                aria-invalid="{{ $errors->has('full_name') ? 'true' : 'false' }}"
                                @if($errors->has('full_name')) aria-describedby="full_name_error" @endif
                                class="perpus-form-input w-full pl-12 pr-4 py-3.5 rounded-xl bg-white/5 border {{ $errors->has('full_name') ? 'border-rose-500 ring-1 ring-rose-500/50' : 'border-white/15' }} focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-white placeholder-slate-400 text-sm sm:text-base transition-colors">
                        </div>
                        @error('full_name')
                            <p id="full_name_error" class="text-xs text-rose-400 mt-1.5 flex items-center gap-1 font-medium" role="alert">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @else
                            <p class="text-xs text-slate-400 mt-1.5">Terbuka untuk Santri, Siswa, Guru, Karyawan, Wali Siswa, dan Pengunjung Perpustakaan.</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-slate-200 mb-2">
                            Nomor WhatsApp / HP Aktif <span class="text-rose-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 text-slate-400 pointer-events-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Contoh: 081234567890" 
                                aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                @if($errors->has('phone')) aria-describedby="phone_error" @endif
                                class="perpus-form-input w-full pl-12 pr-4 py-3.5 rounded-xl bg-white/5 border {{ $errors->has('phone') ? 'border-rose-500 ring-1 ring-rose-500/50' : 'border-white/15' }} focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-white placeholder-slate-400 text-sm sm:text-base transition-colors">
                        </div>
                        @error('phone')
                            <p id="phone_error" class="text-xs text-rose-400 mt-1.5 flex items-center gap-1 font-medium" role="alert">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @else
                            <p class="text-xs text-emerald-400 mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Nomor ini menjadi identitas peminjaman dan dapat dipakai untuk melacak status peminjaman Anda.</span>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-bold text-slate-200 mb-2">
                            Kelas / Asrama / Alamat Domisili (Opsional)
                        </label>
                        <div class="relative">
                            <textarea id="address" name="address" rows="3" placeholder="Contoh: Kelas X Tahfizh A / Asrama Kampus Panam / Jl. Hangtuah No. 45" 
                                aria-invalid="{{ $errors->has('address') ? 'true' : 'false' }}"
                                @if($errors->has('address')) aria-describedby="address_error" @endif
                                class="perpus-form-input w-full px-4 py-3 rounded-xl bg-white/5 border {{ $errors->has('address') ? 'border-rose-500 ring-1 ring-rose-500/50' : 'border-white/15' }} focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-white placeholder-slate-400 text-sm sm:text-base transition-colors">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <p id="address_error" class="text-xs text-rose-400 mt-1.5 flex items-center gap-1 font-medium" role="alert">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Terms agreement note -->
                    <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-200 text-xs sm:text-sm leading-relaxed">
                        <strong class="text-amber-300 flex items-center gap-1.5 mb-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Ketentuan &amp; Tata Tertib Peminjaman:</span>
                        </strong>
                        <ul class="list-disc list-inside space-y-1 text-slate-300">
                            <li>Batas waktu peminjaman buku adalah <strong>7 hari kalender</strong> sejak buku fisik diambil.</li>
                            <li>Buku wajib dijaga keutuhannya, bebas dari coretan, sobekan, atau kerusakan.</li>
                            <li>Tunjukkan bukti kode peminjaman kepada petugas perpustakaan untuk verifikasi pengambilan buku.</li>
                        </ul>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row items-center gap-4">
                        <button type="submit" id="submitBtn" class="perpus-btn-borrow w-full sm:w-auto flex-1 py-4 px-8 text-base min-h-[48px] justify-center font-bold">
                            <svg id="submitIcon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <svg id="submitSpinner" class="w-5 h-5 mr-2 animate-spin hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path></svg>
                            <span id="submitText">Kirim Pengajuan Peminjaman</span>
                        </button>
                        <a href="{{ route('perpus.show', $book->id) }}" class="perpus-btn-detail w-full sm:w-auto px-6 py-4 text-center text-sm font-semibold min-h-[48px] flex items-center justify-center">
                            Batal
                        </a>
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
