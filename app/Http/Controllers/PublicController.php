<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\DataPenerima;
use App\Models\Galeri;
use App\Models\Laporan;
use App\Models\MenuHarian;
use Illuminate\Http\Request;

class PublicController extends Controller{
    public function index(Request $request){
        $stats = [
            'total_penerima' => DataPenerima::sum('jumlah_penerima'),
            'total_sekolah' => DataPenerima::count(),
            'total_laporan' => Laporan::count(),
            'total_berita' => Berita::where('status', 'publish')->count(),
            'total_galeri' => Galeri::count(),
        ];
        $berita_terbaru = Berita::where('status', 'publish')
            ->orderBy('tanggal_publish', 'desc')
            ->take(3)
            ->get();
        $laporan_terbaru = Laporan::with('penulis')
            ->orderBy('tanggal', 'desc')
            ->take(3)
            ->get();
        $galeri_terbaru = Galeri::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Tanggal yang dipilih (default hari ini)
        $tanggalPilih = $request->filled('tanggal') ? $request->tanggal : today()->toDateString();

        // Laporan distribusi pada tanggal terpilih
        $laporanHariIni = Laporan::with('menuHarians')
            ->whereDate('tanggal', $tanggalPilih)
            ->latest()
            ->first();

        // Menu gizi untuk tanggal yang dipilih (prioritas dari laporan hari itu)
        $menuHariIni = ($laporanHariIni && $laporanHariIni->menuHarians->isNotEmpty())
            ? $laporanHariIni->menuHarians
            : MenuHarian::whereDate('tanggal', $tanggalPilih)->orderBy('urutan')->get();

        return view('publik.beranda', compact(
            'stats', 'berita_terbaru', 'laporan_terbaru', 'galeri_terbaru', 'menuHariIni', 'tanggalPilih', 'laporanHariIni'
        ));
    }

    public function laporan(Request $request){
        $tanggal = $request->filled('tanggal') ? $request->tanggal : null;

        $query = Laporan::with(['penulis', 'galeri', 'menuHarians'])->orderBy('tanggal', 'desc');

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        $laporans = $query->paginate(9)->withQueryString();

        $quickDates = [
            ['label' => 'Hari Ini',      'date' => today()->toDateString()],
            ['label' => 'Kemarin',       'date' => today()->subDay()->toDateString()],
            ['label' => 'Kemarin Lusa',  'date' => today()->subDays(2)->toDateString()],
        ];

        return view('publik.laporan', compact('laporans', 'tanggal', 'quickDates'));
    }

    /** Tampilkan detail laporan MBG
     *
     * @param int|string $id
     */
    public function laporanDetail(int|string $id){
        $laporan = Laporan::with(['penulis', 'galeri', 'menuHarians'])->findOrFail($id);
        return view('publik.laporan_detail', compact('laporan'));
    }
    public function galeri(Request $request){
        $tanggal = $request->filled('tanggal') ? $request->tanggal : null;

        $query = Galeri::with(['laporan.menuHarians', 'laporan.penulis'])
            ->orderBy('created_at', 'desc');

        if ($tanggal) {
            $query->whereDate('created_at', $tanggal);
        }

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhereHas('laporan', function ($lq) use ($cari) {
                      $lq->where('judul', 'like', "%{$cari}%");
                  });
            });
        }

        $galeris = $query->paginate(12)->withQueryString();
        $total_foto = Galeri::count();

        $quickDates = [
            ['label' => 'Hari Ini',      'date' => today()->toDateString()],
            ['label' => 'Kemarin',       'date' => today()->subDay()->toDateString()],
            ['label' => 'Kemarin Lusa',  'date' => today()->subDays(2)->toDateString()],
        ];

        return view('publik.galeri', compact('galeris', 'total_foto', 'tanggal', 'quickDates'));
    }
    public function data(Request $request){
        $query = DataPenerima::query();
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama_sekolah', 'like', "%{$cari}%")
                  ->orWhere('alamat', 'like', "%{$cari}%");
            });
        }
        $data_penerima = $query->orderBy('tanggal_distribusi', 'desc')->paginate(10)->withQueryString();
        $total_penerima = DataPenerima::sum('jumlah_penerima');
        $total_sekolah = DataPenerima::count();
        return view('publik.data', compact('data_penerima', 'total_penerima', 'total_sekolah'));
    }
    public function berita(){
        $beritas = Berita::where('status', 'publish')
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(6);
        return view('publik.berita', compact('beritas'));
    }
    /**
     * Tampilkan detail berita MBG
     *
     * @param int|string $id
     */
    public function beritaDetail(int|string $id){
        $berita = Berita::where('status', 'publish')->findOrFail($id);
        $berita_lainnya = Berita::where('status', 'publish')
            ->where('id', '!=', $id)
            ->orderBy('tanggal_publish', 'desc')
            ->take(3)
            ->get();
        return view('publik.berita_detail', compact('berita', 'berita_lainnya'));
    }
}