<?php

namespace Database\Factories;

use App\Models\Petugas;
use App\Models\PeminjamanSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengembalianSiswaFactory extends Factory
{
    public function definition(): array
    {
        static $noKembali = 1;
        $peminjaman = PeminjamanSiswa::inRandomOrder()->first();
        return [
            'NoKembaliM' => 'KBL-S' . str_pad($noKembali++, 4, '0', STR_PAD_LEFT),
            'NoPinjamM' => $peminjaman->NoPinjamM,
            'TglKembali' => $this->faker->dateTimeBetween($peminjaman->TglPinjam, '+1 month'),
            'Denda' => $this->faker->randomFloat(2, 0, 50000),
            'KodePetugas' => Petugas::inRandomOrder()->first()->KodePetugas,
        ];
    }
}
