<?php

namespace App\Http\Controllers;

use App\Models\CommissionArticle;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Menampilkan halaman utama berisi semua artikel dari semua komisi.
     */
    public function index()
    {
        $articles = CommissionArticle::with('commission') // Ambil juga data komisinya
        ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(12); // Tampilkan 12 artikel per halaman

        return view('articles.index', compact('articles'));
    }

    /**
     * Menampilkan satu artikel secara detail.
     */
    public function show(CommissionArticle $article)
    {
        // Pastikan artikel sudah dipublikasikan sebelum ditampilkan
        if (!$article->published_at) {
            abort(404);
        }

        return view('articles.show', compact('article'));
    }
}
