<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;


class GuestbookController extends Controller
{
    public function index()
    {
        $comments = Comment::whereNull('artwork_id')
            ->where('status', 'approved')
            ->with('user')
            ->latest()
            ->paginate(12);
        return view('public.guestbook.index', compact('comments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'name' => 'required_without:user_id|string|max:255',
            'email' => 'required_without:user_id|email|max:255',
        ]);

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
            $validated['name'] = null;
            $validated['email'] = null;
        }

        Comment::create($validated);
        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}

    