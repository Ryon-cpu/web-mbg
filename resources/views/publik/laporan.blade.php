@extends('layouts.publik')
@section('title', 'Laporan Penyaluran - MBG')
@section('content')
<div class="bg-gradient-to-b from-emerald-900 to-slate-900 py-16 text-white text-center">
    <div class="max-w-4xl mx-auto px-4">
        <span class="text-xs uppercase font-bold text-emerald-300 tracking-wider">Transparansi Publik</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold mt-2 mb-3">Laporan Kegiatan Penyaluran</h1>
        <p class="text-slate-300 text-sm max-w-xl mx-auto">
            Daftar resmi seluruh dokumentasi dan rekapan kegiatan makan bergizi gratis yang disalurkan secara berkala.
        </p>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Filter Tanggal -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <!-- Quick Presets -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-1">Pilihan Cepat:</span>
                <!-- Semua -->
                <a href="{{ route('laporan.index') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-xs font-bold border transition duration-150
                       {{ !$tanggal ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs shadow-emerald-200' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border-slate-200 hover:text-emerald-700' }}">
                    <i class="fa-solid fa-layer-group text-[11px]"></i> Semua Laporan
                </a>
                @foreach ($quickDates as $item)
                    @php $isActive = ($tanggal === $item['date']); @endphp
                    <a href="{{ route('laporan.index', ['tanggal' => $item['date']]) }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-xs font-bold border transition duration-150
                           {{ $isActive ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs shadow-emerald-200' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border-slate-200 hover:text-emerald-700' }}">
                        <i class="fa-regular fa-calendar text-[11px]"></i>
                        {{ $item['label'] }}
                        <span class="text-[10px] font-medium {{ $isActive ? 'text-emerald-100' : 'text-slate-400' }}">
                            ({{ \Carbon\Carbon::parse($item['date'])->translatedFormat('d M') }})
                        </span>
                    </a>
                @endforeach
            </div>
            <!--custom date picker form -->
            <form method="GET" action="{{ route('laporan.index') }}" class="flex items-center gap-2">
                <div class="relative flex items-center bg-slate-50 border border-slate-200 rounded-2xl px-3 py-1.5 hover:border-emerald-400 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/20 transition">
                    <label for="pilih_tanggal" class="text-xs font-medium text-slate-500 flex items-center gap-1.5 mr-2 whitespace-nowrap cursor-pointer">
                        <i class="fa-regular fa-calendar-days text-emerald-600"></i> Custom Tanggal:
                    </label>
                    <input type="date" id="pilih_tanggal" name="tanggal" value="{{ $tanggal }}"
                           onchange="this.form.submit()"
                           class="bg-transparent text-xs font-semibold text-slate-800 focus:outline-none cursor-pointer">
                </div>
                <button type="submit" class="px-3.5 py-2 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs transition inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-magnifying-glass"></i> Filter
                </button>
            </form>
        </div>
        <!--info tanggal aktif-->
        @if ($tanggal)
            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2 text-emerald-800 bg-emerald-50/80 px-3.5 py-1.5 rounded-xl border border-emerald-200">
                    <i class="fa-solid fa-calendar-check text-emerald-600"></i>
                    <span>Menampilkan laporan tanggal: <strong class="font-bold text-emerald-900">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</strong></span>
                </div>
                <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-1.5 text-slate-500 hover:text-rose-600 font-semibold transition">
                    <i class="fa-solid fa-rotate-left"></i> Reset ke Semua Tanggal
                </a>
            </div>
        @endif
    </div>
    <!--laporan grid-->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse ($laporans as $laporan)
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                <div>
                    @if ($laporan->foto)
                        <div class="aspect-video w-full rounded-2xl overflow-hidden bg-slate-100 mb-4 border border-slate-100">
                            <img src="{{ url('media/' . $laporan->foto) }}" alt="{{ $laporan->judul }}" class="block w-full h-full object-contain transition duration-300">
                        </div>
                    @endif
                    <div class="flex items-center justify-between text-xs text-slate-500 mb-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200">
                            <i class="fa-regular fa-calendar text-xs"></i>
                            {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d M Y') }}
                        </span>
                        @if ($laporan->menuHarians && $laporan->menuHarians->count() > 0)
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                <i class="fa-solid fa-bowl-food text-[10px]"></i> {{ number_format($laporan->menuHarians->sum('energi'), 0) }} kkal
                            </span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2 hover:text-emerald-600 transition">
                        <a href="{{ route('laporan.detail', $laporan->id) }}">{{ $laporan->judul }}</a>
                    </h3>
                    <p class="text-slate-600 text-sm leading-relaxed line-clamp-3 mb-4">
                        {{ Str::limit(strip_tags($laporan->isi), 120) }}
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-400">
                        Oleh: <strong class="text-slate-700">{{ $laporan->penulis->nama ?? 'Admin' }}</strong>
                    </span>
                    <a href="{{ route('laporan.detail', $laporan->id) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                        Baca Laporan <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-slate-200">
                <i class="fa-regular fa-folder-open text-4xl text-slate-300 mb-3 block"></i>
                @if ($tanggal)
                    <p class="text-slate-500 text-sm">Tidak ada laporan penyaluran pada tanggal <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</strong>.</p>
                    <a href="{{ route('laporan.index') }}" class="mt-4 inline-flex items-center gap-1.5 text-sm text-emerald-600 font-semibold hover:underline">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Tampilkan semua laporan
                    </a>
                @else
                    <p class="text-slate-500 text-sm">Belum ada laporan penyaluran yang tercatat.</p>
                @endif
            </div>
        @endforelse
    </div>
    <!--pagination-->
    <div class="mt-8">
        {{ $laporans->links() }}
    </div>
</div>
@endsection