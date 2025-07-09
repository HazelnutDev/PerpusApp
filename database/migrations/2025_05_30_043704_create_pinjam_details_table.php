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
        Schema::create('pinjam_details_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('NoPinjamM');
            $table->string('KodeBuku');
            $table->string('KodePetugas');
            $table->unsignedTinyInteger('Jumlah')->default(1);
            $table->timestamps();

            $table->foreign('NoPinjamM')->references('NoPinjamM')->on('peminjamen_header_siswa')->onDelete('cascade');
            $table->foreign('KodeBuku')->references('KodeBuku')->on('buku')->onDelete('cascade');
            $table->foreign('KodePetugas')->references('KodePetugas')->on('petugas')->onDelete('cascade');
        });

        Schema::create('pinjam_details_non_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('NoPinjamN');
            $table->string('KodeBuku');
            $table->string('KodePetugas');
            $table->unsignedTinyInteger('Jumlah')->default(1);

            $table->timestamps();

            $table->foreign('NoPinjamN')->references('NoPinjamN')->on('peminjamen_header_non_siswa')->onDelete('cascade');
            $table->foreign('KodeBuku')->references('KodeBuku')->on('buku')->onDelete('cascade');
            $table->foreign('KodePetugas')->references('KodePetugas')->on('petugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjam_details_siswa');
        Schema::dropIfExists('pinjam_details_non_siswa');
    }
};
