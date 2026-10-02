@extends('layouts.admin')

@section('title', 'Tambah Laporan & Menu MBG')
@section('page_title', 'Buat Laporan Baru')
@section('page_subtitle', 'Tulis dokumentasi laporan penyaluran MBG beserta foto dan rincian menu makanan')

@push('styles')
@vite('resources/css/laporan_create.css')
@endpush

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    @if (isset($errors) && $errors->any())
        <div class="flex items-start gap-3 bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl text-sm">
            <i class="fa-solid fa-circle-exclamation text-rose-500 mt-0.5 flex-shrink-0 text-base"></i>
            <div>
                <p class="font-semibold mb-1">Periksa kembali input formulir:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <form action="{{ route('admin.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <!--card 1: informasi laporan-->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8 space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                    <i class="fa-solid fa-file-lines text-base"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Informasi Kegiatan Penyaluran</h3>
                    <p class="text-xs text-slate-500">Judul laporan, tanggal penyaluran, dan catatan evaluasi</p>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="judul" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Judul Laporan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                           placeholder="Contoh: Penyaluran Makan Siang Bergizi di SDN 01..."
                           class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
                </div>
                <div>
                    <label for="tanggal" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Tanggal Distribusi <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                           class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">
                </div>
            </div>
            <div>
                <label for="isi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Isi Laporan & Catatan Evaluasi <span class="text-rose-500">*</span>
                </label>
                <textarea id="isi" name="isi" rows="5" required
                          placeholder="Tuliskan dokumentasi kegiatan penyaluran, respons peserta didik, catatan higiene makanan, dan evaluasi porsi..."
                          class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-sm">{{ old('isi') }}</textarea>
            </div>
        </div>
        <!--card 2: foto dokumentasi / menu makanan-->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100 mb-6">
                <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center">
                    <i class="fa-solid fa-camera text-base"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Foto Dokumentasi / Menu Makanan</h3>
                    <p class="text-xs text-slate-500">Unggah foto sajian menu atau kegiatan penyaluran MBG</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Pilih File Foto
                    </label>
                    <div id="foto-upload-area" class="relative border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-2xl p-6 text-center transition bg-slate-50 hover:bg-emerald-50/20 cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400 mb-2"></i>
                        <p class="text-sm font-semibold text-slate-700">Klik untuk memilih foto dokumentasi</p>
                        <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, atau WEBP (Maks. 5 MB)</p>
                        <input type="file" id="foto" name="foto" accept="image/*" class="hidden">
                    </div>
                </div>
                <!--preview area-->
                <div class="text-center">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Pratinjau Foto</p>
                    <div id="foto-preview-box" class="w-full aspect-video rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                        <span id="preview-placeholder" class="text-xs text-slate-400">Belum ada foto</span>
                        <img id="foto-preview" src="#" alt="Preview" class="w-full h-full object-contain p-1 hidden">
                    </div>
                </div>
            </div>
        </div>
        <!--card 3: rincian menu & kandungan gizi MBG-->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
                        <i class="fa-solid fa-bowl-food text-base"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Rincian Menu & Kandungan Gizi</h3>
                        <p class="text-xs text-slate-500">Rincian item bahan makanan, takaran gram, dan estimasi nutrisi</p>
                    </div>
                </div>
                <button type="button" id="add-row-btn"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition shadow-xs">
                    <i class="fa-solid fa-plus"></i> Tambah Bahan
                </button>
            </div>
            <div class="overflow-x-auto">
                @php
                    $defaultItems = old('items', [
                        ['nama_item'=>'Nasi Putih', 'takaran'=>'200 g', 'energi'=>260, 'protein'=>4.8, 'lemak'=>0.4, 'karbo'=>57.2, 'serat'=>0.6],
                        ['nama_item'=>'Lauk Utama (Ayam/Ikan)', 'takaran'=>'80 g', 'energi'=>190, 'protein'=>18.0, 'lemak'=>12.0, 'karbo'=>0.5, 'serat'=>0.2],
                        ['nama_item'=>'Sayur-Mayur', 'takaran'=>'80 g', 'energi'=>30, 'protein'=>2.5, 'lemak'=>0.4, 'karbo'=>4.0, 'serat'=>2.0],
                        ['nama_item'=>'Lauk Nabati (Tahu/Tempe)', 'takaran'=>'50 g', 'energi'=>90, 'protein'=>8.0, 'lemak'=>5.0, 'karbo'=>5.0, 'serat'=>1.2],
                        ['nama_item'=>'Buah Segar', 'takaran'=>'100 g', 'energi'=>50, 'protein'=>0.8, 'lemak'=>0.2, 'karbo'=>12.0, 'serat'=>2.0],
                        ['nama_item'=>'Air Mineral', 'takaran'=>'350 ml', 'energi'=>0, 'protein'=>0.0, 'lemak'=>0.0, 'karbo'=>0.0, 'serat'=>0.0],
                    ]);
                @endphp
                <table class="w-full text-sm" id="items-table" data-row-index="{{ count($defaultItems) }}">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="text-left px-4 py-3 min-w-[170px]">Nama Bahan / Makanan <span class="text-rose-400">*</span></th>
                            <th class="text-left px-3 py-3 min-w-[110px]">Takaran <span class="text-rose-400">*</span></th>
                            <th class="text-center px-3 py-3 min-w-[85px]"><span class="text-amber-600">Energi</span> (kkal)</th>
                            <th class="text-center px-3 py-3 min-w-[85px]"><span class="text-sky-600">Protein</span> (g)</th>
                            <th class="text-center px-3 py-3 min-w-[85px]"><span class="text-orange-500">Lemak</span> (g)</th>
                            <th class="text-center px-3 py-3 min-w-[85px]"><span class="text-emerald-600">Karbo</span> (g)</th>
                            <th class="text-center px-3 py-3 min-w-[85px]"><span class="text-purple-600">Serat</span> (g)</th>
                            <th class="px-3 py-3 w-10"></th>
                        </tr>
                    </thead>
                    <tbody id="items-body">
                        @foreach ($defaultItems as $i => $item)
                        <tr class="item-row border-b border-slate-50" data-index="{{ $i }}">
                            <td class="px-4 py-2.5">
                                <input type="text" name="items[{{ $i }}][nama_item]" placeholder="Contoh: Nasi Putih..."
                                       value="{{ $item['nama_item'] ?? '' }}" required
                                       class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-xs">
                            </td>
                            <td class="px-3 py-2.5">
                                <input type="text" name="items[{{ $i }}][takaran]" placeholder="Contoh: 200 g"
                                       value="{{ $item['takaran'] ?? '' }}" required
                                       class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-xs">
                            </td>
                            @foreach (['energi','protein','lemak','karbo','serat'] as $field)
                            <td class="px-3 py-2.5 text-center">
                                <input type="number" name="items[{{ $i }}][{{ $field }}]" placeholder="0"
                                       value="{{ $item[$field] ?? 0 }}" min="0" step="0.001" required
                                       class="w-full px-2 py-2 rounded-xl bg-slate-50 border border-slate-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 text-xs text-center">
                            </td>
                            @endforeach
                            <td class="px-3 py-2.5 text-center">
                                <button type="button" class="delete-row-btn p-1.5 rounded-lg text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition" title="Hapus baris">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-900 text-white text-xs font-bold">
                            <td class="px-4 py-3" colspan="2"><i class="fa-solid fa-sigma mr-1.5 text-emerald-400"></i> Total Nutrisi</td>
                            <td class="px-3 py-3 text-center"><span id="total-energi" class="text-amber-300">0</span> kkal</td>
                            <td class="px-3 py-3 text-center"><span id="total-protein" class="text-sky-300">0</span> g</td>
                            <td class="px-3 py-3 text-center"><span id="total-lemak" class="text-orange-300">0</span> g</td>
                            <td class="px-3 py-3 text-center"><span id="total-karbo" class="text-emerald-300">0</span> g</td>
                            <td class="px-3 py-3 text-center"><span id="total-serat" class="text-purple-300">0</span> g</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!--tombol aksi-->
        <div class="flex items-center justify-between gap-4 pt-2">
            <a href="{{ route('admin.laporan.index') }}"
               class="px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 font-semibold text-sm transition">
                <i class="fa-solid fa-arrow-left text-xs mr-1"></i> Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 px-8 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm transition shadow-lg shadow-emerald-600/25 active:scale-95">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Laporan Lengkap
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
@vite('resources/js/laporan_create.js')
@endpush