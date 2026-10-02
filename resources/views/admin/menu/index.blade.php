@extends('layouts.admin')

@section('title', 'Kelola Menu Gizi Harian')
@section('page_title', 'Menu Gizi Harian')
@section('page_subtitle', 'Atur rincian menu makanan dan nilai gizi untuk setiap tanggal distribusi')

@section('content')

@if (session('success'))
    <div class="mb-6 flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl text-sm">
        <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5 flex-shrink-0"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif
@if (session('error'))
    <div class="mb-6 flex items-start gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl text-sm">
        <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 flex-shrink-0"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif
<div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
    <!--header & filter-->
    <div class="px-6 py-5 border-b border-slate-100 flex flex-col gap-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                    <i class="fa-solid fa-bowl-food text-emerald-600"></i>
                    Daftar Menu per Tanggal
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Total {{ $daftarMenu->total() }} tanggal memiliki data menu</p>
            </div>
            <a href="{{ route('admin.menu.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm transition shadow-md shadow-emerald-600/20 flex-shrink-0">
                <i class="fa-solid fa-plus"></i> Tambah Menu
            </a>
        </div>
        <!--filter tanggal / bulan-->
        <form method="GET" action="{{ route('admin.menu.index') }}" class="flex flex-wrap items-center gap-3 pt-2">
            <div class="flex items-center gap-2">
                <label for="tanggal" class="text-xs font-semibold text-slate-600">Cari Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}"
                       class="px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-xs focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:outline-none">
            </div>
            <button type="submit" class="px-4 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold transition">
                <i class="fa-solid fa-filter mr-1"></i> Filter
            </button>
            @if (request()->filled('tanggal') || request()->filled('bulan'))
                <a href="{{ route('admin.menu.index') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold transition">
                    <i class="fa-solid fa-rotate-left mr-1"></i> Reset
                </a>
            @endif
        </form>
    </div>
    @if ($daftarMenu->isEmpty())
        <div class="py-20 text-center">
            <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-utensils text-3xl text-slate-300"></i>
            </div>
            <p class="text-slate-500 font-medium">Belum ada data menu gizi.</p>
            <p class="text-slate-400 text-sm mt-1">Klik <strong>"Tambah Menu"</strong> untuk mulai mengisi.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-6 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-center px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Hari</th>
                        <th class="text-center px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Jml Item</th>
                        <th class="text-center px-4 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Total Energi</th>
                        <th class="text-right px-6 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($daftarMenu as $row)
                        @php
                            $tgl = \Carbon\Carbon::parse($row->tanggal);
                            $isHariIni = $tgl->isToday();
                        @endphp
                        <tr class="hover:bg-slate-50 transition {{ $isHariIni ? 'bg-emerald-50/50' : '' }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-slate-800">{{ $tgl->translatedFormat('d F Y') }}</span>
                                    @if ($isHariIni)
                                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500 text-white font-bold">HARI INI</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="text-xs font-medium text-slate-600">{{ $tgl->translatedFormat('l') }}</span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                                    {{ $row->jumlah_item }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="inline-block px-3 py-1 rounded-xl bg-amber-50 text-amber-700 font-bold text-xs border border-amber-100">
                                    {{ number_format($row->total_energi, 0) }} kkal
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.menu.show', $tgl->format('Y-m-d')) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-xs font-semibold transition border border-emerald-200">
                                        <i class="fa-solid fa-eye text-xs"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.menu.edit', $tgl->format('Y-m-d')) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-700 text-xs font-semibold transition border border-sky-200">
                                        <i class="fa-solid fa-pen text-xs"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.menu.destroy', $tgl->format('Y-m-d')) }}" method="POST"
                                          onsubmit="return confirm('Hapus seluruh menu tanggal {{ $tgl->translatedFormat('d F Y') }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold transition border border-rose-200">
                                            <i class="fa-solid fa-trash text-xs"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($daftarMenu->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $daftarMenu->links() }}
            </div>
        @endif
    @endif
</div>
@endsection