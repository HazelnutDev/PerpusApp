<?php

namespace Database\Seeders;

use App\Models\DetailPeminjamanSiswa;
use App\Models\PeminjamanSiswa;
use App\Models\Buku;
use App\Models\Petugas;
use Illuminate\Database\Seeder;

class DetailPeminjamanSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $peminjaman = PeminjamanSiswa::all();
        
        foreach ($peminjaman as $p) {
            // Create 1-3 detail peminjaman for each peminjaman
            $count = rand(1, 3);
            for ($i = 0; $i < $count; $i++) {
                DetailPeminjamanSiswa::factory()->create([
                    'NoPinjamM' => $p->NoPinjamM,
                    'KodeBuku' => Buku::where('Stok', '>', 0)->inRandomOrder()->first()->KodeBuku,
                    'KodePetugas' => Petugas::inRandomOrder()->first()->KodePetugas,
                ]);
            }
        }
    }
}
