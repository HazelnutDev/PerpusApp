<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\Anggota::factory(10)->create();
    }
}
