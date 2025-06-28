<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanNonSiswaFactory extends Factory
{
    protected static $noPinjam = 1;

    public function definition(): array
    {
        $currentNoPinjam = static::$noPinjam++;
        return [
            'NoPinjamN' => 'PJM-N' . now()->format('ymd') . str_pad($currentNoPinjam, 4, '0', STR_PAD_LEFT),
            'TglPinjam' => now(),
            'TglJatuhTempo' => now()->addDays(7),
        ];
    }
}
