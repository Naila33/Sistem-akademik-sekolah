<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_calon_siswa', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('calon_siswa_id');

            $table->enum('jenis_dokumen', [
                'SKL / Ijazah',
                'Rapor',
                'KK',
                'Akte Kelahiran',
                'Surat Kesehatan',
                'Surat Pernyataan Orang Tua',
                'Bukti Penerimaan Tahap',
                'Surat Izin Keluar',
                'Surat Dispensasi'
            ]);

            $table->string('nama_file')->nullable();
            $table->string('path_file')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('ukuran_file')->nullable();

            $table->enum('status', [
                'Belum Diverifikasi',
                'Valid',
                'Tidak Valid',
                'Revisi'
            ])->default('Belum Diverifikasi');

            $table->text('catatan')->nullable();

            $table->timestamp('tanggal_verifikasi')->nullable();

            $table->timestamps();

            // Relasi ke calon siswa
            $table->foreign('calon_siswa_id')
                ->references('id')
                ->on('calon_siswa')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Satu jenis dokumen hanya boleh satu
            // untuk setiap calon siswa
            $table->unique([
                'calon_siswa_id',
                'jenis_dokumen'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_calon_siswa');
    }
};