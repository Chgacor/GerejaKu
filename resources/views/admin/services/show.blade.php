@extends('layouts.app')

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg max-w-4xl mx-auto">

        @if ($service->image)
            <img class="w-full h-64 md:h-80 object-cover rounded-lg mb-6 shadow-md"
                 src="{{ asset('storage/' . $service->image) }}"
                 alt="{{ $service->title }}">
        @endif

        <div class="mb-6 border-b pb-4">
        <span class="text-sm font-semibold bg-blue-100 text-blue-800 px-3 py-1 rounded-full self-start">
            {{ optional($service->division)->name }}
        </span>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mt-4">{{ $service->title }}</h1>
            <p class="text-lg text-gray-500 mt-2">Oleh: **{{ $service->speaker }}**</p>
            <p class="text-md text-gray-600 font-semibold mt-2">
                {{ $service->service_time->isoFormat('dddd, D MMMM Y, H:mm') }} WIB
            </p>
        </div>

        <div class="prose max-w-none text-gray-800 leading-relaxed">
            {!! nl2br(e($service->description)) !!}
        </div>

        <div class="mt-8 border-t pt-6">
            <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline">&larr; Kembali</a>
        </div>

    </div>
@endsection
