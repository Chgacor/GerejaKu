@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                {{-- JUDUL DINAMIS: Cek apakah ada komisi yang aktif --}}
                @if($commission)
                    Tulis Artikel Baru untuk: <span class="text-blue-600">{{ $commission->name }}</span>
                @else
                    Tulis Artikel Baru
                @endif
            </h1>
        </div>

        {{-- FORM ACTION DINAMIS: Mengarah ke rute yang benar tergantung konteks --}}
        <form action="{{ $commission ? route('admin.commissions.articles.store', $commission) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Mengirim variabel yang dibutuhkan ke form-fields --}}
            @include('admin.articles.form-fields', [
                'article' => $article,
                'commission' => $commission,
                'commissions' => $commissions ?? null
            ])

            <div class="mt-8 flex justify-end space-x-3">
                {{-- Tombol kembali yang cerdas, akan kembali ke halaman sebelumnya --}}
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan Artikel
                </button>
            </div>
        </form>
    </div>
@endsection

