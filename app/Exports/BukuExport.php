<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BukuExport implements FromView
{
    protected $buku;
    protected $startDate;
    protected $endDate;
    protected $message;

    public function __construct($buku, $startDate, $endDate, $message = null)
    {
        $this->buku = $buku;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->message = $message;
    }

    public function view(): View
    {
        return view('laporan.laporanBuku.cetak-excel', [
            'buku' => $this->buku,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'message' => $this->message,
        ]);
    }
} 