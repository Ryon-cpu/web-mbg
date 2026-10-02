<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuHarian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MenuHarianController extends Controller
{
    /**
     * Daftar tanggal yang sudah memiliki menu + filter tanggal/bulan.
     */
    public function index(Request $request)
    {
        $query = MenuHarian::select('tanggal')
            ->selectRaw('COUNT(*) as jumlah_item')
            ->selectRaw('SUM(energi) as total_energi')
            ->groupBy('tanggal')
            ->orderByDesc('tanggal');

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('bulan')) {
            $query->where('tanggal', 'like', $request->bulan . '%');
        }

        $daftarMenu = $query->paginate(15)->withQueryString();

        return view('admin.menu.index', compact('daftarMenu'));
    }

    /**
     * Tampilkan detail rincian menu gizi untuk tanggal tertentu.
     */
    public function show(string $tanggal)
    {
        try {
            $tgl = Carbon::parse($tanggal)->format('Y-m-d');
        } catch (\Exception $e) {
            abort(404);
        }

        $items = MenuHarian::whereDate('tanggal', $tgl)->orderBy('urutan')->get();

        if ($items->isEmpty()) {
            abort(404, 'Menu untuk tanggal ini tidak ditemukan.');
        }

        $totalEnergi  = $items->sum('energi');
        $totalProtein = $items->sum('protein');
        $totalLemak   = $items->sum('lemak');
        $totalKarbo   = $items->sum('karbo');
        $totalSerat   = $items->sum('serat');

        return view('admin.menu.show', compact(
            'items', 'tgl', 'totalEnergi', 'totalProtein', 'totalLemak', 'totalKarbo', 'totalSerat'
        ));
    }

    /**
     * Form tambah menu untuk sebuah tanggal baru.
     */
    public function create()
    {
        return view('admin.menu.create');
    }

    /**
     * Simpan menu baru (bisa multi-item untuk satu tanggal).
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'          => ['required', 'date'],
            'items'            => ['required', 'array', 'min:1'],
            'items.*.nama_item'=> ['required', 'string', 'max:100'],
            'items.*.takaran'  => ['required', 'string', 'max:30'],
            'items.*.energi'   => ['required', 'numeric', 'min:0'],
            'items.*.protein'  => ['required', 'numeric', 'min:0'],
            'items.*.lemak'    => ['required', 'numeric', 'min:0'],
            'items.*.karbo'    => ['required', 'numeric', 'min:0'],
            'items.*.serat'    => ['required', 'numeric', 'min:0'],
        ]);

        // Hapus menu lama untuk tanggal ini (replace mode)
        MenuHarian::whereDate('tanggal', $request->tanggal)->delete();

        $urutan = 1;
        foreach ($request->items as $item) {
            MenuHarian::create([
                'tanggal'   => $request->tanggal,
                'nama_item' => $item['nama_item'],
                'takaran'   => $item['takaran'],
                'energi'    => $item['energi'],
                'protein'   => $item['protein'],
                'lemak'     => $item['lemak'],
                'karbo'     => $item['karbo'],
                'serat'     => $item['serat'],
                'urutan'    => $urutan++,
            ]);
        }

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu tanggal ' . Carbon::parse($request->tanggal)->translatedFormat('d F Y') . ' berhasil disimpan!');
    }

    /**
     * Form edit menu untuk tanggal tertentu.
     */
    public function edit(string $tanggal)
    {
        try {
            $tgl = Carbon::parse($tanggal)->format('Y-m-d');
        } catch (\Exception $e) {
            abort(404);
        }

        $items = MenuHarian::whereDate('tanggal', $tgl)->orderBy('urutan')->get();

        if ($items->isEmpty()) {
            abort(404, 'Menu untuk tanggal ini tidak ditemukan.');
        }

        return view('admin.menu.edit', compact('items', 'tgl'));
    }

    /**
     * Update menu untuk tanggal tertentu (replace all items).
     */
    public function update(Request $request, string $tanggal)
    {
        try {
            $tgl = Carbon::parse($tanggal)->format('Y-m-d');
        } catch (\Exception $e) {
            abort(404);
        }

        $request->validate([
            'items'            => ['required', 'array', 'min:1'],
            'items.*.nama_item'=> ['required', 'string', 'max:100'],
            'items.*.takaran'  => ['required', 'string', 'max:30'],
            'items.*.energi'   => ['required', 'numeric', 'min:0'],
            'items.*.protein'  => ['required', 'numeric', 'min:0'],
            'items.*.lemak'    => ['required', 'numeric', 'min:0'],
            'items.*.karbo'    => ['required', 'numeric', 'min:0'],
            'items.*.serat'    => ['required', 'numeric', 'min:0'],
        ]);

        // Replace semua item untuk tanggal ini
        MenuHarian::whereDate('tanggal', $tgl)->delete();

        $urutan = 1;
        foreach ($request->items as $item) {
            MenuHarian::create([
                'tanggal'   => $tgl,
                'nama_item' => $item['nama_item'],
                'takaran'   => $item['takaran'],
                'energi'    => $item['energi'],
                'protein'   => $item['protein'],
                'lemak'     => $item['lemak'],
                'karbo'     => $item['karbo'],
                'serat'     => $item['serat'],
                'urutan'    => $urutan++,
            ]);
        }

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu tanggal ' . Carbon::parse($tgl)->translatedFormat('d F Y') . ' berhasil diperbarui!');
    }

    /**
     * Hapus semua menu untuk tanggal tertentu.
     */
    public function destroy(string $tanggal)
    {
        try {
            $tgl = Carbon::parse($tanggal)->format('Y-m-d');
        } catch (\Exception $e) {
            abort(404);
        }

        $deleted = MenuHarian::whereDate('tanggal', $tgl)->delete();

        if (!$deleted) {
            return back()->with('error', 'Data menu tidak ditemukan.');
        }

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu tanggal ' . Carbon::parse($tgl)->translatedFormat('d F Y') . ' berhasil dihapus.');
    }
}
