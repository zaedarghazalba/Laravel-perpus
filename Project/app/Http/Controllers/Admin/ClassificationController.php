<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classification;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Classification::query();

        // Filter by level
        if ($request->has('level') && $request->level != '') {
            $query->where('level', $request->level);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $classifications = $query->with('parent')
            ->orderBy('code')
            ->paginate(20);

        return view('admin.classifications.index', compact('classifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all classifications for parent dropdown
        $parentClassifications = Classification::orderBy('code')->get();

        return view('admin.classifications.create', compact('parentClassifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:classifications,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_code' => 'nullable|exists:classifications,code',
            'level' => 'required|integer|min:1|max:10',
        ]);

        Classification::create($validated);

        return redirect()->route('admin.classifications.index')
            ->with('success', 'Klasifikasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classification $classification)
    {
        $classification->load(['parent', 'children', 'books', 'ebooks']);

        return view('admin.classifications.show', compact('classification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classification $classification)
    {
        // Get all classifications except current one for parent dropdown
        $parentClassifications = Classification::where('code', '!=', $classification->code)
            ->orderBy('code')
            ->get();

        return view('admin.classifications.edit', compact('classification', 'parentClassifications'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classification $classification)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:classifications,code,' . $classification->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_code' => 'nullable|exists:classifications,code',
            'level' => 'required|integer|min:1|max:10',
        ]);

        $classification->update($validated);

        return redirect()->route('admin.classifications.index')
            ->with('success', 'Klasifikasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classification $classification)
    {
        // Check if classification has books or ebooks
        if ($classification->books()->count() > 0 || $classification->ebooks()->count() > 0) {
            return redirect()->route('admin.classifications.index')
                ->with('error', 'Klasifikasi tidak dapat dihapus karena masih digunakan oleh buku/ebook!');
        }

        // Check if classification has children
        if ($classification->children()->count() > 0) {
            return redirect()->route('admin.classifications.index')
                ->with('error', 'Klasifikasi tidak dapat dihapus karena masih memiliki sub-klasifikasi!');
        }

        $classification->delete();

        return redirect()->route('admin.classifications.index')
            ->with('success', 'Klasifikasi berhasil dihapus!');
    }

    /**
     * Get children classifications by parent code (for AJAX)
     */
    public function getChildren($code)
    {
        $children = Classification::where('parent_code', $code)
            ->orderBy('code')
            ->get();

        return response()->json([
            'success' => true,
            'children' => $children
        ]);
    }
}
