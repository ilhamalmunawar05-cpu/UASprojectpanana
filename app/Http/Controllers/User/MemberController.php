<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $member = $user->member;

        return view('user.member.edit', compact('member', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $member = $user->member;

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'nim_nidn' => 'required|string|max:50|unique:members,nim_nidn,' . ($member?->id ?? 'NULL'),
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'department' => 'nullable|string|max:100',
        ]);

        if (!$member) {
            // Create new member profile
            $member = Member::create([
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'nim_nidn' => $validated['nim_nidn'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'department' => $validated['department'] ?? null,
                'status' => 'active',
                'joined_date' => Carbon::today(),
            ]);
        } else {
            // Update existing member profile
            $member->update($validated);
        }

        // Redirect to loans page with book parameter if provided
        $bookId = $request->query('book');
        if ($bookId) {
            return redirect()->route('user.loans', ['book' => $bookId])->with('success', 'Profil anggota berhasil disimpan. Silakan lanjutkan peminjaman.');
        }

        return redirect()->route('user.loans')->with('success', 'Profil anggota berhasil disimpan.');
    }
}
