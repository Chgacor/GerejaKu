@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-50 py-12">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-bold text-center mb-6">Register Akun Baru</h1>

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="space-y-4">
                    {{-- Ganti nama_lengkap menjadi full_name --}}
                    <div>
                        <label for="full_name" class="block font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" class="w-full mt-1 p-3 border rounded-lg" required autofocus>
                    </div>

                    {{-- Username --}}
                    <div>
                        <label for="username" class="block font-medium text-gray-700">Username</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" class="w-full mt-1 p-3 border rounded-lg" required>
                        <p class="text-xs text-gray-500 mt-1">Gunakan huruf kecil, angka, tanpa spasi. Contoh: budi_santoso</p>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full mt-1 p-3 border rounded-lg" required>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="w-full mt-1 p-3 border rounded-lg" required>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block font-medium text-gray-700">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full mt-1 p-3 border rounded-lg" required>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
