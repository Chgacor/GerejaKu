<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import View
use App\Models\Setting; // Import Setting
use Illuminate\Support\Facades\Schema; // Import Schema

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Cek jika tabel settings sudah ada sebelum menjalankan query
        if (Schema::hasTable('settings')) {
            // Ambil data ayat mingguan dan bagikan ke semua view
            $weeklyVerse = Setting::where('key', 'weekly_verse')->first();
            View::share('weeklyVerse', $weeklyVerse);
        }
    }
}
