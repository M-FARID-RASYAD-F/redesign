<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Rack;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Menampilkan Halaman Katalog Buku Publik dengan Search & Filter
     */
    public function index(Request $request)
    {
        $search = $request->query('q') ?? $request->query('search');
        $categorySlug = $request->query('kategori') ?? $request->query('category');
        $rackId = $request->query('rak') ?? $request->query('rack');
        $availability = $request->query('ketersediaan') ?? $request->query('availability');
        $sort = $request->query('sort', 'terbaru');

        $query = Book::with(['category', 'rack']);

        // Search
        if (!empty($search)) {
            $query->search($search);
        }

        // Filter Category
        if (!empty($categorySlug) && $categorySlug !== 'all') {
            $query->filterByCategory($categorySlug);
        }

        // Filter Rack
        if (!empty($rackId) && $rackId !== 'all') {
            $query->filterByRack($rackId);
        }

        // Filter Availability
        if ($availability === 'tersedia') {
            $query->available();
        }

        // Sorting
        switch ($sort) {
            case 'judul_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'judul_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'tahun_desc':
                $query->orderBy('publication_year', 'desc')->orderBy('title', 'asc');
                break;
            case 'tahun_asc':
                $query->orderBy('publication_year', 'asc')->orderBy('title', 'asc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $books = $query->paginate(12)->withQueryString();

        // Kategori dengan jumlah buku
        $categories = Category::withCount('books')->orderBy('name', 'asc')->get();

        // Daftar Rak
        $racks = Rack::withCount('books')->orderBy('code', 'asc')->get();

        // Total statistik ringkas untuk header
        $totalBooksCount = Book::count();
        $totalAvailableCount = Book::available()->sum('available_stock');
        $totalCategoriesCount = $categories->count();

        // Kategori aktif (jika difilter)
        $activeCategory = !empty($categorySlug) ? $categories->firstWhere('slug', $categorySlug) : null;
        $activeRack = !empty($rackId) ? $racks->firstWhere('id', $rackId) : null;

        return view('catalog.index', compact(
            'books',
            'categories',
            'racks',
            'search',
            'categorySlug',
            'rackId',
            'availability',
            'sort',
            'totalBooksCount',
            'totalAvailableCount',
            'totalCategoriesCount',
            'activeCategory',
            'activeRack'
        ));
    }

    /**
     * Menampilkan Detail Buku Publik
     */
    public function show($slug)
    {
        $book = Book::with(['category', 'rack'])
            ->where('slug', $slug)
            ->orWhere('id', is_numeric($slug) ? $slug : 0)
            ->firstOrFail();

        // Buku terkait dari kategori yang sama
        $relatedBooks = Book::with(['category', 'rack'])
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->limit(4)
            ->get();

        return view('catalog.show', compact('book', 'relatedBooks'));
    }
}
