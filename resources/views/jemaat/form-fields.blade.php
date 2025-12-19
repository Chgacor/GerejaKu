<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Nama Lengkap --}}
    <div>
        <label for="full_name" class="block text-gray-700 font-medium">Nama Lengkap</label>
        <input type="text"
               id="full_name"
               name="full_name"
               value="{{ old('full_name', $jemaat->full_name ?? '') }}"
               class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('full_name') border-red-500 @enderror"
               required>
        @error('full_name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Jenis Kelamin --}}
    <div>
        <label for="gender" class="block text-gray-700 font-medium">Jenis Kelamin</label>
        <select id="gender" name="gender" class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            <option value="">Pilih Jenis Kelamin</option>
            {{-- Sesuaikan value dengan database: Laki-laki / Perempuan --}}
            <option value="Laki-laki" {{ (old('gender', $jemaat->gender ?? '') == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ (old('gender', $jemaat->gender ?? '') == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('gender')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tempat Lahir --}}
    <div>
        <label for="birth_place" class="block text-gray-700 font-medium">Tempat Lahir</label>
        <input type="text"
               id="birth_place"
               name="birth_place"
               value="{{ old('birth_place', $jemaat->birth_place ?? '') }}"
               class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
               required>
        @error('birth_place')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tanggal Lahir --}}
    <div>
        <label for="birth_date" class="block text-gray-700 font-medium">Tanggal Lahir</label>
        <input type="date"
               id="birth_date"
               name="birth_date"
               value="{{ old('birth_date', $jemaat->birth_date ?? '') }}"
               class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
               required>
        @error('birth_date')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Alamat (Full Width) --}}
    <div class="md:col-span-2">
        <label for="address" class="block text-gray-700 font-medium">Alamat</label>
        <textarea id="address"
                  name="address"
                  rows="3"
                  class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  required>{{ old('address', $jemaat->address ?? '') }}</textarea>
        @error('address')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- No Telepon (Full Width) --}}
    <div class="md:col-span-2">
        <label for="phone_number" class="block text-gray-700 font-medium">No Telepon</label>
        <input type="text"
               id="phone_number"
               name="phone_number"
               value="{{ old('phone_number', $jemaat->phone_number ?? '') }}"
               class="w-full mt-2 p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
               required>
        @error('phone_number')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Foto Profil (Full Width) --}}
    <div class="md:col-span-2">
        <label for="profile_picture" class="block text-gray-700 font-medium">Foto Profil</label>

        {{-- Input File --}}
        <input type="file"
               id="profile_picture"
               name="profile_picture"
               class="w-full mt-2 p-2 border border-gray-300 rounded-lg bg-white text-sm text-gray-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-full file:border-0
                      file:text-sm file:font-semibold
                      file:bg-indigo-50 file:text-indigo-700
                      hover:file:bg-indigo-100">

        <p class="text-xs text-gray-500 mt-1">Format: jpg, jpeg, png. Max: 2MB.</p>

        {{-- Preview Gambar Lama --}}
        @if(isset($jemaat) && $jemaat->profile_picture)
            <div class="mt-4">
                <p class="text-sm text-gray-500 mb-2">Foto Saat Ini:</p>
                <img src="{{ asset('storage/' . $jemaat->profile_picture) }}"
                     alt="Foto Profil"
                     class="h-32 w-32 object-cover rounded-lg border border-gray-300 shadow-sm">
            </div>
        @endif

        @error('profile_picture')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>
