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
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        <a href="{{ route('admin.jemaat.index') }}" class="text-xl font-bold">Admin Panel</a>

        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.jemaat.index') }}" class="hover:text-gray-300">Manajemen Jemaat</a>
            <a href="{{ route('admin.devotionals.index') }}" class="hover:text-gray-300">Manajemen Devosi</a>
            <a href="{{ route('admin.settings.index') }}" class="hover:text-gray-300">Pengaturan</a>

            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 bg-blue-500 rounded hover:bg-blue-600">
                Lihat Situs Publik
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-500 rounded hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<main class="container mx-auto p-6">
    @yield('content')
</main>

</body>
</html>
