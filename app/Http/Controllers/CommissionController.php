<?php
// app/Http/Controllers/CommissionController.php
namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\CommissionArticle;

class CommissionController extends Controller
{

    public function index()
    {
        $commissions = Commission::orderBy('name')->get();
        return view('commissions.index', compact('commissions'));
    }

    public function show(Commission $commission)
    {
        // Memuat relasi 'articles' bersamaan dengan query utama
        $commission->load('articles');
        $articles = $commission->articles()->latest()->paginate(9);
        return view('commissions.show', compact('commission', 'articles'));
    }

    public function showArticle($commissionSlug, $articleSlug)
    {
        $article = CommissionArticle::where('slug', $articleSlug)->firstOrFail();
        return view('articles.show', compact('article'));
    }
}

