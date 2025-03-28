<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceRequest;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            $services = Service::with('category')->paginate(10);

            return view('admin.services.index', compact('services'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la récupération des services.');
        }
    }


    public function create()
    {
        try {
            $categories = Category::all();
            return view('admin.services.create', compact('categories'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la préparation du formulaire de création.' . $e->getMessage());
        }
    }
    
    public function store(StoreServiceRequest $request)
    {
        try {

            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $validatedData['image'] = $request->file('image')->store('services', 'public');
            }

            Service::create($validatedData);

            return redirect()->route('admin.services.index')->with('success', 'Service créé avec succès.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création du service.' . $e->getMessage());
        }
    }

    public function edit(Service $service)
    {
        try {
            $categories = Category::all();
            return view('admin.services.edit', compact('service', 'categories'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la préparation du formulaire d\'édition.' . $e->getMessage());
        }
    }


    public function update(StoreServiceRequest $request, Service $service)
    {
        try {
            $service->update($request->validated());
            return redirect()->route('admin.services.index')->with('success', 'Service mis à jour avec succès.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du service.' . $e->getMessage());
        }
    }

    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()->route('admin.services.index')->with('success', 'Service supprimé avec succès.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du service.' . $e->getMessage());
        }
    }
}
