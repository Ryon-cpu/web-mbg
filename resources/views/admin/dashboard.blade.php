@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Ringkasan')
@section('page_subtitle', 'Statistik dan ringkasan aktivitas dokumentasi MBG')

@section('content')
<!--quick action buttons-->
<div class="mb-8 flex flex-wrap gap-3">
    <a href="{{ route('admin.laporan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition">
        <i class="fa-solid fa-plus"></i> Tulis Laporan Baru
    </a>
    <a href="{{ route('admin.galeri.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold shadow-xs transition">
        <i class="fa-solid fa-upload"></i> Unggah Foto Galeri
    </a>
    <a href="{{ route('admin.data.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold shadow-xs transition">
        <i class="fa-solid fa-school"></i> Tambah Sekolah Penerima
    </a>
</div>
<!--stat cards-->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Total Laporan</p>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_laporan']) }}</h3>
            <a href="{{ route('admin.laporan.index') }}" class="text-xs text-emerald-600 hover:underline font-semibold mt-2 inline-block">Kelola Laporan &rarr;</a>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-file-contract"></i>
        </div>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Galeri Foto</p>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_galeri']) }}</h3>
            <a href="{{ route('admin.galeri.index') }}" class="text-xs text-sky-600 hover:underline font-semibold mt-2 inline-block">Kelola Galeri &rarr;</a>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-camera"></i>
        </div>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Total Sekolah Sasaran</p>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_sekolah']) }}</h3>
            <a href="{{ route('admin.data.index') }}" class="text-xs text-amber-600 hover:underline font-semibold mt-2 inline-block">Kelola Data &rarr;</a>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-school"></i>
        </div>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Total Porsi / Siswa</p>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_penerima']) }}</h3>
            <span class="text-xs text-slate-400">Porsi disalurkan</span>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>
</div>
<!--grid 2 kolom: aktivitas terbaru-->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Laporan Terbaru -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-emerald-600"></i> Laporan Terbaru
            </h3>
            <a href="{{ route('admin.laporan.index') }}" class="text-xs font-semibold text-emerald-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="space-y-3">
            @forelse ($recent_laporan as $laporan)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 hover:bg-slate-100 transition">
                    <div class="overflow-hidden pr-3">
                        <h4 class="font-bold text-sm text-slate-800 truncate">{{ $laporan->judul }}</h4>
                        <p class="text-xs text-slate-500">
                            {{ \Carbon\Carbon::parse($laporan->tanggal)->translatedFormat('d M Y') }} &bull; Oleh {{ $laporan->penulis->nama ?? 'Admin' }}
                        </p>
                    </div>
                    <a href="{{ route('admin.laporan.edit', $laporan->id) }}" class="p-2 rounded-xl text-slate-400 hover:text-emerald-600 hover:bg-white text-xs font-semibold flex-shrink-0">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </div>
            @empty
                <p class="text-xs text-slate-400 text-center py-6">Belum ada laporan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection