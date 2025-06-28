<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanSiswa;
use App\Models\PeminjamanNonSiswa;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\AnggotaNonSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function peminjaman(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Get student loans
        $peminjamanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Get non-student loans
        $peminjamanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Combine the results
        $peminjaman = $peminjamanSiswa->concat($peminjamanNonSiswa)->sortByDesc('TglPinjam');

        return view('laporan.peminjaman.index', compact('peminjaman', 'startDate', 'endDate'));
    }

    public function cetakPeminjaman(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Get student loans
        $peminjamanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Get non-student loans
        $peminjamanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Combine the results
        $peminjaman = $peminjamanSiswa->concat($peminjamanNonSiswa)->sortByDesc('TglPinjam');

        $pdf = PDF::loadView('laporan.peminjaman.cetak', compact('peminjaman', 'startDate', 'endDate'));
        return $pdf->stream('laporan-peminjaman.pdf');
    }

    public function keterlambatan(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();
        $today = Carbon::now();

        // Get late student loans
        $keterlambatanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Get late non-student loans
        $keterlambatanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Combine the results
        $keterlambatan = $keterlambatanSiswa->concat($keterlambatanNonSiswa)->sortByDesc('TglPinjam');

        return view('laporan.keterlambatan.index', compact('keterlambatan', 'startDate', 'endDate'));
    }

    public function cetakKeterlambatan(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();
        $today = Carbon::now();

        // Get late student loans
        $keterlambatanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Get late non-student loans
        $keterlambatanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDate, $endDate])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        // Combine the results
        $keterlambatan = $keterlambatanSiswa->concat($keterlambatanNonSiswa)->sortByDesc('TglPinjam');

        $pdf = PDF::loadView('laporan.keterlambatan.cetak', compact('keterlambatan', 'startDate', 'endDate'));
        return $pdf->stream('laporan-keterlambatan.pdf');
    }

    public function bukuPopuler(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $bukuPopuler = Buku::withCount(['detailPeminjamanSiswa as peminjaman_siswa_count' => function($query) use ($startDate, $endDate) {
            $query->whereHas('peminjaman', function($q) use ($startDate, $endDate) {
                $q->whereBetween('TglPinjam', [$startDate, $endDate]);
            });
        }, 'detailPeminjamanNonSiswa as peminjaman_non_siswa_count' => function($query) use ($startDate, $endDate) {
            $query->whereHas('peminjaman', function($q) use ($startDate, $endDate) {
                $q->whereBetween('TglPinjam', [$startDate, $endDate]);
            });
        }])
        ->with(['kategori', 'rak'])
        ->orderByRaw('(peminjaman_siswa_count + peminjaman_non_siswa_count) DESC')
        ->limit(10)
        ->get()
        ->map(function($buku) {
            $buku->total_peminjaman = $buku->peminjaman_siswa_count + $buku->peminjaman_non_siswa_count;
            return $buku;
        });

        return view('laporan.buku-populer.index', compact('bukuPopuler', 'startDate', 'endDate'));
    }

    public function cetakBukuPopuler(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        $bukuPopuler = Buku::withCount(['detailPeminjamanSiswa as peminjaman_siswa_count' => function($query) use ($startDate, $endDate) {
            $query->whereHas('peminjaman', function($q) use ($startDate, $endDate) {
                $q->whereBetween('TglPinjam', [$startDate, $endDate]);
            });
        }, 'detailPeminjamanNonSiswa as peminjaman_non_siswa_count' => function($query) use ($startDate, $endDate) {
            $query->whereHas('peminjaman', function($q) use ($startDate, $endDate) {
                $q->whereBetween('TglPinjam', [$startDate, $endDate]);
            });
        }])
        ->with(['kategori', 'rak'])
        ->orderByRaw('(peminjaman_siswa_count + peminjaman_non_siswa_count) DESC')
        ->limit(10)
        ->get()
        ->map(function($buku) {
            $buku->total_peminjaman = $buku->peminjaman_siswa_count + $buku->peminjaman_non_siswa_count;
            return $buku;
        });

        $pdf = PDF::loadView('laporan.buku-populer.cetak', compact('bukuPopuler', 'startDate', 'endDate'));
        return $pdf->stream('laporan-buku-populer.pdf');
    }

    /**
     * Display a listing of the member report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function anggota(Request $request)
    {
        $querySiswa = Anggota::query();
        $queryNonSiswa = AnggotaNonSiswa::query();

        if ($request->jenis_anggota == 'siswa') {
            $anggota = $querySiswa->orderBy('NamaAnggota')->get();
        } elseif ($request->jenis_anggota == 'non-siswa') {
            $anggota = $queryNonSiswa->orderBy('Nama')->get();
        } else {
            $anggota = $querySiswa->get()->merge($queryNonSiswa->get())->sortBy('NamaAnggota');
        }

        return view('laporan.anggota.index', compact('anggota'));
    }

    /**
     * Generate PDF for member report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cetakAnggota(Request $request)
    {
        $querySiswa = Anggota::query();
        $queryNonSiswa = AnggotaNonSiswa::query();

        if ($request->jenis_anggota == 'siswa') {
            $anggota = $querySiswa->orderBy('NamaAnggota')->get();
        } elseif ($request->jenis_anggota == 'non-siswa') {
            $anggota = $queryNonSiswa->orderBy('Nama')->get();
        } else {
            $anggota = $querySiswa->get()->merge($queryNonSiswa->get())->sortBy('NamaAnggota');
        }

        $pdf = PDF::loadView('laporan.anggota.cetak', compact('anggota'));
        return $pdf->stream('laporan-anggota-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Display a listing of the book report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buku(Request $request)
    {
        $query = Buku::query();

        if ($request->status == 'tersedia') {
            $query->where('Stok', '>', 0);
        } elseif ($request->status == 'tidak_tersedia') {
            $query->where('Stok', '<=', 0);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Judul', 'like', "%{$search}%")
                  ->orWhere('Pengarang', 'like', "%{$search}%");
            });
        }

        $buku = $query->orderBy('Judul')->paginate(15);

        return view('laporan.buku.index', compact('buku'));
    }

    /**
     * Generate PDF for book report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cetakBuku(Request $request)
    {
        $query = Buku::query();

        if ($request->status == 'tersedia') {
            $query->where('Stok', '>', 0);
        } elseif ($request->status == 'tidak_tersedia') {
            $query->where('Stok', '<=', 0);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Judul', 'like', "%{$search}%")
                  ->orWhere('Pengarang', 'like', "%{$search}%");
            });
        }

        $buku = $query->orderBy('Judul')->get();

        $pdf = PDF::loadView('laporan.buku.cetak', compact('buku'));
        return $pdf->stream('laporan-buku-' . date('Y-m-d') . '.pdf');
    }
}
