<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class AdminVehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $vehicleTypes = VehicleType::withCount('vehicles')->latest()->paginate(10);
        return view('admin.vehicle-types.index', compact('vehicleTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.vehicle-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:vehicle_types',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $vehicleType = new VehicleType();
        $vehicleType->name = $request->name;
        
        // Vérifier si la colonne slug existe dans la table vehicle_types
        if (Schema::hasColumn('vehicle_types', 'slug')) {
            $vehicleType->slug = Str::slug($request->name);
        }
        
        // Vérifier si la colonne description existe dans la table vehicle_types
        if (Schema::hasColumn('vehicle_types', 'description')) {
            $vehicleType->description = $request->description;
        }
        
        if ($request->hasFile('icon') && Schema::hasColumn('vehicle_types', 'icon')) {
            $path = $request->file('icon')->store('vehicle-types', 'public');
            $vehicleType->icon = $path;
        }
        
        $vehicleType->save();

        return redirect()->route('admin.vehicle-types.index')
            ->with('success', 'Type de véhicule créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $vehicleType = VehicleType::withCount('vehicles')->findOrFail($id);
        $vehicles = $vehicleType->vehicles()->with(['brand', 'images'])->paginate(8);
        
        return view('admin.vehicle-types.show', compact('vehicleType', 'vehicles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $vehicleType = VehicleType::findOrFail($id);
        return view('admin.vehicle-types.edit', compact('vehicleType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $vehicleType = VehicleType::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:vehicle_types,name,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $vehicleType->name = $request->name;
        
        // Vérifier si la colonne slug existe dans la table vehicle_types
        if (Schema::hasColumn('vehicle_types', 'slug')) {
            $vehicleType->slug = Str::slug($request->name);
        }
        
        // Vérifier si la colonne description existe dans la table vehicle_types
        if (Schema::hasColumn('vehicle_types', 'description')) {
            $vehicleType->description = $request->description;
        }
        
        if ($request->hasFile('icon') && Schema::hasColumn('vehicle_types', 'icon')) {
            // Supprimer l'ancienne icône s'il existe
            if ($vehicleType->icon) {
                \Storage::disk('public')->delete($vehicleType->icon);
            }
            
            $path = $request->file('icon')->store('vehicle-types', 'public');
            $vehicleType->icon = $path;
        }
        
        $vehicleType->save();

        return redirect()->route('admin.vehicle-types.index')
            ->with('success', 'Type de véhicule mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $vehicleType = VehicleType::findOrFail($id);
        
        // Vérifier si le type de véhicule a des véhicules associés
        if ($vehicleType->vehicles()->count() > 0) {
            return redirect()->route('admin.vehicle-types.index')
                ->with('error', 'Impossible de supprimer ce type de véhicule car il est associé à des véhicules');
        }
        
        // Supprimer l'icône s'il existe
        if ($vehicleType->icon && Schema::hasColumn('vehicle_types', 'icon')) {
            \Storage::disk('public')->delete($vehicleType->icon);
        }
        
        $vehicleType->delete();

        return redirect()->route('admin.vehicle-types.index')
            ->with('success', 'Type de véhicule supprimé avec succès');
    }
}
