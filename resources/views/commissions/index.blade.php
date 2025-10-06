@extends('layouts.app')

@section('content')
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            {{-- Header --}}
            <div class="text-center">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Profil Komisi GKKB Serdam</h1>
                <p class="mt-4 text-lg leading-8 text-gray-600">
                    Mengenal lebih dekat setiap komisi yang melayani dan bertumbuh bersama di gereja kita.
                </p>
            </div>

            {{-- Grid Kartu Komisi --}}
            <div class="mt-20 grid grid-cols-1 gap-12 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($commissions as $commission)
                    <a href="{{ route('commissions.show', $commission->slug) }}" class="group block">
                        <div class="flex flex-col h-full overflow-hidden rounded-2xl shadow-lg bg-white transition-transform duration-300 group-hover:scale-105 group-hover:shadow-xl border border-gray-200">
                            <div class="flex-shrink-0 h-48 w-full bg-gray-100 flex items-center justify-center overflow-hidden">
                                @if($commission->head_photo)
                                    <img class="h-full w-full object-cover" src="{{ asset('storage/' . $commission->head_photo) }}" alt="{{ $commission->name }}">
                                @else
                                    {{-- Placeholder jika tidak ada foto --}}
                                    <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                @endif
                            </div>
                            <div class="p-6 text-center">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $commission->name }}</h3>
                                <p class="mt-2 text-sm text-gray-500">Ketua: {{ $commission->head_of_commission ?? 'Belum ada data' }}</p>
                                <span class="mt-4 inline-block font-semibold text-blue-600 group-hover:text-blue-700">
                                Lihat Profil &rarr;
                            </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
