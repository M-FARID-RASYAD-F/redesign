@extends('layouts.app')

@section('title', 'Formulir Pengajuan Peminjaman - ' . $book->title)

@section('konten_utama')
<div class="perpus-page-wrapper">
    <div class="perpus-container-narrow">
        
        <!-- Navigation -->
        <div class="mb-6">
            <a href="{{ route('perpus.show', $book->id) }}" class="perpus-hero-track-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Detail Buku</span>
            </a>
        </div>

        <div class="perpus-card-surface overflow-hidden">
            <!-- Header Banner -->
            <div class="bg-gradient-to-r from-teal-900 via-emerald-950 to-slate-900 p-6 sm:p-8 text-white border-b border-white/10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold mb-3 border border-emerald-500/30">
                    Formulir Layanan Sirkulasi
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">
                    Ajukan Peminjaman Buku
                </h1>
                <p class="text-slate-300 text-sm max-w-2xl leading-relaxed">
                    Silakan lengkapi data diri Anda dengan benar. Cukup gunakan nomor telepon/WhatsApp aktif tanpa perlu registrasi akun berbelit.
                </p>
            </div>

            <div class="p-6 sm:p-10">
                <!-- Book Selected Card -->
                <div class="perpus-card-subsurface p-5 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-emerald-400 uppercase tracking-wider mb-0.5">Buku yang Dipilih:</div>
                            <h3 class="font-bold text-white text-base sm:text-lg">{{ $book->title }}</h3>
                            <div class="text-xs text-slate-300">Karya {{ $book->author }} • Lokasi Rak: {{ $book->rack_location ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="text-left sm:text-right sm:border-l sm:border-white/10 sm:pl-6 shrink-0">
                        <div class="text-xs text-slate-400">Masa Pinjam</div>
                        <div class="text-sm font-bold text-emerald-400">7 Hari Kalender</div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-sm">
                    <div class="font-bold mb-1">Pengajuan belum dapat diproses:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Application Form -->
                <form action="{{ route('perpus.pinjam.store', $book->id) }}" method="POST" class="space-y-6" id="pinjamForm">
                    @csrf

                    <div>
                        <label for="full_name" class="block text-sm font-bold text-slate-200 mb-2">
                            Nama Lengkap Peminjam <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required placeholder="Contoh: Muhammad Rayhan" 
                            aria-invalid="{{ $errors->has('full_name') ? 'true' : 'false' }}"
                            @if($errors->has('full_name')) aria-describedby="full_name_error" @endif
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border {{ $errors->has('full_name') ? 'border-rose-500 ring-1 ring-rose-500/50' : 'border-white/15' }} focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-white placeholder-slate-400 text-sm sm:text-base transition-colors">
                        @error('full_name')
                            <p id="full_name_error" class="text-xs text-rose-400 mt-1.5 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @else
                            <p class="text-xs text-slate-400 mt-1.5">Siswa / Santri / Guru / Wali Siswa / Pengunjung Umum.</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-slate-200 mb-2">
                            Nomor WhatsApp / HP Aktif <span class="text-rose-400">*</span>
                        </label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Contoh: 081234567890" 
                            aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                            @if($errors->has('phone')) aria-describedby="phone_error" @endif
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border {{ $errors->has('phone') ? 'border-rose-500 ring-1 ring-rose-500/50' : 'border-white/15' }} focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-white placeholder-slate-400 text-sm sm:text-base transition-colors">
                        @error('phone')
                            <p id="phone_error" class="text-xs text-rose-400 mt-1.5 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @else
                            <p class="text-xs text-emerald-400 mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Nomor ini menjadi identitas keanggotaan Anda di perpustakaan sekolah.
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-bold text-slate-200 mb-2">
                            Alamat Rumah / Kelas / Instansi (Opsional)
                        </label>
                        <textarea id="address" name="address" rows="3" placeholder="Contoh: Kelas X Tahfizh A / Asrama Putra / Jl. Mawar No. 12" 
                            aria-invalid="{{ $errors->has('address') ? 'true' : 'false' }}"
                            @if($errors->has('address')) aria-describedby="address_error" @endif
                            class="w-full px-4 py-3 rounded-xl bg-white/5 border {{ $errors->has('address') ? 'border-rose-500 ring-1 ring-rose-500/50' : 'border-white/15' }} focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-white placeholder-slate-400 text-sm sm:text-base transition-colors">{{ old('address') }}</textarea>
                        @error('address')
                            <p id="address_error" class="text-xs text-rose-400 mt-1.5 flex items-center gap-1 font-medium">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Terms agreement note -->
                    <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-200 text-xs sm:text-sm leading-relaxed">
                        <strong class="text-amber-300">Ketentuan Peminjaman:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1 text-slate-300">
                            <li>Batas waktu peminjaman adalah 7 hari sejak tanggal pengambilan buku fisik.</li>
                            <li>Buku wajib dijaga kebersihan dan keutuhannya tanpa coretan atau kerusakan.</li>
                            <li>Tunjukkan bukti kode peminjaman kepada petugas perpustakaan untuk mengambil buku.</li>
                        </ul>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row items-center gap-4">
                        <button type="submit" class="perpus-btn-borrow w-full sm:w-auto flex-1 py-4 px-8 text-base min-h-[48px] justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Kirim Pengajuan Peminjaman</span>
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
@endsection
