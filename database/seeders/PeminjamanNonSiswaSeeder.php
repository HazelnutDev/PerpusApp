<?php

namespace Database\Seeders;

use App\Models\PeminjamanNonSiswa;
use App\Models\AnggotaNonSiswa;
use App\Models\Petugas;
use App\Models\Buku;
use App\Models\DetailPeminjamanNonSiswa;
use Illuminate\Database\Seeder;

class PeminjamanNonSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $anggota = AnggotaNonSiswa::pluck('NoAnggotaN')->toArray();
        $petugas = Petugas::pluck('KodePetugas')->toArray();
        $buku = Buku::pluck('KodeBuku')->toArray();

        if (empty($anggota) || empty($petugas) || empty($buku)) {
            $this->command->warn('Seeder PeminjamanNonSiswa dilewati karena data referensi (anggota/petugas/buku) tidak lengkap.');
            return;
        }

        // Buat 5 peminjaman non-siswa
        for ($i = 0; $i < 5; $i++) {
            // Buat header peminjaman
            $peminjaman = PeminjamanNonSiswa::factory()->make();
            $peminjaman->NoAnggotaN = fake()->randomElement($anggota);
            $peminjaman->KodePetugas = fake()->randomElement($petugas);
            $peminjaman->save();

            // Buat detail peminjaman (1-3 buku per peminjaman)
            $jumlahBuku = rand(1, 3);
            $bukuTerpilih = [];
            
            for ($j = 0; $j < $jumlahBuku; $j++) {
                // Pastikan buku tidak duplikat dalam satu peminjaman
                do {
                    $kodeBuku = fake()->randomElement($buku);
                } while (in_array($kodeBuku, $bukuTerpilih));
                
                $bukuTerpilih[] = $kodeBuku;
                
                // Buat detail peminjaman
                DetailPeminjamanNonSiswa::create([
                    'NoPinjamN' => $peminjaman->NoPinjamN,
                    'KodeBuku' => $kodeBuku,
                    'KodePetugas' => $peminjaman->KodePetugas,
                    'Jumlah' => 1, // Default 1 buku per item
                ]);
            }
        }
    }
}
