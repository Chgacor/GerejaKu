<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Menampilkan halaman kalender
    public function index()
    {
        return view('events.index');
    }

    // Menyediakan data acara dalam format JSON
    public function json()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'title' => $event->title,
                'start' => $event->start_time->toIso8601String(),
                'end' => $event->end_time->toIso8601String(),
                'description' => $event->description, // Kirim deskripsi juga
            ];
        });
        return response()->json($events);
    }
}
