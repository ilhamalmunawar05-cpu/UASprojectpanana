<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function index(Request $request)
    {
        $query = Artwork::with('artist');

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by artist
        if ($request->filled('artist_id')) {
            $query->where('artist_id', $request->artist_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->latest()->paginate(10);

        return view('admin.artworks.index', compact('items'));
    }

    public function create()
    {
        $artists = Artist::all();
        return view('admin.artworks.create', compact('artists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'medium' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,sold,on_display',
        ]);

        $data = $request->only(['title', 'artist_id', 'year', 'medium', 'dimensions', 'description', 'price', 'status']);

        // Convert empty strings to null for nullable integer/numeric fields
        foreach (['year', 'price'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('artworks', 'public');
        }

        Artwork::create($data);

        return redirect()->route('admin.artworks.index')
            ->with('success', 'Karya seni berhasil ditambahkan!');
    }

    public function show(Artwork $artwork)
    {
        $artwork->load('artist');
        return view('admin.artworks.show', compact('artwork'));
    }

    public function edit(Artwork $artwork)
    {
        $artists = Artist::all();
        return view('admin.artworks.edit', compact('artwork', 'artists'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'medium' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,sold,on_display',
        ]);

        $artwork = Artwork::findOrFail($id);
        $data = $request->only(['title', 'artist_id', 'year', 'medium', 'dimensions', 'description', 'price', 'status']);

        // Convert empty strings to null for nullable integer/numeric fields
        foreach (['year', 'price'] as $field) {
            if (isset($data[$field]) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($artwork->image) {
                Storage::disk('public')->delete($artwork->image);
            }
            $data['image'] = $request->file('image')->store('artworks', 'public');
        }

        $artwork->update($data);

        return redirect()->route('admin.artworks.index')
            ->with('success', 'Karya seni berhasil diupdate!');
    }

    public function destroy($id)
    {
        $artwork = Artwork::findOrFail($id);

        // Hapus gambar jika ada
        if ($artwork->image) {
            Storage::disk('public')->delete($artwork->image);
        }

        $artwork->delete();

        return redirect()->route('admin.artworks.index')
            ->with('success', 'Karya seni berhasil dihapus!');
    }
}
