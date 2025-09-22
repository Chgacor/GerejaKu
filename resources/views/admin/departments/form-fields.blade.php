{{-- Error display --}}
<div class="space-y-4">
    <div>
        <label>Nama Departemen</label>
        <input type="text" name="name" value="{{ old('name', $department->name) }}" class="w-full ...">
    </div>
    <div>
        <label>Fungsi & Tujuan</label>
        <textarea name="function" rows="5" class="w-full ...">{{ old('function', $department->function) }}</textarea>
    </div>
    <div>
        <label>Nama Ketua</label>
        <input type="text" name="head_name" value="{{ old('head_name', $department->head_name) }}" class="w-full ...">
    </div>
    <div>
        <label>Pengurus (pisahkan dengan koma)</label>
        <textarea name="committee_members" rows="3" class="w-full ...">{{ old('committee_members', $department->committee_members) }}</textarea>
    </div>
    <div>
        <label>Gambar/Banner</label>
        <input type="file" name="image" class="w-full ...">
        @if($department->image)
            <img src="{{ asset('storage/' . $department->image) }}" class="mt-4 h-32 ...">
        @endif
    </div>
</div>
