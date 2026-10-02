@extends('layouts.admin')

@section('title', 'Kelola Dokumentasi Galeri')
@section('page_title', 'Kelola Dokumentasi Lapangan')
@section('page_subtitle', 'Dokumentasi bukti kedatangan di madrasah/sekolah dan foto menu MBG')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-6 border-b border-slate-100">
        <div>
            <h3 class="font-bold text-slate-800 text-base">Koleksi Dokumentasi MBG</h3>
            <p class="text-xs text-slate-500">Total terunggah: {{ $galeris->total() }} foto dokumentasi</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition">
            <i class="fa-solid fa-cloud-arrow-up"></i> Unggah Dokumentasi Baru
        </a>
    </div>
    <!--grid foto-->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($galeris as $foto)
            <div class="bg-slate-50 rounded-2xl overflow-hidden border border-slate-200 shadow-xs group flex flex-col justify-between">
                <div class="aspect-square w-full overflow-hidden bg-slate-200 relative">
                    <img src="{{ url('media/' . $foto->file_path) }}" alt="{{ $foto->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-sm text-slate-800 line-clamp-1 mb-1">{{ $foto->judul }}</h4>
                    @if ($foto->laporan)
                        <p class="text-xs text-emerald-600 mb-2 truncate">
                            <i class="fa-solid fa-link text-3xs"></i> {{ $foto->laporan->judul }}
                        </p>
                    @endif
                    <div class="flex items-center justify-between pt-2 border-t border-slate-200/60">
                        <span class="text-2xs text-slate-400">{{ $foto->created_at->translatedFormat('d M Y') }}</span>
                        <form action="{{ route('admin.galeri.destroy', $foto->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini secara permanen dari server?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-semibold p-1" title="Hapus Foto">
                                <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-4 py-16 text-center text-slate-400">
                <i class="fa-solid fa-images text-4xl mb-3"></i>
                <p class="text-sm">Belum ada foto yang diunggah.</p>
            </div>
        @endforelse
    </div>
    @if ($galeris->hasPages())
        <div class="mt-8 pt-6 border-t border-slate-100">
            {{ $galeris->links() }}
        </div>
    @endif
</div>
@endsection