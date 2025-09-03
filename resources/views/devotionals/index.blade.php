@extends('layouts.app')

@section('content')
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-800">Renungan & Saat Teduh</h1>
        <p class="text-gray-600 mt-2">Kumpulan renungan untuk menemani pertumbuhan iman Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($devotionals as $devotional)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                <img class="h-48 w-full object-cover"
                     src="{{ $devotional->image ? asset('storage/' . $devotional->image) : 'https://via.placeholder.com/400x200.png?text=Renungan' }}"
                     alt="{{ $devotional->title }}">

                <div class="p-6">
                    <p class="text-sm text-gray-500 mb-2">{{ $devotional->created_at->format('d M Y') }}</p>
                    <h2 class="text-xl font-bold text-gray-900">{{ $devotional->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $devotional->scripture_reference }}</p>
                    <p class="text-gray-700 mt-4 line-clamp-3">
                        {{ $devotional->content }}
                    </p>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('devotionals.show', $devotional) }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                            Baca Selengkapnya &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Belum ada renungan yang dipublikasikan.</p>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $devotionals->links() }}
    </div>
@endsection
