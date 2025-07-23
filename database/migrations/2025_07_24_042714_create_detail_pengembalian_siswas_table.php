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
        Schema::create('detail_pengembalian_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('NoKembaliM');
            $table->string('KodeBuku');
            $table->string('KodePetugas');
            $table->unsignedTinyInteger('Jumlah')->default(1);
            $table->decimal('Denda', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('NoKembaliM')->references('NoKembaliM')->on('kembali_siswa')->onDelete('cascade');
            $table->foreign('KodeBuku')->references('KodeBuku')->on('buku')->onDelete('cascade');
            $table->foreign('KodePetugas')->references('KodePetugas')->on('petugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengembalian_siswa');
    }
};
