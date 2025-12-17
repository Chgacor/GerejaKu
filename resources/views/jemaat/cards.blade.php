@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Profil Jemaat (Card View)</h1>
        <a href="{{ route('admin.jemaat.index') }}"
           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
            Lihat Tampilan Tabel
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($jemaats as $jemaat)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        {{-- PERBAIKAN: Gunakan variabel $jemaat dan nama kolom baru (profile_picture) --}}
                        @if ($jemaat->profile_picture)
                            <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200"
                                 src="{{ asset('storage/' . $jemaat->profile_picture) }}"
                                 alt="{{ $jemaat->full_name }}">
                        @else
                            {{-- Fallback: Tampilkan inisial dari nama jemaat --}}
                            <div class="h-12 w-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold text-lg">
                                {{ Str::upper(Str::substr($jemaat->full_name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            {{-- PERBAIKAN: Gunakan full_name dan phone_number --}}
                            <h2 class="text-lg font-bold text-gray-900 truncate" title="{{ $jemaat->full_name }}">
                                {{ $jemaat->full_name }}
                            </h2>
                            <p class="text-sm text-gray-600 truncate">{{ $jemaat->phone_number }}</p>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2">
                        <p class="text-gray-700 text-sm">
                            <span class="font-semibold text-gray-900">Lahir:</span>
                            {{-- PERBAIKAN: Gunakan birth_place dan birth_date --}}
                            {{ $jemaat->birth_place }}, {{ \Carbon\Carbon::parse($jemaat->birth_date)->isoFormat('D MMM Y') }}
                        </p>
                        <p class="text-gray-700 text-sm line-clamp-2" title="{{ $jemaat->address }}">
                            <span class="font-semibold text-gray-900">Alamat:</span>
                            {{-- PERBAIKAN: Gunakan address --}}
                            {{ $jemaat->address }}
                        </p>
                    </div>

                    <div class="mt-6 flex justify-end space-x-2">
                        <a href="{{ route('admin.jemaat.show', $jemaat->id) }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                            Detail
                        </a>
                        <a href="{{ route('admin.jemaat.edit', $jemaat->id) }}"
                           class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-300 transition">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-10">
                <p class="text-gray-500 text-lg">Belum ada data jemaat.</p>
                <a href="{{ route('admin.jemaat.create') }}" class="text-blue-500 hover:underline mt-2 inline-block">Tambah Data Baru</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $jemaats->appends(request()->query())->links() }}
    </div>
@endsection
