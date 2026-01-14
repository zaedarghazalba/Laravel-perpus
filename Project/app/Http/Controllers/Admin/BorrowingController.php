<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Borrowing::with(['book', 'member']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by member name or book title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('member', function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('student_id', 'like', "%{$search}%");
                })
                ->orWhereHas('book', function($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%");
                });
            });
        }

        $borrowings = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::orderBy('name')->get();
        $books = Book::where('available_quantity', '>', 0)
                    ->with('category')
                    ->orderBy('title')
                    ->get();

        return view('admin.borrowings.create', compact('members', 'books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after:borrow_date',
        ]);

        // Check if book is available
        $book = Book::findOrFail($validated['book_id']);
        if ($book->available_quantity <= 0) {
            return redirect()->back()
                ->with('error', 'Buku tidak tersedia untuk dipinjam.')
                ->withInput();
        }

        // Check if member has overdue books
        $member = Member::findOrFail($validated['member_id']);
        $hasOverdue = $member->borrowings()
            ->where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->exists();

        if ($hasOverdue) {
            return redirect()->back()
                ->with('error', 'Anggota memiliki buku yang terlambat dikembalikan. Harap kembalikan terlebih dahulu.')
                ->withInput();
        }

        // Create borrowing record
        $validated['status'] = 'borrowed';
        Borrowing::create($validated);

        // Decrease available quantity
        $book->decrement('available_quantity');

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Peminjaman berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['book.category', 'member']);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for returning a book.
     */
    public function returnForm(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return redirect()->route('admin.borrowings.index')
                ->with('error', 'Buku sudah dikembalikan.');
        }

        return view('admin.borrowings.return', compact('borrowing'));
    }

    /**
     * Process book return.
     */
    public function processReturn(Request $request, Borrowing $borrowing)
    {
        $validated = $request->validate([
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'fine_amount' => 'nullable|numeric|min:0',
        ]);

        if ($borrowing->status === 'returned') {
            return redirect()->route('admin.borrowings.index')
                ->with('error', 'Buku sudah dikembalikan.');
        }

        $returnDate = Carbon::parse($validated['return_date']);
        $dueDate = Carbon::parse($borrowing->due_date);

        // Calculate fine if overdue (Rp 1,000 per day)
        $fineAmount = 0;
        if ($returnDate->greaterThan($dueDate)) {
            $daysLate = abs($returnDate->diffInDays($dueDate, false));
            $fineAmount = $daysLate * 1000; // Rp 1,000 per day
        }

        // Allow manual fine override
        if ($request->filled('fine_amount')) {
            $fineAmount = $validated['fine_amount'];
        }

        // Update borrowing record
        $borrowing->update([
            'return_date' => $returnDate,
            'fine_amount' => $fineAmount,
            'status' => 'returned',
        ]);

        // Increase available quantity
        $borrowing->book->increment('available_quantity');

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Pengembalian berhasil dicatat.' . ($fineAmount > 0 ? ' Denda: Rp ' . number_format($fineAmount, 0, ',', '.') : ''));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        // Only allow deletion of returned books
        if ($borrowing->status === 'borrowed') {
            return redirect()->route('admin.borrowings.index')
                ->with('error', 'Tidak dapat menghapus peminjaman yang masih aktif.');
        }

        $borrowing->delete();

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
