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
                    <th class="py-3 px-6 text-left">Subjek</th>
                    <th class="py-3 px-6 text-left">Penanya</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                @forelse($qnas as $qna)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left font-semibold">{{ Str::limit($qna->subject, 40) }}</td>
                        <td class="py-3 px-6 text-left">{{ $qna->name }}</td>
                        <td class="py-3 px-6 text-center">
                            @if($qna->answer)
                                <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Dijawab</span>
                            @else
                                <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Baru</span>
                            @endif
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('admin.qna.edit', $qna) }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg text-xs font-bold hover:bg-blue-600 transition-colors duration-300">
                                Jawab
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-6">Belum ada pertanyaan yang masuk.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
