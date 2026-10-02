@extends('layouts.admin')

@section('title', 'Detail Menu â€” ' . \Carbon\Carbon::parse($tgl)->translatedFormat('d F Y'))
@section('page_title', 'Detail Menu Gizi Harian')
@section('page_subtitle', 'Rincian bahan makanan dan kandungan nutrisi untuk tanggal ' . \Carbon\Carbon::parse($tgl)->translatedFormat('l, d F Y'))

@section('content')
@php
    $carbonTgl = \Carbon\Carbon::parse($tgl);
    $isHariIni = $carbonTgl->isToday();
    $isPast = $carbonTgl->isPast() && !$isHariIni;
@endphp

<div class="space-y-6">
    <!--top action bar-->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white rounded-3xl border border-slate-200 shadow-xs p-5 sm:p-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.menu.index') }}"
               class="w-10 h-10 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition flex-shrink-0"
               title="Kembali ke Daftar">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <div class="flex items-center gap-2 flex-wrap">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        {{ $carbonTgl->translatedFormat('l, d F Y') }}
                    </h3>
                    @if ($isHariIni)
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500 text-white font-bold text-xs">HARI INI</span>
                    @elseif ($isPast)
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-700 font-semibold text-xs">Sudah Berlalu</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full bg-sky-100 text-sky-700 font-semibold text-xs">Mendatang</span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-0.5">
                    Distribusi Menu Makan Bergizi Gratis &bull; {{ $items->count() }} item bahan makanan
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('home', ['tanggal' => $tgl]) }}" target="_blank"
               class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i> Lihat di Web
            </a>
            <a href="{{ route('admin.menu.edit', $tgl) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold transition shadow-sm">
                <i class="fa-solid fa-pen text-xs"></i> Edit Menu
            </a>
            <form action="{{ route('admin.menu.destroy', $tgl) }}" method="POST"
                  onsubmit="return confirm('Hapus seluruh menu tanggal {{ $carbonTgl->translatedFormat('d F Y') }}?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold transition border border-rose-200">
                    <i class="fa-solid fa-trash text-xs"></i> Hapus
                </button>
            </form>
        </div>
    </div>
    <!--content grid: table left, visual summary right-->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!--kiri: tabel rincian item-->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-utensils text-base"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-base">Rincian Bahan Makanan</h4>
                        <p class="text-xs text-slate-500">Nilai gizi terhitung per sajian makan siang</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                <th class="text-center px-3 py-3 w-12">#</th>
                                <th class="text-left px-5 py-3 min-w-[150px]">Bahan Makanan</th>
                                <th class="text-center px-4 py-3">Takaran</th>
                                <th class="text-center px-4 py-3"><span class="text-amber-600">Energi</span> (kkal)</th>
                                <th class="text-center px-4 py-3"><span class="text-sky-600">Protein</span> (g)</th>
                                <th class="text-center px-4 py-3"><span class="text-orange-500">Lemak</span> (g)</th>
                                <th class="text-center px-4 py-3"><span class="text-emerald-600">Karbo</span> (g)</th>
                                <th class="text-center px-4 py-3"><span class="text-purple-600">Serat</span> (g)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($items as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-3 py-3.5 text-center text-xs text-slate-400 font-semibold">
                                        {{ $item->urutan }}
                                    </td>
                                    <td class="px-5 py-3.5 font-semibold text-slate-800">
                                        {{ $item->nama_item }}
                                    </td>
                                    <td class="px-4 py-3.5 text-center text-xs text-slate-500 font-medium">
                                        {{ $item->takaran }}
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <span class="inline-block px-2 py-0.5 rounded-lg bg-amber-50 text-amber-700 font-bold text-xs">
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
                                <td class="px-5 py-4 text-sm" colspan="3">
                                    <i class="fa-solid fa-sigma mr-1.5 text-emerald-400"></i> Total Nilai Gizi
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-block px-2.5 py-1 rounded-xl bg-amber-500 text-white font-extrabold text-sm shadow">
                                        {{ number_format($totalEnergi, 0) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center text-sky-300">{{ number_format($totalProtein, 1) }} g</td>
                                <td class="px-4 py-4 text-center text-orange-300">{{ number_format($totalLemak, 1) }} g</td>
                                <td class="px-4 py-4 text-center text-emerald-300">{{ number_format($totalKarbo, 1) }} g</td>
                                <td class="px-4 py-4 text-center text-purple-300">{{ number_format($totalSerat, 1) }} g</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!--kanan: ringkasan gizi visual-->
        <div class="space-y-6">
            <!--card total energi-->
            <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-3xl p-6 text-white shadow-lg shadow-amber-500/20 text-center">
                <i class="fa-solid fa-bolt text-3xl mb-2 text-amber-200"></i>
                <p class="text-5xl font-extrabold">{{ number_format($totalEnergi, 0) }}</p>
                <p class="text-sm font-semibold text-amber-100 mt-1">kkal / Porsi Makan Siang</p>
                @php
                    $persen = min(100, round(($totalEnergi / 700) * 100));
                @endphp
                <div class="mt-4 bg-white/20 rounded-full h-2.5 overflow-hidden">
                    <div class="h-full bg-white rounded-full transition-all duration-700" style="width: {{ $persen }}%"></div>
                </div>
                <p class="text-[11px] text-amber-200 mt-2">{{ $persen }}% dari Standar AKE Makan Siang (700 kkal)</p>
            </div>
            <!--card makronutrien-->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 space-y-4">
                <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-chart-pie text-emerald-600"></i>
                    Pemenuhan Makronutrien
                </h4>
                <!--protein-->
                <div>
                    <div class="flex justify-between items-center mb-1 text-xs">
                        <span class="font-semibold text-slate-600 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-500 inline-block"></span> Protein
                        </span>
                        <span class="font-bold text-sky-700">{{ number_format($totalProtein, 1) }} g</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-sky-500 rounded-full" style="width: {{ min(100, round(($totalProtein/35)*100)) }}%"></div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-0.5">Target: ~35 g / makan siang</p>
                </div>
                <!--karbohidrat-->
                <div>
                    <div class="flex justify-between items-center mb-1 text-xs">
                        <span class="font-semibold text-slate-600 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span> Karbohidrat
                        </span>
                        <span class="font-bold text-emerald-700">{{ number_format($totalKarbo, 1) }} g</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min(100, round(($totalKarbo/100)*100)) }}%"></div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-0.5">Target: ~100 g / makan siang</p>
                </div>
                <!--Lemak-->
                <div>
                    <div class="flex justify-between items-center mb-1 text-xs">
                        <span class="font-semibold text-slate-600 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-500 inline-block"></span> Lemak
                        </span>
                        <span class="font-bold text-orange-600">{{ number_format($totalLemak, 1) }} g</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-orange-500 rounded-full" style="width: {{ min(100, round(($totalLemak/25)*100)) }}%"></div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-0.5">Target: ~25 g / makan siang</p>
                </div>
                <!--serat-->
                <div>
                    <div class="flex justify-between items-center mb-1 text-xs">
                        <span class="font-semibold text-slate-600 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500 inline-block"></span> Serat
                        </span>
                        <span class="font-bold text-purple-700">{{ number_format($totalSerat, 1) }} g</span>
                    </div>
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-500 rounded-full" style="width: {{ min(100, round(($totalSerat/12)*100)) }}%"></div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-0.5">Target: ~12 g / makan siang</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection