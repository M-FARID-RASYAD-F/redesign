@extends('layouts.app')

@section('title', 'Lacak Status Peminjaman Buku - Perpustakaan Digital')

@section('konten_utama')
<div class="bg-gradient-to-b from-slate-50 to-white min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold uppercase tracking-wider mb-3">
                Layanan Mandiri
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 mb-3">
                Lacak Status Peminjaman
            </h1>
            <p class="text-slate-600 text-sm sm:text-base max-w-lg mx-auto">
                Masukkan kode peminjaman Anda (contoh: <span class="font-mono font-semibold text-emerald-700">PINJAM-2026-0001</span>) untuk memeriksa status verifikasi dan masa berlaku peminjaman.
            </p>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl p-6 sm:p-8 mb-8">
            <form action="{{ route('perpus.check') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="loan_code" class="block text-sm font-bold text-slate-800 mb-2">
                        Kode Peminjaman Buku
                    </label>
                    <div class="relative">
                        <svg class="w-5 h-5 absolute left-3.5 top-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        <input type="text" id="loan_code" name="loan_code" value="{{ old('loan_code', isset($loan) ? $loan->loan_code : request('loan_code')) }}" required placeholder="PINJAM-YYYY-XXXX" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 font-mono font-semibold uppercase text-slate-800 text-sm sm:text-base">
                    </div>
                </div>

                @if($errors->has('loan_code'))
                <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $errors->first('loan_code') }}</span>
                </div>
                @endif

                <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/30 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Periksa Status Pinjaman</span>
                </button>
            </form>
        </div>

        <!-- Result Card if $loan is present -->
        @if(isset($loan))
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden animate-fade-in">
            <!-- Header Result -->
            <div class="bg-slate-900 text-white p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="text-xs uppercase tracking-wider text-slate-400 font-medium">Hasil Pencarian Peminjaman</div>
                    <div class="text-xl sm:text-2xl font-extrabold font-mono text-emerald-400 tracking-wide mt-1">
                        {{ $loan->loan_code }}
                    </div>
                </div>
                <div>
                    @php
                        $badgeClasses = match($loan->status) {
                            'diajukan'     => 'bg-amber-100 text-amber-800 border-amber-300',
                            'dipinjam'     => 'bg-blue-100 text-blue-800 border-blue-300',
                            'dikembalikan' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                            'terlambat'    => 'bg-rose-100 text-rose-800 border-rose-300',
                            default        => 'bg-slate-100 text-slate-800 border-slate-300',
                        };
                    @endphp
                    <span class="inline-block px-4 py-2 rounded-xl text-xs sm:text-sm font-bold border {{ $badgeClasses }}">
                        {{ $loan->status_label }}
                    </span>
                </div>
            </div>

            <!-- Details Body -->
            <div class="p-6 sm:p-8 space-y-6">
                <!-- Book Info -->
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-slate-400 font-medium">Buku yang Dipinjam</div>
                        <h4 class="font-bold text-slate-900 text-base sm:text-lg">{{ $loan->book->title }}</h4>
                        <div class="text-xs text-slate-500 mt-0.5">Penulis: {{ $loan->book->author }} • Rak: {{ $loan->book->rack_location ?: '-' }}</div>
                    </div>
                </div>

                <!-- Timeline / Key Dates Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                        <div class="text-xs text-slate-400 mb-1">Tanggal Diajukan</div>
                        <div class="font-bold text-slate-800">{{ $loan->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                        <div class="text-xs text-slate-400 mb-1">Tanggal Diambil (Fisik)</div>
                        <div class="font-bold text-slate-800">{{ $loan->borrowed_at ? $loan->borrowed_at->format('d M Y') : 'Belum Diambil' }}</div>
                    </div>
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50">
                        <div class="text-xs text-slate-400 mb-1">Batas Waktu / Jatuh Tempo</div>
                        <div class="font-bold {{ $loan->status === 'terlambat' ? 'text-rose-600' : 'text-emerald-700' }}">
                            {{ $loan->due_at ? $loan->due_at->format('d M Y') : '-' }}
                        </div>
                    </div>
                </div>

                <!-- Borrower Details -->
                <div class="border-t border-slate-100 pt-4 text-sm space-y-2">
                    <div class="flex justify-between text-slate-600">
                        <span>Peminjam Terdaftar:</span>
                        <span class="font-semibold text-slate-900">{{ $loan->member->full_name }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Nomor Anggota:</span>
                        <span class="font-mono font-bold text-emerald-800">{{ $loan->member->member_code }}</span>
                    </div>
                    @if($loan->returned_at)
                    <div class="flex justify-between text-slate-600">
                        <span>Tanggal Dikembalikan:</span>
                        <span class="font-bold text-emerald-600">{{ $loan->returned_at->format('d M Y, H:i') }}</span>
                    </div>
                    @endif
                    @if($loan->notes)
                    <div class="mt-4 p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs">
                        <span class="font-bold block mb-0.5">Catatan Petugas Perpustakaan:</span>
                        {{ $loan->notes }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('perpus.index') }}" class="text-sm font-semibold text-slate-500 hover:text-emerald-700">
                &larr; Kembali ke Katalog Buku Utama
            </a>
        </div>

    </div>
</div>
@endsection
