@extends('layouts.admin')

@section('title', 'Daftar Peminjaman Buku - Perpustakaan Digital')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="header-title" style="font-size: 1.5rem; font-weight: 700; color: var(--adm-text-title, #ffffff); margin: 0 0 6px 0;">Peminjaman & Pengembalian Buku</h1>
        <p style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.9rem; margin: 0;">Verifikasi pengajuan peminjaman baru, kelola masa pinjam, dan konfirmasi pengembalian buku.</p>
    </div>
    <div>
        <a href="{{ route('admin.perpus.loans.export', ['status' => request('status')]) }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Ekspor Laporan CSV
        </a>
    </div>
</div>

@if(session('success'))
<div style="background-color: rgba(16, 185, 129, 0.15); border-left: 4px solid #10b981; color: #6ee7b7; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
    {{ session('success') }}
</div>
@endif

<!-- Status Filter Tabs -->
<div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; border-bottom: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.12)); padding-bottom: 12px;">
    @php
        $currStatus = request('status', 'all');
        $tabs = [
            'all'          => 'Semua Peminjaman',
            'diajukan'     => 'Menunggu Verifikasi',
            'dipinjam'     => 'Sedang Dipinjam',
            'dikembalikan' => 'Sudah Dikembalikan',
            'terlambat'    => 'Terlambat',
        ];
    @endphp
    @foreach($tabs as $key => $label)
    <a href="{{ route('admin.perpus.loans.index', $key === 'all' ? [] : ['status' => $key]) }}"
       style="padding: 7px 14px; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: all 0.2s; {{ $currStatus === $key ? 'background: var(--adm-primary, #00B4D8); color: #ffffff; box-shadow: 0 0 12px rgba(0, 180, 216, 0.35);' : 'background: rgba(255, 255, 255, 0.06); color: var(--adm-text-sub, #f1f5f9); border: 1px solid var(--adm-border, rgba(0, 180, 216, 0.25));' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<!-- Table Card -->
<div class="card">
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="background-color: rgba(0, 180, 216, 0.10); border-bottom: 2px solid var(--adm-border, rgba(0, 180, 216, 0.3)); color: var(--adm-text-title, #ffffff);">
                    <th style="padding: 12px 16px; font-weight: 600;">Kode Pinjam</th>
                    <th style="padding: 12px 16px; font-weight: 600;">Peminjam / Anggota</th>
                    <th style="padding: 12px 16px; font-weight: 600;">Judul Buku</th>
                    <th style="padding: 12px 16px; font-weight: 600;">Tgl Pinjam / Jatuh Tempo</th>
                    <th style="padding: 12px 16px; font-weight: 600; text-align: center;">Status</th>
                    <th style="padding: 12px 16px; font-weight: 600; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr style="border-bottom: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.08));">
                    <td style="padding: 14px 16px;">
                        <span style="font-family: monospace; font-weight: 700; color: var(--adm-primary, #00B4D8); background: rgba(0, 180, 216, 0.16); padding: 2px 6px; border-radius: 4px; font-size: 0.85rem; border: 1px solid rgba(0, 180, 216, 0.3);">
                            {{ $loan->loan_code }}
                        </span>
                        <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.775rem; margin-top: 3px;">
                            {{ $loan->created_at->format('d M Y, H:i') }}
                        </div>
                    </td>
                    <td style="padding: 14px 16px;">
                        <div style="font-weight: 600; color: var(--adm-text-title, #ffffff);">{{ $loan->member->full_name }}</div>
                        <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.825rem;">
                            HP: {{ $loan->member->phone }} • <span style="font-family: monospace; font-size: 0.775rem;">{{ $loan->member->member_code }}</span>
                        </div>
                    </td>
                    <td style="padding: 14px 16px;">
                        <div style="font-weight: 600; color: var(--adm-text-title, #ffffff);">{{ $loan->book->title }}</div>
                        <div style="color: var(--adm-text-muted, #cbd5e1); font-size: 0.8rem;">
                            Rak: {{ $loan->book->rack_location ?: '-' }}
                        </div>
                    </td>
                    <td style="padding: 14px 16px; font-size: 0.85rem; color: var(--adm-text-sub, #f1f5f9);">
                        <div>Pinjam: {{ $loan->borrowed_at ? $loan->borrowed_at->format('d/m/Y') : '-' }}</div>
                        <div style="{{ $loan->status === 'terlambat' ? 'color: #f87171; font-weight: 700;' : '' }}">
                            Tempo: {{ $loan->due_at ? $loan->due_at->format('d/m/Y') : '-' }}
                        </div>
                    </td>
                    <td style="padding: 14px 16px; text-align: center;">
                        @php
                            $badgeStyles = match($loan->status) {
                                'diajukan'     => 'background-color: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4);',
                                'dipinjam'     => 'background-color: rgba(56, 189, 248, 0.2); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.4);',
                                'dikembalikan' => 'background-color: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4);',
                                'terlambat'    => 'background-color: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4);',
                                default        => 'background-color: rgba(255, 255, 255, 0.1); color: #cbd5e1;',
                            };
                        @endphp
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 0.775rem; font-weight: 600; {{ $badgeStyles }}">
                            {{ $loan->status_label }}
                        </span>
                    </td>
                    <td style="padding: 14px 16px; text-align: center;">
                        <div style="display: inline-flex; gap: 6px; align-items: center;">
                            <a href="{{ route('admin.perpus.loans.show', $loan->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary, #00B4D8); border-color: var(--adm-border, rgba(0, 180, 216, 0.35)); display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; font-size: 0.8rem;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                Detail / Ubah
                            </a>
                            <form action="{{ route('admin.perpus.loans.delete', $loan->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus data peminjaman <strong>{{ $loan->loan_code }}</strong>?">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger" style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; font-size: 0.8rem;">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 40px; text-align: center; color: var(--adm-text-muted, #cbd5e1);">
                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 12px; display: block; opacity: 0.5;"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.5L19 7.5V19a2 2 0 0 1-2 2Z"/></svg>
                        Tidak ada riwayat peminjaman buku dalam status ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($loans->hasPages())
    <div style="padding: 16px; border-top: 1px solid var(--adm-table-border, rgba(255, 255, 255, 0.12));">
        {{ $loans->links() }}
    </div>
    @endif
</div>
@endsection
