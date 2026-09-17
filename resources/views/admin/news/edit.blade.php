@extends('layouts.admin')

@section('title', 'Edit Berita - At-Tamam Edu')

@push('styles')
<!-- Quill Rich Text Editor CSS -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<style>
    /* Custom Styling untuk Dropzone & Live Preview */
    .dropzone-box {
        border: 2px dashed var(--adm-border, rgba(0, 180, 216, 0.4));
        background: rgba(0, 21, 41, 0.4);
        border-radius: 14px;
        padding: 24px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .dropzone-box:hover, .dropzone-box.dragover {
        border-color: var(--adm-primary, #00B4D8);
        background: rgba(0, 180, 216, 0.08);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0, 180, 216, 0.15);
    }
    .dropzone-icon {
        width: 44px;
        height: 44px;
        color: var(--adm-primary, #00B4D8);
        margin-bottom: 10px;
    }
    .dropzone-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--adm-text-title, #ffffff);
        margin-bottom: 4px;
    }
    .dropzone-subtitle {
        font-size: 0.78rem;
        color: var(--adm-text-muted, #94a3b8);
    }
    
    /* Live Preview Card */
    .thumbnail-preview-container {
        display: none;
        margin-top: 14px;
        background: rgba(0, 0, 0, 0.25);
        border: 1px solid var(--adm-border, rgba(0, 180, 216, 0.3));
        border-radius: 12px;
        padding: 14px;
        align-items: center;
        gap: 16px;
    }
    .thumbnail-preview-container.active {
        display: flex;
    }
    .preview-img {
        width: 120px;
        height: 75px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--adm-border, rgba(0, 180, 216, 0.3));
        flex-shrink: 0;
        background: #000;
    }
    .preview-meta {
        flex: 1;
        min-width: 0;
        text-align: left;
    }
    .preview-filename {
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--adm-text-main, #ffffff);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .preview-size {
        font-size: 0.75rem;
        color: var(--adm-text-muted, #94a3b8);
        margin-top: 2px;
    }
    .btn-remove-thumb {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.35);
        color: #f87171;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-remove-thumb:hover {
        background: rgba(239, 68, 68, 0.25);
    }

    /* Thumbnail Input Switcher */
    .thumb-switch-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 12px;
    }
    .thumb-switch-btn {
        background: transparent;
        border: 1px solid var(--adm-border, rgba(0, 180, 216, 0.3));
        color: var(--adm-text-muted, #cbd5e1);
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .thumb-switch-btn.active {
        background: var(--adm-primary, #00B4D8);
        color: #001529;
        border-color: var(--adm-primary, #00B4D8);
        font-weight: 700;
    }

    /* Quill Editor Theme Overrides */
    .ql-toolbar.ql-snow {
        background: rgba(0, 21, 41, 0.6) !important;
        border-color: var(--adm-border, rgba(0, 180, 216, 0.3)) !important;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .ql-toolbar .ql-stroke {
        stroke: var(--adm-text-muted, #cbd5e1) !important;
    }
    .ql-toolbar .ql-fill {
        fill: var(--adm-text-muted, #cbd5e1) !important;
    }
    .ql-toolbar .ql-picker {
        color: var(--adm-text-muted, #cbd5e1) !important;
    }
    .ql-toolbar button:hover .ql-stroke,
    .ql-toolbar button.ql-active .ql-stroke {
        stroke: var(--adm-primary, #00B4D8) !important;
    }
    .ql-toolbar button:hover .ql-fill,
    .ql-toolbar button.ql-active .ql-fill {
        fill: var(--adm-primary, #00B4D8) !important;
    }
    .ql-container.ql-snow {
        border-color: var(--adm-border, rgba(0, 180, 216, 0.3)) !important;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        font-family: inherit !important;
        font-size: 0.95rem !important;
        background: rgba(0, 15, 30, 0.4) !important;
        color: var(--adm-text-main, #ffffff) !important;
        min-height: 280px;
    }
    .ql-editor {
        min-height: 280px;
        line-height: 1.7;
    }
    .ql-editor.ql-blank::before {
        color: var(--adm-text-muted, #64748b) !important;
        font-style: normal;
    }
    [data-theme="light"] .ql-toolbar.ql-snow {
        background: #f8fafc !important;
    }
    [data-theme="light"] .ql-container.ql-snow {
        background: #ffffff !important;
        color: #0f172a !important;
    }
</style>
@endpush

@section('content')
<div class="header">
    <div>
        <h1 class="header-title">Edit Berita</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 4px;">Kembali ke <a href="{{ route('admin.news.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Daftar Berita</a></p>
    </div>
</div>

<div class="card" style="max-width: 850px;">
    <form id="newsEditForm" action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="title">Judul Berita *</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Masukkan judul berita" required value="{{ old('title', $news->title) }}">
            @error('title')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="category_id">Kategori Berita *</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Thumbnail Section (Upload Drag-and-Drop & URL Manual & Existing Preview) -->
        <div class="form-group">
            <label class="form-label">Gambar Thumbnail Berita</label>
            
            <input type="hidden" name="remove_thumbnail" id="remove_thumbnail" value="0">

            <div class="thumb-switch-bar">
                <button type="button" class="thumb-switch-btn active" id="btnModeUpload">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    Unggah dari PC / HP
                </button>
                <button type="button" class="thumb-switch-btn" id="btnModeUrl">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                    Gunakan URL Gambar
                </button>
            </div>

            <!-- Mode 1: Drag & Drop File Upload -->
            <div id="uploadPane">
                <input type="file" id="thumbnail_file" name="thumbnail_file" accept="image/jpeg,image/png,image/webp,image/jpg,image/gif" style="display: none;">
                <div class="dropzone-box" id="dropzoneBox">
                    <svg class="dropzone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path>
                        <path d="M12 12v9"></path>
                        <path d="m16 16-4-4-4 4"></path>
                    </svg>
                    <div class="dropzone-title">Tarik & Lepas file gambar di sini, atau <span style="color: var(--adm-primary, #00B4D8); text-decoration: underline;">Ganti File</span></div>
                    <div class="dropzone-subtitle">Mendukung format JPG, PNG, atau WebP (Maksimal 5MB)</div>
                </div>
            </div>

            <!-- Mode 2: Manual URL Input -->
            <div id="urlPane" style="display: none;">
                <input type="text" id="thumbnail" name="thumbnail" class="form-control" placeholder="Contoh: https://images.unsplash.com/... atau https://picsum.photos/800/400" value="{{ old('thumbnail', $news->thumbnail) }}">
                <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 4px;">Tempel link gambar dari web publik. Pratinjau akan langsung ditampilkan.</span>
            </div>

            <!-- Live Preview Card Instan -->
            @php
                $initialThumbnail = old('thumbnail', $news->thumbnail);
                $initialSrc = '';
                if (!empty($initialThumbnail)) {
                    $initialSrc = Str::startsWith($initialThumbnail, 'http') ? $initialThumbnail : asset($initialThumbnail);
                }
            @endphp
            <div class="thumbnail-preview-container {{ !empty($initialSrc) ? 'active' : '' }}" id="previewContainer">
                <img src="{{ $initialSrc }}" alt="Pratinjau Thumbnail" id="previewImg" class="preview-img">
                <div class="preview-meta">
                    <div class="preview-filename" id="previewFilename">{{ !empty($initialThumbnail) ? basename($initialThumbnail) : 'Thumbnail Berita' }}</div>
                    <div class="preview-size" id="previewSize">{{ Str::startsWith($initialThumbnail, 'http') ? 'URL Eksternal' : 'Gambar Aktif' }}</div>
                </div>
                <button type="button" class="btn-remove-thumb" id="btnRemoveThumb">
                    Hapus Gambar
                </button>
            </div>

            @error('thumbnail_file')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
            @error('thumbnail')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="published_at">Tanggal Publikasi</label>
            <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
            <span style="font-size: 0.75rem; color: var(--text-muted);">Biarkan kosong untuk menjadikannya draft, atau isi tanggal agar otomatis terbit.</span>
            @error('published_at')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Rich-Text Editor (Quill) -->
        <div class="form-group">
            <label class="form-label" for="content">Isi Konten Berita *</label>
            <div id="quillEditor"></div>
            <textarea id="content" name="content" style="display: none;" required>{{ old('content', $news->content) }}</textarea>
            <span style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-top: 6px;">Gunakan tombol pemformatan di atas untuk mengatur heading, daftar poin, kutipan, dan tautan.</span>
            @error('content')
                <div style="color: var(--danger); font-size: 0.8rem; margin-top: 4px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 28px;">
            <button type="submit" class="btn btn-primary" id="btnSubmitNews">Simpan Perubahan</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-outline">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Quill Rich Text Editor JS -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Inisialisasi Quill Rich-Text Editor
    const quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'Tuliskan isi artikel dan warta berita selengkapnya di sini...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['blockquote', 'code-block'],
                ['link'],
                ['clean']
            ]
        }
    });

    // Isi konten berita yang tersimpan
    const contentInput = document.getElementById('content');
    if (contentInput.value) {
        quill.root.innerHTML = contentInput.value;
    }

    // Sinkronisasi Quill ke input hidden saat form submit
    const newsForm = document.getElementById('newsEditForm');
    newsForm.addEventListener('submit', function (e) {
        const html = quill.root.innerHTML;
        const text = quill.getText().trim();
        if (!text && !html.includes('<img')) {
            alert('Isi konten berita tidak boleh kosong!');
            e.preventDefault();
            return false;
        }
        contentInput.value = html;
    });

    // 2. Tab Switcher Upload File vs URL Manual
    const btnModeUpload = document.getElementById('btnModeUpload');
    const btnModeUrl = document.getElementById('btnModeUrl');
    const uploadPane = document.getElementById('uploadPane');
    const urlPane = document.getElementById('urlPane');

    btnModeUpload.addEventListener('click', function () {
        btnModeUpload.classList.add('active');
        btnModeUrl.classList.remove('active');
        uploadPane.style.display = 'block';
        urlPane.style.display = 'none';
    });

    btnModeUrl.addEventListener('click', function () {
        btnModeUrl.classList.add('active');
        btnModeUpload.classList.remove('active');
        urlPane.style.display = 'block';
        uploadPane.style.display = 'none';
    });

    // 3. Drag and Drop & Live Preview Logic
    const dropzone = document.getElementById('dropzoneBox');
    const fileInput = document.getElementById('thumbnail_file');
    const urlInput = document.getElementById('thumbnail');
    const previewContainer = document.getElementById('previewContainer');
    const previewImg = document.getElementById('previewImg');
    const previewFilename = document.getElementById('previewFilename');
    const previewSize = document.getElementById('previewSize');
    const btnRemoveThumb = document.getElementById('btnRemoveThumb');
    const removeThumbnailInput = document.getElementById('remove_thumbnail');

    function showPreview(src, name, size) {
        previewImg.src = src;
        previewFilename.textContent = name;
        previewSize.textContent = size;
        previewContainer.classList.add('active');
        removeThumbnailInput.value = '0';
    }

    function clearPreview() {
        previewImg.src = '';
        previewFilename.textContent = '';
        previewSize.textContent = '';
        previewContainer.classList.remove('active');
        fileInput.value = '';
        urlInput.value = '';
        removeThumbnailInput.value = '1';
    }

    btnRemoveThumb.addEventListener('click', function () {
        clearPreview();
    });

    dropzone.addEventListener('click', function () {
        fileInput.click();
    });

    fileInput.addEventListener('change', function () {
        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
                const sizeKb = (file.size / 1024).toFixed(1);
                showPreview(e.target.result, file.name, sizeKb + ' KB (File Lokal)');
            };
            reader.readAsDataURL(file);
            urlInput.value = '';
        }
    });

    // Drag-and-drop events
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.classList.remove('dragover');
        });
    });

    dropzone.addEventListener('drop', function (e) {
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
            fileInput.files = e.dataTransfer.files;
            const file = e.dataTransfer.files[0];
            const reader = new FileReader();
            reader.onload = function (event) {
                const sizeKb = (file.size / 1024).toFixed(1);
                showPreview(event.target.result, file.name, sizeKb + ' KB (File Lokal)');
            };
            reader.readAsDataURL(file);
            urlInput.value = '';
        }
    });

    // URL input live preview
    urlInput.addEventListener('input', function () {
        const url = urlInput.value.trim();
        if (url) {
            showPreview(url, url, 'URL Eksternal');
            fileInput.value = '';
        } else {
            clearPreview();
        }
    });
});
</script>
@endpush
