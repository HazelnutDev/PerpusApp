<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PeminjamanSiswa;
use App\Models\Anggota;
use App\Models\Petugas;
use App\Models\Buku;
use App\Models\DetailPeminjamanSiswa;

class PeminjamanSiswaSeeder extends Seeder
{
    public function run(): void
    {
        $anggota = Anggota::pluck('NoAnggotaM')->toArray();
        $petugas = Petugas::pluck('KodePetugas')->toArray();
        $buku = Buku::pluck('KodeBuku')->toArray();

        // Cek apakah data tersedia
        if (empty($anggota) || empty($petugas) || empty($buku)) {
            $this->command->warn('Seeder PeminjamanSiswa dilewati karena data referensi (anggota/petugas/buku) tidak lengkap.');
            return;
        }

        // Buat 10 peminjaman
        for ($i = 0; $i < 10; $i++) {
            // Buat header peminjaman
            $peminjaman = PeminjamanSiswa::factory()->make();
            $peminjaman->NoAnggotaM = fake()->randomElement($anggota);
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
                DetailPeminjamanSiswa::create([
                    'NoPinjamM' => $peminjaman->NoPinjamM,
                    'KodeBuku' => $kodeBuku,
                    'KodePetugas' => $peminjaman->KodePetugas,
                    'Jumlah' => 1, // Default 1 buku per item
                ]);
            }
        }
    }
}

