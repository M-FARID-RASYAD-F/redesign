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
            <h1 class="header-title" style="font-size: 1.4rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0;">
                Peminjaman: <span style="font-family: monospace; color: var(--adm-primary, #00B4D8);">{{ $loan->loan_code }}</span>
            </h1>
        </div>
        <div>
            @php
                $badgeStyles = match($loan->status) {
                    'diajukan'     => 'background-color: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4);',
                    'dipinjam'     => 'background-color: rgba(56, 189, 248, 0.2); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4);',
                    'dikembalikan' => 'background-color: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4);',
                    'terlambat'    => 'background-color: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4);',
                    default        => 'background-color: rgba(255, 255, 255, 0.1); color: #cbd5e1;',
                };
            @endphp
            <span style="display: inline-block; padding: 6px 14px; border-radius: 9999px; font-size: 0.85rem; font-weight: 600; {{ $badgeStyles }}">
                Status: {{ $loan->status_label }}
            </span>
        </div>
    </div>
</div>

@if(session('success'))
<div style="background-color: rgba(16, 185, 129, 0.15); border-left: 4px solid #10b981; color: #6ee7b7; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
    {{ session('success') }}
</div>
@endif

<div class="admin-perpus-main-grid">
    <!-- Left Column: Details -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <!-- Card Info Buku -->
        <div class="card" style="padding: 22px;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0 0 16px; border-bottom: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.12)); padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/></svg>
                Informasi Buku yang Dipinjam
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 0.9rem;">
                <div style="grid-column: span 2;">
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Judul Buku</div>
                    <div style="font-weight: 700; color: var(--adm-text-title, #ffffff); font-size: 1.1rem;">{{ $loan->book->title }}</div>
                </div>
                <div>
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Penulis</div>
                    <div style="font-weight: 600; color: var(--adm-text-sub, #f1f5f9);">{{ $loan->book->author }}</div>
                </div>
                <div>
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Penerbit</div>
                    <div style="font-weight: 500; color: var(--adm-text-sub, #f1f5f9);">{{ $loan->book->publisher ?: '-' }}</div>
                </div>
                <div>
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Kategori</div>
                    <span style="background-color: rgba(0, 180, 216, 0.18); color: var(--adm-primary, #00B4D8); border: 1px solid rgba(0, 180, 216, 0.35); padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">
                        {{ $loan->book->category ? $loan->book->category->name : 'Umum' }}
                    </span>
                </div>
                <div>
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Lokasi Rak Fisik</div>
                    <div style="font-weight: 600; color: var(--adm-text-sub, #f1f5f9);">{{ $loan->book->rack_location ?: '-' }}</div>
                </div>
                <div>
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Ketersediaan Stok Fisik Saat Ini</div>
                    <div style="font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9);">
                        <strong style="color: var(--adm-text-title, #ffffff);">{{ $loan->book->available }}</strong> tersedia dari total <strong style="color: var(--adm-text-title, #ffffff);">{{ $loan->book->stock }}</strong> eksemplar
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Info Peminjam -->
        <div class="card" style="padding: 22px;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0 0 16px; border-bottom: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.12)); padding-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                Identitas Peminjam (Anggota)
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 0.9rem;">
                <div>
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Nama Lengkap</div>
                    <div style="font-weight: 700; color: var(--adm-text-title, #ffffff);">{{ $loan->member->full_name }}</div>
                </div>
                <div>
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Nomor Anggota</div>
                    <span style="font-family: monospace; font-weight: 700; color: var(--adm-primary, #00B4D8); background: rgba(0, 180, 216, 0.18); border: 1px solid rgba(0, 180, 216, 0.35); padding: 2px 6px; border-radius: 4px;">
                        {{ $loan->member->member_code }}
                    </span>
                </div>
                <div>
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Nomor Telepon / WhatsApp</div>
                    <div style="font-weight: 600;">
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $loan->member->phone)) }}" target="_blank" style="color: #34d399; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                            {{ $loan->member->phone }} ↗
                        </a>
                    </div>
                </div>
                <div>
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Terdaftar Sejak</div>
                    <div style="color: var(--adm-text-sub, #f1f5f9);">{{ $loan->member->joined_at ? $loan->member->joined_at->format('d F Y') : '-' }}</div>
                </div>
                <div style="grid-column: span 2;">
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem; margin-bottom: 2px;">Alamat / Domisili</div>
                    <div style="color: var(--adm-text-sub, #f1f5f9);">{{ $loan->member->address ?: 'Tidak dicantumkan' }}</div>
                </div>
            </div>
        </div>

        <!-- Card Timeline -->
        <div class="card" style="padding: 22px;">
            <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0 0 16px; border-bottom: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.12)); padding-bottom: 10px;">
                Jadwal Peminjaman
            </h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; font-size: 0.9rem;">
                <div style="background: rgba(255, 255, 255, 0.05); padding: 12px; border-radius: 8px; border: 1px solid var(--adm-border, rgba(0, 180, 216, 0.25));">
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.775rem;">Tanggal Dipinjam</div>
                    <div style="font-weight: 700; color: var(--adm-text-title, #ffffff); margin-top: 4px;">
                        {{ $loan->borrowed_at ? $loan->borrowed_at->format('d/m/Y') : 'Belum diserahkan' }}
                    </div>
                </div>
                <div style="background: rgba(255, 255, 255, 0.05); padding: 12px; border-radius: 8px; border: 1px solid var(--adm-border, rgba(0, 180, 216, 0.25));">
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.775rem;">Jatuh Tempo Pengembalian</div>
                    <div style="font-weight: 700; color: {{ $loan->status === 'terlambat' ? '#f87171' : 'var(--adm-text-title, #ffffff)' }}; margin-top: 4px;">
                        {{ $loan->due_at ? $loan->due_at->format('d/m/Y') : '-' }}
                    </div>
                </div>
                <div style="background: rgba(255, 255, 255, 0.05); padding: 12px; border-radius: 8px; border: 1px solid var(--adm-border, rgba(0, 180, 216, 0.25));">
                    <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.775rem;">Tanggal Pengembalian Riil</div>
                    <div style="font-weight: 700; color: #34d399; margin-top: 4px;">
                        {{ $loan->returned_at ? $loan->returned_at->format('d/m/Y') : 'Belum kembali' }}
                    </div>
                </div>
            </div>
            @if($loan->notes)
            <div style="margin-top: 14px; background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.35); padding: 12px; border-radius: 8px;">
                <div style="font-size: 0.8rem; font-weight: 600; color: #fbbf24; margin-bottom: 2px;">Catatan Tambahan:</div>
                <div style="font-size: 0.875rem; color: #fde68a;">{{ $loan->notes }}</div>
            </div>
            @endif
        </div>
    </div>

    <!-- Right Column: Verification Form -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        <div class="card" style="padding: 22px; border-top: 4px solid var(--adm-primary, #00B4D8);">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0 0 16px;">
                Ubah Status Peminjaman
            </h3>
            <p style="font-size: 0.85rem; color: var(--adm-text-muted, #cbd5e1); margin-top: 0; margin-bottom: 18px; line-height: 1.4;">
                Mengubah status ke <strong>Sedang Dipinjam</strong> akan mengurangi stok tersedia buku. Mengubah ke <strong>Sudah Dikembalikan</strong> akan mengembalikan stok.
            </p>

            <form action="{{ route('admin.perpus.loans.status', $loan->id) }}" method="POST">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">
                        Pilih Status Baru <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="status" class="form-control" style="cursor: pointer; font-weight: 500;">
                        <option value="diajukan" {{ old('status', $loan->status) == 'diajukan' ? 'selected' : '' }} style="background: var(--adm-card-solid, #002147); color: #ffffff;">
                            Menunggu Verifikasi (Diajukan)
                        </option>
                        <option value="dipinjam" {{ old('status', $loan->status) == 'dipinjam' ? 'selected' : '' }} style="background: var(--adm-card-solid, #002147); color: #ffffff;">
                            Sedang Dipinjam (Buku Fisik Diserahkan)
                        </option>
                        <option value="dikembalikan" {{ old('status', $loan->status) == 'dikembalikan' ? 'selected' : '' }} style="background: var(--adm-card-solid, #002147); color: #ffffff;">
                            Sudah Dikembalikan (Buku Kembali ke Rak)
                        </option>
                        <option value="terlambat" {{ old('status', $loan->status) == 'terlambat' ? 'selected' : '' }} style="background: var(--adm-card-solid, #002147); color: #ffffff;">
                            Terlambat (Melewati Batas Waktu)
                        </option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; font-size: 0.875rem; color: var(--adm-text-sub, #f1f5f9); margin-bottom: 6px;">
                        Catatan Petugas (Opsional)
                    </label>
                    <textarea name="notes" rows="3" placeholder="Mis. Kondisi buku saat dikembalikan, alasan perpanjangan, dsb." class="form-control" style="font-family: inherit; font-size: 0.875rem;">{{ old('notes', $loan->notes) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 11px; font-weight: 600; display: inline-flex; justify-content: center; align-items: center; gap: 6px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Simpan Perubahan Status
                </button>
            </form>
        </div>

        <!-- Action Danger Card -->
        <div class="card" style="padding: 18px; border: 1px solid rgba(239, 68, 68, 0.4); background: rgba(239, 68, 68, 0.08);">
            <div style="font-weight: 700; font-size: 0.875rem; color: #f87171; margin-bottom: 6px;">Hapus Data Peminjaman</div>
            <p style="font-size: 0.8rem; color: #fca5a5; margin: 0 0 12px; line-height: 1.4;">
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
