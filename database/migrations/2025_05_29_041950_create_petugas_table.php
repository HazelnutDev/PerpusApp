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
        Schema::create('petugas', function (Blueprint $table) {
            $table->string('KodePetugas')->primary();
            $table->string('Nama');
            $table->string('Username');
            $table->string('Password');
            $table->enum('Role', ['admin','petugas'])->default('petugas');
            $table->string('foto')->nullable(); // Assuming 'foto' is a column for storing profile pictures
            $table->rememberToken(); // For "remember me" functionality // Optional: to track who deleted the record
            $table->softDeletes(); // Soft delete column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
