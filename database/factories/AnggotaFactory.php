<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggota>
 */
class AnggotaFactory extends Factory
{
    private static $noAnggota = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaSiswa = [
            'Andi Pratama',
            'Sari Dewi Lestari', 
            'Muhammad Rizki Ramadhan',
            'Fitri Nur Amaliah'
        ];

        $namaOrtu = [
            'Budi Santoso',
            'Ibu Siti Aminah',
            'Drs. Ahmad Fauzi',
            'Hj. Kartini Sari, S.Pd'
        ];

        $index = (self::$noAnggota - 1) % 4;

        
        $tanggalLahir = $this->faker->dateTimeBetween('-16 years', '-11 years');

        return [
            'NoAnggotaM' => 'M' . str_pad(self::$noAnggota++, 3, '0', STR_PAD_LEFT),
            'NIS' => $this->faker->unique()->numerify('20240###'), 
            'NamaAnggota' => $namaSiswa[$index],
            'TanggalLahir' => $tanggalLahir->format('d-m-Y'),
            'JenisKelamin' => $index % 2 == 0 ? 'L' : 'P', 
            'Alamat' => $this->faker->streetAddress() . ', ' . $this->faker->city(),
            'Kelas' => $this->faker->randomElement(['VII', 'VIII', 'IX']) . ' ' . 
                      $this->faker->randomElement(['A', 'B']),
            'NoTelp' => '08' . $this->faker->numerify('##########'),
            'NamaOrtu' => $namaOrtu[$index],
            'NoTelpOrtu' => '08' . $this->faker->numerify('##########'),
        ];
    }
}