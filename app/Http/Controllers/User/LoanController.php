<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $member = $user->member ?? Member::where('user_id', $user->id)->first();

        if (! $member) {
            return redirect()->route('profile.edit')
                ->with('error', 'Profil anggota tidak ditemukan. Silakan lengkapi data anggota terlebih dahulu.');
        }

        $selectedBook = null;
        if ($request->has('book')) {
            $selectedBook = Book::find($request->query('book'));
        }

        $loans = $member->loans()->with('book')->latest()->paginate(10);

        return view('user.loans.index', compact('member', 'selectedBook', 'loans'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $member = $user->member ?? Member::where('user_id', $user->id)->first();

        if (! $member) {
            return redirect()->route('profile.edit')
                ->with('error', 'Profil anggota tidak ditemukan. Silakan lengkapi data anggota terlebih dahulu.');
        }

        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::find($validated['book_id']);

        if (! $book || $book->stock <= 0) {
            return back()->withErrors(['book_id' => 'Stok buku tidak tersedia.'])->withInput();
        }

        if ($member->loans()->where('book_id', $book->id)->where('status', 'active')->exists()) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        Loan::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'loan_date' => Carbon::today(),
            'due_date' => Carbon::today()->addDays(7),
            'status' => 'active',
        ]);

        $book->decrement('stock');

        return redirect()->route('user.loans')->with('success', 'Buku berhasil dipinjam. Cek daftar peminjaman Anda.');
    }
}
