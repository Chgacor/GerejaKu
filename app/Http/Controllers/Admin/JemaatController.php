<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jemaat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class JemaatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kategori = $request->input('kategori');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Query dasar
        $query = Jemaat::with('user')->whereHas('user', function ($q) {
            $q->where('role', '!=', 'admin');
        });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('phone_number', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        $query->filterByKategori($kategori);

        $query->filterByBulan($bulan);

        $query->filterByTahun($tahun);

        $jemaats = $query->latest()->paginate(10);

        $jemaats->appends($request->all());

        return view('jemaat.index', compact('jemaats'));
    }

    public function cardView(Request $request)
    {
        $search = $request->input('search');

        $query = Jemaat::with('user')->whereHas('user', function ($q) {
            $q->where('role', '!=', 'admin');
        });

        if ($search) {
            $query->where('full_name', 'like', '%' . $search . '%');
        }

        $jemaats = $query->latest()->paginate(9);
        return view('jemaat.cards', compact('jemaats'));
    }

    public function create()
    {
        return view('jemaat.create');
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'username'      => 'required|string|max:255|unique:users,name',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8',
            'full_name'     => 'required|string|max:255',
            'gender'        => 'required',
            'birth_place'   => 'required',
            'birth_date'    => 'required|date',
            'address'       => 'required',
            'phone_number'  => 'required',
            'profile_picture' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat User Login
            $user = User::create([
                'name'     => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'user',
            ]);

            // 2. Buat Profil Jemaat
            $jemaatData = $request->only(['full_name', 'gender', 'birth_place', 'birth_date', 'address', 'phone_number']);
            $jemaatData['user_id'] = $user->id;

            if ($request->hasFile('profile_picture')) {
                $jemaatData['profile_picture'] = $request->file('profile_picture')->store('foto-profil', 'public');
            }

            Jemaat::create($jemaatData);
        });

        return redirect()->route('admin.jemaat.index')->with('success', 'Data jemaat berhasil ditambahkan.');
    }

    public function show(Jemaat $jemaat)
    {
        return view('jemaat.show', compact('jemaat'));
    }

    public function edit($id)
    {
        $jemaat = Jemaat::findOrFail($id);

        return view('jemaat.edit', compact('jemaat'));
    }

    public function update(Request $request, Jemaat $jemaat)
    {
        $request->validate([
            'username'      => 'required|string|unique:users,name,' . $jemaat->user_id,
            'email'         => 'required|email|unique:users,email,' . $jemaat->user_id,
            'full_name'     => 'required',
            // ... tambahkan validasi lain sesuai kebutuhan
        ]);

        DB::transaction(function () use ($request, $jemaat) {
            // Update User
            $userData = ['name' => $request->username, 'email' => $request->email];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $jemaat->user->update($userData);

            // Update Jemaat
            $jemaatData = $request->only(['full_name', 'gender', 'birth_place', 'birth_date', 'address', 'phone_number']);

            if ($request->hasFile('profile_picture')) {
                if ($jemaat->profile_picture && Storage::disk('public')->exists($jemaat->profile_picture)) {
                    Storage::disk('public')->delete($jemaat->profile_picture);
                }
                $jemaatData['profile_picture'] = $request->file('profile_picture')->store('foto-profil', 'public');
            }

            $jemaat->update($jemaatData);
        });

        return redirect()->route('admin.jemaat.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Jemaat $jemaat)
    {
        DB::transaction(function () use ($jemaat) {
            if ($jemaat->profile_picture) Storage::disk('public')->delete($jemaat->profile_picture);
            $jemaat->user->delete(); // Hapus user otomatis hapus jemaat (cascade)
        });
        return redirect()->route('admin.jemaat.index')->with('success', 'Data dihapus.');
    }
}
