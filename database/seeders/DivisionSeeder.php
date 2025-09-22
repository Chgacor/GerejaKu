<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            ['name' => 'Sekolah Minggu', 'schedule_info' => 'Minggu jam 09.00 - 10.30', 'default_time' => '09:00:00'],
            ['name' => 'Ibadah Raya 1', 'schedule_info' => 'Minggu jam 09.00 - 10.30', 'default_time' => '09:00:00'],
            ['name' => 'Tunas & Remaja', 'schedule_info' => 'Minggu 11.00 - 13.00', 'default_time' => '11:00:00'],
            ['name' => 'Ibadah Raya 2', 'schedule_info' => 'Minggu jam 17.00 - 18.30', 'default_time' => '17:00:00'],
            ['name' => 'Epic Ministry', 'schedule_info' => 'Sabtu Minggu ke 4, jam 18.00 - Selesai', 'default_time' => '18:00:00'],
            ['name' => 'Ibadah Doa', 'schedule_info' => 'Kamis Jam 19.00 - 20.00', 'default_time' => '19:00:00'],
            ['name' => 'Usia Indah', 'schedule_info' => 'Sabtu jam 13.00 - 14.00', 'default_time' => '13:00:00'],
        ];

        Division::query()->delete();

        foreach ($divisions as $division) {
            Division::create($division);
        }
    }
}
