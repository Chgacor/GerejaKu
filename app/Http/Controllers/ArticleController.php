<?php

namespace App\Http\Controllers;

use App\Models\CommissionArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Menampilkan halaman utama berisi semua artikel dari semua komisi.
     */
    public function index()
    {
        $articles = CommissionArticle::with('commission')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(12);

        return view('articles.index', compact('articles'));
    }

    /**
     * Menampilkan satu artikel secara detail.
     */
    public function show(CommissionArticle $article)
    {

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            if (!$article->published_at) {
                abort(404);
            }
        }

        // Jika admin, lewati pengecekan di atas (bisa lihat draft)
        return view('articles.show', compact('article'));
    }
}
