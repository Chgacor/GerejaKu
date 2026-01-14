<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Method utama untuk view kalender
    public function index()
    {
        return view('events.index');
    }

    // Method API JSON untuk FullCalendar
    public function json(Request $request)
    {
        $events = Event::all();

        $formattedEvents = $events->map(function ($event) {
            // 1. Tentukan Warna Background (Custom atau Default Biru)
            $bgColor = $event->is_featured ? ($event->color ?? '#3B82F6') : '#3788d8';

            // 2. Tentukan Warna Tulisan Otomatis (Hitam/Putih) berdasarkan Background
            $textColor = $this->getContrastColor($bgColor);

            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_time->toIso8601String(),
                'end' => $event->end_time->toIso8601String(),

                // Kirim warna ke FullCalendar
                'backgroundColor' => $bgColor,
                'borderColor' => $bgColor,
                'textColor' => $textColor, // <--- INI HASIL LOGIKA OTOMATIS

                // Data tambahan
                'extendedProps' => [
                    'description' => $event->description,
                    'type' => $event->type,
                    'speaker' => $event->speaker,
                    'is_featured' => $event->is_featured
                ]
            ];
        });

        return response()->json($formattedEvents);
    }

    /**
     * Helper Function: Menghitung warna teks (Hitam/Putih)
     * berdasarkan kecerahan warna background (HEX).
     */
    private function getContrastColor($hexColor)
    {
        // Hapus tanda '#' jika ada
        $hex = str_replace('#', '', $hexColor);

        // Pastikan format hex valid (6 digit)
        if (strlen($hex) == 3) {
            $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
        }

        // Ambil nilai RGB (Red, Green, Blue)
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Rumus Luminance (Kecerahan) standar W3C
        // (R * 299 + G * 587 + B * 114) / 1000
        $brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        // Jika kecerahan > 128 (Terang), maka teks Hitam (#000000)
        // Jika kecerahan <= 128 (Gelap), maka teks Putih (#ffffff)
        return $brightness > 128 ? '#000000' : '#ffffff';
    }
}
