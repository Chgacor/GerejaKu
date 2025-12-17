@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <ul class="list-disc ml-5"> {{-- Added list style for better visibility --}}
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div>
        <label for="type" class="block font-semibold">Tipe Kegiatan</label>
        <select id="type" name="type" class="w-full mt-1 p-2 border rounded-lg">
            <option value="Ibadah" @selected(old('type', $event->type ?? '') == 'Ibadah')>Ibadah</option>
            <option value="Acara" @selected(old('type', $event->type ?? '') == 'Acara')>Acara Khusus</option>
            <option value="Latihan" @selected(old('type', $event->type ?? '') == 'Latihan')>Latihan Rutin</option>
        </select>
    </div>

    <div>
        <label for="title" class="block font-semibold">Judul Kegiatan</label>
        <input type="text" id="title" name="title" value="{{ old('title', $event->title ?? '') }}" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="start_time" class="block font-semibold">Waktu Mulai</label>
            <input type="datetime-local" id="start_time" name="start_time"
                   value="{{ old('start_time', isset($event->start_time) ? $event->start_time->format('Y-m-d\TH:i') : '') }}"
                   class="w-full mt-1 p-2 border rounded-lg" required>
        </div>
        <div>
            <label for="end_time" class="block font-semibold">Waktu Selesai</label>
            <input type="datetime-local" id="end_time" name="end_time"
                   value="{{ old('end_time', isset($event->end_time) ? $event->end_time->format('Y-m-d\TH:i') : '') }}"
                   class="w-full mt-1 p-2 border rounded-lg" required>
        </div>
    </div>

    <hr class="border-gray-300">
    <p class="text-sm text-gray-500 -mt-2 italic">Isi bagian di bawah ini jika tipe kegiatan adalah "Ibadah".</p>

    <div>
        <label for="speaker" class="block font-semibold">Pembicara</label>
        <input type="text" id="speaker" name="speaker" value="{{ old('speaker', $event->speaker ?? '') }}" class="w-full mt-1 p-2 border rounded-lg">
    </div>

    <div>
        <label for="division_id" class="block font-semibold">Divisi Ibadah</label>
        <select id="division_id" name="division_id" class="w-full mt-1 p-2 border rounded-lg">
            <option value="">Tidak ada</option>
            @foreach($divisions as $division)
                <option value="{{ $division->id }}" @selected(old('division_id', $event->division_id ?? '') == $division->id)>
                    {{ $division->name }}
                </option>
            @endforeach
        </select>
    </div>

    <hr class="border-gray-300">

    <div>
        <label for="description" class="block font-semibold">Deskripsi</label>
        <textarea id="description" name="description" rows="5" class="w-full mt-1 p-2 border rounded-lg">{{ old('description', $event->description ?? '') }}</textarea>
    </div>

    <div>
        <label for="image" class="block font-semibold">Gambar/Flyer Utama</label>
        <input type="file" id="image" name="image" class="w-full mt-1 p-2 border rounded-lg" accept="image/*"> {{-- Added accept attribute --}}
        @if(isset($event) && $event->image)
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-1">Gambar saat ini:</p>
                <img src="{{ asset('storage/' . $event->image) }}" alt="Gambar saat ini" class="h-32 object-cover rounded border border-gray-200">
            </div>
        @endif
    </div>

    <hr class="border-gray-300">

    <div class="flex items-center space-x-6 bg-gray-50 p-4 rounded-lg">
        <div class="flex items-center">
            {{-- Hidden input ensures '0' is sent if checkbox is unchecked --}}
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                   @checked(old('is_featured', $event->is_featured ?? false))
                   class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            <label for="is_featured" class="ml-2 font-medium text-gray-700">Sematkan (Pin) di Halaman Utama?</label>
        </div>

        <div class="flex items-center">
            <label for="color" class="mr-2 font-medium text-gray-700">Warna Pin</label>
            <input type="color" id="color" name="color"
                   value="{{ old('color', $event->color ?? '#3B82F6') }}"
                   class="h-9 w-14 p-1 border border-gray-300 rounded cursor-pointer">
        </div>
    </div>
</div>
