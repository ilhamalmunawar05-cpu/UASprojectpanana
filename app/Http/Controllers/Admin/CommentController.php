<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|staff-admin');
    }

    public function index()
    {
        $comments = Comment::with(['user', 'artwork'])->latest()->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Komentar berhasil dihapus!');
    }

    public function approve(Comment $comment)
    {
        $comment->status = 'approved';
        $comment->save();
        return redirect()->route('admin.comments.index')->with('success', 'Komentar disetujui.');
    }

    public function reject(Comment $comment)
    {
        $comment->status = 'rejected';
        $comment->save();
        return redirect()->route('admin.comments.index')->with('success', 'Komentar ditolak.');
    }
}
