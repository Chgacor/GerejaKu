<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Devotional;
use App\Models\User; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class DevotionalController extends Controller
{
    public function index(Request $request)
    {
        $query = Devotional::query();

        // Logika Search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('scripture_reference', 'like', '%' . $request->search . '%');
        }

        $devotionals = $query->latest()->paginate(10);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'scripture_reference' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('devotionals', 'public');
            $data['image'] = $path;
        }

        $devotional = Devotional::create($data);

        // PERBAIKAN DI SINI:
        // Kirim notifikasi ke User (yang punya trait Notifiable), bukan ke Jemaat.
        // Kita ambil semua User yang memiliki data profil Jemaat.
        $users = User::whereHas('jemaat')->get();

        Notification::send(
            $users,
            new \App\Notifications\NewContentNotification(
                'Renungan Baru: ' . $devotional->title,
                'Renungan terbaru telah ditambahkan: ' . $devotional->title . '. Baca sekarang!',
                route('devotionals.show', $devotional->id),
                'devotional'
            )
        );

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'scripture_reference' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($devotional->image && Storage::exists('public/' . $devotional->image)) {
                Storage::delete('public/' . $devotional->image);
            }
            $path = $request->file('image')->store('devotionals', 'public');
            $data['image'] = $path;
        }

        $devotional->update($data);

        return redirect()->route('admin.devotionals.index')->with('success', 'Renungan berhasil diperbarui.');
    }

    public function destroy(Devotional $devotional)
    {
        if ($devotional->image && Storage::exists('public/' . $devotional->image)) {
            Storage::delete('public/' . $devotional->image);
        }
        $devotional->delete();
        return redirect()->route('admin.devotionals.index')->with('success', 'Renungan berhasil dihapus.');
    }
}
