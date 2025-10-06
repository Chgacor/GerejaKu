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
    {{-- Input untuk Nama Lengkap --}}
    <div>
        <label for="name" class="block font-semibold">Nama Lengkap <span class="text-red-500">*</span></label>
        <input type="text" id="name" name="name" value="{{ old('name', optional($pastor)->name) }}" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>

    {{-- Input untuk Kelompok Pelayanan --}}
    <div>
        <label for="kelompok" class="block font-semibold">Kelompok Pelayanan <span class="text-red-500">*</span></label>
        <input type="text" id="kelompok" name="kelompok" value="{{ old('kelompok', optional($pastor)->kelompok) }}" placeholder="Contoh: Gembala Jemaat, Komisi Misi" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>

    {{-- Dropdown untuk Link Komisi --}}
    <div>
        <label for="commission_id" class="block font-semibold">Tautkan ke Halaman Detail Komisi (Opsional)</label>
        <select id="commission_id" name="commission_id" class="w-full mt-1 p-2 border rounded-lg bg-white">
            <option value="">-- Tidak ditautkan --</option>
            @foreach($commissions as $commission)
                <option value="{{ $commission->id }}" @selected(old('commission_id', optional($pastor)->commission_id) == $commission->id)>
                    {{ $commission->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Input untuk Jabatan --}}
    <div>
        <label for="position" class="block font-semibold">Jabatan <span class="text-red-500">*</span></label>
        <input type="text" id="position" name="position" value="{{ old('position', optional($pastor)->position) }}" placeholder="Contoh: Ketua, Sekretaris, Anggota" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>

    {{-- Input untuk Foto --}}
    <div>
        <label for="photo" class="block font-semibold">Foto</label>
        <input type="file" id="photo" name="photo" class="w-full mt-1 p-2 border rounded-lg">
        @if(isset($pastor) && $pastor->photo)
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-2">Foto saat ini:</p>
                {{-- INI BAGIAN YANG DIPERBAIKI DARI ERROR --}}
                <img src="{{ asset('storage/' . $pastor->photo) }}" alt="Foto saat ini" class="h-32 w-32 object-cover rounded-full shadow-md">
            </div>
        @endif
    </div>

    {{-- Input untuk Biografi Singkat --}}
    <div>
        <label for="bio" class="block font-semibold">Biografi Singkat</label>
        <textarea id="bio" name="bio" rows="5" class="w-full mt-1 p-2 border rounded-lg" placeholder="Ceritakan sedikit tentang pelayan ini (lulusan, keluarga, dll)...">{{ old('bio', optional($pastor)->bio) }}</textarea>
    </div>
</div>
