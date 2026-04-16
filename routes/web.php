<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\ExportController;

// ===== RATE LIMITER =====
RateLimiter::for('kirim-pengaduan', function(Request $request){
    return Limit::perMinute(5)->by($request->ip())
        ->response(function(){
            return back()->with('error', 'Terlalu banyak permintaan. Silakan tunggu beberapa saat.');
        });
});

RateLimiter::for('admin-login', function(Request $request){
    return Limit::perMinute(5)->by($request->ip())
        ->response(function(){
            return back()->with('error', 'Terlalu banyak percobaan login. Silakan tunggu beberapa saat.');
        });
});

// ===== SISWA ROUTES =====
Route::get('/', [AspirasiController::class, 'index'])->name('home');
Route::get('/form', [AspirasiController::class, 'create'])->name('form');
Route::post('/kirim', [AspirasiController::class, 'store'])
    ->middleware('throttle:kirim-pengaduan')
    ->name('kirim');
Route::get('/cek', [AspirasiController::class, 'cekForm'])->name('cek.form');
Route::post('/cek-status', [AspirasiController::class, 'cekStatus'])
    ->middleware('throttle:5,1')
    ->name('cek.status');

// ===== ADMIN AUTH =====
Route::get('/admin', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'cekLogin'])
    ->middleware('throttle:admin-login')
    ->name('admin.cekLogin');
Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::post('/akses-admin', [AdminController::class, 'aksesRahasia'])
    ->middleware('throttle:admin-login')
    ->name('admin.aksesRahasia');

// ===== ADMIN PANEL =====
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function(){

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Aspirasi
    Route::get('/aspirasi/{id}', [AdminController::class, 'showAspirasi'])->name('aspirasi.show');
    Route::post('/update/{id}', [AdminController::class, 'update'])->name('aspirasi.update');
    Route::delete('/aspirasi/{id}', [AdminController::class, 'destroyAspirasi'])->name('aspirasi.destroy');

    // Lampiran
    Route::post('/aspirasi/{id}/lampiran', [AdminController::class, 'uploadLampiran'])->name('aspirasi.lampiran');
    Route::delete('/aspirasi/{id}/lampiran', [AdminController::class, 'hapusLampiran'])->name('aspirasi.lampiran.hapus');

    // Kategori
    Route::get('/kategori', [AdminController::class, 'kategori'])->name('kategori.index');
    Route::post('/kategori/store', [AdminController::class, 'storeKategori'])->name('kategori.store');
    Route::put('/kategori/{id}', [AdminController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{id}', [AdminController::class, 'destroyKategori'])->name('kategori.destroy');

    // Siswa
    Route::get('/siswa', [AdminController::class, 'siswa'])->name('siswa.index');
    Route::post('/siswa/store', [AdminController::class, 'storeSiswa'])->name('siswa.store');
    Route::put('/siswa/{nis}', [AdminController::class, 'updateSiswa'])->name('siswa.update');
    Route::delete('/siswa/{nis}', [AdminController::class, 'destroySiswa'])->name('siswa.destroy');

    // Export
    Route::get('/export/pdf', [ExportController::class, 'pdf'])->name('export.pdf');
    Route::get('/export/excel', [ExportController::class, 'excel'])->name('export.excel');
});