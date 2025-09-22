@extends('layouts.app')
@section('content')
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">Profil Hamba Tuhan</h1>
        <p class="text-gray-600 mt-2">Mengenal para pemimpin rohani di gereja kami.</p>
    </div>
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($pastors as $pastor)
            <div class="bg-white text-center rounded-lg shadow-lg p-6">
                <img class="w-32 h-32 rounded-full mx-auto object-cover mb-4"
                     src="{{ $pastor->photo ? asset('storage/' . $pastor->photo) : 'https://via.placeholder.com/150' }}"
                     alt="{{ $pastor->name }}">
                <h3 class="text-xl font-bold text-gray-900">{{ $pastor->name }}</h3>
                <p class="text-gray-500 font-semibold">{{ $pastor->position }}</p>
                <p class="text-gray-600 mt-4 text-sm">{{ $pastor->bio }}</p>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Data hamba Tuhan belum tersedia.</p>
        @endforelse
    </div>
@endsection
