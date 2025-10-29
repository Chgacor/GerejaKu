@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md">
            <h1 class="text-3xl font-bold text-center mb-6">Welcome!</h1>

            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-4">
                    <label for="username" class="sr-only">Username</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                        </span>
                        {{-- Placeholder diubah --}}
                        <input id="username" type="text" name="username" value="{{ old('username') }}" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Username" required autofocus>
                    </div>

                    {{-- Menampilkan pesan error validasi --}}
                    @error('username')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror

                </div>
                <div class="mb-6">
                    <label for="password" class="sr-only">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                        </span>
                        <input id="password" type="password" name="password" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Password" required>
                    </div>
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                </div>
                <div>
                    <button type="submit" class="w-full bg-black text-white font-bold py-3 px-4 rounded-full hover:bg-gray-800 transition duration-300">
                        Login
                    </button>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('register') }}" class="text-sm text-blue-500 hover:underline">Belum punya akun? Register di sini</a>
                </div>
            </form>
        </div>
    </div>
@endsection
