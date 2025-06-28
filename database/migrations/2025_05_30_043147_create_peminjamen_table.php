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
        Schema::create('peminjamen_header_siswa', function (Blueprint $table) {
            $table->string('NoPinjamM')->primary();
            $table->date('TglPinjam');
            $table->date('TglJatuhTempo');
            $table->string('NoAnggotaM');
            $table->string('KodePetugas');
            $table->timestamps();

            $table->unique(['NoPinjamM']);
            $table->foreign('NoAnggotaM')->references('NoAnggotaM')->on('anggota')->onDelete('cascade');
            $table->foreign('KodePetugas')->references('KodePetugas')->on('petugas')->onDelete('cascade');
        });

        Schema::create('peminjamen_header_non_siswa', function (Blueprint $table) {
            $table->string('NoPinjamN')->primary();
            $table->date('TglPinjam');
            $table->date('TglJatuhTempo');
            $table->string('NoAnggotaN');
            $table->string('KodePetugas');
            $table->timestamps();

            $table->foreign('NoAnggotaN')->references('NoAnggotaN')->on('anggota_non_siswa')->onDelete('cascade');
            $table->foreign('KodePetugas')->references('KodePetugas')->on('petugas')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen_header_siswa');
        Schema::dropIfExists('peminjamen_header_non_siswa');
        Schema::dropIfExists('peminjamen_detail');
    }
};
