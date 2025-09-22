<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    use App\Models\Department;

    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }
}
