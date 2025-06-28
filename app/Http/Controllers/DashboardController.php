<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Petugas;
use Illuminate\Http\Request;
use App\Models\AnggotaNonSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Data counts
        $petugas = Petugas::all();
        $buku = Buku::all();
        $anggota = Anggota::all();
        $anggota_non_siswa = AnggotaNonSiswa::all();

        // Peminjaman data
        $peminjaman_siswa = DB::table('peminjamen_header_siswa')
            ->join('anggota', 'peminjamen_header_siswa.NoAnggotaM', '=', 'anggota.NoAnggotaM')
            ->select('peminjamen_header_siswa.*', 'anggota.NamaAnggota')
            ->orderBy('TglPinjam', 'desc')
            ->limit(5)
            ->get();

        $peminjaman_non_siswa = DB::table('peminjamen_header_non_siswa')
            ->join('anggota_non_siswa', 'peminjamen_header_non_siswa.NoAnggotaN', '=', 'anggota_non_siswa.NoAnggotaN')
            ->select('peminjamen_header_non_siswa.*', 'anggota_non_siswa.NamaAnggota')
            ->orderBy('TglPinjam', 'desc')
            ->limit(5)
            ->get();

        // Pengembalian data
        $pengembalian_siswa = DB::table('kembali_siswa')
            ->join('peminjamen_header_siswa', 'kembali_siswa.NoPinjamM', '=', 'peminjamen_header_siswa.NoPinjamM')
            ->join('anggota', 'peminjamen_header_siswa.NoAnggotaM', '=', 'anggota.NoAnggotaM')
            ->select('kembali_siswa.*', 'anggota.NamaAnggota')
            ->orderBy('TglKembali', 'desc')
            ->limit(5)
            ->get();

        $pengembalian_non_siswa = DB::table('kembali_non_siswa')
            ->join('peminjamen_header_non_siswa', 'kembali_non_siswa.NoPinjamN', '=', 'peminjamen_header_non_siswa.NoPinjamN')
            ->join('anggota_non_siswa', 'peminjamen_header_non_siswa.NoAnggotaN', '=', 'anggota_non_siswa.NoAnggotaN')
            ->select('kembali_non_siswa.*', 'anggota_non_siswa.NamaAnggota')
            ->orderBy('TglKembali', 'desc')
            ->limit(5)
            ->get();

        // Statistik peminjaman per anggota
        $statistik_peminjaman_siswa = DB::table('peminjamen_header_siswa')
            ->join('anggota', 'peminjamen_header_siswa.NoAnggotaM', '=', 'anggota.NoAnggotaM')
            ->select('anggota.NamaAnggota', DB::raw('count(*) as total_pinjam'))
            ->groupBy('anggota.NoAnggotaM', 'anggota.NamaAnggota')
            ->orderBy('total_pinjam', 'desc')
            ->limit(5)
            ->get();

        $statistik_peminjaman_non_siswa = DB::table('peminjamen_header_non_siswa')
            ->join('anggota_non_siswa', 'peminjamen_header_non_siswa.NoAnggotaN', '=', 'anggota_non_siswa.NoAnggotaN')
            ->select('anggota_non_siswa.NamaAnggota', DB::raw('count(*) as total_pinjam'))
            ->groupBy('anggota_non_siswa.NoAnggotaN', 'anggota_non_siswa.NamaAnggota')
            ->orderBy('total_pinjam', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'petugas',
            'buku',
            'anggota',
            'anggota_non_siswa',
            'peminjaman_siswa',
            'peminjaman_non_siswa',
            'pengembalian_siswa',
            'pengembalian_non_siswa',
            'statistik_peminjaman_siswa',
            'statistik_peminjaman_non_siswa'
        ));
    }
}
