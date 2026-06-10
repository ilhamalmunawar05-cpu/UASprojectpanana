<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|staff-admin');
    }

    public function index()
    {
        $members = Member::with('user')->latest()->paginate(15);
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('member')->where('email', '!=', 'admin@gallery.com')->get();
        return view('admin.members.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:members,user_id',
            'nim_nidn' => 'required|string|max:50|unique:members,nim_nidn',
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'department' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,suspended',
            'joined_date' => 'required|date',
        ]);

        Member::create($validated);

        return redirect()->route('admin.members.index')->with('success', 'Anggota perpustakaan berhasil ditambahkan!');
    }

    public function show(Member $member)
    {
        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        $users = User::where('id', $member->user_id)->orWhereDoesntHave('member')->get();
        return view('admin.members.edit', compact('member', 'users'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'nim_nidn' => 'required|string|max:50|unique:members,nim_nidn,' . $member->id,
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'department' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $member->update($validated);

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil dihapus!');
    }
}
