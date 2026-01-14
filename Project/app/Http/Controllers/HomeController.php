<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Get featured ebooks (most viewed, published only)
        $featuredEbooks = Ebook::where('is_published', true)
            ->orderBy('view_count', 'desc')
            ->limit(6)
            ->get();

        // Get recent ebooks (published only)
        $recentEbooks = Ebook::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Get categories with ebook count
        $categories = Category::withCount(['ebooks' => function ($query) {
            $query->where('is_published', true);
        }])
            ->having('ebooks_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get statistics
        $stats = [
            'total_ebooks' => Ebook::where('is_published', true)->count(),
            'total_books' => Book::sum('quantity'),
            'total_categories' => $categories->count(),
            'total_downloads' => Ebook::where('is_published', true)->sum('download_count'),
        ];

        return view('home', compact('featuredEbooks', 'recentEbooks', 'categories', 'stats'));
    }

    /**
     * Display ebook catalog with search and filters.
     */
    public function ebooks(Request $request)
    {
        $query = Ebook::where('is_published', true)->with('category');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderBy('view_count', 'desc');
                break;
            case 'downloads':
                $query->orderBy('download_count', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $ebooks = $query->paginate(12)->appends($request->query());

        // Get all categories for filter dropdown
        $categories = Category::withCount(['ebooks' => function ($query) {
            $query->where('is_published', true);
        }])
            ->having('ebooks_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('ebooks.index', compact('ebooks', 'categories'));
    }

    /**
     * Display ebook detail page.
     */
    public function showEbook(Ebook $ebook)
    {
        // Only show published ebooks
        if (!$ebook->is_published) {
            abort(404);
        }

        // Increment view count
        $ebook->increment('view_count');

        // Load category relationship
        $ebook->load('category');

        // Get related ebooks (same category, excluding current)
        $relatedEbooks = Ebook::where('is_published', true)
            ->where('category_id', $ebook->category_id)
            ->where('id', '!=', $ebook->id)
            ->orderBy('view_count', 'desc')
            ->limit(4)
            ->get();

        return view('ebooks.show', compact('ebook', 'relatedEbooks'));
    }

    /**
     * Display ebook reader.
     */
    public function readEbook(Ebook $ebook)
    {
        // Only show published ebooks
        if (!$ebook->is_published) {
            abort(404);
        }

        return view('ebooks.read', compact('ebook'));
    }

    /**
     * Search for books in catalog.
     */
    public function searchBooks(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return view('books.search', ['books' => collect(), 'query' => '']);
        }

        // Search books by title, author, ISBN, or barcode
        $books = Book::where(function($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('author', 'like', "%{$query}%")
              ->orWhere('isbn', 'like', "%{$query}%")
              ->orWhere('barcode', 'like', "%{$query}%");
        })
        ->with(['category', 'classification'])
        ->orderBy('title')
        ->get();

        return view('books.search', compact('books', 'query'));
    }

    /**
     * Download ebook.
     */
    public function downloadEbook(Ebook $ebook)
    {
        // Only allow downloading published ebooks
        if (!$ebook->is_published) {
            abort(404);
        }

        // Increment download count
        $ebook->increment('download_count');

        $filePath = public_path($ebook->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($filePath, $ebook->title . '.pdf');
    }
}
