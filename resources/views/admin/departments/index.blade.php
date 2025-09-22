@extends('layouts.admin')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6">Manajemen Departemen</h1>
        <a href="{{ route('admin.departments.create') }}" class="bg-blue-500 ...">Tambah Departemen</a>
        {{-- Tabel untuk menampilkan daftar departemen --}}
    </div>
@endsection
