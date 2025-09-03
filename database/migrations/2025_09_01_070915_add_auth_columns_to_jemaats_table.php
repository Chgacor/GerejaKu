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
        Schema::table('jemaats', function (Blueprint $table) {
            $table->string('email')->unique()->after('nama_lengkap');
            $table->string('password')->after('email');
            $table->string('role')->default('user')->after('password'); // 'user' atau 'admin'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jemaats', function (Blueprint $table) {
            //
        });
    }
};
