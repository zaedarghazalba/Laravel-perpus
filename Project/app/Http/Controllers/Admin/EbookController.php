<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ebook::with('category');

        // Filter by status
        if ($request->filled('status')) {
            $published = $request->status === 'published';
            $query->where('is_published', $published);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $ebooks = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.ebooks.index', compact('ebooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.ebooks.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50|unique:ebooks,isbn',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048|mimetypes:image/jpeg,image/png',
            'file_path' => 'required|file|mimes:pdf|max:20480|mimetypes:application/pdf', // Max 20MB
            'description' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        // Set default values
        $validated['view_count'] = 0;
        $validated['download_count'] = 0;
        $validated['is_published'] = $request->has('is_published');

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
            $path = $file->store('covers', 'book_covers');
            $validated['cover_image'] = $path;
        }

        // Handle PDF upload - stored securely outside public directory with authorization
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');

            // Validate MIME type (additional security check)
            if ($file->getMimeType() !== 'application/pdf') {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['file_path' => 'File harus berupa PDF.']);
            }

            // Store file with secure random name
            $path = $file->store('', 'ebooks');
            $validated['file_path'] = $path;
        }

        Ebook::create($validated);

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ebook $ebook)
    {
        $ebook->load('category');
        return view('admin.ebooks.show', compact('ebook'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ebook $ebook)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.ebooks.edit', compact('ebook', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ebook $ebook)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:50|unique:ebooks,isbn,' . $ebook->id,
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048|mimetypes:image/jpeg,image/png',
            'file_path' => 'nullable|file|mimes:pdf|max:20480|mimetypes:application/pdf',
            'description' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

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

            // Delete old cover if exists
            if ($ebook->cover_image && Storage::disk('book_covers')->exists($ebook->cover_image)) {
                Storage::disk('book_covers')->delete($ebook->cover_image);
            }

            // Store new file with secure random name
            $path = $file->store('covers', 'book_covers');
            $validated['cover_image'] = $path;
        }

        // Handle PDF upload - stored securely outside public directory with authorization
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');

            // Validate MIME type (additional security check)
            if ($file->getMimeType() !== 'application/pdf') {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['file_path' => 'File harus berupa PDF.']);
            }

            // Delete old PDF if exists
            if ($ebook->file_path && Storage::disk('ebooks')->exists($ebook->file_path)) {
                Storage::disk('ebooks')->delete($ebook->file_path);
            }

            // Store new file with secure random name
            $path = $file->store('', 'ebooks');
            $validated['file_path'] = $path;
        }

        $ebook->update($validated);

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ebook $ebook)
    {
        // Delete cover image
        if ($ebook->cover_image && Storage::disk('book_covers')->exists($ebook->cover_image)) {
            Storage::disk('book_covers')->delete($ebook->cover_image);
        }

        // Delete PDF file
        if ($ebook->file_path && Storage::disk('ebooks')->exists($ebook->file_path)) {
            Storage::disk('ebooks')->delete($ebook->file_path);
        }

        $ebook->delete();

        return redirect()->route('admin.ebooks.index')
            ->with('success', 'Ebook berhasil dihapus.');
    }

    /**
     * Download ebook file.
     */
    public function download(Ebook $ebook)
    {
        if (!$ebook->file_path || !file_exists(public_path($ebook->file_path))) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        // Increment download count
        $ebook->increment('download_count');

        return response()->download(public_path($ebook->file_path));
    }

    /**
     * Toggle publish status.
     */
    public function togglePublish(Ebook $ebook)
    {
        $ebook->update(['is_published' => !$ebook->is_published]);

        $status = $ebook->is_published ? 'dipublikasikan' : 'tidak dipublikasikan';

        return redirect()->back()
            ->with('success', "Ebook berhasil {$status}.");
    }
}
