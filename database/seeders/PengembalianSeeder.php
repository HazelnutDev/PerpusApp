<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengembalianSiswa;
use App\Models\PengembalianNonSiswa;
use App\Models\PeminjamanSiswa;
use App\Models\PeminjamanNonSiswa;
use App\Models\Petugas;
use App\Models\DetailPeminjamanSiswa;
use App\Models\DetailPeminjamanNonSiswa;
use App\Models\DetailPengembalianSiswa;
use App\Models\DetailPengembalianNonSiswa;

class PengembalianSeeder extends Seeder
{
    public function run(): void
    {
        $petugas = Petugas::pluck('KodePetugas')->toArray();
        
        // Pengembalian Siswa
        $peminjamanSiswa = PeminjamanSiswa::with('detailPeminjaman')
            ->whereDoesntHave('pengembalian')
            ->inRandomOrder()
            ->limit(5)
            ->get();
            
        foreach ($peminjamanSiswa as $pinjam) {
            // Buat header pengembalian
            $pengembalian = PengembalianSiswa::factory()->create([
                'NoPinjamM' => $pinjam->NoPinjamM,
                'TglKembali' => now()->addDays(rand(1, 10)),
                'KodePetugas' => fake()->randomElement($petugas),
                'Denda' => rand(0, 5000), // Denda acak antara 0-5000
            ]);
            
            // Ambil detail peminjaman
            $detailPeminjaman = $pinjam->detailPeminjaman;
            
            // Buat detail pengembalian untuk setiap buku yang dipinjam
            foreach ($detailPeminjaman as $detail) {
                DetailPengembalianSiswa::create([
                    'NoKembaliM' => $pengembalian->NoKembaliM,
                    'KodeBuku' => $detail->KodeBuku,
                    'KodePetugas' => $pengembalian->KodePetugas,
                    'Jumlah' => $detail->Jumlah,
                    'Denda' => $pengembalian->Denda / count($detailPeminjaman), // Bagi denda ke setiap buku
                ]);
            }
        }

        // Pengembalian Non Siswa
        $peminjamanNonSiswa = PeminjamanNonSiswa::with('detailPeminjaman')
            ->whereDoesntHave('pengembalian')
            ->inRandomOrder()
            ->limit(3)
            ->get();
            
        foreach ($peminjamanNonSiswa as $pinjam) {
            // Buat header pengembalian
            $pengembalian = PengembalianNonSiswa::factory()->create([
                'NoPinjamN' => $pinjam->NoPinjamN,
                'TglKembali' => now()->addDays(rand(1, 10)),
                'KodePetugas' => fake()->randomElement($petugas),
                'Denda' => rand(0, 5000), // Denda acak antara 0-5000
            ]);
            
            // Ambil detail peminjaman
            $detailPeminjaman = $pinjam->detailPeminjaman;
            
            // Buat detail pengembalian untuk setiap buku yang dipinjam
            foreach ($detailPeminjaman as $detail) {
                DetailPengembalianNonSiswa::create([
                    'NoKembaliN' => $pengembalian->NoKembaliN,
                    'KodeBuku' => $detail->KodeBuku,
                    'KodePetugas' => $pengembalian->KodePetugas,
                    'Jumlah' => $detail->Jumlah,
                    'Denda' => $pengembalian->Denda / count($detailPeminjaman), // Bagi denda ke setiap buku
                ]);
            }
        }
    }
}
