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
    <div class="container mx-auto px-6 py-3">
        <div class="flex justify-between items-center h-16">
            {{-- LOGO / BRAND --}}
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold flex items-center space-x-2">
                <span>{{ config('app.name') }}</span>
                <span class="text-blue-400 text-sm font-normal px-2 py-0.5 rounded border border-blue-400">Admin</span>
            </a>

            {{-- MENU DESKTOP --}}
            <div class="hidden md:flex items-center space-x-6">

                {{-- Helper Component untuk Link Desktop --}}
                @php
                    // Fungsi kecil untuk menentukan kelas CSS agar kode lebih rapi
                    $navClass = function($routePattern) {
                        $isActive = request()->routeIs($routePattern);
                        return [
                            'link' => $isActive ? 'text-white font-semibold' : 'text-gray-400 hover:text-white',
                            'line' => $isActive ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-100',
                        ];
                    };
                @endphp

                {{-- 1. JEMAAT --}}
                @php $s = $navClass('admin.jemaat.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.jemaat.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">Jemaat</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                {{-- 2. DEVOSI --}}
                @php $s = $navClass('admin.devotionals.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.devotionals.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">Devosi</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                {{-- 3. SLIDESHOW --}}
                @php $s = $navClass('admin.slides.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.slides.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">Slide</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                {{-- 4. IBADAH --}}
                @php $s = $navClass('admin.services.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.services.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">Ibadah</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                {{-- 5. PROFIL (Pastors) --}}
                @php $s = $navClass('admin.pastors.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.pastors.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">Profil</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                {{-- 6. KOMISI --}}
                {{-- Note: Menyala jika di rute komisi, TAPI tidak menyala jika sedang di Artikel Global --}}
                @php $s = $navClass('admin.commissions.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.commissions.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">Komisi</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                {{-- 7. ARTIKEL --}}
                {{-- Note: Menyala untuk artikel global --}}
                @php $s = $navClass('admin.articles.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.articles.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">Artikel</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                {{-- 8. ACARA --}}
                @php $s = $navClass('admin.events.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.events.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">Acara</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                {{-- 9. QnA --}}
                @php $s = $navClass('admin.qna.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.qna.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">QnA</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                {{-- 10. PENGATURAN --}}
                @php $s = $navClass('admin.settings.*'); @endphp
                <div class="relative group">
                    <a href="{{ route('admin.settings.index') }}" class="{{ $s['link'] }} transition-colors duration-300 py-2 block">Pengaturan</a>
                    <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-400 transform {{ $s['line'] }} transition-transform duration-300 ease-out origin-left"></span>
                </div>

                <div class="border-l border-gray-600 h-6 mx-2"></div>

                {{-- Link Publik --}}
                <a href="{{ route('home') }}" target="_blank"
                   class="px-4 py-2 text-sm bg-blue-600 rounded hover:bg-blue-700 transition-colors shadow">
                    Lihat Web
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 text-sm bg-red-600 rounded hover:bg-red-700 transition-colors shadow">
                        Keluar
                    </button>
                </form>
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
