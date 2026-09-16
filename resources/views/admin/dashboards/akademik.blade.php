@extends('layouts.admin')

@section('title', 'Akademik Dashboard - At-Tamam Edu')

@section('content')
<!-- HERO BANNER (EDITOR AKADEMIK) -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            <span>MANAJEMEN AKADEMIK & KURIKULUM</span>
        </div>
        <h1 class="hero-title">Pusat Data Pendidik & Program Kejuruan</h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            <span>Tambah Guru / Staf</span>
        </a>
        <a href="{{ route('admin.majors.create') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            <span>Tambah Jurusan</span>
        </a>
    </div>
</div>

<!-- KARTU STATISTIK AKADEMIK -->
<div class="stats-grid">
    <!-- Total Guru & Staf -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">TOTAL DEWAN GURU</span>
            <div class="stat-card-icon icon-cyan">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
        </div>
        <div class="stat-card-val">{{ $stats['total_teachers'] }}</div>
        <div class="stat-card-sub">Pendidik & staf terdaftar</div>
    </div>

    <!-- Guru Aktif Mengajar -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">GURU AKTIF</span>
            <div class="stat-card-icon icon-emerald">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #34d399;">{{ $stats['active_teachers'] }}</div>
        <div class="stat-card-sub">Aktif dalam proses KBM</div>
    </div>

    <!-- Guru Nonaktif -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">NONAKTIF / CUTI</span>
            <div class="stat-card-icon icon-rose">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="10" y1="15" x2="10" y2="9"/><line x1="14" y1="15" x2="14" y2="9"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #f87171;">{{ $stats['inactive_teachers'] }}</div>
        <div class="stat-card-sub">Sedang cuti / tugas luar</div>
    </div>

    <!-- Program Jurusan -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">PROGRAM JURUSAN</span>
            <div class="stat-card-icon icon-purple">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #c084fc;">{{ $stats['total_majors'] }}</div>
        <div class="stat-card-sub">Konsentrasi keahlian santri</div>
    </div>
</div>

<!-- DUA KOLOM: GURU TERBARU & DAFTAR JURUSAN -->
<div class="admin-grid-2col">
    <!-- Kolom 1: Data Guru & Staf Terbaru -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #ffffff;">Dewan Guru & Staf Terbaru</h3>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline btn-sm">Kelola Semua Guru →</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Foto & Nama</th>
                        <th>NIP</th>
                        <th>Posisi / Bidang</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                @if($teacher->photo)
                                    <img src="{{ asset('storage/' . $teacher->photo) }}" alt="" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; flex-shrink: 0; border: 2px solid var(--adm-border);">
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 50%; background: rgba(0, 180, 216, 0.2); color: #38bdf8; display: flex; align-items: center; justify-content: center; font-weight: 700; flex-shrink: 0;">
                                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div style="min-width: 0;">
                                    <div style="font-weight: 700; color: #ffffff; white-space: nowrap;">{{ $teacher->name }}</div>
                                    <div style="font-size: 0.78rem; color: var(--adm-text-muted);">{{ $teacher->subject ?? 'Staf Umum' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; color: var(--adm-text-sub);">{{ $teacher->nip ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $teacher->position }}</span>
                        </td>
                        <td>
                            @if($teacher->status === 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-warning">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 5px;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                <span>Edit</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--adm-text-muted); padding: 24px;">Belum ada data guru/staf terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kolom 2: Program Jurusan & Kurikulum -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                <span>Program Jurusan</span>
            </h3>
            <a href="{{ route('admin.majors.index') }}" class="btn btn-outline btn-sm">Kelola →</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            @forelse($majors as $m)
            <div style="padding: 14px; background: rgba(0, 0, 0, 0.25); border: 1px solid var(--adm-border); border-radius: 10px; display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(0, 180, 216, 0.15); color: #38bdf8; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        @if($m->icon)
                            {{ $m->icon }}
                        @else
                            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        @endif
                    </div>
                    <div>
                        <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">{{ $m->name }}</div>
                        <div style="font-size: 0.76rem; color: #38bdf8; font-family: 'JetBrains Mono', monospace;">/{{ $m->slug }}</div>
                        @if($m->description)
                            <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ Str::limit($m->description, 80) }}
                            </div>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.majors.edit', $m->id) }}" class="btn btn-outline btn-sm" style="padding: 6px 8px; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center;" title="Edit Jurusan">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                </a>
            </div>
            @empty
            <div style="font-size: 0.85rem; color: var(--adm-text-muted); text-align: center; padding: 20px;">
                Belum ada data jurusan.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
