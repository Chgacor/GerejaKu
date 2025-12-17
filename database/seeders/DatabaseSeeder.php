<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jemaat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Jalankan Seeder Divisi (yang sudah ada sebelumnya)
        $this->call([
            DivisionSeeder::class,
        ]);

        // 2. Buat 1 Akun Admin (Untuk Login Anda)
        $admin = User::create([
            'name' => 'admin', // Username
            'email' => 'admin@gerejaku.com',
            'password' => Hash::make('password'), // Password default
            'role' => 'admin',
        ]);

        // Buat data profil untuk admin (biar tidak error saat buka profil)
        Jemaat::create([
            'user_id' => $admin->id,
            'full_name' => 'Administrator Utama',
            'gender' => 'Laki-laki',
            'birth_place' => 'Jakarta',
            'birth_date' => '1990-01-01',
            'address' => 'Kantor Gereja',
            'phone_number' => '08123456789',
        ]);

        // 3. Buat 50 Data Dummy Jemaat
        // Kita gunakan User::factory untuk buat loginnya, lalu setiap user dibuatkan 1 Jemaat
        User::factory(50)->create(['role' => 'user'])->each(function ($user) {
            Jemaat::factory()->create([
                'user_id' => $user->id,
                // full_name dll akan otomatis digenerate oleh JemaatFactory
            ]);
        });
    }
}
