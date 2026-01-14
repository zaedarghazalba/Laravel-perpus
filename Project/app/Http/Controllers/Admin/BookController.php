<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Classification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['category', 'classification'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $classifications = Classification::orderBy('code')->get();
        return view('admin.books.create', compact('categories', 'classifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50|unique:books,isbn',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|string|max:50|unique:books,barcode',
            'classification_code' => 'nullable|exists:classifications,code',
            'call_number' => 'nullable|string|max:50',
            'shelf_location' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048|mimetypes:image/jpeg,image/png',
            'description' => 'nullable|string',
        ]);

        // Set available_quantity same as quantity for new book
        $validated['available_quantity'] = $validated['quantity'];

        // Auto-generate shelf location from classification code if not provided
        if (!empty($validated['classification_code']) && empty($validated['shelf_location'])) {
            $validated['shelf_location'] = Book::generateShelfLocation($validated['classification_code']);
        }

        // Handle cover image upload - stored securely outside public directory
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');

            // Validate MIME type (additional security check)
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['cover_image' => 'File harus berupa gambar JPEG atau PNG.']);
            }

            // Store file with secure random name
            $path = $file->store('', 'book_covers');
            $validated['cover_image'] = $path;
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load(['category', 'classification', 'borrowings.member']);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        $classifications = Classification::orderBy('code')->get();
        return view('admin.books.edit', compact('book', 'categories', 'classifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50|unique:books,isbn,' . $book->id,
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|string|max:50|unique:books,barcode,' . $book->id,
            'classification_code' => 'nullable|exists:classifications,code',
            'call_number' => 'nullable|string|max:50',
            'shelf_location' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048|mimetypes:image/jpeg,image/png',
            'description' => 'nullable|string',
        ]);

        // Calculate available_quantity based on the change in total quantity
        $quantityDifference = $validated['quantity'] - $book->quantity;
        $validated['available_quantity'] = max(0, $book->available_quantity + $quantityDifference);

        // Auto-generate shelf location from classification code if not provided
        if (!empty($validated['classification_code']) && empty($validated['shelf_location'])) {
            $validated['shelf_location'] = Book::generateShelfLocation($validated['classification_code']);
        }

        // Handle cover image upload - stored securely outside public directory
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');

            // Validate MIME type (additional security check)
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($file->getMimeType(), $allowedMimes)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['cover_image' => 'File harus berupa gambar JPEG atau PNG.']);
            }

            // Delete old image if exists
            if ($book->cover_image && Storage::disk('book_covers')->exists($book->cover_image)) {
                Storage::disk('book_covers')->delete($book->cover_image);
            }

            // Store new file with secure random name
            $path = $file->store('', 'book_covers');
            $validated['cover_image'] = $path;
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Check if book has active borrowings
        if ($book->borrowings()->where('status', 'borrowed')->exists()) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Tidak dapat menghapus buku yang sedang dipinjam.');
        }

        // Delete cover image if exists
        if ($book->cover_image && Storage::disk('book_covers')->exists($book->cover_image)) {
            Storage::disk('book_covers')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }

    /**
     * Quick book lookup by barcode
     */
    public function lookup(Request $request)
    {
        // GET: Show lookup page
        if ($request->isMethod('GET')) {
            return view('admin.books.lookup');
        }

        // POST: AJAX search by barcode with validation
        $validated = $request->validate([
            'barcode' => 'required|string|max:50|regex:/^[a-zA-Z0-9\-_]+$/',
        ]);

        $barcode = $validated['barcode'];

        $book = Book::where('barcode', $barcode)
            ->with(['category', 'classification'])
            ->first();

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Buku dengan barcode ini tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'book' => $book
        ]);
    }
}
