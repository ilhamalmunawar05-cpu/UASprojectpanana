<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class OpacController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $books = Book::query()
            ->when($q, function($query, $q) {
                $query->where('title', 'like', "%{$q}%")
                      ->orWhere('author', 'like', "%{$q}%")
                      ->orWhere('isbn', 'like', "%{$q}%");
            })
            ->orderBy('title')
            ->paginate(10)
            ->withQueryString();

        return view('opac.index', compact('books', 'q'));
    }
}
