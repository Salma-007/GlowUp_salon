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
}
