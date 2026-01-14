<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::withCount('borrowings')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50|unique:members,student_id',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'join_date' => 'required|date',
        ]);

        Member::create($validated);

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $member->load(['borrowings.book']);
        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50|unique:members,student_id,' . $member->id,
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'join_date' => 'required|date',
        ]);

        $member->update($validated);

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        try {
            $member->delete();
            return redirect()->route('admin.members.index')
                ->with('success', 'Anggota berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.members.index')
                ->with('error', 'Anggota tidak dapat dihapus karena masih memiliki riwayat peminjaman.');
        }
    }
}
