<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Buku;
use App\Models\PeminjamanSiswa;
use App\Models\PeminjamanNonSiswa;
use App\Models\PengembalianSiswa;
use App\Models\PengembalianNonSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the pengembalian.
     *
     * @param Request $request
     * @return View|Factory
     */
    public function index(Request $request): View|Factory
    {
        $perPage = 10;
        $currentPage = request()->get('page', 1);

        // Get both student and non-student returns
        $pengembalianSiswa = PengembalianSiswa::with(['peminjaman.anggota', 'peminjaman.petugas'])
            ->latest('TglKembali');
        
        $pengembalianNonSiswa = PengembalianNonSiswa::with(['peminjaman.anggota', 'peminjaman.petugas'])
            ->latest('TglKembali');

        $type = $request->type ?? null;
        if ($type === 'siswa') {
            $pengembalian = $pengembalianSiswa->paginate($perPage);
        } elseif ($type === 'non-siswa') {
            $pengembalian = $pengembalianNonSiswa->paginate($perPage);
        } else {
            // Combine both types of returns
            $combined = $pengembalianSiswa->get()
                ->concat($pengembalianNonSiswa->get())
                ->sortByDesc('TglKembali');

            // Manual pagination
            $offset = ($currentPage - 1) * $perPage;
            $items = $combined->slice($offset, $perPage);
            
            $pengembalian = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $combined->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url()]
            );
        }

        return view('pengembalian.index', compact('pengembalian'));
    }

    /**
     * Show the form for creating a new pengembalian.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    // public function create(Request $request): View|RedirectResponse
    // {
        
    //     if (!$request->has('peminjaman_id')) {
    //         return redirect()->route('peminjaman.index')
    //             ->with('error', 'ID Peminjaman tidak ditemukan');
    //     }

    //     // Check if this is a student loan or non-student loan based on loan number format
    //     if (strpos($request->peminjaman_id, 'PJM-S') === 0) {
    //         $peminjaman = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
    //             ->where('NoPinjamM', $request->peminjaman_id)
    //             ->firstOrFail();
    //     } else {
    //         $peminjaman = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
    //             ->where('NoPinjamN', $request->peminjaman_id)
    //             ->firstOrFail();
    //     }

    //     if (!in_array($peminjaman->status, ['dipinjam', 'terlambat'])) {
    //         return redirect()->route('peminjaman.show', $request->peminjaman_id)
    //             ->with('error', 'Peminjaman ini sudah dikembalikan');
    //     }
        

    //     $dendaPerHari = 1000; // Rp 1.000 per hari
    //     $hariTerlambat = max(0, Carbon::now()->diffInDays($peminjaman->TglJatuhTempo));
    //     $totalDenda = $hariTerlambat * $dendaPerHari;

    //     return view('pengembalian.create', compact('peminjaman', 'dendaPerHari', 'hariTerlambat', 'totalDenda'));
    // }

    // /**
    //  * Store a newly created pengembalian in storage.
    //  *
    //  * @param Request $request
    //  * @return RedirectResponse
    //  */
    // public function store(Request $request): RedirectResponse
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'peminjaman_id' => 'required|string',
    //         'TglKembali' => 'required|date',
    //         'Denda' => 'required|numeric|min:0'
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $kodePetugas = Auth::user()->KodePetugas;
    //         $counter = DB::table(strpos($request->peminjaman_id, 'PJM-S') === 0 ? 'kembali_siswa' : 'kembali_non_siswa')
    //             ->whereDate('created_at', Carbon::today())
    //             ->count() + 1;
            
    //         // Generate return number
    //         $prefix = strpos($request->peminjaman_id, 'PJM-S') === 0 ? 'KBL-S' : 'KBL-N';
    //         $nomorKembali = $prefix . date('Ymd') . str_pad($counter, 4, '0', STR_PAD_LEFT);

    //         // Create return record based on loan type
    //         if (strpos($request->peminjaman_id, 'PJM-S') === 0) {
    //             $peminjaman = PeminjamanSiswa::where('NoPinjamM', $request->peminjaman_id)->firstOrFail();
                
    //             PengembalianSiswa::create([
    //                 'NoKembaliM' => $nomorKembali,
    //                 'NoPinjamM' => $peminjaman->NoPinjamM,
    //                 'TglKembali' => $request->TglKembali,
    //                 'KodePetugas' => $kodePetugas,
    //                 'Denda' => $request->Denda
    //             ]);

    //             // Update book stock for each borrowed book
    //             foreach ($peminjaman->detailPeminjaman as $detail) {
    //                 $buku = Buku::where('KodeBuku', $detail->KodeBuku)->firstOrFail();
    //                 $buku->update(['Stok' => $buku->Stok + 1]); // Assuming 1 book per detail
    //             }
    //         } else {
    //             $peminjaman = PeminjamanNonSiswa::where('NoPinjamN', $request->peminjaman_id)->firstOrFail();
                
    //             PengembalianNonSiswa::create([
    //                 'NoKembaliN' => $nomorKembali,
    //                 'NoPinjamN' => $peminjaman->NoPinjamN,
    //                 'TglKembali' => $request->TglKembali,
    //                 'KodePetugas' => $kodePetugas,
    //                 'Denda' => $request->Denda
    //             ]);

    //             // Update book stock for each borrowed book
    //             foreach ($peminjaman->detailPeminjaman as $detail) {
    //                 $buku = Buku::where('KodeBuku', $detail->KodeBuku)->firstOrFail();
    //                 $buku->update(['Stok' => $buku->Stok + 1]); // Assuming 1 book per detail
    //             }
    //         }

    //         DB::commit();
    //         return redirect()->route('peminjaman.index')
    //             ->with('success', 'Peminjaman berhasil dikembalikan');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
    //     }
    // }

    // Perbaikan untuk method create() di PengembalianController

