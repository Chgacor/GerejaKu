@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Profil Hamba Tuhan</h1>

        {{-- FIX 1: Action ke route update dengan ID, dan enctype multipart --}}
        <form action="{{ route('admin.pastors.update', $pastor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- FIX 2: Method spoofing PUT untuk update --}}
            @method('PUT')

            @include('admin.pastors.form-fields')

            {{-- FIX 3: Styling tombol --}}
            <div class="mt-6 flex items-center gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    Perbarui Data
                </button>
                <a href="{{ route('admin.pastors.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection
