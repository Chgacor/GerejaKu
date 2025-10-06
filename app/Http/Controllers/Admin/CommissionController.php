<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission; // Pastikan model Commission sudah di-import
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CommissionController extends Controller
{
    /**
     * Menampilkan daftar semua komisi.
     */
    public function index()
    {
        $commissions = Commission::latest()->paginate(10);
        return view('admin.commissions.index', compact('commissions'));
    }

    /**
     * Menampilkan form untuk membuat komisi baru.
     */
    public function create()
    {
        // Kirim instance Commission yang baru dan kosong ke view
        return view('admin.commissions.create', [
            'commission' => new \App\Models\Commission()
        ]);
    }

    /**
     * Menyimpan komisi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:commissions',
            'head_of_commission' => 'nullable|string|max:255',
            'head_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'purpose' => 'nullable|string',
            'management_structure' => 'nullable|string',
        ]);

        $data = $request->except('head_photo');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('head_photo')) {
            $path = $request->file('head_photo')->store('commissions', 'public');
            $data['head_photo'] = $path;
        }

        Commission::create($data);

        return redirect()->route('admin.commissions.index')->with('success', 'Komisi baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit komisi.
     */
    public function edit(Commission $commission)
    {
        return view('admin.commissions.edit', compact('commission'));
    }

    /**
     * Memperbarui data komisi di database.
     */
    public function update(Request $request, Commission $commission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:commissions,name,' . $commission->id,
            'head_of_commission' => 'nullable|string|max:255',
            'head_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'purpose' => 'nullable|string',
            'management_structure' => 'nullable|string',
        ]);

        $data = $request->except('head_photo');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('head_photo')) {
            if ($commission->head_photo && Storage::disk('public')->exists($commission->head_photo)) {
                Storage::disk('public')->delete($commission->head_photo);
            }
            $path = $request->file('head_photo')->store('commissions', 'public');
            $data['head_photo'] = $path;
        }

        $commission->update($data);

        return redirect()->route('admin.commissions.index')->with('success', 'Data komisi berhasil diperbarui.');
    }

    /**
     * Menghapus komisi dari database.
     */
    public function destroy(Commission $commission)
    {
        if ($commission->head_photo && Storage::disk('public')->exists($commission->head_photo)) {
            Storage::disk('public')->delete($commission->head_photo);
        }

        $commission->delete();
        return redirect()->route('admin.commissions.index')->with('success', 'Data komisi berhasil dihapus.');
    }
}
