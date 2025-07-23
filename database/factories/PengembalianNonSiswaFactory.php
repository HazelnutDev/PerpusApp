<?php

namespace Database\Factories;

use App\Models\PeminjamanNonSiswa;
use App\Models\Petugas;
use App\Models\PengembalianNonSiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengembalianNonSiswaFactory extends Factory
{
    protected $model = PengembalianNonSiswa::class;

    public function definition(): array
    {
        static $noKembali = 1;
        $peminjaman = PeminjamanNonSiswa::inRandomOrder()->first();
        
        // Get the latest NoKembaliN and increment it
        $latest = PengembalianNonSiswa::orderBy('NoKembaliN', 'desc')->first();
        if ($latest) {
            $lastNumber = (int)substr($latest->NoKembaliN, 6);
            $noKembali = $lastNumber + 1;
        }

        return [
            'NoKembaliN' => 'KBL-N' . str_pad($noKembali++, 4, '0', STR_PAD_LEFT),
            'NoPinjamN' => $peminjaman?->NoPinjamN ?? null,
            'TglKembali' => now(),
            'KodePetugas' => Petugas::inRandomOrder()->first()?->KodePetugas ?? null,
            'Denda' => $this->faker->randomElement([0, 1000, 2000, 3000, 5000]),
        ];
    }
}
