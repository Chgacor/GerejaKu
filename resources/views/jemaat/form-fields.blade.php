<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-gray-700">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $jemaat->nama_lengkap ?? '') }}" class="w-full mt-2 p-2 border rounded-lg" required>
    </div>
    <div>
        <label class="block text-gray-700">Kelamin</label>
        <select name="kelamin" class="w-full mt-2 p-2 border rounded-lg" required>
            <option value="Pria" {{ (old('kelamin', $jemaat->kelamin ?? '') == 'Pria') ? 'selected' : '' }}>Pria</option>
            <option value="Wanita" {{ (old('kelamin', $jemaat->kelamin ?? '') == 'Wanita') ? 'selected' : '' }}>Wanita</option>
        </select>
    </div>
    <div>
        <label class="block text-gray-700">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $jemaat->tempat_lahir ?? '') }}" class="w-full mt-2 p-2 border rounded-lg" required>
    </div>
    <div>
        <label class="block text-gray-700">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $jemaat->tanggal_lahir ?? '') }}" class="w-full mt-2 p-2 border rounded-lg" required>
    </div>
    <div class="md:col-span-2">
        <label class="block text-gray-700">Alamat</label>
        <textarea name="alamat" rows="3" class="w-full mt-2 p-2 border rounded-lg" required>{{ old('alamat', $jemaat->alamat ?? '') }}</textarea>
    </div>
    <div class="md:col-span-2">
        <label class="block text-gray-700">No Telepon</label>
        <input type="text" name="no_telepon" value="{{ old('no_telepon', $jemaat->no_telepon ?? '') }}" class="w-full mt-2 p-2 border rounded-lg" required>
    </div>
    <div class="md:col-span-2">
        <label class="block text-gray-700">Foto Profil</label>
        <input type="file" name="foto_profil" class="w-full mt-2 p-2 border rounded-lg">
        @if(isset($jemaat) && $jemaat->foto_profil)
            <img src="{{ asset('storage/' . $jemaat->foto_profil) }}" alt="Foto Profil" class="mt-4 h-32 w-32 object-cover rounded-full">
        @endif
    </div>
</div>
