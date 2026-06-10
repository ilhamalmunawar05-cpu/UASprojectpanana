<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;

class MuseumController extends Controller
{
    public function index()
    {
        $items = Collection::paginate(12);
        return view('public.museum.index', compact('items'));
    }

    public function show($id)
    {
        $collection = Collection::findOrFail($id);
        return view('public.museum.show', compact('collection'));
    }
}
