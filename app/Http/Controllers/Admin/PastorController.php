<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pastor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PastorController extends Controller
{
    public function index()
    {
        $pastors = Pastor::latest()->get();
        return view('admin.pastors.index', compact('pastors'));
    }

    public function create()
    {
        return view('admin.pastors.create', ['pastor' => new Pastor()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pastors', 'public');
        }

        Pastor::create($data);
        return redirect()->route('admin.pastors.index')->with('success', 'Profil berhasil dibuat.');
    }

    public function edit(Pastor $pastor)
    {
        return view('admin.pastors.edit', compact('pastor'));
    }

    public function update(Request $request, Pastor $pastor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($pastor->photo && Storage::exists('public/' . $pastor->photo)) {
                Storage::delete('public/' . $pastor->photo);
            }
            $data['photo'] = $request->file('photo')->store('pastors', 'public');
        }

        $pastor->update($data);
        return redirect()->route('admin.pastors.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(Pastor $pastor)
    {
        if ($pastor->photo && Storage::exists('public/' . $pastor->photo)) {
            Storage::delete('public/' . $pastor->photo);
        }
        $pastor->delete();
        return redirect()->route('admin.pastors.index')->with('success', 'Profil berhasil dihapus.');
    }
}
