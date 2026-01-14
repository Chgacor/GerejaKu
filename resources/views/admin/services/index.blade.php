@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">

        {{-- HEADER & PENCARIAN --}}
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Jadwal Ibadah</h1>

                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <a href="{{ route('admin.services.create') }}"
                       class="flex-1 md:flex-none text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-md flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Jadwal
                    </a>
                </div>
            </div>

            {{-- FORM FILTER / SEARCH --}}
            <form action="{{ route('admin.services.index') }}" method="GET">
                <div class="flex gap-2">
                    <input type="text" name="search" placeholder="Cari tema, pembicara, atau divisi..." value="{{ request('search') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <button type="submit" class="bg-gray-800 text-white p-2 rounded-lg hover:bg-gray-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.services.index') }}" class="bg-red-100 text-red-500 border border-red-200 p-2 rounded-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center" title="Reset Filter">✕</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- INFO JUMLAH DATA --}}
        <div class="text-sm text-gray-500 mb-4 px-1">
            @if($services->count() > 0)
                Menampilkan {{ $services->firstItem() }} - {{ $services->lastItem() }} dari <strong>{{ $services->total() }}</strong> jadwal.
            @else
                <span class="text-red-500">Tidak ada jadwal ibadah ditemukan.</span>
            @endif
        </div>

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Tema / Judul</th>
                    <th class="py-3 px-6 text-left">Pembicara</th>
                    <th class="py-3 px-6 text-left">Waktu Ibadah</th>
                    <th class="py-3 px-6 text-left">Divisi</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse($services as $service)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">

                        {{-- Tema --}}
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <span class="font-bold text-gray-800">{{ $service->title }}</span>
                        </td>

                        {{-- Pembicara --}}
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                {{ $service->speaker }}
                            </div>
                        </td>

                        {{-- Waktu --}}
                        <td class="py-3 px-6 text-left">
                            <div class="flex flex-col">
                                <span class="text-gray-800 font-medium">{{ $service->service_time->format('d M Y') }}</span>
                                <span class="text-xs text-blue-500 font-semibold">{{ $service->service_time->format('H:i') }} WIB</span>
                            </div>
                        </td>

                        {{-- Divisi --}}
                        <td class="py-3 px-6 text-left">
                            <span class="bg-gray-100 text-gray-700 border border-gray-200 py-1 px-3 rounded-full text-xs font-semibold">
                                {{ $service->division->name ?? 'Umum' }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-2">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="p-1 text-yellow-500 hover:text-yellow-700 transition" title="Edit Jadwal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Tombol Hapus (SweetAlert) --}}
                                <form id="delete-form-{{ $service->id }}" action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="confirmAction(event, 'delete-form-{{ $service->id }}', 'Hapus Jadwal?', 'Data yang dihapus tidak dapat dikembalikan!', 'Ya, Hapus!', '#ef4444')"
                                            class="p-1 text-red-500 hover:text-red-700 transition"
                                            title="Hapus Jadwal">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500 bg-gray-50 italic">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p>Belum ada jadwal ibadah yang dibuat.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $services->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
