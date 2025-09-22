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

<div class="space-y-6">
    <div>
        <label for="type" class="block font-semibold text-gray-700">Tipe Kegiatan</label>
        <select name="type" id="type" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="Ibadah" @selected(old('type', optional($event)->type) == 'Ibadah')>Ibadah</option>
            <option value="Acara" @selected(old('type', optional($event)->type) == 'Acara')>Acara Khusus</option>
            <option value="Latihan" @selected(old('type', optional($event)->type) == 'Latihan')>Latihan Rutin</option>
        </select>
    </div>
    <div>
        <label for="title" class="block font-semibold text-gray-700">Judul Kegiatan</label>
        <input type="text" id="title" name="title" value="{{ old('title', optional($event)->title) }}" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="start_time" class="block font-semibold text-gray-700">Waktu Mulai</label>
            <input type="datetime-local" id="start_time" name="start_time" value="{{ old('start_time', optional($event->start_time)->format('Y-m-d\TH:i')) }}" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div>
            <label for="end_time" class="block font-semibold text-gray-700">Waktu Selesai</label>
            <input type="datetime-local" id="end_time" name="end_time" value="{{ old('end_time', optional($event->end_time)->format('Y-m-d\TH:i')) }}" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
    </div>
    <hr>
    <p class="text-sm text-gray-500 -mt-2">Isi bagian di bawah ini jika tipe kegiatan adalah "Ibadah".</p>
    <div>
        <label for="speaker" class="block font-semibold text-gray-700">Pembicara</label>
        <input type="text" id="speaker" name="speaker" value="{{ old('speaker', optional($event)->speaker) }}" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div>
        <label for="division_id" class="block font-semibold text-gray-700">Divisi Ibadah</label>
        <select name="division_id" id="division_id" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Tidak ada</option>
            @foreach($divisions as $division)
                <option value="{{ $division->id }}" @selected(old('division_id', optional($event)->division_id) == $division->id)>{{ $division->name }}</option>
            @endforeach
        </select>
    </div>
    <hr>
    <div>
        <label for="description" class="block font-semibold text-gray-700">Deskripsi</label>
        <textarea name="description" id="description" rows="5" class="w-full mt-1 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', optional($event)->description) }}</textarea>
    </div>
    <div>
        <label for="image" class="block font-semibold text-gray-700">Gambar/Flyer</label>
        <input type="file" name="image" id="image" class="w-full mt-1 p-2 border rounded-lg">
        @if(optional($event)->image)
            <img src="{{ asset('storage/' . $event->image) }}" alt="Gambar saat ini" class="mt-4 h-32 object-cover rounded">
        @endif
    </div>
    <hr>
    <div class="flex items-center space-x-6">
        <div class="flex items-center">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', optional($event)->is_featured)) class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="is_featured" class="ml-2 block text-sm text-gray-900">Sematkan (Pin) di Halaman Utama?</label>
        </div>
        <div class="flex items-center">
            <label for="color" class="mr-2 text-sm text-gray-900">Warna Pin</label>
            <input type="color" id="color" name="color" value="{{ old('color', optional($event)->color ?? '#3B82F6') }}" class="h-8 w-10">
        </div>
    </div>
</div>

