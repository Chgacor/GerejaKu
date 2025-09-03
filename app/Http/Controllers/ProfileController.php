<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan form edit profil
    public function edit()
    {
        // Kirim data user yang sedang login ke view
        return view('profile.edit', ['jemaat' => Auth::user()]);
    }

    // Menyimpan perubahan profil
    public function update(Request $request)
    {
        $jemaat = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'no_telepon' => 'required',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto_profil'); // Ambil semua data kecuali foto

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($jemaat->foto_profil && file_exists(storage_path('app/public/' . $jemaat->foto_profil))) {
                \Storage::delete('public/'.$jemaat->foto_profil);
            }
            $path = $request->file('foto_profil')->store('foto-profil', 'public');
            $data['foto_profil'] = $path;
        }

        $jemaat->update($data);

        $jemaat->refresh();

        return redirect('/')->with('success', 'Profil berhasil diperbarui!');
    }
}
