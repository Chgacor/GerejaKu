<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use Illuminate\Http\Request;

class JemaatController extends Controller
{
    // Menampilkan semua data dalam tabel
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kelamin = $request->input('kelamin');

        // Tambahkan ->where('role', 'user') di sini
        $query = Jemaat::query()->where('role', 'user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('no_telepon', 'like', '%' . $search . '%')
                    ->orWhere('kelamin', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }

        if ($kelamin && $kelamin !== 'semua') {
            $query->where('kelamin', $kelamin);
        }

        $jemaats = $query->latest()->paginate(10);

        return view('jemaat.index', compact('jemaats'));
    }

    // Ganti method cardView() Anda dengan ini
    public function cardView(Request $request)
    {
        $search = $request->input('search');
        $kelamin = $request->input('kelamin');

        // Tambahkan ->where('role', 'user') di sini juga
        $query = Jemaat::query()->where('role', 'user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    // ... (kondisi orWhere lainnya) ...
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }

        if ($kelamin && $kelamin !== 'semua') {
            $query->where('kelamin', $kelamin);
        }

        $jemaats = $query->latest()->paginate(9);

        return view('jemaat.cards', compact('jemaats'));
    }

    // Menampilkan form untuk menambah data baru
    public function create()
    {
        return view('jemaat.create');
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap',
            'kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'no_telepon',
            'foto_profil',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('foto-profil', 'public');
            $data['foto_profil'] = $path;
        }

        Jemaat::create($data);

        return redirect()->route('jemaat.index')->with('success', 'Data jemaat berhasil ditambahkan.');
    }


    public function edit(Jemaat $jemaat)
    {
        return view('jemaat.edit', compact('jemaat'));
    }

    public function update(Request $request, Jemaat $jemaat)
    {
        $request->validate([
            'nama_lengkap',
            'kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'no_telepon',
            'foto_profil',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($jemaat->foto_profil && file_exists(storage_path('app/public/' . $jemaat->foto_profil))) {
                \Storage::delete('public/'.$jemaat->foto_profil);
            }
            $path = $request->file('foto_profil')->store('foto-profil', 'public');
            $data['foto_profil'] = $path;
        }

        $jemaat->update($data);

        return redirect()->route('jemaat.index')->with('success', 'Data jemaat berhasil diperbarui.');
    }

    public function destroy(Jemaat $jemaat)
    {
        $jemaat->delete();

        return redirect()->route('jemaat.index')->with('success', 'Data jemaat berhasil dihapus.');
    }

    public function show(Jemaat $jemaat)
    {
        return view('jemaat.show', compact('jemaat'));
    }
}

