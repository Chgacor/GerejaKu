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
            // Mengubah nama kolom agar konsisten Inggris
            $table->renameColumn('nama_lengkap', 'full_name');
            $table->renameColumn('kelamin', 'gender');
            $table->renameColumn('tempat_lahir', 'birth_place');
            $table->renameColumn('tanggal_lahir', 'birth_date');
            $table->renameColumn('alamat', 'address');
            $table->renameColumn('no_telepon', 'phone_number');
            $table->renameColumn('foto_profil', 'profile_picture');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
