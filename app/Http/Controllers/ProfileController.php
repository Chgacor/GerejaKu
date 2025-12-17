<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        // Ambil user beserta data jemaat-nya
        $user = $request->user()->load('jemaat');
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validasi
        $request->validate([
            // Data Akun
            'username' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,

            // Data Profil (Bahasa Inggris sesuai database baru)
            'full_name'    => 'required|string|max:255',
            'gender'       => 'required|in:Laki-laki,Perempuan',
            'birth_place'  => 'required|string|max:255',
            'birth_date'   => 'required|date',
            'address'      => 'required|string',
            'phone_number' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::transaction(function () use ($request, $user) {
            // A. Update Tabel Users (Akun)
            $user->update([
                'name'  => $request->username,
                'email' => $request->email,
            ]);

            // B. Siapkan Data Jemaat (Profil)
            $jemaatData = $request->only([
                'full_name', 'gender', 'birth_place',
                'birth_date', 'address', 'phone_number'
            ]);

            // Handle Foto Profil
            if ($request->hasFile('profile_picture')) {
                // Hapus foto lama jika ada
                if ($user->jemaat && $user->jemaat->profile_picture) {
                    if (Storage::disk('public')->exists($user->jemaat->profile_picture)) {
                        Storage::disk('public')->delete($user->jemaat->profile_picture);
                    }
                }
                $jemaatData['profile_picture'] = $request->file('profile_picture')->store('foto-profil', 'public');
            }

            // C. Update atau Create data Jemaat
            // updateOrCreate akan mencari jemaat berdasarkan user_id, jika ada diupdate, jika tidak dibuat baru
            $user->jemaat()->updateOrCreate(
                ['user_id' => $user->id],
                $jemaatData
            );
        });

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
