@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Jemaat</h1>
        <form action="{{ route('admin.jemaat.update', $jemaat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('jemaat.form-fields')
            <div class="mt-6">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    Update
                </button>
                <a href="{{ route('admin.jemaat.cards') }}" class="text-gray-600 ml-4">Batal</a>
            </div>
        </form>
    </div>
@endsection
