@extends('layouts.publik')
@section('title', 'Beranda - Dokumentasi Program Makan Bergizi Gratis (MBG)')
@section('content')
<!--hero section-->
<section class="relative bg-gradient-to-b from-emerald-900 via-slate-900 to-slate-900 text-white overflow-hidden py-24 lg:py-32">
    <!--decorative background elements-->
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 right-0 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-semibold tracking-wide uppercase mb-6">
                <i class="fa-solid fa-seedling text-emerald-400"></i> Generasi Emas Bebas Stunting
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                DOKUMENTASI PROGRAM <br>
                <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-300 bg-clip-text text-transparent">
                    SPPG 03 GULUK-GULUK YAYASAN ANNUQAYYAH (MBG)
                </span>
            </h1>
            <p class="text-base sm:text-lg text-slate-300 mb-10 leading-relaxed">
                Pusat data, transparansi, laporan kegiatan, dan dokumentasi penyaluran makanan sehat dan bergizi untuk siswa-siswi di seluruh sekolah sasaran.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('data.index') }}" class="px-6 py-3.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-500/30 transition transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-magnifying-glass mr-2"></i> Cek Data Penerima
                </a>
                <a href="{{ route('laporan.index') }}" class="px-6 py-3.5 rounded-2xl bg-slate-800/80 hover:bg-slate-700 text-slate-200 border border-slate-700 font-semibold transition">
                    <i class="fa-solid fa-file-lines mr-2"></i> Lihat Laporan Penyaluran
                </a>
            </div>
        </div>
    </div>
</section>
<!--statistik bar-->
<section class="relative -mt-12 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <!-- Stat 1 -->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex items-center gap-4 transform hover:-translate-y-1 transition duration-200">
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="fa-solid fa-child-reaching"></i>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_penerima'] ?? 0) }}</p>
                <p class="text-xs font-medium text-slate-500">Porsi Makanan Disalurkan</p>
            </div>
        </div>
        <!--stat 2-->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex items-center gap-4 transform hover:-translate-y-1 transition duration-200">
            <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="fa-solid fa-school"></i>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_sekolah'] ?? 0) }}</p>
                <p class="text-xs font-medium text-slate-500">Sekolah Sasaran</p>
            </div>
        </div>
        <!--stat 3-->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex items-center gap-4 transform hover:-translate-y-1 transition duration-200">
            <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="fa-solid fa-file-contract"></i>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_laporan'] ?? 0) }}</p>
                <p class="text-xs font-medium text-slate-500">Laporan Penyaluran</p>
            </div>
        </div>
        <!--stat 4-->
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-slate-100 flex items-center gap-4 transform hover:-translate-y-1 transition duration-200">
            <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="fa-solid fa-camera-retro"></i>
            </div>
            <div>
                <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_galeri'] ?? 0) }}</p>
                <p class="text-xs font-medium text-slate-500">Foto Dokumentasi</p>
            </div>
        </div>
    </div>
