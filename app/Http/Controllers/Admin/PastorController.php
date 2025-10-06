<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission; // PENTING: Import model Commission
use App\Models\Pastor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PastorController extends Controller
{
    /**
     * Menampilkan daftar semua profil pelayan.
     */
    public function index()
    {
        // Mengurutkan berdasarkan data terbaru lebih cocok untuk halaman admin.
        $pastors = Pastor::latest()->paginate(15);
        return view('admin.pastors.index', compact('pastors'));
    }

    /**
     * Menampilkan form untuk membuat profil baru.
     */
    public function create()
    {
        // Ambil semua data komisi untuk ditampilkan di dropdown.
        $commissions = Commission::orderBy('name')->get();

        // Kirim data komisi dan instance Pastor baru ke view.
        return view('admin.pastors.create', [
            'pastor' => new Pastor(),
            'commissions' => $commissions,
        ]);
    }

    /**
     * Menyimpan profil baru ke database.
     */
    public function store(Request $request)
    {
        // VALIDASI: Menambahkan 'kelompok' dan 'commission_id'.
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'kelompok' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'commission_id' => 'nullable|exists:commissions,id', // 'exists' memastikan ID komisi valid.
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pastors', 'public');
        }

        Pastor::create($data);

        return redirect()->route('admin.pastors.index')->with('success', 'Profil baru berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit profil yang ada.
     */
    public function edit(Pastor $pastor)
    {
        // Ambil semua data komisi untuk ditampilkan di dropdown.
        $commissions = Commission::orderBy('name')->get();

        // Kirim data profil yang akan diedit dan daftar komisi ke view.
        return view('admin.pastors.edit', compact('pastor', 'commissions'));
    }

    /**
     * Memperbarui profil di database.
     */
    public function update(Request $request, Pastor $pastor)
    {
        // VALIDASI: Menambahkan 'kelompok' dan 'commission_id'.
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'kelompok' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'commission_id' => 'nullable|exists:commissions,id',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada.
            if ($pastor->photo && Storage::disk('public')->exists($pastor->photo)) {
                Storage::disk('public')->delete($pastor->photo);
            }
            $data['photo'] = $request->file('photo')->store('pastors', 'public');
        }

        $pastor->update($data);

        return redirect()->route('admin.pastors.index')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Menghapus profil dari database.
     */
    public function destroy(Pastor $pastor)
    {
        // Hapus foto dari storage jika ada.
        if ($pastor->photo && Storage::disk('public')->exists($pastor->photo)) {
            Storage::disk('public')->delete($pastor->photo);
        }

        $pastor->delete();

        return redirect()->route('admin.pastors.index')->with('success', 'Profil berhasil dihapus.');
    }
}
