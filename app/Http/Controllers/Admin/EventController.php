<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Division; // Import Division
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('division')->orderBy('start_time', 'desc')->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('admin.events.create', [
            'event' => new Event(),
            'divisions' => $divisions
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }
        Event::create($data);
        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil dibuat.');
    }

    public function edit(Event $event)
    {
        $divisions = Division::all();
        return view('admin.events.edit', compact('event', 'divisions'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validateRequest($request);
        if ($request->hasFile('image')) {
            if ($event->image && Storage::exists('public/' . $event->image)) {
                Storage::delete('public/' . $event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }
        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->image && Storage::exists('public/' . $event->image)) {
            Storage::delete('public/' . $event->image);
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    // Fungsi bantuan untuk validasi
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'speaker' => 'nullable|string|max:255',
            'division_id' => 'nullable|exists:divisions,id',
            'type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_featured' => 'nullable|boolean',
            'color' => 'nullable|string|max:7', // cth: #FF0000
        ]);
    }
}
