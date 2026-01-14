<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Ebook;
use App\Models\Member;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function books(Request $request)
    {
        $query = Book::with(['category', 'classification']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('level')) {
            $query->whereHas('classification', function($q) use ($request) {
                $q->where('level', $request->level);
            });
        }

        if ($request->filled('main_class')) {
            $mainClass = $request->main_class;
            $query->where('classification_code', '>=', $mainClass)
                  ->where('classification_code', '<', (int)$mainClass + 100);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $books = $query->orderBy('classification_code', 'asc')->orderBy('title', 'asc')->get();
        $categories = Category::orderBy('name')->get();

        if ($request->get('format') === 'print') {
            $title = 'Laporan Inventaris Buku';
            $periode = $request->filled('start_date') ? $request->start_date . ' s/d ' . $request->end_date : 'Semua Waktu';
            return view('admin.reports.books_print', compact('books', 'title', 'periode'));
        }

        return view('admin.reports.books', compact('books', 'categories'));
    }

    public function ebooks(Request $request)
    {
        $query = Ebook::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('is_published')) {
            $query->where('is_published', $request->is_published);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $ebooks = $query->orderBy('title')->get();
        $categories = Category::orderBy('name')->get();

        if ($request->get('format') === 'print') {
            $title = 'Laporan Katalog E-Book';
            $periode = $request->filled('start_date') ? $request->start_date . ' s/d ' . $request->end_date : 'Semua Waktu';
            return view('admin.reports.ebooks_print', compact('ebooks', 'title', 'periode'));
        }

        return view('admin.reports.ebooks', compact('ebooks', 'categories'));
    }

    public function members(Request $request)
    {
        $query = Member::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $members = $query->orderBy('name')->get();

        if ($request->get('format') === 'print') {
            $title = 'Laporan Data Anggota';
            $periode = $request->filled('start_date') ? $request->start_date . ' s/d ' . $request->end_date : 'Semua Waktu';
            return view('admin.reports.members_print', compact('members', 'title', 'periode'));
        }

        return view('admin.reports.members', compact('members'));
    }

    public function borrowings(Request $request)
    {
        $query = Borrowing::with(['book', 'member']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->orWhereHas('member', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('member_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('borrow_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        $borrowings = $query->orderBy('borrow_date', 'desc')->get();

        if ($request->get('format') === 'print') {
            $title = 'Laporan Transaksi Peminjaman';
            $periode = $request->filled('start_date') ? $request->start_date . ' s/d ' . $request->end_date : 'Semua Waktu';
            return view('admin.reports.borrowings_print', compact('borrowings', 'title', 'periode'));
        }

        return view('admin.reports.borrowings', compact('borrowings'));
    }
}
