@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        {{-- Padding top dikurangi (pt-10) agar judul naik --}}
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10 pb-20">
            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                    Berita & Kegiatan Gereja
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-base sm:text-lg text-gray-600">
                    Ikuti terus informasi dan kegiatan terbaru dari semua komisi di GKKB Serdam.
                </p>
            </div>

            {{-- Grid Responsif --}}
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($articles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}" class="block group">
                        <div class="flex flex-col h-full overflow-hidden rounded-xl bg-white border border-gray-200 shadow-sm transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            {{-- Gambar Artikel --}}
                            <div class="flex-shrink-0">
                                <img class="h-52 w-full object-cover" src="{{ $article->cover_image ? asset('storage/' . $article->cover_image) : 'https://placehold.co/400x250/e2e8f0/64748b?text=Berita' }}" alt="{{ $article->title }}">
                            </div>

                            {{-- Konten Kartu --}}
                            <div class="flex flex-1 flex-col justify-between p-6">
                                <div class="flex-1">
                                    <p class="text-xs font-bold uppercase tracking-wider text-blue-600">
                                        {{ optional($article->commission)->name ?? 'Umum' }}
                                    </p>
                                    <h2 class="mt-2 text-xl font-bold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">
                                        {{ $article->title }}
                                    </h2>
                                    <p class="mt-3 text-sm text-gray-500 leading-relaxed line-clamp-3">
                                        {{ Str::limit(strip_tags($article->content), 120) }}
                                    </p>
                                </div>
                                <div class="mt-6 pt-4 border-t border-gray-50">
                                    <span class="text-sm font-semibold text-blue-700 flex items-center group-hover:gap-2 transition-all">
                                        Baca Selengkapnya <span>&rarr;</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 text-center py-16 px-6 bg-white rounded-xl shadow-sm border border-gray-200">
                        <p class="text-gray-500">Belum ada berita yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection
