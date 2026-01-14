<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\CommissionArticle;
use App\Models\User; // PENTING: Tambahkan ini
use App\Notifications\NewContentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class CommissionArticleController extends Controller
{
    // Di AdminCommissionArticleController.php

    public function index(Request $request, Commission $commission = null)
    {
        $query = CommissionArticle::query()->with('commission');

        // Jika filter per komisi
        if ($commission) {
            $query->where('commission_id', $commission->id);
        }

        // Jika ada pencarian
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $articles = $query->latest()->paginate(10);

        // Kirim $commission ke view (bisa null kalau global)
        return view('admin.articles.index', compact('articles', 'commission'));
    }

    public function create(Commission $commission = null) {
        $commissions = Commission::orderBy('name')->get();
        // Kirim objek kosong agar form tidak error
        $article = new CommissionArticle();
        return view('admin.articles.create', compact('commission', 'commissions', 'article'));
    }

    public function store(Request $request, Commission $commission = null) {
        // Definisikan aturan validasi dasar
        $rules = [
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ];

        // LOGIKA PERBAIKAN:
        // Jika $commission (Route Parameter) TIDAK ADA (misal: buat dari menu Admin Global),
        // maka user WAJIB memilih commission_id dari dropdown.
        if (!$commission) {
            $rules['commission_id'] = 'required|exists:commissions,id';
        }

        $validatedData = $request->validate($rules);

        // Jika $commission ADA (Route Nested), paksa commission_id sesuai parameter route
        if ($commission) {
            $validatedData['commission_id'] = $commission->id;
        }

        if ($request->hasFile('cover_image')) {
            $validatedData['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }

        // Buat Slug Unik
        $validatedData['slug'] = $this->createUniqueSlug($validatedData['title']);

        $article = CommissionArticle::create($validatedData);

        // FIX: Kirim notifikasi dengan aman (Try-Catch)
        try {
            $this->sendPublicationNotification($article, 'Berita Baru: ');
        } catch (\Exception $e) {
            // Abaikan jika error notifikasi, yang penting berita tersimpan
        }

        $redirectRoute = $commission ? 'admin.commissions.articles.index' : 'admin.articles.index';
        $routeParams = $commission ? ['commission' => $commission] : [];
        return redirect()->route($redirectRoute, $routeParams)->with('success', 'Artikel berhasil diterbitkan.');
    }

    public function edit(CommissionArticle $article) {
        $commissions = Commission::orderBy('name')->get();
        // Jika artikel milik komisi, kita bisa ambil komisinya, atau biarkan null untuk mode edit global
        $commission = $article->commission;
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
            if ($article->cover_image && Storage::disk('public')->exists($article->cover_image)) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $validatedData['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }

        // Update slug hanya jika judul berubah
        if ($request->title !== $article->title) {
            $validatedData['slug'] = $this->createUniqueSlug($validatedData['title'], $article->id);
        }

        $article->update($validatedData);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(CommissionArticle $article) {
        if ($article->cover_image && Storage::disk('public')->exists($article->cover_image)) {
            Storage::disk('public')->delete($article->cover_image);
        }
        $article->delete();
        return back()->with('success', 'Artikel berhasil dihapus.');
    }

    private function createUniqueSlug($title, $id = 0): string {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;
        while (CommissionArticle::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        return $slug;
    }

    /**
     * FIX: Mengirim notifikasi ke USER, bukan Jemaat.
     */
    private function sendPublicationNotification(CommissionArticle $article, string $titlePrefix)
    {
        // Ambil User yang memiliki data profil Jemaat (Akun Aktif)
        $subscribers = User::whereHas('jemaat')->get();

        if ($subscribers->isEmpty()) {
            return;
        }

        $title = $titlePrefix . Str::limit($article->title, 30);
        $body = 'Artikel "' . Str::limit($article->title, 40) . '..." telah dipublikasikan.';

        // Menggunakan helper route() dengan objek article akan otomatis menggunakan getRouteKeyName() (biasanya ID atau Slug)
        $url = route('articles.show', $article);

        Notification::send($subscribers, new NewContentNotification($title, $body, $url, 'berita'));
    }
}
