@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">

        {{-- HEADER & TOMBOL TAMBAH --}}
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Renungan (Devosi)</h1>

                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <a href="{{ route('admin.devotionals.create') }}"
                       class="flex-1 md:flex-none text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-md flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Buat Renungan Baru
                    </a>
                </div>
            </div>

            {{-- FORM PENCARIAN (Opsional, tapi biar konsisten) --}}
            <form action="{{ route('admin.devotionals.index') }}" method="GET">
                <div class="flex gap-2">
                    <input type="text" name="search" placeholder="Cari judul renungan..." value="{{ request('search') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <button type="submit" class="bg-gray-800 text-white p-2 rounded-lg hover:bg-gray-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.devotionals.index') }}" class="bg-red-100 text-red-500 border border-red-200 p-2 rounded-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center" title="Reset Filter">✕</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- INFO JUMLAH DATA --}}
        <div class="text-sm text-gray-500 mb-4 px-1">
            @if($devotionals->count() > 0)
                Menampilkan {{ $devotionals->firstItem() }} - {{ $devotionals->lastItem() }} dari <strong>{{ $devotionals->total() }}</strong> renungan.
            @else
                <span class="text-red-500">Tidak ada renungan ditemukan.</span>
            @endif
        </div>

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Judul Renungan</th>
                    <th class="py-3 px-6 text-left">Referensi Alkitab</th>
                    <th class="py-3 px-6 text-left">Tanggal Posting</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse($devotionals as $devotional)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">

                        {{-- Judul --}}
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <span class="font-medium text-gray-800">{{ $devotional->title }}</span>
                        </td>

                        {{-- Referensi --}}
                        <td class="py-3 px-6 text-left">
                            <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-semibold border border-blue-200">
                                {{ $devotional->scripture_reference }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="py-3 px-6 text-left">
                            {{ $devotional->created_at->format('d M Y') }}
                            <span class="text-xs text-gray-400 block">{{ $devotional->created_at->diffForHumans() }}</span>
                        </td>

                        {{-- Aksi --}}
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-2">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.devotionals.edit', $devotional->id) }}" class="p-1 text-yellow-500 hover:text-yellow-700 transition" title="Edit Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Tombol Hapus (Pakai SweetAlert confirmAction) --}}
                                <form id="delete-form-{{ $devotional->id }}" action="{{ route('admin.devotionals.destroy', $devotional->id) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="confirmAction(event, 'delete-form-{{ $devotional->id }}', 'Hapus Renungan?', 'Data yang dihapus tidak dapat dikembalikan!', 'Ya, Hapus!', '#ef4444')"
                                            class="p-1 text-red-500 hover:text-red-700 transition"
                                            title="Hapus Data">
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
                        <td colspan="4" class="py-8 text-center text-gray-500 bg-gray-50 italic">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p>Belum ada renungan yang dibuat.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $devotionals->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
