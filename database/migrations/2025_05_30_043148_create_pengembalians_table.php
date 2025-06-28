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
        Schema::create('kembali_siswa', function (Blueprint $table) {
            $table->string('NoKembaliM')->primary();
            $table->string('NoPinjamM');
            $table->date('TglKembali');
            $table->string('KodePetugas');
            $table->double('Denda');
            $table->timestamps();

            $table->foreign('NoPinjamM')->references('NoPinjamM')->on('peminjamen_header_siswa')->onDelete('cascade');
            $table->foreign('KodePetugas')->references('KodePetugas')->on('petugas')->onDelete('cascade');
        });

        Schema::create('kembali_non_siswa', function (Blueprint $table) {
            $table->string('NoKembaliN')->primary();
            $table->string('NoPinjamN');
            $table->date('TglKembali');
            $table->string('KodePetugas');
            $table->double('Denda');
            $table->timestamps();

            $table->foreign('NoPinjamN')->references('NoPinjamN')->on('peminjamen_header_non_siswa')->onDelete('cascade');
            $table->foreign('KodePetugas')->references('KodePetugas')->on('petugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kembali_siswa');
        Schema::dropIfExists('kembali_non_siswa');
    }
};
