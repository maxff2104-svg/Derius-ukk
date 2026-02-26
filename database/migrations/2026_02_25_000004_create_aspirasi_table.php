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
        Schema::create('aspirasi', function (Blueprint $table) {
            $table->id('id_aspirasi');
            $table->string('id_pelaporan', 30)->unique();
            $table->string('nis', 20);
            $table->foreign('nis')->references('nis')->on('siswa')->cascadeOnDelete();
            $table->unsignedBigInteger('id_kategori');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->cascadeOnDelete();
            $table->string('lokasi', 150)->nullable();
            $table->text('keterangan');
            $table->string('foto_bukti')->nullable();
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            $table->text('feedback')->nullable();
            $table->tinyInteger('progres_perbaikan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirasi');
    }
};
