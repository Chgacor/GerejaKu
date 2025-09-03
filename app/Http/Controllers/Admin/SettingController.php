<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil semua settings dan ubah jadi array agar mudah digunakan di view
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validasi umum untuk semua input teks
        $rules = [
            'weekly_verse' => 'nullable|string',
            'church_history' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Aturan validasi untuk gambar
        ];

        $request->validate($rules);

        // Loop melalui semua input teks dan simpan
        foreach ($request->except('_token', 'about_image') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Tangani unggahan gambar secara terpisah
        if ($request->hasFile('about_image')) {
            // Hapus gambar lama jika ada
            $oldImage = Setting::where('key', 'about_image')->first();
            if ($oldImage && $oldImage->value && \Storage::exists('public/' . $oldImage->value)) {
                \Storage::delete('public/' . $oldImage->value);
            }

            $path = $request->file('about_image')->store('pages', 'public'); // Simpan di folder 'pages'
            Setting::updateOrCreate(
                ['key' => 'about_image'],
                ['value' => $path]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
