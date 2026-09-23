<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Category;
use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    protected function logActivity(string $action, string $description): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'buku',
            'action' => $action,
            'description' => $description,
        ]);
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $rackId = $request->query('rack_id');
        $status = $request->query('status');

        $query = Book::with(['category', 'rack']);

        if (!empty($search)) {
            $query->search($search);
        }

        if (!empty($categoryId) && $categoryId !== 'all') {
            $query->where('category_id', $categoryId);
        }

        if (!empty($rackId) && $rackId !== 'all') {
            $query->where('rack_id', $rackId);
        }

        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        $categories = Category::orderBy('name', 'asc')->get();
        $racks = Rack::orderBy('code', 'asc')->get();

        return view('admin.books.index', compact('books', 'categories', 'racks', 'search', 'categoryId', 'rackId', 'status'));
    }

    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $racks = Rack::orderBy('code', 'asc')->get();

        // Fallback default category if none exist
        if ($categories->isEmpty()) {
            $defaultCat = Category::create([
                'name' => 'Umum',
                'slug' => 'umum',
                'description' => 'Kategori buku umum'
            ]);
            $categories = collect([$defaultCat]);
        }

        return view('admin.books.create', compact('categories', 'racks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'rack_id' => 'nullable|exists:racks,id',
            'isbn' => 'nullable|string|max:50|unique:books,isbn',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'pages' => 'nullable|integer|min:1',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,rusak',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'cover_image' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('books', 'public');
            $validated['cover_image'] = 'storage/' . $path;
        }
        unset($validated['cover_file']);

        // Set slug
        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $counter = 1;
        while (Book::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }
        $validated['slug'] = $slug;

        // Default available stock equals total stock on creation
        $validated['available_stock'] = $validated['stock'];

        $book = Book::create($validated);

        $this->logActivity('create', "Menambah koleksi buku baru: '{$book->title}'");

        return redirect()->route('admin.books.index')->with('success', 'Buku baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        $racks = Rack::orderBy('code', 'asc')->get();

        return view('admin.books.edit', compact('book', 'categories', 'racks'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'rack_id' => 'nullable|exists:racks,id',
            'isbn' => ['nullable', 'string', 'max:50', Rule::unique('books')->ignore($book->id)],
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'pages' => 'nullable|integer|min:1',
            'stock' => 'required|integer|min:0',
            'available_stock' => 'nullable|integer|min:0|lte:stock',
            'description' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,rusak',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'cover_image' => 'nullable|string|max:1000',
            'remove_cover' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_file')) {
            if (!empty($book->cover_image) && Str::startsWith($book->cover_image, 'storage/books/')) {
                $oldFile = Str::after($book->cover_image, 'storage/');
                Storage::disk('public')->delete($oldFile);
            }
            $path = $request->file('cover_file')->store('books', 'public');
            $validated['cover_image'] = 'storage/' . $path;
        } elseif ($request->boolean('remove_cover')) {
            if (!empty($book->cover_image) && Str::startsWith($book->cover_image, 'storage/books/')) {
                $oldFile = Str::after($book->cover_image, 'storage/');
                Storage::disk('public')->delete($oldFile);
            }
            $validated['cover_image'] = null;
        } elseif (!array_key_exists('cover_image', $validated) || ($validated['cover_image'] === null && !$request->has('cover_image'))) {
            $validated['cover_image'] = $book->cover_image;
        }
        unset($validated['cover_file'], $validated['remove_cover']);

        // Manage available stock if not explicitly set
        if (!isset($validated['available_stock'])) {
            $stockDiff = $validated['stock'] - $book->stock;
            $validated['available_stock'] = max(0, min($validated['stock'], $book->available_stock + $stockDiff));
        }

        if ($book->title !== $validated['title']) {
            $baseSlug = Str::slug($validated['title']);
            $slug = $baseSlug;
            $counter = 1;
            while (Book::where('slug', $slug)->where('id', '!=', $book->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        $book->update($validated);

        $this->logActivity('update', "Mengubah data buku: '{$book->title}'");

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $title = $book->title;

        if (!empty($book->cover_image) && Str::startsWith($book->cover_image, 'storage/books/')) {
            $oldFile = Str::after($book->cover_image, 'storage/');
            Storage::disk('public')->delete($oldFile);
        }

        $book->delete();

        $this->logActivity('delete', "Menghapus buku: '{$title}'");

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
