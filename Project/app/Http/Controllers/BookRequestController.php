<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    /**
     * Display the book request form.
     */
    public function create(Request $request)
    {
        // Pre-fill form data if coming from search
        $prefill = [
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'request_type' => $request->input('type', 'book'),
        ];

        return view('book-requests.create', compact('prefill'));
    }

    /**
     * Store a new book request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50',
            'request_type' => 'required|in:book,ebook',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        BookRequest::create($validated);

        return redirect()->route('home')
            ->with('success', 'Permintaan buku berhasil dikirim. Kami akan meninjau permintaan Anda.');
    }

    /**
     * Display user's book requests.
     */
    public function index()
    {
        $requests = BookRequest::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('book-requests.index', compact('requests'));
    }
}
