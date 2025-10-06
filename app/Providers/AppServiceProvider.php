<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use Exception; // Import Exception untuk ditangkap di blok catch

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Di sini kita mendaftarkan data yang akan tersedia di semua view.
     * Ini cara yang efisien untuk data global seperti info kontak atau ayat mingguan.
     */
    public function boot(): void
    {
        // Gunakan try-catch untuk menangani error jika tabel 'settings' belum ada,
        // misalnya saat menjalankan 'php artisan migrate' pertama kali.
        try {
            // Cek apakah tabel 'settings' sudah ada di database.
            if (Schema::hasTable('settings')) {
                // Ambil semua pengaturan yang kita butuhkan dalam SATU KALI query database.
                // Ini lebih efisien daripada melakukan query berulang kali.
                $settings = Setting::whereIn('key', [
                    'weekly_verse',
                    'contact_instagram',
                    'contact_phone',
                    'contact_facebook', // <-- DITAMBAHKAN
                    'contact_youtube'   // <-- DITAMBAHKAN
                ])->get()->keyBy('key'); // keyBy('key') mengubah collection agar key-nya adalah kolom 'key'.

                // Ambil model 'Setting' untuk ayat mingguan.
                // Kita ambil seluruh model agar bisa mengakses ->key dan ->value di view.
                $weeklyVerse = $settings->get('weekly_verse');

                // Buat array asosiatif untuk pengaturan kontak.
                // Menggunakan null coalescing operator (??) untuk fallback jika data tidak ada.
                $contactSettings = [
                    'contact_instagram' => $settings->get('contact_instagram')->value ?? null,
                    'contact_phone'     => $settings->get('contact_phone')->value ?? null,
                    'contact_facebook'  => $settings->get('contact_facebook')->value ?? null, // <-- DITAMBAHKAN
                    'contact_youtube'   => $settings->get('contact_youtube')->value ?? null,  // <-- DITAMBAHKAN
                ];

                // Bagikan kedua variabel ke semua view yang di-render.
                View::share('weeklyVerse', $weeklyVerse);
                View::share('contactSettings', $contactSettings);
            }
        } catch (Exception $e) {
            // Jika terjadi error (misal, koneksi database gagal),
            // kita bagikan nilai default agar aplikasi tidak crash.
            View::share('weeklyVerse', null);
            View::share('contactSettings', []);
            // Anda juga bisa menambahkan log error di sini jika perlu:
            // Log::error("Could not load settings from database: " . $e->getMessage());
        }
    }
}

