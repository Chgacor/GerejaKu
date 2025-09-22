@extends('layouts.admin')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold">Edit Departemen</h1>
        <form action="{{ route('admin.departments.update', $department->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.departments.form-fields')
            <button type="submit" class="bg-green-500 ...">Update</button>
        </form>
    </div>
@endsection
