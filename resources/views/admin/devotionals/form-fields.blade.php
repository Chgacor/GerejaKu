@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p class="font-bold">Terjadi Kesalahan</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4">
    <div>
        <label for="title" class="block text-gray-700 font-semibold">Judul Renungan</label>
        <input type="text" id="title" name="title" value="{{ old('title', $devotional->title ?? '') }}" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div>
        <label for="image" class="block text-gray-700 font-semibold">Gambar Utama</label>
        <input type="file" id="image" name="image" class="w-full mt-1 p-2 border rounded-lg">
        @if(isset($devotional) && $devotional->image)
            <img src="{{ asset('storage/' . $devotional->image) }}" alt="Gambar saat ini" class="mt-4 h-32 object-cover">
        @endif
    </div>
    <div>
        <label for="scripture_reference" class="block text-gray-700 font-semibold">Referensi Alkitab</label>
        <input type="text" id="scripture_reference" name="scripture_reference" value="{{ old('scripture_reference', $devotional->scripture_reference ?? '') }}" placeholder="Contoh: Yohanes 3:16" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div>
        <label for="content" class="block text-gray-700 font-semibold">Isi Renungan</label>
        <textarea id="content" name="content" rows="10" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('content', $devotional->content ?? '') }}</textarea>
    </div>
</div>
