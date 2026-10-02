@extends('layouts.admin')

@section('title', 'Tambah Data Penerima')
@section('page_title', 'Tambah Data Sekolah Penerima')
@section('page_subtitle', 'Masukkan data sasaran distribusi program MBG')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.data.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="nama_sekolah" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Nama Sekolah Sasaran <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required placeholder="Contoh: SDN 05 Pagi Jakarta Pusat" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
            </div>
            <div>
                <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Alamat Lengkap Sekolah <span class="text-rose-500">*</span>
                </label>
                <textarea id="alamat" name="alamat" rows="3" required placeholder="Jl. Sudirman No. 12, Kelurahan..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">{{ old('alamat') }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="jumlah_penerima" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Jumlah Siswa Penerima <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" id="jumlah_penerima" name="jumlah_penerima" value="{{ old('jumlah_penerima') }}" required min="1" placeholder="Contoh: 350" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
                </div>
                <div>
                    <label for="tanggal_distribusi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Tanggal Distribusi <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="tanggal_distribusi" name="tanggal_distribusi" value="{{ old('tanggal_distribusi', date('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-xs transition">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Data
                </button>
                <a href="{{ route('admin.data.index') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection