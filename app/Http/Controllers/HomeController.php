<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Slide;
use App\Models\Service;
use App\Models\Pastor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('is_active', true)->orderBy('order')->get();

        $upcomingServices = Service::where('service_time', '>=', now())
            ->orderBy('service_time', 'asc')
            ->take(10)
            ->get();

        return view('home', compact('slides', 'upcomingServices'));
    }
    public function about()
    {
        $keys = ['church_history', 'church_vision', 'church_mission', 'about_image'];
        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key');

        return view('about', compact('settings'));
    }

    public function pastors()
    {
        $pastors = Pastor::orderBy('id')->get();
        return view('pastors.index', compact('pastors'));
    }


}
