<?php

namespace Database\Seeders;

use App\Models\PeminjamanNonSiswa;
use App\Models\AnggotaNonSiswa;
use App\Models\Petugas;
use Illuminate\Database\Seeder;

class PeminjamanNonSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $anggota = AnggotaNonSiswa::pluck('NoAnggotaN')->toArray();
        $petugas = Petugas::pluck('KodePetugas')->toArray();

        if (empty($anggota) || empty($petugas)) {
            $this->command->warn('Seeder PeminjamanNonSiswa dilewati karena anggota non siswa atau petugas kosong.');
            return;
        }

        PeminjamanNonSiswa::factory()
            ->count(5)
            ->make()
            ->each(function ($peminjaman) use ($anggota, $petugas) {
                $peminjaman->NoAnggotaN = fake()->randomElement($anggota);
                $peminjaman->KodePetugas = fake()->randomElement($petugas);
                $peminjaman->save();
            });
    }
}
