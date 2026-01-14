@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">

        {{-- BAGIAN HEADER: JUDUL & PENCARIAN --}}
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Manajemen Komisi</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola data komisi dan ketua komisi di sini.</p>
                </div>

                <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('admin.commissions.index') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                        <div class="relative w-full md:w-64">
                            <input type="text" name="search" placeholder="Cari nama komisi..." value="{{ request('search') }}"
                                   class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

                            @if(request('search'))
                                <a href="{{ route('admin.commissions.index') }}" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
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
                    <a href="{{ route('admin.commissions.create') }}"
                       class="flex-shrink-0 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-md flex items-center justify-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Komisi
                    </a>
                </div>
            </div>
        </div>

        {{-- INFO JUMLAH DATA --}}
        <div class="text-sm text-gray-500 mb-4 px-1 flex justify-between items-center">
            @if($commissions->count() > 0)
                <span>Menampilkan {{ $commissions->firstItem() }} - {{ $commissions->lastItem() }} dari <strong>{{ $commissions->total() }}</strong> komisi.</span>
            @else
                <span class="text-red-500 italic">Data tidak ditemukan.</span>
            @endif
        </div>

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Nama Komisi</th>
                    <th class="py-3 px-6 text-left">Ketua Komisi</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse ($commissions as $commission)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">

                        {{-- Nama Komisi --}}
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="mr-3">
                                    {{-- Ikon Avatar Inisial --}}
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                        {{ substr($commission->name, 0, 1) }}
                                    </div>
                                </div>
                                <span class="font-bold text-gray-800">{{ $commission->name }}</span>
                            </div>
                        </td>

                        {{-- Ketua --}}
                        <td class="py-3 px-6 text-left">
                            @if($commission->head_of_commission)
                                <span class="text-gray-700 font-medium">{{ $commission->head_of_commission }}</span>
                            @else
                                <span class="text-gray-400 italic text-xs">Belum ditentukan</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-3">

                                {{-- Tombol Kelola Artikel (Opsional) --}}
                                {{-- Nanti arahkan ke route artikel komisi --}}
{{--                                <a href="#"--}}
{{--                                   class="text-green-500 hover:text-green-700 transition transform hover:scale-110"--}}
{{--                                   title="Kelola Artikel Komisi ini">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">--}}
{{--                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />--}}
{{--                                    </svg>--}}
{{--                                </a>--}}

                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.commissions.edit', $commission) }}"
                                   class="text-yellow-500 hover:text-yellow-700 transition transform hover:scale-110"
                                   title="Edit Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Tombol Hapus (SweetAlert) --}}
                                <form id="delete-form-{{ $commission->id }}" action="{{ route('admin.commissions.destroy', $commission) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="confirmAction(event, 'delete-form-{{ $commission->id }}', 'Hapus Komisi {{ $commission->name }}?', 'Semua data terkait komisi ini mungkin ikut terhapus!', 'Ya, Hapus!', '#ef4444')"
                                            class="text-red-500 hover:text-red-700 transition transform hover:scale-110"
                                            title="Hapus Komisi">
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
                        <td colspan="3" class="py-8 text-center text-gray-500 bg-gray-50 italic">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p>Belum ada data komisi. Silakan tambah baru.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($commissions->hasPages())
            <div class="mt-6">
                {{ $commissions->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
