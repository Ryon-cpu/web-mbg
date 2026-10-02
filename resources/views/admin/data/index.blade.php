@extends('layouts.admin')

@section('title', 'Kelola Data Penerima')
@section('page_title', 'Data Sekolah Penerima MBG')
@section('page_subtitle', 'Kelola daftar sekolah dan kuota siswa penerima makanan bergizi')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
    <!--header card with search-->
    <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-800 text-base">Semua Data Penerima</h3>
            <p class="text-xs text-slate-500">Total akumulasi porsi: <strong class="text-emerald-700 font-bold">{{ number_format($total_penerima) }} siswa</strong></p>
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-3">
            <form action="{{ route('admin.data.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari sekolah/alamat..." class="px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30">
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-800 text-white text-xs font-semibold hover:bg-slate-700">Cari</button>
                @if(request('cari'))
                    <a href="{{ route('admin.data.index') }}" class="text-xs text-slate-500 hover:text-slate-700">Reset</a>
                @endif
            </form>
            <a href="{{ route('admin.data.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition flex-shrink-0">
                <i class="fa-solid fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
    <!--table-->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                <tr>
                    <th class="py-4 px-6">No</th>
                    <th class="py-4 px-6">Nama Sekolah</th>
                    <th class="py-4 px-6">Alamat</th>
                    <th class="py-4 px-6 text-center">Jumlah Penerima</th>
                    <th class="py-4 px-6">Tanggal Distribusi</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($data_penerima as $index => $item)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 text-slate-400 font-mono text-xs">
                            {{ $data_penerima->firstItem() + $index }}
                        </td>
                        <td class="py-4 px-6 font-bold text-slate-900">
                            {{ $item->nama_sekolah }}
                        </td>
                        <td class="py-4 px-6 text-slate-600 text-xs max-w-xs">
                            {{ $item->alamat }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold border border-emerald-200 text-xs">
                                {{ number_format($item->jumlah_penerima) }} Siswa
                            </span>
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">
                            {{ \Carbon\Carbon::parse($item->tanggal_distribusi)->translatedFormat('d M Y') }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.data.edit', $item->id) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-amber-100 text-slate-600 hover:text-amber-700 text-xs font-semibold transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.data.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data sekolah penerima ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-rose-100 text-slate-600 hover:text-rose-700 text-xs font-semibold transition" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-school text-3xl mb-2"></i>
                            <p>Belum ada data penerima.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($data_penerima->hasPages())
        <div class="p-6 border-t border-slate-100">
            {{ $data_penerima->links() }}
        </div>
    @endif
</div>
@endsection