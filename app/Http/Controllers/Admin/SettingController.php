<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage facade untuk file handling

class SettingController extends Controller
{
    /**
     * Menampilkan halaman pengaturan dengan data yang sudah ada.
     */
    public function index()
    {
        // Kode ini sudah efisien. Mengambil semua setting dan mengubahnya menjadi
        // array [key => value] untuk kemudahan penggunaan di view.
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Memperbarui data pengaturan.
     */
    public function update(Request $request)
    {
        // Menambahkan aturan validasi untuk field baru.
        // 'nullable' berarti field boleh kosong.
        // 'url' memastikan input adalah URL yang valid.
        $rules = [
            'weekly_verse'      => 'nullable|string',
            'church_history'    => 'nullable|string',
            'church_vision'     => 'nullable|string',
            'church_mission'    => 'nullable|string',
            'about_image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

            // Aturan validasi untuk data kontak & medsos
            'contact_phone'     => 'nullable|string|max:255', // <-- DITAMBAHKAN
            'contact_instagram' => 'nullable|url|max:255',      // <-- DITAMBAHKAN
            'contact_facebook'  => 'nullable|url|max:255',     // <-- DITAMBAHKAN
            'contact_youtube'   => 'nullable|url|max:255',       // <-- DITAMBAHKAN
        ];

        $request->validate($rules);

        // Loop ini SANGAT EFISIEN dan tidak perlu diubah.
        // Ia akan secara otomatis menyimpan semua field baru yang Anda tambahkan di form.
        foreach ($request->except('_token', 'about_image') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key], // Kondisi pencarian
                ['value' => $value ?? ''] // Data yang diupdate/dibuat (menggunakan ?? '' untuk handle nilai null)
            );
        }

        // Penanganan upload file (sudah bagus)
        if ($request->hasFile('about_image')) {
            $oldImage = Setting::where('key', 'about_image')->first();
            if ($oldImage && $oldImage->value && Storage::disk('public')->exists($oldImage->value)) {
                Storage::disk('public')->delete($oldImage->value);
            }

            $path = $request->file('about_image')->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'about_image'],
                ['value' => $path]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
