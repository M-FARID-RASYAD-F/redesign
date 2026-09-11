@extends('layouts.admin')

@section('title', 'Pendaftaran PPDB Online - At-Tamam Edu')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 class="header-title">Pendaftaran PPDB Online</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola dan verifikasi pendaftaran calon peserta didik baru sesuai tingkatannya.</p>
    </div>
    <div>
        <a href="{{ route('admin.ppdb.export', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null]) }}" class="btn btn-success" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 10px 18px; border-radius: 8px; text-decoration: none; color: white; background: #10b981;">
            📥 Unduh Rekap CSV {{ $currentJenjang !== 'all' ? '(' . strtoupper($currentJenjang) . ')' : '' }}
        </a>
    </div>
</div>

<!-- FILTER TAB BERDASARKAN TINGKATAN (SD, SMP, SMK) -->
<div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
    <a href="{{ route('admin.ppdb.index') }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'all' ? 'background: var(--primary); color: #ffffff;' : 'background: rgba(255,255,255,0.06); color: var(--text-muted); border: 1px solid var(--border);' }}">
        <span>📋</span> Semua Tingkat
        <span style="background: rgba(0,0,0,0.25); padding: 2px 8px; border-radius: 999px; font-size: 0.75rem;">{{ $counts['all'] }}</span>
    </a>

    <a href="{{ route('admin.ppdb.index', ['jenjang' => 'sd']) }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'sd' ? 'background: #059669; color: #ffffff;' : 'background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.3);' }}">
        <span>🎒</span> SD (Sekolah Dasar)
        <span style="background: rgba(0,0,0,0.25); padding: 2px 8px; border-radius: 999px; font-size: 0.75rem;">{{ $counts['sd'] }}</span>
    </a>

    <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smp']) }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'smp' ? 'background: #0284c7; color: #ffffff;' : 'background: rgba(56,189,248,0.1); color: #38bdf8; border: 1px solid rgba(56,189,248,0.3);' }}">
        <span>📚</span> SMP (Menengah Pertama)
        <span style="background: rgba(0,0,0,0.25); padding: 2px 8px; border-radius: 999px; font-size: 0.75rem;">{{ $counts['smp'] }}</span>
    </a>

    <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smk']) }}" 
       style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'smk' ? 'background: #7c3aed; color: #ffffff;' : 'background: rgba(168,85,247,0.1); color: #c084fc; border: 1px solid rgba(168,85,247,0.3);' }}">
        <span>💻</span> SMK (Kejuruan)
        <span style="background: rgba(0,0,0,0.25); padding: 2px 8px; border-radius: 999px; font-size: 0.75rem;">{{ $counts['smk'] }}</span>
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Pendaftaran</th>
                    <th>Tingkat / Jenjang</th>
                    <th>Nama Calon Siswa</th>
                    <th>Nama Orang Tua</th>
                    <th>Telepon Orang Tua</th>
                    <th>Status</th>
                    <th style="width: 220px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($registrations as $reg)
                <tr>
                    <td style="font-weight: 700; font-family: monospace; color: var(--primary);">
                        {{ $reg->no_pendaftaran }}
                    </td>
                    <td>
                        @if($reg->jenjang === 'sd')
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35);">
                                🎒 SD
                            </span>
                        @elseif($reg->jenjang === 'smp')
                            <span class="badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35);">
                                📚 SMP
                            </span>
                        @elseif($reg->jenjang === 'smk')
                            <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35);">
                                💻 SMK
                            </span>
                            @if($reg->major_choice)
                                <div style="font-size: 0.75rem; color: #a855f7; margin-top: 3px; font-weight: 600;">
                                    {{ $reg->major_choice }}
                                </div>
                            @endif
                        @else
                            <span class="badge" style="background: rgba(148, 163, 184, 0.15); color: #94a3b8;">
                                {{ strtoupper($reg->jenjang ?? '-') }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #ffffff; margin-bottom: 2px;">{{ $reg->full_name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">
                            {{ $reg->gender == 'L' ? 'Laki-laki' : 'Perempuan' }} · Lahir: {{ $reg->birth_date ? $reg->birth_date->format('d/m/Y') : '-' }}
                        </div>
                    </td>
                    <td>
                        {{ $reg->parent_name }}
                    </td>
                    <td>
                        {{ $reg->parent_phone }}
                    </td>
                    <td>
                        @if($reg->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($reg->status == 'diverifikasi')
                            <span class="badge badge-info">Diverifikasi</span>
                        @elseif($reg->status == 'diterima')
                            <span class="badge badge-success">Diterima</span>
                        @elseif($reg->status == 'ditolak')
                            <span class="badge badge-danger">Ditolak</span>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary);">Detail & Verifikasi</a>
                            
                            @can('delete', $reg)
                            <form action="{{ route('admin.ppdb.delete', $reg->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus pendaftar <strong>{{ $reg->full_name }}</strong>? Tindakan ini tidak dapat dibatalkan.">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger">🗑️ Hapus</button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 30px;">
                        @if($currentJenjang !== 'all')
                            Belum ada pendaftaran PPDB untuk tingkat <strong>{{ strtoupper($currentJenjang) }}</strong>.
                        @else
                            Belum ada pendaftaran PPDB online masuk.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
