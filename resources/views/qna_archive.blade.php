@extends('layouts.app') {{-- Pastikan ini sesuai dengan layout Anda --}}

@section('content')
    <div class="bg-gray-50 py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">

                {{-- Judul Halaman --}}
                <div class="text-center border-b border-gray-200 pb-8 mb-12">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                        Arsip Tanya Jawab
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Semua pertanyaan yang telah dijawab dan dipublikasikan.
                    </p>
                </div>

                {{-- Daftar Q&A --}}
                <div class="space-y-8">
                    @forelse ($allQna as $qna)
                        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-md">
                            <p class="font-bold text-xl text-gray-900">
                                {{ $qna->question }}
                            </p>
                            <div class="mt-5 pt-5 border-t border-gray-100 text-gray-700 leading-relaxed">
                                {!! nl2br(e($qna->answer)) !!}
                            </div>
                            <div class="mt-4 text-sm text-gray-500">
                                Dijawab pada: {{ $qna->answered_at ? $qna->answered_at->format('d F Y') : 'N/A' }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-lg shadow-md">
                            <p class="text-gray-500">Belum ada pertanyaan yang dipublikasikan.</p>
                        </div>
                    @endforelse {{-- <--- INI SUDAH DIPERBAIKI --}}
                </div>

                {{-- Paginasi (Link Halaman) --}}
                <div classm="mt-12">
                    {{ $allQna->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
