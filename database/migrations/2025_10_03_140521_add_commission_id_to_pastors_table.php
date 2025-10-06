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
            // Kolom ini boleh null, karena tidak semua profil (cth: Gembala) terikat ke komisi.
            $table->foreignId('commission_id')->nullable()->after('kelompok')->constrained('commissions')->onDelete('set null');
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