</section>
<!--tentang  program MBG-->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider">Misi Utama</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2 mb-6 tracking-tight">
                    Meningkatkan Nutrisi Anak Bangsa untuk Masa Depan Lebih Sehat
                </h2>
                <p class="text-slate-600 leading-relaxed mb-6">
                    Program Makan Bergizi Gratis (MBG) adalah inisiatif strategis pemenuhan kecukupan gizi harian bagi peserta didik. Program ini menjamin setiap porsi makanan memenuhi standar gizi seimbang: karbohidrat, protein hewani/nabati, serat, serta mikronutrien penting.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mt-1 flex-shrink-0 text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Transparansi Data & Laporan</h4>
                            <p class="text-xs text-slate-500">Seluruh data distribusi dan laporan berkala dapat dipantau oleh masyarakat luas secara terbuka.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mt-1 flex-shrink-0 text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Higienitas & Standar Gizi Teruji</h4>
                            <p class="text-xs text-slate-500">Penyediaan menu diawasi oleh tim ahli gizi untuk memastikan kualitas kalori dan protein.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mt-1 flex-shrink-0 text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Pemberdayaan Ekonomi Lokal</h4>
                            <p class="text-xs text-slate-500">Bahan baku bersumber dari petani, peternak, dan UMKM lokal di sekitar sekolah sasaran.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--visual info card-->
            <div class="bg-gradient-to-tr from-emerald-600 to-teal-500 rounded-3xl p-8 sm:p-10 text-white shadow-2xl relative overflow-hidden">
                <div class="absolute -bottom-10 -right-10 w-60 h-60 bg-white/10 rounded-full blur-2xl"></div>
                <h3 class="text-2xl font-bold mb-4">Prinsip Piring Sehat MBG</h3>
                <p class="text-emerald-100 text-sm leading-relaxed mb-6">
                    Setiap piring makanan yang disajikan dirancang khusus sesuai anjuran Isi Piringku:
                </p>
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                        <i class="fa-solid fa-bowl-rice text-3xl mb-2 text-amber-200"></i>
                        <h5 class="font-bold text-sm">35% Karbohidrat</h5>
                        <p class="text-xs text-emerald-100">Nasi / Kentang / Ubi</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                        <i class="fa-solid fa-drumstick-bite text-3xl mb-2 text-amber-200"></i>
                        <h5 class="font-bold text-sm">35% Lauk Pauk</h5>
                        <p class="text-xs text-emerald-100">Ayam, Telur, Ikan, Tahu</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                        <i class="fa-solid fa-carrot text-3xl mb-2 text-amber-200"></i>
                        <h5 class="font-bold text-sm">20% Sayur-Mayur</h5>
                        <p class="text-xs text-emerald-100">Bayam, Wortel, Brokoli</p>
                    </div>
                    <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                        <i class="fa-solid fa-apple-whole text-3xl mb-2 text-amber-200"></i>
                        <h5 class="font-bold text-sm">10% Buah Segar</h5>
                        <p class="text-xs text-emerald-100">Pisang, Pepaya, Jeruk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--section: menu gizi harian-->
