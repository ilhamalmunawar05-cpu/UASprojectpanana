<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Book;
use App\Models\LoanReturn;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|staff-admin');
    }

    public function index()
    {
        $loans = Loan::with(['member', 'book'])->latest()->paginate(15);
        return view('admin.loans.index', compact('loans'));
    }

    public function create()
    {
        $members = Member::where('status', 'active')->get();
        $books = Book::where('stock', '>', 0)->get();
        return view('admin.loans.create', compact('members', 'books'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
        ]);

        $book = Book::find($validated['book_id']);
        if ($book->stock <= 0) {
            return back()->withErrors(['book_id' => 'Stok buku tidak tersedia.']);
        }

        Loan::create($validated + ['status' => 'active']);
        $book->decrement('stock');

        return redirect()->route('admin.loans.index')->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function show(Loan $loan)
    {
        return view('admin.loans.show', compact('loan'));
    }

    public function returnBook($id)
    {
        $loan = Loan::findOrFail($id);
        if ($loan->status !== 'active') {
            return back()->withErrors(['error' => 'Peminjaman ini sudah ditutup.']);
        }
        return view('admin.loans.return', compact('loan'));
    }

    public function processReturn(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        
        $validated = $request->validate([
            'return_date' => 'required|date|after_or_equal:' . $loan->loan_date,
            'notes' => 'nullable|string',
        ]);

        $returnDate = \Carbon\Carbon::parse($validated['return_date']);
        $dueDate = \Carbon\Carbon::parse($loan->due_date);
        $lateDay = max(0, $returnDate->diffInDays($dueDate));
        $fineAmount = $lateDay * 5000; // Rp 5000 per hari

        LoanReturn::create([
            'loan_id' => $loan->id,
            'return_date' => $validated['return_date'],
            'late_days' => $lateDay,
            'fine_amount' => $fineAmount,
            'notes' => $validated['notes'] ?? null,
        ]);

        $loan->update(['status' => 'returned']);
        $loan->book->increment('stock');

        return redirect()->route('admin.loans.index')->with('success', 'Pengembalian buku berhasil dicatat!');
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status === 'active') {
            $loan->book->increment('stock');
        }
        $loan->delete();

        return redirect()->route('admin.loans.index')->with('success', 'Pencatatan peminjaman berhasil dihapus!');
    }
}
