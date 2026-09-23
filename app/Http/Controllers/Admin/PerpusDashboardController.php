<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Support\Facades\DB;

class PerpusDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books'     => Book::count(),
            'total_available' => (int) Book::sum('available'),
            'total_dipinjam'  => BookLoan::where('status', 'dipinjam')->count(),
            'total_terlambat' => BookLoan::where('status', 'terlambat')->count(),
        ];

        $recentLoans = BookLoan::with(['book', 'member'])
            ->orderBy('created_at', 'desc')->take(8)->get();

        $topBooks = BookLoan::select('book_id', DB::raw('count(*) as total'))
            ->groupBy('book_id')
            ->orderByDesc('total')
            ->with('book')
            ->take(5)
            ->get();

        return view('admin.dashboards.perpus', compact('stats', 'recentLoans', 'topBooks'));
    }
}