@php
    //data menu mingguan(1=Senin, 6=Sabtu, 0=Minggu=libur)
    $menuMingguan = [
        1 => [
            'tema'  => 'Menu Senin â€” Ayam & Sayur Hijau',
            'warna' => 'emerald',
            'items' => [
                ['nama'=>'Nasi Putih',      'takaran'=>'200 g', 'energi'=>260,  'protein'=>4.8,  'lemak'=>0.4,  'karbo'=>57.2, 'serat'=>0.6],
                ['nama'=>'Ayam Goreng',     'takaran'=>'75 g',  'energi'=>195,  'protein'=>18.6, 'lemak'=>13.2, 'karbo'=>0.0,  'serat'=>0.0],
                ['nama'=>'Tumis Bayam',     'takaran'=>'80 g',  'energi'=>28,   'protein'=>2.6,  'lemak'=>0.4,  'karbo'=>3.8,  'serat'=>2.2],
                ['nama'=>'Tempe Goreng',    'takaran'=>'50 g',  'energi'=>100,  'protein'=>9.5,  'lemak'=>5.5,  'karbo'=>6.8,  'serat'=>1.4],
                ['nama'=>'Jeruk Manis',     'takaran'=>'100 g', 'energi'=>47,   'protein'=>0.9,  'lemak'=>0.1,  'karbo'=>11.8, 'serat'=>2.4],
                ['nama'=>'Air Mineral',     'takaran'=>'350 ml','energi'=>0,    'protein'=>0.0,  'lemak'=>0.0,  'karbo'=>0.0,  'serat'=>0.0],
            ],
        ],
        2 => [
            'tema'  => 'Menu Selasa â€” Ikan & Wortel',
            'warna' => 'sky',
            'items' => [
                ['nama'=>'Nasi Putih',      'takaran'=>'200 g', 'energi'=>260,  'protein'=>4.8,  'lemak'=>0.4,  'karbo'=>57.2, 'serat'=>0.6],
                ['nama'=>'Ikan Goreng',     'takaran'=>'80 g',  'energi'=>148,  'protein'=>21.4, 'lemak'=>6.8,  'karbo'=>0.0,  'serat'=>0.0],
                ['nama'=>'Wortel Rebus',    'takaran'=>'80 g',  'energi'=>23,   'protein'=>0.5,  'lemak'=>0.1,  'karbo'=>5.4,  'serat'=>1.5],
                ['nama'=>'Tahu Kukus',      'takaran'=>'60 g',  'energi'=>48,   'protein'=>5.1,  'lemak'=>2.8,  'karbo'=>1.4,  'serat'=>0.2],
                ['nama'=>'Pisang Ambon',    'takaran'=>'100 g', 'energi'=>89,   'protein'=>1.1,  'lemak'=>0.3,  'karbo'=>22.8, 'serat'=>2.6],
                ['nama'=>'Air Mineral',     'takaran'=>'350 ml','energi'=>0,    'protein'=>0.0,  'lemak'=>0.0,  'karbo'=>0.0,  'serat'=>0.0],
            ],
        ],
        3 => [
            'tema'  => 'Menu Rabu â€” Telur & Brokoli',
            'warna' => 'amber',
            'items' => [
                ['nama'=>'Nasi Putih',      'takaran'=>'200 g', 'energi'=>260,  'protein'=>4.8,  'lemak'=>0.4,  'karbo'=>57.2, 'serat'=>0.6],
                ['nama'=>'Telur Dadar',     'takaran'=>'70 g',  'energi'=>122,  'protein'=>8.4,  'lemak'=>9.6,  'karbo'=>0.8,  'serat'=>0.0],
                ['nama'=>'Brokoli Rebus',   'takaran'=>'80 g',  'energi'=>28,   'protein'=>2.8,  'lemak'=>0.3,  'karbo'=>4.8,  'serat'=>2.6],
                ['nama'=>'Tahu Goreng',     'takaran'=>'60 g',  'energi'=>120,  'protein'=>7.2,  'lemak'=>9.0,  'karbo'=>1.4,  'serat'=>0.2],
                ['nama'=>'Pepaya Segar',    'takaran'=>'100 g', 'energi'=>43,   'protein'=>0.5,  'lemak'=>0.1,  'karbo'=>11.1, 'serat'=>1.8],
                ['nama'=>'Air Mineral',     'takaran'=>'350 ml','energi'=>0,    'protein'=>0.0,  'lemak'=>0.0,  'karbo'=>0.0,  'serat'=>0.0],
            ],
        ],
        4 => [
            'tema'  => 'Menu Kamis â€” Daging & Kacang',
            'warna' => 'red',
            'items' => [
                ['nama'=>'Nasi Merah',      'takaran'=>'200 g', 'energi'=>216,  'protein'=>4.4,  'lemak'=>1.8,  'karbo'=>46.0, 'serat'=>3.5],
                ['nama'=>'Daging Sapi Semur','takaran'=>'60 g', 'energi'=>140,  'protein'=>15.0, 'lemak'=>8.2,  'karbo'=>2.4,  'serat'=>0.0],
                ['nama'=>'Tumis Kacang Panjang','takaran'=>'80 g','energi'=>36, 'protein'=>2.6,  'lemak'=>0.3,  'karbo'=>7.2,  'serat'=>3.6],
                ['nama'=>'Perkedel Kentang','takaran'=>'50 g',  'energi'=>90,   'protein'=>2.8,  'lemak'=>3.8,  'karbo'=>11.2, 'serat'=>0.8],
                ['nama'=>'Semangka Segar',  'takaran'=>'150 g', 'energi'=>46,   'protein'=>0.9,  'lemak'=>0.2,  'karbo'=>11.5, 'serat'=>0.6],
                ['nama'=>'Air Mineral',     'takaran'=>'350 ml','energi'=>0,    'protein'=>0.0,  'lemak'=>0.0,  'karbo'=>0.0,  'serat'=>0.0],
            ],
        ],
        5 => [
            'tema'  => 'Menu Jumat â€” Ikan Asap & Labu',
            'warna' => 'teal',
            'items' => [
                ['nama'=>'Nasi Putih',      'takaran'=>'200 g', 'energi'=>260,  'protein'=>4.8,  'lemak'=>0.4,  'karbo'=>57.2, 'serat'=>0.6],
                ['nama'=>'Ikan Tongkol',    'takaran'=>'80 g',  'energi'=>156,  'protein'=>26.0, 'lemak'=>5.8,  'karbo'=>0.0,  'serat'=>0.0],
                ['nama'=>'Tumis Labu Siam', 'takaran'=>'80 g',  'energi'=>24,   'protein'=>1.0,  'lemak'=>0.2,  'karbo'=>5.4,  'serat'=>1.6],
                ['nama'=>'Tempe Bacem',     'takaran'=>'50 g',  'energi'=>96,   'protein'=>9.2,  'lemak'=>4.8,  'karbo'=>7.6,  'serat'=>1.4],
                ['nama'=>'Melon Segar',     'takaran'=>'120 g', 'energi'=>38,   'protein'=>0.6,  'lemak'=>0.2,  'karbo'=>9.4,  'serat'=>0.8],
                ['nama'=>'Air Mineral',     'takaran'=>'350 ml','energi'=>0,    'protein'=>0.0,  'lemak'=>0.0,  'karbo'=>0.0,  'serat'=>0.0],
            ],
        ],
        6 => [
            'tema'  => 'Menu Sabtu â€” Ayam Bumbu & Jagung',
            'warna' => 'purple',
            'items' => [
                ['nama'=>'Nasi Putih',      'takaran'=>'200 g', 'energi'=>260,  'protein'=>4.8,  'lemak'=>0.4,  'karbo'=>57.2, 'serat'=>0.6],
                ['nama'=>'Ayam Bumbu Rujak','takaran'=>'75 g',  'energi'=>185,  'protein'=>17.5, 'lemak'=>12.0, 'karbo'=>2.0,  'serat'=>0.2],
                ['nama'=>'Tumis Jagung Muda','takaran'=>'80 g', 'energi'=>45,   'protein'=>1.8,  'lemak'=>0.5,  'karbo'=>9.4,  'serat'=>2.0],
                ['nama'=>'Tahu Bacem',      'takaran'=>'60 g',  'energi'=>78,   'protein'=>6.8,  'lemak'=>3.8,  'karbo'=>5.4,  'serat'=>0.3],
                ['nama'=>'Apel Merah',      'takaran'=>'100 g', 'energi'=>52,   'protein'=>0.3,  'lemak'=>0.2,  'karbo'=>13.8, 'serat'=>2.4],
                ['nama'=>'Air Mineral',     'takaran'=>'350 ml','energi'=>0,    'protein'=>0.0,  'lemak'=>0.0,  'karbo'=>0.0,  'serat'=>0.0],
            ],
        ],
    ];
    //data tanggal yang dipilih (default hari ini)
    $curTgl = isset($tanggalPilih) ? \Carbon\Carbon::parse($tanggalPilih) : now();
    $isToday = $curTgl->isToday();
    $tanggalHariIni = $curTgl->translatedFormat('l, d F Y');
    //data cek menu dari database admin ($menuHariIni dari controller)
    $menuDb = (isset($menuHariIni) && ($menuHariIni instanceof \Illuminate\Support\Collection) && $menuHariIni->isNotEmpty())
        ? $menuHariIni
        : null;
    $isDariDb = false;
    if ($menuDb) {
        $isDariDb = true;
        $menuHariIni = [
            'tema'  => 'Menu MBG â€” ' . $curTgl->translatedFormat('l, d F Y'),
            'warna' => 'emerald',
            'items' => $menuDb->map(function ($item) {
                return [
                    'nama'    => $item->nama_item,
                    'takaran' => $item->takaran,
                    'energi'  => (float) $item->energi,
                    'protein' => (float) $item->protein,
                    'lemak'   => (float) $item->lemak,
                    'karbo'   => (float) $item->karbo,
                    'serat'   => (float) $item->serat,
                ];
            })->all(),
        ];
    } else {
        $hariIni     = (int) $curTgl->format('N'); // 1=Senin ... 7=Minggu
        $menuHariIni = $menuMingguan[$hariIni] ?? null; // null jika Minggu
    }
    $namaHari = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    if ($menuHariIni) {
        $totalEnergi  = collect($menuHariIni['items'])->sum('energi');
        $totalProtein = collect($menuHariIni['items'])->sum('protein');
        $totalLemak   = collect($menuHariIni['items'])->sum('lemak');
        $totalKarbo   = collect($menuHariIni['items'])->sum('karbo');
        $totalSerat   = collect($menuHariIni['items'])->sum('serat');
    }
