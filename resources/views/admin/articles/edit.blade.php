@extends('layouts.admin')

@section('content')

    <h1 class="text-2xl font-bold text-gray-800 mb-6">
        Edit Artikel: {{ Str::limit($article->title, 50) }}

        @if($article->commission)
            <span class="text-sm font-normal text-gray-500 block">
                Milik Komisi: {{ $article->commission->name }}
            </span>
        @endif
    </h1>

    <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg max-w-4xl mx-auto">

        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.articles.form-fields', ['article' => $article, 'commission' => null, 'commissions' => $commissions])

            <div class="mt-8 flex justify-end items-center space-x-3">
                <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    Update Artikel
                </button>
            </div>
        </form>
    </div>
@endsection

