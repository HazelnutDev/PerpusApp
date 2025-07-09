<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\PeminjamanSiswa;
use App\Models\PeminjamanNonSiswa;
use App\Models\DetailPeminjamanSiswa;
use App\Models\DetailPeminjamanNonSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class DetailPeminjamanController extends Controller
{
    /**
     * Show the form for creating a new detail peminjaman.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function create(Request $request): View|RedirectResponse
    {
        if (!$request->has('peminjaman_id')) {
            return redirect()->route('peminjaman.index')
                ->with('error', 'ID Peminjaman tidak ditemukan');
        }

        // Check if this is a student loan or non-student loan based on loan number format
        if (strpos($request->peminjaman_id, 'PJM-S') === 0) {
            $peminjaman = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku'])
                ->where('NoPinjamM', $request->peminjaman_id)
                ->firstOrFail();
        } else {
            $peminjaman = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku'])
                ->where('NoPinjamN', $request->peminjaman_id)
                ->firstOrFail();
        }

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->route('peminjaman.show', $request->peminjaman_id)
                ->with('error', 'Tidak dapat menambah detail untuk peminjaman yang sudah selesai');
        }

        $bukus = Buku::where('Stok', '>', 0)->get();
        return view('detail-peminjaman.create', compact('peminjaman', 'bukus'));
    }

    /**
     * Store a newly created detail peminjaman in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'peminjaman_id' => 'required|string',
            'buku_id' => 'required|exists:buku,KodeBuku',
            'jumlah' => 'required|integer|min:1'
        ], [
            'peminjaman_id.required' => 'ID Peminjaman wajib diisi',
            'buku_id.required' => 'Buku wajib dipilih',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.min' => 'Jumlah minimal 1'
        ]);

        DB::beginTransaction();
        try {
            // Check if this is a student loan or non-student loan based on loan number format
            if (strpos($request->peminjaman_id, 'PJM-S') === 0) {
                $peminjaman = PeminjamanSiswa::where('NoPinjamM', $request->peminjaman_id)->firstOrFail();
                $existingDetail = DetailPeminjamanSiswa::where('NoPinjamM', $peminjaman->NoPinjamM)
                    ->where('KodeBuku', $request->buku_id)
                    ->first();
            } else {
                $peminjaman = PeminjamanNonSiswa::where('NoPinjamN', $request->peminjaman_id)->firstOrFail();
                $existingDetail = DetailPeminjamanNonSiswa::where('NoPinjamN', $peminjaman->NoPinjamN)
                    ->where('KodeBuku', $request->buku_id)
                    ->first();
            }

            if ($peminjaman->status !== 'dipinjam') {
                return back()->with('error', 'Tidak dapat menambah detail untuk peminjaman yang sudah selesai');
            }

            $buku = Buku::where('KodeBuku', $request->buku_id)->firstOrFail();

            if ($existingDetail) {
                return back()->with('error', 'Buku ini sudah ada dalam peminjaman');
            }

            if ($buku->Stok < $request->jumlah) {
                return back()->with('error', "Stok buku {$buku->Judul} tidak mencukupi");
            }

            // Create detail peminjaman
            if (strpos($request->peminjaman_id, 'PJM-S') === 0) {
                DetailPeminjamanSiswa::create([
                    'NoPinjamM' => $peminjaman->NoPinjamM,
                    'KodeBuku' => $buku->KodeBuku,
                    'KodePetugas' => Auth::user()->KodePetugas,
                    'Jumlah' => $request->jumlah
                ]);
            } else {
                DetailPeminjamanNonSiswa::create([
                    'NoPinjamN' => $peminjaman->NoPinjamN,
                    'KodeBuku' => $buku->KodeBuku,
                    'KodePetugas' => Auth::user()->KodePetugas,
                    'Jumlah' => $request->jumlah
                ]);
            }

            // Update stok
            $buku->update(['Stok' => $buku->Stok - $request->jumlah]);

            DB::commit();
            return redirect()->route('peminjaman.show', $request->peminjaman_id)
                ->with('success', 'Buku berhasil ditambahkan ke peminjaman');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified detail peminjaman from storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(string $no_pinjam, string $kode_buku): RedirectResponse
    {
        // $request->validate([
        //     'no_pinjam' => 'required|string',
        //     'kode_buku' => 'required|string'
        // ]);

        DB::beginTransaction();
        try {
            // Check if this is a student loan or non-student loan based on loan number format
            // if (strpos($request->no_pinjam, 'PJM-S') === 0) {
            //     $peminjaman = PeminjamanSiswa::with('detailPeminjaman')
            //         ->where('NoPinjamM', $request->no_pinjam)
            //         ->firstOrFail();
                
            //     $detail = DetailPeminjamanSiswa::where('NoPinjamM', $request->no_pinjam)
            //         ->where('KodeBuku', $request->kode_buku)
            //         ->firstOrFail();
            // } else {
            //     $peminjaman = PeminjamanNonSiswa::with('detailPeminjaman')
            //         ->where('NoPinjamN', $request->no_pinjam)
            //         ->firstOrFail();
                
            //     $detail = DetailPeminjamanNonSiswa::where('NoPinjamN', $request->no_pinjam)
            //         ->where('KodeBuku', $request->kode_buku)
            //         ->firstOrFail();
            // }
            if (strpos($no_pinjam, 'PJM-S') === 0) {
        $peminjaman = PeminjamanSiswa::with('detailPeminjaman')
            ->where('NoPinjamM', $no_pinjam)
            ->firstOrFail();

        $detail = DetailPeminjamanSiswa::where('NoPinjamM', $no_pinjam)
            ->where('KodeBuku', $kode_buku)
            ->firstOrFail();
        } else {
        $peminjaman = PeminjamanNonSiswa::with('detailPeminjaman')
            ->where('NoPinjamN', $no_pinjam)
            ->firstOrFail();

        $detail = DetailPeminjamanNonSiswa::where('NoPinjamN', $no_pinjam)
            ->where('KodeBuku', $kode_buku)
            ->firstOrFail();
         }


            if ($peminjaman->status !== 'dipinjam') {
                return back()->with('error', 'Tidak dapat menghapus detail untuk peminjaman yang sudah selesai');
            }

            // Restore book stock
            $buku = Buku::where('KodeBuku', $detail->KodeBuku)->firstOrFail();
            $buku->update(['Stok' => $buku->Stok + 1]); // Assuming 1 book per detail

            // Delete detail
            $detail->delete();

            DB::commit();
            return redirect()->route('peminjaman.show', $no_pinjam)
                ->with('success', 'Detail peminjaman berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus detail peminjaman: ' . $e->getMessage());
        }
    }
}
