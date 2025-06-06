<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::withCount('services') 
        ->orderBy('name') 
        ->paginate(3); 

        $totalCategories = $categories->total();

        return view('admin.categories.index', compact('categories', 'totalCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.unique' => 'Cette catégorie existe déjà.',
        ]);
    
        Category::create([
            'name' => $request->name, 
        ]);
    
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès.');
    }
    
    public function update(Request $request, Category $category)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            ], [
                'name.unique' => 'Cette catégorie existe déjà.',
            ]);
    
            $category->update(['name' => $request->name]);
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    
        } catch (\Throwable $th) {
            return redirect()->route('admin.categories.index')->with('error', 'Une erreur s\'est produite lors de la mise à jour de la catégorie.');
        }
    }


    public function destroy(Category $category)
    {
        try{
            $category->delete();
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès.');
        }
        catch (\Throwable $th) {
            return redirect()->route('admin.categories.index')->with('error', 'Une erreur s\'est produite lors de la suppression de la catégorie.');
        }
        
    }
}
