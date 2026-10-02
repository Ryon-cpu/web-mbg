@extends('layouts.publik')
@section('title', $laporan->judul . ' - Laporan MBG')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 mb-6">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Laporan
    </a>
    <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm space-y-8">
        <!--metadata header -->
        <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 pb-4 border-b border-slate-100">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200">
                <i class="fa-regular fa-calendar"></i>
                Tanggal Penyaluran: {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('l, d F Y') }}
            </span>
            <span>&bull;</span>
            <span>Penulis: <strong class="text-slate-800">{{ $laporan->penulis->nama ?? 'Admin' }}</strong></span>
            <span>&bull;</span>
            <span>Dibuat: {{ $laporan->created_at->translatedFormat('d M Y, H:i') }}</span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 leading-tight">
            {{ $laporan->judul }}
        </h1>
        <!--foto utama laporan/dokumentasi-->
        @if ($laporan->foto)
            <div class="w-full max-w-3xl mx-auto aspect-video rounded-3xl overflow-hidden border border-slate-200 shadow-sm bg-slate-100">
                <img src="{{ url('media/' . $laporan->foto) }}"
                     alt="{{ $laporan->judul }}"
                 class="block w-full h-full object-contain">
            </div>
        @endif
        <!--content body-->
        <div class="prose max-w-none text-slate-700 text-base leading-relaxed whitespace-pre-line">
            {{ $laporan->isi }}
        </div>
        <!--section: rincian menu & nilai gizi MBG-->
        @if ($laporan->menuHarians && $laporan->menuHarians->count() > 0)
            @php
                $items = $laporan->menuHarians;
                $totEnergi  = $items->sum('energi');
                $totProtein = $items->sum('protein');
                $totLemak   = $items->sum('lemak');
                $totKarbo   = $items->sum('karbo');
                $totSerat   = $items->sum('serat');
            @endphp
            <div class="pt-8 border-t border-slate-200 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-bowl-food text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Rincian Menu & Standar Gizi Distribusi</h3>
                        <p class="text-xs text-slate-500">Daftar item makanan dan takaran gizi per porsi pada laporan ini</p>
                    </div>
                </div>
                <!--tabel rincian menu-->
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-slate-100 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    <th class="text-left px-5 py-3.5 min-w-[160px]">Bahan Makanan</th>
                                    <th class="text-center px-4 py-3.5">Takaran</th>
                                    <th class="text-center px-4 py-3.5"><span class="text-amber-600">Energi</span> (kkal)</th>
                                    <th class="text-center px-4 py-3.5"><span class="text-sky-600">Protein</span> (g)</th>
                                    <th class="text-center px-4 py-3.5"><span class="text-orange-500">Lemak</span> (g)</th>
                                    <th class="text-center px-4 py-3.5"><span class="text-emerald-600">Karbo</span> (g)</th>
                                    <th class="text-center px-4 py-3.5"><span class="text-purple-600">Serat</span> (g)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach ($items as $item)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-5 py-3.5 font-semibold text-slate-800">
                                            {{ $item->nama_item }}
                                        </td>
                                        <td class="px-4 py-3.5 text-center text-xs text-slate-500 font-medium">
                                            {{ $item->takaran }}
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            <span class="inline-block px-2.5 py-0.5 rounded-lg bg-amber-50 text-amber-700 font-bold text-xs">
                                                {{ number_format($item->energi ?? 0, 1) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3.5 text-center text-xs font-semibold text-sky-700">
                                            {{ number_format($item->protein ?? 0, 1) }}
                                        </td>
                                        <td class="px-4 py-3.5 text-center text-xs font-semibold text-orange-600">
                                            {{ number_format($item->lemak ?? 0, 1) }}
                                        </td>
                                        <td class="px-4 py-3.5 text-center text-xs font-semibold text-emerald-700">
                                            {{ number_format($item->karbo ?? 0, 1) }}
                                        </td>
                                        <td class="px-4 py-3.5 text-center text-xs font-semibold text-purple-600">
                                            {{ number_format($item->serat ?? 0, 1) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-slate-900 text-white font-bold text-xs">
                                    <td class="px-5 py-4 text-sm" colspan="2">
                                        <i class="fa-solid fa-sigma mr-1.5 text-emerald-400"></i> Total Nutrisi Menu
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-block px-2.5 py-1 rounded-xl bg-amber-500 text-white font-extrabold text-sm shadow">
                                            {{ number_format($totEnergi, 0) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center text-sky-300">{{ number_format($totProtein, 1) }} g</td>
                                    <td class="px-4 py-4 text-center text-orange-300">{{ number_format($totLemak, 1) }} g</td>
                                    <td class="px-4 py-4 text-center text-emerald-300">{{ number_format($totKarbo, 1) }} g</td>
                                    <td class="px-4 py-4 text-center text-purple-300">{{ number_format($totSerat, 1) }} g</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!--summary macro badges-->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100 text-center">
                        <span class="text-xs font-semibold text-sky-600 uppercase">Protein</span>
                        <p class="text-xl font-extrabold text-sky-900 mt-1">{{ number_format($totProtein, 1) }} g</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-center">
                        <span class="text-xs font-semibold text-emerald-600 uppercase">Karbohidrat</span>
                        <p class="text-xl font-extrabold text-emerald-900 mt-1">{{ number_format($totKarbo, 1) }} g</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-orange-50 border border-orange-100 text-center">
                        <span class="text-xs font-semibold text-orange-600 uppercase">Lemak</span>
                        <p class="text-xl font-extrabold text-orange-900 mt-1">{{ number_format($totLemak, 1) }} g</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-purple-50 border border-purple-100 text-center">
                        <span class="text-xs font-semibold text-purple-600 uppercase">Serat</span>
                        <p class="text-xl font-extrabold text-purple-900 mt-1">{{ number_format($totSerat, 1) }} g</p>
                    </div>
                </div>
            </div>
        @endif
        <!--galeri foto tambahan terkait-->
        @if ($laporan->galeri && $laporan->galeri->count() > 0)
            <div class="pt-8 border-t border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-images text-emerald-600"></i> Galeri Dokumentasi Tambahan
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach ($laporan->galeri as $foto)
                        <div class="group relative aspect-[3/4] rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-xs">
                            <img src="{{ url('media/' . $foto->file_path) }}" alt="{{ $foto->judul }}" class="w-full h-full object-contain transition duration-200">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent opacity-0 group-hover:opacity-100 transition p-3 flex items-end">
                                <p class="text-xs text-white">{{ $foto->judul }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
</div>
@endsection