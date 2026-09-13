@extends('layouts.admin')

@section('title', 'Pendaftaran PPDB Online - At-Tamam Edu')

@section('content')
<div class="header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 class="header-title">Pendaftaran PPDB Online</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola dan verifikasi pendaftaran calon peserta didik baru sesuai tingkat dan statusnya.</p>
    </div>
    <div class="header-actions" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
        @if($currentJenjang !== 'all' || $currentStatus !== 'all')
            <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600; padding: 10px 16px; border-radius: 8px;">
                🔄 Reset Filter
            </a>
        @endif
        <a href="{{ route('admin.ppdb.export', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" class="btn btn-success" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 10px 18px; border-radius: 8px; text-decoration: none; color: white; background: #10b981;">
            📥 Unduh Rekap CSV
            @if($currentJenjang !== 'all') ({{ strtoupper($currentJenjang) }}) @endif
            @if($currentStatus !== 'all') [{{ ucfirst($currentStatus) }}] @endif
        </a>
    </div>
</div>

<!-- PANEL FILTER TINGKAT (JENJANG) & STATUS SELEKSI -->
<div class="card ppdb-filter-panel" style="margin-bottom: 22px; padding: 18px 20px; border-radius: 14px;">
    <div style="display: flex; flex-direction: column; gap: 16px;">
        <!-- Baris 1: Filter Berdasarkan Tingkatan (SD, SMP, SMK) -->
        <div class="ppdb-filter-row" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div class="ppdb-filter-label" style="display: flex; align-items: center; gap: 6px; min-width: 140px;">
                <span style="font-size: 0.95rem;">🏫</span>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Tingkat:</span>
            </div>
            <div class="ppdb-filter-options" style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.ppdb.index', ['jenjang' => null, 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'all' ? 'background: var(--primary); color: #ffffff;' : 'background: rgba(255,255,255,0.06); color: var(--text-muted); border: 1px solid var(--border);' }}">
                    <span>📋</span> Semua Tingkat
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $counts['all'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => 'sd', 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'sd' ? 'background: #059669; color: #ffffff;' : 'background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.3);' }}">
                    <span>🎒</span> SD (Sekolah Dasar)
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $counts['sd'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smp', 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'smp' ? 'background: #0284c7; color: #ffffff;' : 'background: rgba(56,189,248,0.1); color: #38bdf8; border: 1px solid rgba(56,189,248,0.3);' }}">
                    <span>📚</span> SMP (Menengah Pertama)
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $counts['smp'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smk', 'status' => $currentStatus !== 'all' ? $currentStatus : null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentJenjang === 'smk' ? 'background: #7c3aed; color: #ffffff;' : 'background: rgba(168,85,247,0.1); color: #c084fc; border: 1px solid rgba(168,85,247,0.3);' }}">
                    <span>💻</span> SMK (Kejuruan)
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $counts['smk'] }}</span>
                </a>
            </div>
        </div>

        <div style="border-top: 1px solid rgba(255, 255, 255, 0.08);"></div>

        <!-- Baris 2: Filter Berdasarkan Status Seleksi -->
        <div class="ppdb-filter-row" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <div class="ppdb-filter-label" style="display: flex; align-items: center; gap: 6px; min-width: 140px;">
                <span style="font-size: 0.95rem;">⚡</span>
                <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Status Seleksi:</span>
            </div>
            <div class="ppdb-filter-options" style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => null]) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'all' ? 'background: var(--primary); color: #ffffff;' : 'background: rgba(255,255,255,0.06); color: var(--text-muted); border: 1px solid var(--border);' }}">
                    <span>📑</span> Semua Status
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['all'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => 'pending']) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'pending' ? 'background: #d97706; color: #ffffff;' : 'background: rgba(245,158,11,0.1); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3);' }}">
                    <span>⏳</span> Pending
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['pending'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => 'diverifikasi']) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'diverifikasi' ? 'background: #0284c7; color: #ffffff;' : 'background: rgba(56,189,248,0.1); color: #38bdf8; border: 1px solid rgba(56,189,248,0.3);' }}">
                    <span>🔍</span> Diverifikasi
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['diverifikasi'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => 'diterima']) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'diterima' ? 'background: #059669; color: #ffffff;' : 'background: rgba(16,185,129,0.1); color: #34d399; border: 1px solid rgba(16,185,129,0.3);' }}">
                    <span>✅</span> Diterima
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['diterima'] }}</span>
                </a>

                <a href="{{ route('admin.ppdb.index', ['jenjang' => $currentJenjang !== 'all' ? $currentJenjang : null, 'status' => 'ditolak']) }}" 
                   style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentStatus === 'ditolak' ? 'background: #dc2626; color: #ffffff;' : 'background: rgba(239,68,68,0.1); color: #f87171; border: 1px solid rgba(239,68,68,0.3);' }}">
                    <span>❌</span> Ditolak
                    <span style="background: rgba(0,0,0,0.25); padding: 2px 7px; border-radius: 999px; font-size: 0.72rem;">{{ $statusCounts['ditolak'] }}</span>
                </a>
            </div>
        </div>
    </div>
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
                    <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px 20px;">
                        <div style="font-size: 2rem; margin-bottom: 8px;">🔍</div>
                        <div style="font-size: 0.98rem; font-weight: 700; color: #ffffff; margin-bottom: 6px;">
                            @if($currentJenjang !== 'all' || $currentStatus !== 'all')
                                Tidak ada data pendaftaran yang sesuai dengan filter
                            @else
                                Belum ada pendaftaran PPDB online masuk
                            @endif
                        </div>
                        <div style="font-size: 0.84rem; color: var(--text-muted); margin-bottom: 16px;">
                            @if($currentJenjang !== 'all' && $currentStatus !== 'all')
                                Tidak ditemukan pendaftar tingkat <strong>{{ strtoupper($currentJenjang) }}</strong> dengan status <strong>{{ ucfirst($currentStatus) }}</strong>.
                            @elseif($currentJenjang !== 'all')
                                Belum ada pendaftar untuk tingkat <strong>{{ strtoupper($currentJenjang) }}</strong>.
                            @elseif($currentStatus !== 'all')
                                Tidak ada pendaftar dengan status <strong>{{ ucfirst($currentStatus) }}</strong>.
                            @else
                                Pendaftaran calon peserta didik baru akan tampil di sini.
                            @endif
                        </div>
                        @if($currentJenjang !== 'all' || $currentStatus !== 'all')
                            <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 6px;">
                                🔄 Tampilkan Semua Pendaftar
                            </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($registrations->hasPages())
    <div style="margin-top: 20px; display: flex; justify-content: flex-end; overflow-x: auto;">
        {{ $registrations->links() }}
    </div>
    @endif
</div>
@endsection
