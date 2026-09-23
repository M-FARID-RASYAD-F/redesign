@extends('layouts.admin')

@section('title', 'Tambah Buku Baru - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Tambah Buku Baru</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.books.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Koleksi Buku</a></p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Baris 1: Judul Buku --}}
        <div class="form-group">
            <label class="form-label" for="title">Judul Buku *</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Contoh: Belajar Pemrograman Web Modern dengan Laravel" required value="{{ old('title') }}">
            @error('title')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Baris 2: Kategori & Rak --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="category_id">Kategori Buku *</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="rack_id">Rak Penyimpanan</label>
                <select id="rack_id" name="rack_id" class="form-control">
                    <option value="">-- Pilih Rak (Opsional) --</option>
                    @foreach($racks as $r)
                        <option value="{{ $r->id }}" {{ old('rack_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->code }} - {{ $r->name }}
                        </option>
                    @endforeach
                </select>
                @error('rack_id')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris 3: Penulis & Penerbit --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="author">Penulis / Pengarang *</label>
                <input type="text" id="author" name="author" class="form-control" placeholder="Contoh: Dr. Ir. Wahyu Ramadhan" required value="{{ old('author') }}">
                @error('author')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="publisher">Penerbit</label>
                <input type="text" id="publisher" name="publisher" class="form-control" placeholder="Contoh: Penerbit Informatika" value="{{ old('publisher') }}">
                @error('publisher')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris 4: ISBN, Tahun Terbit, Jumlah Halaman --}}
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="isbn">Nomor ISBN</label>
                <input type="text" id="isbn" name="isbn" class="form-control" placeholder="Contoh: 978-602-04-1234-5" value="{{ old('isbn') }}">
                @error('isbn')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="publication_year">Tahun Terbit</label>
                <input type="number" id="publication_year" name="publication_year" class="form-control" placeholder="YYYY" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('publication_year', date('Y')) }}">
                @error('publication_year')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="pages">Halaman</label>
                <input type="number" id="pages" name="pages" class="form-control" placeholder="Contoh: 320" min="1" value="{{ old('pages') }}">
                @error('pages')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris 5: Stok & Status --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="stock">Total Stok Buku *</label>
                <input type="number" id="stock" name="stock" class="form-control" min="0" required value="{{ old('stock', 5) }}">
                <span style="font-size: 0.75rem; color: var(--text-muted);">Jumlah eksemplar fisik yang dimiliki perpustakaan.</span>
                @error('stock')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status Buku *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="tersedia" {{ old('status', 'tersedia') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ old('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="rusak" {{ old('status') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
                @error('status')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris 6: Cover Image File / URL --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="cover_file">Upload File Cover (Gambar)</label>
                <input type="file" id="cover_file" name="cover_file" class="form-control" accept="image/jpeg,image/png,image/webp">
                <span style="font-size: 0.75rem; color: var(--text-muted);">Maks. 3MB (JPG, PNG, WebP)</span>
                @error('cover_file')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="cover_image">Atau Masukkan URL Cover</label>
                <input type="text" id="cover_image" name="cover_image" class="form-control" placeholder="https://..." value="{{ old('cover_image') }}">
                <span style="font-size: 0.75rem; color: var(--text-muted);">Bisa menggunakan URL gambar dari internet.</span>
                @error('cover_image')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris 7: Sinopsis / Deskripsi --}}
        <div class="form-group">
            <label class="form-label" for="description">Sinopsis & Ringkasan Buku</label>
            <textarea id="description" name="description" class="form-control" rows="5" placeholder="Tulis sinopsis cerita, daftar bab atau ringkasan topik buku...">{{ old('description') }}</textarea>
            @error('description')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Simpan Buku Baru</span>
            </button>
            <a href="{{ route('admin.books.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
