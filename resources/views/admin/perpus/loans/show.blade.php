@extends('layouts.admin')

@section('title', 'Verifikasi Peminjaman - ' . $loan->loan_code)

@section('content')
<div class="header" style="margin-bottom: 24px;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('admin.perpus.loans.index') }}" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 4px;">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <h1 class="header-title" style="font-size: 1.4rem; font-weight: 700; color: #1e293b; margin: 0;">
                Peminjaman: <span style="font-family: monospace; color: #0284c7;">{{ $loan->loan_code }}</span>
            </h1>
        </div>
        <div>
            @php
                $badgeStyles = match($loan->status) {
                    'diajukan'     => 'background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;',
                    'dipinjam'     => 'background-color: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe;',
                    'dikembalikan' => 'background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;',
                    'terlambat'    => 'background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;',
                    default        => 'background-color: #f1f5f9; color: #475569;',
                };
            @endphp
            <span style="display: inline-block; padding: 6px 14px; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; {{ $badgeStyles }}">
                Status: {{ $loan->status_label }}
            </span>
        </div>
    </div>
</div>

@if(session('success'))
<div style="background-color: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
    {{ session('success') }}
</div>
@endif

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; align-items: start;">
    <!-- Left Column: Details -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Card Info Buku -->
        <div class="card" style="padding: 22px;">
            <h3 style="font-size: 1.05rem; font-weight: 600; color: #1e293b; margin: 0 0 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
                Informasi Buku yang Dipinjam
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 0.9rem;">
                <div style="grid-column: span 2;">
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Judul Buku</div>
                    <div style="font-weight: 700; color: #0f172a; font-size: 1.1rem;">{{ $loan->book->title }}</div>
                </div>
                <div>
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Penulis</div>
                    <div style="font-weight: 600; color: #334155;">{{ $loan->book->author }}</div>
                </div>
                <div>
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Penerbit</div>
                    <div style="font-weight: 500; color: #334155;">{{ $loan->book->publisher ?: '-' }}</div>
                </div>
                <div>
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Kategori</div>
                    <span style="background-color: #e0f2fe; color: #0369a1; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 500;">
                        {{ $loan->book->category ? $loan->book->category->name : 'Umum' }}
                    </span>
                </div>
                <div>
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Lokasi Rak Fisik</div>
                    <div style="font-weight: 600; color: #334155;">{{ $loan->book->rack_location ?: '-' }}</div>
                </div>
                <div>
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Ketersediaan Stok Fisik Saat Ini</div>
                    <div style="font-size: 0.875rem;">
                        <strong>{{ $loan->book->available }}</strong> tersedia dari total <strong>{{ $loan->book->stock }}</strong> eksemplar
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Info Peminjam -->
        <div class="card" style="padding: 22px;">
            <h3 style="font-size: 1.05rem; font-weight: 600; color: #1e293b; margin: 0 0 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Identitas Peminjam (Anggota)
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 0.9rem;">
                <div>
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Nama Lengkap</div>
                    <div style="font-weight: 700; color: #0f172a;">{{ $loan->member->full_name }}</div>
                </div>
                <div>
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Nomor Anggota</div>
                    <span style="font-family: monospace; font-weight: 700; color: #0369a1; background: #e0f2fe; padding: 2px 6px; border-radius: 4px;">
                        {{ $loan->member->member_code }}
                    </span>
                </div>
                <div>
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Nomor Telepon / WhatsApp</div>
                    <div style="font-weight: 600; color: #0f172a;">
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $loan->member->phone)) }}" target="_blank" style="color: #059669; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                            {{ $loan->member->phone }} ↗
                        </a>
                    </div>
                </div>
                <div>
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Terdaftar Sejak</div>
                    <div style="color: #334155;">{{ $loan->member->joined_at ? $loan->member->joined_at->format('d F Y') : '-' }}</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 2px;">Alamat / Domisili</div>
                    <div style="color: #334155;">{{ $loan->member->address ?: 'Tidak dicantumkan' }}</div>
                </div>
            </div>
        </div>

        <!-- Card Timeline -->
        <div class="card" style="padding: 22px;">
            <h3 style="font-size: 1.05rem; font-weight: 600; color: #1e293b; margin: 0 0 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
                Jadwal Peminjaman
            </h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; font-size: 0.9rem;">
                <div style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div style="color: #64748b; font-size: 0.775rem;">Tanggal Dipinjam</div>
                    <div style="font-weight: 700; color: #1e293b; margin-top: 4px;">
                        {{ $loan->borrowed_at ? $loan->borrowed_at->format('d/m/Y') : 'Belum diserahkan' }}
                    </div>
                </div>
                <div style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div style="color: #64748b; font-size: 0.775rem;">Jatuh Tempo Pengembalian</div>
                    <div style="font-weight: 700; color: {{ $loan->status === 'terlambat' ? '#dc2626' : '#1e293b' }}; margin-top: 4px;">
                        {{ $loan->due_at ? $loan->due_at->format('d/m/Y') : '-' }}
                    </div>
                </div>
                <div style="background: #f8fafc; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div style="color: #64748b; font-size: 0.775rem;">Tanggal Pengembalian Riil</div>
                    <div style="font-weight: 700; color: #15803d; margin-top: 4px;">
                        {{ $loan->returned_at ? $loan->returned_at->format('d/m/Y') : 'Belum kembali' }}
                    </div>
                </div>
            </div>
            @if($loan->notes)
            <div style="margin-top: 14px; background: #fffbeb; border: 1px solid #fef3c7; padding: 12px; border-radius: 8px;">
                <div style="font-size: 0.8rem; font-weight: 600; color: #92400e; margin-bottom: 2px;">Catatan Tambahan:</div>
                <div style="font-size: 0.875rem; color: #78350f;">{{ $loan->notes }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Right Column: Verification Form -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <div class="card" style="padding: 22px; border-top: 4px solid #0284c7;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0 0 16px;">
                Ubah Status Peminjaman
            </h3>
            <p style="font-size: 0.85rem; color: #64748b; margin-top: 0; margin-bottom: 18px; line-height: 1.4;">
                Mengubah status ke <strong>Sedang Dipinjam</strong> akan mengurangi stok tersedia buku. Mengubah ke <strong>Sudah Dikembalikan</strong> akan mengembalikan stok.
            </p>

            <form action="{{ route('admin.perpus.loans.status', $loan->id) }}" method="POST">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 6px;">
                        Pilih Status Baru <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="status" class="form-control" style="width: 100%; padding: 10px 12px; border-radius: 6px; border: 1px solid #cbd5e1; font-weight: 500;">
                        <option value="diajukan" {{ old('status', $loan->status) == 'diajukan' ? 'selected' : '' }}>
                            Menunggu Verifikasi (Diajukan)
                        </option>
                        <option value="dipinjam" {{ old('status', $loan->status) == 'dipinjam' ? 'selected' : '' }}>
                            Sedang Dipinjam (Buku Fisik Diserahkan)
                        </option>
                        <option value="dikembalikan" {{ old('status', $loan->status) == 'dikembalikan' ? 'selected' : '' }}>
                            Sudah Dikembalikan (Buku Kembali ke Rak)
                        </option>
                        <option value="terlambat" {{ old('status', $loan->status) == 'terlambat' ? 'selected' : '' }}>
                            Terlambat (Melewati Batas Waktu)
                        </option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: #334155; margin-bottom: 6px;">
                        Catatan Petugas (Opsional)
                    </label>
                    <textarea name="notes" rows="3" placeholder="Mis. Kondisi buku saat dikembalikan, alasan perpanjangan, dsb." class="form-control" style="width: 100%; padding: 10px 12px; border-radius: 6px; border: 1px solid #cbd5e1; font-family: inherit; font-size: 0.875rem;">{{ old('notes', $loan->notes) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 11px; font-weight: 600; display: inline-flex; justify-content: center; align-items: center; gap: 6px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan Status
                </button>
            </form>
        </div>

        <!-- Action Danger Card -->
        <div class="card" style="padding: 18px; border: 1px solid #fee2e2; background-color: #fffaf0;">
            <div style="font-weight: 600; font-size: 0.875rem; color: #991b1b; margin-bottom: 6px;">Hapus Data Peminjaman</div>
            <p style="font-size: 0.8rem; color: #7f1d1d; margin: 0 0 12px; line-height: 1.4;">
                Data peminjaman ini dapat dihapus permanen dari sistem bila terjadi kesalahan input atau pembatalan sepihak.
            </p>
            <form action="{{ route('admin.perpus.loans.delete', $loan->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus peminjaman {{ $loan->loan_code }}?">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger" style="width: 100%; padding: 8px;">
                    Hapus Peminjaman Ini
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
