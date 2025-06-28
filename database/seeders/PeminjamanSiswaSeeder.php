<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeminjamanSiswa;
use App\Models\Anggota;
use App\Models\Petugas;

class PeminjamanSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $anggota = Anggota::pluck('NoAnggotaM')->toArray();
        $petugas = Petugas::pluck('KodePetugas')->toArray();

        // Cek apakah data tersedia
        if (empty($anggota) || empty($petugas)) {
            $this->command->warn('Seeder PeminjamanSiswa dilewati karena anggota atau petugas kosong.');
            return;
        }

        PeminjamanSiswa::factory()
            ->count(10)
            ->make()
            ->each(function ($peminjaman) use ($anggota, $petugas) {
                $peminjaman->NoAnggotaM = fake()->randomElement($anggota);
                $peminjaman->KodePetugas = fake()->randomElement($petugas);
                $peminjaman->save();
            });
    }
}

