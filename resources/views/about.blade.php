@extends('layouts.app')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">

        @if ($aboutImage)
            <img class="w-full h-64 object-cover rounded-lg mb-6 shadow-md"
                 src="{{ asset('storage/' . $aboutImage) }}"
                 alt="Gambar Tentang Kami">
        @endif

        <h1 class="text-4xl font-bold text-gray-800 mb-6 border-b pb-4">Tentang Kami</h1>
        <div class="prose max-w-none text-gray-800 leading-relaxed">
            {!! nl2br(e($history)) !!}
        </div>
    </div>
@endsection
