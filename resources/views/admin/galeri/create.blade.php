@extends('layouts.admin')

@section('title', 'Unggah Dokumentasi Penyaluran')
@section('page_title', 'Unggah Dokumentasi Baru')
@section('page_subtitle', 'Tambahkan bukti kedatangan di madrasah/sekolah dan foto sajian menu MBG')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="judul" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Keterangan Dokumentasi / Lokasi <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Dokumentasi Kedatangan & Menu MBG di MI Al-Hidayah" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
                <p class="text-xs text-slate-400 mt-1">Tuliskan nama madrasah/sekolah, waktu tiba, atau deskripsi foto menu.</p>
            </div>
            <div>
                <label for="foto" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Foto Bukti Dokumentasi <span class="text-rose-500">*</span>
                </label>
                <input type="file" id="foto" name="foto" required accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
                <p class="text-xs text-slate-400 mt-1.5">Foto serah terima di madrasah atau foto porsi menu makanan. Maksimal 5MB.</p>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-xs transition">
                    <i class="fa-solid fa-cloud-arrow-up mr-1.5"></i> Unggah Foto
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection