<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exhibition;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExhibitionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|staff-admin');
    }

    public function index()
    {
        $exhibitions = Exhibition::latest()->paginate(10);
        return view('admin.exhibitions.index', compact('exhibitions'));
    }

    public function create()
    {
        $artworks = Artwork::all();
        return view('admin.exhibitions.create', compact('artworks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:upcoming,ongoing,completed',
            'artworks' => 'nullable|array',
            'artworks.*' => 'exists:artworks,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('exhibitions', 'public');
        }

        $exhibition = Exhibition::create($validated);

        if ($request->has('artworks')) {
            $exhibition->artworks()->sync($request->artworks);
        }

        return redirect()->route('admin.exhibitions.index')->with('success', 'Pameran berhasil ditambahkan!');
    }

    public function show(Exhibition $exhibition)
    {
        $exhibition->load('artworks');
        return view('admin.exhibitions.show', compact('exhibition'));
    }

    public function edit(Exhibition $exhibition)
    {
        $artworks = Artwork::all();
        $exhibition->load('artworks');
        return view('admin.exhibitions.edit', compact('exhibition', 'artworks'));
    }

    public function update(Request $request, Exhibition $exhibition)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:upcoming,ongoing,completed',
            'artworks' => 'nullable|array',
            'artworks.*' => 'exists:artworks,id',
        ]);

        if ($request->hasFile('image')) {
            if ($exhibition->image) Storage::disk('public')->delete($exhibition->image);
            $validated['image'] = $request->file('image')->store('exhibitions', 'public');
        }

        $exhibition->update($validated);

        if ($request->has('artworks')) {
            $exhibition->artworks()->sync($request->artworks);
        }

        return redirect()->route('admin.exhibitions.index')->with('success', 'Pameran berhasil diperbarui!');
    }

    public function destroy(Exhibition $exhibition)
    {
        if ($exhibition->image) Storage::disk('public')->delete($exhibition->image);
        $exhibition->delete();
        return redirect()->route('admin.exhibitions.index')->with('success', 'Pameran berhasil dihapus!');
    }
}
