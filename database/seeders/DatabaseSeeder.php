<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\AnggotaNonSiswa;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset auto-increment
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->call([
        PetugasSeeder::class,
        BukuSeeder::class,
        ]);
    }
}
        $anggotas = Anggota::factory(4)->create();
        $anggotaNonSiswa = AnggotaNonSiswa::factory(2)->create();
