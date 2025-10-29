<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\CommissionArticle;
use App\Models\Jemaat;
use App\Models\Pastor;
use App\Models\Qna;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slide;
use App\Notifications\NewQuestionSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

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

        $publishedQnas = Qna::where('is_published', true)
            ->latest('answered_at')
            ->take(5)
            ->get();

        return view('home', compact('slides', 'upcomingServices', 'artikelTerbaru', 'publishedQnas'));
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

    public function storeQna(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'question' => 'required|string|max:5000',
        ]);

        $qna = Qna::create($validatedData);

        // Kirim notifikasi email ke semua admin
        $admins = Jemaat::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewQuestionSubmitted($qna));
        }

        // Kembali ke halaman utama dengan pesan sukses
        return redirect('/#qna-section')->with('success_qna', 'Pertanyaan Anda telah berhasil terkirim. Terima kasih!');
    }
}
