@extends('layouts.app')

@section('title', 'Ajukan Peminjaman: ' . $book->title . ' - Perpustakaan Digital')

@section('konten_utama')
<div class="perpus-page-wrapper">
    <!-- Compact Container for Form Focus (max-width: 980px) -->
    <div class="perpus-container-form">
        
        <!-- Breadcrumbs & Navigation Bar -->
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <nav class="flex items-center gap-2 text-xs text-slate-300 font-medium" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <span class="text-slate-500">/</span>
                <a href="{{ route('perpus.index') }}" class="hover:text-white transition-colors">Perpustakaan</a>
                <span class="text-slate-500">/</span>
                @if($book->category)
                    <a href="{{ route('perpus.index', ['category' => $book->category_id]) }}" class="hover:text-emerald-300 transition-colors text-emerald-400">
                        {{ $book->category->name }}
                    </a>
                    <span class="text-slate-500">/</span>
                @endif
                <a href="{{ route('perpus.show', $book->id) }}" class="hover:text-emerald-300 transition-colors text-emerald-400 truncate max-w-[150px] sm:max-w-[220px]">
                    {{ $book->title }}
                </a>
                <span class="text-slate-500">/</span>
                <span class="text-slate-400" aria-current="page">Form Pinjam</span>
            </nav>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('perpus.show', $book->id) }}" class="perpus-btn-detail inline-flex items-center gap-1.5 px-3 py-1.5 text-xs rounded-lg">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Detail Buku</span>
                </a>
                <a href="{{ route('perpus.tracking') }}" class="perpus-btn-top-track text-xs !py-1.5 !px-3 !rounded-lg">
                    <span>Lacak Status &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Master Container Card (Compact 2-Column Responsive Layout) -->
        <div class="perpus-card-surface perpus-detail-card perpus-card-compact mb-16 sm:mb-20">
            <div class="perpus-form-grid">
                
                <!-- Left Column: Compact Visual & Guidelines Panel -->
                <div class="perpus-detail-cover-panel perpus-card-subsurface !p-5 !gap-4 flex flex-col items-center justify-between text-center">
                    <div class="w-full flex flex-col items-center justify-center text-center">
                        <!-- Category & Rack Badges (Centered) -->
                        <div class="perpus-cover-panel-header is-centered !mb-3 w-full">
                            <span class="perpus-detail-cat-badge !text-[11px] !py-1 !px-2.5">
                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span>{{ $book->category ? $book->category->name : 'Umum' }}</span>
                            </span>
                            @if($book->rack_location)
                            <span class="perpus-detail-rack-badge !text-[11px] !py-1 !px-2.5">
                                <svg class="w-3 h-3 shrink-0 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Rak: {{ $book->rack_location }}</span>
                            </span>
                            @endif
                        </div>

                        <!-- Book Cover Showcase (Perfect Center) -->
                        <div class="w-full flex items-center justify-center text-center my-1">
                            <div class="perpus-detail-cover-box cover-box-form mx-auto shadow-xl transition-transform duration-300 hover:scale-[1.02]">
                                <img src="{{ $book->cover ? asset('storage/' . $book->cover) : asset('images/book-placeholder.png') }}"
                                     alt="Sampul buku: {{ $book->title }}"
                                     width="195"
                                     height="265"
                                     onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.png') }}';"
                                     class="perpus-book-cover-img mx-auto block">
                            </div>
                        </div>

                        <!-- Title and Author Summary -->
                        <div class="text-center mt-3 px-1 w-full">
                            <div class="text-[10px] uppercase tracking-wider text-emerald-400 font-bold mb-0.5">Buku Pilihan</div>
                            <h2 class="text-sm sm:text-base font-bold text-white line-clamp-2 leading-snug">{{ $book->title }}</h2>
                            <p class="text-xs text-slate-300 mt-0.5 font-medium">{{ $book->author }}</p>
                        </div>
                    </div>

                    <div>
                        <!-- Live Stock Status Widget -->
                        <div class="perpus-stock-widget !p-3 !gap-1.5 rounded-xl">
                            <div class="perpus-stock-widget-label !text-[10px]">Ketersediaan Fisik:</div>
                            <div class="perpus-stock-widget-status !gap-2">
                                <div class="w-2.5 h-2.5 rounded-full {{ $book->available > 0 ? 'bg-emerald-400 animate-pulse' : 'bg-rose-500' }}" aria-hidden="true"></div>
                                <span class="font-bold text-xs sm:text-sm {{ $book->available > 0 ? 'text-emerald-300' : 'text-rose-300' }}">
                                    {{ $book->available > 0 ? $book->available . ' Eksemplar Tersedia' : 'Sedang Dipinjam' }}
                                </span>
                            </div>
                            <div class="perpus-stock-widget-total !text-[11px] !pt-1">
                                Total Koleksi: <strong>{{ $book->stock }} eksemplar</strong>
                            </div>
                        </div>

                        <!-- Mini Guidelines -->
                        <div class="mt-3 pt-3 border-t border-white/10 text-xs text-slate-300 space-y-1.5">
                            <div class="font-bold text-cyan-300 flex items-center gap-1.5 text-[11px] uppercase tracking-wider">
                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Tata Tertib Pinjam:</span>
                            </div>
                            <ul class="space-y-1 list-disc list-inside text-slate-300 text-[11px] leading-relaxed">
                                <li>Masa pinjam <strong>7 hari kalender</strong>.</li>
                                <li>Tunjukkan kode peminjaman ke petugas.</li>
                                <li>Wajib merawat keutuhan buku.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Form Panel -->
                <div class="perpus-detail-content-panel">
                    <div>
                        <!-- Category & Status Tag Row -->
                        <div class="perpus-detail-tag-row !mb-3 !gap-2">
                            <span class="perpus-detail-cat-badge !text-[11px] !py-1 !px-2.5">
                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Sirkulasi Mandiri Online</span>
                            </span>

                            @if($book->rack_location)
                            <span class="perpus-detail-rack-badge !text-[11px] !py-1 !px-2.5">
                                <span>Rak: {{ $book->rack_location }}</span>
                            </span>
                            @endif

                            <span class="perpus-detail-stock-badge !text-[11px] !py-1 !px-2.5 {{ $book->available > 0 ? 'badge-in-stock' : 'badge-out-stock' }}">
                                <span class="badge-dot {{ $book->available > 0 ? 'animate-pulse' : '' }}"></span>
                                <span>{{ $book->available > 0 ? 'Siap Dipinjam' : 'Stok Habis' }}</span>
                            </span>
                        </div>

                        <!-- Page / Form Title -->
                        <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight mb-1.5">
                            Ajukan Peminjaman Buku
                        </h1>

                        <!-- Editorial Byline: Penulis & Masa Pinjam -->
                        <div class="perpus-detail-byline !mb-4 !gap-2.5 sm:!gap-3 text-xs sm:text-sm">
                            <div class="perpus-byline-item">
                                <span class="text-slate-400">Buku:</span>
                                <strong class="text-white truncate max-w-[180px] sm:max-w-none">{{ $book->title }}</strong>
                            </div>
                            <span class="perpus-byline-separator">&bull;</span>
                            <div class="perpus-byline-item">
                                <span class="text-slate-400">Penulis:</span>
                                <strong class="text-slate-200">{{ $book->author }}</strong>
                            </div>
                            <span class="perpus-byline-separator">&bull;</span>
                            <div class="perpus-byline-item">
                                <span class="text-slate-400">Durasi:</span>
                                <strong class="text-emerald-400 font-bold">7 Hari</strong>
                            </div>
                        </div>

                        <!-- Specifications Matrix Grid (Compact) -->
                        <div class="perpus-specs-matrix !py-2.5 !my-3 !gap-2.5">
                            <!-- Card 1: Penulis -->
                            <div class="perpus-spec-card !p-2.5 !gap-2.5 rounded-xl">
                                <div class="perpus-spec-icon stat-blue !w-8 !h-8 !rounded-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="perpus-spec-content">
                                    <span class="perpus-spec-label !text-[10px]">Penulis</span>
                                    <span class="perpus-spec-val !text-xs truncate" title="{{ $book->author }}">{{ $book->author }}</span>
                                </div>
                            </div>

                            <!-- Card 2: Penerbit -->
                            <div class="perpus-spec-card !p-2.5 !gap-2.5 rounded-xl">
                                <div class="perpus-spec-icon stat-purple !w-8 !h-8 !rounded-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="perpus-spec-content">
                                    <span class="perpus-spec-label !text-[10px]">Penerbit</span>
                                    <span class="perpus-spec-val !text-xs truncate" title="{{ $book->publisher ?: '-' }}">{{ $book->publisher ?: 'Koleksi Perpustakaan' }}</span>
                                </div>
                            </div>

                            <!-- Card 3: ISBN -->
                            <div class="perpus-spec-card !p-2.5 !gap-2.5 rounded-xl">
                                <div class="perpus-spec-icon stat-cyan !w-8 !h-8 !rounded-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                    </svg>
                                </div>
                                <div class="perpus-spec-content">
                                    <span class="perpus-spec-label !text-[10px]">Nomor ISBN</span>
                                    <span class="perpus-spec-val font-mono text-cyan-300 !text-xs">{{ $book->isbn ?: 'Tidak Terdaftar' }}</span>
                                </div>
                            </div>

                            <!-- Card 4: Durasi Pinjam -->
                            <div class="perpus-spec-card !p-2.5 !gap-2.5 rounded-xl">
                                <div class="perpus-spec-icon stat-green !w-8 !h-8 !rounded-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="perpus-spec-content">
                                    <span class="perpus-spec-label !text-[10px]">Masa Pinjam</span>
                                    <span class="perpus-spec-val text-emerald-400 font-bold !text-xs">7 Hari Kalender</span>
                                </div>
                            </div>
                        </div>

                        <!-- Out of Stock Warning -->
                        @if($book->available < 1)
                        <div class="mb-5 p-4 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-200" role="alert">
                            <div class="flex items-center gap-2 font-bold text-sm mb-1 text-rose-300">
                                <svg class="w-4 h-4 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Seluruh Eksemplar Sedang Dipinjam</span>
                            </div>
                            <p class="text-xs text-slate-300 mb-3 leading-relaxed">
                                Saat ini seluruh eksemplar fisik buku ini sedang dipinjam. Silakan periksa secara berkala atau cari buku lainnya di katalog perpustakaan.
                            </p>
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('perpus.index') }}" class="perpus-btn-detail px-3 py-1.5 text-xs font-semibold rounded-lg inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                    <span>Katalog Buku</span>
                                </a>
                                <a href="{{ route('perpus.tracking') }}" class="perpus-btn-top-track !text-xs !py-1.5 !px-3 !rounded-lg">
                                    <span>Lacak Pinjaman &rarr;</span>
                                </a>
                            </div>
                        </div>
                        @endif

                        <!-- Validation Error Summary -->
                        @if($errors->any())
                        <div class="mb-5 p-3.5 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-300 text-xs sm:text-sm" role="alert" aria-live="assertive">
                            <div class="font-bold mb-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Periksa kembali data pengajuan:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-0.5 pl-1 text-xs">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Submission Form with Clean, Subtle Placeholders -->
                        <form action="{{ route('perpus.pinjam.store', $book->id) }}" method="POST" id="pinjamForm" novalidate>
                            @csrf

                            <div class="space-y-4 mb-5">
                                <!-- Field 1: Nama Lengkap -->
                                <div>
                                    <label for="full_name" class="block text-xs sm:text-sm font-semibold text-slate-200 mb-1.5">
                                        Nama Lengkap Peminjam <span class="text-rose-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3 text-slate-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </span>
                                        <input type="text"
                                               id="full_name"
                                               name="full_name"
                                               value="{{ old('full_name') }}"
                                               required
                                               placeholder="Masukkan nama lengkap peminjam"
                                               aria-invalid="{{ $errors->has('full_name') ? 'true' : 'false' }}"
                                               class="perpus-form-input !pl-10 !py-2.5 !text-sm {{ $errors->has('full_name') ? '!border-rose-500' : '' }}"
                                               {{ $book->available < 1 ? 'disabled' : '' }}>
                                    </div>
                                    @error('full_name')
                                        <p class="text-xs text-rose-400 mt-1 font-medium">{{ $message }}</p>
                                    @else
                                        <p class="text-[11px] text-slate-400 mt-1">Terbuka untuk santri, siswa, dewan guru, staf, maupun wali murid.</p>
                                    @enderror
                                </div>

                                <!-- Field 2: Nomor WhatsApp -->
                                <div>
                                    <label for="phone" class="block text-xs sm:text-sm font-semibold text-slate-200 mb-1.5">
                                        Nomor WhatsApp / HP Aktif <span class="text-rose-400">*</span>
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3.5 top-3 text-slate-400 pointer-events-none">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        </span>
                                        <input type="tel"
                                               id="phone"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               required
                                               placeholder="Masukkan nomor WhatsApp aktif"
                                               aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                               class="perpus-form-input !pl-10 !py-2.5 !text-sm {{ $errors->has('phone') ? '!border-rose-500' : '' }}"
                                               {{ $book->available < 1 ? 'disabled' : '' }}>
                                    </div>
                                    @error('phone')
                                        <p class="text-xs text-rose-400 mt-1 font-medium">{{ $message }}</p>
                                    @else
                                        <p class="text-[11px] text-emerald-400 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>Nomor ini menjadi identitas akun sirkulasi dan bukti pelacakan peminjaman buku Anda.</span>
                                        </p>
                                    @enderror
                                </div>

                                <!-- Field 3: Kelas / Asrama / Domisili -->
                                <div>
                                    <label for="address" class="block text-xs sm:text-sm font-semibold text-slate-200 mb-1.5">
                                        Kelas / Asrama / Alamat Domisili <span class="text-xs font-normal text-slate-400">(Opsional)</span>
                                    </label>
                                    <textarea id="address"
                                              name="address"
                                              rows="2"
                                              placeholder="Tuliskan kelas, asrama, atau alamat domisili"
                                              class="perpus-form-input !py-2.5 !px-3.5 !text-sm {{ $errors->has('address') ? '!border-rose-500' : '' }}"
                                              {{ $book->available < 1 ? 'disabled' : '' }}>{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="text-xs text-rose-400 mt-1 font-medium">{{ $message }}</p>
                                    @else
                                        <p class="text-[11px] text-slate-400 mt-1">Membantu petugas mengenali afiliasi Anda di lingkungan sekolah.</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Information Policy Callout (Compact) -->
                            <div class="perpus-policy-callout !p-3.5 !mb-5 !gap-3 rounded-xl">
                                <div class="perpus-policy-icon !mt-0.5">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="perpus-policy-text">
                                    <label class="flex items-start gap-2.5 cursor-pointer select-none">
                                        <input type="checkbox"
                                               id="agree_terms"
                                               name="agree_terms"
                                               value="1"
                                               required
                                               checked
                                               class="mt-0.5 w-3.5 h-3.5 rounded text-emerald-600 bg-white/10 border-white/20 focus:ring-emerald-500 cursor-pointer">
                                        <span class="text-xs text-slate-300 leading-relaxed">
                                            <strong>Ketentuan Peminjaman:</strong> Saya bersedia merawat buku ini dengan baik, menjaga kebersihan halaman, dan berkomitmen mengembalikannya tepat waktu dalam tempo <strong>7 hari kalender</strong> sejak serah terima fisik buku.
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Call To Action Bar -->
                            <div class="perpus-detail-cta-bar !pt-4 !mt-2 !gap-3">
                                @if($book->available > 0)
                                <button type="submit" id="submitBtn" class="perpus-btn-borrow w-full sm:w-auto flex-1 text-center !py-3 !px-6 text-sm font-bold !min-h-[46px] inline-flex items-center justify-center cursor-pointer !rounded-xl">
                                    <svg id="submitIcon" class="w-4 h-4 mr-2 inline-block shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <svg id="submitSpinner" class="w-4 h-4 mr-2 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                    </svg>
                                    <span id="submitText">Kirim Pengajuan Peminjaman</span>
                                </button>
                                @else
                                <div class="w-full sm:w-auto flex-1 !py-3 !px-6 perpus-btn-disabled text-center font-bold !min-h-[46px] inline-flex items-center justify-center !rounded-xl text-xs sm:text-sm">
                                    <svg class="w-4 h-4 mr-2 inline-block shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Seluruh Eksemplar Sedang Dipinjam</span>
                                </div>
                                @endif

                                <a href="{{ route('perpus.show', $book->id) }}" class="perpus-btn-detail w-full sm:w-auto !px-6 !py-3 text-center text-xs sm:text-sm font-semibold !min-h-[46px] inline-flex items-center justify-center !rounded-xl">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

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
            const agreeTerms = document.getElementById('agree_terms')?.checked;

            if (!fullName || !phone || !agreeTerms) {
                return; // Let browser/native validation handle empty or unchecked fields
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
