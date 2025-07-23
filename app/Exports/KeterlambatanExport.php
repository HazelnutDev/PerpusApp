<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KeterlambatanExport implements FromView
{
    protected $keterlambatan;
    protected $startDate;
    protected $endDate;
    protected $message;

    public function __construct($keterlambatan, $startDate, $endDate, $message = null)
    {
        $this->keterlambatan = $keterlambatan;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->message = $message;
    }

    public function view(): View
    {
        return view('laporan.keterlambatan.cetak-excel', [
            'keterlambatan' => $this->keterlambatan,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'message' => $this->message,
        ]);
    }
} 