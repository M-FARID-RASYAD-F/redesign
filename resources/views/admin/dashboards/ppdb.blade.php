@extends('layouts.admin')

@section('title', 'PPDB Dashboard - At-Tamam Edu')

@section('content')
<!-- HERO BANNER (ADMIN PPDB) -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <span>📝</span>
            <span>PORTAL VERIFIKASI & SELEKSI PPDB ONLINE</span>
        </div>
        <h1 class="hero-title">Pusat Seleksi & Verifikasi Berkas Calon Siswa</h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.ppdb.export') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <span>📥</span> Ekspor CSV Rekap
        </a>
        <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <span>📋</span> Tabel Semua Pendaftar
        </a>
    </div>
</div>

<!-- STATISTIK KARTU SELEKSI PPDB -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 26px;">
    <!-- Total Pendaftar -->
    <div class="card" style="margin-bottom: 0;">
        <div style="font-size: 0.82rem; color: var(--adm-text-muted); font-weight: 700; text-transform: uppercase;">TOTAL PENDAFTAR</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: #ffffff; margin-top: 4px;">{{ $stats['total'] }}</div>
        <div style="font-size: 0.78rem; color: var(--adm-text-muted); margin-top: 4px;">Tahun Ajaran 2026/2027</div>
    </div>

    <!-- Menunggu Verifikasi (Pending) -->
    <div class="card" style="margin-bottom: 0; border-color: rgba(245, 158, 11, 0.45); background: rgba(245, 158, 11, 0.08);">
        <div style="font-size: 0.82rem; color: #fbbf24; font-weight: 700; text-transform: uppercase;">⏳ PERLU VERIFIKASI</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: #fbbf24; margin-top: 4px;">{{ $stats['pending'] }}</div>
        <div style="font-size: 0.78rem; color: #fde68a; margin-top: 4px;">Menunggu tindakan panitia</div>
    </div>

    <!-- Terverifikasi -->
    <div class="card" style="margin-bottom: 0;">
        <div style="font-size: 0.82rem; color: var(--adm-text-muted); font-weight: 700; text-transform: uppercase;">📑 BERKAS VALID</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: #38bdf8; margin-top: 4px;">{{ $stats['diverifikasi'] }}</div>
        <div style="font-size: 0.78rem; color: var(--adm-text-muted); margin-top: 4px;">Dokumen lengkap & lolos cek</div>
    </div>

    <!-- Diterima -->
    <div class="card" style="margin-bottom: 0; border-color: rgba(16, 185, 129, 0.45); background: rgba(16, 185, 129, 0.08);">
        <div style="font-size: 0.82rem; color: #34d399; font-weight: 700; text-transform: uppercase;">🎉 SISWA DITERIMA</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: #34d399; margin-top: 4px;">{{ $stats['diterima'] }}</div>
        <div style="font-size: 0.78rem; color: #a7f3d0; margin-top: 4px;">Siap registrasi ulang</div>
    </div>

    <!-- Ditolak -->
    <div class="card" style="margin-bottom: 0;">
        <div style="font-size: 0.82rem; color: var(--adm-text-muted); font-weight: 700; text-transform: uppercase;">❌ TIDAK LOLOS</div>
        <div style="font-size: 2.2rem; font-weight: 800; color: #f87171; margin-top: 4px;">{{ $stats['ditolak'] }}</div>
        <div style="font-size: 0.78rem; color: var(--adm-text-muted); margin-top: 4px;">Tidak memenuhi kriteria</div>
    </div>
</div>

<!-- REKAP PENDAFTAR PER TINGKATAN (SD, SMP, SMK) -->
<div style="margin-bottom: 26px;">
    <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
        <span>🏫</span> Pendaftar Berdasarkan Tingkatan Pendidikan
    </h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
        <!-- SD -->
        <a href="{{ route('admin.ppdb.index', ['jenjang' => 'sd']) }}" class="card" style="margin-bottom: 0; text-decoration: none; border-color: rgba(16, 185, 129, 0.4); background: rgba(16, 185, 129, 0.08); transition: transform 0.2s ease;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 0.8rem; color: #34d399; font-weight: 800; text-transform: uppercase;">SEKOLAH DASAR (SD)</span>
                    <div style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-top: 4px;">{{ $stats['sd_total'] }}</div>
                    <span style="font-size: 0.78rem; color: #a7f3d0; font-weight: 600;">Kelola Pendaftar SD →</span>
                </div>
                <span style="font-size: 2.2rem;">🎒</span>
            </div>
        </a>

        <!-- SMP -->
        <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smp']) }}" class="card" style="margin-bottom: 0; text-decoration: none; border-color: rgba(56, 189, 248, 0.4); background: rgba(56, 189, 248, 0.08); transition: transform 0.2s ease;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 0.8rem; color: #38bdf8; font-weight: 800; text-transform: uppercase;">MENENGAH PERTAMA (SMP)</span>
                    <div style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-top: 4px;">{{ $stats['smp_total'] }}</div>
                    <span style="font-size: 0.78rem; color: #bae6fd; font-weight: 600;">Kelola Pendaftar SMP →</span>
                </div>
                <span style="font-size: 2.2rem;">📚</span>
            </div>
        </a>

        <!-- SMK -->
        <a href="{{ route('admin.ppdb.index', ['jenjang' => 'smk']) }}" class="card" style="margin-bottom: 0; text-decoration: none; border-color: rgba(168, 85, 247, 0.4); background: rgba(168, 85, 247, 0.08); transition: transform 0.2s ease;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <span style="font-size: 0.8rem; color: #c084fc; font-weight: 800; text-transform: uppercase;">KEJURUAN (SMK)</span>
                    <div style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-top: 4px;">{{ $stats['smk_total'] }}</div>
                    <span style="font-size: 0.78rem; color: #e9d5ff; font-weight: 600;">Kelola Pendaftar SMK →</span>
                </div>
                <span style="font-size: 2.2rem;">💻</span>
            </div>
        </a>
    </div>
