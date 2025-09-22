@extends('layouts.app')
@section('content')
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold">Departemen Pelayanan</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($departments as $department)
            <a href="{{ route('departments.show', $department) }}" class="block bg-white rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-2 ...">
                <img class="h-48 w-full object-cover" src="{{ $department->image ? asset('storage/' . $department->image) : '...' }}">
                <div class="p-6">
                    <h2 class="text-xl font-bold">{{ $department->name }}</h2>
                </div>
            </a>
        @endforeach
    </div>
@endsection
