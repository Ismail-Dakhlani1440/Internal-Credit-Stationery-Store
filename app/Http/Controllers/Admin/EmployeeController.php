<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role_id', 3)->get();

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();

        return view('admin.employees.create', compact('roles', 'departments'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
            'role_id'       => 'required',
            'department_id' => 'nullable',
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => $request->password, // hash auto via casts()
            'role_id'       => $request->role_id,
            'department_id' => $request->department_id,
        ]);

        return redirect()->route('employees.index')
            ->with('success', 'Employé ajouté avec succès');
    }

    public function edit(User $employee)
    {
        $roles = Role::all();
        $departments = Department::all();

        return view('admin.employees.edit', compact('employee', 'roles', 'departments'));
    }


    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $employee->id,
            'password'      => 'nullable|min:6',
            'role_id'       => 'required',
            'department_id' => 'nullable',
        ]);

        $data = $request->only([
            'name',
            'email',
            'role_id',
            'department_id',
        ]);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $employee->update($data);

        return redirect()->route('employees.index')
            ->with('success', 'Employé modifié');
    }

    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employé supprimé');
    }
}
