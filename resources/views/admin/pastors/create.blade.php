@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Profil Baru</h1>

        <form action="{{ route('admin.pastors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Ini akan memanggil isi form dari file terpisah --}}
            @include('admin.pastors.form-fields')

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>
@endsection
