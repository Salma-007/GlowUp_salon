<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function search(Request $request)
    {
        $output = "";
        $clients = User::where(function($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
        })
        ->whereHas('roles', function($q) {
            $q->where('name', 'client');
        })
        ->get();
    
        foreach($clients as $client)
        {
            $photoHtml = '<div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                             <i class="fas fa-user"></i>
                          </div>';

            if ($client->photo) {
                $photoPath = asset('storage/' . $client->photo);
                $photoHtml = '<div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full object-cover" src="'.$photoPath.'" alt="Photo de '.$client->name.'">
                             </div>';
            }
    
            $output.= '<tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    '.$photoHtml.'
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">' . $client->name . '</div>
                                        <div class="text-sm text-gray-500">Client depuis ' . $client->created_at->format('Y') . '</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">' . $client->email . '</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">' . ($client->phone ? ($client->phone) : 'N/A') . '</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Actif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="' . route('admin.clients.edit', $client->id) . '" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="' . route('client.destroy', $client->id) . '" method="POST" onsubmit="return confirm(\'Êtes-vous sûr de vouloir supprimer ce client ?\')" class="inline-block">
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
