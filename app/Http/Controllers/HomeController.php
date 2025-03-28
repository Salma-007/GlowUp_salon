<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $services = Service::with('category')->take(3)->get();
            $employees = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'client'); 
            })->get();
            
            return view('clients.index', compact('services', 'employees'));
            return view('clients.index', compact('services'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la récupération des réservations.' . $e->getMessage());
        }
    }

    public function services()
    {
        $services = Service::paginate(6);

        return view('clients.services', compact('services'));
    }
}
