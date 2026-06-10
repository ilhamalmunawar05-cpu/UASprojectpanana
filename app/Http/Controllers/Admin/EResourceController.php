<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super-admin|staff-admin');
    }

    public function index()
    {
        $resources = EResource::latest()->paginate(15);
        return view('admin.eresources.index', compact('resources'));
    }

    public function create()
    {
        return view('admin.eresources.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:ebook,journal,research_paper,multimedia,other',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,epub,doc,docx,zip|max:102400',
            'url' => 'nullable|url',
        ]);

        if (!isset($validated['file']) && !isset($validated['url'])) {
            return back()->withErrors(['error' => 'Silakan upload file atau masukkan URL.'])->withInput();
        }

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('eresources', 'public');
            unset($validated['file']);
        }

        $validated['uploaded_by'] = auth()->id();

        EResource::create($validated);

        return redirect()->route('admin.eresources.index')->with('success', 'E-Resource berhasil ditambahkan!');
    }

    public function edit(EResource $eresource)
    {
        return view('admin.eresources.edit', compact('eresource'));
    }

    public function update(Request $request, EResource $eresource)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:ebook,journal,research_paper,multimedia,other',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,epub,doc,docx,zip|max:102400',
            'url' => 'nullable|url',
        ]);

        if ($request->hasFile('file')) {
            if ($eresource->file_path) {
                Storage::disk('public')->delete($eresource->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('eresources', 'public');
            unset($validated['file']);
        }

        $eresource->update($validated);

        return redirect()->route('admin.eresources.index')->with('success', 'E-Resource berhasil diperbarui!');
    }

    public function destroy(EResource $eresource)
    {
        if ($eresource->file_path) {
            Storage::disk('public')->delete($eresource->file_path);
        }
        $eresource->delete();

        return redirect()->route('admin.eresources.index')->with('success', 'E-Resource berhasil dihapus!');
    }
}
