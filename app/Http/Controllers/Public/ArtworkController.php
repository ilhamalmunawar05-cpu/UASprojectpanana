<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Auction;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function index()
    {
        $items = Artwork::with('artist')->paginate(12);
        return view('public.artwork.index', compact('items'));
    }

    public function show($id)
    {
        $artwork = Artwork::with('artist')->findOrFail($id);

        // Check if artwork has active auction
        $auction = Auction::where('artwork_id', $artwork->id)
            ->where('status', 'active')
            ->first();

        // Get related artworks from the same artist
        $relatedArtworks = Artwork::where('artist_id', $artwork->artist_id)
            ->where('id', '!=', $artwork->id)
            ->limit(4)
            ->get();

        return view('public.artwork.show', compact('artwork', 'auction', 'relatedArtworks'));
    }
}
