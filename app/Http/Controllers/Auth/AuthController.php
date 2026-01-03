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
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,name|alpha_dash',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $user = new User();
            $user->name = $request->username;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'user';
            $user->is_active = false;
            $user->save();

            Jemaat::create([
                'user_id'   => $user->id,
                'full_name' => $request->full_name,
            ]);

        });

        return redirect('/login')->with('success', 'Registrasi berhasil! Mohon tunggu verifikasi admin (maksimal 1 minggu).');
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

        // Attempt login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            // Check if verified
            if (!$user->is_active && $user->role !== 'admin') { // Super admin exception just in case
                Auth::logout();
                $request->session()->invalidate();
                return back()->withErrors(['username' => 'Akun Anda belum diverifikasi oleh Admin.']);
            }

            $request->session()->regenerate();

            if (in_array($user->role, ['admin', 'passenger', 'super_admin'])) {
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
