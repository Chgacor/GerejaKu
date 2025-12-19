<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - GKKB Serdam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

<nav class="bg-gray-800 text-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4"> {{-- px dikurangi sedikit agar area lebih luas --}}
        <div class="flex justify-between items-center h-20"> {{-- h-20 memberikan ruang napas lebih baik --}}

            {{-- LOGO / BRAND --}}
            <a href="{{ route('admin.dashboard') }}" class="flex-shrink-0 flex items-center space-x-2 mr-4">
                <span class="text-lg font-bold tracking-tight">{{ config('app.name') }}</span>
                <span class="text-[10px] uppercase tracking-wider text-blue-400 font-semibold px-1.5 py-0.5 rounded border border-blue-400/50">Admin</span>
            </a>

            {{-- MENU DESKTOP --}}
            {{-- Ubah ke lg:flex agar layar tablet tetap menggunakan hamburger --}}
            <div class="hidden lg:flex items-center space-x-1 xl:space-x-3">

                @php
                    $navClass = function($routePattern) {
                        $isActive = request()->routeIs($routePattern);
                        return [
                            'link' => $isActive ? 'text-white font-semibold' : 'text-gray-400 hover:text-white',
                            'line' => $isActive ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100',
                        ];
                    };
                @endphp

                {{-- Item Menu - Menggunakan text-sm dan whitespace-nowrap --}}
                @foreach([
                    ['route' => 'admin.jemaat.*', 'url' => route('admin.jemaat.index'), 'label' => 'Jemaat'],
                    ['route' => 'admin.devotionals.*', 'url' => route('admin.devotionals.index'), 'label' => 'Devosi'],
                    ['route' => 'admin.slides.*', 'url' => route('admin.slides.index'), 'label' => 'Slide'],
                    ['route' => 'admin.services.*', 'url' => route('admin.services.index'), 'label' => 'Ibadah'],
                    ['route' => 'admin.pastors.*', 'url' => route('admin.pastors.index'), 'label' => 'Profil'],
                    ['route' => 'admin.commissions.*', 'url' => route('admin.commissions.index'), 'label' => 'Komisi'],
                    ['route' => 'admin.articles.*', 'url' => route('admin.articles.index'), 'label' => 'Artikel'],
                    ['route' => 'admin.events.*', 'url' => route('admin.events.index'), 'label' => 'Acara'],
                    ['route' => 'admin.qna.*', 'url' => route('admin.qna.index'), 'label' => 'QnA'],
                    ['route' => 'admin.settings.*', 'url' => route('admin.settings.index'), 'label' => 'Pengaturan'],
                ] as $item)
                    @php $s = $navClass($item['route']); @endphp
                    <div class="relative group">
                        <a href="{{ $item['url'] }}" class="{{ $s['link'] }} text-sm whitespace-nowrap transition-colors duration-300 px-2 py-2 block">
                            {{ $item['label'] }}
                        </a>
                        <span class="absolute bottom-1 left-2 right-2 h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                    </div>
                @endforeach

                <div class="border-l border-gray-600 h-6 mx-2"></div>

                {{-- Action Buttons --}}
                <div class="flex items-center space-x-2">
                    <a href="{{ route('home') }}" target="_blank"
                       class="px-3 py-1.5 text-xs font-medium bg-blue-600 rounded hover:bg-blue-700 transition-colors shadow whitespace-nowrap">
                        Lihat Web
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1.5 text-xs font-medium bg-red-600 rounded hover:bg-red-700 transition-colors shadow whitespace-nowrap">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            {{-- TOMBOL HAMBURGER (MOBILE) --}}
            <div class="md:hidden flex items-center">
                <button id="burger-btn" class="text-white focus:outline-none p-2 rounded hover:bg-gray-700">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- MENU MOBILE --}}
        <div id="mobile-menu" class="hidden md:hidden mt-3 pb-4 space-y-1 border-t border-gray-700 pt-2">
            @php
                // Helper Class untuk Mobile
                $mobileClass = function($routePattern) {
                    return request()->routeIs($routePattern)
                        ? 'bg-gray-900 text-white border-l-4 border-blue-500 pl-2' // Aktif
                        : 'text-gray-300 hover:bg-gray-700 hover:text-white';      // Tidak Aktif
                };
            @endphp

            <a href="{{ route('admin.jemaat.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.jemaat.*') }}">Jemaat</a>
            <a href="{{ route('admin.devotionals.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.devotionals.*') }}">Devosi</a>
            <a href="{{ route('admin.slides.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.slides.*') }}">Slideshow</a>
            <a href="{{ route('admin.services.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.services.*') }}">Ibadah</a>
            <a href="{{ route('admin.pastors.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.pastors.*') }}">Profil</a>
            <a href="{{ route('admin.commissions.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.commissions.*') }}">Komisi</a>
            <a href="{{ route('admin.articles.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.articles.*') }}">Artikel</a>
            <a href="{{ route('admin.events.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.events.*') }}">Acara</a>
            <a href="{{ route('admin.qna.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.qna.*') }}">QnA</a>
            <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass('admin.settings.*') }}">Pengaturan</a>

            <div class="border-t border-gray-700 my-2 pt-2">
                <a href="{{ route('home') }}" target="_blank" class="block px-3 py-2 rounded-md text-base font-medium text-blue-400 hover:bg-gray-700">
                    Lihat Situs Publik
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-400 hover:bg-gray-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<main class="container mx-auto p-6 min-h-screen">
    @yield('content')
</main>

<script>
    const burgerBtn = document.getElementById('burger-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    burgerBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
</body>
</html>
