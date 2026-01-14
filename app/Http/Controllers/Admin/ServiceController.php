<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Service::with('division'); // Eager load division biar query ringan

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('speaker', 'like', "%{$search}%")
                    ->orWhereHas('division', function($subQ) use ($search) {
                        $subQ->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $services = $query->latest('service_time')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('admin.services.create', [
            'service' => new Service(),
            'divisions' => $divisions
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'speaker' => 'required|string|max:255',
            'division_id' => 'required|string',
            'other_division_name' => 'required_if:division_id,other|nullable|string|max:255',
            'other_division_time' => 'required_if:division_id,other|nullable|date_format:H:i',
            'service_date' => 'required|date',
            'service_time_input' => 'required|date_format:H:i',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->input('division_id') === 'other') {
            $newDivision = Division::create([
                'name' => $request->input('other_division_name'),
                'default_time' => $request->input('other_division_time'),
                'schedule_info' => 'Jadwal kustom'
            ]);
            $validatedData['division_id'] = $newDivision->id;
        }

        $validatedData['service_time'] = $request->input('service_date') . ' ' . $request->input('service_time_input');

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validatedData);
        return redirect()->route('admin.services.index')->with('success', 'Jadwal ibadah berhasil dibuat.');
    }

    public function edit(Service $service)
    {
        $divisions = Division::all();
        return view('admin.services.edit', compact('service', 'divisions'));
    }

    public function update(Request $request, Service $service)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'speaker' => 'required|string|max:255',
            'division_id' => 'required|string',
            'other_division_name' => 'required_if:division_id,other|nullable|string|max:255',
            'other_division_time' => 'required_if:division_id,other|nullable|date_format:H:i',
            'service_date' => 'required|date',
            'service_time_input' => 'required|date_format:H:i',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->input('division_id') === 'other') {
            $newDivision = Division::create([
                'name' => $request->input('other_division_name'),
                'default_time' => $request->input('other_division_time'),
                'schedule_info' => 'Jadwal kustom'
            ]);
            $validatedData['division_id'] = $newDivision->id;
        }

        $validatedData['service_time'] = $request->input('service_date') . ' ' . $request->input('service_time_input');

        if ($request->hasFile('image')) {
            if ($service->image && Storage::exists('public/' . $service->image)) {
                Storage::delete('public/' . $service->image);
            }
            $validatedData['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validatedData);
        return redirect()->route('admin.services.index')->with('success', 'Jadwal ibadah berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->image && Storage::exists('public/' . $service->image)) {
            Storage::delete('public/' . $service->image);
        }
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'Jadwal ibadah berhasil dihapus.');
    }
}
