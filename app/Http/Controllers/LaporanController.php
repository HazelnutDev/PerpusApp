<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanSiswa;
use App\Models\PeminjamanNonSiswa;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\AnggotaNonSiswa;
use App\Models\PengembalianSiswa;
use App\Models\PengembalianNonSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BukuExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnggotaExport;
use App\Exports\PeminjamanExport;
use App\Exports\PengembalianExport;
use App\Exports\KeterlambatanExport;
use App\Exports\BukuPopulerExport;

class LaporanController extends Controller
{
    public function laporanBuku(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $buku = collect();
        $message = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'start_date.required' => 'Tanggal mulai wajib diisi.',
                'end_date.required' => 'Tanggal akhir wajib diisi.',
                'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal akhir.',
                'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
            ]);

            $startDateCarbon = Carbon::parse($startDate)->startOfDay();
            $endDateCarbon = Carbon::parse($endDate)->endOfDay();

            $buku = Buku::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
                ->orderBy('created_at', 'desc')
                ->get();

            if ($buku->isEmpty()) {
                $message = 'Data buku pada periode ini tidak ditemukan.';
            }
        }

        return view('laporan.laporanBuku.index', compact('buku', 'startDate', 'endDate', 'message'));
    }

    public function cetakLaporanBuku(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();

        $buku = Buku::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->orderBy('created_at', 'desc')
            ->get();

        $message = $buku->isEmpty() ? 'Data buku pada periode ini tidak ditemukan.' : null;

        $pdf = Pdf::loadView('laporan.laporanBuku.cetak', compact('buku', 'startDate', 'endDate', 'message'));
        return $pdf->stream('laporan-buku-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    public function exportLaporanBukuExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $startDateCarbon = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = \Carbon\Carbon::parse($endDate)->endOfDay();

        $buku = \App\Models\Buku::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->orderBy('created_at', 'desc')
            ->get();

        $message = $buku->isEmpty() ? 'Data buku pada periode ini tidak ditemukan.' : null;

        return Excel::download(new BukuExport($buku, $startDate, $endDate, $message), 'laporan-buku-' . $startDate . '-sd-' . $endDate . '.xlsx');
    }

    public function laporanAnggota(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $anggota = collect();
        $message = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'start_date.required' => 'Tanggal mulai wajib diisi.',
                'end_date.required' => 'Tanggal akhir wajib diisi.',
                'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal akhir.',
                'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
            ]);

            $startDateCarbon = Carbon::parse($startDate)->startOfDay();
            $endDateCarbon = Carbon::parse($endDate)->endOfDay();

            $anggotaSiswa = Anggota::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $item->jenis = 'Siswa';
                    return $item;
                });

            $anggotaNonSiswa = AnggotaNonSiswa::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $item->jenis = 'Non Siswa';
                    return $item;
                });

            $anggota = $anggotaSiswa->concat($anggotaNonSiswa)->sortByDesc('created_at');

            if ($anggota->isEmpty()) {
                $message = 'Data anggota pada periode ini tidak ditemukan.';
            }
        }

        return view('laporan.laporanAnggota.index', compact('anggota', 'startDate', 'endDate', 'message'));
    }

    public function cetakLaporanAnggota(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();

        $anggotaSiswa = Anggota::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'Siswa';
                return $item;
            });

        $anggotaNonSiswa = AnggotaNonSiswa::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'Non Siswa';
                return $item;
            });

        $anggota = $anggotaSiswa->concat($anggotaNonSiswa)->sortByDesc('created_at');

        $message = $anggota->isEmpty() ? 'Data anggota pada periode ini tidak ditemukan.' : null;

        $pdf = Pdf::loadView('laporan.laporanAnggota.cetak', compact('anggota', 'startDate', 'endDate', 'message'));
        return $pdf->stream('laporan-anggota-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    public function exportLaporanAnggotaExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $startDateCarbon = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = \Carbon\Carbon::parse($endDate)->endOfDay();

        $anggotaSiswa = \App\Models\Anggota::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'Siswa';
                return $item;
            });
        $anggotaNonSiswa = \App\Models\AnggotaNonSiswa::whereBetween('created_at', [$startDateCarbon, $endDateCarbon])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->jenis = 'Non Siswa';
                return $item;
            });
        $anggota = $anggotaSiswa->concat($anggotaNonSiswa)->sortByDesc('created_at');
        $message = $anggota->isEmpty() ? 'Data anggota pada periode ini tidak ditemukan.' : null;
        return \Maatwebsite\Excel\Facades\Excel::download(new AnggotaExport($anggota, $startDate, $endDate, $message), 'laporan-anggota-' . $startDate . '-sd-' . $endDate . '.xlsx');
    }

    public function peminjaman(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $peminjaman = collect();
        $message = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'start_date.required' => 'Tanggal mulai wajib diisi.',
                'end_date.required' => 'Tanggal akhir wajib diisi.',
                'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal akhir.',
                'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
            ]);

            $startDateCarbon = Carbon::parse($startDate)->startOfDay();
            $endDateCarbon = Carbon::parse($endDate)->endOfDay();

            $peminjamanSiswa = PeminjamanSiswa::with([
                'anggota',
                'petugas',
                'detailPeminjaman.buku',
                'detailPeminjaman.petugas'
            ])
                ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
                ->orderBy('TglPinjam', 'desc')
                ->get();

            $peminjamanNonSiswa = PeminjamanNonSiswa::with([
                'anggota',
                'petugas',
                'detailPeminjaman.buku',
                'detailPeminjaman.petugas'
            ])
                ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
                ->orderBy('TglPinjam', 'desc')
                ->get();

            $peminjaman = $peminjamanSiswa->concat($peminjamanNonSiswa)->sortByDesc('TglPinjam');

            if ($peminjaman->isEmpty()) {
                $message = 'Data peminjaman pada periode ini tidak ditemukan.';
            }
        }

        return view('laporan.peminjaman.index', compact('peminjaman', 'startDate', 'endDate', 'message'));
    }

    public function cetakPeminjaman(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();

        $peminjamanSiswa = PeminjamanSiswa::with([
            'anggota',
            'petugas',
            'detailPeminjaman.buku',
            'detailPeminjaman.petugas'
        ])
            ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        $peminjamanNonSiswa = PeminjamanNonSiswa::with([
            'anggota',
            'petugas',
            'detailPeminjaman.buku',
            'detailPeminjaman.petugas'
        ])
            ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
            ->orderBy('TglPinjam', 'desc')
            ->get();

        $peminjaman = $peminjamanSiswa->concat($peminjamanNonSiswa)->sortByDesc('TglPinjam');

        $message = $peminjaman->isEmpty() ? 'Data peminjaman pada periode ini tidak ditemukan.' : null;

        $pdf = Pdf::loadView('laporan.peminjaman.cetak', compact('peminjaman', 'startDate', 'endDate', 'message'));
        return $pdf->stream('laporan-peminjaman-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    public function exportPeminjamanExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $startDateCarbon = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = \Carbon\Carbon::parse($endDate)->endOfDay();
        $peminjamanSiswa = \App\Models\PeminjamanSiswa::with(['anggota', 'petugas', 'detailPeminjaman.buku', 'detailPeminjaman.petugas', 'pengembalian'])
            ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
            ->orderBy('TglPinjam', 'desc')
            ->get();
        $peminjamanNonSiswa = \App\Models\PeminjamanNonSiswa::with(['anggota', 'petugas', 'detailPeminjaman.buku', 'detailPeminjaman.petugas', 'pengembalian'])
            ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
            ->orderBy('TglPinjam', 'desc')
            ->get();
        $peminjaman = $peminjamanSiswa->concat($peminjamanNonSiswa)->sortByDesc('TglPinjam');
        $message = $peminjaman->isEmpty() ? 'Data peminjaman pada periode ini tidak ditemukan.' : null;
        return \Maatwebsite\Excel\Facades\Excel::download(new PeminjamanExport($peminjaman, $startDate, $endDate, $message), 'laporan-peminjaman-' . $startDate . '-sd-' . $endDate . '.xlsx');
    }

    public function laporanPengembalian(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $pengembalian = collect();
        $message = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'start_date.required' => 'Tanggal mulai wajib diisi.',
                'end_date.required' => 'Tanggal akhir wajib diisi.',
                'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal akhir.',
                'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
            ]);

            $startDateCarbon = Carbon::parse($startDate)->startOfDay();
            $endDateCarbon = Carbon::parse($endDate)->endOfDay();

            $kembaliSiswa = PengembalianSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
                ->whereBetween('TglKembali', [$startDateCarbon, $endDateCarbon])
                ->orderBy('TglKembali', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'Nama' => $item->peminjaman->anggota->NamaAnggota ?? '-',
                        'Jenis' => 'Siswa',
                        'Judul' => $item->peminjaman->detailPeminjaman->pluck('buku.Judul')->implode(', ') ?? '-',
                        'TglPinjam' => $item->peminjaman->TglPinjam ?? '-',
                        'JatuhTempo' => $item->peminjaman->TglJatuhTempo ?? '-',
                        'TglKembali' => $item->TglKembali,
                        'Petugas' => $item->petugas->Nama ?? '-',
                        'Denda' => $item->Denda,
                    ];
                });

            $kembaliNonSiswa = PengembalianNonSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
                ->whereBetween('TglKembali', [$startDateCarbon, $endDateCarbon])
                ->orderBy('TglKembali', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'Nama' => $item->peminjaman->anggota->NamaAnggota ?? '-',
                        'Jenis' => 'Non Siswa',
                        'Judul' => $item->peminjaman->detailPeminjaman->pluck('buku.Judul')->implode(', ') ?? '-',
                        'TglPinjam' => $item->peminjaman->TglPinjam ?? '-',
                        'JatuhTempo' => $item->peminjaman->TglJatuhTempo ?? '-',
                        'TglKembali' => $item->TglKembali,
                        'Petugas' => $item->petugas->Nama ?? '-',
                        'Denda' => $item->Denda,
                    ];
                });

            $pengembalian = $kembaliSiswa->concat($kembaliNonSiswa)->sortByDesc('TglKembali');

            if ($pengembalian->isEmpty()) {
                $message = 'Data pengembalian pada periode ini tidak ditemukan.';
            }
        }

        return view('laporan.laporanPengembalian.index', compact('pengembalian', 'startDate', 'endDate', 'message'));
    }

    public function cetakLaporanPengembalian(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();

        $kembaliSiswa = PengembalianSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglKembali', [$startDateCarbon, $endDateCarbon])
            ->orderBy('TglKembali', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->peminjaman->anggota->NamaAnggota ?? '-',
                    'Jenis' => 'Siswa',
                    'Judul' => $item->peminjaman->detailPeminjaman->pluck('buku.Judul')->implode(', ') ?? '-',
                    'TglPinjam' => $item->peminjaman->TglPinjam ?? '-',
                    'JatuhTempo' => $item->peminjaman->TglJatuhTempo ?? '-',
                    'TglKembali' => $item->TglKembali,
                    'Petugas' => $item->petugas->Nama ?? '-',
                    'Denda' => $item->Denda,
                ];
            });

        $kembaliNonSiswa = PengembalianNonSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglKembali', [$startDateCarbon, $endDateCarbon])
            ->orderBy('TglKembali', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->peminjaman->anggota->NamaAnggota ?? '-',
                    'Jenis' => 'Non Siswa',
                    'Judul' => $item->peminjaman->detailPeminjaman->pluck('buku.Judul')->implode(', ') ?? '-',
                    'TglPinjam' => $item->peminjaman->TglPinjam ?? '-',
                    'JatuhTempo' => $item->peminjaman->TglJatuhTempo ?? '-',
                    'TglKembali' => $item->TglKembali,
                    'Petugas' => $item->petugas->Nama ?? '-',
                    'Denda' => $item->Denda,
                ];
            });

        $pengembalian = $kembaliSiswa->concat($kembaliNonSiswa)->sortByDesc('TglKembali');

        $message = $pengembalian->isEmpty() ? 'Data pengembalian pada periode ini tidak ditemukan.' : null;

        $pdf = Pdf::loadView('laporan.laporanPengembalian.cetak', compact('pengembalian', 'startDate', 'endDate', 'message'));
        return $pdf->stream('laporan-pengembalian-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    public function exportLaporanPengembalianExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $startDateCarbon = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = \Carbon\Carbon::parse($endDate)->endOfDay();
        $kembaliSiswa = \App\Models\PengembalianSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglKembali', [$startDateCarbon, $endDateCarbon])
            ->orderBy('TglKembali', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->peminjaman->anggota->NamaAnggota ?? '-',
                    'Jenis' => 'Siswa',
                    'Judul' => $item->peminjaman->detailPeminjaman->pluck('buku.Judul')->implode(', ') ?? '-',
                    'TglPinjam' => $item->peminjaman->TglPinjam ?? '-',
                    'JatuhTempo' => $item->peminjaman->TglJatuhTempo ?? '-',
                    'TglKembali' => $item->TglKembali,
                    'Petugas' => $item->petugas->Nama ?? '-',
                    'Denda' => $item->Denda,
                ];
            });
        $kembaliNonSiswa = \App\Models\PengembalianNonSiswa::with(['peminjaman.anggota', 'peminjaman.detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglKembali', [$startDateCarbon, $endDateCarbon])
            ->orderBy('TglKembali', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->peminjaman->anggota->NamaAnggota ?? '-',
                    'Jenis' => 'Non Siswa',
                    'Judul' => $item->peminjaman->detailPeminjaman->pluck('buku.Judul')->implode(', ') ?? '-',
                    'TglPinjam' => $item->peminjaman->TglPinjam ?? '-',
                    'JatuhTempo' => $item->peminjaman->TglJatuhTempo ?? '-',
                    'TglKembali' => $item->TglKembali,
                    'Petugas' => $item->petugas->Nama ?? '-',
                    'Denda' => $item->Denda,
                ];
            });
        $pengembalian = $kembaliSiswa->concat($kembaliNonSiswa)->sortByDesc('TglKembali');
        $message = $pengembalian->isEmpty() ? 'Data pengembalian pada periode ini tidak ditemukan.' : null;
        return \Maatwebsite\Excel\Facades\Excel::download(new PengembalianExport($pengembalian, $startDate, $endDate, $message), 'laporan-pengembalian-' . $startDate . '-sd-' . $endDate . '.xlsx');
    }

    public function keterlambatan(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $keterlambatan = collect();
        $message = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'start_date.required' => 'Tanggal mulai wajib diisi.',
                'end_date.required' => 'Tanggal akhir wajib diisi.',
                'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal akhir.',
                'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
            ]);

            $startDateCarbon = Carbon::parse($startDate)->startOfDay();
            $endDateCarbon = Carbon::parse($endDate)->endOfDay();
            $today = Carbon::now();

            $keterlambatanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
                ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
                ->where('TglJatuhTempo', '<', $today)
                ->whereDoesntHave('pengembalian')
                ->orderBy('TglPinjam', 'desc')
                ->get();

            $keterlambatanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
                ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
                ->where('TglJatuhTempo', '<', $today)
                ->whereDoesntHave('pengembalian')
                ->orderBy('TglPinjam', 'desc')
                ->get();

            $keterlambatan = $keterlambatanSiswa->concat($keterlambatanNonSiswa)->sortByDesc('TglPinjam');

            if ($keterlambatan->isEmpty()) {
                $message = 'Data keterlambatan pada periode ini tidak ditemukan.';
            }
        }

        return view('laporan.keterlambatan.index', compact('keterlambatan', 'startDate', 'endDate', 'message'));
    }

    public function cetakKeterlambatan(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $today = Carbon::now();

        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();

        $keterlambatanSiswa = PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        $keterlambatanNonSiswa = PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();

        $keterlambatan = $keterlambatanSiswa->concat($keterlambatanNonSiswa)->sortByDesc('TglPinjam');

        $message = $keterlambatan->isEmpty() ? 'Data keterlambatan pada periode ini tidak ditemukan.' : null;

        $pdf = Pdf::loadView('laporan.keterlambatan.cetak', compact('keterlambatan', 'startDate', 'endDate', 'message'));
        return $pdf->stream('laporan-keterlambatan-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    public function exportKeterlambatanExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $startDateCarbon = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = \Carbon\Carbon::parse($endDate)->endOfDay();
        $today = now();
        $keterlambatanSiswa = \App\Models\PeminjamanSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();
        $keterlambatanNonSiswa = \App\Models\PeminjamanNonSiswa::with(['anggota', 'detailPeminjaman.buku', 'petugas'])
            ->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon])
            ->where('TglJatuhTempo', '<', $today)
            ->whereDoesntHave('pengembalian')
            ->orderBy('TglPinjam', 'desc')
            ->get();
        $keterlambatan = $keterlambatanSiswa->concat($keterlambatanNonSiswa)->sortByDesc('TglPinjam');
        $message = $keterlambatan->isEmpty() ? 'Data keterlambatan pada periode ini tidak ditemukan.' : null;
        return \Maatwebsite\Excel\Facades\Excel::download(new KeterlambatanExport($keterlambatan, $startDate, $endDate, $message), 'laporan-keterlambatan-' . $startDate . '-sd-' . $endDate . '.xlsx');
    }

    public function bukuPopuler(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $bukuPopuler = collect();
        $message = null;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ], [
                'start_date.required' => 'Tanggal mulai wajib diisi.',
                'end_date.required' => 'Tanggal akhir wajib diisi.',
                'start_date.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal akhir.',
                'end_date.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal mulai.',
            ]);

            $startDateCarbon = Carbon::parse($startDate)->startOfDay();
            $endDateCarbon = Carbon::parse($endDate)->endOfDay();

            $bukuPopuler = Buku::withCount([
                'detailPeminjamanSiswa as peminjaman_siswa_count' => function ($query) use ($startDateCarbon, $endDateCarbon) {
                    $query->whereHas('peminjaman', function ($q) use ($startDateCarbon, $endDateCarbon) {
                        $q->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon]);
                    });
                },
                'detailPeminjamanNonSiswa as peminjaman_non_siswa_count' => function ($query) use ($startDateCarbon, $endDateCarbon) {
                    $query->whereHas('peminjaman', function ($q) use ($startDateCarbon, $endDateCarbon) {
                        $q->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon]);
                    });
                }
            ])
                ->with(['kategori', 'rak'])
                ->orderByRaw('(peminjaman_siswa_count + peminjaman_non_siswa_count) DESC')
                ->limit(10)
                ->get()
                ->map(function ($buku) {
                    $buku->total_peminjaman = $buku->peminjaman_siswa_count + $buku->peminjaman_non_siswa_count;
                    return $buku;
                });

            if ($bukuPopuler->isEmpty()) {
                $message = 'Data buku populer pada periode ini tidak ditemukan.';
            }
        }

        return view('laporan.buku-populer.index', compact('bukuPopuler', 'startDate', 'endDate', 'message'));
    }

    public function cetakBukuPopuler(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay();

        $bukuPopuler = Buku::withCount([
            'detailPeminjamanSiswa as peminjaman_siswa_count' => function ($query) use ($startDateCarbon, $endDateCarbon) {
                $query->whereHas('peminjaman', function ($q) use ($startDateCarbon, $endDateCarbon) {
                    $q->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon]);
                });
            },
            'detailPeminjamanNonSiswa as peminjaman_non_siswa_count' => function ($query) use ($startDateCarbon, $endDateCarbon) {
                $query->whereHas('peminjaman', function ($q) use ($startDateCarbon, $endDateCarbon) {
                    $q->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon]);
                });
            }
        ])
            ->with(['kategori', 'rak'])
            ->orderByRaw('(peminjaman_siswa_count + peminjaman_non_siswa_count) DESC')
            ->limit(10)
            ->get()
            ->map(function ($buku) {
                $buku->total_peminjaman = $buku->peminjaman_siswa_count + $buku->peminjaman_non_siswa_count;
                return $buku;
            });

        $message = $bukuPopuler->isEmpty() ? 'Data buku populer pada periode ini tidak ditemukan.' : null;

        $pdf = Pdf::loadView('laporan.buku-populer.cetak', compact('bukuPopuler', 'startDate', 'endDate', 'message'));
        return $pdf->stream('laporan-buku-populer-' . $startDate . '-sd-' . $endDate . '.pdf');
    }

    public function exportBukuPopulerExcel(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $startDateCarbon = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = \Carbon\Carbon::parse($endDate)->endOfDay();
        $bukuPopuler = \App\Models\Buku::withCount([
            'detailPeminjamanSiswa as peminjaman_siswa_count' => function ($query) use ($startDateCarbon, $endDateCarbon) {
                $query->whereHas('peminjaman', function ($q) use ($startDateCarbon, $endDateCarbon) {
                    $q->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon]);
                });
            },
            'detailPeminjamanNonSiswa as peminjaman_non_siswa_count' => function ($query) use ($startDateCarbon, $endDateCarbon) {
                $query->whereHas('peminjaman', function ($q) use ($startDateCarbon, $endDateCarbon) {
                    $q->whereBetween('TglPinjam', [$startDateCarbon, $endDateCarbon]);
                });
            }
        ])
            ->with(['kategori', 'rak'])
            ->orderByRaw('(peminjaman_siswa_count + peminjaman_non_siswa_count) DESC')
            ->limit(10)
            ->get()
            ->map(function ($buku) {
                $buku->total_peminjaman = $buku->peminjaman_siswa_count + $buku->peminjaman_non_siswa_count;
                return $buku;
            });
        $message = $bukuPopuler->isEmpty() ? 'Data buku populer pada periode ini tidak ditemukan.' : null;
        return \Maatwebsite\Excel\Facades\Excel::download(new BukuPopulerExport($bukuPopuler, $startDate, $endDate, $message), 'laporan-buku-populer-' . $startDate . '-sd-' . $endDate . '.xlsx');
    }
}