<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Planning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanningController extends Controller
{
    public function showPlanning($employeeId)
    {
        $employee = User::findOrFail($employeeId);
        
        $plannings = Planning::where('employee_id', $employeeId)->get();

        return view('plannings.show', compact('employee', 'plannings'));
    }

    public function show()
    {
        $employee = Auth::user();

        $plannings = Planning::where('employee_id', $employee->id)->get();

        return view('employees.planning.show', compact('employee', 'plannings'));
    }
}
