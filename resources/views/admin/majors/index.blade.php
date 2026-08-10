@extends('layouts.admin')

@section('title', 'Kelola Jurusan - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Kelola Jurusan</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kelola data program keahlian/jurusan yang tersedia di sekolah.</p>
    </div>
    <a href="{{ route('admin.majors.create') }}" class="btn btn-primary">
        <span>➕</span> Tambah Jurusan Baru
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">Ikon</th>
                    <th>Nama Jurusan</th>
                    <th>Deskripsi Ringkas</th>
                    <th style="width: 150px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($majors as $major)
                <tr>
                    <td style="font-size: 1.5rem; text-align: center;">
                        {{ $major->icon ?? '💻' }}
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #0f172a; margin-bottom: 2px;">{{ $major->name }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">Slug: {{ $major->slug }}</div>
                    </td>
                    <td style="line-height: 1.4; color: var(--text-muted); font-size: 0.85rem;">
                        {{ Str::limit($major->description, 100) }}
                    </td>
                    <td style="text-align: right;">
                        <div style="display: inline-flex; gap: 8px;">
                            <a href="{{ route('admin.majors.edit', $major->id) }}" class="btn btn-outline btn-sm" style="color: var(--primary); border-color: var(--primary);">Edit</a>
                            
                            <form action="{{ route('admin.majors.delete', $major->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada data jurusan keahlian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
