<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite('resources/css/app.css')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>
@php
    $isAdminRoute = request()->routeIs('admin.*');
    $bodyClass = $isAdminRoute ? 'bg-gray-100' : 'bg-gray-50';
@endphp
<body class="{{ $bodyClass }}">

@if ($isAdminRoute)
    <nav class="bg-gray-800 text-white shadow-md">
        <div class="container mx-auto px-6 py-3">
            <div class="flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">{{ config('app.name') }} - Admin Panel</a>

                <div class="hidden md:flex items-center space-x-6">
                    @php
                        function admin_nav_link($routeName, $label) {
                            $isActive = request()->routeIs($routeName . '*');
                            $classes = $isActive ? 'text-white font-semibold' : 'text-gray-400 hover:text-white';
                            $underlineClasses = $isActive ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100';

                            return <<<HTML
                                <div class="relative group">
                                    <a href="{$routeName}" class="{$classes} transition-colors duration-300 py-2">
                                        {$label}
                                    </a>
                                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {$underlineClasses} transition-transform duration-300 ease-out origin-left"></span>
                                </div>
                            HTML;
                        }
                    @endphp

                    {!! admin_nav_link(route('admin.jemaat.index'), 'Jemaat') !!}
                    {!! admin_nav_link(route('admin.devotionals.index'), 'Devosi') !!}
                    {!! admin_nav_link(route('admin.slides.index'), 'Slideshow') !!}
                    {!! admin_nav_link(route('admin.services.index'), 'Ibadah') !!}
                    {!! admin_nav_link(route('admin.pastors.index'), 'Hamba Tuhan') !!}
                    {!! admin_nav_link(route('admin.events.index'), 'Acara') !!}
                    {!! admin_nav_link(route('admin.settings.index'), 'Pengaturan') !!}

                    <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 text-sm bg-blue-500 rounded hover:bg-blue-600 transition-colors">Lihat Situs</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm bg-red-500 rounded hover:bg-red-600 transition-colors">Logout</button>
                    </form>
                </div>

                <div class="md:hidden">
                    <button data-toggle-button data-toggle-target="#admin-mobile-menu" class="text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="admin-mobile-menu" class="hidden md:hidden mt-3 space-y-1" data-toggle-menu>
                <a href="{{ route('admin.jemaat.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Jemaat</a>
                <a href="{{ route('admin.devotionals.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Devosi</a>
                <a href="{{ route('admin.slides.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Slideshow</a>
                <a href="{{ route('admin.services.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Ibadah</a>
                <a href="{{ route('admin.pastors.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Hamba Tuhan</a>
                <a href="{{ route('admin.events.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Acara</a>
                <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Pengaturan</a>
                <a href="{{ route('home') }}" target="_blank" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Lihat Situs Publik</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Logout</button>
                </form>
            </div>
        </div>
    </nav>
