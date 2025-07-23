<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PeminjamanExport implements FromView
{
    protected $peminjaman;
    protected $startDate;
    protected $endDate;
    protected $message;

    public function __construct($peminjaman, $startDate, $endDate, $message = null)
    {
        $this->peminjaman = $peminjaman;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->message = $message;
    }

    public function view(): View
    {
        return view('laporan.peminjaman.cetak-excel', [
            'peminjaman' => $this->peminjaman,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'message' => $this->message,
        ]);
    }
} 