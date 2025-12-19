@extends('layouts.app')

@section('content')
    <div class="bg-gray-50 min-h-screen">
        {{-- HERO SECTION --}}
        <div class="relative h-[400px] md:h-[500px] overflow-hidden">
            @if(isset($settings['about_image']) && $settings['about_image'])
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $settings['about_image']) }}" alt="Tentang Kami">
            @else
                <div class="w-full h-full bg-gradient-to-r from-blue-900 to-blue-700"></div>
            @endif
            {{-- Overlay Gradasi agar Teks Terbaca --}}
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <div class="text-center px-4">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight drop-shadow-lg">
                        Tentang Kami
                    </h1>
                    <p class="mt-4 text-blue-100 text-lg md:text-xl max-w-2xl mx-auto font-light italic">
                        "Melayani dengan kasih, bertumbuh dalam iman."
                    </p>
                </div>
            </div>
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 pb-20">

            {{-- SECTION VISI & MISI (Grid Layout) --}}
            <div class="grid md:grid-cols-2 gap-8 mb-16">
                {{-- VISI --}}
                <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl border-t-4 border-blue-600 transition-transform hover:-translate-y-1 duration-300">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Visi Kami</h2>
                    <div class="prose prose-blue text-gray-600 leading-relaxed italic text-lg">
                        "{!! nl2br(e($settings['church_vision'] ?? 'Konten Visi belum tersedia.')) !!}"
                    </div>
                </div>

                {{-- MISI --}}
                <div class="bg-white p-8 md:p-12 rounded-2xl shadow-xl border-t-4 border-blue-400 transition-transform hover:-translate-y-1 duration-300">
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Misi Kami</h2>
                    <div class="prose prose-blue text-gray-600 leading-relaxed">
                        {!! nl2br(e($settings['church_mission'] ?? 'Konten Misi belum tersedia.')) !!}
                    </div>
                </div>
            </div>

            {{-- SECTION SEJARAH --}}
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100 flex flex-col md:flex-row">
                {{-- Dekorasi Samping dengan Gambar Background --}}
                <div class="md:w-1/3 relative p-12 text-white flex flex-col justify-center overflow-hidden">
                    {{-- Gambar Background (Sama dengan Hero) --}}
                    @if(isset($settings['about_image']) && $settings['about_image'])
                        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('storage/' . $settings['about_image']) }}" alt="Sejarah Gereja">
                        {{-- Overlay Biru agar Teks Terbaca --}}
                        <div class="absolute inset-0 bg-blue-900/80 mix-blend-multiply"></div>
                    @else
                        <div class="absolute inset-0 bg-blue-700"></div>
                    @endif

                    {{-- Konten Teks (Diberi relative z-10 agar di atas gambar) --}}
                    <div class="relative z-10">
                        <h2 class="text-4xl font-bold mb-4">Sejarah Singkat</h2>
                        <div class="w-20 h-1.5 bg-blue-400 rounded-full mb-6"></div>
                        <p class="text-blue-100 font-light leading-relaxed">
                            Mengenang perjalanan iman dan penyertaan Tuhan bagi GKKB Serdam dari masa ke masa.
                        </p>
                    </div>
                </div>

                {{-- Isi Sejarah --}}
                <div class="md:w-2/3 p-8 md:p-16">
                    <div class="prose prose-lg max-w-none text-gray-700 leading-loose">
                        {!! nl2br(e($settings['church_history'] ?? 'Konten Sejarah belum tersedia.')) !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
