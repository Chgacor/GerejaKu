@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">

        {{-- BAGIAN HEADER: JUDUL & PENCARIAN --}}
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        @if(isset($commission) && $commission)
                            Artikel Komisi: <span class="text-blue-600">{{ $commission->name }}</span>
                        @else
                            Semua Artikel Komisi
                        @endif
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola berita, kegiatan, dan artikel komisi di sini.</p>
                </div>

                <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">

                    {{-- Form Pencarian --}}
                    {{-- Logika: Jika sedang di halaman Komisi Tertentu, search tetap di situ --}}
                    @php
                        $searchAction = (isset($commission) && $commission)
                                        ? route('admin.commissions.articles.index', $commission->id)
                                        : route('admin.articles.index');
                    @endphp

                    <form action="{{ $searchAction }}" method="GET" class="flex gap-2 w-full md:w-auto">
                        <div class="relative w-full md:w-64">
                            <input type="text" name="search" placeholder="Cari judul artikel..." value="{{ request('search') }}"
                                   class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">

                            @if(request('search'))
                                <a href="{{ $searchAction }}" class="absolute right-2 top-2 text-gray-400 hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                                </a>
                            @else
                                <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </button>
                            @endif
                        </div>
                    </form>

                    {{-- Tombol Tulis Baru --}}
                    @if(isset($commission) && $commission)
                        <a href="{{ route('admin.commissions.articles.create', $commission) }}"
                           class="flex-shrink-0 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-md flex items-center justify-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                            Tulis Artikel Baru
                        </a>
                    @else
                        <a href="{{ route('admin.articles.create') }}"
                           class="flex-shrink-0 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition shadow-md flex items-center justify-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                            Tulis Artikel Baru
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- INFO JUMLAH DATA --}}
        <div class="text-sm text-gray-500 mb-4 px-1 flex justify-between items-center">
            @if($articles->count() > 0)
                <span>Menampilkan {{ $articles->firstItem() }} - {{ $articles->lastItem() }} dari <strong>{{ $articles->total() }}</strong> artikel.</span>
            @else
                <span class="text-red-500 italic">Tidak ada artikel ditemukan.</span>
            @endif
        </div>

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Judul Artikel</th>
                    <th class="py-3 px-6 text-left">Komisi</th>
                    <th class="py-3 px-6 text-left">Kategori</th>
                    <th class="py-3 px-6 text-left">Tgl Publikasi</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse($articles as $article)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">

                        {{-- Judul --}}
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <span class="font-bold text-gray-800">{{ $article->title }}</span>
                        </td>

                        {{-- Komisi --}}
                        <td class="py-3 px-6 text-left">
                            @if($article->commission)
                                <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold border border-blue-200">
                                    {{ $article->commission->name }}
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-600 py-1 px-3 rounded-full text-xs font-semibold border border-gray-200">
                                    Umum / Global
                                </span>
                            @endif
                        </td>

                        {{-- Kategori --}}
                        <td class="py-3 px-6 text-left">
                            <span class="text-gray-700">{{ $article->category }}</span>
                        </td>

                        {{-- Tgl Publikasi --}}
                        <td class="py-3 px-6 text-left">
                            @if($article->published_at)
                                <span class="text-gray-800">{{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}</span>
                                <span class="text-xs text-gray-400 block">{{ \Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 py-1 px-2 rounded text-xs font-bold border border-yellow-200">Draft</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-3">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.articles.edit', $article) }}" class="text-yellow-500 hover:text-yellow-700 transition transform hover:scale-110" title="Edit Artikel">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Tombol Hapus (SweetAlert) --}}
                                <form id="delete-form-{{ $article->id }}" action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="confirmAction(event, 'delete-form-{{ $article->id }}', 'Hapus Artikel?', 'Artikel yang dihapus tidak dapat dikembalikan!', 'Ya, Hapus!', '#ef4444')"
                                            class="text-red-500 hover:text-red-700 transition transform hover:scale-110"
                                            title="Hapus Artikel">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <p>Belum ada artikel yang dibuat.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $articles->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
