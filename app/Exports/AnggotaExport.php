<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AnggotaExport implements FromView
{
    protected $anggota;
    protected $startDate;
    protected $endDate;
    protected $message;

    public function __construct($anggota, $startDate, $endDate, $message = null)
    {
        $this->anggota = $anggota;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->message = $message;
    }

    public function view(): View
    {
        return view('laporan.laporanAnggota.cetak-excel', [
            'anggota' => $this->anggota,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'message' => $this->message,
        ]);
    }
} 