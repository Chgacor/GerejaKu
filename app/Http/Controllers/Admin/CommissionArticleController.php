<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\CommissionArticle;
use App\Models\Jemaat; // Pastikan ini adalah model User Anda yang menggunakan trait Notifiable
use App\Notifications\NewContentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification; // [FIX] Ditambahkan kembali

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

        // --- [FIX] Logika Notifikasi Diperbaiki ---
        // Cek apakah artikel ini dianggap "terbit"
        // (Asumsinya: null = terbit sekarang, atau tanggal di masa lalu/kini)
        $isPublished = $article->published_at === null || $article->published_at <= now();

        if ($isPublished) {
            $this->sendPublicationNotification($article);
        }
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

        // [FIX] Simpan status terbit SEBELUM update
        $wasPublished = $article->published_at === null || $article->published_at <= now();

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) Storage::disk('public')->delete($article->cover_image);
            $validatedData['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }
        if ($request->title !== $article->title) {
            $validatedData['slug'] = $this->createUniqueSlug($validatedData['title'], $article->id);
        }

        $article->update($validatedData);

        // [FIX] Cek status terbit SETELAH update
        $isNowPublished = $article->published_at === null || $article->published_at <= now();

        // Kirim notifikasi HANYA jika status berubah dari "belum" ke "sudah"
        if (!$wasPublished && $isNowPublished) {
            $this->sendPublicationNotification($article);
        }

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
     * [BARU] Fungsi terpusat untuk mengirim notifikasi
     */
    private function sendPublicationNotification(CommissionArticle $article)
    {
        dd('MASUK TES NOTIFIKASI');
        // Ganti Jemaat::all() jika Anda ingin target yang lebih spesifik
        // Ganti Jemaat::class dengan model User Anda (misal: App\Models\User)
        $subscribers = Jemaat::where('role', '!=', 'admin')->get();

        if ($subscribers->isEmpty()) {
            return; // Tidak ada penerima, hentikan
        }

        $title = 'Berita Baru: ' . Str::limit($article->title, 30);
        $body = 'Artikel baru telah dipublikasikan.';
        $url = route('articles.show', $article->slug);

        // [FIX] Menggunakan Facade 'Notification' yang sudah di-import
        Notification::send($subscribers, new NewContentNotification($title, $body, $url, 'berita'));
    }
}
