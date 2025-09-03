<?php
// Lokasi: app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Penting! Tambahkan ini
use Illuminate\Support\Facades\Hash; // Penting! Tambahkan ini

class LoginController extends Controller
{
    // Menampilkan halaman form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses upaya login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $adminUsername = 'admin';
        $adminPasswordHash = '$2y$12$S1PjRMaGcfWPtfJzTp0uBOH1fnMecZ1CyzZ1tiPQEKXkJkhypRbO6';

        if ($request->username === $adminUsername && Hash::check($request->password, $adminPasswordHash)) {

            $user = User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'admin',
                    'password' => $adminPasswordHash,
                ]
            );

            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/jemaat');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
