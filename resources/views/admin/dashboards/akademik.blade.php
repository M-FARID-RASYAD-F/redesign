@extends('layouts.admin')

@section('title', 'Akademik Dashboard - At-Tamam Edu')

@section('content')
<!-- HERO BANNER (EDITOR AKADEMIK) -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <span>👨‍🏫</span>
            <span>MANAJEMEN AKADEMIK & KURIKULUM</span>
        </div>
        <h1 class="hero-title">Pusat Data Pendidik & Program Kejuruan</h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <span>➕</span> Tambah Guru / Staf
        </a>
        <a href="{{ route('admin.majors.create') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <span>💻</span> Tambah Jurusan
        </a>
    </div>
</div>

<!-- KARTU STATISTIK AKADEMIK -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 26px;">
    <!-- Total Guru & Staf -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">TOTAL DEWAN GURU</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0, 180, 216, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">👨‍🏫</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #ffffff;">{{ $stats['total_teachers'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Pendidik & staf terdaftar</div>
    </div>

    <!-- Guru Aktif Mengajar -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">GURU AKTIF</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">✅</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #34d399;">{{ $stats['active_teachers'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Aktif dalam proses KBM</div>
    </div>

    <!-- Guru Nonaktif -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">NONAKTIF / CUTI</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(239, 68, 68, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">⏸️</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #f87171;">{{ $stats['inactive_teachers'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Sedang cuti / tugas luar</div>
    </div>

    <!-- Program Jurusan -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">PROGRAM JURUSAN</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(168, 85, 247, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">💻</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #c084fc;">{{ $stats['total_majors'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Konsentrasi keahlian santri</div>
    </div>
</div>

<!-- DUA KOLOM: GURU TERBARU & DAFTAR JURUSAN -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
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
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
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
            <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff;">💻 Program Jurusan</h3>
            <a href="{{ route('admin.majors.index') }}" class="btn btn-outline btn-sm">Kelola →</a>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px;">
            @forelse($majors as $m)
            <div style="padding: 14px; background: rgba(0, 0, 0, 0.25); border: 1px solid var(--adm-border); border-radius: 10px; display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;">
                <div style="display: flex; gap: 12px; align-items: flex-start;">
                    <div style="width: 38px; height: 38px; border-radius: 8px; background: rgba(0, 180, 216, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;">
                        {{ $m->icon ?? '💻' }}
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
                <a href="{{ route('admin.majors.edit', $m->id) }}" class="btn btn-outline btn-sm" style="padding: 4px 8px; font-size: 0.75rem; flex-shrink: 0;">✏️</a>
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
