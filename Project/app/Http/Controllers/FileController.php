<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    /**
     * Serve book cover images securely.
     * Public access allowed for better UX, but served through controller.
     */
    public function serveBookCover(Book $book): StreamedResponse
    {
        if (!$book->cover_image || !Storage::disk('book_covers')->exists($book->cover_image)) {
            abort(404, 'Cover image not found.');
        }

        $path = Storage::disk('book_covers')->path($book->cover_image);
        $mimeType = Storage::disk('book_covers')->mimeType($book->cover_image);

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000', // Cache for 1 year
        ]);
    }

    /**
     * Serve ebook PDF securely with authorization check.
     * Only authenticated users can view ebooks.
     */
    public function serveEbook(Ebook $ebook): StreamedResponse
    {
        // Authorization: Must be authenticated
        if (!auth()->check()) {
            abort(403, 'You must be logged in to view ebooks.');
        }

        // Check if ebook is published (unless user is admin)
        if (!$ebook->is_published && (!auth()->user() || auth()->user()->role !== 'admin')) {
            abort(403, 'This ebook is not published yet.');
        }

        if (!$ebook->file_path || !Storage::disk('ebooks')->exists($ebook->file_path)) {
            abort(404, 'Ebook file not found.');
        }

        // Increment view count
        $ebook->increment('view_count');

        $path = Storage::disk('ebooks')->path($ebook->file_path);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $ebook->title . '.pdf"',
            'Cache-Control' => 'private, no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    /**
     * Download ebook PDF securely with authorization and rate limiting.
     * Only authenticated users can download ebooks.
     */
    public function downloadEbook(Ebook $ebook)
    {
        // Authorization: Must be authenticated
        if (!auth()->check()) {
            abort(403, 'You must be logged in to download ebooks.');
        }

        // Check if ebook is published (unless user is admin)
        if (!$ebook->is_published && (!auth()->user() || auth()->user()->role !== 'admin')) {
            abort(403, 'This ebook is not published yet.');
        }

        if (!$ebook->file_path || !Storage::disk('ebooks')->exists($ebook->file_path)) {
            abort(404, 'Ebook file not found.');
        }

        // Increment download count
        $ebook->increment('download_count');

        return Storage::disk('ebooks')->download($ebook->file_path, $ebook->title . '.pdf');
    }

    /**
     * Download ebook for admin (no publication check).
     */
    public function adminDownloadEbook(Ebook $ebook)
    {
        // Authorization: Must be admin
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        if (!$ebook->file_path || !Storage::disk('ebooks')->exists($ebook->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        // Increment download count
        $ebook->increment('download_count');

        return Storage::disk('ebooks')->download($ebook->file_path, $ebook->title . '.pdf');
    }
}
