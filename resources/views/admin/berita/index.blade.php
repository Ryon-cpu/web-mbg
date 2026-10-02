@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page_title', 'Kelola Berita & Publikasi')
@section('page_subtitle', 'Publikasikan artikel dan berita perkembangan program MBG')

@section('content')
<div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
    <!--header card-->
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="font-bold text-slate-800 text-base">Semua Berita MBG</h3>
            <p class="text-xs text-slate-500">Total berita: {{ $beritas->total() }} artikel</p>
        </div>
        <a href="{{ route('admin.berita.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition">
            <i class="fa-solid fa-plus"></i> Tulis Berita Baru
        </a>
    </div>
    <!--table-->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500">
                <tr>
                    <th class="py-4 px-6">No</th>
                    <th class="py-4 px-6">Thumbnail</th>
                    <th class="py-4 px-6">Judul Berita</th>
                    <th class="py-4 px-6">Tanggal Publikasi</th>
                    <th class="py-4 px-6 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($beritas as $index => $berita)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-4 px-6 text-slate-400 font-mono text-xs">
                            {{ $beritas->firstItem() + $index }}
                        </td>
                        <td class="py-4 px-6">
                            @if ($berita->thumbnail)
                                <img src="{{ url('media/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-16 h-12 object-cover rounded-xl border border-slate-200">
                            @else
                                <div class="w-16 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 text-xs">
                                    No Pic
                                </div>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-bold text-slate-900 max-w-sm">
                            <span class="block line-clamp-1">{{ $berita->judul }}</span>
                            <span class="text-xs font-normal text-slate-500 line-clamp-1">{{ Str::limit(strip_tags($berita->isi), 70) }}</span>
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">
                            {{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d M Y') }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if ($berita->status === 'publish')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold">
                                    Publish
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold">
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.berita.edit', $berita->id) }}" class="p-2 rounded-xl bg-slate-100 hover:bg-amber-100 text-slate-600 hover:text-amber-700 text-xs font-semibold transition" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-xl bg-slate-100 hover:bg-rose-100 text-slate-600 hover:text-rose-700 text-xs font-semibold transition" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <i class="fa-solid fa-newspaper text-3xl mb-2"></i>
                            <p>Belum ada artikel berita.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($beritas->hasPages())
        <div class="p-6 border-t border-slate-100">
            {{ $beritas->links() }}
        </div>
    @endif
</div>
@endsection