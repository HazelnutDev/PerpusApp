<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PengembalianNonSiswaFactory extends Factory
{
    public function definition(): array
    {
        static $noKembali = 1;
        return [
            'NoKembaliN' => 'KBL-N' . date('ymd') . str_pad($noKembali++, 4, '0', STR_PAD_LEFT),
            'TglKembali' => now(),
            'Denda' => $this->faker->randomElement([0, 1000, 2000, 3000, 5000]),
            // NoPinjamN and KodePetugas will be set when creating
        ];
    }
}
