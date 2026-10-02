<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dokumentasi Makan Bergizi Gratis (MBG)')</title>
    <!--favicon-->
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpeg') }}?v={{ time() }}">
    <!--tailwind CSS-->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#16a34a',
                        'primary-dark': '#15803d',
                        secondary: '#0284c7',
                        accent: '#f59e0b',
                    }
                }
            }
        }
    </script>
    <!--google fonts inter-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!--fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen">
    <!--navbar-->
    <nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!--logo-->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-600/30 group-hover:scale-105 transition duration-200">
                        <i class="fa-solid fa-utensils text-xl"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold tracking-tight text-slate-900 flex items-center gap-1.5">
                            MBG <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-semibold uppercase tracking-wider">Nasional</span>
                        </span>
                        <p class="text-xs text-slate-500">Makan Bergizi Gratis</p>
                    </div>
                </a>
                <!--desktop menu-->
                <div class="hidden md:flex items-center gap-1 lg:gap-2 font-medium text-sm">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-house mr-1.5 text-xs opacity-70"></i> Beranda
                    </a>
                    <a href="{{ route('laporan.index') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('laporan.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-file-lines mr-1.5 text-xs opacity-70"></i> Laporan
                    </a>
                    <a href="{{ route('galeri.index') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('galeri.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-images mr-1.5 text-xs opacity-70"></i> Galeri
                    </a>
                    <a href="{{ route('data.index') }}" class="px-4 py-2 rounded-xl transition {{ request()->routeIs('data.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-slate-600 hover:text-emerald-600 hover:bg-slate-100' }}">
                        <i class="fa-solid fa-school mr-1.5 text-xs opacity-70"></i> Data Penerima
                    </a>
                </div>
                <!--admin action button-->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-slate-800 shadow-sm transition">
                            <i class="fa-solid fa-gauge-high text-xs"></i> Panel Admin
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:border-emerald-500 hover:text-emerald-600 transition">
                            <i class="fa-solid fa-lock text-xs"></i> Login Admin
                        </a>
                    @endauth
                </div>
                <!--mobile menu button-->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!--mobile menu dropdown-->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-5 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">Beranda</a>
            <a href="{{ route('laporan.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('laporan.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">Laporan</a>
            <a href="{{ route('galeri.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('galeri.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">Galeri</a>
            <a href="{{ route('data.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('data.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-50' }}">Data Penerima</a>
            <div class="pt-2 border-t border-slate-100">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white font-semibold text-sm">Panel Admin</a>
                @else
                    <a href="{{ route('admin.login') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-sm">Login Admin</a>
                @endauth
            </div>
        </div>
    </nav>
    <!--content-->
    <main class="flex-grow">
        @yield('content')
    </main>
    <!--footer-->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white">
                            <i class="fa-solid fa-utensils"></i>
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight">Dokumentasi MBG</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-md">
                        Sistem informasi dan dokumentasi resmi Program Makan Bergizi Gratis (MBG). Mewujudkan generasi sehat, cerdas, dan tangguh secara merata dan transparan.
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-semibold uppercase text-slate-200 tracking-wider mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Beranda</a></li>
                        <li><a href="{{ route('laporan.index') }}" class="hover:text-emerald-400 transition">Laporan Kegiatan</a></li>
                        <li><a href="{{ route('galeri.index') }}" class="hover:text-emerald-400 transition">Galeri Foto</a></li>
                        <li><a href="{{ route('data.index') }}" class="hover:text-emerald-400 transition">Data Sekolah Penerima</a></li>
                        <li><a href="{{ route('berita.index') }}" class="hover:text-emerald-400 transition">Berita & Informasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Program Makan Bergizi Gratis (MBG). Hak cipta dilindungi.</p>
                <p class="mt-2 sm:mt-0">Dikelola secara transparan & akuntabel</p>
            </div>
        </div>
    </footer>
    @vite('resources/js/publik.js')
    @stack('scripts')
</body>
</html>