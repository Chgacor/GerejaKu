@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <div>
                {{-- PERBAIKAN 1: Hapus nesting H1 yang salah --}}
                <h1 class="text-2xl font-bold text-gray-800">
                    @if(isset($commission) && $commission)
                        Artikel Komisi: <span class="text-blue-600">{{ $commission->name }}</span>
                    @else
                        Semua Artikel Komisi
                    @endif
                </h1>
            </div>

            {{-- PERBAIKAN 2: Route yang benar untuk Nested Resource --}}
            @if(isset($commission) && $commission)
                <a href="{{ route('admin.commissions.articles.create', $commission) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Tulis Artikel Baru
                </a>
            @else
                {{-- Mengarah ke /admin/articles/create (Global) --}}
                <a href="{{ route('admin.articles.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Tulis Artikel Baru
                </a>
            @endif
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
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
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left font-semibold">
                            {{ $article->title }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{-- Optional digunakan agar tidak error jika artikel dibuat tanpa komisi (Global) --}}
                            @if($article->commission)
                                <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">
                                    {{ $article->commission->name }}
                                </span>
                            @else
                                <span class="bg-gray-200 text-gray-700 py-1 px-3 rounded-full text-xs">
                                    Umum / Global
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-left">{{ $article->category }}</td>
                        <td class="py-3 px-6 text-left">
                            @if($article->published_at)
                                {{ \Carbon\Carbon::parse($article->published_at)->format('d M Y') }}
                            @else
                                <span class="text-yellow-600 italic">Draft</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                {{-- Route shallow (admin.articles.edit) sudah benar --}}
                                <a href="{{ route('admin.articles.edit', $article) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                </a>

                                {{-- Route shallow (admin.articles.destroy) sudah benar --}}
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.036-2.134H8.718c-1.126 0-2.037.955-2.037 2.134v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">Belum ada artikel untuk ditampilkan.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
