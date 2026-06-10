<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|staff-admin');
    }

    public function index()
    {
        $collections = Collection::latest()->paginate(10);
        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.collections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'year' => 'nullable|integer|min:0|max:' . date('Y'),
            'origin' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'collection_number' => 'nullable|string|max:255|unique:collections',
            'category' => 'required|in:lukisan,patung,tekstil,keramik,lainnya',
        ]);

        // Convert empty strings to null for nullable integer fields
        if (isset($validated['year']) && $validated['year'] === '') {
            $validated['year'] = null;
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('collections', 'public');
        }

        Collection::create($validated);
        return redirect()->route('admin.collections.index')->with('success', 'Koleksi berhasil ditambahkan!');
    }

    public function show(Collection $collection)
    {
        return view('admin.collections.show', compact('collection'));
    }

    public function edit(Collection $collection)
    {
        return view('admin.collections.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'year' => 'nullable|integer|min:0|max:' . date('Y'),
            'origin' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'dimensions' => 'nullable|string|max:255',
            'collection_number' => 'nullable|string|max:255|unique:collections,collection_number,' . $collection->id,
            'category' => 'required|in:lukisan,patung,tekstil,keramik,lainnya',
        ]);

        // Convert empty strings to null for nullable integer fields
        if (isset($validated['year']) && $validated['year'] === '') {
            $validated['year'] = null;
        }

        if ($request->hasFile('image')) {
            if ($collection->image) Storage::disk('public')->delete($collection->image);
            $validated['image'] = $request->file('image')->store('collections', 'public');
        }

        $collection->update($validated);
        return redirect()->route('admin.collections.index')->with('success', 'Koleksi berhasil diperbarui!');
    }

    public function destroy(Collection $collection)
    {
        if ($collection->image) Storage::disk('public')->delete($collection->image);
        $collection->delete();
        return redirect()->route('admin.collections.index')->with('success', 'Koleksi berhasil dihapus!');
    }
}
