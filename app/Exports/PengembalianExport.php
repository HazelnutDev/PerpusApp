<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengembalianExport implements FromView
{
    protected $pengembalian;
    protected $startDate;
    protected $endDate;
    protected $message;

    public function __construct($pengembalian, $startDate, $endDate, $message = null)
    {
        $this->pengembalian = $pengembalian;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->message = $message;
    }

    public function view(): View
    {
        return view('laporan.laporanPengembalian.cetak-excel', [
            'pengembalian' => $this->pengembalian,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'message' => $this->message,
        ]);
    }
} 