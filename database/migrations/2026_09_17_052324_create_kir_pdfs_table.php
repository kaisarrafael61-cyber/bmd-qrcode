<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kir_pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama/Judul dokumen KIR (misal: "KIR Ruang Admin")
            $table->string('file_path'); // Path penyimpanan file PDF
            $table->string('file_name'); // Nama asli file
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kir_pdfs');
    }
};