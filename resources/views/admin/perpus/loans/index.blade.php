@extends('layouts.admin')

@section('title', 'Daftar Peminjaman Buku - Perpustakaan Digital')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
    <div>
        <h1 class="header-title" style="font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0 0 6px 0;">Peminjaman & Pengembalian Buku</h1>
        <p style="color: var(--text-muted, #64748b); font-size: 0.9rem; margin: 0;">Verifikasi pengajuan peminjaman baru, kelola masa pinjam, dan konfirmasi pengembalian buku.</p>
    </div>
    <div>
        <a href="{{ route('admin.perpus.loans.export', ['status' => request('status')]) }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px;">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Ekspor Laporan CSV
        </a>
    </div>
</div>

@if(session('success'))
<div style="background-color: #ecfdf5; border-left: 4px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem;">
    {{ session('success') }}
</div>
@endif

<!-- Status Filter Tabs -->
<div style="display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;">
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
       style="padding: 7px 14px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; font-weight: 500; transition: all 0.2s; {{ $currStatus === $key ? 'background-color: #0f172a; color: #fff;' : 'background-color: #f1f5f9; color: #475569; hover:background-color: #e2e8f0;' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<!-- Table Card -->
<div class="card">
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569;">
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
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 14px 16px;">
                        <span style="font-family: monospace; font-weight: 700; color: #0284c7; background: #e0f2fe; padding: 2px 6px; border-radius: 4px; font-size: 0.85rem;">
                            {{ $loan->loan_code }}
                        </span>
                        <div style="color: #94a3b8; font-size: 0.775rem; margin-top: 3px;">
                            {{ $loan->created_at->format('d M Y, H:i') }}
                        </div>
                    </td>
                    <td style="padding: 14px 16px;">
                        <div style="font-weight: 600; color: #1e293b;">{{ $loan->member->full_name }}</div>
                        <div style="color: #64748b; font-size: 0.825rem;">
                            HP: {{ $loan->member->phone }} • <span style="font-family: monospace; font-size: 0.775rem;">{{ $loan->member->member_code }}</span>
                        </div>
                    </td>
                    <td style="padding: 14px 16px;">
                        <div style="font-weight: 600; color: #334155;">{{ $loan->book->title }}</div>
                        <div style="color: #64748b; font-size: 0.8rem;">
                            Rak: {{ $loan->book->rack_location ?: '-' }}
                        </div>
                    </td>
                    <td style="padding: 14px 16px; font-size: 0.85rem; color: #475569;">
                        <div>Pinjam: {{ $loan->borrowed_at ? $loan->borrowed_at->format('d/m/Y') : '-' }}</div>
                        <div style="{{ $loan->status === 'terlambat' ? 'color: #dc2626; font-weight: 600;' : '' }}">
                            Tempo: {{ $loan->due_at ? $loan->due_at->format('d/m/Y') : '-' }}
                        </div>
                    </td>
                    <td style="padding: 14px 16px; text-align: center;">
                        @php
                            $badgeStyles = match($loan->status) {
                                'diajukan'     => 'background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;',
                                'dipinjam'     => 'background-color: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe;',
                                'dikembalikan' => 'background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;',
                                'terlambat'    => 'background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;',
                                default        => 'background-color: #f1f5f9; color: #475569;',
                            };
                        @endphp
                        <span style="display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 0.775rem; font-weight: 600; {{ $badgeStyles }}">
                            {{ $loan->status_label }}
                        </span>
                    </td>
                    <td style="padding: 14px 16px; text-align: center;">
                        <div style="display: inline-flex; gap: 6px; align-items: center;">
                            <a href="{{ route('admin.perpus.loans.show', $loan->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary, #0284c7); border-color: #bae6fd; display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; font-size: 0.8rem;">
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
                    <td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8;">
                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 12px; display: block; opacity: 0.5;"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.5L19 7.5V19a2 2 0 0 1-2 2Z"/></svg>
                        Tidak ada riwayat peminjaman buku dalam status ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($loans->hasPages())
    <div style="padding: 16px; border-top: 1px solid #e2e8f0;">
        {{ $loans->links() }}
    </div>
    @endif
</div>
@endsection
