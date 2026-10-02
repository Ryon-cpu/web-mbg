<?php

use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DataPenerimaController as AdminDataPenerimaController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Read-Only)
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/laporan', [PublicController::class, 'laporan'])->name('laporan.index');
Route::get('/laporan/{id}', [PublicController::class, 'laporanDetail'])->name('laporan.detail');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri.index');
Route::get('/data', [PublicController::class, 'data'])->name('data.index');
Route::get('/berita', [PublicController::class, 'berita'])->name('berita.index');
Route::get('/berita/{id}', [PublicController::class, 'beritaDetail'])->name('berita.detail');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Admin)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes (Middleware: auth & role admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Profil Admin
    Route::get('/profil', [AdminDashboardController::class, 'showProfile'])->name('profil');
    Route::post('/profil', [AdminDashboardController::class, 'updateProfile'])->name('profil.update');
    Route::post('/profil/account', [AdminDashboardController::class, 'updateAccount'])->name('profil.account');
    Route::post('/profil/password', [AdminDashboardController::class, 'updatePassword'])->name('profil.password');
    Route::post('/profil/photo/delete', [AdminDashboardController::class, 'deletePhoto'])->name('profil.photo.delete');
    // Laporan (index, create, store, edit, update, destroy)
    Route::resource('laporan', AdminLaporanController::class)->except(['show']);
    // Galeri (index, create, store, destroy)
    Route::resource('galeri', AdminGaleriController::class)->only(['index', 'create', 'store', 'destroy']);
    // Data Penerima (index, create, store, edit, update, destroy)
    Route::resource('data', AdminDataPenerimaController::class)->except(['show']);
    // Berita (index, create, store, edit, update, destroy)
    Route::resource('berita', AdminBeritaController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Storage Asset Handler (Shared Hosting / InfinityFree Compatibility)
|--------------------------------------------------------------------------
*/
Route::get('/media/{path}', function ($path) {
    $candidates = [
        storage_path('app/public/' . $path),
        public_path('storage/' . $path),
        storage_path('app/' . $path),
    ];

    foreach ($candidates as $filePath) {
        if (file_exists($filePath) && !is_dir($filePath)) {
            $mime = @mime_content_type($filePath) ?: 'application/octet-stream';
            return response()->file($filePath, [
                'Content-Type' => $mime,
                'Cache-Control' => 'public, max-age=604800',
            ]);
        }
    }

    abort(404);
})->where('path', '.*')->name('media.serve');