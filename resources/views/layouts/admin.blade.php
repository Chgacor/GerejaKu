<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - GKKB Serdam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

{{--
    KONFIGURASI MENU DAN PERMISSION ROLE
    Kita definisikan array ini di sini agar bisa dipakai
    baik di Desktop Menu maupun Mobile Menu.
--}}
@php
    $userRole = auth()->user()->role; // Ambil role user yang sedang login

    $menuItems = [
        [
            'label' => 'Jemaat',
            'route' => 'admin.jemaat.*',
            'url' => route('admin.jemaat.index'),
            'allowed_roles' => ['admin']
        ],
        [
            'label' => 'Devosi',
            'route' => 'admin.devotionals.*',
            'url' => route('admin.devotionals.index'),
            'allowed_roles' => ['admin', 'gembala']
        ],
        [
            'label' => 'Slide',
            'route' => 'admin.slides.*',
            'url' => route('admin.slides.index'),
            'allowed_roles' => ['admin', 'pengurus']
        ],
        [
            'label' => 'Ibadah',
            'route' => 'admin.services.*',
            'url' => route('admin.services.index'),
            'allowed_roles' => ['admin', 'pengurus']
        ],
        [
            'label' => 'Profil',
            'route' => 'admin.pastors.*',
            'url' => route('admin.pastors.index'),
            'allowed_roles' => ['admin']
        ],
        [
            'label' => 'Komisi',
            'route' => 'admin.commissions.*',
            'url' => route('admin.commissions.index'),
            'allowed_roles' => ['admin']
        ],
        [
            'label' => 'Artikel',
            'route' => 'admin.articles.*',
            'url' => route('admin.articles.index'),
            'allowed_roles' => ['admin', 'gembala', 'pengurus']
        ],
        [
            'label' => 'Acara',
            'route' => 'admin.events.*',
            'url' => route('admin.events.index'),
            'allowed_roles' => ['admin', 'gembala']
        ],
        [
            'label' => 'QnA',
            'route' => 'admin.qna.*',
            'url' => route('admin.qna.index'),
            'allowed_roles' => ['admin', 'gembala']
        ],
        [
            'label' => 'Pengaturan',
            'route' => 'admin.settings.*',
            'url' => route('admin.settings.index'),
            'allowed_roles' => ['admin']
        ],
        [
            'label' => 'Verifikasi User',
            'route' => 'admin.verifications.index',
            'url' => route('admin.verifications.index'),
            'allowed_roles' => ['admin']
        ],
    ];
@endphp

<nav class="bg-gray-800 text-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-20">

            {{-- LOGO / BRAND --}}
            <a href="{{ route('admin.dashboard') }}" class="flex-shrink-0 flex items-center space-x-2 mr-4">
                <span class="text-lg font-bold tracking-tight">{{ config('app.name') }}</span>
                <span class="text-[10px] uppercase tracking-wider text-blue-400 font-semibold px-1.5 py-0.5 rounded border border-blue-400/50">
                    {{-- Menampilkan Role User saat ini agar jelas --}}
                    {{ strtoupper($userRole) }}
                </span>
            </a>

            {{-- MENU DESKTOP --}}
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

                @foreach($menuItems as $item)
                    {{-- CEK PERMISSION: Jika role user TIDAK ada di daftar allowed_roles, lewati (hidden) --}}
                    @if(!in_array($userRole, $item['allowed_roles']))
                        @continue
                    @endif

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

            {{-- Loop Menu Mobile menggunakan Array yang sama dengan Desktop --}}
            @foreach($menuItems as $item)
                {{-- CEK PERMISSION MOBILE --}}
                @if(!in_array($userRole, $item['allowed_roles']))
                    @continue
                @endif

                <a href="{{ $item['url'] }}" class="block px-3 py-2 rounded-md text-base font-medium {{ $mobileClass($item['route']) }}">
                    {{ $item['label'] }}
                </a>
            @endforeach

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
