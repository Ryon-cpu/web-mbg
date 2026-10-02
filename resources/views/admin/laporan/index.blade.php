@extends('layouts.admin')

@section('title', 'Kelola Laporan')
@section('page_title', 'Kelola Laporan Kegiatan')
@section('page_subtitle', 'Daftar dokumentasi laporan penyaluran MBG')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
    <!--header card-->
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-800 text-base">Semua Laporan MBG</h3>
            <p class="text-xs text-slate-500">Total terdata: {{ $laporans->total() }} laporan</p>
        </div>
        <a href="{{ route('admin.laporan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition">
            <i class="fa-solid fa-plus"></i> Tambah Laporan
        </a>
    </div>
    <!--table-->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                <tr>
                    <th class="py-4 px-6">No</th>
                    <th class="py-4 px-6">Judul Laporan</th>
                    <th class="py-4 px-6">Tanggal</th>
                    <th class="py-4 px-6">Penulis</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($laporans as $index => $laporan)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 text-slate-400 font-mono text-xs">
                            {{ $laporans->firstItem() + $index }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                @if ($laporan->foto)
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 border border-slate-200">
                                        <img src="{{ url('media/' . $laporan->foto) }}" alt="Foto" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0 text-slate-400">
                                        <i class="fa-solid fa-image text-sm"></i>
                                    </div>
                                @endif
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $laporan->judul }}</span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        @if ($laporan->menuHarians && $laporan->menuHarians->count() > 0)
                                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                                <i class="fa-solid fa-bowl-food text-[10px]"></i> {{ $laporan->menuHarians->count() }} item &bull; {{ number_format($laporan->menuHarians->sum('energi'), 0) }} kkal
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600 whitespace-nowrap">
                            <i class="fa-regular fa-calendar text-slate-400 mr-1"></i>
                            {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">
                            {{ $laporan->penulis->nama ?? 'Admin' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('laporan.detail', $laporan->id) }}" target="_blank" class="p-2 rounded-xl bg-slate-100 hover:bg-emerald-100 text-slate-600 hover:text-emerald-700 text-xs font-semibold transition" title="Lihat di Web">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                                <a href="{{ route('admin.laporan.edit', $laporan->id) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-amber-100 text-slate-600 hover:text-amber-700 text-xs font-semibold transition" title="Edit Laporan">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-rose-100 text-slate-600 hover:text-rose-700 text-xs font-semibold transition" title="Hapus Laporan">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                            <p>Belum ada data laporan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($laporans->hasPages())
        <div class="p-6 border-t border-slate-100">
            {{ $laporans->links() }}
        </div>
    @endif
</div>
@endsection