<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|staff-admin');
    }

    public function index()
    {
        $articles = Article::with('author')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $artworks = Artwork::all();
        return view('admin.articles.create', compact('artworks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'artwork_id' => 'nullable|exists:artworks,id',
            'category' => 'required|in:kritik,ulasan,berita,tutorial',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['author_id'] = auth()->id();

        // Handle empty artwork_id
        if (empty($validated['artwork_id'])) {
            $validated['artwork_id'] = null;
        }

        // Handle is_published checkbox
        $validated['is_published'] = $request->has('is_published') ? true : false;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat!');
    }

    public function show(Article $article)
    {
        $article->load('author', 'artwork');
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $artworks = Artwork::all();
        return view('admin.articles.edit', compact('article', 'artworks'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'artwork_id' => 'nullable|exists:artworks,id',
            'category' => 'required|in:kritik,ulasan,berita,tutorial',
            'is_published' => 'nullable|boolean',
        ]);

        // Handle empty artwork_id
        if (empty($validated['artwork_id'])) {
            $validated['artwork_id'] = null;
        }

        // Handle is_published checkbox
        $validated['is_published'] = $request->has('is_published') ? true : false;

        if ($request->hasFile('image')) {
            if ($article->image) Storage::disk('public')->delete($article->image);
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        if ($article->image) Storage::disk('public')->delete($article->image);
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
