@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Profil Jemaat (Card View)</h1>
        <a href="{{ route('admin.jemaat.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
            Lihat Tampilan Tabel
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($jemaats as $jemaat)
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        @if (Auth::user()->foto_profil)
                            <img class="h-8 w-8 rounded-full object-cover"
                                 src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                                 alt="{{ Auth::user()->nama_lengkap }}">
                        @else
                            <div
                                class="h-8 w-8 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">
                                {{ Str::substr(Auth::user()->nama_lengkap, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $jemaat->nama_lengkap }}</h2>
                            <p class="text-sm text-gray-600">{{ $jemaat->no_telepon }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-700"><span class="font-semibold">Lahir:</span> {{ $jemaat->tempat_lahir }}
                            , {{ \Carbon\Carbon::parse($jemaat->tanggal_lahir)->format('d M Y') }}</p>
                        <p class="text-gray-700"><span class="font-semibold">Alamat:</span> {{ $jemaat->alamat }}</p>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('admin.jemaat.edit', $jemaat->id) }}"
                           class="bg-black text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800">
                            View/Edit
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Belum ada data jemaat.</p>
        @endforelse
    </div>
@endsection
