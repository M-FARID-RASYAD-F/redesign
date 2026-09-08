@extends('layouts.admin')

@section('title', 'CMS Dashboard - At-Tamam Edu')

@section('content')
<!-- HERO BANNER (ADMIN CMS) -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <span>📰</span>
            <span>CONTENT MANAGEMENT SYSTEM (CMS)</span>
        </div>
        <h1 class="hero-title">Pusat Publikasi Konten & Informasi Sekolah</h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <span>✍️</span> Tulis Berita Baru
        </a>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <span>📰</span> Kelola Semua Berita
        </a>
    </div>
</div>

<!-- KARTU STATISTIK CMS -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 26px;">
    <!-- Berita Terbit -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">BERITA TAYANG</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📰</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #34d399;">{{ $stats['published_news'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Dari total {{ $stats['total_news'] }} artikel dibuat</div>
    </div>

    <!-- Foto Galeri -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">GALERI FOTO</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(0, 180, 216, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">🖼️</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #ffffff;">{{ $stats['total_galleries'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Dokumentasi kegiatan santri</div>
    </div>

    <!-- Pengumuman Aktif vs Expired -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">PENGUMUMAN</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(245, 158, 11, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📢</div>
        </div>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 2rem; font-weight: 800; color: #fbbf24;">{{ $stats['active_announcements'] }}</span>
            <span style="font-size: 0.85rem; color: var(--adm-text-muted);">aktif · {{ $stats['expired_announcements'] }} arsip</span>
        </div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Info siaran publik & internal</div>
    </div>

    <!-- Agenda Sekolah -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
            <span style="font-size: 0.85rem; color: var(--adm-text-muted); font-weight: 700;">AGENDA MENDATANG</span>
            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(168, 85, 247, 0.15); display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">📅</div>
        </div>
        <div style="font-size: 2rem; font-weight: 800; color: #c084fc;">{{ $stats['upcoming_agendas'] }}</div>
        <div style="font-size: 0.8rem; color: var(--adm-text-muted); margin-top: 4px;">Kegiatan terjadwal berikutnya</div>
    </div>
</div>

<!-- DUA KOLOM: ARTIKEL TERBARU & AGENDA / PENGUMUMAN -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Kolom 1: Berita Terbaru -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="font-size: 1.1rem; font-weight: 800; color: #ffffff;">Berita & Publikasi Terbaru</h3>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline btn-sm">Lihat Semua Berita →</a>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Thumbnail & Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentNews as $n)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                @if($n->thumbnail)
                                <img src="{{ $n->thumbnail }}" alt="" style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
                                @else
                                <div style="width: 44px; height: 44px; border-radius: 8px; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">📰</div>
                                @endif
                                <div style="min-width: 0;">
                                    <div style="font-weight: 700; color: #ffffff; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $n->title }}</div>
                                    <div style="font-size: 0.78rem; color: var(--adm-text-muted);">{{ $n->created_at->format('d M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $n->category ? $n->category->name : 'Umum' }}</span>
                        </td>
                        <td>
                            @if($n->published_at && $n->published_at <= now())
                                <span class="badge badge-success">Tayang</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.news.edit', $n->id) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--adm-text-muted); padding: 24px;">Belum ada berita terbit.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kolom 2: Agenda & Pengumuman Aktif -->
    <div class="card">
        <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 14px;">📅 Agenda Mendatang</h3>
        
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;">
            @forelse($upcomingAgendas as $ag)
            <div style="padding: 12px; background: rgba(0, 0, 0, 0.25); border: 1px solid var(--adm-border); border-radius: 10px;">
                <div style="font-size: 0.76rem; color: #38bdf8; font-weight: 800; text-transform: uppercase;">
                    🗓️ {{ \Carbon\Carbon::parse($ag->date)->translatedFormat('l, d F Y') }}
                </div>
                <div style="font-size: 0.9rem; font-weight: 700; color: #ffffff; margin-top: 2px;">{{ $ag->title }}</div>
                @if($ag->location)
                <div style="font-size: 0.78rem; color: var(--adm-text-muted); margin-top: 2px;">📍 {{ $ag->location }}</div>
                @endif
            </div>
            @empty
            <div style="font-size: 0.85rem; color: var(--adm-text-muted); text-align: center; padding: 12px;">Tidak ada agenda terdekat.</div>
            @endforelse
        </div>

        <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 12px;">📢 Pengumuman Aktif</h3>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            @forelse($recentAnnouncements as $ann)
            <div style="padding: 10px 12px; background: rgba(0, 0, 0, 0.25); border-left: 3px solid #fbbf24; border-radius: 0 8px 8px 0;">
                <div style="font-size: 0.88rem; font-weight: 700; color: #ffffff;">{{ $ann->title }}</div>
                <div style="font-size: 0.76rem; color: var(--adm-text-muted); margin-top: 2px;">
                    Mulai: {{ \Carbon\Carbon::parse($ann->start_date)->format('d/m/Y') }} · {{ $ann->is_archived ? 'Arsip' : 'Aktif' }}
                </div>
            </div>
            @empty
            <div style="font-size: 0.85rem; color: var(--adm-text-muted); text-align: center; padding: 12px;">Tidak ada pengumuman.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
