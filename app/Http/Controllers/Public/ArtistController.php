<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artist;

class ArtistController extends Controller
{
    public function index()
    {
        $items = Artist::paginate(12);
        return view('public.artists.index', compact('items'));
    }

    public function show($id)
    {
        $artist = Artist::with('artworks')->findOrFail($id);
        return view('public.artists.show', compact('artist'));
    }
}
