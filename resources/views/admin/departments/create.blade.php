@extends('layouts.admin')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold">Tambah Departemen Baru</h1>
        <form action="{{ route('admin.departments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.departments.form-fields')
            <button type="submit" class="bg-blue-500 ...">Simpan</button>
        </form>
    </div>
@endsection
