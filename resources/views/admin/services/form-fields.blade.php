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
        <label for="title" class="block font-semibold">Judul/Tema</label>
        <input type="text" name="title" value="{{ old('title', optional($service)->title) }}" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>

    <div>
        <label for="speaker" class="block font-semibold">Pembicara</label>
        <input type="text" name="speaker" value="{{ old('speaker', optional($service)->speaker) }}" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>

    <div>
        <label for="division_id" class="block font-semibold">Ibadah</label>
        <select name="division_id" id="division-select" class="w-full mt-1 p-2 border rounded-lg" required>
            <option value="">Pilih Ibadah</option>
            @foreach($divisions as $division)
                <option value="{{ $division->id }}" {{ old('division_id', optional($service)->division_id) == $division->id ? 'selected' : '' }}>
                    {{ $division->name }} ({{ $division->schedule_info }})
                </option>
            @endforeach
            <option value="other" {{ old('division_id') == 'other' ? 'selected' : '' }}>Lainnya...</option>
        </select>
    </div>

    <div id="other-division-container" class="hidden">
        <div class="p-4 border-l-4 border-blue-200 bg-blue-50 space-y-4 rounded-r-lg">
            <div>
                <label for="other_division_name" class="block font-semibold">Nama Ibadah Lainnya</label>
                <input type="text" name="other_division_name" value="{{ old('other_division_name') }}" placeholder="Masukkan nama ibadah baru" class="w-full mt-1 p-2 border rounded-lg">
            </div>
            <div>
                <label for="other_division_time" class="block font-semibold">Waktu Ibadah Lainnya</label>
                <input type="time" name="other_division_time" value="{{ old('other_division_time') }}" class="w-full mt-1 p-2 border rounded-lg">
            </div>
        </div>
    </div>

    <div>
        <label for="service_date" class="block font-semibold">Tanggal Ibadah</label>
        <input type="date" name="service_date" value="{{ old('service_date', optional($service->service_time)->format('Y-m-d')) }}" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>

    {{-- KITA BUNGKUS INPUT JAM UTAMA DENGAN DIV BARU --}}
    <div id="main-time-container">
        <label for="service_time_input" class="block font-semibold">Jam Ibadah</label>
        <input type="time" name="service_time_input" id="service-time-input" value="{{ old('service_time_input', optional($service->service_time)->format('H:i')) }}" class="w-full mt-1 p-2 border rounded-lg" required>
    </div>

    <div>
        <label for="image" class="block font-semibold">Gambar/Thumbnail (Opsional)</label>
        <input type="file" name="image" class="w-full mt-1 p-2 border rounded-lg">
        @if(optional($service)->image)
            <img src="{{ asset('storage/' . $service->image) }}" class="mt-4 h-32 object-cover rounded">
        @endif
    </div>

    <div>
        <label for="description" class="block font-semibold">Deskripsi Singkat</label>
        <textarea name="description" rows="4" class="w-full mt-1 p-2 border rounded-lg" placeholder="Jelaskan sedikit tentang ibadah ini...">{{ old('description', optional($service)->description) }}</textarea>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const divisionSelect = document.getElementById('division-select');
        const otherDivisionContainer = document.getElementById('other-division-container');
        const serviceTimeInput = document.getElementById('service-time-input');
        // KITA AMBIL DIV PEMBUNGKUS INPUT JAM UTAMA
        const mainTimeContainer = document.getElementById('main-time-container');

        const divisionsData = {!! $divisions->mapWithKeys(fn($div) => [$div->id => $div->default_time])->toJson() !!};

        function handleDivisionChange() {
            const selectedValue = divisionSelect.value;

            if (selectedValue === 'other') {
                otherDivisionContainer.classList.remove('hidden');
                mainTimeContainer.classList.add('hidden');
            } else {
                otherDivisionContainer.classList.add('hidden');
                mainTimeContainer.classList.remove('hidden');
            }

            if (divisionsData[selectedValue]) {
                serviceTimeInput.value = divisionsData[selectedValue].substring(0, 5);
            }
        }

        divisionSelect.addEventListener('change', handleDivisionChange);

        handleDivisionChange();
    });
</script>

