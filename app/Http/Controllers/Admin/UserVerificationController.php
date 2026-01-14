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
        // 1. Ambil List User Baru (Belum Approved)
        $pendingUsers = \App\Models\User::where('is_approved', 0)
            ->where('id', '!=', auth()->id()) // Safety
            ->latest()
            ->get();

        // 2. Ambil List User yang Minta Reset Password
        $resetRequests = \App\Models\User::whereNotNull('password_reset_requested_at')
            ->latest()
            ->get();

        return view('admin.verifications.index', compact('pendingUsers', 'resetRequests'));
    }

    public function toggleStatus(User $user)
    {
        $newState = !$user->is_approved;
        $user->update(['is_approved' => $newState]);

        $statusText = $newState ? 'DIAKTIFKAN' : 'DINONAKTIFKAN';
        $msgType = $newState ? 'success' : 'warning';

        return redirect()->back()->with($msgType, "Akun {$user->name} berhasil {$statusText}!");
    }

    public function approvePasswordReset(User $user)
    {
        // 1. Tentukan Password Baru (Berdasarkan Tanggal Lahir jika ada)
        if ($user->jemaat && $user->jemaat->birth_date) {
            $tglLahir = Carbon::parse($user->jemaat->birth_date)->format('dmY');
            $newPassword = 'gkkbserdam' . $tglLahir;
            $msgSuffix = "sesuai Tanggal Lahir ({$tglLahir})";
        } else {
            $newPassword = 'gkkbserdam01012000';
            $msgSuffix = "ke Default (01012000)";
        }

        // 2. Update Password & Hapus Flag Request
        $user->update([
            'password' => Hash::make($newPassword),
            'password_reset_requested_at' => null // Hilangkan dari list request
        ]);

        return redirect()->back()->with('success', "Password {$user->name} berhasil direset {$msgSuffix}. Request selesai.");
    }
}
