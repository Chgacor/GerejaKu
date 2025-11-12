@extends('layouts.app')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">

        {{-- Gambar Banner --}}
        @if(isset($settings['about_image']) && $settings['about_image'])
            <img class.="w-full h-64 object-cover rounded-lg mb-8 shadow-md"
                 src="{{ asset('storage/' . $settings['about_image']) }}"
                 alt="Tentang Kami">
        @endif

        {{-- Judul Utama --}}
        <h1 class="text-4xl font-bold text-gray-800 mb-6 border-b pb-4 text-center">
            Tentang Kami
        </h1>

        {{-- Section Visi --}}
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Visi Kami</h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed text-center">
                {!! nl2br(e($settings['church_vision'] ?? 'Konten Visi belum tersedia.')) !!}
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Misi Kami</h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed text-center">
                {!! nl2br(e($settings['church_mission'] ?? 'Konten Misi belum tersedia.')) !!}
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Sejarah Kami</h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed text-center">
                {!! nl2br(e($settings['church_history'] ?? 'Konten Sejarah belum tersedia.')) !!}
            </div>
        </div>

    </div>
@endsection
