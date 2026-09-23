<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected function logActivity(string $action, string $description): void
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'module' => 'kategori_buku',
            'action' => $action,
            'description' => $description,
        ]);
    }

    public function index()
    {
        $categories = Category::withCount('books')->orderBy('name', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        
        // Ensure unique slug
        $baseSlug = $validated['slug'];
        $count = 1;
        while (Category::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$baseSlug}-{$count}";
            $count++;
        }

        $category = Category::create($validated);

        $this->logActivity('create', "Menambah kategori buku: '{$category->name}'");

        return redirect()->route('admin.categories.index')->with('success', 'Kategori buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
        ]);

        if ($category->name !== $validated['name']) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $count = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }
            $validated['slug'] = $slug;
        }

        $category->update($validated);

        $this->logActivity('update', "Mengubah kategori buku: '{$category->name}'");

        return redirect()->route('admin.categories.index')->with('success', 'Kategori buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();

        $this->logActivity('delete', "Menghapus kategori buku: '{$name}'");

        return redirect()->route('admin.categories.index')->with('success', 'Kategori buku berhasil dihapus!');
    }
}
