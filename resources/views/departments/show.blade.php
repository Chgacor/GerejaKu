@extends('layouts.app')
@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
        {{-- Tampilkan detail departemen di sini --}}
        <h1>{{ $department->name }}</h1>
        <p>Ketua: {{ $department->head_name }}</p>
        <div>{!! nl2br(e($department->function)) !!}</div>
        {{-- Di sini nanti kita akan tampilkan daftar Komisi di bawah Departemen ini --}}
    </div>
@endsection
