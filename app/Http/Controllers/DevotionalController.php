<?php

namespace App\Http\Controllers;

use App\Models\Devotional;
use Illuminate\Http\Request;

class DevotionalController extends Controller
{
    // Menampilkan daftar semua renungan
    public function index()
    {
        $devotionals = Devotional::latest()->paginate(9);
        return view('devotionals.index', compact('devotionals'));
    }

    // Menampilkan satu renungan secara spesifik
    public function show(Devotional $devotional)
    {
        return view('devotionals.show', compact('devotional'));
    }
}
