@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Lupa Password?</h2>
                <p class="text-gray-500 text-sm mt-2">Masukkan Username, Email, atau Nama Anda. Admin akan menerima notifikasi permintaan reset Anda.</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 text-sm rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-6">
                    <label for="login_id" class="block text-gray-700 text-sm font-bold mb-2">Identitas Akun</label>
                    <input type="text" id="login_id" name="login_id"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                           placeholder="Email / Username / Nama" required autofocus>
                </div>

                <button type="submit" class="w-full bg-yellow-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-yellow-600 transition duration-300 shadow">
                    Kirim Permintaan Reset
                </button>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-800 flex items-center justify-center gap-1 transition">
                        ← Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
