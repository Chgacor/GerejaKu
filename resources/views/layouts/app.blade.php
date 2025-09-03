<!-- Lokasi: resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GKKB Serdam</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
<!-- Navbar Publik -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <div>
            <a href="/" class="text-xl font-bold text-gray-800">GKKB Serdam</a>
        </div>

        <div class="hidden md:flex space-x-8 mr-auto ml-auto">
            <a href="/" class="text-gray-600 hover:text-blue-500">Home</a>
            <a href="#" class="text-gray-600 hover:text-blue-500">Jadwal</a>
            <a href="{{ route('devotionals.index') }}" class="text-gray-600 hover:text-blue-500">Devosi</a>
            <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-500">Tentang Kami</a>
        </div>

        <div class="flex items-center">
            @guest
                <div class="space-x-3">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-100">Login</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm text-white bg-blue-500 rounded-lg hover:bg-blue-600">Register</a>
                </div>
            @endguest

            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                        @if (Auth::user()->foto_profil)
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('storage/' . Auth::user()->foto_profil) }}" alt="{{ Auth::user()->nama_lengkap }}">
                        @else
                            <div class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                                {{ Str::substr(Auth::user()->nama_lengkap, 0, 1) }}
                            </div>
                        @endif
                    </button>

                    <div x-show="open"
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">

                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.jemaat.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-bold bg-yellow-100">
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

    </div>
</nav>

<!-- Konten Utama -->
<main class="container mx-auto px-6 py-8">
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-10 mt-10">
    <div class="container mx-auto text-center">
        @if($weeklyVerse && $weeklyVerse->value)
            <div class="mb-6">
                <p class="text-lg italic">"{{ $weeklyVerse->value }}"</p>
            </div>
        @endif
        <p>&copy; {{ date('Y') }} GKKB Serdam. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>
