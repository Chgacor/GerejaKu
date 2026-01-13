<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserVerificationController extends Controller
{
    public function index()
    {
        // Ambil SEMUA user (kecuali diri sendiri), urutkan yang pending di atas
        $users = User::where('id', '!=', auth()->id())
            ->orderBy('is_approved', 'asc') // Yang 0 (pending) di atas
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.verifications.index', compact('users'));
    }

    // Mengubah Status (Aktif <-> Nonaktif)
    public function toggleStatus(User $user)
    {
        $newState = !$user->is_approved;
        $user->update(['is_approved' => $newState]);

        $statusText = $newState ? 'DIAKTIFKAN' : 'DINONAKTIFKAN';
        $msgType = $newState ? 'success' : 'warning'; // Hijau jika aktif, Kuning jika nonaktif

        return redirect()->back()->with($msgType, "Akun {$user->name} berhasil {$statusText}!");
    }

    public function approvePasswordReset(User $user)
    {
        // 1. Cek Relasi: Apakah User ini punya data Jemaat?
        if (!$user->jemaat) {
            // JIKA TIDAK ADA DATA JEMAAT
            return redirect()->back()->with('error', "Gagal! User {$user->name} tidak terhubung dengan data Jemaat manapun. Password tidak direset.");
        }

        // 2. Cek Tanggal Lahir
        if (empty($user->jemaat->tanggal_lahir)) {
            // JIKA ADA DATA JEMAAT, TAPI TANGGAL LAHIR KOSONG
            $default = '01012000';
            $newPassword = 'gkkbserdam' . $default;

            $user->update(['password' => Hash::make($newPassword)]);

            return redirect()->back()->with('warning', "User punya data Jemaat tapi Tanggal Lahir KOSONG. Password direset ke default: {$newPassword}");
        }

        // 3. JIKA SEMUA DATA LENGKAP
        try {
            $tglLahir = Carbon::parse($user->jemaat->tanggal_lahir)->format('dmY');
            $newPassword = 'gkkbserdam' . $tglLahir;

            $user->update(['password' => Hash::make($newPassword)]);

            return redirect()->back()->with('success', "Password {$user->name} berhasil direset menjadi: {$newPassword}");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Terjadi kesalahan format tanggal: " . $e->getMessage());
        }
    }
}
