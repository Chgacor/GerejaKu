<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $rules = [
            'weekly_verse' => 'nullable|string',
            'church_history' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $request->validate($rules);

        foreach ($request->except('_token', 'about_image') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if ($request->hasFile('about_image')) {
            $oldImage = Setting::where('key', 'about_image')->first();
            if ($oldImage && $oldImage->value && \Storage::exists('public/' . $oldImage->value)) {
                \Storage::delete('public/' . $oldImage->value);
            }

            $path = $request->file('about_image')->store('pages', 'public');
            Setting::updateOrCreate(
                ['key' => 'about_image'],
                ['value' => $path]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
