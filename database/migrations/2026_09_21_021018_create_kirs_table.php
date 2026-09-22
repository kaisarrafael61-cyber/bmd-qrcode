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
        Schema::create('kirs', function (Blueprint $table) {
            $table->id();
            $table->string('ruangan')->default('Sekretariat'); // Untuk membedakan asal ruangan
            $table->string('jenis_barang')->nullable();
            $table->string('merk_model')->nullable();
            $table->string('no_seri')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('bahan')->nullable();
            $table->string('tahun_pembuatan')->nullable();
            $table->string('no_kode_barang')->nullable();
            $table->string('jumlah_register')->nullable();
            $table->string('keadaan_barang')->nullable(); // Baik, Kurang Baik, atau Rusak Berat
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kirs');
    }
};