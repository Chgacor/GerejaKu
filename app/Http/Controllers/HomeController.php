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
use Illuminate\Support\Facades\Auth; 
use App\Models\User;

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
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();

        $publishedQnas = Qna::where('is_published', true)
            ->latest('answered_at')
            ->take(3)
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
            'subject' => 'required|string|max:255',
            'question' => 'required|string',
        ]);

        $user = Auth::user();

        $jemaat = $user->jemaat;
        $userPhone = $jemaat ? $jemaat->no_hp : null;

        // 4. Simpan ke Database
        $qna = Qna::create([
            'user_id'  => $user->id,
            'name'     => $user->name,
            'email'    => $user->email,
            'phone'    => $userPhone,
            'subject'  => $validatedData['subject'],
            'question' => $validatedData['question'],
        ]);

        $admins = User::where('role', 'admin')->get();

        if ($admins->count() > 0) {
            Notification::send($admins, new NewQuestionSubmitted($qna));
        }

        return redirect()->back()->with('success_qna', 'Pertanyaan Anda telah terkirim! Admin akan membalas secepatnya.');
    }

    public function showQnaArchive(Request $request)
    {
        $allQna = Qna::where('is_published', true)
            ->whereNotNull('answer')
            ->latest('answered_at')
            ->paginate(10);

        return view('qna_archive', compact('allQna'));
    }
}
