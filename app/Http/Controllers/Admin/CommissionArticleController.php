<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\CommissionArticle;
use App\Models\Jemaat;
use App\Notifications\NewContentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class CommissionArticleController extends Controller
{
    public function index(Commission $commission = null) {
        $articles = $commission ? $commission->articles()->latest()->paginate(15)
            : CommissionArticle::with('commission')->latest()->paginate(15);
        return view('admin.articles.index', compact('articles', 'commission'));
    }

    public function create(Commission $commission = null) {
        $commissions = Commission::orderBy('name')->get();
        $article = new CommissionArticle();
        return view('admin.articles.create', compact('commission', 'commissions', 'article'));
    }

    public function store(Request $request, Commission $commission = null) {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'commission_id' => 'required_without:commission|nullable|exists:commissions,id',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        if ($commission) $validatedData['commission_id'] = $commission->id;
        if ($request->hasFile('cover_image')) {
            $validatedData['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }
        $validatedData['slug'] = $this->createUniqueSlug($validatedData['title']);
        $article = CommissionArticle::create($validatedData);

        // --- [FIX] Mengganti . menjadi -> ---
        $this->sendPublicationNotification($article, 'Berita Baru: ');
        // --- Akhir Perbaikan ---

        $redirectRoute = $commission ? 'admin.commissions.articles.index' : 'admin.articles.index';
        $routeParams = $commission ? ['commission' => $commission] : [];
        return redirect()->route($redirectRoute, $routeParams)->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(CommissionArticle $article) {
        $commissions = Commission::orderBy('name')->get();
        $commission = null;
        return view('admin.articles.edit', compact('article', 'commission', 'commissions'));
    }

    public function update(Request $request, CommissionArticle $article) {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'commission_id' => 'required|exists:commissions,id',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) Storage::disk('public')->delete($article->cover_image);
            $validatedData['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }
        if ($request->title !== $article->title) {
            $validatedData['slug'] = $this->createUniqueSlug($validatedData['title'], $article->id);
        }

        $article->update($validatedData);

        $this->sendPublicationNotification($article, 'Berita Diperbarui: ');

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(CommissionArticle $article) {
        if ($article->cover_image) Storage::disk('public')->delete($article->cover_image);
        $article->delete();
        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    private function createUniqueSlug($title, $id = 0): string {
        $slug = Str::slug($title); $count = 1; $originalSlug = $slug;
        while (CommissionArticle::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . ++$count;
        }
        return $slug;
    }

    /**
     * Fungsi terpusat untuk mengirim notifikasi
     */
    private function sendPublicationNotification(CommissionArticle $article, string $titlePrefix)
    {

        $subscribers = Jemaat::all();

        if ($subscribers->isEmpty()) {
            return;
        }

        $title = $titlePrefix . Str::limit($article->title, 30);
        $body = 'Artikel "' . Str::limit($article->title, 40) . '..." telah dipublikasikan.';
        $url = route('articles.show', $article->slug);

        Notification::send($subscribers, new NewContentNotification($title, $body, $url, 'berita'));
    }
}

