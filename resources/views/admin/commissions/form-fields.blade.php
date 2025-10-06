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
    <div>
        <label for="name" class="block font-semibold">Nama Komisi <span class="text-red-500">*</span></label>
        <input type="text" id="name" name="name" value="{{ old('name', optional($commission)->name) }}" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>
    <div>
        <label for="head_of_commission" class="block font-semibold">Nama Ketua Komisi</label>
        <input type="text" id="head_of_commission" name="head_of_commission" value="{{ old('head_of_commission', optional($commission)->head_of_commission) }}" class="w-full mt-1 p-2 border rounded-lg">
    </div>
    <div>
        <label for="head_photo" class="block font-semibold">Foto Ketua</label>
        <input type="file" id="head_photo" name="head_photo" class="w-full mt-1 p-2 border rounded-lg">
        @if(isset($commission) && $commission->head_photo)
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-2">Foto saat ini:</p>
                <img src="{{ asset('storage/' . $commission->head_photo) }}" alt="Foto Ketua" class="h-32 w-32 object-cover rounded-full shadow-md">
            </div>
        @endif
    </div>
    <div>
        <label for="purpose" class="block font-semibold">Tujuan & Visi Misi</label>
        <textarea id="purpose" name="purpose" rows="5" class="w-full mt-1 p-2 border rounded-lg">{{ old('purpose', optional($commission)->purpose) }}</textarea>
    </div>
    <div>
        <label for="management_structure" class="block font-semibold">Struktur Keanggotaan</label>
        <textarea id="management_structure" name="management_structure" rows="8" class="w-full mt-1 p-2 border rounded-lg" placeholder="Contoh:&#10;Wakil Ketua: Budi&#10;Sekretaris: Citra&#10;Bendahara: Dedi">{{ old('management_structure', optional($commission)->management_structure) }}</textarea>
    </div>
</div>
