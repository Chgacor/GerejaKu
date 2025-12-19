@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        {{-- Padding top ditambah (pt-20) agar judul turun --}}
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-10 pb-20">
            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                    Renungan & Saat Teduh
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-base sm:text-lg text-gray-600">
                    Kumpulan renungan untuk menemani pertumbuhan iman Anda.
                </p>
            </div>

            {{-- Grid Responsif (ml-4 dihapus agar center) --}}
            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($devotionals as $devotional)
                    <div class="group flex flex-col h-full bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        {{-- Gambar Devosi --}}
                        <div class="relative overflow-hidden">
                            <img class="h-48 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 src="{{ $devotional->image ? asset('storage/' . $devotional->image) : 'https://placehold.co/400x250/e2e8f0/64748b?text=Renungan' }}"
                                 alt="{{ $devotional->title }}">
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-700 shadow-sm">
                                    {{ $devotional->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-gray-900 group-hover:text-blue-700 transition-colors">
                                    {{ $devotional->title }}
                                </h2>
                                <p class="text-sm font-medium text-blue-600 mt-1 italic">
                                    {{ $devotional->scripture_reference }}
                                </p>
                                <p class="text-sm text-gray-600 mt-4 line-clamp-3 leading-relaxed">
                                    {{ strip_tags($devotional->content) }}
                                </p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-50 flex justify-end">
                                <a href="{{ route('devotionals.show', $devotional) }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition-all">
                                    Baca Renungan <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 text-center py-16 px-6 bg-white rounded-xl shadow-sm border border-gray-200">
                        <p class="text-gray-500">Belum ada renungan yang dipublikasikan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $devotionals->links() }}
            </div>
        </div>
    </div>
@endsection
