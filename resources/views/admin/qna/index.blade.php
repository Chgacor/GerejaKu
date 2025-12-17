@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Tanya Jawab (QnA)</h1>
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
                    <th class="py-3 px-6 text-left">Tanggal</th>
                    <th class="py-3 px-6 text-left">Subjek</th>
                    <th class="py-3 px-6 text-left">Penanya</th>
                    <th class="py-3 px-6 text-center">Kontak (WA)</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse($qnas as $qna)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $qna->created_at->format('d M Y') }}
                        </td>
                        <td class="py-3 px-6 text-left font-semibold">
                            {{ Str::limit($qna->subject, 30) }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex flex-col">
                                <span class="font-bold">{{ $qna->name }}</span>
                                <span class="text-xs text-gray-500">{{ $qna->email }}</span>
                            </div>
                        </td>

                        {{-- TOMBOL WHATSAPP --}}
                        <td class="py-3 px-6 text-center">
                            @if($qna->phone)
                                @php
                                    // Ubah format 08xx jadi 628xx
                                    $hp = $qna->phone;
                                    if(substr($hp, 0, 1) == '0') {
                                        $hp = '62' . substr($hp, 1);
                                    }
                                    $pesan = "Halo {$qna->name}, mengenai pertanyaan Anda di GerejaKu tentang '{$qna->subject}'...";
                                @endphp
                                <a href="https://wa.me/{{ $hp }}?text={{ urlencode($pesan) }}" target="_blank" class="inline-flex items-center bg-green-500 text-white py-1 px-3 rounded text-xs font-bold hover:bg-green-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    Chat WA
                                </a>
                            @else
                                <span class="text-gray-400 text-xs italic">Tidak ada No HP</span>
                            @endif
                        </td>

                        <td class="py-3 px-6 text-center">
                            @if($qna->answer)
                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-semibold border border-green-200">Dijawab</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-semibold border border-yellow-200">Menunggu</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('admin.qna.edit', $qna) }}" class="bg-blue-600 text-white py-2 px-4 rounded-lg text-xs font-bold hover:bg-blue-700 shadow transition-colors duration-300">
                                Jawab
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-6 text-gray-500 italic">Belum ada pertanyaan yang masuk.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($qnas, 'links'))
            <div class="mt-4">
                {{ $qnas->links() }}
            </div>
        @endif
    </div>
@endsection
