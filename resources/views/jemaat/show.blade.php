@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800">Detail Profil Jemaat</h1>
            <a href="{{ url()->previous() }}" class="text-blue-500 hover:underline">&larr; Kembali</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- BAGIAN FOTO PROFIL --}}
            <div class="md:col-span-1 flex flex-col items-center">
                {{-- PERBAIKAN 1: Gunakan kolom 'profile_picture' dan 'full_name' --}}
                @if($jemaat->profile_picture)
                    <img class="h-48 w-48 object-cover rounded-full shadow-lg mb-4 border-4 border-gray-200"
                         src="{{ asset('storage/' . $jemaat->profile_picture) }}"
                         alt="Foto {{ $jemaat->full_name }}">
                @else
                    {{-- Fallback jika tidak ada foto --}}
                    <div class="h-48 w-48 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-6xl shadow-lg mb-4 border-4 border-blue-200">
                        {{ Str::upper(Str::substr($jemaat->full_name, 0, 1)) }}
                    </div>
                @endif

                {{-- PERBAIKAN 2: Nama route yang benar adalah 'admin.jemaat.edit' --}}
                <a href="{{ route('admin.jemaat.edit', $jemaat->id) }}"
                   class="mt-4 w-full text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Edit Data
                </a>
            </div>

            {{-- BAGIAN DATA DIRI --}}
            <div class="md:col-span-2 space-y-4">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Nama Lengkap</label>
                    {{-- PERBAIKAN 3: Gunakan 'full_name' --}}
                    <p class="text-lg text-gray-900 font-medium">{{ $jemaat->full_name }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Jenis Kelamin</label>
                    {{-- PERBAIKAN 4: Gunakan 'gender' --}}
                    <p class="text-lg text-gray-900">{{ $jemaat->gender }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Tempat & Tanggal Lahir</label>
                    {{-- PERBAIKAN 5: Gunakan 'birth_place' dan 'birth_date' --}}
                    <p class="text-lg text-gray-900">
                        {{ $jemaat->birth_place }}, {{ \Carbon\Carbon::parse($jemaat->birth_date)->isoFormat('D MMMM Y') }}
                    </p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Nomor Telepon</label>
                    {{-- PERBAIKAN 6: Gunakan 'phone_number' --}}
                    <p class="text-lg text-gray-900">{{ $jemaat->phone_number }}</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-500">Alamat</label>
                    {{-- PERBAIKAN 7: Gunakan 'address' --}}
                    <p class="text-lg text-gray-900 leading-relaxed">{{ $jemaat->address }}</p>
                </div>

                {{-- Tambahan: Informasi Akun Login --}}
                @if($jemaat->user)
                    <div class="pt-4 mt-4 border-t border-gray-100">
                        <h3 class="text-md font-bold text-gray-800 mb-2">Informasi Akun</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold text-gray-500">Email Login</label>
                                <p class="text-gray-900">{{ $jemaat->user->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-500">Username</label>
                                <p class="text-gray-900">{{ $jemaat->user->name }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
