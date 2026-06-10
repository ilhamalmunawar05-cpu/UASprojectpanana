<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index()
    {
        $items = Auction::with('artwork')
            ->where('status', 'active')
            ->orderBy('end_date', 'asc')
            ->paginate(12);
        return view('public.auctions.index', compact('items'));
    }

    public function show($id)
    {
        $auction = Auction::with(['artwork', 'bids.user'])
            ->findOrFail($id);
        return view('public.auctions.show', compact('auction'));
    }

    public function bid(Request $request, $auction)
    {
        $request->validate([
            'bid_amount' => 'required|numeric|min:0'
        ]);

        $auction = Auction::findOrFail($auction);

        // Validasi bid amount harus lebih tinggi dari current bid
        if ($request->bid_amount <= $auction->current_bid) {
            return back()->with('error', 'Bid amount must be higher than current bid.');
        }

        // Simpan bid
        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => auth()->id(),
            'bid_amount' => $request->bid_amount,
        ]);

        // Update current bid di auction
        $auction->update([
            'current_bid' => $request->bid_amount,
        ]);

        return back()->with('success', 'Your bid has been placed successfully!');
    }
}
