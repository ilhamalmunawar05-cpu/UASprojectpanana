<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|staff-admin');
    }

    public function index()
    {
        $artists = Artist::latest()->paginate(10);
        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        return view('admin.artists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('artists', 'public');
        }

        Artist::create($validated);
        return redirect()->route('admin.artists.index')->with('success', 'Seniman berhasil ditambahkan!');
    }

    public function show(Artist $artist)
    {
        $artist->load('artworks');
        return view('admin.artists.show', compact('artist'));
    }

    public function edit(Artist $artist)
    {
        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('image')) {
            if ($artist->image) Storage::disk('public')->delete($artist->image);
            $validated['image'] = $request->file('image')->store('artists', 'public');
        }

        $artist->update($validated);
        return redirect()->route('admin.artists.index')->with('success', 'Seniman berhasil diperbarui!');
    }

    public function destroy(Artist $artist)
    {
        if ($artist->image) Storage::disk('public')->delete($artist->image);
        $artist->delete();
        return redirect()->route('admin.artists.index')->with('success', 'Seniman berhasil dihapus!');
    }
}
