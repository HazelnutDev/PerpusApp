<?php

namespace Database\Factories;

use App\Models\PeminjamanSiswa;
use App\Models\Anggota;
use App\Models\Petugas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PeminjamanSiswa>
 */
class PeminjamanSiswaFactory extends Factory
{
    protected $model = PeminjamanSiswa::class;

    public function definition(): array
    {
        static $counter = 1;
        $tglPinjam = $this->faker->dateTimeBetween('-1 month', 'now');
        $tglJatuhTempo = date('Y-m-d', strtotime($tglPinjam->format('Y-m-d') . ' +7 days'));

        return [
            'NoPinjamM' => 'PJM-S' . str_pad($counter++, 4, '0', STR_PAD_LEFT),
            'TglPinjam' => $tglPinjam,
            'TglJatuhTempo' => $tglJatuhTempo,
            'NoAnggotaM' => Anggota::factory(),
            'KodePetugas' => Petugas::factory()
        ];
    }
}
