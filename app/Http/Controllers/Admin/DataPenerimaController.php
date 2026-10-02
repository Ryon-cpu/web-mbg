<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataPenerima;
use Illuminate\Http\Request;

class DataPenerimaController extends Controller{
    public function index(Request $request){
        $query = DataPenerima::query();
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where('nama_sekolah', 'like', "%{$cari}%")
                  ->orWhere('alamat', 'like', "%{$cari}%");
        }
        $data_penerima = $query->orderBy('tanggal_distribusi', 'desc')->paginate(10)->withQueryString();
        $total_penerima = DataPenerima::sum('jumlah_penerima');
        return view('admin.data.index', compact('data_penerima', 'total_penerima'));
    }
    public function create(){
        return view('admin.data.create');
    }
    public function store(Request $request){
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'jumlah_penerima' => ['required', 'integer', 'min:1'],
            'tanggal_distribusi' => ['required', 'date'],
        ]);
        DataPenerima::create($validated);
        return redirect()->route('admin.data.index')->with('success', 'Data penerima berhasil ditambahkan!');
    }
    public function edit(DataPenerima $data){
        return view('admin.data.edit', compact('data'));
    }
    public function update(Request $request, DataPenerima $data){
        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'jumlah_penerima' => ['required', 'integer', 'min:1'],
            'tanggal_distribusi' => ['required', 'date'],
        ]);
        $data->update($validated);
        return redirect()->route('admin.data.index')->with('success', 'Data penerima berhasil diperbarui!');
    }
    public function destroy(DataPenerima $data){
        $data->delete();
        return redirect()->route('admin.data.index')->with('success', 'Data penerima berhasil dihapus!');
    }
}