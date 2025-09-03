@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Lengkapi Profil Anda</h1>
        <p class="text-gray-600 mb-6">Silakan isi data di bawah ini untuk melanjutkan.</p>

        @if(session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                <p>{{ session('warning') }}</p>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('jemaat.form-fields')

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>
@endsection
