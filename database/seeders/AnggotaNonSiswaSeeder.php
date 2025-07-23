<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AnggotaNonSiswaSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\AnggotaNonSiswa::factory(5)->create();
    }
} 