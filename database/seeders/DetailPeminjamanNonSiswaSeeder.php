<?php

namespace Database\Seeders;

use App\Models\DetailPeminjamanNonSiswa;
use App\Models\PeminjamanNonSiswa;
use App\Models\Buku;
use App\Models\Petugas;
use Illuminate\Database\Seeder;

class DetailPeminjamanNonSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $peminjaman = PeminjamanNonSiswa::all();
        
        foreach ($peminjaman as $p) {
            // Create 1-3 detail peminjaman for each peminjaman
            $count = rand(1, 3);
            for ($i = 0; $i < $count; $i++) {
                DetailPeminjamanNonSiswa::factory()->create([
                    'NoPinjamN' => $p->NoPinjamN,
                    'KodeBuku' => Buku::where('Stok', '>', 0)->inRandomOrder()->first()->KodeBuku,
                    'KodePetugas' => Petugas::inRandomOrder()->first()->KodePetugas,
                ]);
            }
        }
    }
}
