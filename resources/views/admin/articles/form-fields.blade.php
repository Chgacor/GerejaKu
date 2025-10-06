@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p class="font-bold">Terjadi Kesalahan</p>
        <ul class="list-disc list-inside mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4">
    {{-- Dropdown untuk memilih komisi (hanya tampil jika membuat dari menu utama) --}}
    @if(!$commission)
        <div>
            <label for="commission_id" class="block font-semibold">Pilih Komisi <span class="text-red-500">*</span></label>
            <select id="commission_id" name="commission_id" class="w-full mt-1 p-2 border rounded-lg bg-white @error('commission_id') border-red-500 @enderror" required>
                <option value="">-- Pilih salah satu komisi --</option>
                @if($commissions)
                    @foreach($commissions as $c)
                        <option value="{{ $c->id }}" @selected(old('commission_id', optional($article->commission)->id) == $c->id)>
                            {{ $c->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            {{-- Menampilkan error validasi spesifik untuk field ini --}}
            @error('commission_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div>
        <label for="title" class="block font-semibold">Judul Artikel <span class="text-red-500">*</span></label>
        <input type="text" id="title" name="title" value="{{ old('title', optional($article)->title) }}" class="w-full mt-1 p-2 border rounded-lg @error('title') border-red-500 @enderror" required>
        @error('title')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="category" class="block font-semibold">Kategori <span class="text-red-500">*</span></label>
        <select id="category" name="category" class="w-full mt-1 p-2 border rounded-lg bg-white @error('category') border-red-500 @enderror" required>
            <option value="Berita" @selected(old('category', optional($article)->category) == 'Berita')>Berita</option>
            <option value="Kegiatan" @selected(old('category', optional($article)->category) == 'Kegiatan')>Kegiatan</option>
            <option value="Pengetahuan" @selected(old('category', optional($article)->category) == 'Pengetahuan')>Pengetahuan</option>
            <option value="Doa & Rencana" @selected(old('category', optional($article)->category) == 'Doa & Rencana')>Doa & Rencana</option>
        </select>
        @error('category')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="cover_image" class="block font-semibold">Gambar Utama</label>
        <input type="file" id="cover_image" name="cover_image" class="w-full mt-1 p-2 border rounded-lg">
        @if(isset($article) && $article->cover_image)
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-2">Gambar saat ini:</p>
                <img src="{{ asset('storage/' . $article->cover_image) }}" alt="Gambar saat ini" class="max-h-48 object-cover rounded shadow-md">
            </div>
        @endif
        @error('cover_image')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="content" class="block font-semibold">Konten Artikel <span class="text-red-500">*</span></label>
        <textarea id="content" name="content" rows="10" class="w-full mt-1 p-2 border rounded-lg @error('content') border-red-500 @enderror" required>{{ old('content', optional($article)->content) }}</textarea>
        @error('content')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="published_at" class="block font-semibold">Tanggal Publikasi (Opsional)</label>
        <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', optional($article)->published_at ? \Carbon\Carbon::parse(optional($article)->published_at)->format('Y-m-d\TH:i') : '') }}" class="w-full mt-1 p-2 border rounded-lg">
        <p class="text-xs text-gray-500 mt-1">Kosongkan jika ingin disimpan sebagai draft.</p>
        @error('published_at')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

