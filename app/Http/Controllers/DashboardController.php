<?php

namespace App\Http\Controllers;

class DashboardController
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id == 1) {
            return redirect()->route('employees.index');
        }

        if ($user->role_id == 2) {
            return view('dashboard.manager');
        }

        if ($user->role_id == 3) {
            return view('dashboard.employee');
        }

        abort(403);
    }
}
