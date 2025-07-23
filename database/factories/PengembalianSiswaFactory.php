<?php

namespace Database\Factories;

use App\Models\Petugas;
use App\Models\PeminjamanSiswa;
use App\Models\PengembalianSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengembalianSiswaFactory extends Factory
{
    protected $model = PengembalianSiswa::class; // WAJIB ADA

    public function definition(): array
    {
        static $noKembali = 1;
        $peminjaman = PeminjamanSiswa::inRandomOrder()->first();
        
        // Get the latest NoKembaliM and increment it
        $latest = \App\Models\PengembalianSiswa::orderBy('NoKembaliM', 'desc')->first();
        if ($latest) {
            $lastNumber = (int)substr($latest->NoKembaliM, 6);
            $noKembali = $lastNumber + 1;
        }

        return [
            'NoKembaliM' => 'KBL-S' . str_pad($noKembali++, 4, '0', STR_PAD_LEFT),
            'NoPinjamM' => $peminjaman?->NoPinjamM ?? null,
            'TglKembali' => $this->faker->dateTimeBetween($peminjaman?->TglPinjam ?? now(), '+1 month'),
            'Denda' => $this->faker->randomFloat(2, 0, 50000),
            'KodePetugas' => Petugas::inRandomOrder()->first()?->KodePetugas ?? null,
        ];
    }
}
