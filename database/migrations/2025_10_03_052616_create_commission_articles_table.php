<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commission_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commission_id')->constrained('commissions')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author')->nullable();
            $table->enum('category', ['Berita', 'Kegiatan', 'Pengetahuan', 'Doa & Rencana']);
            $table->longText('content');
            $table->string('cover_image')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_articles');
    }
};
