<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->name, 
        ]);
    
        return redirect()->route('admin.categories.index');
    }


    public function update(Request $request, Category $category)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category->update(['name' => $request->name]);
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');

        } catch (\Throwable $th) {
            return redirect()->route('admin.categories.index')->with('error', 'Une erreur s\'est produite lors de la mise à jour de la catégorie.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
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
