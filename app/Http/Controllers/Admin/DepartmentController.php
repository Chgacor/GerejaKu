<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::latest()->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create', ['department' => new Department()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'function' => 'required|string',
            'head_name' => 'required|string|max:255',
            'committee_members' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('departments', 'public');
        }

        Department::create($data);
        return redirect()->route('admin.departments.index')->with('success', 'Departemen berhasil dibuat.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'function' => 'required|string',
            'head_name' => 'required|string|max:255',
            'committee_members' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($department->image && Storage::exists('public/' . $department->image)) {
                Storage::delete('public/' . $department->image);
            }
            $data['image'] = $request->file('image')->store('departments', 'public');
        }

        $department->update($data);
        return redirect()->route('admin.departments.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        if ($department->image && Storage::exists('public/' . $department->image)) {
            Storage::delete('public/' . $department->image);
        }
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
