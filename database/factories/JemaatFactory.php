<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jemaat>
 */
class JemaatFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Kita biarkan user_id kosong di sini, nanti diisi lewat Seeder
            'user_id' => User::factory(),
            'full_name' => fake()->name(),
            'gender' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'birth_place' => fake()->city(),
            'birth_date' => fake()->date('Y-m-d', '2005-01-01'), // Contoh data minimal umur tertentu
            'address' => fake()->address(),
            'phone_number' => fake()->phoneNumber(),
            'profile_picture' => null, // Biarkan null atau kasih default.jpg
        ];
    }
}
