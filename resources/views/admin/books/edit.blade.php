@extends('layouts.admin')

@section('title', 'Edit Buku - At-Tamam Edu')

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Edit Buku</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.books.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Koleksi Buku</a></p>
    </div>
</div>

<div class="card" style="max-width: 800px;">
    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Baris 1: Judul Buku --}}
        <div class="form-group">
            <label class="form-label" for="title">Judul Buku *</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Contoh: Belajar Pemrograman Web Modern dengan Laravel" required value="{{ old('title', $book->title) }}">
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
                        <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
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
                        <option value="{{ $r->id }}" {{ old('rack_id', $book->rack_id) == $r->id ? 'selected' : '' }}>
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
                <input type="text" id="author" name="author" class="form-control" placeholder="Contoh: Dr. Ir. Wahyu Ramadhan" required value="{{ old('author', $book->author) }}">
                @error('author')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="publisher">Penerbit</label>
                <input type="text" id="publisher" name="publisher" class="form-control" placeholder="Contoh: Penerbit Informatika" value="{{ old('publisher', $book->publisher) }}">
                @error('publisher')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris 4: ISBN, Tahun Terbit, Jumlah Halaman --}}
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="isbn">Nomor ISBN</label>
                <input type="text" id="isbn" name="isbn" class="form-control" placeholder="Contoh: 978-602-04-1234-5" value="{{ old('isbn', $book->isbn) }}">
                @error('isbn')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="publication_year">Tahun Terbit</label>
                <input type="number" id="publication_year" name="publication_year" class="form-control" placeholder="YYYY" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('publication_year', $book->publication_year) }}">
                @error('publication_year')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="pages">Halaman</label>
                <input type="number" id="pages" name="pages" class="form-control" placeholder="Contoh: 320" min="1" value="{{ old('pages', $book->pages) }}">
                @error('pages')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris 5: Stok, Stok Tersedia, dan Status --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="stock">Total Stok Buku *</label>
                <input type="number" id="stock" name="stock" class="form-control" min="0" required value="{{ old('stock', $book->stock) }}">
                <span style="font-size: 0.75rem; color: var(--text-muted);">Total unit fisik di perpustakaan.</span>
                @error('stock')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="available_stock">Stok Tersedia *</label>
                <input type="number" id="available_stock" name="available_stock" class="form-control" min="0" max="{{ old('stock', $book->stock) }}" required value="{{ old('available_stock', $book->available_stock) }}">
                <span style="font-size: 0.75rem; color: var(--text-muted);">Unit yang saat ini siap dipinjam.</span>
                @error('available_stock')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="status">Status Buku *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="tersedia" {{ old('status', $book->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipinjam" {{ old('status', $book->status) === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="rusak" {{ old('status', $book->status) === 'rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
                @error('status')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Preview Cover Saat Ini --}}
        @if($book->cover_image)
            <div style="margin-bottom: 16px; padding: 12px; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; display: flex; align-items: center; gap: 16px;">
                <img src="{{ $book->cover_url }}" alt="Cover {{ $book->title }}" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;">
                <div>
                    <div style="font-size: 0.85rem; font-weight: 600; color: #ffffff;">Cover Aktif</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); word-break: break-all;">{{ $book->cover_image }}</div>
                    <label style="display: inline-flex; align-items: center; gap: 6px; margin-top: 6px; font-size: 0.8rem; color: #ef4444; cursor: pointer;">
                        <input type="checkbox" name="remove_cover" value="1">
                        <span>Hapus cover saat ini</span>
                    </label>
                </div>
            </div>
        @endif

        {{-- Baris 6: Cover Image File / URL Baru --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="form-group">
                <label class="form-label" for="cover_file">Ganti Cover (Upload File)</label>
                <input type="file" id="cover_file" name="cover_file" class="form-control" accept="image/jpeg,image/png,image/webp">
                <span style="font-size: 0.75rem; color: var(--text-muted);">Maks. 3MB (JPG, PNG, WebP)</span>
                @error('cover_file')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="cover_image">Atau Ubah URL Cover</label>
                <input type="text" id="cover_image" name="cover_image" class="form-control" placeholder="https://..." value="{{ old('cover_image', str_starts_with($book->cover_image ?? '', 'http') ? $book->cover_image : '') }}">
                <span style="font-size: 0.75rem; color: var(--text-muted);">Gunakan URL gambar publik jika tidak upload file.</span>
                @error('cover_image')
                    <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Baris 7: Sinopsis / Deskripsi --}}
        <div class="form-group">
            <label class="form-label" for="description">Sinopsis & Ringkasan Buku</label>
            <textarea id="description" name="description" class="form-control" rows="5" placeholder="Tulis sinopsis cerita, daftar bab atau ringkasan topik buku...">{{ old('description', $book->description) }}</textarea>
            @error('description')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 8px;">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span>Simpan Perubahan</span>
            </button>
            <a href="{{ route('admin.books.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection
