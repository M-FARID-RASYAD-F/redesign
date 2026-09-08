@extends('layouts.admin')

@section('title', 'Kelola Agenda Kegiatan - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Agenda Kegiatan</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola jadwal kegiatan sekolah, rapat akademik, dan event penting.</p>
    </div>
    @if(auth()->user()->canManageAnnouncements())
    <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary">
        <span>➕</span> Tambah Agenda Baru
    </a>
    @endif
</div>

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
    ✅ {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Kegiatan / Agenda</th>
                    <th>Tanggal Pelaksanaan</th>
                    <th>Lokasi Kegiatan</th>
                    <th>Penanggung Jawab / Dibuat Oleh</th>
                    @if(auth()->user()->canManageAnnouncements())
                    <th style="width: 150px; text-align: right;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($agendas as $ag)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #fff; margin-bottom: 2px;">{{ $ag->title }}</div>
                        <div style="color: var(--text-muted); font-size: 0.82rem;">{{ Str::limit($ag->description, 80) }}</div>
                    </td>
                    <td>
                        <span class="badge badge-info" style="font-family: monospace; font-size: 0.85rem;">
                            📅 {{ $ag->date ? $ag->date->format('d M Y') : '-' }}
                        </span>
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.85rem;">
                        📍 {{ $ag->location ?? 'Kampus Utama' }}
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.85rem;">
                        {{ $ag->creator ? $ag->creator->name : '-' }}
                    </td>
                    @if(auth()->user()->canManageAnnouncements())
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('admin.agenda.edit', $ag->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary);">Edit</a>
                            
                            <form action="{{ route('admin.agenda.delete', $ag->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Apakah Anda yakin ingin menghapus agenda <strong>{{ $ag->title }}</strong>?">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete-trigger">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada jadwal agenda kegiatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
