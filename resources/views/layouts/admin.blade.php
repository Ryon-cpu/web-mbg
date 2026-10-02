<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin MBG') - Panel Administrasi</title>
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
                        slateDark: '#0f172a',
                    }
                }
            }
        }
    </script>
    <!--google fonts inter-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!--font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/admin.js'])
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 antialiased overflow-x-hidden">
    <!--backdrop overlay khusus mobile -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-40 hidden transition-opacity duration-300 opacity-0 md:hidden"></div>
    <div class="min-h-screen flex flex-col md:flex-row">
        <!--sidebar: di desktop tetap normal, di mobile buka-tutup -->
        <aside id="admin-sidebar" class="bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col justify-between">
            <div class="flex flex-col h-full overflow-hidden">
                <!--brand header & tombol close (mobile saja) -->
                <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800 flex-shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white font-bold shadow-md flex-shrink-0">
                            <i class="fa-solid fa-utensils"></i>
                        </div>
                        <div class="overflow-hidden">
                            <span class="text-lg font-bold text-white tracking-tight block truncate">Admin MBG</span>
                            <p class="text-xs text-emerald-400 font-medium">Panel Kontrol</p>
                        </div>
                    </div>
                    <!--tombol close hanya tampil di mobile-->
                    <button id="close-sidebar-btn" type="button" class="md:hidden p-2 rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 transition focus:outline-none" aria-label="Tutup Sidebar">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                <!--navigation links with smooth scrollbar-->
                <div class="flex-1 overflow-y-auto custom-scrollbar px-4 py-6 space-y-1 text-sm font-medium">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 font-semibold' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-gauge-high w-5 text-center text-base"></i>
                        <span>Dashboard</span>
                    </a>
                    <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Kelola Konten
                    </div>
                    <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.laporan.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 font-semibold' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-file-signature w-5 text-center text-base"></i>
                        <span>Laporan</span>
                    </a>
                    <a href="{{ route('admin.galeri.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.galeri.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 font-semibold' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-photo-film w-5 text-center text-base"></i>
                        <span>Galeri Foto</span>
                    </a>
                    <a href="{{ route('admin.data.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.data.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 font-semibold' : 'hover:bg-slate-800 text-slate-300 hover:text-white' }}">
                        <i class="fa-solid fa-school w-5 text-center text-base"></i>
                        <span>Data Penerima</span>
                    </a>
                    <div class="pt-4 pb-1 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Website Publik
                    </div>
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-emerald-400 transition">
                        <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center text-base"></i>
                        <span>Lihat Web Publik</span>
                    </a>
                </div>
                <!--current user & logout-->
                <div class="p-4 border-t border-slate-800 flex-shrink-0 bg-slate-900">
                    <a href="{{ route('admin.profil') }}" class="flex items-center gap-3 px-3 py-2 mb-3 bg-slate-800/60 hover:bg-slate-700/60 rounded-xl transition group">
                        <div class="w-9 h-9 rounded-lg overflow-hidden flex-shrink-0 border-2 border-slate-700 group-hover:border-emerald-500 transition">
                            <img
                                src="{{ asset('images/profile.jpeg') }}?v={{ time() }}"
                                alt="Foto Profil"
                                class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-full h-full bg-emerald-500/20 text-emerald-400 items-center justify-center font-bold text-sm hidden" style="display:none">
                                {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                            </div>
                        </div>
                        <div class="overflow-hidden min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->nama ?? 'Admin' }}</p>
                            <p class="text-xs text-emerald-400 truncate">Klik untuk edit profil</p>
                        </div>
                        <i class="fa-solid fa-pen text-slate-500 group-hover:text-emerald-400 text-xs ml-auto flex-shrink-0 transition"></i>
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold text-sm transition">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar (Logout)
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        <!--main content area: di samping sidebar saat desktop, penuh saat mobile-->
        <div class="flex-1 flex flex-col min-w-0">
            <!--topbar header-->
            <header class="h-20 bg-white border-b border-slate-200 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs">
                <div class="flex items-center gap-3 sm:gap-4">
                    <!--toggle sidebar button(hanya muncul di mobile)-->
                    <button id="toggle-sidebar-btn" type="button" class="md:hidden p-2.5 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 border border-slate-200 flex items-center justify-center transition shadow-2xs focus:outline-none" title="Buka Menu" aria-label="Buka Menu">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold text-slate-800 leading-tight">@yield('page_title', 'Dashboard')</h1>
                        <p class="text-xs text-slate-500 hidden sm:block">@yield('page_subtitle', 'Kelola informasi dokumentasi program MBG')</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:text-emerald-600 hover:border-emerald-300 hover:bg-emerald-50/50 transition">
                        <i class="fa-solid fa-arrow-up-right-from-square text-2xs"></i>
                        <span>Lihat Web</span>
                    </a>
                    <span class="text-xs px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="hidden xs:inline">Admin</span> Aktif
                    </span>
                </div>
            </header>
            <!--main body-->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto">
                <!--flash notification: success-->
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-xs">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5"></i>
                        <div>
                            <h4 class="font-semibold text-sm">Berhasil!</h4>
                            <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif
                <!--flash notification: error-->
                @if (session('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start gap-3 shadow-xs">
                        <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg mt-0.5"></i>
                        <div>
                            <h4 class="font-semibold text-sm">Terjadi Kesalahan!</h4>
                            <p class="text-sm text-rose-700">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif
                <!--validation errors alert-->
                @if (isset($errors) && $errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 flex items-start gap-3 shadow-xs">
                        <i class="fa-solid fa-circle-exclamation text-amber-600 text-lg mt-0.5"></i>
                        <div>
                            <h4 class="font-semibold text-sm">Silakan periksa kembali input Anda:</h4>
                            <ul class="list-disc list-inside text-sm text-amber-700 mt-1 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>