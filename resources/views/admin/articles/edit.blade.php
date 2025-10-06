@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Artikel</h1>

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.articles.form-fields')

            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.commissions.articles.index', $commission) }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Update Artikel
                </button>
            </div>
        </form>
    </div>
@endsection