@else
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <a href="/" class="text-xl font-bold text-gray-800">{{ config('app.name', 'GKKB Serdam') }}</a>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                @php
                    function public_nav_link($routeName, $label, $wildcard = false) {
                        $checkRoute = $wildcard ? $routeName . '*' : $routeName;
                        $isActive = request()->routeIs($checkRoute);
                        $classes = $isActive ? 'text-blue-600 font-bold' : 'text-gray-600';
                        $underlineClasses = $isActive ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100';

                        return <<<HTML
                            <div class="relative group">
                                <a href="{$routeName}" class="{$classes} hover:text-blue-600 transition-colors duration-300 py-2">
                                    {$label}
                                </a>
                                <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-500 transform {$underlineClasses} transition-transform duration-300 ease-out origin-left"></span>
                            </div>
                        HTML;
                    }
                @endphp

                {!! public_nav_link(route('home'), 'Home') !!}
                {!! public_nav_link(route('events.index'), 'Jadwal', true) !!}
                {!! public_nav_link(route('devotionals.index'), 'Devosi', true) !!}
                {!! public_nav_link(route('about'), 'Sejarah Gereja') !!}
                {!! public_nav_link(route('pastors.index'), 'Profil GKKB') !!}
            </div>
            <div class="hidden md:flex items-center">
                @guest
                    <div class="space-x-3">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm text-white bg-blue-500 rounded-lg hover:bg-blue-600">Register</a>
                    </div>
                @endguest
                @auth
                    <div class="relative">
                        <button data-toggle-button data-toggle-target="#profile-menu" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            @if (Auth::user()->foto_profil)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="{{ Auth::user()->nama_lengkap }}">
                            @else
                                <div class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                                    {{ Str::substr(Auth::user()->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                        </button>
                        <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" data-toggle-menu>
                            @if (Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-bold bg-yellow-100">
                                    Admin Panel
                                </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
            <div class="md:hidden flex items-center">
                <button data-toggle-button data-toggle-target="#public-mobile-menu" class="text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
        <div id="public-mobile-menu" class="hidden md:hidden px-6 pt-2 pb-4 space-y-1" data-toggle-menu>
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Home</a>
            <a href="{{ route('events.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Jadwal</a>
            <a href="{{ route('devotionals.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Devosi</a>
            <a href="{{ route('about') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Sejarah Gereja</a>
            <a href="{{ route('pastors.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Profil GKKB</a>
            <hr class="my-2 border-gray-200">
            @guest
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Register</a>
            @endguest
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Admin Panel</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            @endauth
        </div>
    </nav>
@endif

<main>
    @if ($isAdminRoute)
        <div class="container mx-auto p-6">
            @yield('content')
        </div>
    @else
        @yield('content')
    @endif
</main>

@if (!$isAdminRoute)
    <footer class="bg-gray-800 text-white py-10 mt-10">
        <div class="container mx-auto text-center px-4">
            @if(isset($weeklyVerse) && $weeklyVerse->value)
                <div class="mb-6 max-w-2xl mx-auto">
                    <p class="text-lg italic text-gray-300">"{{ $weeklyVerse->value }}"</p>
                </div>
            @endif

            <div class="mb-4">
                    @if(isset($contactSettings['contact_phone']))
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactSettings['contact_phone']) }}" class="text-gray-400 hover:text-white mx-2 inline-block">
                            Telepon: {{ $contactSettings['contact_phone'] }}
                        </a>
                    @endif

                    @if(isset($contactSettings['contact_instagram']))
                        <a href="{{ $contactSettings['contact_instagram'] }}" target="_blank" class="text-gray-400 hover:text-white mx-2 inline-block">
                            Instagram
                        </a>
                    @endif

                    @if(isset($contactSettings['contact_facebook']))
                        <a href="{{ $contactSettings['contact_facebook'] }}" target="_blank" class="text-gray-400 hover:text-white mx-2 inline-block">
                            Facebook
                        </a>
                    @endif

                    @if(isset($contactSettings['contact_youtube']))
                        <a href="{{ $contactSettings['contact_youtube'] }}" target="_blank" class="text-gray-400 hover:text-white mx-2 inline-block">
                            YouTube
                        </a>
                    @endif
            </div>


            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ config('app.name', 'GKKB Serdam') }}. All Rights Reserved.</p>
        </div>
    </footer>
@endif

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const allToggleMenus = document.querySelectorAll('[data-toggle-menu]');
        const allToggleButtons = document.querySelectorAll('[data-toggle-button]');

        allToggleButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.stopPropagation(); // Mencegah window click event terpicu

                const targetSelector = button.dataset.toggleTarget;
                const targetMenu = document.querySelector(targetSelector);

                if (targetMenu) {
                    // Tutup semua menu lain sebelum membuka menu yang baru
                    allToggleMenus.forEach(menu => {
                        if (menu !== targetMenu) {
                            menu.classList.add('hidden');
                        }
                    });

                    // Buka/tutup menu yang ditargetkan
                    targetMenu.classList.toggle('hidden');
                }
            });
        });

        // Event listener untuk menutup semua menu jika klik di luar area
        window.addEventListener('click', () => {
            allToggleMenus.forEach(menu => {
                menu.classList.add('hidden');
            });
        });
    });
</script>
</body>
</html>
