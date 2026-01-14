<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'total_books' => Book::count(),
            'total_ebooks' => Ebook::count(),
            'total_members' => Member::count(),
            'total_categories' => Category::count(),
            'active_borrowings' => Borrowing::where('status', 'borrowed')->count(),
            'overdue_borrowings' => Borrowing::where('status', 'overdue')->count(),
        ];

        // Get recent borrowings
        $recent_borrowings = Borrowing::with(['member', 'book'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get popular ebooks
        $popular_ebooks = Ebook::where('is_published', true)
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_borrowings', 'popular_ebooks'));
    }
}
