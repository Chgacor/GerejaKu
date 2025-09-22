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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('speaker')->nullable(); // Untuk pembicara ibadah
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('set null'); // Relasi ke divisi
            $table->string('type'); // Tipe: 'Ibadah', 'Acara', 'Latihan', dll.
            $table->string('image')->nullable();
            $table->boolean('is_featured')->default(false); // Untuk pin/sorotan
            $table->string('color')->nullable(); // Untuk warna pin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