public function create(Request $request): View|RedirectResponse
{
    if (!$request->has('peminjaman_id')) {
        return redirect()->route('peminjaman.index')
            ->with('error', 'ID Peminjaman tidak ditemukan');
    }

    // Check if this is a student loan or non-student loan based on loan number format
    if (strpos($request->peminjaman_id, 'PJM-S') === 0) {
        $peminjaman = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->where('NoPinjamM', $request->peminjaman_id)
            ->firstOrFail();
    } else {
        $peminjaman = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->where('NoPinjamN', $request->peminjaman_id)
            ->firstOrFail();
    }

    if (!in_array($peminjaman->status, ['dipinjam', 'terlambat'])) {
        return redirect()->route('peminjaman.show', $request->peminjaman_id)
            ->with('error', 'Peminjaman ini sudah dikembalikan');
    }

    // Generate nomor pengembalian untuk preview
    $isStudent = strpos($request->peminjaman_id, 'PJM-S') === 0;
    $prefix = $isStudent ? 'KBL-S' : 'KBL-N';
    
    // Hitung counter berdasarkan tanggal hari ini
    $today = date('Y-m-d');
    $counter = 0;
    
    if ($isStudent) {
        $counter = DB::table('kembali_siswa')
            ->whereDate('created_at', $today)
            ->count() + 1;
    } else {
        $counter = DB::table('kembali_non_siswa')
            ->whereDate('created_at', $today)
            ->count() + 1;
    }
    
    // Format: KBL-S/N + YYYYMMDD + 4 digit counter mulai dari 0001
    $nomorKembali = $prefix . date('Ymd') . str_pad($counter, 4, '0', STR_PAD_LEFT);
    $kodePetugas = Auth::user()->KodePetugas;
    $dendaPerHari = 1000; // Rp 1.000 per hari
    $hariTerlambat = max(0, Carbon::now()->diffInDays($peminjaman->TglJatuhTempo));
    $totalDenda = $hariTerlambat * $dendaPerHari;

    return view('pengembalian.create', compact('peminjaman', 'dendaPerHari', 'hariTerlambat', 'totalDenda', 'nomorKembali', 'kodePetugas'));
}

