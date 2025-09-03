<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Devotional;
use Illuminate\Http\Request;

class DevotionalController extends Controller
{
    public function index()
    {
        $devotionals = Devotional::latest()->paginate(9);
        return view('admin.devotionals.index', compact('devotionals'));
    }

    public function create()
    {
        return view('admin.devotionals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar
            'scripture_reference' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('devotionals', 'public');
            $data['image'] = $path;
        }

        Devotional::create($data);

        return redirect()->route('admin.devotionals.index')->with('success', 'Renungan berhasil dibuat.');
    }

    public function edit(Devotional $devotional)
    {
        return view('admin.devotionals.edit', compact('devotional'));
    }

    public function update(Request $request, Devotional $devotional)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar
            'scripture_reference' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($devotional->image && file_exists(storage_path('app/public/' . $devotional->image))) {
                \Storage::delete('public/' . $devotional->image);
            }
            $path = $request->file('image')->store('devotionals', 'public');
            $data['image'] = $path;
        }

        $devotional->update($data);

        return redirect()->route('admin.devotionals.index')->with('success', 'Renungan berhasil diperbarui.');
    }

    public function destroy(Devotional $devotional)
    {
        $devotional->delete();
        return redirect()->route('devotionals.index')->with('success', 'Renungan berhasil dihapus.');
    }
}
