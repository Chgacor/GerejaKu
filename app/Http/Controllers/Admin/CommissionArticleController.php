<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\CommissionArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CommissionArticleController extends Controller
{
    public function index(Commission $commission = null)
    {
        if ($commission) {
            $articles = $commission->articles()->with('commission')->latest()->paginate(10);
        } else {
            $articles = CommissionArticle::with('commission')->latest()->paginate(10);
        }

        return view('admin.articles.index', compact('commission', 'articles'));
    }

    public function create(Commission $commission = null)
    {
        $commissions = $commission ? null : Commission::orderBy('name')->get();

        return view('admin.articles.create', [
            'commission' => $commission,
            'article' => new CommissionArticle(),
            'commissions' => $commissions,
        ]);
    }

    public function store(Request $request, Commission $commission = null)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'commission_id' => 'required_without:commission|exists:commissions,id',
            'author' => 'nullable|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['title']);

        if ($commission) {
            $validatedData['commission_id'] = $commission->id;
        }

        if ($request->hasFile('cover_image')) {
            $validatedData['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }

        CommissionArticle::create($validatedData);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel baru berhasil ditambahkan.');
    }

    public function edit(CommissionArticle $article)
    {
        $article->load('commission');
        $commissions = Commission::orderBy('name')->get();
        return view('admin.articles.edit', compact('article', 'commissions'));
    }

    public function update(Request $request, CommissionArticle $article)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'commission_id' => 'required|exists:commissions,id',
            'author' => 'nullable|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['title']);

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image && Storage::disk('public')->exists($article->cover_image)) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $validatedData['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }

        $article->update($validatedData);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(CommissionArticle $article)
    {
        if ($article->cover_image && Storage::disk('public')->exists($article->cover_image)) {
            Storage::disk('public')->delete($article->cover_image);
        }
        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
