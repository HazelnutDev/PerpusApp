<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
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

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::match(['get', 'post'], 'change-password', [AuthController::class, 'changePassword'])->name('change-password');

    // Admin-only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('petugas', PetugasController::class);
        Route::resource('buku', BukuController::class)->except(['index', 'show']);
        Route::resource('anggota', AnggotaController::class)->except(['index', 'show']);
        Route::resource('anggota-non-siswa', AnggotaNonSiswaController::class)->except(['index', 'show']);
        Route::delete('peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
        Route::delete('detail-peminjaman/{no_pinjam}/{kode_buku}', [DetailPeminjamanController::class, 'destroy'])->name('detail-peminjaman.destroy.custom');
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('laporanBuku', [LaporanController::class, 'laporanBuku'])->name('laporanBuku.index');
            Route::get('laporanBuku/cetak', [LaporanController::class, 'cetakLaporanBuku'])->name('laporanBuku.cetak');
            Route::get('laporanAnggota', [LaporanController::class, 'laporanAnggota'])->name('laporanAnggota.index');
            Route::get('laporanAnggota/cetak', [LaporanController::class, 'cetakLaporanAnggota'])->name('laporanAnggota.cetak');
        });
    });

    // Routes accessible by both Admin and Petugas
    Route::middleware(['role:admin,petugas'])->group(function () {
        Route::get('buku', [BukuController::class, 'index'])->name('buku.index');
        Route::get('buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
        Route::get('anggota', [AnggotaController::class, 'index'])->name('anggota.index');
        Route::get('anggota/{anggota}', [AnggotaController::class, 'show'])->name('anggota.show');
        Route::get('anggota-non-siswa', [AnggotaNonSiswaController::class, 'index'])->name('anggota-non-siswa.index');
        Route::get('anggota-non-siswa/{anggota_non_siswa}', [AnggotaNonSiswaController::class, 'show'])->name('anggota-non-siswa.show');
        Route::resource('peminjaman', PeminjamanController::class)->except(['destroy']);
        Route::get('peminjaman/hitung-denda/{id}', [PeminjamanController::class, 'hitungDenda'])->name('peminjaman.hitung-denda');
        Route::resource('detail-peminjaman', DetailPeminjamanController::class)->only(['create', 'store']);
        Route::resource('pengembalian', PengembalianController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('pengembalian/{nomorKembali}/print', [PengembalianController::class, 'print'])->name('pengembalian.print');
        Route::get('/petugas-profil', [PetugasController::class, 'profile'])->name('petugas.profil');
        Route::put('/petugas-profil', [PetugasController::class, 'updateProfile'])->name('petugas.profil.update');
        Route::delete('/petugas/delete-account/{id}', [PetugasController::class, 'deleteAccount'])->name('petugas.delete-account');
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('peminjaman', [LaporanController::class, 'peminjaman'])->name('peminjaman.index');
            Route::get('peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('peminjaman.cetak');
            Route::get('laporanPengembalian', [LaporanController::class, 'laporanPengembalian'])->name('laporanPengembalian.index');
            Route::get('laporanPengembalian/cetak', [LaporanController::class, 'cetakLaporanPengembalian'])->name('laporanPengembalian.cetak');
        });
    });
    
});