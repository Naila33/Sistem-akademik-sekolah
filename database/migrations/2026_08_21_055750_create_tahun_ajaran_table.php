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
        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 9); // Contoh: "2025/2026" (pas 9 karakter)
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->boolean('status')->default(false); // true = Aktif, false = Nonaktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_ajaran'); // Disesuaikan menjadi 'tahun_ajaran'
    }
};