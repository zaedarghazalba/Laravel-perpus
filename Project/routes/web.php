<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookRequestController as AdminBookRequestController;
use App\Http\Controllers\Admin\BorrowingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClassificationController;
use App\Http\Controllers\Admin\EbookController as AdminEbookController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Book Search
Route::get('/books/search', [HomeController::class, 'searchBooks'])->name('books.search');

// Ebook Routes
Route::get('/ebooks', [HomeController::class, 'ebooks'])->name('ebooks.index');
Route::get('/ebooks/{ebook}', [HomeController::class, 'showEbook'])->name('ebooks.show');
Route::get('/ebooks/{ebook}/read', [HomeController::class, 'readEbook'])->name('ebooks.read');

// Secure file serving routes with rate limiting
Route::get('/files/books/{book}/cover', [FileController::class, 'serveBookCover'])->name('files.book.cover');
Route::middleware(['throttle:30,1'])->group(function () {
    Route::get('/files/ebooks/{ebook}/view', [FileController::class, 'serveEbook'])->name('files.ebook.view');
    Route::get('/files/ebooks/{ebook}/download', [FileController::class, 'downloadEbook'])->name('files.ebook.download');
});

// Legacy route redirect for backward compatibility (will be removed)
Route::get('/ebooks/{ebook}/download', [FileController::class, 'downloadEbook'])->middleware('throttle:10,1')->name('ebooks.download');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Book Requests (User Side)
    Route::get('/book-requests', [BookRequestController::class, 'index'])->name('book-requests.index');
    Route::get('/book-requests/create', [BookRequestController::class, 'create'])->name('book-requests.create');
    Route::post('/book-requests', [BookRequestController::class, 'store'])->middleware('throttle:5,1')->name('book-requests.store');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard route removed - redirects handled in admin layout
    Route::resource('categories', CategoryController::class);
    Route::resource('classifications', ClassificationController::class);
    Route::get('classifications/{code}/children', [ClassificationController::class, 'getChildren'])->name('classifications.children');

    // Book lookup routes (must be before resource routes) - with rate limiting
    Route::get('books/lookup', [BookController::class, 'lookup'])->name('books.lookup');
    Route::post('books/lookup', [BookController::class, 'lookup'])->middleware('throttle:20,1')->name('books.lookup.search');
    Route::resource('books', BookController::class);
    Route::resource('members', MemberController::class);

    // Borrowing custom routes (must be before resource routes)
    Route::get('borrowings/{borrowing}/return', [BorrowingController::class, 'returnForm'])->name('borrowings.return');
    Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'processReturn'])->name('borrowings.processReturn');
    Route::resource('borrowings', BorrowingController::class);

    // Ebook custom routes
    Route::get('ebooks/{ebook}/download', [FileController::class, 'adminDownloadEbook'])->middleware('throttle:30,1')->name('ebooks.download');
    Route::post('ebooks/{ebook}/toggle-publish', [AdminEbookController::class, 'togglePublish'])->name('ebooks.togglePublish');
    Route::resource('ebooks', AdminEbookController::class);

    // Book Requests Management
    Route::get('book-requests', [AdminBookRequestController::class, 'index'])->name('book-requests.index');
    Route::get('book-requests/{bookRequest}', [AdminBookRequestController::class, 'show'])->name('book-requests.show');
    Route::post('book-requests/{bookRequest}/approve', [AdminBookRequestController::class, 'approve'])->name('book-requests.approve');
    Route::post('book-requests/{bookRequest}/reject', [AdminBookRequestController::class, 'reject'])->name('book-requests.reject');
    Route::post('book-requests/{bookRequest}/fulfill', [AdminBookRequestController::class, 'fulfill'])->name('book-requests.fulfill');
    Route::delete('book-requests/{bookRequest}', [AdminBookRequestController::class, 'destroy'])->name('book-requests.destroy');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/books', [ReportController::class, 'books'])->name('books');
        Route::get('/ebooks', [ReportController::class, 'ebooks'])->name('ebooks');
        Route::get('/members', [ReportController::class, 'members'])->name('members');
        Route::get('/borrowings', [ReportController::class, 'borrowings'])->name('borrowings');
    });
});

require __DIR__.'/auth.php';
