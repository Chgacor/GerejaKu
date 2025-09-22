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
        <label for="title" class="block font-semibold">Judul</label>
        <input type="text" name="title" value="{{ old('title', optional($slide)->title) }}" class="w-full mt-1 p-2 border rounded-lg">
    </div>
    <div>
        <label for="subtitle" class="block font-semibold">Subjudul (Opsional)</label>
        <input type="text" name="subtitle" value="{{ old('subtitle', optional($slide)->subtitle) }}" class="w-full mt-1 p-2 border rounded-lg">
    </div>
    <div>
        <label for="image" class="block font-semibold">Gambar</label>
        <input type="file" name="image" class="w-full mt-1 p-2 border rounded-lg">
        @if(isset($slide) && $slide->image)
            <img src="{{ asset('storage/' . $slide->image) }}" class="mt-4 h-32 object-cover rounded">
        @endif
    </div>
    <div>
        <label for="link_url" class="block font-semibold">Link URL (Opsional)</label>
        <input type="url" name="link_url" value="{{ old('link_url', optional($slide)->link_url) }}" class="w-full mt-1 p-2 border rounded-lg">
    </div>
    <div>
        <label for="order" class="block font-semibold">Urutan</label>
        <input type="number" name="order" value="{{ old('order', optional($slide)->order ?? 0) }}" class="w-full mt-1 p-2 border rounded-lg">
    </div>
    <div class="flex items-center">
        <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', optional($slide)->is_active ?? true))>
        <label for="is_active" class="ml-2">Aktifkan slide ini</label>
    </div>
</div>
