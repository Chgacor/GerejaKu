<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('order')->get();
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        // Kita tidak perlu mengirim $nextOrder ke view karena akan diset otomatis saat store
        return view('admin.slides.create', ['slide' => new Slide()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'link_url' => 'nullable|url',
            // 'order' dihapus dari validasi karena otomatis
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->has('is_active');

        // LOGIKA OTOMATIS URUTAN: Ambil urutan tertinggi saat ini + 1
        $data['order'] = (Slide::max('order') ?? 0) + 1;

        $path = $request->file('image')->store('slides', 'public');
        $data['image'] = $path;

        Slide::create($data);

        return redirect()->route('admin.slides.index')->with('success', 'Slide berhasil dibuat.');
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'link_url' => 'nullable|url',
            'order' => 'required|integer', // Di update, user mungkin ingin mengubah urutan manual, jadi biarkan
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->except('image');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($slide->image && Storage::exists('public/' . $slide->image)) {
                Storage::delete('public/' . $slide->image);
            }
            $path = $request->file('image')->store('slides', 'public');
            $data['image'] = $path;
        }

        $slide->update($data);

        return redirect()->route('admin.slides.index')->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(Slide $slide)
    {
        if ($slide->image && Storage::exists('public/' . $slide->image)) {
            Storage::delete('public/' . $slide->image);
        }
        $slide->delete();
        return redirect()->route('admin.slides.index')->with('success', 'Slide berhasil dihapus.');
    }

    public function toggleStatus(Slide $slide)
    {
        $slide->is_active = !$slide->is_active;
        $slide->save();

        return redirect()->route('admin.slides.index')->with('success', 'Status slide berhasil diubah.');
    }
}
