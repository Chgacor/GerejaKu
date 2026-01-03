<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowedSettings = [
            'weekly_verse',
            'church_history',
            'church_vision',
            'church_mission',
            'contact_phone',
            'contact_instagram',
            'contact_facebook',
            'contact_youtube',
        ];

        $rules = [
            'weekly_verse'      => 'nullable|string',
            'church_history'    => 'nullable|string',
            'church_vision'     => 'nullable|string',
            'church_mission'    => 'nullable|string',
            'contact_phone'     => 'nullable|string|max:255',
            'contact_instagram' => 'nullable|url|max:255',
            'contact_facebook'  => 'nullable|url|max:255',
            'contact_youtube'   => 'nullable|url|max:255',
            'about_image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $request->validate($rules);

        // 2. Only update allowed keys
        foreach ($request->only($allowedSettings) as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

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
