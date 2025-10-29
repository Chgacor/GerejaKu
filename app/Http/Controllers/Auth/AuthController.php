<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Jemaat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan form registrasi.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi user baru.
     */
    public function register(Request $request)
    {
        // 1. VALIDASI DIPERBARUI: Menambahkan validasi untuk 'username'.
        // Aturan 'alpha_dash' memastikan username hanya berisi huruf, angka, strip (-), dan underscore (_).
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:jemaats|alpha_dash',
            'email' => 'required|string|email|max:255|unique:jemaats',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. PROSES CREATE DIPERBARUI: Secara eksplisit membuat user dengan data yang benar.
        // Ini lebih aman dan jelas daripada menggunakan $request->all().
        $jemaat = Jemaat::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password, // Password akan di-hash otomatis oleh Model Jemaat
        ]);

        // 3. Login user yang baru dibuat
        Auth::login($jemaat);

        return redirect('/');
    }

    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Memproses upaya login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Kredensial login sudah benar menggunakan 'username'.
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/jemaat');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->onlyInput('username');
    }

    /**
     * Memproses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

