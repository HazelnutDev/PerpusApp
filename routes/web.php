<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RakController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PetugasProfileController;
use App\Http\Controllers\AnggotaNonSiswaController;
use App\Http\Controllers\DetailPeminjamanController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Route::match(['get', 'post'], 'login', [AuthController::class, 'login'])->name('login');
    Route::match(['get', 'post'], 'register', [AuthController::class, 'register'])->name('register');
    Route::match(['get', 'post'], 'forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::match(['get', 'post'], 'reset-password/{username}', [AuthController::class, 'resetPassword'])->name('resetPassword');
});

// Authenticated routes for petugas
Route::middleware(['auth:petugas'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::match(['get', 'post'], 'change-password', [AuthController::class, 'changePassword'])->name('change-password');

    // Petugas routes
    Route::resource('petugas', PetugasController::class);
    // Profile routes
    Route::get('/petugas-profil', [PetugasController::class, 'index1'])->name('petugas.profil');
    Route::put('/petugas-profil', [PetugasController::class, 'update'])->name('petugas.profil');


    // Buku routes
    Route::resource('buku', BukuController::class);

    // Anggota routes
    Route::resource('anggota', AnggotaController::class);

    // Anggota Non Siswa routes
    Route::resource('anggota-non-siswa', AnggotaNonSiswaController::class);

    // Unified Peminjaman routes
    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('peminjaman/hitung-denda/{id}', [PeminjamanController::class, 'hitungDenda'])->name('peminjaman.hitung-denda');
    Route::resource('detail-peminjaman', DetailPeminjamanController::class);
    
    // Unified Pengembalian routes
    Route::resource('pengembalian', PengembalianController::class);
    Route::get('pengembalian/{nomorKembali}/print', [PengembalianController::class, 'print'])->name('pengembalian.print');

    // Laporan routes
    Route::prefix('laporan')->name('laporan.')->group(function () {
        // Laporan Peminjaman
        Route::get('peminjaman', [LaporanController::class, 'peminjaman'])->name('peminjaman.index');
        Route::get('peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('peminjaman.cetak');
        
        // Laporan Keterlambatan
        Route::get('keterlambatan', [LaporanController::class, 'keterlambatan'])->name('keterlambatan.index');
        Route::get('keterlambatan/cetak', [LaporanController::class, 'cetakKeterlambatan'])->name('keterlambatan.cetak');

        // Laporan Buku Populer
        Route::get('buku-populer', [LaporanController::class, 'bukuPopuler'])->name('buku-populer.index');
        Route::get('buku-populer/cetak', [LaporanController::class, 'cetakBukuPopuler'])->name('buku-populer.cetak');
        
        // Laporan Anggota
        Route::get('anggota', [LaporanController::class, 'anggota'])->name('anggota.index');
        Route::get('anggota/cetak', [LaporanController::class, 'cetakAnggota'])->name('anggota.cetak');
        
        // Laporan Buku
        Route::get('buku', [LaporanController::class, 'buku'])->name('buku.index');
        Route::get('buku/cetak', [LaporanController::class, 'cetakBuku'])->name('buku.cetak');
    });
});
