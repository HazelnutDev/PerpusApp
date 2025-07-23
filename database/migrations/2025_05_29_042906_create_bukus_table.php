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
        Schema::create('buku', function (Blueprint $table) {
            $table->string('KodeBuku')->primary();
            $table->string('NoUDC');
            $table->string('Judul');
            $table->string('Penerbit');
            $table->string('Pengarang');
            $table->year('TahunTerbit'); // Kembali ke year() yang lebih tepat
            $table->text('Deskripsi')->nullable();
            $table->string('ISBN')->unique();
            $table->integer('Stok')->default(0);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};