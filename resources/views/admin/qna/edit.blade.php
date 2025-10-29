@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Jawab Pertanyaan</h1>

        <div class="mb-8 p-6 bg-gray-50 rounded-lg border">
            <p><strong>Dari:</strong> {{ $qna->name }} ({{ $qna->email }})</p>
            <p class="mt-1"><strong>Subjek:</strong> {{ $qna->subject }}</p>
            <blockquote class="mt-4 border-l-4 pl-4 text-lg text-gray-700 italic">
                "{{ $qna->question }}"
            </blockquote>
        </div>

        <form action="{{ route('admin.qna.update', $qna) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="answer" class="block font-semibold">Jawaban Anda</label>
                <textarea id="answer" name="answer" rows="10" class="w-full mt-1 p-2 border rounded-lg" required>{{ old('answer', $qna->answer) }}</textarea>
            </div>
            <div class="mt-4 flex items-center">
                <input type="checkbox" id="is_published" name="is_published" value="1" @checked(old('is_published', $qna->is_published))>
                <label for="is_published" class="ml-2">Publikasikan pertanyaan dan jawaban ini di Halaman Utama</label>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg">Simpan Jawaban</button>
            </div>
        </form>
    </div>
@endsection
