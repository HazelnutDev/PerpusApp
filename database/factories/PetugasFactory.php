<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Petugas>
 */
class PetugasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create('id_ID');
        static $kodePetugas = 1;
        return [
            "KodePetugas" => "PTG" . str_pad($kodePetugas++, 3, '0', STR_PAD_LEFT),
            "Nama"=> $faker->name(),
            "Username"=> $faker->username(),
            "Password"=> bcrypt('password'), // Default password
            "Role"=> $faker->randomElement(['admin', 'petugas'])
        ];
    }
}
