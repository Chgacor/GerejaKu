@extends('layouts.app')

@section('content')
    {{-- Hero Section --}}
    <div class="bg-gray-800 py-20 sm:py-28 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-base font-semibold leading-7 text-blue-300">Profil Komisi</p>
            <h1 class="mt-2 text-4xl font-bold tracking-tight sm:text-6xl">{{ $commission->name }}</h1>
            <p class="mt-6 text-lg leading-8 text-gray-300 max-w-2xl mx-auto">{{ strip_tags($commission->purpose) }}</p>
        </div>
    </div>

    <div class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Bagian Struktur Pengurus --}}
            <div class="mx-auto max-w-3xl mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 mb-6">Struktur Keanggotaan</h2>
                <div class="prose lg:prose-lg max-w-none text-gray-600">
                    <p><strong>Ketua:</strong> {{ $commission->head_of_commission ?? '-' }}</p>
                    {{-- Tampilkan struktur lain jika ada --}}
                    @if($commission->management_structure)
                        <div class="mt-4">{!! nl2br(e($commission->management_structure)) !!}</div>
                    @endif
                </div>
            </div>

            <hr class="mb-16">

            {{-- Bagian Artikel & Berita --}}
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900">Berita & Kegiatan Terbaru</h2>
            </div>

            <div class="mt-12 grid gap-8 lg:grid-cols-3 md:grid-cols-2">
                @forelse($articles as $article)
                    <a href="{{ route('articles.show', [$commission->slug, $article->slug]) }}" class="block group">
                        <div class="flex flex-col h-full overflow-hidden rounded-lg shadow-2xl bg-white transition-transform duration-300 group-hover:scale-105">
                            <div class="flex-shrink-0">
                                <img class="h-48 w-full object-cover" src="{{ $article->cover_image ? asset('storage/' . $article->cover_image) : 'https://via.placeholder.com/400x250.png?text=GKKb+Serdam' }}" alt="{{ $article->title }}">
                            </div>
                            <div class="flex flex-1 flex-col justify-between p-6">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-blue-600">{{ $article->category }}</p>
                                    <p class="mt-2 text-xl font-semibold text-gray-900">{{ $article->title }}</p>
                                    <p class="mt-3 text-base text-gray-500">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                                </div>
                                <div class="mt-6">
                                    <span class="font-semibold text-blue-700 group-hover:text-blue-800">Baca Selengkapnya &rarr;</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="lg:col-span-3 text-center py-12">
                        <p class="text-gray-500">Belum ada berita dari komisi ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection
