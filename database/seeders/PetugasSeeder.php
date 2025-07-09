<?php

namespace Database\Seeders;

use App\Models\Petugas;
use Carbon\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Facade;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Petugas::create([
            'KodePetugas' => 'PTG01',
            'Nama' => 'Admin Perpustakaan',
            'Username' => 'admin',
            'Password' => bcrypt('admin'),
            'Role' => 'admin',
        ]);
        
        Petugas::create([
            'KodePetugas' => 'PTG02',
            'Nama' => 'Petugas Perpustakaan',
            'Username' => 'petugas',
            'Password' => bcrypt('petugas'),
            'Role' => 'petugas',
        ]);
    }
}