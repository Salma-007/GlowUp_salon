<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Service::with('category');
            
            if ($request->has('search')) {
                $query->where('name', 'like', '%'.$request->search.'%');
            }

            if ($request->has('category')) {
                $query->where('category_id', $request->category);
            }
            
            $services = $query->paginate(5);
            $categories = Category::all(); 
    
            return view('admin.services.index', compact('services', 'categories'));
    
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


    public function update(UpdateServiceRequest $request, Service $service)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }

                $validatedData['image'] = $request->file('image')->store('services', 'public');
            }
    
            $service->update($validatedData);


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
