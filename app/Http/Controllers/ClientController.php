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
}