// Perbaikan untuk method store() - bagian generate nomor pengembalian
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'peminjaman_id' => 'required|string',
        'TglKembali' => 'required|date',
        'Denda' => 'required|numeric|min:0'
    ]);

    DB::beginTransaction();
    try {
        $kodePetugas = Auth::user()->KodePetugas;
        $isStudent = strpos($request->peminjaman_id, 'PJM-S') === 0;
        
        // Generate nomor pengembalian dengan format baru
        $today = date('Y-m-d');
        $counter = 0;
        
        if ($isStudent) {
            $counter = DB::table('kembali_siswa')
                ->whereDate('created_at', $today)
                ->count() + 1;
        } else {
            $counter = DB::table('kembali_non_siswa')
                ->whereDate('created_at', $today)
                ->count() + 1;
        }
        
        // Format: KBL-S/N + YYYYMMDD + 4 digit counter mulai dari 0001
        $prefix = $isStudent ? 'KBL-S' : 'KBL-N';
        $nomorKembali = $prefix . date('Ymd') . str_pad($counter, 4, '0', STR_PAD_LEFT);

        // Create return record based on loan type
        if ($isStudent) {
            $peminjaman = PeminjamanSiswa::where('NoPinjamM', $request->peminjaman_id)->firstOrFail();
            
            PengembalianSiswa::create([
                'NoKembaliM' => $nomorKembali,
                'NoPinjamM' => $peminjaman->NoPinjamM,
                'TglKembali' => $request->TglKembali,
                'KodePetugas' => $kodePetugas,
                'Denda' => $request->Denda
            ]);

            // Update book stock for each borrowed book
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $buku = Buku::where('KodeBuku', $detail->KodeBuku)->firstOrFail();
                $buku->update(['Stok' => $buku->Stok + $detail->Jumlah]); // Gunakan jumlah dari detail
            }
        } else {
            $peminjaman = PeminjamanNonSiswa::where('NoPinjamN', $request->peminjaman_id)->firstOrFail();
            
            PengembalianNonSiswa::create([
                'NoKembaliN' => $nomorKembali,
                'NoPinjamN' => $peminjaman->NoPinjamN,
                'TglKembali' => $request->TglKembali,
                'KodePetugas' => $kodePetugas,
                'Denda' => $request->Denda
            ]);

            // Update book stock for each borrowed book
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $buku = Buku::where('KodeBuku', $detail->KodeBuku)->firstOrFail();
                $buku->update(['Stok' => $buku->Stok + $detail->Jumlah]); // Gunakan jumlah dari detail
            }
        }

        DB::commit();
        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dikembalikan');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
    }
}

    public function show($nomorKembali): View
    {
        $pengembalian = null;
        $error = null;

        try {
            // Find either student or non-student return based on number format
            if (strpos($nomorKembali, 'KBL-S') === 0) {
                $pengembalian = PengembalianSiswa::with([
                    'peminjaman.anggota',
                    'peminjaman.detailPeminjaman.buku',
                    'petugas'
                ])->where('NoKembaliM', $nomorKembali)
                  ->firstOrFail();
            } else {
                $pengembalian = PengembalianNonSiswa::with([
                    'peminjaman.anggota',
                    'peminjaman.detailPeminjaman.buku',
                    'petugas'
                ])->where('NoKembaliN', $nomorKembali)
                  ->firstOrFail();
            }
        } catch (\Exception $e) {
            $error = 'Pengembalian tidak ditemukan: ' . $e->getMessage();
        }

        // If pengembalian is found, pass the correct nomorKembali for print route usage in the view
        $nomorKembaliForPrint = $pengembalian ? ($pengembalian instanceof PengembalianSiswa ? $pengembalian->NoKembaliM : $pengembalian->NoKembaliN) : null;

        return view('pengembalian.show', compact('pengembalian', 'error', 'nomorKembaliForPrint'));
    }

    public function print($nomorKembali)
    {
        // Find either student or non-student return based on the return number format
        if (strpos($nomorKembali, 'KBL-S') === 0) {
            $pengembalian = PengembalianSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku'])
                ->where('NoKembaliM', $nomorKembali)
                ->firstOrFail();
        } else {
            $pengembalian = PengembalianNonSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku'])
                ->where('NoKembaliN', $nomorKembali)
                ->firstOrFail();
        }

        $pdf = PDF::loadView('pengembalian.print', compact('pengembalian'));
        return $pdf->stream("bukti-pengembalian-{$nomorKembali}.pdf");
    }
}

