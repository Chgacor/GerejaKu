@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Jemaat Baru</h1>
        <form action="{{ route('admin.jemaat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('jemaat.form-fields')
            <div class="mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Simpan
                </button>
                <a href="{{ route('admin.jemaat.index') }}" class="text-gray-600 ml-4">Batal</a>
            </div>
        </form>
    </div>
@endsection
