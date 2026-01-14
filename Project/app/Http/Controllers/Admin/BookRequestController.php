<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookRequest;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    /**
     * Display a listing of book requests.
     */
    public function index(Request $request)
    {
        $query = BookRequest::with(['user', 'processor'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by request type
        if ($request->filled('type')) {
            $query->where('request_type', $request->type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        $requests = $query->paginate(20);

        // Get counts for badges
        $counts = [
            'pending' => BookRequest::pending()->count(),
            'approved' => BookRequest::approved()->count(),
            'rejected' => BookRequest::rejected()->count(),
            'fulfilled' => BookRequest::fulfilled()->count(),
        ];

        return view('admin.book-requests.index', compact('requests', 'counts'));
    }

    /**
     * Display the specified book request.
     */
    public function show(BookRequest $bookRequest)
    {
        $bookRequest->load(['user', 'processor']);
        return view('admin.book-requests.show', compact('bookRequest'));
    }

    /**
     * Approve a book request.
     */
    public function approve(Request $request, BookRequest $bookRequest)
    {
        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $bookRequest->update([
            'status' => 'approved',
            'admin_note' => $validated['admin_note'] ?? null,
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        return redirect()->route('admin.book-requests.index')
            ->with('success', 'Permintaan buku telah disetujui.');
    }

    /**
     * Reject a book request.
     */
    public function reject(Request $request, BookRequest $bookRequest)
    {
        $validated = $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        $bookRequest->update([
            'status' => 'rejected',
            'admin_note' => $validated['admin_note'],
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        return redirect()->route('admin.book-requests.index')
            ->with('success', 'Permintaan buku telah ditolak.');
    }

    /**
     * Mark a book request as fulfilled.
     */
    public function fulfill(Request $request, BookRequest $bookRequest)
    {
        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $bookRequest->update([
            'status' => 'fulfilled',
            'admin_note' => $validated['admin_note'] ?? null,
            'processed_by' => auth()->id(),
            'processed_at' => now(),
        ]);

        return redirect()->route('admin.book-requests.index')
            ->with('success', 'Permintaan buku ditandai sebagai terpenuhi.');
    }

    /**
     * Delete a book request.
     */
    public function destroy(BookRequest $bookRequest)
    {
        $bookRequest->delete();

        return redirect()->route('admin.book-requests.index')
            ->with('success', 'Permintaan buku berhasil dihapus.');
    }
}
