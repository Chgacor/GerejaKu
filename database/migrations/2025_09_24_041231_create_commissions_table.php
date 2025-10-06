<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Komisi, cth: Komisi Pemuda
            $table->string('slug')->unique(); // Untuk URL yang rapi, cth: komisi-pemuda
            $table->string('head_of_commission')->nullable(); // Nama Ketua Komisi
            $table->text('purpose')->nullable(); // Fungsi & Tujuan / Pengetahuan
            $table->longText('management_structure')->nullable(); // Struktur Pengurus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};

