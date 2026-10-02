@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page_title', 'Edit Berita MBG')
@section('page_subtitle', 'Perbarui informasi dan publikasi berita')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="judul" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Judul Berita <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Thumbnail Saat Ini
                </label>
                @if ($berita->thumbnail)
                    <div class="mb-3 w-40 aspect-video rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                        <img src="{{ url('media/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
                    </div>
                @endif
                <label for="thumbnail" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Ganti Thumbnail (Kosongkan jika tidak ingin mengubah)
                </label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/jpeg,image/png,image/jpg,image/webp" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal_publish" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Tanggal Publikasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="tanggal_publish" name="tanggal_publish" value="{{ old('tanggal_publish', $berita->tanggal_publish) }}" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
                </div>
                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Status Publikasi <span class="text-rose-500">*</span>
                    </label>
                    <select id="status" name="status" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
                        <option value="draft" {{ old('status', $berita->status) === 'draft' ? 'selected' : '' }}>Draft (Disimpan Sementara)</option>
                        <option value="publish" {{ old('status', $berita->status) === 'publish' ? 'selected' : '' }}>Publish (Tampil ke Publik)</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="isi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Isi Lengkap Berita <span class="text-rose-500">*</span>
                </label>
                <textarea id="isi" name="isi" rows="10" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">{{ old('isi', $berita->isi) }}</textarea>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-xs transition">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i> Perbarui Berita
                </button>
                <a href="{{ route('admin.berita.index') }}" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection