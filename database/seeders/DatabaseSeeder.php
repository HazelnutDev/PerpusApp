<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PetugasSeeder::class,
            AnggotaSeeder::class,
            AnggotaNonSiswaSeeder::class,
            BukuSeeder::class,
            PeminjamanSiswaSeeder::class,
            PeminjamanNonSiswaSeeder::class,
            PengembalianSeeder::class,
        ]);
    }
}
