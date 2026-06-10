<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Artwork;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|staff-admin');
    }

    public function index()
    {
        $auctions = Auction::with('artwork')->latest()->paginate(10);
        return view('admin.auctions.index', compact('auctions'));
    }

    public function create()
    {
        $artworks = Artwork::where('status', 'available')->get();
        return view('admin.auctions.create', compact('artworks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'starting_bid' => 'required|numeric|min:0',
            'status' => 'required|in:active,ended,cancelled',
        ]);

        Auction::create($validated);
        return redirect()->route('admin.auctions.index')->with('success', 'Lelang berhasil ditambahkan!');
    }

    public function show(Auction $auction)
    {
        $auction->load('artwork.artist', 'bids.user');
        return view('admin.auctions.show', compact('auction'));
    }

    public function edit(Auction $auction)
    {
        $artworks = Artwork::all();
        return view('admin.auctions.edit', compact('auction', 'artworks'));
    }

    public function update(Request $request, Auction $auction)
    {
        $validated = $request->validate([
            'artwork_id' => 'required|exists:artworks,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'starting_bid' => 'required|numeric|min:0',
            'status' => 'required|in:active,ended,cancelled',
        ]);

        $auction->update($validated);
        return redirect()->route('admin.auctions.index')->with('success', 'Lelang berhasil diperbarui!');
    }

    public function destroy(Auction $auction)
    {
        $auction->delete();
        return redirect()->route('admin.auctions.index')->with('success', 'Lelang berhasil dihapus!');
    }
}

// Public Controller: app/Http/Controllers/AuctionPublicController.php
namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;

class AuctionPublicController extends Controller
{
    public function index()
    {
        $auctions = Auction::where('status', 'active')
            ->with('artwork.artist')
            ->latest()
            ->paginate(9);
        return view('public.auctions.index', compact('auctions'));
    }

    public function show(Auction $auction)
    {
        $auction->load('artwork.artist', 'bids.user');
        return view('public.auctions.show', compact('auction'));
    }

    public function bid(Request $request, Auction $auction)
    {
        $request->validate([
            'bid_amount' => 'required|numeric|min:' . ($auction->current_bid ?? $auction->starting_bid),
        ]);

        if (!$auction->isActive()) {
            return back()->with('error', 'Lelang sudah berakhir atau tidak aktif!');
        }

        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => auth()->id(),
            'bid_amount' => $request->bid_amount,
        ]);

        $auction->update([
            'current_bid' => $request->bid_amount,
            'winner_id' => auth()->id(),
        ]);

        return back()->with('success', 'Bid berhasil ditempatkan!');
    }
}
