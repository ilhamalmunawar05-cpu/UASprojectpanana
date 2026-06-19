<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\EResource;

class EResourceController extends Controller
{
    public function index()
    {
        $resources = EResource::latest()->paginate(12);

        return view('public.eresources.index', compact('resources'));
    }
}
