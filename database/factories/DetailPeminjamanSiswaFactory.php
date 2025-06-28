<?php

namespace Database\Factories;

use App\Models\Buku;
use App\Models\PeminjamanSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailPeminjamanSiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'NoPinjamM' => PeminjamanSiswa::inRandomOrder()->first()->NoPinjamM,
            'KodeBuku' => Buku::inRandomOrder()->first()->KodeBuku,
            'KodePetugas' => \App\Models\Petugas::inRandomOrder()->first()->KodePetugas,
        ];
    }
}
