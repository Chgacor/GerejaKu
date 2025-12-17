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
    /**
     * Menampilkan daftar jemaat dalam bentuk tabel.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kelamin = $request->input('kelamin');

        // Menggunakan 'with' untuk eager loading relasi user agar lebih efisien
        $query = Jemaat::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('no_telepon', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    // Pencarian ke tabel users (untuk email atau username)
                    ->orWhereHas('user', function ($qUser) use ($search) {
                        $qUser->where('email', 'like', '%' . $search . '%')
                            ->orWhere('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($kelamin && $kelamin !== 'semua') {
            $query->where('kelamin', $kelamin);
        }

        $jemaats = $query->latest()->paginate(10);

        return view('jemaat.index', compact('jemaats'));
    }

    /**
     * Menampilkan daftar jemaat dalam bentuk kartu (Grid View).
     */
    public function cardView(Request $request)
    {
        $search = $request->input('search');
        $kelamin = $request->input('kelamin');

        $query = Jemaat::with('user');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($qUser) use ($search) {
                        $qUser->where('email', 'like', '%' . $search . '%')
                            ->orWhere('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($kelamin && $kelamin !== 'semua') {
            $query->where('kelamin', $kelamin);
        }

        $jemaats = $query->latest()->paginate(9);

        return view('jemaat.cards', compact('jemaats'));
    }

    /**
     * Menampilkan form untuk menambah jemaat baru.
     */
    public function create()
    {
        return view('jemaat.create');
    }

    /**
     * Menyimpan data jemaat baru beserta akun loginnya.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (Gabungan User & Jemaat)
        $request->validate([
            // Data Akun (Tabel Users)
            'username'      => 'required|string|max:255|unique:users,name',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8', // Password wajib saat create

            // Data Profil (Tabel Jemaats)
            'nama_lengkap'  => 'required|string|max:255',
            'kelamin'       => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'no_telepon'    => 'required|string|max:20',
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Database Transaction: Simpan User & Jemaat sekaligus
        DB::transaction(function () use ($request) {
            // A. Buat User Baru
            $user = User::create([
                'name'     => $request->username, // Kolom 'name' di user kita pakai untuk username
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                // Jika ada kolom role di tabel users, tambahkan di sini: 'role' => 'user'
            ]);

            // B. Siapkan Data Jemaat
            $jemaatData = $request->only([
                'nama_lengkap',
                'kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'no_telepon'
            ]);

            // Hubungkan Jemaat dengan User yang baru dibuat
            $jemaatData['user_id'] = $user->id;

            // C. Upload Foto Jika Ada
            if ($request->hasFile('foto_profil')) {
                $jemaatData['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
            }

            // D. Simpan Jemaat
            Jemaat::create($jemaatData);
        });

        return redirect()->route('admin.jemaat.index')->with('success', 'Data jemaat dan akun pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data jemaat.
     */
    public function show(Jemaat $jemaat)
    {
        // Pastikan load relasi user untuk ditampilkan detailnya
        $jemaat->load('user');
        return view('jemaat.show', compact('jemaat'));
    }

    /**
     * Menampilkan form edit data jemaat.
     */
    public function edit(Jemaat $jemaat)
    {
        return view('jemaat.edit', compact('jemaat'));
    }

    /**
     * Memperbarui data jemaat dan akun pengguna.
     */
    public function update(Request $request, Jemaat $jemaat)
    {
        // 1. Validasi Input
        $request->validate([
            // Data Akun (User) - validasi unique ignore ID user terkait
            'username'      => 'required|string|max:255|unique:users,name,' . $jemaat->user_id,
            'email'         => 'required|email|unique:users,email,' . $jemaat->user_id,
            'password'      => 'nullable|string|min:8', // Password nullable saat edit (hanya diisi jika ingin ganti)

            // Data Profil (Jemaat)
            'nama_lengkap'  => 'required|string|max:255',
            'kelamin'       => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'no_telepon'    => 'required|string|max:20',
            'foto_profil'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Database Transaction
        DB::transaction(function () use ($request, $jemaat) {

            // A. Update Data Jemaat
            $jemaatData = $request->only([
                'nama_lengkap',
                'kelamin',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'no_telepon'
            ]);

            // Handle Foto Profil
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($jemaat->foto_profil && Storage::disk('public')->exists($jemaat->foto_profil)) {
                    Storage::disk('public')->delete($jemaat->foto_profil);
                }
                // Upload foto baru
                $jemaatData['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
            }

            $jemaat->update($jemaatData);

            // B. Update Data User (Akun Login)
            $user = $jemaat->user; // Ambil user terkait
            if ($user) {
                $userData = [
                    'name'  => $request->username,
                    'email' => $request->email,
                ];

                // Hanya update password jika input tidak kosong
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                $user->update($userData);
            }
        });

        return redirect()->route('admin.jemaat.index')->with('success', 'Data jemaat dan akun berhasil diperbarui.');
    }

    /**
     * Menghapus data jemaat dan akun terkait.
     */
    public function destroy(Jemaat $jemaat)
    {
        DB::transaction(function () use ($jemaat) {
            // 1. Hapus Foto Fisik
            if ($jemaat->foto_profil && Storage::disk('public')->exists($jemaat->foto_profil)) {
                Storage::disk('public')->delete($jemaat->foto_profil);
            }

            // 2. Hapus User (Otomatis menghapus Jemaat via constraint database on delete cascade)
            // Jika constraint belum diset, kita hapus manual dua-duanya.
            if ($jemaat->user) {
                $jemaat->user->delete();
            } else {
                // Fallback jika tidak ada user terkait (data lama/error)
                $jemaat->delete();
            }
        });

        return redirect()->route('admin.jemaat.index')->with('success', 'Data jemaat berhasil dihapus.');
    }
}