</div>

<!-- VISUAL BAR STATUS PROGRESS CHART -->
<div class="card" style="margin-bottom: 26px;">
    <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 12px;">
        📊 Komposisi Kelulusan Seleksi Calon Siswa
    </h3>
    @php
        $total = max($stats['total'], 1);
        $pctPending = round(($stats['pending'] / $total) * 100);
        $pctVerif = round(($stats['diverifikasi'] / $total) * 100);
        $pctDiterima = round(($stats['diterima'] / $total) * 100);
        $pctDitolak = round(($stats['ditolak'] / $total) * 100);
    @endphp
    <!-- Progress Bar Bertingkat -->
    <div style="height: 18px; width: 100%; border-radius: 999px; background: rgba(0,0,0,0.3); overflow: hidden; display: flex; margin-bottom: 14px; border: 1px solid var(--adm-border);">
        <div style="width: {{ $pctPending }}%; background: #fbbf24;" title="Pending: {{ $pctPending }}%"></div>
        <div style="width: {{ $pctVerif }}%; background: #38bdf8;" title="Diverifikasi: {{ $pctVerif }}%"></div>
        <div style="width: {{ $pctDiterima }}%; background: #34d399;" title="Diterima: {{ $pctDiterima }}%"></div>
        <div style="width: {{ $pctDitolak }}%; background: #ef4444;" title="Ditolak: {{ $pctDitolak }}%"></div>
    </div>
    <div style="display: flex; gap: 20px; flex-wrap: wrap; font-size: 0.82rem;">
        <span style="display: inline-flex; align-items: center; gap: 6px; color: #fbbf24;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #fbbf24;"></span> Pending ({{ $pctPending }}%)
        </span>
        <span style="display: inline-flex; align-items: center; gap: 6px; color: #38bdf8;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #38bdf8;"></span> Diverifikasi ({{ $pctVerif }}%)
        </span>
        <span style="display: inline-flex; align-items: center; gap: 6px; color: #34d399;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #34d399;"></span> Diterima ({{ $pctDiterima }}%)
        </span>
        <span style="display: inline-flex; align-items: center; gap: 6px; color: #f87171;">
            <span style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444;"></span> Ditolak ({{ $pctDitolak }}%)
        </span>
    </div>
</div>

<!-- ANTREAN VERIFIKASI PENDAFTAR PENDING -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div>
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #ffffff; margin-bottom: 2px;">
                🚨 Antrean Pendaftar Baru (Perlu Tindakan Verifikasi Segera)
            </h3>
            <span style="font-size: 0.8rem; color: var(--adm-text-muted);">Klik tombol "Verifikasi Sekarang" untuk memeriksa berkas dan menentukan status seleksi</span>
        </div>
        <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline btn-sm">Buka Semua Data →</a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No. Pendaftaran</th>
                    <th>Tingkat</th>
                    <th>Nama Calon Siswa</th>
                    <th>Orang Tua / HP</th>
                    <th>Berkas Diunggah</th>
                    <th>Waktu Pengajuan</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingRegistrations as $reg)
                <tr>
                    <td style="font-weight: 700; font-family: monospace; color: var(--adm-primary);">
                        {{ $reg->no_pendaftaran }}
                    </td>
                    <td>
                        @if($reg->jenjang === 'sd')
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.35); font-size: 0.75rem;">🎒 SD</span>
                        @elseif($reg->jenjang === 'smp')
                            <span class="badge" style="background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.35); font-size: 0.75rem;">📚 SMP</span>
                        @elseif($reg->jenjang === 'smk')
                            <span class="badge" style="background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.35); font-size: 0.75rem;">💻 SMK</span>
                        @else
                            <span class="badge">{{ strtoupper($reg->jenjang ?? '-') }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 700; color: #ffffff;">{{ $reg->full_name }}</div>
                        <div style="font-size: 0.78rem; color: var(--adm-text-muted);">
                            {{ $reg->gender == 'L' ? 'Ikhwan (L)' : 'Akhwat (P)' }} · {{ $reg->birth_date ? $reg->birth_date->format('d/m/Y') : '-' }}
                        </div>
                    </td>
                    <td>
                        <div style="color: #ffffff;">{{ $reg->parent_name }}</div>
                        <div style="font-size: 0.78rem; color: var(--adm-text-muted); font-family: monospace;">{{ $reg->parent_phone }}</div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $reg->documents->count() }} Berkas</span>
                    </td>
                    <td style="font-size: 0.8rem; color: var(--adm-text-muted);">
                        {{ $reg->created_at ? $reg->created_at->diffForHumans() : '-' }}
                    </td>
                    <td style="text-align: right;">
                        <a href="{{ route('admin.ppdb.show', $reg->id) }}" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 4px;">
                            <span>🔍</span> Verifikasi Sekarang
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #34d399; padding: 30px; font-weight: 700;">
                        ✨ Luar biasa! Seluruh antrean pendaftar telah selesai diverifikasi oleh panitia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
