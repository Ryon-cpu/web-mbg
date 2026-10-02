<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller{
    public function index(){
        $beritas = Berita::orderBy('tanggal_publish', 'desc')->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }
    public function create(){
        return view('admin.berita.create');
    }
    public function store(Request $request){
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'tanggal_publish' => ['required', 'date'],
            'status' => ['required', 'in:draft,publish'],
        ]);
        $file = $request->file('thumbnail');
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9.\-]/', '_', $file->getClientOriginalName());
        $validated['thumbnail'] = $file->storeAs('berita', $filename, 'public');
        Berita::create($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan!');
    }
    public function edit(Berita $berita){
        return view('admin.berita.edit', compact('berita'));
    }
    public function update(Request $request, Berita $berita){
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'tanggal_publish' => ['required', 'date'],
            'status' => ['required', 'in:draft,publish'],
        ]);
        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
                Storage::disk('public')->delete($berita->thumbnail);
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9.\-]/', '_', $file->getClientOriginalName());
            $validated['thumbnail'] = $file->storeAs('berita', $filename, 'public');
        } else {
            unset($validated['thumbnail']);
        }
        $berita->update($validated);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }
    public function destroy(Berita $berita){
        if ($berita->thumbnail && Storage::disk('public')->exists($berita->thumbnail)) {
            Storage::disk('public')->delete($berita->thumbnail);
        }
        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}