<?php

namespace App\Http\Controllers;

use App\Models\Jemaat;
use App\Models\Qna;
use App\Notifications\NewQuestionSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class QnaController extends Controller
{
    /**
     * Menampilkan halaman QnA dengan form dan daftar pertanyaan terpublikasi.
     */
    public function index()
    {
        $publishedQnas = Qna::where('is_published', true)
            ->latest('answered_at')
            ->paginate(10);

        return view('qna.index', compact('publishedQnas'));
    }

    /**
     * Menyimpan pertanyaan baru dari pengunjung.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'question' => 'required|string|max:5000',
        ]);

        $qna = Qna::create($validatedData);

        // Kirim notifikasi ke semua admin
        $admins = Jemaat::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewQuestionSubmitted($qna));
        }

        return redirect()->route('qna.index')->with('success', 'Pertanyaan Anda telah berhasil terkirim. Terima kasih!');
    }
}
