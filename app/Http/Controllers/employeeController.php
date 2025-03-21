<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendEmployeeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'client'); 
        })->paginate(5); 
        return view('admin.employees.employee-manage', compact('employees'));
    }   

    public function create()
    {
        $roles = Role::all();
        return view('admin.employees.add-employee', ['roles' => $roles]);
    }

    public function ajouter(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required',
            'role' => 'required|exists:roles,id', 
        ]);
    
        try {
            $randomPassword = Str::random(10);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($randomPassword),
            ]);
    
            $role = Role::find($request->role);
            $user->roles()->sync([$role->id]);

            Mail::to($user->email)->send(new SendEmployeeMail($user->name, $user->email, $randomPassword));

            return redirect()->route('employees.index')->with('success', 'Utilisateur créé avec succès et mot de passe envoyé par e-mail.');
    
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la création de l\'utilisateur : ' . $e->getMessage())->withInput();
        }
    }

    public function edit(User $employee)
    {
        $roles = Role::all();

        return view('admin.employees.edit', [
            'employee' => $employee,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $employee)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $employee->id,
                'phone' => 'nullable|string|max:20',
                'role' => 'required|exists:roles,id',
            ]);

            $employee->update($validatedData);

            $employee->roles()->sync([$request->role]);

            return redirect()->route('admin.employees.index')->with('success', 'Employé mis à jour avec succès.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur s\'est produite lors de la mise à jour de l\'employé.']);
        }
    }

    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return back()->with('success', 'Employee deleted successfully.');

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
