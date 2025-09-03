@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800">Detail Profil Jemaat</h1>
            <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline">&larr; Kembali</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1 flex flex-col items-center">
                <img class="h-48 w-48 object-cover rounded-full shadow-lg mb-4"
                     src="{{ $jemaat->foto_profil ? asset('storage/' . $jemaat->foto_profil) : 'https://via.placeholder.com/150' }}"
                     alt="Foto {{ $jemaat->nama_lengkap }}">
                <a href="{{ route('jemaat.edit', $jemaat->id) }}"
                   class="mt-4 w-full text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">
                    Edit Data
                </a>
            </div>

            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Nama Lengkap</label>
                    <p class="text-lg text-gray-900">{{ $jemaat->nama_lengkap }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Jenis Kelamin</label>
                    <p class="text-lg text-gray-900">{{ $jemaat->kelamin }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Tempat & Tanggal Lahir</label>
                    <p class="text-lg text-gray-900">{{ $jemaat->tempat_lahir }}
                        , {{ \Carbon\Carbon::parse($jemaat->tanggal_lahir)->isoFormat('D MMMM Y') }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Nomor Telepon</label>
                    <p class="text-lg text-gray-900">{{ $jemaat->no_telepon }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Alamat</label>
                    <p class="text-lg text-gray-900 leading-relaxed">{{ $jemaat->alamat }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
