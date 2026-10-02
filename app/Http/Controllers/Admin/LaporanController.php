<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\MenuHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller{
    public function index(){
        $laporans = Laporan::with(['penulis', 'menuHarians'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        return view('admin.laporan.index', compact('laporans'));
    }

    public function create(){
        return view('admin.laporan.create');
    }

    public function store(Request $request){
        $validated = $request->validate([
            'judul'             => ['required', 'string', 'max:255'],
            'tanggal'           => ['required', 'date'],
            'isi'               => ['required', 'string'],
            'foto'              => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'items'             => ['nullable', 'array'],
            'items.*.nama_item' => ['required_with:items', 'string', 'max:100'],
            'items.*.takaran'   => ['required_with:items', 'string', 'max:30'],
            'items.*.energi'    => ['required_with:items', 'numeric', 'min:0'],
            'items.*.protein'   => ['required_with:items', 'numeric', 'min:0'],
            'items.*.lemak'     => ['required_with:items', 'numeric', 'min:0'],
            'items.*.karbo'     => ['required_with:items', 'numeric', 'min:0'],
            'items.*.serat'     => ['required_with:items', 'numeric', 'min:0'],
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Beri nama baru dengan ekstensi .jpg (hasil kompresi)
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.jpg';
            $fotoPath = 'laporan/' . $filename;

            // Simpan ke storage/app/public/laporan/
            $storageDir = storage_path('app/public/laporan/');
            if (!is_dir($storageDir)) @mkdir($storageDir, 0777, true);

            // Kompresi & resize otomatis menggunakan GD bawaan PHP (tanpa package tambahan)
            $sourcePath = $file->getRealPath();
            $mime       = $file->getMimeType();
            if ($mime === 'image/png') {
                $src = imagecreatefrompng($sourcePath);
            } elseif ($mime === 'image/webp') {
                $src = imagecreatefromwebp($sourcePath);
            } else {
                $src = imagecreatefromjpeg($sourcePath);
            }
            if ($src) {
                $origW = imagesx($src);
                $origH = imagesy($src);
                if ($origW > 1200) {
                    $newW = 1200;
                    $newH = (int) round($origH * 1200 / $origW);
                } else {
                    $newW = $origW;
                    $newH = $origH;
                }
                $canvas = imagecreatetruecolor($newW, $newH);
                imagecopyresampled($canvas, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                imagejpeg($canvas, $storageDir . $filename, 85);
                imagedestroy($src);
                imagedestroy($canvas);
            } else {
                // Fallback: simpan apa adanya
                $file->move($storageDir, $filename);
            }

            // Salin ke public/storage/laporan/ untuk akses statis di shared hosting
            $publicTarget = public_path('storage/' . $fotoPath);
            if (!is_dir(dirname($publicTarget))) @mkdir(dirname($publicTarget), 0777, true);
            @copy($storageDir . $filename, $publicTarget);
        }

        $laporan = Laporan::create([
            'judul'      => $request->judul,
            'tanggal'    => $request->tanggal,
            'isi'        => $request->isi,
            'foto'       => $fotoPath,
            'penulis_id' => Auth::id(),
        ]);

        // Simpan rincian item menu gizi jika diisi
        if ($request->filled('items') && is_array($request->items)) {
            $urutan = 1;
            foreach ($request->items as $item) {
                if (!empty(trim($item['nama_item'] ?? ''))) {
                    MenuHarian::create([
                        'laporan_id' => $laporan->id,
                        'tanggal'    => $laporan->tanggal,
                        'nama_item'  => $item['nama_item'],
                        'takaran'    => $item['takaran'] ?? '-',
                        'energi'     => $item['energi'] ?? 0,
                        'protein'    => $item['protein'] ?? 0,
                        'lemak'      => $item['lemak'] ?? 0,
                        'karbo'      => $item['karbo'] ?? 0,
                        'serat'      => $item['serat'] ?? 0,
                        'urutan'     => $urutan++,
                    ]);
                }
            }
        }

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan beserta foto dan rincian menu berhasil ditambahkan!');
    }

    public function edit(Laporan $laporan){
        $laporan->load('menuHarians');
        return view('admin.laporan.edit', compact('laporan'));
    }

    public function update(Request $request, Laporan $laporan){
        $validated = $request->validate([
            'judul'             => ['required', 'string', 'max:255'],
            'tanggal'           => ['required', 'date'],
            'isi'               => ['required', 'string'],
            'foto'              => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'items'             => ['nullable', 'array'],
            'items.*.nama_item' => ['required_with:items', 'string', 'max:100'],
            'items.*.takaran'   => ['required_with:items', 'string', 'max:30'],
            'items.*.energi'    => ['required_with:items', 'numeric', 'min:0'],
            'items.*.protein'   => ['required_with:items', 'numeric', 'min:0'],
            'items.*.lemak'     => ['required_with:items', 'numeric', 'min:0'],
            'items.*.karbo'     => ['required_with:items', 'numeric', 'min:0'],
            'items.*.serat'     => ['required_with:items', 'numeric', 'min:0'],
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($laporan->foto) {
                if (Storage::disk('public')->exists($laporan->foto)) {
                    Storage::disk('public')->delete($laporan->foto);
                }
                $oldPublic = public_path('storage/' . $laporan->foto);
                if (file_exists($oldPublic)) @unlink($oldPublic);
            }

            $file = $request->file('foto');
            // Beri nama baru dengan ekstensi .jpg (hasil kompresi)
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.jpg';
            $laporan->foto = 'laporan/' . $filename;

            // Simpan ke storage/app/public/laporan/
            $storageDir = storage_path('app/public/laporan/');
            if (!is_dir($storageDir)) @mkdir($storageDir, 0777, true);

            // Kompresi & resize otomatis menggunakan GD bawaan PHP (tanpa package tambahan)
            $sourcePath = $file->getRealPath();
            $mime       = $file->getMimeType();
            if ($mime === 'image/png') {
                $src = imagecreatefrompng($sourcePath);
            } elseif ($mime === 'image/webp') {
                $src = imagecreatefromwebp($sourcePath);
            } else {
                $src = imagecreatefromjpeg($sourcePath);
            }
            if ($src) {
                $origW = imagesx($src);
                $origH = imagesy($src);
                if ($origW > 1200) {
                    $newW = 1200;
                    $newH = (int) round($origH * 1200 / $origW);
                } else {
                    $newW = $origW;
                    $newH = $origH;
                }
                $canvas = imagecreatetruecolor($newW, $newH);
                imagecopyresampled($canvas, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                imagejpeg($canvas, $storageDir . $filename, 85);
                imagedestroy($src);
                imagedestroy($canvas);
            } else {
                // Fallback: simpan apa adanya
                $file->move($storageDir, $filename);
            }

            // Salin ke public/storage/laporan/ untuk akses statis di shared hosting
            $publicTarget = public_path('storage/' . $laporan->foto);
            if (!is_dir(dirname($publicTarget))) @mkdir(dirname($publicTarget), 0777, true);
            @copy($storageDir . $filename, $publicTarget);
        }
        $laporan->judul   = $request->judul;
        $laporan->tanggal = $request->tanggal;
        $laporan->isi     = $request->isi;
        $laporan->save();

        // Perbarui rincian item menu gizi (replace mode untuk laporan ini)
        MenuHarian::where('laporan_id', $laporan->id)->delete();

        if ($request->filled('items') && is_array($request->items)) {
            $urutan = 1;
            foreach ($request->items as $item) {
                if (!empty(trim($item['nama_item'] ?? ''))) {
                    MenuHarian::create([
                        'laporan_id' => $laporan->id,
                        'tanggal'    => $laporan->tanggal,
                        'nama_item'  => $item['nama_item'],
                        'takaran'    => $item['takaran'] ?? '-',
                        'energi'     => $item['energi'] ?? 0,
                        'protein'    => $item['protein'] ?? 0,
                        'lemak'      => $item['lemak'] ?? 0,
                        'karbo'      => $item['karbo'] ?? 0,
                        'serat'      => $item['serat'] ?? 0,
                        'urutan'     => $urutan++,
                    ]);
                }
            }
        }
        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil diperbarui!');
    }
    public function destroy(Laporan $laporan){
        if ($laporan->foto) {
            if (Storage::disk('public')->exists($laporan->foto)) {
                Storage::disk('public')->delete($laporan->foto);
            }
            $oldPublic = public_path('storage/' . $laporan->foto);
            if (file_exists($oldPublic)) {
                @unlink($oldPublic);
            }
        }
        $laporan->delete();
        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }
}