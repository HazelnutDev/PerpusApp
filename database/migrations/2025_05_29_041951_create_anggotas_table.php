<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->string('NoAnggotaM')->primary();
            $table->string('NIS')->unique();
            $table->string('NamaAnggota')->nullable();
            $table->string('TanggalLahir')->nullable();
            $table->string('JenisKelamin')->nullable();
            $table->string('Alamat')->nullable();
            $table->string('Kelas')->nullable();
            $table->string('NoTelp')->nullable();
            $table->string('NamaOrtu')->nullable();
            $table->string('NoTelpOrtu')->nullable();
            $table->timestamps();
        });

        Schema::create('anggota_non_siswa', function (Blueprint $table) {
            $table->string('NoAnggotaN')->primary();
            $table->string('NIP')->unique();
            $table->string('NamaAnggota')->nullable();
            $table->string('Pekerjaan')->nullable();
            $table->string('JenisKelamin')->nullable();
            $table->string('TanggalLahir')->nullable();
            $table->string('Alamat')->nullable();
            $table->string('NoTelp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
        Schema::dropIfExists('anggota_non_siswa');
    }
};
