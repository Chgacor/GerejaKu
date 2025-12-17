<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Jemaat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi
        $request->validate([
            // Ubah nama_lengkap jadi full_name agar sesuai form view
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,name|alpha_dash',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request) {

            // A. Buat Akun Login (Users)
            $user = User::create([
                'name'     => $request->username,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'user',
            ]);

            // B. Buat Profil (Jemaats) dengan nama kolom bahasa Inggris
            Jemaat::create([
                'user_id'   => $user->id,
                'full_name' => $request->full_name, // Mapping ke kolom full_name
            ]);

            Auth::login($user);
        });

        return redirect('/')->with('success', 'Registrasi berhasil!');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = [
            'name'     => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
