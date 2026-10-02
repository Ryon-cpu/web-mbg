<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - MBG</title>
    <!--favicon-->
    <link rel="icon" type="image/jpeg" href="{{ asset('favicon.jpeg') }}?v={{ time() }}">
    <!--tailwind css-->
    <script src="https://cdn.tailwindcss.com"></script>
    <!--google fonts inter-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!--fontawesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-900 to-emerald-950 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!--logo & header-->
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-gradient-to-tr from-emerald-500 to-teal-400 text-white shadow-xl shadow-emerald-500/20 mb-4 hover:scale-105 transition">
                <i class="fa-solid fa-utensils text-2xl"></i>
            </a>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Login Administrator</h1>
            <p class="text-sm text-slate-400 mt-1">Portal Pengelolaan Dokumentasi MBG</p>
        </div>
        <!--login card-->
        <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-2xl border border-slate-100 relative">
            <!--flash errors/notification-->
            @if(session('error'))
                <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @if(session('success'))
                <div class="mb-5 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium">
                    <p class="font-bold mb-1">Gagal Masuk:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf
                <!--input email-->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com" class="w-full pl-11 pr-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm text-slate-800">
                    </div>
                </div>
                <!--input password-->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                        <input type="password" id="password" name="password" required placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" class="w-full pl-11 pr-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm text-slate-800">
                    </div>
                </div>
                <!--remember me-->
                <div class="flex items-center justify-between text-xs text-slate-600">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-emerald-600 border-slate-300 focus:ring-emerald-500">
                        <span>Ingat saya</span>
                    </label>
                    <span class="text-slate-400">Khusus Role Admin</span>
                </div>
                <!--submit button-->
                <button type="submit" class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-lg shadow-emerald-600/30 transition transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-arrow-right-to-bracket mr-2"></i> Masuk ke Dashboard
                </button>
            </form>
            <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs font-semibold text-slate-500 hover:text-emerald-600 inline-flex items-center gap-1.5 transition">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Publik
                </a>
            </div>
        </div>
    </div>
</body>
</html>