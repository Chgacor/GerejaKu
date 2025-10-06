@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 py-12 sm:py-16">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg max-w-4xl mx-auto">

            {{-- Gambar Utama (jika ada) --}}
            @if ($article->cover_image)
                <img class="w-full h-64 lg:h-96 object-cover rounded-lg mb-8 shadow-md"
                     src="{{ asset('storage/' . $article->cover_image) }}"
                     alt="{{ $article->title }}">
            @endif

            {{-- Header Artikel --}}
            <div class="mb-8 border-b pb-6">
                {{-- Label Kategori & Komisi --}}
                <div class="flex items-center space-x-4 text-sm font-medium text-blue-600 mb-2">
                    <span>{{ $article->category }}</span>
                    @if($article->commission)
                        <span class="text-gray-300">|</span>
                        {{-- Link ke halaman detail komisi --}}
                        <a href="{{ route('commissions.show', $article->commission->slug) }}" class="hover:underline">
                            Dari: {{ $article->commission->name }}
                        </a>
                    @endif
                </div>

                <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-gray-900">{{ $article->title }}</h1>

                <p class="text-sm text-gray-500 mt-3">
                    Ditulis oleh {{ $article->author ?? 'Admin' }}
                    <span class="mx-2">&bull;</span>
                    Dipublikasikan pada {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->isoFormat('dddd, D MMMM Y') : $article->created_at->isoFormat('D MMMM Y') }}
                </p>
            </div>

            {{-- Konten Utama Artikel --}}
            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($article->content)) !!}
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-10 border-t pt-6">
                <a href="{{ route('articles.index') }}" class="inline-block text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-300">
                    &larr; Kembali ke Daftar Berita
                </a>
            </div>
        </div>
    </div>
@endsection

