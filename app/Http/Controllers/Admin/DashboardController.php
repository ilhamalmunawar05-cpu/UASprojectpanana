<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Artist;
use App\Models\Exhibition;
use App\Models\Auction;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Collection;
use App\Models\Category;
use App\Models\Book;
use App\Models\User;
use App\Models\Member;
use App\Models\Loan;
use App\Models\FinePayment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'artworks' => Artwork::count(),
            'artists' => Artist::count(),
            'exhibitions' => Exhibition::count(),
            'auctions' => Auction::count(),
            'articles' => Article::count(),
            'comments' => Comment::count(),
            'collections' => Collection::count(),
            'categories' => Category::count(),
            'books' => Book::count(),
            'users' => User::count(),
            'members' => Member::count(),
            'loans_active' => Loan::where('status', 'active')->count(),
            'loans_overdue' => Loan::where('status', 'overdue')->count(),
            'fines_total' => FinePayment::sum('amount') ?? 0,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

