<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(4);  
        $permissions = Permission::all();
        return view('admin.roles_permissions.index', compact('roles', 'permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);
    
        $role = Role::create([
            'name' => $request->name,
        ]);
    
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }
    
        return back()->with('success', 'Rôle créé avec succès !');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);
    
        $permission = Permission::create([
            'name' => $request->name,
        ]);
    
        return redirect()->route('admin.roles_permissions.index')->with('success', 'La permission a été créée avec succès.');
    }
    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return back()->with('success', 'Rôle supprimé avec succès.');
    }

    public function destroyPermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return back()->with('success', 'Permission supprimée avec succès.');
    }

    public function editRole(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
    
        return view('admin.roles_permissions.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }
    
        return redirect()->route('admin.roles_permissions.index')->with('success', 'Rôle mis à jour avec succès !');
    }
}
