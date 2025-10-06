@extends('layouts.app')

@section('content')
    <div class="bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            {{-- Judul Halaman --}}
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                    Berita & Kegiatan Gereja
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Ikuti terus informasi dan kegiatan terbaru dari semua komisi di GKKb Serdam.
                </p>
            </div>

            {{-- Grid untuk Kartu Artikel --}}
            <div class="mt-20 grid gap-10 lg:grid-cols-3 md:grid-cols-2">
                @forelse($articles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}" class="block group">
                        <div class="flex flex-col h-full overflow-hidden rounded-xl bg-white border border-gray-200 shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            {{-- Gambar Artikel --}}
                            <div class="flex-shrink-0">
                                <img class="h-52 w-full object-cover rounded-t-xl" src="{{ $article->cover_image ? asset('storage/' . $article->cover_image) : 'https://placehold.co/400x250/e2e8f0/64748b?text=GKKb+Serdam' }}" alt="{{ $article->title }}">
                            </div>

                            {{-- Konten Kartu --}}
                            <div class="flex flex-1 flex-col justify-between p-6">
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-blue-600">
                                        {{-- Menampilkan nama komisi dengan aman --}}
                                        <span class="hover:underline">{{ optional($article->commission)->name }}</span>
                                    </p>
                                    <p class="mt-2 text-xl font-bold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">
                                        {{ $article->title }}
                                    </p>
                                    <p class="mt-3 text-base text-gray-500 leading-relaxed">
                                        {{ Str::limit(strip_tags($article->content), 120) }}
                                    </p>
                                </div>
                                <div class="mt-6">
                                <span class="font-semibold text-blue-700 group-hover:text-blue-800">
                                    Baca Selengkapnya &rarr;
                                </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    {{-- Tampilan jika tidak ada artikel sama sekali --}}
                    <div class="lg:col-span-3 text-center py-16 px-6 bg-white rounded-lg shadow-xl">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 18V7.125C4.5 6.504 5.004 6 5.625 6H9" />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Berita</h3>
                        <p class="mt-1 text-sm text-gray-500">Silakan kembali lagi nanti untuk melihat pembaruan.</p>
                    </div>
                @endforelse
            </div>

            {{-- Link Paginasi --}}
            <div class="mt-20">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection

