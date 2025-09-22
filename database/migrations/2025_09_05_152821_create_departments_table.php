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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama departemen, cth: "Departemen Ibadah"
            $table->text('function'); // Fungsi & tujuan
            $table->string('head_name'); // Nama ketua
            $table->text('committee_members')->nullable(); // Nama pengurus (kita buat teks simpel dulu)
            $table->string('image')->nullable(); // Foto/banner departemen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
