@extends('layouts.app')

@section('content')
    {{-- Slideshow Utama --}}
    @if($slides->isNotEmpty())
        <div class="swiper hero-swiper h-96">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide relative bg-gray-800 text-white overflow-hidden">
                        <img src="{{ asset('storage/' . $slide->image) }}" class="w-full h-full object-cover opacity-50">
                        <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center p-8">
                            <div class="text-center">
                                <h1 class="text-4xl md:text-6xl font-bold drop-shadow-md">{{ $slide->title }}</h1>
                                @if($slide->subtitle)
                                    <p class="mt-4 text-lg md:text-xl drop-shadow-sm">{{ $slide->subtitle }}</p>
                                @endif
                                @if($slide->link_url)
                                    <a href="{{ $slide->link_url }}" class="mt-8 inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded shadow-lg">
                                        Selengkapnya
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination hero-pagination"></div>
            <div class="swiper-button-prev hero-button-prev"></div>
            <div class="swiper-button-next hero-button-next"></div>
        </div>
    @endif

    <section class="bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Judul Bagian --}}
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Berita & Kegiatan Terbaru
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-lg text-gray-600">
                    Ikuti terus informasi dan kegiatan terbaru dari komisi-komisi di GKKb Serdam.
                </p>
            </div>

            {{-- Grid untuk Kartu Artikel --}}
            <div class="mt-12 grid gap-8 lg:grid-cols-3 md:grid-cols-2">
                @forelse($artikelTerbaru as $artikel)
                    <a href="{{ route('articles.show', $artikel->slug) }}" class="block group">
                        <div class="flex flex-col h-full overflow-hidden rounded-lg shadow-2xl bg-white transition-transform duration-300 group-hover:scale-105">
                            {{-- Gambar Artikel --}}
                            <div class="flex-shrink-0">
                                <img class="h-48 w-full object-cover" src="{{ $artikel->cover_image ? asset('storage/' . $artikel->cover_image) : 'https://via.placeholder.com/400x250.png?text=GKKb+Serdam' }}" alt="{{ $artikel->title }}">
                            </div>

                            {{-- Konten Kartu --}}
                            <div class="flex flex-1 flex-col justify-between p-6 bg-white">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-blue-600">
                                        <span class="hover:underline">{{ optional($artikel->commission)->name }}</span>
                                    </p>
                                    <p class="mt-2 text-xl font-semibold text-gray-900">
                                        {{ $artikel->title }}
                                    </p>
                                    <p class="mt-3 text-base text-gray-500">
                                        {{ Str::limit(strip_tags($artikel->content), 120) }}
                                    </p>
                                </div>
                                <div class="mt-6">
                                    <span class="font-semibold text-blue-700 group-hover:text-blue-800">
                                        Baca Selengkapnya &rarr;
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="lg:col-span-3 text-center py-12">
                        <p class="text-gray-500">Belum ada berita untuk ditampilkan saat ini.</p>
                    </div>
                @endforelse
            </div>

            {{-- Tombol Lihat Semua --}}
            <div class="mt-12 text-center">
                <a href="{{ route('articles.index') }}" class="inline-block rounded-md bg-blue-600 px-5 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Lihat Semua Artikel
                </a>
            </div>
        </div>
    </section>


    {{-- Slideshow Ibadah Mendatang --}}
    @if($upcomingServices->isNotEmpty())
        <div class="container mx-auto px-6 py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Ibadah & Kegiatan Mendatang</h2>
            </div>
            <div class="swiper service-swiper relative group">
                <div class="swiper-wrapper">
                    @foreach ($upcomingServices as $service)
                        <div class="swiper-slide pb-10">
                            <div class="bg-white rounded-lg shadow-xl flex flex-col overflow-hidden h-full">
                                <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://via.placeholder.com/600x400.png?text=GKKD' }}"
                                     alt="{{ $service->title }}" class="h-48 w-full object-cover">
                                <div class="p-6 flex flex-col flex-grow">
                                    <span class="text-xs font-semibold bg-blue-100 text-blue-800 px-2 py-1 rounded-full self-start">{{ optional($service->division)->name }}</span>
                                    <h3 class="text-xl font-bold text-gray-900 mt-3">{{ $service->title }}</h3>
                                    <p class="text-gray-500 text-sm mt-1">Oleh: {{ $service->speaker }}</p>
                                    <p class="text-gray-700 font-semibold mt-3">{{ $service->service_time->isoFormat('dddd, D MMM Y, H:mm') }} WIB</p>
                                    <div class="mt-auto pt-4">
                                        <a href="{{ route('services.show', $service) }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                                            Lihat Detail &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination service-pagination text-center !bottom-0"></div>
                <div class="swiper-button-prev service-button-prev text-blue-500 group-hover:opacity-100 opacity-0 transition-opacity duration-300"></div>
                <div class="swiper-button-next service-button-next text-blue-500 group-hover:opacity-100 opacity-0 transition-opacity duration-300"></div>
            </div>
        </div>
    @endif

    <div class="text-center my-12 container mx-auto px-6">
        <h1 class="text-4xl font-bold text-gray-800">Selamat Datang di Portal GKKB Serdam</h1>
        <p class="mt-4 text-lg text-gray-600">Tempat kita bertumbuh bersama dalam iman dan persekutuan.</p>
    </div>
@endsection

@push('scripts')
    <script>
        const heroSwiper = new Swiper('.hero-swiper', {
            autoplay: { delay: 3000, disableOnInteraction: false },
            loop: true,
            pagination: { el: '.hero-pagination', clickable: true },
            navigation: { nextEl: '.hero-button-next', prevEl: '.hero-button-prev' },
        });

        const serviceSwiper = new Swiper('.service-swiper', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: { el: '.service-pagination', clickable: true },
            navigation: { nextEl: '.service-button-next', prevEl: '.service-button-prev' },
            breakpoints: {
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });
    </script>
@endpush

