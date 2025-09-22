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
        <label for="name" class="block text-gray-700 font-semibold">Nama Lengkap</label>
        <input type="text" id="name" name="name" value="{{ old('name', optional($pastor)->name) }}" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <div>
        <label for="position" class="block text-gray-700 font-semibold">Jabatan</label>
        <input type="text" id="position" name="position" value="{{ old('position', optional($pastor)->position) }}" placeholder="Contoh: Gembala Sidang" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <div>
        <label for="photo" class="block text-gray-700 font-semibold">Foto</label>
        <input type="file" id="photo" name="photo" class="w-full mt-1 p-2 border rounded-lg">
        @if(isset($pastor) && $pastor->photo)
            <img src="{{ asset('storage/' . $pastor->photo) }}" alt="Foto saat ini" class="mt-4 h-32 w-32 object-cover rounded-full">
        @endif
    </div>

    <div>
        <label for="bio" class="block text-gray-700 font-semibold">Biografi Singkat</label>
        <textarea id="bio" name="bio" rows="5" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ceritakan sedikit tentang hamba Tuhan ini...">{{ old('bio', optional($pastor)->bio) }}</textarea>
    </div>
</div>
