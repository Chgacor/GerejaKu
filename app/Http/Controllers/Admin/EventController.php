<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Di AdminEventController.php
    public function index(Request $request)
    {
        $query = \App\Models\Event::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest('start_time')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create() {
        $divisions = Division::all();
        return view('admin.events.create', ['event' => new Event(), 'divisions' => $divisions]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'description' => 'nullable|string',
            'speaker' => 'nullable|string',
            'division_id' => 'nullable|exists:divisions,id',
            'image' => 'nullable|image|max:2048',

            // Validasi untuk Pin & Warna
            'is_featured' => 'nullable|boolean',
            'color' => 'nullable|string|max:7',
        ]);

        // Handle Upload Gambar
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        // Set default jika checkbox tidak dicentang (karena HTML checkbox tidak kirim value kalau false)
        $data['is_featured'] = $request->has('is_featured') ? 1 : 0;

        // Simpan
        \App\Models\Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil ditambahkan!');
    }

    public function update(Request $request, \App\Models\Event $event)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'description' => 'nullable|string',
            'speaker' => 'nullable|string',
            'division_id' => 'nullable|exists:divisions,id',
            'image' => 'nullable|image|max:2048',

            // Validasi Pin & Warna
            'is_featured' => 'nullable|boolean',
            'color' => 'nullable|string|max:7',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($event->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        // Handle Checkbox Update
        // Trik: Checkbox HTML kalau uncheck gak kirim data, jadi kita paksa set 0 kalau gak ada di request
        $data['is_featured'] = $request->input('is_featured', 0);

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil diperbarui!');
    }
    public function edit(Event $event) {
        $divisions = Division::all();
        return view('admin.events.edit', compact('event', 'divisions'));
    }
    public function destroy(Event $event) {
        if ($event->image && Storage::exists('public/' . $event->image)) {
            Storage::delete('public/' . $event->image);
        }
        // Hapus juga galeri jika ada
        if ($event->documentation_gallery) {
            foreach ($event->documentation_gallery as $imagePath) {
                Storage::delete('public/' . $imagePath);
            }
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
    private function validateAndPrepareData(Request $request, ?Event $event = null): array {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'speaker' => 'nullable|string|max:255',
            'division_id' => 'nullable|exists:divisions,id',
            'type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_featured' => 'nullable',
            'color' => 'nullable|string|max:7',
        ]);
        if ($request->hasFile('image')) {
            if ($event && $event->image && Storage::exists('public/' . $event->image)) {
                Storage::delete('public/' . $event->image);
            }
            $data['image'] = $request->file('image')->store('events/flyers', 'public');
        }
        $data['is_featured'] = $request->has('is_featured');
        return $data;
    }

    public function json()
    {
        $events = \App\Models\Event::all();

        $mappedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_time->toIso8601String(),
                'end' => $event->end_time->toIso8601String(),
                'description' => $event->description,

                // INI KUNCINYA: Kirim warna ke FullCalendar
                'backgroundColor' => $event->is_featured ? ($event->color ?? '#3B82F6') : '#3788d8', // Warna custom jika dipin, default biru jika tidak
                'borderColor' => $event->is_featured ? ($event->color ?? '#3B82F6') : '#3788d8',

                // Tambahan data untuk logika di JS
                'extendedProps' => [
                    'description' => $event->description,
                    'is_featured' => $event->is_featured
                ]
            ];
        });

        return response()->json($mappedEvents);
    }
}
