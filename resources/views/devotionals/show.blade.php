@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">

        @if ($devotional->image)
            <img class="w-full h-64 lg:h-80 object-cover rounded-lg mb-6 shadow-md"
                 src="{{ asset('storage/' . $devotional->image) }}"
                 alt="{{ $devotional->title }}">
        @endif

        <div class="mb-6 border-b pb-4">
            <h1 class="text-4xl font-bold text-gray-800">{{ $devotional->title }}</h1>
            <p class="text-lg text-gray-500 mt-2">{{ $devotional->scripture_reference }}</p>
            <p class="text-sm text-gray-400 mt-1">Dipublikasikan pada {{ $devotional->created_at->format('d F Y') }}</p>
        </div>

        <div class="prose max-w-none text-gray-800 leading-relaxed">
            {!! nl2br(e($devotional->content)) !!}
        </div>

        <div class="mt-8 border-t pt-4">
            <a href="{{ route('devotionals.index') }}" class="text-blue-500 hover:underline">&larr; Kembali ke Daftar Renungan</a>
        </div>
        Sigma
    </div>
@endsection
