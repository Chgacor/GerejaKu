@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Komisi: {{ $commission->name }}</h1>

        <form action="{{ route('admin.commissions.update', $commission) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.commissions.form-fields', ['commission' => $commission])

            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('admin.commissions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Update Komisi
                </button>
            </div>
        </form>
    </div>
@endsection
