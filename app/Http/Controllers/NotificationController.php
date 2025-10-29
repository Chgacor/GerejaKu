<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Fungsi untuk mengambil daftar notifikasi yang belum dibaca
    public function index()
    {
        return response()->json(auth()->user()->unreadNotifications);
    }

    // Fungsi untuk menandai notifikasi sebagai "sudah dibaca"
    public function markAsRead(Request $request)
    {
        // Jika ada ID, tandai satu. Jika tidak, tandai semua.
        auth()->user()->unreadNotifications
            ->when($request->id, fn ($query) => $query->where('id', $request->id))
            ->markAsRead();

        return response()->noContent();
    }
}
