@extends('layouts.publik')

@section('title', 'Data Sekolah Penerima - MBG')

@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-slate-900 py-16 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs uppercase font-bold text-emerald-300 tracking-wider">Data Sasaran Terverifikasi</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold mt-2 mb-3">Data Sekolah Penerima MBG</h1>
        <p class="text-slate-300 text-sm max-w-xl mx-auto">
            Informasi terbuka data sekolah sasaran penerima manfaat program Makan Bergizi Gratis beserta jumlah kuota siswa penerima.
        </p>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!--star counter card-->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="fa-solid fa-school"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Sekolah Terdata</p>
                <h3 class="text-3xl font-extrabold text-slate-900">{{ number_format($total_sekolah) }} <span class="text-sm font-normal text-slate-500">Sekolah</span></h3>
            </div>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Total Siswa / Porsi Penerima</p>
                <h3 class="text-3xl font-extrabold text-slate-900">{{ number_format($total_penerima) }} <span class="text-sm font-normal text-slate-500">Siswa</span></h3>
            </div>
        </div>
    </div>
    <!--search form-->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs mb-8">
        <form action="{{ route('data.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama sekolah atau alamat lokasi..." class="w-full pl-11 pr-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
            </div>
            <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition">
                Cari Data
            </button>
            @if(request('cari'))
                <a href="{{ route('data.index') }}" class="px-4 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-semibold flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>
    <!--data tabel card-->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                    <tr>
                        <th class="py-4 px-6">No</th>
                        <th class="py-4 px-6">Nama Sekolah</th>
                        <th class="py-4 px-6">Alamat Lengkap</th>
                        <th class="py-4 px-6 text-center">Jumlah Penerima</th>
                        <th class="py-4 px-6">Tanggal Distribusi</th>
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
                            <td class="py-4 px-6 text-slate-600 max-w-xs">
                                {{ $item->alamat }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">
                                    {{ number_format($item->jumlah_penerima) }} Siswa
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                {{ \Carbon\Carbon::parse($item->tanggal_distribusi)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-3xl mb-2"></i>
                                <p>Tidak ada data penerima ditemukan.</p>
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
</div>
@endsection