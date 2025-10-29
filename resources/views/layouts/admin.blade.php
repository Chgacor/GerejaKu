<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - GKKB Serdam</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<nav class="bg-gray-800 text-white shadow-md">
    <div class="container mx-auto px-6 py-3">
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">{{ config('app.name') }} - Admin Panel</a>

            {{-- Menu Desktop --}}
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
                {!! admin_nav_link(route('admin.pastors.index'), 'Profil') !!}
                {!! admin_nav_link(route('admin.commissions.index'), 'Komisi') !!}
                {!! admin_nav_link(route('admin.articles.index'), 'Artikel') !!}
                {!! admin_nav_link(route('admin.events.index'), 'Acara') !!}
                {!! admin_nav_link(route('admin.qna.index'), 'QnA') !!}
                {!! admin_nav_link(route('admin.settings.index'), 'Pengaturan') !!}

                <a href="{{ route('home') }}" target="_blank"
                   class="px-4 py-2 text-sm bg-blue-500 rounded hover:bg-blue-600 transition-colors">
                    Lihat Situs
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 text-sm bg-red-500 rounded hover:bg-red-600 transition-colors">
                        Logout
                    </button>
                </form>
            </div>

            <div class="md:hidden">
                <button id="burger-btn" class="text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden mt-3 space-y-1">
            <a href="{{ route('admin.jemaat.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Jemaat</a>
            <a href="{{ route('admin.devotionals.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Devosi</a>
            <a href="{{ route('admin.slides.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Slideshow</a>
            <a href="{{ route('admin.services.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Ibadah</a>
            <a href="{{ route('admin.pastors.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Profil</a>
            <a href="{{ route('admin.events.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Acara</a>
            <a href="{{ route('admin.articles.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Artikel</a>
            <a href="{{ route('admin.qna.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">QnA</a>
            <a href="{{ route('admin.settings.index') }}" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Pengaturan</a>
            <a href="{{ route('home') }}" target="_blank" class="block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">Lihat Situs Publik</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-700">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<main class="container mx-auto p-6">
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

