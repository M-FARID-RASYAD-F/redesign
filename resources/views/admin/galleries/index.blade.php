@extends('layouts.admin')

@section('title', 'Kelola Galeri Foto - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Galeri Foto</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Galeri dokumentasi kegiatan, fasilitas, dan momen prestasi sekolah.</p>
    </div>
    @if(auth()->user()->canManageCms())
    <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
        <span>➕</span> Unggah Foto Baru
    </a>
    @endif
</div>

@if(session('success'))
<div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #10b981; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
    ✅ {{ session('success') }}
</div>
@endif

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
    @forelse($galleries as $gal)
    <div class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
        <div style="height: 180px; width: 100%; overflow: hidden; background: #000; position: relative;">
            <img src="{{ str_starts_with($gal->image_path, 'http') ? $gal->image_path : asset($gal->image_path) }}" 
                 alt="{{ $gal->title }}" 
                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s;"
                 onerror="this.src='https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?w=600'">
            <span class="badge badge-info" style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
                {{ $gal->category ?? 'Kegiatan' }}
            </span>
        </div>
        <div style="padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h4 style="font-size: 1rem; font-weight: 600; color: #fff; margin-bottom: 6px;">{{ $gal->title }}</h4>
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 12px;">
                    Diupload: {{ $gal->created_at ? $gal->created_at->format('d M Y') : '-' }} · Oleh: {{ $gal->uploader ? $gal->uploader->name : 'Admin' }}
                </div>
            </div>

            @if(auth()->user()->canManageCms())
            <div style="border-top: 1px solid var(--border); padding-top: 12px; display: flex; justify-content: flex-end;">
                <form action="{{ route('admin.galleries.delete', $gal->id) }}" method="POST" class="form-delete-confirm" data-delete-message="Hapus foto {{ $gal->title }} dari galeri?">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm btn-delete-trigger">🗑️ Hapus Foto</button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="card" style="grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 40px;">
        Belum ada foto yang diunggah ke galeri sekolah.
    </div>
    @endforelse
</div>
@endsection
