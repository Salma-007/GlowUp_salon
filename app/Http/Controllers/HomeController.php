<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $services = Service::with('category')->take(3)->get();
            return view('clients.index', compact('services'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la récupération des réservations.' . $e->getMessage());
        }
    }
}
