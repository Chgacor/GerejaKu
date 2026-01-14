@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">

        {{-- BAGIAN HEADER: JUDUL & PENCARIAN --}}
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Manajemen Acara</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola agenda, kegiatan khusus, dan latihan rutin gereja.</p>
                </div>

                <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">

                    {{-- Form Pencarian --}}
                    <form action="{{ route('admin.events.index') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                        <div class="relative w-full md:w-64">
                            <input type="text" name="search" placeholder="Cari nama acara..." value="{{ request('search') }}"
                                   class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

                            @if(request('search'))
                                <a href="{{ route('admin.events.index') }}" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                </a>
                            @else
                                <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </button>
                            @endif
                        </div>
                    </form>

                    {{-- Tombol Tambah --}}
                    <a href="{{ route('admin.events.create') }}"
                       class="flex-shrink-0 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-md flex items-center justify-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Acara Baru
                    </a>
                </div>
            </div>
        </div>

        {{-- INFO JUMLAH DATA --}}
        <div class="text-sm text-gray-500 mb-4 px-1 flex justify-between items-center">
            @if($events->count() > 0)
                <span>Menampilkan {{ $events->firstItem() }} - {{ $events->lastItem() }} dari <strong>{{ $events->total() }}</strong> acara.</span>
            @else
                <span class="text-red-500 italic">Tidak ada acara ditemukan.</span>
            @endif
        </div>

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Nama Acara</th>
                    <th class="py-3 px-6 text-left">Waktu Mulai</th>
                    <th class="py-3 px-6 text-left">Waktu Selesai</th>
                    <th class="py-3 px-6 text-center">Status Pin</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse($events as $event)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">

                        {{-- Nama Acara --}}
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-800">{{ $event->title }}</span>
                                <span class="text-xs text-gray-500">{{ $event->type ?? 'Acara Umum' }}</span>
                            </div>
                        </td>

                        {{-- Waktu Mulai --}}
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <span>{{ $event->start_time->format('d M Y, H:i') }}</span>
                            </div>
                        </td>

                        {{-- Waktu Selesai --}}
                        <td class="py-3 px-6 text-left">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>{{ $event->end_time->format('d M Y, H:i') }}</span>
                            </div>
                        </td>

                        {{-- Status Pin (Featured) --}}
                        <td class="py-3 px-6 text-center">
                            @if($event->is_featured)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Dipin
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-3">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.events.edit', $event->id) }}"
                                   class="text-yellow-500 hover:text-yellow-700 transition transform hover:scale-110"
                                   title="Edit Acara">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Tombol Hapus (SweetAlert) --}}
                                <form id="delete-form-{{ $event->id }}" action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="confirmAction(event, 'delete-form-{{ $event->id }}', 'Hapus Acara Ini?', 'Data yang dihapus tidak dapat dikembalikan!', 'Ya, Hapus!', '#ef4444')"
                                            class="text-red-500 hover:text-red-700 transition transform hover:scale-110"
                                            title="Hapus Acara">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                                <p>Belum ada acara yang dibuat.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-6">
            {{ $events->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
