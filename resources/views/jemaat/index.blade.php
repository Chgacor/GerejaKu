@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Data Jemaat</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.jemaat.cards') }}"
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                        Card View
                    </a>
                    <a href="{{ route('admin.jemaat.create') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                        Create New
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.jemaat.index') }}" method="GET" class="mt-4">
                <div class="flex space-x-4">
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari data jemaat..."
                        value="{{ request('search') }}"
                        class="w-full px-4 py-2 border rounded-lg">

                    <button type="submit"
                            class="bg-gray-800 text-white font-bold py-2 px-4 rounded-lg hover:bg-gray-700">Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-sm text-gray-600 mt-4">
        Menampilkan {{ $jemaats->firstItem() }} - {{ $jemaats->lastItem() }} dari total {{ $jemaats->total() }} data.
    </div>

    <table class="min-w-full bg-white">
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
        <tr>
            <th class="py-3 px-6 text-left">Nama Lengkap</th>
            <th class="py-3 px-6 text-left">Kelamin</th>
            <th class="py-3 px-6 text-left">No Telepon</th>
            <th class="py-3 px-6 text-left">Alamat</th>
            <th class="py-3 px-6 text-center">Actions</th>
        </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
        @foreach($jemaats as $data)
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $data->nama_lengkap }}</td>
                <td class="py-3 px-6 text-left">{{ $data->kelamin }}</td>
                <td class="py-3 px-6 text-left">{{ $data->no_telepon }}</td>
                <td class="py-3 px-6 text-left">{{ Str::limit($data->alamat, 35) }}</td>
                <td class="py-3 px-6 text-center">
                    <div class="flex item-center justify-center">
                        <a href="{{ route('admin.jemaat.show', $data->id) }}"
                           class="w-4 mr-4 transform hover:text-blue-500 hover:scale-110" title="View Details">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.jemaat.edit', $data->id) }}"
                           class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.jemaat.destroy', $data->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                                    title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-6">
        {{ $jemaats->appends(request()->query())->links() }}
    </div>
@endsection
