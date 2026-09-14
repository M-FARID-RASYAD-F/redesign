<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Traits\LogsActivity;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $newsList = News::with(['category', 'author'])->orderBy('created_at', 'desc')->get();
        return view('admin.news.index', compact('newsList'));
    }

    public function create()
    {
        $categories = NewsCategory::all();
        if ($categories->isEmpty()) {
            $defaultCat = NewsCategory::create(['name' => 'Umum', 'slug' => 'umum']);
            $categories = collect([$defaultCat]);
        }
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required|string',
            'thumbnail' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        $validated['author_id'] = Auth::id();

        $news = News::create($validated);

        $this->logActivity('berita', 'create', "Membuat berita baru: '{$news->title}'");

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diterbitkan!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        $categories = NewsCategory::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:news_categories,id',
            'content' => 'required|string',
            'thumbnail' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        if ($news->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        }

        $news->update($validated);

        $this->logActivity('berita', 'update', "Mengubah berita: '{$news->title}'");

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $title = $news->title;
        $news->delete();

        $this->logActivity('berita', 'delete', "Menghapus berita: '{$title}'");

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus!');
    }

    // Aliases for backward compatibility
    public function newsIndex() { return $this->index(); }
    public function newsCreate() { return $this->create(); }
    public function newsStore(Request $request) { return $this->store($request); }
    public function newsEdit($id) { return $this->edit($id); }
    public function newsUpdate(Request $request, $id) { return $this->update($request, $id); }
    public function newsDelete($id) { return $this->destroy($id); }
}
