<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
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

    public function services(Request $request)
    {
        $query = Service::query();
        $employees = User::whereNotIn('role_id', [2, 4])->get();

        // Filtres
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        $services = $query->paginate(6);
        $categories = Category::all();
        
        return view('clients.services', compact('services', 'categories','employees'));
    }
}
