@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 py-16 sm:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">Profil Pelayan GKKB Serdam</h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">
                    Mengenal lebih dekat para Gembala dan Badan Pengurus Komisi yang melayani.
                </p>
            </div>

            <div class="space-y-16">
                @forelse($groupedProfiles as $kelompok => $profiles)
                    <div>
                        @php
                            // Ambil profil pertama dari grup untuk mengecek tautan komisi
                            $firstProfile = $profiles->first();
                            $commissionLink = $firstProfile->commission ? route('commissions.show', $firstProfile->commission->slug) : null;
                        @endphp

                        {{-- Judul Grup (menjadi link jika ada tautan) --}}
                        @if($commissionLink)
                            <a href="{{ $commissionLink }}" class="group block max-w-md mx-auto">
                                <h2 class="text-3xl font-bold text-center text-gray-800 border-b-2 border-blue-500 pb-4 mb-12 group-hover:text-blue-600 group-hover:border-blue-700 transition">
                                    {{ $kelompok }}
                                    <span class="block text-sm font-semibold mt-2 text-blue-500 opacity-0 group-hover:opacity-100 transition">Lihat Visi & Misi &rarr;</span>
                                </h2>
                            </a>
                        @else
                            <h2 class="text-3xl font-bold text-center text-gray-800 border-b-2 border-blue-500 pb-4 mb-12 max-w-md mx-auto">
                                {{ $kelompok }}
                            </h2>
                        @endif

                        {{-- Grid untuk setiap profil di dalam kelompok --}}
                        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($profiles as $profile)
                                <div class="bg-white text-center rounded-lg shadow-lg p-6 transform hover:-translate-y-2 transition-transform duration-300">
                                    <img class="w-32 h-32 rounded-full mx-auto object-cover mb-4 ring-4 ring-gray-200"
                                         src="{{ $profile->photo ? asset('storage/' . $profile->photo) : 'https://via.placeholder.com/150' }}"
                                         alt="{{ $profile->name }}">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $profile->name }}</h3>
                                    <p class="text-blue-500 font-semibold">{{ $profile->position }}</p>
                                    <p class="text-gray-600 mt-4 text-sm">{{ $profile->bio }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-lg">Belum ada data profil pelayan untuk ditampilkan.</p>
                @endforelse
            </div>
@endsection
