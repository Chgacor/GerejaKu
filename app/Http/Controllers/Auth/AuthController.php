<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Jemaat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- REGISTRASI ---
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:jemaats',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $jemaat = Jemaat::create($request->all());

        Auth::login($jemaat);

        return redirect('/');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'username' => 'required|string', // atau 'email' jika Anda menggunakan email
            'password' => 'required',
        ]);

        $credentials = [
            'nama_lengkap' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/jemaat');
            }

            // Jika bukan admin, arahkan ke halaman utama
            return redirect()->intended('/');
        }

        // Jika login gagal
        return back()->withErrors([
            'username' => 'Nama Lengkap atau Password salah.',
        ])->onlyInput('username');
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
