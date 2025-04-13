<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\SendEmployeeMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{

    public function search(Request $request)
    {
        $output="";
        $employees = User::where(function($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
        })
        ->whereDoesntHave('roles', function($q) {
            $q->where('name', 'client'); 
        })
        ->get();

        foreach($employees as $employee)
        {

            $photoHtml = '<div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
            <i class="fas fa-user"></i>
            </div>';
    
            if ($employee->photo) {
            $photoPath = asset('storage/' . $employee->photo);
            $photoHtml = '<div class="flex-shrink-0 h-10 w-10">
               <img class="h-10 w-10 rounded-full object-cover" src="'.$photoPath.'" alt="Photo de '.$employee->name.'">
            </div>';
            }

            $roles = implode(', ', $employee->roles->pluck('name')->toArray());

            $output.= '<tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    '.$photoHtml.'
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">' . $employee->name . '</div>
                                        <div class="text-sm text-gray-500">Employé depuis ' . $employee->created_at->format('Y') . '</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">' . $employee->email . '</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">' . ($employee->phone ? ($employee->phone) : 'N/A') . '</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">' . $roles . '</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Actif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="' . route('admin.employees.edit', $employee->id) . '" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="' . route('employee.destroy', $employee->id) . '" method="POST" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer cet employé ?\')" class="inline-block">
                                    ' . csrf_field() . '
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>';
        }

        return response($output);
    }


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
        $services = Service::all(); 
        return view('admin.employees.add-employee', [
            'roles' => $roles,
            'services' => $services
        ]);
    }

    public function ajouter(StoreEmployeeRequest $request)
    {

        $validated = $request->validated();

        try {
            $randomPassword = Str::random(10);
    
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($randomPassword),
            ]);
    
            $role = Role::find($validated['role']);
            $user->roles()->sync([$role->id]);

            if (!empty($validated['services'])) {
                $servicesIds = array_map('intval', $validated['services']);
                $user->services()->sync($servicesIds);
            }

            Mail::to($user->email)->send(new SendEmployeeMail($user->name, $user->email, $randomPassword));

            return redirect()->route('admin.employees.employee-manage')->with('success', 'Utilisateur créé avec succès et mot de passe envoyé par e-mail.');
    
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la création de l\'utilisateur : ' . $e->getMessage())->withInput();
        }
    }

    public function edit(User $employee)
    {
        $roles = Role::all();
        $services = Service::all(); 
        $employeeServices = $employee->services->pluck('id')->toArray();
    
        return view('admin.employees.edit', [
            'employee' => $employee,
            'roles' => $roles,
            'services' => $services,
            'employeeServices' => $employeeServices
        ]);
    }

    public function update(UpdateEmployeeRequest $request, User $employee)
    {
        try {
            $validated = $request->validated();

            $employee->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone']
            ]);

            $employee->roles()->sync([$validated['role']]);
            $employee->services()->sync($validated['services'] ?? []);

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
