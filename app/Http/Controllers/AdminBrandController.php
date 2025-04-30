<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class AdminBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $brands = Brand::withCount('vehicles')->latest()->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        
        // Vérifier si la colonne slug existe dans la table brands
        if (Schema::hasColumn('brands', 'slug')) {
            $brand->slug = Str::slug($request->name);
        }
        
        // Vérifier si la colonne description existe dans la table brands
        if (Schema::hasColumn('brands', 'description')) {
            $brand->description = $request->description;
        }
        
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('brands', 'public');
            $brand->logo = $path;
        }
        
        $brand->save();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marque créée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $brand = Brand::withCount('vehicles')->findOrFail($id);
        $vehicles = $brand->vehicles()->with(['vehicleType', 'images'])->paginate(8);
        
        return view('admin.brands.show', compact('brand', 'vehicles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $brand = Brand::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand->name = $request->name;
        
        // Vérifier si la colonne slug existe dans la table brands
        if (Schema::hasColumn('brands', 'slug')) {
            $brand->slug = Str::slug($request->name);
        }
        
        // Vérifier si la colonne description existe dans la table brands
        if (Schema::hasColumn('brands', 'description')) {
            $brand->description = $request->description;
        }
        
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($brand->logo) {
                \Storage::disk('public')->delete($brand->logo);
            }
            
            $path = $request->file('logo')->store('brands', 'public');
            $brand->logo = $path;
        }
        
        $brand->save();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marque mise à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $brand = Brand::findOrFail($id);
        
        // Vérifier si la marque a des véhicules associés
        if ($brand->vehicles()->count() > 0) {
            return redirect()->route('admin.brands.index')
                ->with('error', 'Impossible de supprimer cette marque car elle est associée à des véhicules');
        }
        
        // Supprimer le logo s'il existe
        if ($brand->logo) {
            \Storage::disk('public')->delete($brand->logo);
        }
        
        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marque supprimée avec succès');
    }
}
