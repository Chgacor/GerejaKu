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
        Schema::create('qnas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('question');
            $table->text('answer')->nullable(); // Jawaban dari admin
            $table->foreignId('answered_by')->nullable()->constrained('jemaats')->onDelete('set null'); // Admin yang menjawab
            $table->timestamp('answered_at')->nullable();
            $table->boolean('is_published')->default(false); // Tampilkan di halaman publik?
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qnas');
    }
};
