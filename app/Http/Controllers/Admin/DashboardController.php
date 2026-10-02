<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\DataPenerima;
use App\Models\Galeri;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller{
    public function index(){
        $stats = [
            'total_laporan' => Laporan::count(),
            'total_galeri' => Galeri::count(),
            'total_sekolah' => DataPenerima::count(),
            'total_penerima' => DataPenerima::sum('jumlah_penerima'),
            'total_berita' => Berita::count(),
            'berita_publish' => Berita::where('status', 'publish')->count(),
            'berita_draft' => Berita::where('status', 'draft')->count(),
        ];
        $recent_laporan = Laporan::with('penulis')->latest()->take(5)->get();
        $recent_berita = Berita::latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recent_laporan', 'recent_berita'));
    }

    /**
     * Tampilkan halaman profil admin.
     */
    public function showProfile(){
        return view('admin.ggg');
    }

    /**
     * Update data akun admin (nama & email).
     */
    public function updateAccount(Request $request){
        $user = auth()->user();

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email sudah digunakan oleh akun lain.',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Informasi akun profil berhasil diperbarui!');
    }

    /**
     * Update kata sandi admin.
     */
    public function updatePassword(Request $request){
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini yang Anda masukkan salah.'])->with('error', 'Kata sandi saat ini tidak cocok.');
        }

        $user->password = $request->password;
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui!');
    }

    /**
     * Hapus foto profil admin (reset ke default avatar).
     */
    public function deletePhoto(){
        $paths = [
            public_path('images/profile.jpeg'),
            public_path('images/profile.png'),
            public_path('images/profile.jpg'),
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        return back()->with('success', 'Foto profil berhasil dihapus dan dikembalikan ke avatar default!');
    }

    /**
     * Update foto profil admin (menyimpan hasil crop base64 ke public/images/profile.jpeg).
     */
    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'cropped_image' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Data tidak valid.');
        }

        $imageData = $request->input('cropped_image');

        // Validasi format base64 image
        if (!preg_match('/^data:image\/(jpeg|jpg|png|webp);base64,/', $imageData)) {
            return back()->with('error', 'Format gambar tidak valid. Hanya JPEG, PNG, atau WebP yang diizinkan.');
        }

        // Ambil data base64 murni
        $base64 = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
        $decoded = base64_decode($base64);

        if ($decoded === false) {
            return back()->with('error', 'Gagal memproses gambar. Silakan coba lagi.');
        }

        // Batas ukuran: 5MB
        if (strlen($decoded) > 5 * 1024 * 1024) {
            return back()->with('error', 'Ukuran foto maksimal 5MB.');
        }

        $targetPath = public_path('images/profile.jpeg');

        // Pastikan folder ada
        if (!is_dir(public_path('images'))) {
            mkdir(public_path('images'), 0755, true);
        }

        // Simpan sebagai JPEG menggunakan GD
        $sourceImage = @imagecreatefromstring($decoded);
        if ($sourceImage === false) {
            return back()->with('error', 'Format gambar tidak didukung atau gambar rusak.');
        }

        // Resize ke 400x400 (square crop sudah dilakukan di frontend)
        $w = imagesx($sourceImage);
        $h = imagesy($sourceImage);
        $output = imagecreatetruecolor(400, 400);

        // Isi latar belakang putih untuk menangani PNG/WebP transparan
        $white = imagecolorallocate($output, 255, 255, 255);
        imagefilledrectangle($output, 0, 0, 400, 400, $white);

        imagecopyresampled($output, $sourceImage, 0, 0, 0, 0, 400, 400, $w, $h);
        imagejpeg($output, $targetPath, 90);
        // Simpan juga salinan profile.png untuk kompatibilitas
        imagepng($output, public_path('images/profile.png'));
        imagedestroy($sourceImage);
        imagedestroy($output);

        // Buang cache browser dengan query string timestamp
        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}