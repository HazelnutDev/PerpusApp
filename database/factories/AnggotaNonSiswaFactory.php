<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnggotaNonSiswa>
 */
class AnggotaNonSiswaFactory extends Factory
{
    private static $noAnggota = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaGuru = [
            'Ahmad Budiman, S.Kom',
            'Dr. Sri Wahyuni, M.Pd'
        ];

        $jabatan = [
            'Guru Teknologi Informasi',
            'Guru Matematika'
        ];

        $nip = [
            '196508121990032001',
            '198703152010011004'
        ];

        $index = (self::$noAnggota - 1) % 2;

        $tanggalLahir = $this->faker->dateTimeBetween('-95 years', '-20 years');

        return [
            'NoAnggotaN' => 'N' . str_pad(self::$noAnggota++, 3, '0', STR_PAD_LEFT),
            'NIP' => $nip[$index],
            'NamaAnggota' => $namaGuru[$index],
            'Jabatan' => $jabatan[$index],
            'JenisKelamin' => $index % 2 == 0 ? 'L' : 'P', 
            'TanggalLahir' => $tanggalLahir->format('d-m-Y'),
            'Alamat' => $this->faker->streetAddress() . ', ' . $this->faker->city(),
            'NoTelp' => '08' . $this->faker->numerify('##########'),
        ];
    }
}