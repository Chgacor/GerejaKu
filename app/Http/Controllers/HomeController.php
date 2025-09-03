<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function about()
    {
        $historySetting = Setting::where('key', 'church_history')->first();
        $imageSetting = Setting::where('key', 'about_image')->first(); // Ambil setting gambar

        $history = $historySetting->value ?? 'Konten belum tersedia.';
        $aboutImage = $imageSetting->value ?? null; // Dapatkan path gambar atau null

        return view('about', compact('history', 'aboutImage')); // Kirimkan keduanya
    }
}
