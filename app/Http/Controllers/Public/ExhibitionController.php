<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Exhibition;

class ExhibitionController extends Controller
{
    public function index()
    {
        $items = Exhibition::orderBy('start_date', 'desc')->paginate(12);
        return view('public.exhibitions.index', compact('items'));
    }

    public function show($id)
    {
        $exhibition = Exhibition::with('artworks')->findOrFail($id);
        return view('public.exhibitions.show', compact('exhibition'));
    }
}
