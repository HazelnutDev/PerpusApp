<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    public function definition(): array
    {
        static $kodeBuku = 1;
        $stok = $this->faker->numberBetween(10, 50);
       
        return [
            'KodeBuku' => 'B' . str_pad($kodeBuku++, 4, '0', STR_PAD_LEFT),
            'NoUDC' => $this->faker->unique()->numerify('UDC###'),
            'Judul' => $this->faker->sentence(3),
            'Penerbit' => $this->faker->company(),
            'Pengarang' => $this->faker->name(),
            'TahunTerbit' => $this->faker->numberBetween(1950, 2024), // UBAH INI!
            'Deskripsi' => $this->faker->paragraph(),
            'ISBN' => $this->faker->unique()->isbn13(),
            'Stok' => $stok
        ];
    }
}