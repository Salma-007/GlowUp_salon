<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::whereHas('roles', function ($query) {
            $query->where('name', 'client'); 
        })->paginate(5);
    
        return view('admin.clients.clients-manage', compact('clients'));
    }

    
    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->delete();
            return back()->with('success', 'client deleted successfully.');

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function edit(User $client)
    {

        return view('admin.clients.edit', [
            'client' => $client,
        ]);
    }

    public function update(Request $request, User $client)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $client->id,
                'phone' => 'nullable|string|max:20',
            ]);

            $client->update($validatedData);

            return redirect()->route('admin.clients.index')->with('success', 'Employé mis à jour avec succès.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur s\'est produite lors de la mise à jour de l\'employé.']);
        }
    }
}
