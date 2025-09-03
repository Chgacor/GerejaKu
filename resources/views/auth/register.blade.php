<!-- Lokasi: resources/views/auth/register.blade.php -->
@extends('layouts.app')
@section('content')
    <div class="flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-bold text-center mb-6">Register Akun Baru</h1>
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="mb-4">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="w-full mt-1 p-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label>Email</label>
                    <input type="email" name="email" class="w-full mt-1 p-2 border rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label>Password</label>
                    <input type="password" name="password" class="w-full mt-1 p-2 border rounded-lg" required>
                </div>
                <div class="mb-6">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full mt-1 p-2 border rounded-lg" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Register</button>
            </form>
        </div>
    </div>
@endsection
