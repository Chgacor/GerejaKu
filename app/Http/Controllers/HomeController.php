<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Slide;
use App\Models\Service;
use App\Models\Pastor;
use App\Models\CommissionArticle;
use App\Models\Commission;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (home).
     */
    public function index()
    {
        $slides = Slide::where('is_active', true)->orderBy('order')->get();

        $upcomingServices = Service::where('service_time', '>=', now())
            ->orderBy('service_time', 'asc')
            ->take(10)
            ->get();

        $artikelTerbaru = CommissionArticle::with('commission')
            ->whereNotNull('published_at') // <--- INI KUNCINYA
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('home', compact('slides', 'upcomingServices', 'artikelTerbaru'));
    }

    /**
     * Menampilkan halaman "Tentang Kami".
     */
    public function about()
    {
        $keys = ['church_history', 'church_vision', 'church_mission', 'about_image'];
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key');
        return view('about', compact('settings'));
    }

    /**
     * Menampilkan halaman profil gabungan.
     */
    public function pastors()
    {
        $allProfiles = Pastor::with('commission')->orderBy('kelompok')->orderBy('name')->get();
        $groupedProfiles = $allProfiles->groupBy('kelompok');
        return view('pastors.index', compact('groupedProfiles'));
    }
}
