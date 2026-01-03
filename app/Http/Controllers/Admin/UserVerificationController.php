<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserVerificationController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('is_active', false)->where('role', '!=', 'super_admin')->get();
        $passwordRequests = User::whereNotNull('password_reset_requested_at')->get();

        return view('admin.verifications.index', compact('pendingUsers', 'passwordRequests'));
    }

    public function approve(User $user)
    {
        $user->update(['is_active' => true]);
        // Ideally send an email here
        return back()->with('success', 'User verified!');
    }

    public function approvePasswordReset(User $user)
    {
        $tempPass = Str::random(10);
        $user->update([
            'password' => Hash::make($tempPass),
            'password_reset_requested_at' => null
        ]);

        return back()->with('success', "Password reset approved. New temporary password: $tempPass");
    }
}