@endphp
<section id="menu-section" class="py-20 bg-gradient-to-b from-slate-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{--section header--}}
        <div class="text-center mb-10">
            <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider">Informasi Gizi</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2 mb-3">
                Menu Harian MBG
            </h2>
            <div class="flex items-center justify-center gap-3 flex-wrap mt-3">
                <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-2 rounded-2xl text-sm font-semibold">
                    <i class="fa-regular fa-calendar-check text-emerald-500"></i>
                    {{ ucfirst($tanggalHariIni) }}
                    @if ($isToday)
                        <span class="ml-1 px-2 py-0.5 rounded-full bg-emerald-500 text-white font-bold text-[10px]">HARI INI</span>
                    @else
                        <span class="ml-1 px-2 py-0.5 rounded-full bg-slate-200 text-slate-700 font-semibold text-[10px]">ARSIP TANGGAL</span>
                    @endif
                </div>
                <!--form ganti tanggal-->
                <form method="GET" action="{{ route('home') }}#menu-section" class="inline-flex items-center gap-2 bg-white border border-slate-200 px-3 py-1.5 rounded-2xl shadow-xs">
                    <label for="pilih_tgl" class="text-xs text-slate-500 font-medium">Cek Tanggal Lain:</label>
                    <input type="date" id="pilih_tgl" name="tanggal" value="{{ $curTgl->toDateString() }}"
                           onchange="this.form.submit()"
                           class="text-xs font-semibold text-slate-700 bg-transparent focus:outline-none cursor-pointer">
                </form>
                @if (!$isToday)
                    <a href="{{ route('home') }}#menu-section" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3.5 py-2 rounded-2xl border border-emerald-200 transition">
                        <i class="fa-solid fa-rotate-left mr-1"></i> Hari Ini
                    </a>
                @endif
                <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-emerald-600 bg-white hover:bg-slate-50 px-4 py-2 rounded-2xl border border-slate-200 shadow-xs transition">
                    <i class="fa-solid fa-file-lines text-emerald-500"></i> Arsip Laporan &rarr;
                </a>
            </div>
        </div>
        @if (!$menuHariIni)
            <!--hari libur-->
            <div class="max-w-lg mx-auto text-center bg-white rounded-3xl border border-slate-200 shadow-xs p-12">
                <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-mug-hot text-3xl text-slate-400"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Hari Minggu Tidak Ada Distribusi</h3>
                <p class="text-sm text-slate-500">Program MBG berjalan pada hari sekolah (Senin – Sabtu). Selamat beristirahat!</p>
            </div>
        @else
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!--kiri: tabel rincian menu-->
                <div class="xl:col-span-2">
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                        <!--header tabel-->
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                @php
                                    $warnaBadge = [
                                        'emerald' => 'bg-emerald-100 text-emerald-700',
                                        'sky'     => 'bg-sky-100 text-sky-700',
                                        'amber'   => 'bg-amber-100 text-amber-700',
                                        'red'     => 'bg-red-100 text-red-700',
                                        'teal'    => 'bg-teal-100 text-teal-700',
                                        'purple'  => 'bg-purple-100 text-purple-700',
                                    ];
                                    $wb = $warnaBadge[$menuHariIni['warna']] ?? 'bg-slate-100 text-slate-700';
                                @endphp
                                <div class="w-10 h-10 rounded-xl {{ $wb }} flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-utensils text-base"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-800 text-base">{{ $menuHariIni['tema'] }}</h3>
                                    <p class="text-xs text-slate-500">Rincian nilai gizi per bahan makanan</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                @if (isset($laporanHariIni) && $laporanHariIni)
                                    <a href="{{ route('laporan.detail', $laporanHariIni->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold hover:bg-emerald-100 transition flex-shrink-0">
                                        <i class="fa-solid fa-file-lines text-emerald-600"></i> Baca Laporan Terkait
                                    </a>
                                @elseif ($isDariDb)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-semibold flex-shrink-0">
                                        <i class="fa-solid fa-circle-check text-emerald-600"></i> Terverifikasi Admin
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!--tabel-->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100">
                                        <th class="text-left px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider min-w-[140px]">Bahan Makanan</th>
                                        <th class="text-center px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Takaran</th>
                                        <th class="text-center px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                            <span class="text-amber-600">Energi</span><br><span class="font-normal text-slate-400 normal-case text-[10px]">(kkal)</span>
                                        </th>
                                        <th class="text-center px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                            <span class="text-sky-600">Protein</span><br><span class="font-normal text-slate-400 normal-case text-[10px]">(g)</span>
                                        </th>
                                        <th class="text-center px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                            <span class="text-orange-500">Lemak</span><br><span class="font-normal text-slate-400 normal-case text-[10px]">(g)</span>
                                        </th>
                                        <th class="text-center px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                            <span class="text-emerald-600">Karbo</span><br><span class="font-normal text-slate-400 normal-case text-[10px]">(g)</span>
                                        </th>
                                        <th class="text-center px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                            <span class="text-purple-600">Serat</span><br><span class="font-normal text-slate-400 normal-case text-[10px]">(g)</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach ($menuHariIni['items'] as $item)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="px-6 py-4">
                                                <span class="font-semibold text-slate-800 text-sm">{{ $item['nama'] }}</span>
                                            </td>
                                            <td class="px-4 py-4 text-center text-xs text-slate-500 font-medium">{{ $item['takaran'] }}</td>
                                            <td class="px-4 py-4 text-center">
                                                <span class="inline-block px-2 py-0.5 rounded-lg bg-amber-50 text-amber-700 font-bold text-xs">
                                                    {{ number_format($item['energi'] ?? 0, 0) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 text-center text-xs font-semibold text-sky-700">
                                                {{ number_format($item['protein'] ?? 0, 1) }}
                                            </td>
                                            <td class="px-4 py-4 text-center text-xs font-semibold text-orange-600">
                                                {{ number_format($item['lemak'] ?? 0, 1) }}
                                            </td>
                                            <td class="px-4 py-4 text-center text-xs font-semibold text-emerald-700">
                                                {{ number_format($item['karbo'] ?? 0, 1) }}
                                            </td>
                                            <td class="px-4 py-4 text-center text-xs font-semibold text-purple-600">
                                                {{ number_format($item['serat'] ?? 0, 1) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--baris total-->
                                <tfoot>
                                    <tr class="bg-slate-900 text-white">
                                        <td class="px-6 py-4 font-bold text-sm" colspan="2">
                                            <i class="fa-solid fa-sigma mr-1.5 text-emerald-400"></i> Total Sehari
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <span class="inline-block px-2.5 py-1 rounded-xl bg-amber-500 text-white font-extrabold text-sm shadow">
                                                {{ number_format($totalEnergi, 0) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-center font-bold text-sky-300 text-xs">{{ number_format($totalProtein, 1) }}</td>
                                        <td class="px-4 py-4 text-center font-bold text-orange-300 text-xs">{{ number_format($totalLemak, 1) }}</td>
                                        <td class="px-4 py-4 text-center font-bold text-emerald-300 text-xs">{{ number_format($totalKarbo, 1) }}</td>
                                        <td class="px-4 py-4 text-center font-bold text-purple-300 text-xs">{{ number_format($totalSerat, 1) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!--kanan: ringkasan gizi visual & foto-->
                <div class="flex flex-col gap-5">
                    <!--foto sajian menu dari laporan-->
                    @if (isset($laporanHariIni) && $laporanHariIni && $laporanHariIni->foto)
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-4 overflow-hidden">
                            <div class="flex items-center justify-between mb-2.5">
                                <span class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                                    <i class="fa-solid fa-camera text-emerald-600"></i> Foto Dokumentasi
                                </span>
                                <a href="{{ route('laporan.detail', $laporanHariIni->id) }}" class="text-[11px] font-semibold text-emerald-600 hover:text-emerald-700">
                                    Detail Laporan &rarr;
                                </a>
                            </div>
                            <div class="w-full max-w-md mx-auto aspect-video rounded-2xl overflow-hidden border border-slate-100 bg-slate-100">
                                <img src="{{ url('media/' . $laporanHariIni->foto) }}"
                                     alt="{{ $laporanHariIni->judul }}"
                                     class="block w-full h-full object-contain">
                            </div>
                        </div>
                    @endif
                    <!--total energi-->
                    <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-3xl p-6 text-white shadow-lg shadow-amber-500/25 text-center">
                        <i class="fa-solid fa-bolt text-3xl mb-2 text-amber-200"></i>
                        <p class="text-5xl font-extrabold">{{ number_format($totalEnergi, 0) }}</p>
                        <p class="text-sm font-semibold text-amber-100 mt-1">kkal / Hari</p>
                        <p class="text-xs text-amber-200 mt-2">Total Energi Menu Hari Ini</p>
                        @php
                            $persen = min(100, round(($totalEnergi / 700) * 100));
                        @endphp
                        <div class="mt-4 bg-white/20 rounded-full h-2.5 overflow-hidden">
                            <div class="h-full bg-white rounded-full transition-all duration-700" style="width: {{ $persen }}%"></div>
                        </div>
                        <p class="text-[11px] text-amber-200 mt-1.5">{{ $persen }}% dari AKE Makan Siang Sekolah (700 kkal)</p>
                    </div>
                    <!--ringkasan makronutrien-->
                    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 space-y-4">
                        <h4 class="text-sm font-bold text-slate-700 mb-1 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-emerald-600"></i> Ringkasan Makronutrien
                        </h4>
                        <!--protein-->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-sky-500 inline-block"></span> Protein
                                </span>
                                <span class="text-xs font-bold text-sky-700">{{ number_format($totalProtein, 1) }} g</span>
                            </div>
                            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-sky-500 rounded-full" style="width: {{ min(100, round(($totalProtein/35)*100)) }}%"></div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-0.5">Kebutuhan ~35g / makan siang</p>
                        </div>
                        <!--karbohidrat-->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span> Karbohidrat
                                </span>
                                <span class="text-xs font-bold text-emerald-700">{{ number_format($totalKarbo, 1) }} g</span>
                            </div>
                            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ min(100, round(($totalKarbo/100)*100)) }}%"></div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-0.5">Kebutuhan ~100g / makan siang</p>
                        </div>
                        <!--lemak-->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-orange-500 inline-block"></span> Lemak
                                </span>
                                <span class="text-xs font-bold text-orange-600">{{ number_format($totalLemak, 1) }} g</span>
                            </div>
                            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-orange-500 rounded-full" style="width: {{ min(100, round(($totalLemak/25)*100)) }}%"></div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-0.5">Kebutuhan ~25g / makan siang</p>
                        </div>
                        <!--serat-->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500 inline-block"></span> Serat
                                </span>
                                <span class="text-xs font-bold text-purple-700">{{ number_format($totalSerat, 1) }} g</span>
                            </div>
                            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-purple-500 rounded-full" style="width: {{ min(100, round(($totalSerat/12)*100)) }}%"></div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-0.5">Kebutuhan ~12g / makan siang</p>
                        </div>
                    </div>
                    <!--catatan-->
                    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4">
                        <p class="text-xs text-emerald-700 leading-relaxed">
                            <i class="fa-solid fa-circle-info mr-1"></i>
                            Nilai gizi berdasarkan Angka Kecukupan Gizi (AKG) BPOM 2019 untuk porsi makan siang siswa.
                            Menu dirotasi setiap minggu untuk memastikan variasi nutrisi.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
<!--berita terbaru-->
<section class="py-16 bg-slate-100/70 border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10">
            <div>
                <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider">Kabar Terkini</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mt-1">Berita & Informasi Program</h2>
            </div>
            <a href="{{ route('berita.index') }}" class="mt-4 sm:mt-0 text-sm font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                Lihat Semua Berita <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($berita_terbaru as $item)
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-md border border-slate-200 flex flex-col transition duration-200">
                    <div class="aspect-[3/4] w-full overflow-hidden bg-slate-100 relative">
                        @if ($item->thumbnail)
                            <img src="{{ url('media/' . $item->thumbnail) }}" alt="{{ $item->judul }}" class="w-full h-full object-contain transition duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400">
                                <i class="fa-solid fa-image text-3xl"></i>
                            </div>
                        @endif
                        <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-xs text-white text-xs px-2.5 py-1 rounded-lg">
                            {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d M Y') }}
                        </span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-lg text-slate-900 mb-2 line-clamp-2 hover:text-emerald-600 transition">
                                <a href="{{ route('berita.detail', $item->id) }}">{{ $item->judul }}</a>
                            </h3>
                            <p class="text-slate-600 text-sm line-clamp-3 mb-4 leading-relaxed">
                                {{ Str::limit(strip_tags($item->isi), 120) }}
                            </p>
                        </div>
                        <a href="{{ route('berita.detail', $item->id) }}" class="inline-flex items-center text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                            Baca Selengkapnya <i class="fa-solid fa-chevron-right text-xs ml-1.5"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-slate-200">
                    <i class="fa-regular fa-newspaper text-4xl text-slate-300 mb-3"></i>
                    <p class="text-slate-500 text-sm">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!--cuplikan galeri laporan-->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!--kolom laporan-->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider">Transparansi</span>
                        <h3 class="text-2xl font-bold text-slate-900">Laporan Terbaru</h3>
                    </div>
                    <a href="{{ route('laporan.index') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                        Semua Laporan &rarr;
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse ($laporan_terbaru as $laporan)
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs hover:border-emerald-300 transition">
                            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1.5">
                                <i class="fa-regular fa-calendar text-emerald-600"></i>
                                <span>{{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d F Y') }}</span>
                                <span>&bull;</span>
                                <i class="fa-regular fa-user text-slate-400"></i>
                                <span>{{ $laporan->penulis->nama ?? 'Admin' }}</span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-base mb-1">
                                <a href="{{ route('laporan.detail', $laporan->id) }}" class="hover:text-emerald-600 transition">
                                    {{ $laporan->judul }}
                                </a>
                            </h4>
                            <p class="text-slate-600 text-xs line-clamp-2 leading-relaxed mb-3">
                                {{ Str::limit(strip_tags($laporan->isi), 100) }}
                            </p>
                            <a href="{{ route('laporan.detail', $laporan->id) }}" class="text-xs font-semibold text-emerald-600 hover:underline">
                                Buka Laporan Detail &rarr;
                            </a>
                        </div>
                    @empty
                        <div class="p-6 text-center bg-white rounded-2xl border border-slate-200 text-slate-500 text-sm">
                            Belum ada laporan penyaluran.
                        </div>
                    @endforelse
                </div>
            </div>
            <!--kolom galeri-->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <span class="text-emerald-600 font-bold text-xs uppercase tracking-wider">Dokumentasi Visual</span>
                        <h3 class="text-2xl font-bold text-slate-900">Foto Kegiatan</h3>
                    </div>
                    <a href="{{ route('galeri.index') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                        Lihat Galeri &rarr;
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @forelse ($galeri_terbaru as $foto)
                        <div class="group relative aspect-[3/4] rounded-2xl overflow-hidden bg-slate-200 border border-slate-200 shadow-xs">
                            <img src="{{ url('media/' . $foto->file_path) }}" alt="{{ $foto->judul }}" class="w-full h-full object-contain transition duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-200 flex items-end p-3">
                                <p class="text-xs text-white font-medium line-clamp-2">{{ $foto->judul }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 p-8 text-center bg-white rounded-2xl border border-slate-200 text-slate-500 text-sm">
                            Belum ada foto dokumentasi diunggah.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection