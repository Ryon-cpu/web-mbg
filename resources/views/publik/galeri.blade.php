@extends('layouts.publik')

@section('title', 'Hasil Dokumentasi Penyaluran & Menu MBG')

@section('content')
{{--hero header --}}
<div class="bg-gradient-to-b from-emerald-900 via-teal-900 to-slate-900 py-16 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-4xl mx-auto px-4 relative z-10">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider border border-emerald-500/30 mb-3">
            <i class="fa-solid fa-camera-retro"></i> Dokumentasi Madrasah        </span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight mt-1 mb-4">
            HASIL DOKUMENTASI PENYALURAN MBG
        </h1>
        <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
            Kumpulan bukti visual kedatangan di madrasah/sekolah penerima.
        </p>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{--filter tanggal & pencarian--}}
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            {{--quick presets--}}
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider mr-1">Pilihan Cepat:</span>
                {{--semua--}}
                <a href="{{ route('galeri.index', request()->filled('cari') ? ['cari' => request('cari')] : []) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl text-xs font-bold border transition duration-150
                       {{ !$tanggal ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs shadow-emerald-200' : 'bg-slate-50 hover:bg-slate-100 text-slate-600 border-slate-200 hover:text-emerald-700' }}">
                    <i class="fa-solid fa-layer-group text-[11px]"></i> Semua Dokumentasi
                </a>
                @foreach ($quickDates as $item)
                    @php $isActive = ($tanggal === $item['date']); @endphp
                    <a href="{{ route('galeri.index', array_merge(request()->filled('cari') ? ['cari' => request('cari')] : [], ['tanggal' => $item['date']])) }}"
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
            {{--form custom tanggal & cari--}}
            <form method="GET" action="{{ route('galeri.index') }}" class="flex flex-wrap items-center gap-2">
                @if (request('cari'))
                    <input type="hidden" name="cari" value="{{ request('cari') }}">
                @endif
                <div class="relative flex items-center bg-slate-50 border border-slate-200 rounded-2xl px-3 py-1.5 hover:border-emerald-400 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/20 transition">
                    <label for="pilih_tanggal" class="text-xs font-medium text-slate-500 flex items-center gap-1.5 mr-2 whitespace-nowrap cursor-pointer">
                        <i class="fa-regular fa-calendar-days text-emerald-600"></i> Custom Tanggal:
                    </label>
                    <input type="date" id="pilih_tanggal" name="tanggal" value="{{ $tanggal }}"
                           onchange="this.form.submit()"
                           class="bg-transparent text-xs font-semibold text-slate-800 focus:outline-none cursor-pointer">
                </div>
                <button type="submit" class="px-3.5 py-2 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-xs transition inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
            </form>
        </div>
        {{--info tanggal/filter aktif--}}
        @if ($tanggal || request('cari'))
            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex flex-wrap items-center gap-2">
                    @if ($tanggal)
                        <div class="flex items-center gap-1.5 text-emerald-800 bg-emerald-50/80 px-3 py-1.5 rounded-xl border border-emerald-200">
                            <i class="fa-solid fa-calendar-check text-emerald-600"></i>
                            <span>Tanggal: <strong class="font-bold text-emerald-900">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</strong></span>
                        </div>
                    @endif
                    @if (request('cari'))
                        <div class="flex items-center gap-1.5 text-slate-700 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200">
                            <i class="fa-solid fa-magnifying-glass text-slate-500"></i>
                            <span>Pencarian: "<strong>{{ request('cari') }}</strong>"</span>
                        </div>
                    @endif
                </div>
                <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-1.5 text-slate-500 hover:text-rose-600 font-semibold transition">
                    <i class="fa-solid fa-rotate-left"></i> Reset ke Semua Tanggal
                </a>
            </div>
        @endif
    </div>
    {{--grid dokumentasi--}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @forelse ($galeris as $item)
            <div class="bg-white rounded-3xl overflow-hidden border border-slate-200 shadow-xs hover:shadow-md transition-all duration-300 group flex flex-col justify-between">
                {{--bagian foto--}}
                <div class="relative aspect-[3/4] w-full overflow-hidden bg-slate-100 cursor-pointer"
                     onclick="openLightbox('{{ url('media/' . $item->file_path) }}', '{{ addslashes($item->judul) }}', '{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}', '{{ $item->laporan ? route('laporan.detail', $item->laporan_id) : '' }}', '{{ $item->laporan ? addslashes($item->laporan->judul) : '' }}')">
                    <img src="{{ url('media/' . $item->file_path) }}"
                         alt="{{ $item->judul }}"
                         class="w-full h-full object-contain transition-transform duration-500">
                    {{--gradient overlay saat hover--}}
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-black/20 opacity-80 group-hover:opacity-100 transition-opacity"></div>
                    {{--badge status dokumentasi--}}
                    <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-600/90 backdrop-blur-md text-white text-[10px] font-bold shadow-xs">
                            <i class="fa-solid fa-circle-check text-[9px]"></i> Dokumentasi Lapangan
                        </span>
                    </div>
                    {{--tombol Zoom Preview--}}
                    <div class="absolute bottom-3 right-3">
                        <span class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-md text-slate-800 flex items-center justify-center text-xs shadow-md group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-expand"></i>
                        </span>
                    </div>
                    {{--tanggal di pojok kiri bawah foto--}}
                    <div class="absolute bottom-3 left-3 text-white text-xs font-medium drop-shadow-md">
                        <i class="fa-regular fa-calendar mr-1 text-emerald-300"></i>
                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                    </div>
                </div>
                {{--bagian konten keterangan--}}
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-slate-900 text-base leading-snug mb-2 group-hover:text-emerald-700 transition">
                            {{ $item->judul }}
                        </h3>
                        {{--tautan laporan & menu MBG--}}
                        @if ($item->laporan)
                            <div class="mt-3 p-3 rounded-2xl bg-emerald-50/70 border border-emerald-100/80">
                                <div class="flex items-start gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center flex-shrink-0 text-[10px] mt-0.5">
                                        <i class="fa-solid fa-bowl-food"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wide block">Laporan & Menu Terkait:</span>
                                        <p class="text-xs font-semibold text-slate-800 truncate mt-0.5">
                                            {{ $item->laporan->judul }}
                                        </p>
                                        @if ($item->laporan->menuHarians && $item->laporan->menuHarians->count() > 0)
                                            <div class="flex items-center gap-2 mt-1 text-[11px] text-emerald-700 font-medium">
                                                <span><i class="fa-solid fa-utensils text-[9px]"></i> {{ $item->laporan->menuHarians->count() }} item menu</span>
                                                <span>&bull;</span>
                                                <span><i class="fa-solid fa-bolt text-[9px]"></i> {{ number_format($item->laporan->menuHarians->sum('energi'), 0) }} kkal</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-3 py-2 px-3 rounded-2xl bg-slate-50 border border-slate-100 text-[11px] text-slate-500 flex items-center gap-1.5">
                                <i class="fa-solid fa-location-dot text-slate-400"></i>
                                <span>Dokumentasi kegiatan distribusi MBG</span>
                            </div>
                        @endif
                    </div>
                    {{--footer card--}}
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                        @if ($item->laporan)
                            <a href="{{ route('laporan.detail', $item->laporan_id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:text-emerald-700 transition">
                                Cek Rincian Menu <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        @else
                            <span class="text-[11px] text-slate-400">MBG Dokumentasi</span>
                        @endif
                        <button type="button"
                                onclick="openLightbox('{{ url('media/' . $item->file_path) }}', '{{ addslashes($item->judul) }}', '{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}', '{{ $item->laporan ? route('laporan.detail', $item->laporan_id) : '' }}', '{{ $item->laporan ? addslashes($item->laporan->judul) : '' }}')"
                                class="inline-flex items-center gap-1 text-xs font-semibold text-slate-500 hover:text-slate-800 transition">
                            <i class="fa-regular fa-eye text-xs"></i> Lihat Foto
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-slate-200">
                <div class="w-16 h-16 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center mx-auto mb-3 text-2xl">
                    <i class="fa-regular fa-images"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Dokumentasi</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    @if ($tanggal)
                        Tidak ada dokumentasi penyaluran pada tanggal <strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</strong>.
                    @elseif (request('cari'))
                        Tidak ditemukan dokumentasi dengan kata kunci "<strong>{{ request('cari') }}</strong>".
                    @else
                        Dokumentasi foto kedatangan di madrasah/sekolah penerima akan segera diunggah.
                    @endif
                </p>
                @if ($tanggal || request('cari'))
                    <a href="{{ route('galeri.index') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-2xl bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition">
                        <i class="fa-solid fa-rotate-left text-xs"></i> Tampilkan Semua Dokumentasi
                    </a>
                @endif
            </div>
        @endforelse
    </div>
    {{--pagination--}}
    @if ($galeris->hasPages())
        <div class="mt-8">
            {{ $galeris->links() }}
        </div>
    @endif
</div>
{{--lightbox modal preview--}}
<div id="lightbox-modal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6" onclick="closeLightboxOnBackdrop(event)">
    <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden border border-slate-800 shadow-2xl flex flex-col max-h-[90vh]" onclick="event.stopPropagation()">
        {{--modal header--}}
        <div class="p-4 sm:p-5 bg-slate-900/90 border-b border-slate-800 flex items-center justify-between text-white">
            <div class="min-w-0 pr-4">
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 block mb-0.5">
                    <i class="fa-solid fa-camera mr-1"></i> Bukti Dokumentasi Lapangan
                </span>
                <h3 id="lightbox-title" class="font-bold text-base sm:text-lg text-white truncate"></h3>
                <p id="lightbox-date" class="text-xs text-slate-400 mt-0.5"></p>
            </div>
            <button onclick="closeLightbox()" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center transition">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
        {{--modal image counter--}}
        <div class="flex-1 bg-black flex items-center justify-center overflow-hidden p-2 sm:p-4 min-h-[300px]">
            <img id="lightbox-img" src="" alt="Dokumentasi MBG" class="max-h-[65vh] w-auto max-w-full object-contain rounded-xl shadow-lg">
        </div>
        {{--modal footer--}}
        <div id="lightbox-footer" class="p-4 bg-slate-900 border-t border-slate-800 flex flex-wrap items-center justify-between gap-3 text-xs">
            <div id="lightbox-laporan-info" class="text-slate-300">
                {{-- Diisi secara dinamis oleh JavaScript --}}
            </div>
            <a id="lightbox-laporan-link" href="#" class="hidden px-4 py-2 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition items-center gap-1.5">
                <i class="fa-solid fa-bowl-food"></i> Lihat Rincian Menu & Laporan
            </a>
        </div>
    </div>
</div>
<script>
    function openLightbox(imgUrl, title, date, laporanUrl, laporanTitle) {
        document.getElementById('lightbox-img').src = imgUrl;
        document.getElementById('lightbox-title').textContent = title;
        document.getElementById('lightbox-date').innerHTML = '<i class="fa-regular fa-calendar mr-1"></i> Tanggal Dokumentasi: ' + date;

        const laporanLink = document.getElementById('lightbox-laporan-link');
        const laporanInfo = document.getElementById('lightbox-laporan-info');

        if (laporanUrl && laporanTitle) {
            laporanInfo.innerHTML = '<i class="fa-solid fa-link text-emerald-400 mr-1.5"></i> Terhubung dengan: <strong class="text-white">' + laporanTitle + '</strong>';
            laporanLink.href = laporanUrl;
            laporanLink.classList.remove('hidden');
            laporanLink.classList.add('inline-flex');
        } else {
            laporanInfo.innerHTML = '<span class="text-slate-400"><i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Dokumentasi Terverifikasi Program MBG</span>';
            laporanLink.classList.add('hidden');
            laporanLink.classList.remove('inline-flex');
        }
        document.getElementById('lightbox-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        document.getElementById('lightbox-modal').classList.add('hidden');
        document.getElementById('lightbox-img').src = '';
        document.body.style.overflow = 'auto';
    }
    function closeLightboxOnBackdrop(event) {
        if (event.target.id === 'lightbox-modal') {
            closeLightbox();
        }
    }
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
@endsection