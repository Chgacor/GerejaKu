@if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif
<div class="space-y-6">
    <div>
        <label class="block font-semibold">Tipe Kegiatan</label>
        <select name="type" class="w-full mt-1 p-2 border rounded-lg">
            <option value="Ibadah" @selected(old('type', optional($event)->type) == 'Ibadah')>Ibadah</option>
            <option value="Acara" @selected(old('type', optional($event)->type) == 'Acara')>Acara Khusus</option>
            <option value="Latihan" @selected(old('type', optional($event)->type) == 'Latihan')>Latihan Rutin</option>
        </select>
    </div>
    <div>
        <label class="block font-semibold">Judul Kegiatan</label>
        <input type="text" name="title" value="{{ old('title', optional($event)->title) }}" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block font-semibold">Waktu Mulai</label>
            <input type="datetime-local" name="start_time" value="{{ old('start_time', optional($event->start_time)->format('Y-m-d\TH:i')) }}" class="w-full mt-1 p-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block font-semibold">Waktu Selesai</label>
            <input type="datetime-local" name="end_time" value="{{ old('end_time', optional($event->end_time)->format('Y-m-d\TH:i')) }}" class="w-full mt-1 p-2 border rounded-lg" required>
        </div>
    </div>
    <hr>
    <p class="text-sm text-gray-500 -mt-2">Isi bagian di bawah ini jika tipe kegiatan adalah "Ibadah".</p>
    <div>
        <label class="block font-semibold">Pembicara</label>
        <input type="text" name="speaker" value="{{ old('speaker', optional($event)->speaker) }}" class="w-full mt-1 p-2 border rounded-lg">
    </div>
    <div>
        <label class="block font-semibold">Divisi Ibadah</label>
        <select name="division_id" class="w-full mt-1 p-2 border rounded-lg">
            <option value="">Tidak ada</option>
            @foreach($divisions as $division)
                <option value="{{ $division->id }}" @selected(old('division_id', optional($event)->division_id) == $division->id)>{{ $division->name }}</option>
            @endforeach
        </select>
    </div>
    <hr>
    <div>
        <label class="block font-semibold">Deskripsi</label>
        <textarea name="description" rows="5" class="w-full mt-1 p-2 border rounded-lg">{{ old('description', optional($event)->description) }}</textarea>
    </div>
    <div>
        <label class="block font-semibold">Gambar/Flyer Utama</label>
        <input type="file" name="image" class="w-full mt-1 p-2 border rounded-lg">
        @if(optional($event)->image)
            <img src="{{ asset('storage/' . $event->image) }}" alt="Gambar saat ini" class="mt-4 h-32 object-cover rounded">
        @endif
    </div>
    <hr>
    <div class="flex items-center space-x-6">
        <div class="flex items-center">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', optional($event)->is_featured)) class="h-4 w-4 rounded border-gray-300">
            <label for="is_featured" class="ml-2">Sematkan (Pin) di Halaman Utama?</label>
        </div>
        <div class="flex items-center">
            <label for="color" class="mr-2">Warna Pin</label>
            <input type="color" id="color" name="color" value="{{ old('color', optional($event)->color ?? '#3B82F6') }}" class="h-8 w-10">
        </div>
    </div>
</div>
