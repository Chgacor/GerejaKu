@extends('layouts.admin')

@section('content')
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Website</h1>

        @if (session('success'))
            <div class="bg-green-100 border-green-400 text-green-700 border-l-4 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="weekly_verse" class="block text-gray-700 font-semibold">Ayat Alkitab Mingguan</label>
                    <textarea id="weekly_verse" name="weekly_verse" rows="3" class="w-full mt-1 p-2 border rounded-lg">{{ $settings['weekly_verse'] ?? '' }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Ayat ini akan muncul di bagian footer website.</p>
                </div>

                <hr class="my-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Kontak & Media Sosial</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="contact_phone" class="block text-gray-700 font-semibold">Nomor Telepon Gereja</label>
                            <input type="text" id="contact_phone" name="contact_phone" class="w-full mt-1 p-2 border rounded-lg" value="{{ $settings['contact_phone'] ?? '' }}" placeholder="+62 234-5678-910">
                        </div>
                        <div>
                            <label for="contact_instagram" class="block text-gray-700 font-semibold">URL Instagram</label>
                            <input type="text" id="contact_instagram" name="contact_instagram" class="w-full mt-1 p-2 border rounded-lg" value="{{ $settings['contact_instagram'] ?? '' }}" placeholder="https://www.instagram.com/gerejaku.id">
                            <p class="text-sm text-gray-500 mt-1">Masukkan URL lengkap.</p>
                        </div>
                        <div>
                            <label for="contact_facebook" class="block text-gray-700 font-semibold">URL Facebook</label>
                            <input type="text" id="contact_facebook" name="contact_facebook" class="w-full mt-1 p-2 border rounded-lg" value="{{ $settings['contact_facebook'] ?? '' }}" placeholder="https://www.facebook.com/gerejaku.id">
                            <p class="text-sm text-gray-500 mt-1">Masukkan URL lengkap.</p>
                        </div>
                        <div>
                            <label for="contact_youtube" class="block text-gray-700 font-semibold">URL YouTube</label>
                            <input type="text" id="contact_youtube" name="contact_youtube" class="w-full mt-1 p-2 border rounded-lg" value="{{ $settings['contact_youtube'] ?? '' }}" placeholder="https://www.youtube.com/@gerejaku.id">
                            <p class="text-sm text-gray-500 mt-1">Masukkan URL lengkap.</p>
                        </div>
                    </div>
                </div>
                <hr class="my-6">

                <div>
                    <label for="about_image" class="block text-gray-700 font-semibold">Gambar Halaman "Tentang Kami"</label>
                    <input type="file" id="about_image" name="about_image" class="w-full mt-1 p-2 border rounded-lg">
                    @if(isset($settings['about_image']) && $settings['about_image'])
                        <img src="{{ asset('storage/' . $settings['about_image']) }}" alt="Gambar saat ini" class="mt-4 h-32 object-cover rounded-md">
                    @endif
                    <p class="text-sm text-gray-500 mt-1">Gambar ini akan muncul di bagian atas halaman "Tentang Kami".</p>
                </div>
                <div>
                    <label for="church_vision" class="block text-gray-700 font-semibold">Visi Gereja</label>
                    <textarea id="church_vision" name="church_vision" rows="5" class="w-full mt-1 p-2 border rounded-lg">{{ $settings['church_vision'] ?? '' }}</textarea>
                </div>
                <div>
                    <label for="church_mission" class="block text-gray-700 font-semibold">Misi Gereja</label>
                    <textarea id="church_mission" name="church_mission" rows="5" class="w-full mt-1 p-2 border rounded-lg">{{ $settings['church_mission'] ?? '' }}</textarea>
                </div>
                <div>
                    <label for="church_history" class="block text-gray-700 font-semibold">Sejarah Gereja</label>
                    <textarea id="church_history" name="church_history" rows="15" class="w-full mt-1 p-2 border rounded-lg">{{ $settings['church_history'] ?? '' }}</textarea>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
@endsection
