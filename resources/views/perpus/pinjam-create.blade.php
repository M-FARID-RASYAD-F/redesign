@extends('layouts.app')

@section('title', 'Formulir Pengajuan Peminjaman - ' . $book->title)

@section('konten_utama')
<div class="bg-gradient-to-b from-slate-50 to-white min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Navigation -->
        <div class="mb-6">
            <a href="{{ route('perpus.show', $book->id) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-emerald-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Detail Buku
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden">
            <!-- Header Banner -->
            <div class="bg-gradient-to-r from-teal-800 to-emerald-900 p-6 sm:p-8 text-white">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold mb-3 border border-emerald-500/30">
                    Formulir Layanan Sirkulasi
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">
                    Ajukan Peminjaman Buku
                </h1>
                <p class="text-slate-200 text-sm max-w-2xl leading-relaxed">
                    Silakan isi identitas Anda dengan benar. Cukup gunakan nomor telepon/WhatsApp aktif tanpa perlu registrasi akun berbelit.
                </p>
            </div>

            <div class="p-6 sm:p-10">
                <!-- Book Selected Card -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-emerald-700 uppercase tracking-wider mb-0.5">Buku yang Dipilih:</div>
                            <h3 class="font-bold text-slate-900 text-base sm:text-lg">{{ $book->title }}</h3>
                            <div class="text-xs text-slate-500">Karya {{ $book->author }} • Lokasi Rak: {{ $book->rack_location ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="text-right sm:border-l sm:border-slate-200 sm:pl-6 shrink-0">
                        <div class="text-xs text-slate-500">Masa Pinjam</div>
                        <div class="text-sm font-bold text-emerald-700">7 Hari Kalender</div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
                    <div class="font-bold mb-1">Pengajuan belum dapat diproses:</div>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Application Form -->
                <form action="{{ route('perpus.pinjam.store', $book->id) }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="full_name" class="block text-sm font-bold text-slate-800 mb-2">
                            Nama Lengkap Peminjam <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required placeholder="Contoh: Muhammad Rayhan" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-slate-800 text-sm sm:text-base">
                        <p class="text-xs text-slate-400 mt-1.5">Siswa / Santri / Guru / Wali Siswa / Pengunjung Umum.</p>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-slate-800 mb-2">
                            Nomor WhatsApp / HP Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="Contoh: 081234567890" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-slate-800 text-sm sm:text-base">
                        <p class="text-xs text-emerald-600 mt-1.5 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Nomor ini menjadi identitas keanggotaan Anda di perpustakaan sekolah.
                        </p>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-bold text-slate-800 mb-2">
                            Alamat Rumah / Kelas / Instansi (Opsional)
                        </label>
                        <textarea id="address" name="address" rows="3" placeholder="Contoh: Kelas X Tahfizh A / Asrama Putra / Jl. Mawar No. 12" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium text-slate-800 text-sm sm:text-base">{{ old('address') }}</textarea>
                    </div>

                    <!-- Terms agreement note -->
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs sm:text-sm leading-relaxed">
                        <strong>Ketentuan Peminjaman:</strong>
                        <ul class="list-disc list-inside mt-1 space-y-1">
                            <li>Batas waktu peminjaman adalah 7 hari sejak tanggal pengambilan buku fisik.</li>
                            <li>Buku wajib dijaga kebersihan dan keutuhannya tanpa coretan atau kerusakan.</li>
                            <li>Tunjukkan bukti kode peminjaman kepada petugas perpustakaan untuk mengambil buku.</li>
                        </ul>
                    </div>

                    <div class="pt-4 flex flex-col sm:flex-row items-center gap-4">
                        <button type="submit" class="w-full sm:w-auto flex-1 py-4 px-8 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold rounded-xl shadow-lg shadow-emerald-600/30 hover:shadow-emerald-600/50 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Kirim Pengajuan Peminjaman</span>
                        </button>
                        <a href="{{ route('perpus.show', $book->id) }}" class="w-full sm:w-auto px-6 py-4 text-center text-sm font-semibold text-slate-500 hover:text-slate-800">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
