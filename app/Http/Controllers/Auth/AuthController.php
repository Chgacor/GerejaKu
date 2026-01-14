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
    // --- REGISTER ---
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:50|unique:users,username|alpha_dash',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat User Login
            $user = User::create([
                'name' => $request->full_name, // Simpan Nama Lengkap di kolom 'name'
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
                'is_approved' => false, // Default: Pending
            ]);

            // 2. Buat Data Jemaat (Terhubung)
            Jemaat::create([
                'user_id'   => $user->id,
                'full_name' => $request->full_name,
            ]);
        });

        return redirect('/login')->with('success', 'Registrasi berhasil! Mohon tunggu persetujuan Admin sebelum login.');
    }

    // --- LOGIN FLEKSIBEL ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Ubah validasi: bukan 'email', tapi 'login_id'
        $request->validate([
            'login_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $input = $request->login_id;
        $password = $request->password;

        // LOGIKA PENCARIAN USER (Email OR Username OR Name)
        $user = User::where('email', $input)
            ->orWhere('username', $input)
            ->orWhere('name', $input)
            ->first();

        // Cek Password & User Ditemukan
        if ($user && Hash::check($password, $user->password)) {

            // 1. Cek Apakah Sudah Disetujui Admin?
            if ($user->is_approved == 0) {
                return back()->with('error', 'Akun Anda sedang dalam antrean verifikasi Admin. Silakan tunggu atau hubungi sekretariat.');
            }

            // 2. Login Sukses
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();

            // Redirect sesuai Role
            if ($user->role === 'user') {
                return redirect()->intended('/');
            }
            return redirect()->intended('/admin');
        }

        // Jika Gagal
        return back()->with('error', 'Login gagal. Periksa kembali Username/Email dan Password Anda.');
    }

    // --- FORGOT PASSWORD REQUEST ---
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetRequest(Request $request)
    {
        $request->validate(['login_id' => 'required']);
        $input = $request->login_id;

        // Cari User
        $user = User::where('email', $input)
            ->orWhere('username', $input)
            ->orWhere('name', $input)
            ->first();

        if ($user) {
            // Tandai request reset di database
            $user->update(['password_reset_requested_at' => now()]);

            return back()->with('success', "Permintaan reset password untuk '{$user->name}' telah dikirim. Admin akan meresetnya segera.");
        }

        return back()->withErrors(['login_id' => 'User tidak ditemukan.']);
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
