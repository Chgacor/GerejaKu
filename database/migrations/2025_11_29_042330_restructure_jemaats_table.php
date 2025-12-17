<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jemaats', function (Blueprint $table) {
            // 1. Tambahkan Foreign Key ke tabel users
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');

            // 2. Hapus kolom autentikasi yang redundan (karena sudah ada di tabel users)
            // Pastikan Anda sudah memindahkan datanya jika ini aplikasi live
            $table->dropColumn(['email', 'password', 'username', 'role']);
        });
    }

    public function down(): void
    {
        Schema::table('jemaats', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('role')->default('user');
        });
    }
};
