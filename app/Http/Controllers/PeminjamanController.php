<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\AnggotaNonSiswa;
use App\Models\PeminjamanSiswa;
use App\Models\PeminjamanNonSiswa;
use App\Models\DetailPeminjamanSiswa;
use App\Models\DetailPeminjamanNonSiswa;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $currentPage = request()->get('page', 1);

        // Get both student and non-student loans
        $peminjamanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->latest('TglPinjam');
        
        $peminjamanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->latest('TglPinjam');

        if ($request->type === 'siswa') {
            $peminjaman = $peminjamanSiswa->paginate($perPage);
        } elseif ($request->type === 'non-siswa') {
            $peminjaman = $peminjamanNonSiswa->paginate($perPage);
        } else {
            // Combine both types of loans
            $combined = $peminjamanSiswa->get()
                ->concat($peminjamanNonSiswa->get())
                ->sortByDesc('TglPinjam');

            // Manual pagination
            $offset = ($currentPage - 1) * $perPage;
            $items = $combined->slice($offset, $perPage);
            
            $peminjaman = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $combined->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url()]
            );
        }

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $bukus = Buku::where('Stok', '>', 0)->get();
        $anggotas = Anggota::all();
        $anggotaNonSiswas = AnggotaNonSiswa::all();
        return view('peminjaman.create', compact('bukus', 'anggotas', 'anggotaNonSiswas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_anggota' => 'required|in:siswa,non-siswa',
            'anggota_id' => 'required|string',
            'TglPinjam' => [
                'required',
                'date',
                'date_format:Y-m-d',
            ],
            'TglJatuhTempo' => [
                'required',
                'date',
                'date_format:Y-m-d',
                'after:TglPinjam',
            ],
            'buku_id' => 'required|array|min:1',
            'buku_id.*' => 'required|exists:buku,KodeBuku',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1'
        ], [
            'TglJatuhTempo.after' => 'Tanggal jatuh tempo harus setelah tanggal peminjaman',
            'buku_id.required' => 'Pilih minimal satu buku',
            'buku_id.min' => 'Pilih minimal satu buku',
            'jumlah.*.min' => 'Jumlah tidak boleh kosong',
            'jumlah.*.integer' => 'Jumlah harus berupa angka',
        ]);

        DB::beginTransaction();
        try {
            $kodePetugas = Auth::user()->KodePetugas;
            $counter = DB::table($request->tipe_anggota === 'siswa' ? 'peminjamen_header_siswa' : 'peminjamen_header_non_siswa')
                ->whereDate('created_at', Carbon::today())
                ->count() + 1;
            
            // Generate loan number
            $prefix = $request->tipe_anggota === 'siswa' ? 'PJM-S' : 'PJM-N';
            $nomorPinjam = $prefix . date('Ymd') . str_pad($counter, 4, '0', STR_PAD_LEFT);

            // Create peminjaman
            if ($request->tipe_anggota === 'siswa') {
                $peminjaman = PeminjamanSiswa::create([
                    'NoPinjamM' => $nomorPinjam,
                    'NoAnggotaM' => $request->anggota_id,
                    'TglPinjam' => $request->TglPinjam,
                    'TglJatuhTempo' => $request->TglJatuhTempo,
                    'KodePetugas' => $kodePetugas
                ]);

                // Create detail peminjaman
                foreach ($request->buku_id as $index => $kodeBuku) {
                    $buku = Buku::findOrFail($kodeBuku);
                    $jumlah = $request->jumlah[$index];

                    if ($buku->Stok < $jumlah) {
                        throw new \Exception("Stok buku {$buku->JudulBuku} tidak mencukupi.");
                    }

                    DetailPeminjamanSiswa::create([
                        'NoPinjamM' => $peminjaman->NoPinjamM,
                        'KodeBuku' => $kodeBuku,
                        'KodePetugas' => $kodePetugas
                    ]);

                    // Update stok
                    $buku->update(['Stok' => $buku->Stok - $jumlah]);
                }
            } else {
                $peminjaman = PeminjamanNonSiswa::create([
                    'NoPinjamN' => $nomorPinjam,
                    'NoAnggotaN' => $request->anggota_id,
                    'TglPinjam' => $request->TglPinjam,
                    'TglJatuhTempo' => $request->TglJatuhTempo,
                    'KodePetugas' => $kodePetugas
                ]);

                // Create detail peminjaman
                foreach ($request->buku_id as $index => $kodeBuku) {
                    $buku = Buku::findOrFail($kodeBuku);
                    $jumlah = $request->jumlah[$index];

                    if ($buku->Stok < $jumlah) {
                        throw new \Exception("Stok buku {$buku->JudulBuku} tidak mencukupi.");
                    }

                    DetailPeminjamanNonSiswa::create([
                        'NoPinjamN' => $peminjaman->NoPinjamN,
                        'KodeBuku' => $kodeBuku,
                        'KodePetugas' => $kodePetugas,
                        'Jumlah' => $jumlah
                    ]);

                    // Update stok
                    $buku->update(['Stok' => $buku->Stok - $jumlah]);
                }
            }

            DB::commit();
            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }    public function show($nomorPinjam)
    {
        // Find either student or non-student loan based on the loan number format
        if (strpos($nomorPinjam, 'PJM-S') === 0) {
            $peminjaman = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
                ->where('NoPinjamM', $nomorPinjam)
                ->firstOrFail();
        } elseif (strpos($nomorPinjam, 'PJM-N') === 0) {
            $peminjaman = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
                ->where('NoPinjamN', $nomorPinjam)
                ->firstOrFail();
        } else {
            // fallback: coba cari di kedua tabel jika tidak ada prefix
            $peminjaman = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
                ->where('NoPinjamM', $nomorPinjam)
                ->first();
            if (!$peminjaman) {
                $peminjaman = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
                    ->where('NoPinjamN', $nomorPinjam)
                    ->firstOrFail();
            }
        }
        return view('peminjaman.show', compact('peminjaman'));
    }   

    // public function edit($id)
    // {
    // if (strpos($id, 'PJM-S') === 0) {
    //     $peminjaman = PeminjamanSiswa::where('NoPinjamM', $id)->firstOrFail();
    // } else {
    //     $peminjaman = PeminjamanNonSiswa::where('NoPinjamN', $id)->firstOrFail();
    // }
    // return view('peminjaman.edit', compact('peminjaman'));
    // }
    
    public function edit($nomorPinjam)
    {
        // Find either student or non-student loan based on the loan number format
        if (strpos($nomorPinjam, 'PJM-S') === 0) {
            $peminjaman = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
                ->where('NoPinjamM', $nomorPinjam)
                ->firstOrFail();
        } else {
            $peminjaman = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
                ->where('NoPinjamN', $nomorPinjam)
                ->firstOrFail();
        }

        if ($peminjaman && method_exists($peminjaman, 'pengembalian') && $peminjaman->pengembalian) {
            return redirect()->route('peminjaman.show', $nomorPinjam)
                ->with('error', 'Peminjaman yang sudah dikembalikan tidak dapat diedit');
        }

        $bukus = Buku::all();
        return view('peminjaman.edit', compact('peminjaman', 'bukus'));
    }    
    
    public function update(Request $request, $nomorPinjam)
    {
        // Find either student or non-student loan based on the loan number format
        if (strpos($nomorPinjam, 'PJM-S') === 0) {
            $peminjaman = PeminjamanSiswa::where('NoPinjamM', $nomorPinjam)->firstOrFail();
            $isSiswa = true;
        } else {
            $peminjaman = PeminjamanNonSiswa::where('NoPinjamN', $nomorPinjam)->firstOrFail();
            $isSiswa = false;
        }        if ($peminjaman && method_exists($peminjaman, 'pengembalian') && $peminjaman->pengembalian) {
            return redirect()->route('peminjaman.show', $nomorPinjam)
                ->with('error', 'Peminjaman yang sudah dikembalikan tidak dapat diedit');
        }

        $request->validate([
            'TglJatuhTempo' => 'required|date|after:TglPinjam'
        ]);

        $peminjaman->update([
            'TglJatuhTempo' => $request->TglJatuhTempo
        ]);

        return redirect()->route('peminjaman.show', $nomorPinjam)
            ->with('success', 'Tanggal kembali berhasil diperbarui');
    }    
    
    public function destroy($nomorPinjam)
    {
        // Find either student or non-student loan based on the loan number format
        if (strpos($nomorPinjam, 'PJM-S') === 0) {
            $peminjaman = PeminjamanSiswa::with('detailPeminjaman.buku')
                ->where('NoPinjamM', $nomorPinjam)
                ->firstOrFail();
            $isSiswa = true;
        } else {
            $peminjaman = PeminjamanNonSiswa::with('detailPeminjaman.buku')
                ->where('NoPinjamN', $nomorPinjam)
                ->firstOrFail();
            $isSiswa = false;
        }

        if ($peminjaman->pengembalian) {
            return back()->with('error', 'Peminjaman yang sudah dikembalikan tidak dapat dihapus');
        }

        DB::beginTransaction();
        try {
            // Restore book stock
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $buku = Buku::where('KodeBuku', $detail->KodeBuku)->firstOrFail();
                $buku->update(['Stok' => $buku->Stok + 1]); // Assuming 1 book per detail
            }

            $peminjaman->delete();
            DB::commit();

            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus peminjaman');
        }
    }   
    
    public function hitungDenda($nomorPinjam)
    {
        // Find either student or non-student loan based on the loan number format
        if (strpos($nomorPinjam, 'PJM-S') === 0) {
            $peminjaman = PeminjamanSiswa::where('NoPinjamM', $nomorPinjam)->firstOrFail();
        } else {
            $peminjaman = PeminjamanNonSiswa::where('NoPinjamN', $nomorPinjam)->firstOrFail();
        }

        $hariTerlambat = max(0, Carbon::now()->diffInDays($peminjaman->TglJatuhTempo));
        $denda = $hariTerlambat * 1000; // Rp1000 per day
        
        return response()->json([
            'denda' => $denda,
            'hari_terlambat' => $hariTerlambat
        ]);
    }
}
