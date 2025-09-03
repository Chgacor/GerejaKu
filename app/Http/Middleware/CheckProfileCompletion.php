<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user sudah login DAN no_telepon MASIH KOSONG
        if (Auth::check() && is_null(Auth::user()->no_telepon)) {

            // JANGAN redirect jika user SUDAH berada di halaman edit profil
            if (!$request->routeIs('profile.edit') && !$request->routeIs('profile.update')) {

                // INILAH YANG TERJADI:
                // Sistem mengalihkan ke halaman 'profile.edit' dengan pesan peringatan.
                return redirect()->route('profile.edit')->with('warning', 'Harap lengkapi profil Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
