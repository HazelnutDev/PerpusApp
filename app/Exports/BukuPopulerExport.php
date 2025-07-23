<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BukuPopulerExport implements FromView
{
    protected $bukuPopuler;
    protected $startDate;
    protected $endDate;
    protected $message;

    public function __construct($bukuPopuler, $startDate, $endDate, $message = null)
    {
        $this->bukuPopuler = $bukuPopuler;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->message = $message;
    }

    public function view(): View
    {
        return view('laporan.laporanBukuPopuler.cetak-excel', [
            'bukuPopuler' => $this->bukuPopuler,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'message' => $this->message,
        ]);
    }
} 