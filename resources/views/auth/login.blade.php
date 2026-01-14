@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100 py-10">
        <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md">
            <h1 class="text-3xl font-bold text-center mb-6">Login GKKB</h1>

            {{-- AREA NOTIFIKASI ERROR / SUKSES --}}
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm rounded shadow-sm">
                    <p class="font-bold">Gagal Login</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 text-sm rounded shadow-sm">
                    <p class="font-bold">Info</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                {{-- INPUT FLEKSIBEL (Username/Email/Nama) --}}
                <div class="mb-5">
                    <label for="login_id" class="block text-gray-700 text-sm font-bold mb-2">Username / Email / Nama</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </span>
                        {{-- Perhatikan name="login_id" --}}
                        <input id="login_id" type="text" name="login_id" value="{{ old('login_id') }}"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                               placeholder="Contoh: budisantoso" required autofocus>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                           <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </span>
                        <input id="password" type="password" name="password"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                               placeholder="********" required>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="mr-2 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        Ingat Saya
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 shadow-lg transform hover:-translate-y-0.5">
                    Masuk
                </button>

                <div class="text-center mt-6">
                    <span class="text-gray-600 text-sm">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="text-sm font-bold text-blue-600 hover:underline ml-1">Daftar Sekarang</a>
                </div>
            </form>
        </div>
    </div>
@endsection
