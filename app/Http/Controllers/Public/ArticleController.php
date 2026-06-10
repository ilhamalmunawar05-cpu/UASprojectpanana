<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $items = Article::with('author')->where('is_published', true)->orderBy('created_at', 'desc')->paginate(12);
        return view('public.articles.index', compact('items'));
    }

    public function show($id)
    {
        $article = Article::with(['author', 'artwork'])->findOrFail($id);
        return view('public.articles.show', compact('article'));
    }
}
