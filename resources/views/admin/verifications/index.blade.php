@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Verifikasi & Manajemen User</h2>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded-r relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Alert Warning --}}
        @if(session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 shadow-sm rounded-r relative" role="alert">
                <span class="block sm:inline">{{ session('warning') }}</span>
            </div>
        @endif

        {{-- Alert Error --}}
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded-r relative" role="alert">
                <span class="block sm:inline font-bold">Error:</span>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama / Email</th>
                        <th class="px-5 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Koneksi Data</th>
                        <th class="px-5 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal Daftar</th>
                        <th class="px-5 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-150 border-b border-gray-200">

                            {{-- Nama & Email --}}
                            <td class="px-5 py-4 bg-white text-sm">
                                <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                <div class="text-gray-500 text-xs">{{ $user->email }}</div>
                            </td>

                            {{-- Role --}}
                            <td class="px-5 py-4 bg-white text-sm text-center">
                            <span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full text-xs uppercase">
                                {{ $user->role }}
                            </span>
                            </td>

                            {{-- STATUS (Badge Aktif/Pending) --}}
                            <td class="px-5 py-4 bg-white text-sm text-center">
                                @if($user->is_approved)
                                    <span class="px-2 py-1 font-bold leading-tight text-green-700 bg-green-100 rounded-full text-xs">
                                    ✔ AKTIF
                                </span>
                                @else
                                    <span class="px-2 py-1 font-bold leading-tight text-red-700 bg-red-100 rounded-full text-xs">
                                    ⏳ PENDING
                                </span>
                                @endif
                            </td>

                            {{-- Indikator Koneksi Data Jemaat (Untuk debug password) --}}
                            <td class="px-5 py-4 bg-white text-sm text-center">
                                @if($user->jemaat)
                                    <div class="text-green-600 font-bold text-xs">✔ Terhubung</div>
                                    <div class="text-gray-400 text-[10px]">
                                        Lahir: {{ $user->jemaat->tanggal_lahir ? \Carbon\Carbon::parse($user->jemaat->tanggal_lahir)->format('d-m-Y') : 'KOSONG' }}
                                    </div>
                                @else
                                    <div class="text-red-500 font-bold text-xs">❌ Putus</div>
                                    <div class="text-gray-400 text-[10px]">Tidak ada data jemaat</div>
                                @endif
                            </td>

                            {{-- Tanggal Daftar --}}
                            <td class="px-5 py-4 bg-white text-sm text-center text-gray-600">
                                {{ $user->created_at->format('d M Y') }}
                            </td>

                            {{-- AKSI (Tombol Berubah) --}}
                            <td class="px-5 py-4 bg-white text-sm text-center">
                                <div class="flex items-center justify-center space-x-2">

                                    {{-- Tombol Toggle Status --}}
                                    <form action="{{ route('admin.verifications.toggle', $user->id) }}" method="POST">
                                        @csrf
                                        @if($user->is_approved)
                                            {{-- Jika Aktif -> Tombol Batalkan/Nonaktifkan --}}
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-xs transition shadow" onclick="return confirm('Nonaktifkan user ini? Dia tidak akan bisa login lagi.')">
                                                 Batalkan
                                            </button>
                                        @else
                                            {{-- Jika Pending -> Tombol Terima --}}
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs transition shadow" onclick="return confirm('Terima user ini?')">
                                                 Terima
                                            </button>
                                        @endif
                                    </form>

                                    {{-- Tombol Reset Pass --}}
                                    <form action="{{ route('admin.verifications.password_reset', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-1 px-3 rounded text-xs transition shadow" onclick="return confirm('Reset password berdasarkan tanggal lahir?')">
                                             Reset
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
