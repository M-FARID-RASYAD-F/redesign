@extends('layouts.admin')

@section('title', 'CMS Dashboard - At-Tamam Edu')

@section('content')
<!-- HERO BANNER (ADMIN CMS) -->
<div class="dashboard-hero">
    <div class="hero-content">
        <div class="hero-badge-pill">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
            <span>CONTENT MANAGEMENT SYSTEM (CMS)</span>
        </div>
        <h1 class="hero-title">Pusat Publikasi Konten & Informasi Sekolah</h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
            <span>Tulis Berita Baru</span>
        </a>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 8px;">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
            <span>Kelola Semua Berita</span>
        </a>
    </div>
</div>

<!-- KARTU STATISTIK CMS -->
<div class="stats-grid">
    <!-- Berita Terbit -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">BERITA TAYANG</span>
            <div class="stat-card-icon icon-emerald">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #34d399;">{{ $stats['published_news'] }}</div>
        <div class="stat-card-sub">Dari {{ $stats['total_news'] }} artikel dibuat</div>
    </div>

    <!-- Foto Galeri -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">GALERI FOTO</span>
            <div class="stat-card-icon icon-cyan">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
            </div>
        </div>
        <div class="stat-card-val">{{ $stats['total_galleries'] }}</div>
        <div class="stat-card-sub">Dokumentasi kegiatan santri</div>
    </div>

    <!-- Pengumuman Aktif vs Expired -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">PENGUMUMAN</span>
            <div class="stat-card-icon icon-amber">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m3 11 18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #fbbf24;">{{ $stats['active_announcements'] }}</div>
        <div class="stat-card-sub">Aktif ({{ $stats['expired_announcements'] }} arsip)</div>
    </div>

    <!-- Agenda Sekolah -->
    <div class="card stat-card-item">
        <div class="stat-card-header">
            <span class="stat-card-label">AGENDA MENDATANG</span>
            <div class="stat-card-icon icon-purple">
                <svg width="19" height="19" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
        </div>
        <div class="stat-card-val" style="color: #c084fc;">{{ $stats['upcoming_agendas'] }}</div>
        <div class="stat-card-sub">Kegiatan terjadwal berikutnya</div>
    </div>
</div>

<!-- DUA KOLOM: ARTIKEL TERBARU & AGENDA / PENGUMUMAN -->
<div class="admin-grid-2col">
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
                                <div style="width: 44px; height: 44px; border-radius: 8px; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--adm-text-muted);">
                                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg>
                                </div>
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
                            <a href="{{ route('admin.news.edit', $n->id) }}" class="btn btn-outline btn-sm" style="display: inline-flex; align-items: center; gap: 5px;">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                <span>Edit</span>
                            </a>
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
        <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span>Agenda Mendatang</span>
        </h3>
        
        <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 20px;">
            @forelse($upcomingAgendas as $ag)
            <div style="padding: 12px; background: rgba(0, 0, 0, 0.25); border: 1px solid var(--adm-border); border-radius: 10px;">
                <div style="font-size: 0.76rem; color: #38bdf8; font-weight: 800; text-transform: uppercase; display: flex; align-items: center; gap: 6px;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/></svg>
                    <span>{{ \Carbon\Carbon::parse($ag->date)->translatedFormat('l, d F Y') }}</span>
                </div>
                <div style="font-size: 0.9rem; font-weight: 700; color: #ffffff; margin-top: 4px;">{{ $ag->title }}</div>
                @if($ag->location)
                <div style="font-size: 0.78rem; color: var(--adm-text-muted); margin-top: 4px; display: flex; align-items: center; gap: 5px;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span>{{ $ag->location }}</span>
                </div>
                @endif
            </div>
            @empty
            <div style="font-size: 0.85rem; color: var(--adm-text-muted); text-align: center; padding: 12px;">Tidak ada agenda terdekat.</div>
            @endforelse
        </div>

        <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="m3 11 18-5v12L3 13v-2z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>
            <span>Pengumuman Aktif</span>
        </h3>
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
