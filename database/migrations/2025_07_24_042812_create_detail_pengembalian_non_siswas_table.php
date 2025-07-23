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
        Schema::create('detail_pengembalian_non_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('NoKembaliN');
            $table->string('KodeBuku');
            $table->string('KodePetugas');
            $table->unsignedTinyInteger('Jumlah')->default(1);
            $table->decimal('Denda', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('NoKembaliN')->references('NoKembaliN')->on('kembali_non_siswa')->onDelete('cascade');
            $table->foreign('KodeBuku')->references('KodeBuku')->on('buku')->onDelete('cascade');
            $table->foreign('KodePetugas')->references('KodePetugas')->on('petugas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengembalian_non_siswa');
    }
};
