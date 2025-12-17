@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-10 px-4">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Profil Saya</h2>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- BAGIAN AKUN (Tabel Users) --}}
                    <div class="col-span-2">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Informasi Akun</h3>
                    </div>

                    <div>
                        <label class="block text-gray-700">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->name) }}"
                               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
                        @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- BAGIAN PROFIL (Tabel Jemaats) --}}
                    <div class="col-span-2 mt-4">
                        <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Data Pribadi</h3>
                    </div>

                    <div>
                        <label class="block text-gray-700">Nama Lengkap</label>
                        {{-- Perhatikan: Kita akses via $user->jemaat?->full_name (tanda ? untuk antisipasi jika null) --}}
                        <input type="text" name="full_name" value="{{ old('full_name', $user->jemaat?->full_name) }}"
                               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
                        @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">No Telepon / WA</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $user->jemaat?->phone_number) }}"
                               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
                        @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">Jenis Kelamin</label>
                        <select name="gender" class="w-full mt-1 p-2 border rounded-lg bg-white">
                            <option value="">Pilih...</option>
                            <option value="Laki-laki" {{ old('gender', $user->jemaat?->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $user->jemaat?->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">Tempat Lahir</label>
                        <input type="text" name="birth_place" value="{{ old('birth_place', $user->jemaat?->birth_place) }}"
                               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
                        @error('birth_place') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $user->jemaat?->birth_date) }}"
                               class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">
                        @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-gray-700">Alamat Lengkap</label>
                        <textarea name="address" rows="3" class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-300">{{ old('address', $user->jemaat?->address) }}</textarea>
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-gray-700 mb-2">Foto Profil</label>
                        @if($user->jemaat && $user->jemaat->profile_picture)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $user->jemaat->profile_picture) }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover border">
                            </div>
                        @endif
                        <input type="file" name="profile_picture" class="w-full p-2 border rounded-lg">
                        @error('profile_picture') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
