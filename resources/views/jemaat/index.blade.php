@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">
        <div class="mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Data Jemaat</h1>

                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <a href="{{ route('admin.jemaat.cards') }}"
                       class="flex-1 md:flex-none text-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        Card View
                    </a>
                    <a href="{{ route('admin.jemaat.create') }}"
                       class="flex-1 md:flex-none text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                        + Tambah
                    </a>
                </div>
            </div>

            {{-- FORM FILTER --}}
            {{-- Menggunakan Grid System agar rapi di semua device --}}
            <form action="{{ route('admin.jemaat.index') }}" method="GET">
                <div class="grid grid-cols-2 md:grid-cols-12 gap-4">

                    {{-- Filter Kategori: Full width di HP, 3 kolom di Laptop --}}
                    <div class="col-span-2 md:col-span-3">
                        <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 bg-white" onchange="this.form.submit()">
                            <option value="">Semua Kategori Umur</option>
                            <option value="sekolah_minggu" {{ request('kategori') == 'sekolah_minggu' ? 'selected' : '' }}>Sekolah Minggu (1-11)</option>
                            <option value="remaja" {{ request('kategori') == 'remaja' ? 'selected' : '' }}>Tunas & Remaja (12-18)</option>
                            <option value="dewasa" {{ request('kategori') == 'dewasa' ? 'selected' : '' }}>Dewasa (19-59)</option>
                            <option value="lansia" {{ request('kategori') == 'lansia' ? 'selected' : '' }}>Usia Indah (60+)</option>
                        </select>
                    </div>

                    {{-- Filter Bulan: Setengah lebar di HP, 2 kolom di Laptop --}}
                    <div class="col-span-1 md:col-span-2">
                        <select name="bulan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 bg-white" onchange="this.form.submit()">
                            <option value="">Bulan Lahir</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Tahun: Setengah lebar di HP, 2 kolom di Laptop --}}
                    <div class="col-span-1 md:col-span-2">
                        <input type="number" name="tahun" placeholder="Thn Lahir" value="{{ request('tahun') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Search Text: Full width di HP, Sisa kolom di Laptop --}}
                    <div class="col-span-2 md:col-span-5 flex gap-2">
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari nama / alamat..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <button type="submit" class="bg-gray-800 text-white p-2 rounded-lg hover:bg-gray-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>

                        {{-- Tombol Reset (Muncul jika ada filter aktif) --}}
                        @if(request()->anyFilled(['search', 'kategori', 'bulan', 'tahun']))
                            <a href="{{ route('admin.jemaat.index') }}"
                               class="bg-red-100 text-red-500 border border-red-200 p-2 rounded-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center" title="Reset Filter">
                                ✕
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Info Jumlah Data --}}
        <div class="text-sm text-gray-500 mb-4 px-1">
            @if($jemaats->count() > 0)
                Menampilkan {{ $jemaats->firstItem() }} - {{ $jemaats->lastItem() }} dari <strong>{{ $jemaats->total() }}</strong> jemaat.
            @else
                <span class="text-red-500">Tidak ada data ditemukan.</span>
            @endif
        </div>

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">Nama Jemaat</th>
                    <th class="py-3 px-6 text-left">Kategori</th>
                    <th class="py-3 px-6 text-left">Umur</th>
                    <th class="py-3 px-6 text-left hidden md:table-cell">No Telepon</th> {{-- Sembunyikan di HP kecil --}}
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse($jemaats as $data)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <div class="flex items-center">
                                {{-- Jika ada foto profil, tampilkan (Opsional) --}}
                                @if($data->profile_picture)
                                    <img class="w-8 h-8 rounded-full mr-2 object-cover" src="{{ Storage::url($data->profile_picture) }}" alt="Avatar">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gray-200 mr-2 flex items-center justify-center text-xs text-gray-500">
                                        {{ substr($data->full_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <span class="font-medium text-gray-800">{{ $data->full_name }}</span>
                                    <div class="text-xs text-gray-400 block md:hidden">{{ $data->phone_number }}</div> {{-- Tampil di HP --}}
                                </div>
                            </div>
                        </td>

                        <td class="py-3 px-6 text-left">
                            @php
                                $cat = $data->kategori_umur;
                                $badgeClass = match($cat) {
                                    'Sekolah Minggu' => 'bg-green-100 text-green-700 border-green-200',
                                    'Tunas & Remaja' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'Dewasa'         => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    'Usia Indah'     => 'bg-purple-100 text-purple-700 border-purple-200',
                                    default          => 'bg-gray-100 text-gray-700 border-gray-200',
                                };
                            @endphp
                            <span class="{{ $badgeClass }} border px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap">
                                {{ $cat }}
                            </span>
                        </td>

                        <td class="py-3 px-6 text-left">
                            <span class="font-bold text-gray-700">{{ $data->age }}</span> Thn
                        </td>

                        <td class="py-3 px-6 text-left hidden md:table-cell">
                            {{ $data->phone_number }}
                        </td>

                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center space-x-2">
                                <a href="{{ route('admin.jemaat.show', $data->id) }}" class="p-1 text-blue-500 hover:text-blue-700 transition" title="Lihat">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                                <a href="{{ route('admin.jemaat.edit', $data->id) }}" class="p-1 text-yellow-500 hover:text-yellow-700 transition" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('admin.jemaat.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1 text-red-500 hover:text-red-700 transition" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500 bg-gray-50 italic">
                            Belum ada data jemaat yang sesuai filter.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $jemaats->appends(request()->query())->links() }}
        </div>
    </div>
@endsection
