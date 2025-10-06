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
        Schema::table('pastors', function (Blueprint $table) {
            // Kolom ini akan menyimpan nama grup, cth: "Gembala Jemaat", "Komisi Misi", dll.
            $table->string('kelompok')->nullable()->after('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pastors', function (Blueprint $table) {
            //
        });
    }
};
