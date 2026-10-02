<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller{
    public function index(){
        $galeris = Galeri::with('laporan')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('admin.galeri.index', compact('galeris'));
    }
    public function create(){
        $laporans = Laporan::orderBy('judul')->get();
        return view('admin.galeri.create', compact('laporans'));
    }
    public function store(Request $request){
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'foto' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'laporan_id' => ['nullable', 'exists:laporan,id'],
        ]);
        $file = $request->file('foto');
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9.\-]/', '_', $file->getClientOriginalName());
        $filePath = $file->storeAs('galeri', $filename, 'public');
        
        // Salin langsung ke public/storage/galeri untuk akses statis di shared hosting
        $publicTarget = public_path('storage/' . $filePath);
        if (!is_dir(dirname($publicTarget))) {
            @mkdir(dirname($publicTarget), 0777, true);
        }
        @copy(storage_path('app/public/' . $filePath), $publicTarget);

        Galeri::create([
            'judul' => $validated['judul'],
            'file_path' => $filePath,
            'laporan_id' => $validated['laporan_id'] ?? null,
        ]);
        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil diunggah!');
    }
    public function destroy(Galeri $galeri){
        if ($galeri->file_path) {
            if (Storage::disk('public')->exists($galeri->file_path)) {
                Storage::disk('public')->delete($galeri->file_path);
            }
            $oldPublic = public_path('storage/' . $galeri->file_path);
            if (file_exists($oldPublic)) {
                @unlink($oldPublic);
            }
        }
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil dihapus!');
    }
}